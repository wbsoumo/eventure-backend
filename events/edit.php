<?php
/**
 * Eventure CMS — Edit Existing Event / Portfolio Project
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM `portfolio_events` WHERE `id` = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

if (!$event) {
    set_flash('error', 'Event not found.');
    redirect(BASE_URL . '/events/index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Security token expired.');
        redirect(BASE_URL . "/events/edit.php?id={$id}");
    }

    $title     = trim($_POST['title'] ?? '');
    $slug      = trim($_POST['slug'] ?? '') ?: slugify($title);
    $category  = trim($_POST['category'] ?? 'Wedding');
    $client    = trim($_POST['client'] ?? '');
    $year      = trim($_POST['year'] ?? '');
    $location  = trim($_POST['location'] ?? '');
    $scope     = trim($_POST['scope'] ?? '');
    $stats     = trim($_POST['stats'] ?? '');
    $heroImage = trim($_POST['hero_image'] ?? '');
    $summary   = trim($_POST['summary'] ?? '');
    $desc      = trim($_POST['description'] ?? '');
    $featured  = isset($_POST['featured']) ? 1 : 0;
    $order     = (int)($_POST['display_order'] ?? 0);

    if (empty($title) || empty($heroImage)) {
        set_flash('error', 'Event title and cover image are required.');
        redirect(BASE_URL . "/events/edit.php?id={$id}");
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE `portfolio_events` SET
                `title`         = ?,
                `slug`          = ?,
                `category`      = ?,
                `client`        = ?,
                `year`          = ?,
                `location`      = ?,
                `scope`         = ?,
                `stats`         = ?,
                `hero_image`    = ?,
                `summary`       = ?,
                `description`   = ?,
                `featured`      = ?,
                `display_order` = ?
            WHERE `id` = ?
        ");
        $stmt->execute([
            $title, $slug, $category, $client, $year, $location, $scope, $stats, $heroImage, $summary, $desc, $featured, $order, $id
        ]);

        set_flash('success', "Event [{$title}] updated successfully!");
        redirect(BASE_URL . '/events/index.php');
    } catch (Exception $e) {
        set_flash('error', 'Error updating event: ' . $e->getMessage());
        redirect(BASE_URL . "/events/edit.php?id={$id}");
    }
}

$pageTitle = "Edit Event: {$event['title']}";
require_once __DIR__ . '/../includes/header.php';
?>

<div class="row">
  <div class="col-lg-9 mx-auto">
    <div class="card card-outline card-warning">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit Event: <?= e($event['title']) ?></h3>
        <span class="badge badge-secondary">ID #<?= $event['id'] ?></span>
      </div>

      <form action="" method="post">
        <?= csrf_field() ?>

        <div class="card-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="eventTitle">Event Title *</label>
                <input type="text" id="eventTitle" name="title" class="form-control" value="<?= e($event['title']) ?>" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="eventSlug">URL Slug</label>
                <input type="text" id="eventSlug" name="slug" class="form-control" value="<?= e($event['slug']) ?>" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="eventCategory">Category *</label>
                <select id="eventCategory" name="category" class="custom-select" required>
                  <option value="Wedding" <?= $event['category'] === 'Wedding' ? 'selected' : '' ?>>Wedding</option>
                  <option value="Corporate" <?= $event['category'] === 'Corporate' ? 'selected' : '' ?>>Corporate</option>
                  <option value="Bespoke" <?= $event['category'] === 'Bespoke' ? 'selected' : '' ?>>Bespoke Celebration</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="eventLocation">Destination / City *</label>
                <input type="text" id="eventLocation" name="location" class="form-control" value="<?= e($event['location']) ?>" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="eventYear">Year</label>
                <input type="text" id="eventYear" name="year" class="form-control" value="<?= e($event['year']) ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="eventClient">Client / Host Family</label>
                <input type="text" id="eventClient" name="client" class="form-control" value="<?= e($event['client']) ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="eventStats">Quick Highlight Stats</label>
                <input type="text" id="eventStats" name="stats" class="form-control" value="<?= e($event['stats']) ?>">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="eventScope">Production Scope</label>
            <input type="text" id="eventScope" name="scope" class="form-control" value="<?= e($event['scope']) ?>" required>
          </div>

          <!-- Cover Image Upload Box -->
          <div class="form-group">
            <label>Cover / Hero Image *</label>
            <div class="cdn-image-box">
              <div class="mb-3 text-center">
                <img id="eventImagePreview" src="<?= e($event['hero_image']) ?>" alt="Preview" class="cdn-thumb-preview" onerror="this.src='https://via.placeholder.com/600x320/121215/d4af37?text=Image+Load+Error'">
              </div>
              <div class="input-group mb-2">
                <input type="text" id="eventImageInput" name="hero_image" class="form-control form-control-sm" value="<?= e($event['hero_image']) ?>" required>
              </div>
              <div class="d-flex align-items-center justify-content-between pt-2 border-top border-light">
                <label class="btn btn-outline-primary btn-sm mb-0 cursor-pointer">
                  <i class="fas fa-cloud-upload-alt mr-1"></i> Replace Image on CDN
                  <input type="file" class="d-none" data-cdn-upload data-target-input="eventImageInput" data-target-preview="eventImagePreview" data-folder="portfolio" accept="image/*">
                </label>
                <div class="upload-status text-xs"></div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="eventSummary">Short Summary (Card Preview) *</label>
            <textarea id="eventSummary" name="summary" class="form-control" rows="3" required><?= e($event['summary']) ?></textarea>
          </div>

          <div class="form-group">
            <label for="eventDesc">Detailed Case Study Description</label>
            <textarea id="eventDesc" name="description" class="form-control" rows="5"><?= e($event['description']) ?></textarea>
          </div>

          <div class="row align-items-center mt-3">
            <div class="col-md-6">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="featuredCheck" name="featured" value="1" <?= $event['featured'] ? 'checked' : '' ?>>
                <label class="custom-control-label text-white" for="featuredCheck">
                  Feature on Home Page Carousel
                </label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-0">
                <label for="displayOrder">Display Order</label>
                <input type="number" id="displayOrder" name="display_order" class="form-control" value="<?= (int)$event['display_order'] ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer bg-light text-dark border-light text-right">
          <a href="<?= BASE_URL ?>/events/index.php" class="btn btn-secondary mr-2">Cancel</a>
          <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save mr-1"></i> Update Event
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
