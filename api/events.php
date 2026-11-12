<?php
/**
 * Eventure REST API — Portfolio Events
 * Endpoint: GET /api/events.php?category=Wedding
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
$slug     = trim($_GET['slug'] ?? '');

try {
    // Single Event Detail by Slug
    if (!empty($slug)) {
        $stmt = $pdo->prepare("SELECT * FROM `portfolio_events` WHERE `slug` = ? AND `is_active` = 1 LIMIT 1");
        $stmt->execute([$slug]);
        $event = $stmt->fetch();

        if (!$event) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Event not found']);
            exit;
        }

        echo json_encode(['success' => true, 'event' => $event]);
        exit;
    }

    // List Events
    $sql = "SELECT `id`, `title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `summary`, `featured`, `display_order` FROM `portfolio_events` WHERE `is_active` = 1";
    $params = [];

    if (!empty($category) && strtolower($category) !== 'all') {
        $sql .= " AND LOWER(`category`) = LOWER(?)";
        $params[] = $category;
    }

    $sql .= " ORDER BY `display_order` ASC, `id` DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $events = $stmt->fetchAll() ?: [];

    echo json_encode([
        'success'  => true,
        'count'    => count($events),
        'events'   => $events,
        'cachedAt' => date('c')
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
