<?php
/**
 * Eventure CMS — Create New Event / Portfolio Project
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Security token expired.');
        redirect(BASE_URL . '/events/create.php');
    }

    $title     = trim($_POST['title'] ?? '');
    $slug      = trim($_POST['slug'] ?? '') ?: slugify($title);
    $category  = trim($_POST['category'] ?? 'Wedding');
    $client    = trim($_POST['client'] ?? '');
    $year      = trim($_POST['year'] ?? date('Y'));
    $location  = trim($_POST['location'] ?? 'Kolkata');
    $scope     = trim($_POST['scope'] ?? '');
    $stats     = trim($_POST['stats'] ?? '');
    $heroImage = trim($_POST['hero_image'] ?? '');
    $summary   = trim($_POST['summary'] ?? '');
    $desc      = trim($_POST['description'] ?? '');
    $featured  = isset($_POST['featured']) ? 1 : 0;
    $order     = (int)($_POST['display_order'] ?? 0);

    if (empty($title) || empty($heroImage)) {
        set_flash('error', 'Event title and cover image are required.');
        redirect(BASE_URL . '/events/create.php');
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO `portfolio_events` 
                (`title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `summary`, `description`, `featured`, `display_order`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $title, $slug, $category, $client, $year, $location, $scope, $stats, $heroImage, $summary, $desc, $featured, $order
        ]);

        set_flash('success', 'Event project created successfully!');
        redirect(BASE_URL . '/events/index.php');
    } catch (Exception $e) {
        set_flash('error', 'Error creating event: ' . $e->getMessage());
        redirect(BASE_URL . '/events/create.php');
    }
}

$pageTitle = 'Add New Event';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="row">
  <div class="col-lg-9 mx-auto">
    <div class="card card-outline card-warning">
      <div class="card-header">
        <h3 class="card-title text-gold font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Create Event Showcase</h3>
      </div>

      <form action="" method="post">
        <?= csrf_field() ?>

        <div class="card-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="eventTitle">Event Title *</label>
                <input type="text" id="eventTitle" name="title" class="form-control" placeholder="e.g. Palatial Heritage Wedding" required oninput="document.getElementById('eventSlug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '')">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="eventSlug">URL Slug</label>
                <input type="text" id="eventSlug" name="slug" class="form-control" placeholder="palatial-heritage-wedding">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="eventCategory">Category *</label>
                <select id="eventCategory" name="category" class="custom-select" required>
                  <option value="Wedding" selected>Wedding</option>
                  <option value="Corporate">Corporate</option>
                  <option value="Bespoke">Bespoke Celebration</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="eventLocation">Destination / City *</label>
                <input type="text" id="eventLocation" name="location" class="form-control" placeholder="e.g. Udaipur &amp; Kolkata" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="eventYear">Year</label>
                <input type="text" id="eventYear" name="year" class="form-control" value="<?= date('Y') ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="eventClient">Client / Host Family</label>
                <input type="text" id="eventClient" name="client" class="form-control" placeholder="e.g. Private Royal Family / Zee Media">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="eventStats">Quick Highlight Stats</label>
                <input type="text" id="eventStats" name="stats" class="form-control" placeholder="e.g. 3 Days · 450 Guests · Palace Takeover">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="eventScope">Production Scope</label>
            <input type="text" id="eventScope" name="scope" class="form-control" placeholder="e.g. Creative Direction, Kinetic Stage, AV Rigging, VIP Hospitality" required>
          </div>

          <!-- Cover Image Upload Box -->
          <div class="form-group">
            <label>Cover / Hero Image *</label>
            <div class="cdn-image-box">
              <div class="mb-3 text-center">
                <img id="eventImagePreview" src="https://via.placeholder.com/600x320/121215/d4af37?text=No+Cover+Image+Selected" alt="Preview" class="cdn-thumb-preview">
              </div>
              <div class="input-group mb-2">
                <input type="text" id="eventImageInput" name="hero_image" class="form-control form-control-sm" placeholder="Paste image URL or use uploader below" required>
              </div>
              <div class="d-flex align-items-center justify-content-between pt-2 border-top border-secondary">
                <label class="btn btn-outline-gold btn-sm mb-0 cursor-pointer">
                  <i class="fas fa-cloud-upload-alt mr-1"></i> Upload Image to CDN
                  <input type="file" class="d-none" data-cdn-upload data-target-input="eventImageInput" data-target-preview="eventImagePreview" data-folder="portfolio" accept="image/*">
                </label>
                <div class="upload-status text-xs"></div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="eventSummary">Short Summary (Card Preview) *</label>
            <textarea id="eventSummary" name="summary" class="form-control" rows="3" placeholder="Brief 2-line description of the event..." required></textarea>
          </div>

          <div class="form-group">
            <label for="eventDesc">Detailed Case Study Description</label>
            <textarea id="eventDesc" name="description" class="form-control" rows="5" placeholder="Full story, technical challenges, and execution highlights..."></textarea>
          </div>

          <div class="row align-items-center mt-3">
            <div class="col-md-6">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="featuredCheck" name="featured" value="1">
                <label class="custom-control-label text-white" for="featuredCheck">
                  Feature on Home Page Carousel
                </label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-0">
                <label for="displayOrder">Display Order</label>
                <input type="number" id="displayOrder" name="display_order" class="form-control" value="0">
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer bg-dark border-secondary text-right">
          <a href="<?= BASE_URL ?>/events/index.php" class="btn btn-secondary mr-2">Cancel</a>
          <button type="submit" class="btn btn-gold px-4">
            <i class="fas fa-check mr-1"></i> Create Project
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
