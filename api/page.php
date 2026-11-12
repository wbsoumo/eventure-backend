<?php
/**
 * Eventure REST API — Page Content & Segments
 * Endpoint: GET /api/page.php?slug=home
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

$slug = strtolower(trim($_GET['slug'] ?? 'home'));

try {
    // 1. Fetch Page
    $stmt = $pdo->prepare("SELECT * FROM `pages` WHERE `slug` = ?");
    $stmt->execute([$slug]);
    $page = $stmt->fetch();

    if (!$page) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => "Page [{$slug}] not found"]);
        exit;
    }

    // 2. Fetch Page Sections
    $stmt = $pdo->prepare("SELECT `section_key`, `title`, `content_json` FROM `page_sections` WHERE `page_slug` = ?");
    $stmt->execute([$slug]);
    $rawSections = $stmt->fetchAll();

    $sections = [];
    foreach ($rawSections as $sec) {
        $sections[$sec['section_key']] = [
            'title' => $sec['title'],
            'data'  => json_decode($sec['content_json'], true) ?: []
        ];
    }

    echo json_encode([
        'success'  => true,
        'page'     => $page,
        'sections' => $sections,
        'cachedAt' => date('c')
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
