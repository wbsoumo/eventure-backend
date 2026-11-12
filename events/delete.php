<?php
/**
 * Eventure CMS — Delete Event
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

$id    = (int)($_GET['id'] ?? 0);
$token = $_GET['csrf_token'] ?? '';

if (!verify_csrf_token($token)) {
    set_flash('error', 'Invalid security token.');
    redirect(BASE_URL . '/events/index.php');
}

$stmt = $pdo->prepare("DELETE FROM `portfolio_events` WHERE `id` = ?");
$stmt->execute([$id]);

set_flash('success', 'Event successfully deleted.');
redirect(BASE_URL . '/events/index.php');
