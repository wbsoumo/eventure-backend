<?php
/**
 * Eventure CDN Image Migrator
 * Reads all image paths in the database (portfolio_events, gallery_photos, pages, site_settings)
 * Matches corresponding local files in /public
 * Uploads them via https://cdn.myeventure.in/upload.php
 * Updates MySQL records with the new cdn.myeventure.in URLs
 */
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

$dbHost     = '86.107.77.32';
$dbName     = 'myevent1_eventure';
$dbUser     = 'myevent1_eventure';
$dbPass     = 'BHWM2RGLbc5Mm586rYDC';
$dbCharset  = 'utf8mb4';

$uploadEndpoint = 'https://cdn.myeventure.in/upload.php';
$apiKey         = 'eventure_secret_cdn_key_9748328654';

$publicDir = realpath(__DIR__ . '/../public');
if (!$publicDir || !is_dir($publicDir)) {
    die("Error: public directory not found at " . __DIR__ . "/../public\n");
}

echo "=== Eventure CDN Image Sync Starting ===\n";
echo "Public directory: {$publicDir}\n";

try {
    $dsn = "mysql:host={$dbHost};dbname={$dbName};charset={$dbCharset}";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "Connected to MySQL database on {$dbHost}\n\n";
} catch (PDOException $e) {
    die("Database Connection Error: " . $e->getMessage() . "\n");
}

// Memory cache of local_path -> cdn_url
$cacheFile = __DIR__ . '/cdn_upload_cache.json';
$uploadedCache = [];
if (file_exists($cacheFile)) {
    $uploadedCache = json_decode(file_get_contents($cacheFile), true) ?: [];
}

