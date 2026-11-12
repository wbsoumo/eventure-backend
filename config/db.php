<?php
/**
 * Eventure CMS — Database Connection (PDO)
 */
declare(strict_types=1);

// Automatic detection: if running on Hostbet server, localhost or remote IP
$isLocalhost = in_array($_SERVER['SERVER_ADDR'] ?? '', ['127.0.0.1', '::1', '86.107.77.32'], true);
$dbHost      = $isLocalhost ? 'localhost' : (getenv('DB_HOST') ?: '86.107.77.32');
$dbName      = getenv('DB_NAME') ?: 'myevent1_eventure';
$dbUser      = getenv('DB_USER') ?: 'myevent1_eventure';
$dbPass      = getenv('DB_PASS') ?: 'BHWM2RGLbc5Mm586rYDC';
$dbCharset   = 'utf8mb4';

try {
    $dsn = "mysql:host={$dbHost};dbname={$dbName};charset={$dbCharset}";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$dbCharset}"
    ]);
} catch (PDOException $e) {
    // If localhost fails on server, try fallback to 86.107.77.32
    if ($dbHost === 'localhost') {
        try {
            $dsn = "mysql:host=86.107.77.32;dbname={$dbName};charset={$dbCharset}";
            $pdo = new PDO($dsn, $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e2) {
            die("Database Connection Error: " . $e2->getMessage());
        }
    } else {
        die("Database Connection Error: " . $e->getMessage());
    }
}
