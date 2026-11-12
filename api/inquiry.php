<?php
/**
 * Eventure REST API — Lead & Inquiry Submissions
 * Endpoint: POST /api/inquiry.php
 */
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

require_once __DIR__ . '/../config/db.php';

// Accept JSON payload or standard POST form data
$rawBody = file_get_contents('php://input');
$data = json_decode($rawBody, true) ?: $_POST;

$name      = trim($data['name'] ?? '');
$phone     = trim($data['phone'] ?? '');
$email     = trim($data['email'] ?? '');
$eventType = trim($data['eventType'] ?? $data['event_type'] ?? '');
$city      = trim($data['city'] ?? 'Kolkata');
$date      = trim($data['date'] ?? $data['target_date'] ?? '');
$guests    = trim($data['guests'] ?? '');
$budget    = trim($data['budget'] ?? '');
$message   = trim($data['message'] ?? '');

// Honeypot check
if (!empty($data['company'])) {
    // Silent drop for bots
    echo json_encode(['success' => true, 'message' => 'Inquiry received']);
    exit;
}

if (empty($name) || empty($phone) || empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Name, phone, and email are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO `enquiries` 
            (`name`, `phone`, `email`, `event_type`, `city`, `target_date`, `guests`, `budget`, `message`, `status`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'new')
    ");

    $stmt->execute([
        $name, $phone, $email, $eventType, $city, $date, $guests, $budget, $message
    ]);

    $inquiryId = (int)$pdo->lastInsertId();

    echo json_encode([
        'success'   => true,
        'message'   => 'Thank you. Your event brief has been received by our senior team in Kolkata.',
        'inquiryId' => $inquiryId
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
