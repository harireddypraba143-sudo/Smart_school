<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Smart_school API v1 Configuration
|--------------------------------------------------------------------------
| Enterprise-grade API configuration for Smart_City integration.
| IMPORTANT: Keep this file secure. Do NOT commit secrets to public repos.
|--------------------------------------------------------------------------
*/

$config['api_version'] = 'v1';

/*
|--------------------------------------------------------------------------
| JWT Configuration
|--------------------------------------------------------------------------
*/
$config['jwt_secret']           = 'SS_2026_x9k4mP7vL2nQ8wR5tY1uB6cA3fH0jE4gK9dM7sN2xW5zV8bU1yT6pI3oJ0';
$config['jwt_algorithm']        = 'HS256';
$config['access_token_ttl']     = 3600;        // 1 hour in seconds
$config['refresh_token_ttl']    = 2592000;     // 30 days in seconds

/*
|--------------------------------------------------------------------------
| API Key Settings
|--------------------------------------------------------------------------
*/
$config['api_key_header']       = 'X-API-KEY';

/*
|--------------------------------------------------------------------------
| Rate Limiting
|--------------------------------------------------------------------------
*/
$config['rate_limit_enabled']   = TRUE;
$config['rate_limit_requests']  = 60;          // Max requests per window
$config['rate_limit_window']    = 60;          // Window in seconds (1 minute)

/*
|--------------------------------------------------------------------------
| CORS (Cross-Origin Resource Sharing)
|--------------------------------------------------------------------------
*/
$config['cors_allowed_origins'] = ['*'];       // Restrict in production
$config['cors_allowed_methods'] = 'GET, POST, PUT, DELETE, OPTIONS';
$config['cors_allowed_headers'] = 'Content-Type, Authorization, X-API-KEY';

/*
|--------------------------------------------------------------------------
| OTP Settings
|--------------------------------------------------------------------------
*/
$config['otp_length']           = 6;
$config['otp_expiry']           = 300;         // 5 minutes in seconds
$config['otp_dev_bypass']       = '123456';    // Dev-only bypass. SET TO NULL IN PRODUCTION!

/*
|--------------------------------------------------------------------------
| Response Settings
|--------------------------------------------------------------------------
*/
$config['default_page_limit']   = 20;
$config['max_page_limit']       = 100;

/*
|--------------------------------------------------------------------------
| Logging
|--------------------------------------------------------------------------
*/
$config['api_logging_enabled']  = TRUE;

/*
|--------------------------------------------------------------------------
| Webhook Configuration
|--------------------------------------------------------------------------
*/
$config['webhooks_enabled']     = TRUE;
