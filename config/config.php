<?php
/**
 * Eventure CMS — Global Configuration & Constants
 */
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    session_start();
}

// System URLs
define('APP_NAME', 'Eventure Admin');
define('APP_VERSION', '1.0.0');

// Determine base URL dynamically
$scheme  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host    = $_SERVER['HTTP_HOST'] ?? 'admin.myeventure.in';
define('BASE_URL', "{$scheme}://{$host}");

// CDN Configuration
define('CDN_URL', 'https://cdn.myeventure.in');
define('CDN_UPLOAD_ENDPOINT', 'https://cdn.myeventure.in/upload.php');
define('CDN_API_KEY', 'eventure_secret_cdn_key_9748328654');

// Default Admin Credentials reminder (for installer)
define('DEFAULT_ADMIN_EMAIL', 'admin@myeventure.in');

// Include DB Connection
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/auth.php';
