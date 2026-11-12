<?php
/**
 * Eventure CMS — Visual Gallery Photo Manager
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

// Handle Single Photo Add / Fast Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_photo') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Token expired.');
        redirect(BASE_URL . '/gallery/index.php');
    }

    $title    = trim($_POST['title'] ?? 'Eventure Gallery Photo');
    $category = trim($_POST['category'] ?? 'weddings');
    $imageUrl = trim($_POST['image_url'] ?? '');

    if (!empty($imageUrl)) {
        $stmt = $pdo->prepare("INSERT INTO `gallery_photos` (`title`, `category`, `image_url`) VALUES (?, ?, ?)");
        $stmt->execute([$title, $category, $imageUrl]);
        set_flash('success', 'Photo added to gallery archive!');
    }
    redirect(BASE_URL . '/gallery/index.php');
}

// Handle Delete
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    if (verify_csrf_token($_GET['csrf_token'] ?? '')) {
        $stmt = $pdo->prepare("DELETE FROM `gallery_photos` WHERE `id` = ?");
        $stmt->execute([$delId]);
        set_flash('success', 'Photo deleted from archive.');
    }
    redirect(BASE_URL . '/gallery/index.php');
}

// Fetch photos with category filter
$catFilter = trim($_GET['category'] ?? '');
$sql = "SELECT * FROM `gallery_photos`";
$params = [];
if (!empty($catFilter)) {
    $sql .= " WHERE `category` = ?";
    $params[] = $catFilter;
}
$sql .= " ORDER BY `id` DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$photos = $stmt->fetchAll();

$pageTitle = 'Gallery Archive Photos (' . count($photos) . ')';
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Upload New Photo Card -->
<div class="card card-outline card-warning mb-4">
  <div class="card-header">
    <h3 class="card-title text-gold"><i class="fas fa-upload mr-2"></i>Add New Photo to Archive</h3>
  </div>
  <div class="card-body">
    <form action="" method="post">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="add_photo">

      <div class="row align-items-end">
        <div class="col-md-3">
          <div class="form-group mb-md-0">
            <label>Category</label>
            <select name="category" id="galleryUploadCategory" class="custom-select" required>
              <option value="weddings" selected>Weddings</option>
              <option value="corporate">Corporate</option>
              <option value="sangeet">Sangeet</option>
              <option value="decor">Decor &amp; Floral</option>
              <option value="moments">Moments &amp; Rituals</option>
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group mb-md-0">
            <label>Photo Caption / Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Royal Mandap under Chandelier">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group mb-md-0">
            <label>Image URL (or upload)</label>
            <input type="text" id="galleryImageUrl" name="image_url" class="form-control" placeholder="https://cdn..." required>
          </div>
        </div>

        <div class="col-md-2">
          <label class="btn btn-outline-gold btn-block mb-0 cursor-pointer">
            <i class="fas fa-cloud-upload-alt mr-1"></i> Pick File
            <input type="file" class="d-none" data-cdn-upload data-target-input="galleryImageUrl" data-folder="gallery" accept="image/*">
          </label>
        </div>
      </div>

      <div class="mt-3 text-right">
        <button type="submit" class="btn btn-gold btn-sm px-4">
          <i class="fas fa-plus mr-1"></i> Add to Visual Gallery
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Gallery Grid -->
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <h3 class="card-title text-gold mr-3"><i class="fas fa-images mr-2"></i>Archived Photographs</h3>
      <div class="btn-group btn-group-sm">
        <a href="<?= BASE_URL ?>/gallery/index.php" class="btn <?= empty($catFilter) ? 'btn-gold' : 'btn-outline-secondary' ?>">All</a>
        <a href="<?= BASE_URL ?>/gallery/index.php?category=weddings" class="btn <?= $catFilter === 'weddings' ? 'btn-gold' : 'btn-outline-secondary' ?>">Weddings</a>
        <a href="<?= BASE_URL ?>/gallery/index.php?category=corporate" class="btn <?= $catFilter === 'corporate' ? 'btn-gold' : 'btn-outline-secondary' ?>">Corporate</a>
        <a href="<?= BASE_URL ?>/gallery/index.php?category=sangeet" class="btn <?= $catFilter === 'sangeet' ? 'btn-gold' : 'btn-outline-secondary' ?>">Sangeet</a>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="row">
      <?php if (empty($photos)): ?>
        <div class="col-12 text-center py-5 text-muted">
          No photos found in this category.
        </div>
      <?php else: ?>
        <?php foreach ($photos as $ph): ?>
          <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
            <div class="position-relative border border-secondary rounded overflow-hidden shadow-sm bg-dark">
              <img src="<?= e($ph['image_url']) ?>" alt="" style="width: 100%; height: 140px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/200x140/121215/d4af37?text=Image'">
              
              <div class="p-2">
                <span class="badge badge-secondary text-xs text-uppercase mb-1"><?= e($ph['category']) ?></span>
                <p class="text-xs text-truncate mb-2" title="<?= e($ph['title']) ?>"><?= e($ph['title']) ?></p>
                
                <div class="d-flex justify-content-between align-items-center pt-1 border-top border-secondary">
                  <a href="<?= e($ph['image_url']) ?>" target="_blank" class="text-xs text-gold"><i class="fas fa-expand"></i> View</a>
                  <a href="<?= BASE_URL ?>/gallery/index.php?delete=<?= $ph['id'] ?>&csrf_token=<?= csrf_token() ?>" class="text-xs text-danger" onclick="return confirm('Delete this photo?');"><i class="fas fa-trash"></i> Delete</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
