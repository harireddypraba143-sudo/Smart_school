<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ApiSetup Controller
 * 
 * One-time setup: creates database tables and generates API key.
 * 
 * USAGE: Visit /api_setup/install once, copy the API key, then DISABLE this controller.
 * WARNING: Remove or restrict this controller in production!
 */
class ApiSetup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Create all API tables and generate first API key.
     * Visit: http://localhost:8000/api_setup/install
     */
    public function install() {
        $results = [];

        // 1. Create api_keys table
        $this->db->query("
            CREATE TABLE IF NOT EXISTS api_keys (
                id INT AUTO_INCREMENT PRIMARY KEY,
                api_key VARCHAR(64) NOT NULL UNIQUE,
                app_name VARCHAR(100) NOT NULL,
                allowed_ips TEXT DEFAULT NULL,
                is_active TINYINT(1) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
        $results[] = '✅ api_keys table created';

        // 2. Create refresh_tokens table
        $this->db->query("
            CREATE TABLE IF NOT EXISTS refresh_tokens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                parent_id INT NOT NULL,
                token VARCHAR(128) NOT NULL UNIQUE,
                expires_at DATETIME NOT NULL,
                is_revoked TINYINT(1) DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_token (token),
                INDEX idx_parent (parent_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
        $results[] = '✅ refresh_tokens table created';

        // 3. Create api_logs table
        $this->db->query("
            CREATE TABLE IF NOT EXISTS api_logs (
                id BIGINT AUTO_INCREMENT PRIMARY KEY,
                api_key_id INT DEFAULT NULL,
                parent_id INT DEFAULT NULL,
                method VARCHAR(10) NOT NULL,
                endpoint VARCHAR(255) NOT NULL,
                status_code INT NOT NULL DEFAULT 200,
                response_time_ms INT DEFAULT 0,
                ip_address VARCHAR(45),
                user_agent TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_created (created_at),
                INDEX idx_endpoint (endpoint)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
        $results[] = '✅ api_logs table created';

        // 4. Create rate_limits table
        $this->db->query("
            CREATE TABLE IF NOT EXISTS rate_limits (
                id INT AUTO_INCREMENT PRIMARY KEY,
                identifier VARCHAR(100) NOT NULL,
                request_count INT DEFAULT 1,
                window_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_identifier (identifier),
                INDEX idx_window (window_start)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
        $results[] = '✅ rate_limits table created';

        // 5. Create webhook_config table
        $this->db->query("
            CREATE TABLE IF NOT EXISTS webhook_config (
                id INT AUTO_INCREMENT PRIMARY KEY,
                event_type VARCHAR(50) NOT NULL,
                target_url TEXT NOT NULL,
                secret_key VARCHAR(64),
                is_active TINYINT(1) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
        $results[] = '✅ webhook_config table created';

        // 6. Generate API key for Smart_City app
        $api_key = bin2hex(random_bytes(32)); // 64-char hex
        
        // Check if Smart_City key already exists
        $existing = $this->db->get_where('api_keys', ['app_name' => 'Smart_City_App'])->row();
        if (!$existing) {
            $this->db->insert('api_keys', [
                'api_key'  => $api_key,
                'app_name' => 'Smart_City_App',
                'allowed_ips' => '*' // Allow all IPs initially
            ]);
            $results[] = '✅ API key generated for Smart_City_App';
        } else {
            $api_key = $existing->api_key;
            $results[] = '⚠️ API key already exists for Smart_City_App';
        }

        // Display results
        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html><html><head><title>Smart_school API Setup</title>';
        echo '<style>
            body { font-family: "Inter", sans-serif; background: #0f172a; color: #e2e8f0; padding: 40px; }
            .container { max-width: 700px; margin: 0 auto; }
            h1 { background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
            .result { padding: 8px 16px; margin: 8px 0; background: #1e293b; border-radius: 8px; border-left: 3px solid #667eea; }
            .key-box { background: #1e293b; padding: 20px; border-radius: 12px; border: 2px solid #667eea; margin-top: 20px; }
            .key { font-family: monospace; font-size: 14px; color: #38bdf8; word-break: break-all; padding: 12px; background: #0f172a; border-radius: 8px; }
            .warning { background: #fef3c7; color: #92400e; padding: 16px; border-radius: 8px; margin-top: 20px; }
        </style></head><body>';
        echo '<div class="container">';
        echo '<h1>🚀 Smart_school API v1 Setup Complete</h1>';
        
        foreach ($results as $r) {
            echo '<div class="result">' . $r . '</div>';
        }

        echo '<div class="key-box">';
        echo '<h3>🔑 Your API Key (copy this NOW)</h3>';
        echo '<div class="key">' . $api_key . '</div>';
        echo '<p style="color: #94a3b8; margin-top: 10px;">Add this to your Smart_City Flutter app as <code>X-API-KEY</code> header.</p>';
        echo '</div>';

        echo '<div class="warning">';
        echo '⚠️ <strong>IMPORTANT:</strong> Disable or delete this controller (<code>ApiSetup.php</code>) after setup!';
        echo '</div>';

        echo '</div></body></html>';
    }
}
