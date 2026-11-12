<?php
/**
 * Eventure CMS — Git Webhook & Auto Deployment Script
 * Hit this URL to automatically pull latest changes from GitHub:
 * https://admin.myeventure.in/deploy.php?key=eventure_secret_cdn_key_9748328654
 */
declare(strict_types=1);

$secretKey = 'eventure_secret_cdn_key_9748328654';
$providedKey = $_GET['key'] ?? ($_POST['key'] ?? '');

if ($providedKey !== $secretKey) {
    http_response_code(403);
    die("Access Denied: Invalid deployment key.");
}

header('Content-Type: text/plain; charset=utf-8');
echo "=== Eventure CMS Deployment ===\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n";
echo "Current directory: " . getcwd() . "\n\n";

if (!function_exists('shell_exec')) {
    echo "Notice: shell_exec() is disabled on this server.\n";
    echo "Please use DirectAdmin Git Management or File Manager to update files.\n";
    exit;
}

$output = [];
$cmds = [
    'git status 2>&1',
    'git pull origin main 2>&1'
];

foreach ($cmds as $cmd) {
    echo ">> $cmd\n";
    $res = shell_exec($cmd);
    echo ($res ?: '(no output)') . "\n\n";
}

echo "=== Deployment Finished ===\n";