function uploadFileToCdn(string $localFilePath, string $folder, string $uploadEndpoint, string $apiKey, array &$cache, string $cacheFile): ?string {
    if (!file_exists($localFilePath)) {
        return null;
    }

    $realPath = realpath($localFilePath);
    if (isset($cache[$realPath])) {
        return $cache[$realPath];
    }

    $cfile = new CURLFile($realPath);
    $postData = [
        'api_key' => $apiKey,
        'folder'  => $folder,
        'file'    => $cfile,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uploadEndpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 && $response) {
        $json = json_decode($response, true);
        if (!empty($json['success']) && !empty($json['url'])) {
            $cdnUrl = $json['url'];
            $cache[$realPath] = $cdnUrl;
            file_put_contents($cacheFile, json_encode($cache, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            return $cdnUrl;
        }
    }

    echo "  [WARN] Upload failed for {$localFilePath} (HTTP {$httpCode}): {$response}\n";
    return null;
}

function resolveLocalPath(string $relPath, string $publicDir): ?string {
    $relPath = ltrim($relPath, '/');
    $cand = $publicDir . '/' . $relPath;
    if (file_exists($cand)) {
        return $cand;
    }
    return null;
}

// 1. Sync Site Settings Logo
echo "--- 1. Syncing Site Settings Logo ---\n";
$stmt = $pdo->query("SELECT id, logo_url FROM site_settings LIMIT 1");
if ($row = $stmt->fetch()) {
    $logo = $row['logo_url'] ?? '';
    if ($logo && !str_starts_with($logo, 'https://cdn.myeventure.in')) {
        $local = resolveLocalPath($logo, $publicDir);
        if ($local) {
            $cdn = uploadFileToCdn($local, 'logos', $uploadEndpoint, $apiKey, $uploadedCache, $cacheFile);
            if ($cdn) {
                $pdo->prepare("UPDATE site_settings SET logo_url = ? WHERE id = ?")->execute([$cdn, $row['id']]);
                echo "  ✓ Logo updated: {$cdn}\n";
            }
        }
    }
}

// 2. Sync Pages Hero Images
echo "\n--- 2. Syncing Pages Hero Images ---\n";
$stmt = $pdo->query("SELECT id, slug, hero_image FROM pages");
while ($row = $stmt->fetch()) {
    $img = $row['hero_image'] ?? '';
    if ($img && !str_starts_with($img, 'https://cdn.myeventure.in')) {
        $local = resolveLocalPath($img, $publicDir);
        if ($local) {
            $folder = (str_contains($row['slug'], 'wedding')) ? 'weddings' : ((str_contains($row['slug'], 'corporate')) ? 'corporate' : 'general');
            $cdn = uploadFileToCdn($local, $folder, $uploadEndpoint, $apiKey, $uploadedCache, $cacheFile);
            if ($cdn) {
                $pdo->prepare("UPDATE pages SET hero_image = ? WHERE id = ?")->execute([$cdn, $row['id']]);
                echo "  ✓ Page [{$row['slug']}] hero image updated: {$cdn}\n";
            }
        }
    }
}

// 3. Sync Portfolio Events
echo "\n--- 3. Syncing Portfolio Events Images ---\n";
$stmt = $pdo->query("SELECT id, title, category, hero_image, gallery_images FROM portfolio_events");
while ($row = $stmt->fetch()) {
    $folder = (stripos($row['category'] ?? '', 'wedding') !== false) ? 'weddings' : 'corporate';
    $hero = $row['hero_image'] ?? '';
    $updatedHero = $hero;

    if ($hero && !str_starts_with($hero, 'https://cdn.myeventure.in')) {
        $local = resolveLocalPath($hero, $publicDir);
        if ($local) {
            $cdn = uploadFileToCdn($local, $folder, $uploadEndpoint, $apiKey, $uploadedCache, $cacheFile);
            if ($cdn) {
                $updatedHero = $cdn;
            }
        }
    }

    // Gallery images JSON
    $gal = json_decode($row['gallery_images'] ?? '[]', true) ?: [];
    $updatedGal = [];
    foreach ($gal as $gimg) {
        if (!str_starts_with($gimg, 'https://cdn.myeventure.in')) {
            $local = resolveLocalPath($gimg, $publicDir);
            if ($local) {
                $cdn = uploadFileToCdn($local, $folder, $uploadEndpoint, $apiKey, $uploadedCache, $cacheFile);
                $updatedGal[] = $cdn ?: $gimg;
            } else {
                $updatedGal[] = $gimg;
            }
        } else {
            $updatedGal[] = $gimg;
        }
    }

    $pdo->prepare("UPDATE portfolio_events SET hero_image = ?, gallery_images = ? WHERE id = ?")
        ->execute([$updatedHero, json_encode($updatedGal, JSON_UNESCAPED_SLASHES), $row['id']]);
    echo "  ✓ Event #{$row['id']} ({$row['title']}) updated.\n";
}

// 4. Sync Gallery Photos (all 91 archive photos)
echo "\n--- 4. Syncing Gallery Photos (91 items) ---\n";
$stmt = $pdo->query("SELECT id, title, category, image_url, thumbnail_url FROM gallery_photos");
$count = 0;
while ($row = $stmt->fetch()) {
    $imgUrl  = $row['image_url'] ?? '';
    $thumbUrl = $row['thumbnail_url'] ?? '';
    $cat = strtolower($row['category'] ?? 'gallery');
    $folder = 'gallery';

    $newImg = $imgUrl;
    $newThumb = $thumbUrl;

    if ($imgUrl && !str_starts_with($imgUrl, 'https://cdn.myeventure.in')) {
        $local = resolveLocalPath($imgUrl, $publicDir);
        if ($local) {
            $cdn = uploadFileToCdn($local, $folder, $uploadEndpoint, $apiKey, $uploadedCache, $cacheFile);
            if ($cdn) {
                $newImg = $cdn;
            }
        }
    }

    if ($thumbUrl && !str_starts_with($thumbUrl, 'https://cdn.myeventure.in')) {
        $local = resolveLocalPath($thumbUrl, $publicDir);
        if ($local) {
            $cdn = uploadFileToCdn($local, $folder, $uploadEndpoint, $apiKey, $uploadedCache, $cacheFile);
            if ($cdn) {
                $newThumb = $cdn;
            }
        }
    } elseif (!$thumbUrl && $newImg) {
        $newThumb = $newImg;
    }

    if ($newImg !== $imgUrl || $newThumb !== $thumbUrl) {
        $pdo->prepare("UPDATE gallery_photos SET image_url = ?, thumbnail_url = ? WHERE id = ?")
            ->execute([$newImg, $newThumb, $row['id']]);
        $count++;
    }
}
echo "  ✓ {$count} gallery photos updated with CDN URLs.\n";

echo "\n=== Image Migration to CDN Completed Successfully! ===\n";
