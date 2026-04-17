<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ApiResponse Library
 * 
 * Standardized JSON response builder for the Smart_school REST API.
 * Handles success/error responses, pagination, gzip compression,
 * CORS headers, and request logging.
 */
class ApiResponse {

    private $CI;
    private $start_time;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->config->load('api_config', TRUE);
        $this->start_time = microtime(true);
    }

    /**
     * Send a successful JSON response.
     */
    public function success($data = null, $message = 'Success', $code = 200, $pagination = null) {
        $response = [
            'status'    => 'success',
            'code'      => $code,
            'message'   => $message,
            'data'      => $data,
            'timestamp' => gmdate('Y-m-d\TH:i:s\Z')
        ];

        if ($pagination) {
            $response['pagination'] = $pagination;
        }

        $this->_send($response, $code);
    }

    /**
     * Send an error JSON response.
     */
    public function error($message = 'An error occurred', $code = 400, $error_type = 'BAD_REQUEST') {
        $response = [
            'status'     => 'error',
            'code'       => $code,
            'error_type' => $error_type,
            'message'    => $message,
            'timestamp'  => gmdate('Y-m-d\TH:i:s\Z')
        ];

        $this->_send($response, $code);
    }

    /**
     * Build a standard pagination object.
     */
    public function paginate($page, $limit, $total) {
        return [
            'page'        => (int)$page,
            'limit'       => (int)$limit,
            'total'       => (int)$total,
            'total_pages' => (int)ceil($total / max($limit, 1))
        ];
    }

    /**
     * Get pagination params from request with defaults.
     */
    public function get_pagination_params() {
        $config = $this->CI->config->item('api_config');
        $default_limit = isset($config['default_page_limit']) ? $config['default_page_limit'] : 20;
        $max_limit     = isset($config['max_page_limit']) ? $config['max_page_limit'] : 100;

        $page  = max(1, (int)$this->CI->input->get('page'));
        $limit = (int)$this->CI->input->get('limit');
        
        if ($limit <= 0) $limit = $default_limit;
        if ($limit > $max_limit) $limit = $max_limit;

        $offset = ($page - 1) * $limit;

        return ['page' => $page, 'limit' => $limit, 'offset' => $offset];
    }

    /**
     * Set CORS headers.
     */
    public function set_cors_headers() {
        $config = $this->CI->config->item('api_config');
        $origins = isset($config['cors_allowed_origins']) ? implode(', ', $config['cors_allowed_origins']) : '*';

        header('Access-Control-Allow-Origin: ' . $origins);
        header('Access-Control-Allow-Methods: ' . ($config['cors_allowed_methods'] ?? 'GET, POST, OPTIONS'));
        header('Access-Control-Allow-Headers: ' . ($config['cors_allowed_headers'] ?? 'Content-Type, Authorization, X-API-KEY'));
        header('Access-Control-Max-Age: 86400');

        // Handle preflight OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }

    /**
     * Log an API request to the api_logs table.
     */
    public function log_request($api_key_id = null, $parent_id = null, $status_code = 200) {
        $config = $this->CI->config->item('api_config');
        if (!($config['api_logging_enabled'] ?? false)) return;

        $response_time = round((microtime(true) - $this->start_time) * 1000);

        // Silently attempt to log — don't break the API if logging fails
        try {
            $this->CI->db->insert('api_logs', [
                'api_key_id'       => $api_key_id,
                'parent_id'        => $parent_id,
                'method'           => $_SERVER['REQUEST_METHOD'],
                'endpoint'         => $_SERVER['REQUEST_URI'],
                'status_code'      => $status_code,
                'response_time_ms' => $response_time,
                'ip_address'       => $this->CI->input->ip_address(),
                'user_agent'       => substr($this->CI->input->user_agent(), 0, 500)
            ]);
        } catch (Exception $e) {
            // Silently fail — logging should never break the API
        }
    }

    /**
     * Internal: send JSON response with proper headers and gzip.
     */
    private function _send($response, $code) {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        header('X-Response-Time: ' . round((microtime(true) - $this->start_time) * 1000) . 'ms');

        $json = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // gzip compression if client supports it
        if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
            header('Content-Encoding: gzip');
            echo gzencode($json);
        } else {
            echo $json;
        }

        exit;
    }
}
