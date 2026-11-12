<?php
/**
 * Eventure CMS — Segment-by-Segment Page Content Editor
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

$slug = strtolower(trim($_GET['slug'] ?? 'home'));

// Fetch page details
$stmt = $pdo->prepare("SELECT * FROM `pages` WHERE `slug` = ?");
$stmt->execute([$slug]);
$page = $stmt->fetch();

if (!$page) {
    set_flash('error', "Page [{$slug}] not found.");
    redirect(BASE_URL . '/dashboard.php');
}

// Fetch sections for this page
$stmt = $pdo->prepare("SELECT * FROM `page_sections` WHERE `page_slug` = ? ORDER BY `display_order` ASC");
$stmt->execute([$slug]);
$sections = $stmt->fetchAll();

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Security token expired. Please retry.');
        redirect(BASE_URL . "/pages/edit.php?slug={$slug}");
    }

    try {
        // 1. Update Core Page Table (Hero, CTA, Metadata)
        $updatePage = $pdo->prepare("
            UPDATE `pages` SET
                `title`         = ?,
                `eyebrow`       = ?,
                `hero_title`    = ?,
                `hero_subtitle` = ?,
                `hero_image`    = ?,
                `cta_eyebrow`   = ?,
                `cta_title`     = ?,
                `cta_subtitle`  = ?,
                `cta_btn_text`  = ?,
                `cta_btn_link`  = ?
            WHERE `slug` = ?
        ");

        $updatePage->execute([
            trim($_POST['title'] ?? ''),
            trim($_POST['eyebrow'] ?? ''),
            trim($_POST['hero_title'] ?? ''),
            trim($_POST['hero_subtitle'] ?? ''),
            trim($_POST['hero_image'] ?? ''),
            trim($_POST['cta_eyebrow'] ?? ''),
            trim($_POST['cta_title'] ?? ''),
            trim($_POST['cta_subtitle'] ?? ''),
            trim($_POST['cta_btn_text'] ?? ''),
            trim($_POST['cta_btn_link'] ?? ''),
            $slug
        ]);

        // 2. Update Dynamic Page Sections
        if (!empty($_POST['sections']) && is_array($_POST['sections'])) {
            $updateSec = $pdo->prepare("
                INSERT INTO `page_sections` (`page_slug`, `section_key`, `title`, `content_json`)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    `title` = VALUES(`title`),
                    `content_json` = VALUES(`content_json`)
            ");

            foreach ($_POST['sections'] as $secKey => $secData) {
                $secTitle = trim($secData['title'] ?? '');
                $rawJson  = trim($secData['json'] ?? '');

                // Verify valid JSON
                $decoded = json_decode($rawJson, true);
                if ($decoded === null && !empty($rawJson)) {
                    throw new Exception("Invalid JSON formatting in section [{$secKey}]");
                }
                $cleanJson = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

                $updateSec->execute([$slug, $secKey, $secTitle, $cleanJson]);
            }
        }

        set_flash('success', "Page [{$page['title']}] updated successfully!");
        redirect(BASE_URL . "/pages/edit.php?slug={$slug}");
    } catch (Exception $e) {
        set_flash('error', 'Update failed: ' . $e->getMessage());
        redirect(BASE_URL . "/pages/edit.php?slug={$slug}");
    }
}

$pageTitle = "Edit {$page['title']} Page";
require_once __DIR__ . '/../includes/header.php';
?>

<div class="row">
  <div class="col-12">
    <div class="card card-outline card-warning">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h3 class="card-title text-primary font-weight-bold">
            <i class="fas fa-edit mr-2"></i><?= e($page['title']) ?> Content Editor
          </h3>
          <span class="badge badge-secondary ml-2">Slug: <?= e($slug) ?></span>
        </div>
        <div>
          <a href="https://www.myeventure.in<?= $slug === 'home' ? '' : '/' . e($slug) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-external-link-alt mr-1"></i> Preview on Website
          </a>
        </div>
      </div>

      <form action="" method="post">
        <?= csrf_field() ?>

        <div class="card-body">
          <!-- SECTION 1: HERO & HEADER BANNER -->
          <div class="callout callout-warning bg-light text-dark border-light mb-4">
            <h5 class="text-primary"><i class="fas fa-image mr-2"></i>1. Hero Header &amp; Atmosphere</h5>
            <p class="text-muted text-sm">Control the full-bleed atmospheric photograph, eyebrow tagline, and display typography.</p>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="pageTitleInput">Page Title (Browser / Navigation)</label>
                <input type="text" id="pageTitleInput" name="title" class="form-control" value="<?= e($page['title']) ?>" required>
              </div>

              <div class="form-group">
                <label for="eyebrowInput">Hero Eyebrow Tagline</label>
                <input type="text" id="eyebrowInput" name="eyebrow" class="form-control" value="<?= e($page['eyebrow']) ?>" placeholder="e.g. LUXURY WEDDINGS · PAN INDIA">
              </div>

              <div class="form-group">
                <label for="heroTitleInput">Hero Display Heading</label>
                <textarea id="heroTitleInput" name="hero_title" class="form-control" rows="3" placeholder="Display heading (newlines create distinct visual lines)"><?= e($page['hero_title']) ?></textarea>
                <small class="text-muted">Each new line creates a typographic break on the website.</small>
              </div>

              <div class="form-group">
                <label for="heroSubInput">Hero Introductory Subtitle</label>
                <textarea id="heroSubInput" name="hero_subtitle" class="form-control" rows="4"><?= e($page['hero_subtitle']) ?></textarea>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Hero Atmospheric Background Image</label>
                <div class="cdn-image-box">
                  <div class="mb-3 text-center">
                    <img id="heroImagePreview" src="<?= e($page['hero_image']) ?>" alt="Hero Preview" class="cdn-thumb-preview" onerror="this.src='https://via.placeholder.com/600x300/121215/d4af37?text=No+Image+Selected'">
                  </div>

                  <div class="input-group mb-2">
                    <input type="text" id="heroImageInput" name="hero_image" class="form-control form-control-sm" value="<?= e($page['hero_image']) ?>" placeholder="e.g. /images/wedding.webp or CDN URL" required>
                  </div>

                  <!-- CDN Direct Uploader Button -->
                  <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top border-light">
                    <label class="btn btn-outline-primary btn-sm mb-0 cursor-pointer">
                      <i class="fas fa-cloud-upload-alt mr-1"></i> Upload New Image to CDN
                      <input type="file" class="d-none" data-cdn-upload data-target-input="heroImageInput" data-target-preview="heroImagePreview" data-folder="<?= in_array($slug, ['weddings', 'corporate']) ? $slug : 'general' ?>" accept="image/*">
                    </label>
                    <div class="upload-status text-xs"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <hr class="border-light my-5">

          <!-- SECTION 2: PAGE-SPECIFIC SEGMENTS / CARDS -->
          <div class="callout callout-info bg-light text-dark border-light mb-4">
            <h5 class="text-primary"><i class="fas fa-th-large mr-2"></i>2. Segment Cards &amp; Content Modules</h5>
            <p class="text-muted text-sm">Edit cards, capabilities, metrics, and structured JSON sections that populate this page.</p>
          </div>

          <?php if (empty($sections)): ?>
            <div class="alert alert-dark border border-light text-muted">
              <i class="fas fa-info-circle mr-1"></i> This page uses dynamic content from global databases (Portfolio / Gallery). Manage them via the sidebar menus.
            </div>
          <?php else: ?>
            <?php foreach ($sections as $sec): ?>
              <div class="card bg-light text-dark border border-light mb-4">
                <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center">
                  <strong class="text-primary">
                    <i class="fas fa-cubes mr-2"></i><?= e($sec['title'] ?: ucfirst($sec['section_key'])) ?>
                  </strong>
                  <span class="badge badge-secondary"><?= e($sec['section_key']) ?></span>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" name="sections[<?= e($sec['section_key']) ?>][title]" class="form-control" value="<?= e($sec['title']) ?>">
                  </div>

                  <div class="form-group">
                    <label>Cards &amp; Items Data (Structured JSON)</label>
                    <textarea name="sections[<?= e($sec['section_key']) ?>][json]" class="form-control font-monospace text-warning" rows="7" style="font-family: monospace; font-size: 0.85rem;"><?= e($sec['content_json']) ?></textarea>
                    <small class="text-muted">Structured items, metrics, and cards formatted as clean JSON.</small>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

          <hr class="border-light my-5">

          <!-- SECTION 3: CALL TO ACTION (CTA) AT PAGE BOTTOM -->
          <div class="callout callout-warning bg-light text-dark border-light mb-4">
            <h5 class="text-primary"><i class="fas fa-bullhorn mr-2"></i>3. Bottom Call to Action (CTA) Banner</h5>
            <p class="text-muted text-sm">The closing statement and invitation at the bottom of the page.</p>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="ctaEyebrow">CTA Eyebrow</label>
                <input type="text" id="ctaEyebrow" name="cta_eyebrow" class="form-control" value="<?= e($page['cta_eyebrow'] ?? '') ?>" placeholder="e.g. Kolkata Studio">
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="ctaTitle">CTA Big Heading</label>
                <input type="text" id="ctaTitle" name="cta_title" class="form-control" value="<?= e($page['cta_title'] ?? '') ?>" placeholder="e.g. If you are planning something that truly matters...">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="ctaSubtitle">CTA Subtitle Description</label>
                <textarea id="ctaSubtitle" name="cta_subtitle" class="form-control" rows="2"><?= e($page['cta_subtitle'] ?? '') ?></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="ctaBtnText">Button Label</label>
                <input type="text" id="ctaBtnText" name="cta_btn_text" class="form-control" value="<?= e($page['cta_btn_text'] ?? 'Start an Enquiry') ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="ctaBtnLink">Button Target Link</label>
                <input type="text" id="ctaBtnLink" name="cta_btn_link" class="form-control" value="<?= e($page['cta_btn_link'] ?? '/contact') ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer bg-light text-dark border-light text-right">
          <a href="<?= BASE_URL ?>/dashboard.php" class="btn btn-secondary mr-2">Cancel</a>
          <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save mr-1"></i> Save Changes to <?= e($page['title']) ?>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
