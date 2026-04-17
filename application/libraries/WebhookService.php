<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * WebhookService Library
 * 
 * Dispatches outbound webhook events to registered URLs.
 * Supports: fee.paid, attendance.marked, result.published
 */
class WebhookService {

    private $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->config->load('api_config', TRUE);
    }

    /**
     * Dispatch a webhook event.
     * 
     * @param string $event_type  e.g., 'fee.paid', 'attendance.marked'
     * @param array  $payload     Data to send
     */
    public function dispatch($event_type, $payload = []) {
        $config = $this->CI->config->item('api_config');
        if (!($config['webhooks_enabled'] ?? false)) return;

        // Get active webhook configs for this event
        $webhooks = $this->CI->db->get_where('webhook_config', [
            'event_type' => $event_type,
            'is_active'  => 1
        ])->result();

        foreach ($webhooks as $webhook) {
            $this->_send($webhook, $event_type, $payload);
        }
    }

    /**
     * Send webhook payload to target URL.
     */
    private function _send($webhook, $event_type, $payload) {
        $body = json_encode([
            'event'     => $event_type,
            'timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'data'      => $payload
        ]);

        // Generate signature for verification
        $signature = '';
        if (!empty($webhook->secret_key)) {
            $signature = hash_hmac('sha256', $body, $webhook->secret_key);
        }

        $headers = [
            'Content-Type: application/json',
            'X-Webhook-Event: ' . $event_type,
            'X-Webhook-Signature: ' . $signature
        ];

        // Use cURL for non-blocking request
        $ch = curl_init($webhook->target_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_CONNECTTIMEOUT => 5
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Log the webhook delivery attempt
        $this->_log($webhook, $event_type, $body, $response, $http_code, $error);
    }

    /**
     * Log webhook delivery attempt.
     */
    private function _log($webhook, $event_type, $request_body, $response, $http_code, $error) {
        try {
            $this->CI->db->insert('api_logs', [
                'method'           => 'WEBHOOK',
                'endpoint'         => $webhook->target_url,
                'status_code'      => $http_code ?: 0,
                'response_time_ms' => 0,
                'ip_address'       => 'outbound',
                'user_agent'       => 'SmartSchool-Webhook/1.0 ' . $event_type
            ]);
        } catch (Exception $e) {
            // Silently fail
        }
    }
}
