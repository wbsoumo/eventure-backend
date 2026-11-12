<?php
/**
 * Eventure REST API — Gallery Photos
 * Endpoint: GET /api/gallery.php?category=weddings
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

$category = trim($_GET['category'] ?? '');

try {
    $sql = "SELECT `id`, `title`, `category`, `image_url`, `thumbnail_url`, `aspect_ratio` FROM `gallery_photos` WHERE `is_active` = 1";
    $params = [];

    if (!empty($category) && strtolower($category) !== 'all') {
        $sql .= " AND LOWER(`category`) = LOWER(?)";
        $params[] = $category;
    }

    $sql .= " ORDER BY `display_order` ASC, `id` DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $photos = $stmt->fetchAll() ?: [];

    echo json_encode([
        'success'  => true,
        'count'    => count($photos),
        'photos'   => $photos,
        'cachedAt' => date('c')
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
