<?php
/**
 * Eventure REST API — Site Settings & Navigation
 * Endpoint: GET /api/site.php
 */
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../config/db.php';

try {
    // 1. Fetch site settings
    $stmt = $pdo->query("SELECT * FROM `site_settings` WHERE `id` = 1");
    $settings = $stmt->fetch() ?: [];

    // 2. Fetch active navigation items
    $navStmt = $pdo->query("SELECT `name`, `path`, `num_prefix` FROM `nav_items` WHERE `is_active` = 1 ORDER BY `display_order` ASC");
    $navItems = $navStmt->fetchAll() ?: [];

    echo json_encode([
        'success'  => true,
        'settings' => $settings,
        'nav'      => $navItems,
        'cachedAt' => date('c')
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
