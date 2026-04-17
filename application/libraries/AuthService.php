<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * AuthService Library
 * 
 * Handles JWT token generation/validation, OTP management,
 * refresh tokens, and API key validation for the REST API.
 * Uses HMAC-SHA256 for JWT (no external dependencies).
 */
class AuthService {

    private $CI;
    private $config;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->config->load('api_config', TRUE);
        $this->config = $this->CI->config->item('api_config');
    }

    // ========================================================================
    // API KEY VALIDATION
    // ========================================================================

    /**
     * Validate the API key from request headers.
     * Returns the api_key row or FALSE.
     */
    public function validate_api_key() {
        $header_name = $this->config['api_key_header'] ?? 'X-API-KEY';
        
        // Try header first, then fallback to query param
        $api_key = $this->CI->input->get_request_header($header_name, TRUE);
        if (!$api_key) {
            $api_key = $this->CI->input->get('api_key');
        }

        if (!$api_key) return FALSE;

        $row = $this->CI->db->get_where('api_keys', [
            'api_key'   => $api_key,
            'is_active'  => 1
        ])->row();

        if (!$row) return FALSE;

        // Check IP whitelist if configured
        if (!empty($row->allowed_ips)) {
            $allowed = array_map('trim', explode(',', $row->allowed_ips));
            $client_ip = $this->CI->input->ip_address();
            if (!in_array($client_ip, $allowed) && !in_array('*', $allowed)) {
                return FALSE;
            }
        }

        return $row;
    }

    // ========================================================================
    // JWT TOKEN MANAGEMENT
    // ========================================================================

    /**
     * Generate a JWT access token for a parent.
     */
    public function generate_access_token($parent_id, $parent_data = []) {
        $now = time();
        $ttl = $this->config['access_token_ttl'] ?? 3600;

        $payload = [
            'iss'       => 'smart_school_api',
            'sub'       => $parent_id,
            'iat'       => $now,
            'exp'       => $now + $ttl,
            'type'      => 'access',
            'name'      => $parent_data['name'] ?? '',
            'phone'     => $parent_data['phone'] ?? ''
        ];

        return $this->_jwt_encode($payload);
    }

    /**
     * Generate a refresh token and store it in DB.
     */
    public function generate_refresh_token($parent_id) {
        $token = bin2hex(random_bytes(64)); // 128-char secure token
        $ttl   = $this->config['refresh_token_ttl'] ?? 2592000;

        $this->CI->db->insert('refresh_tokens', [
            'parent_id'  => $parent_id,
            'token'      => hash('sha256', $token), // Store hashed
            'expires_at' => date('Y-m-d H:i:s', time() + $ttl),
            'is_revoked' => 0
        ]);

        return $token; // Return unhashed to client
    }

    /**
     * Validate JWT access token from Authorization header.
     * Returns the decoded payload or FALSE.
     */
    public function validate_access_token() {
        $header = $this->CI->input->get_request_header('Authorization', TRUE);
        if (!$header) return FALSE;

        // Extract "Bearer TOKEN"
        if (preg_match('/Bearer\s+(.+)$/i', $header, $matches)) {
            $token = $matches[1];
        } else {
            return FALSE;
        }

        $payload = $this->_jwt_decode($token);
        if (!$payload) return FALSE;

        // Check token type
        if (($payload['type'] ?? '') !== 'access') return FALSE;

        // Check expiration
        if (($payload['exp'] ?? 0) < time()) return FALSE;

        return $payload;
    }

    /**
     * Validate a refresh token and return a new access token.
     * Returns ['access_token' => '...', 'parent_id' => ...] or FALSE.
     */
    public function refresh_access_token($refresh_token) {
        $hashed = hash('sha256', $refresh_token);

        $row = $this->CI->db
            ->where('token', $hashed)
            ->where('is_revoked', 0)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->get('refresh_tokens')
            ->row();

        if (!$row) return FALSE;

        // Get parent data
        $parent = $this->CI->db->get_where('parent', ['parent_id' => $row->parent_id])->row();
        if (!$parent) return FALSE;

        // Generate new access token
        $access_token = $this->generate_access_token($row->parent_id, [
            'name'  => $parent->name,
            'phone' => $parent->phone
        ]);

        return [
            'access_token' => $access_token,
            'parent_id'    => $row->parent_id
        ];
    }

    /**
     * Revoke all refresh tokens for a parent (logout).
     */
    public function revoke_refresh_tokens($parent_id) {
        $this->CI->db->where('parent_id', $parent_id)->update('refresh_tokens', ['is_revoked' => 1]);
    }

    /**
     * Revoke a specific refresh token.
     */
    public function revoke_token($refresh_token) {
        $hashed = hash('sha256', $refresh_token);
        $this->CI->db->where('token', $hashed)->update('refresh_tokens', ['is_revoked' => 1]);
    }

    // ========================================================================
    // OTP MANAGEMENT
    // ========================================================================

    /**
     * Send OTP to a parent's phone number.
     * Returns TRUE on success, FALSE if parent not found.
     */
    public function send_otp($phone) {
        // Find parent by phone
        $parent = $this->CI->db
            ->like('phone', $phone)
            ->get('parent')
            ->row();

        if (!$parent) return FALSE;

        // Generate OTP
        $otp_length = $this->config['otp_length'] ?? 6;
        $otp = str_pad(random_int(0, pow(10, $otp_length) - 1), $otp_length, '0', STR_PAD_LEFT);
        $expiry = date('Y-m-d H:i:s', time() + ($this->config['otp_expiry'] ?? 300));

        // Store OTP (reuse parent table — add otp columns if needed, or use a temp approach)
        // For simplicity, we'll store in session or a simple cache approach
        // Using CI session as temp storage keyed by phone
        $this->CI->load->library('session');
        $this->CI->session->set_userdata('otp_' . $phone, [
            'otp'        => $otp,
            'parent_id'  => $parent->parent_id,
            'expires_at' => time() + ($this->config['otp_expiry'] ?? 300)
        ]);

        // In production: send OTP via SMS gateway
        // For now: dev bypass available
        log_message('info', "OTP for {$phone}: {$otp}");

        return TRUE;
    }

    /**
     * Verify OTP for a phone number.
     * Returns parent row on success, FALSE on failure.
     */
    public function verify_otp($phone, $otp) {
        // Dev bypass
        $dev_otp = $this->config['otp_dev_bypass'] ?? null;
        if ($dev_otp && $otp === $dev_otp) {
            $parent = $this->CI->db->like('phone', $phone)->get('parent')->row();
            return $parent ?: FALSE;
        }

        // Check stored OTP
        $this->CI->load->library('session');
        $stored = $this->CI->session->userdata('otp_' . $phone);

        if (!$stored) return FALSE;
        if ($stored['expires_at'] < time()) return FALSE;
        if ($stored['otp'] !== $otp) return FALSE;

        // OTP valid — clear it
        $this->CI->session->unset_userdata('otp_' . $phone);

        // Return parent
        return $this->CI->db->get_where('parent', ['parent_id' => $stored['parent_id']])->row();
    }

    // ========================================================================
    // RATE LIMITING (DB-backed)
    // ========================================================================

    /**
     * Check rate limit for an identifier (API key or IP).
     * Returns TRUE if within limit, FALSE if exceeded.
     */
    public function check_rate_limit($identifier) {
        if (!($this->config['rate_limit_enabled'] ?? false)) return TRUE;

        $max_requests = $this->config['rate_limit_requests'] ?? 60;
        $window       = $this->config['rate_limit_window'] ?? 60;
        $window_start = date('Y-m-d H:i:s', time() - $window);

        // Count requests in current window
        $count = $this->CI->db
            ->where('identifier', $identifier)
            ->where('window_start >', $window_start)
            ->count_all_results('rate_limits');

        if ($count >= $max_requests) {
            return FALSE;
        }

        // Log this request
        $this->CI->db->insert('rate_limits', [
            'identifier'    => $identifier,
            'request_count' => 1,
            'window_start'  => date('Y-m-d H:i:s')
        ]);

        // Cleanup old entries (every ~100th request)
        if (rand(1, 100) === 1) {
            $this->CI->db->where('window_start <', date('Y-m-d H:i:s', time() - $window * 2))->delete('rate_limits');
        }

        return TRUE;
    }

    // ========================================================================
    // JWT INTERNAL METHODS (No external dependencies)
    // ========================================================================

    private function _jwt_encode($payload) {
        $secret = $this->config['jwt_secret'];

        $header = $this->_base64url_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $body   = $this->_base64url_encode(json_encode($payload));
        $sig    = $this->_base64url_encode(hash_hmac('sha256', "{$header}.{$body}", $secret, true));

        return "{$header}.{$body}.{$sig}";
    }

    private function _jwt_decode($token) {
        $secret = $this->config['jwt_secret'];
        $parts  = explode('.', $token);

        if (count($parts) !== 3) return FALSE;

        list($header, $body, $sig) = $parts;

        // Verify signature
        $expected_sig = $this->_base64url_encode(hash_hmac('sha256', "{$header}.{$body}", $secret, true));
        if (!hash_equals($expected_sig, $sig)) return FALSE;

        $payload = json_decode($this->_base64url_decode($body), true);
        if (!$payload) return FALSE;

        return $payload;
    }

    private function _base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function _base64url_decode($data) {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
