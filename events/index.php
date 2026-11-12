<?php
/**
 * Eventure CMS — All Events / Portfolio Projects List
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

$category = trim($_GET['category'] ?? '');
$sql = "SELECT * FROM `portfolio_events`";
$params = [];

if (!empty($category)) {
    $sql .= " WHERE `category` = ?";
    $params[] = $category;
}
$sql .= " ORDER BY `display_order` ASC, `id` DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll();

$pageTitle = 'Portfolio Events';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <h3 class="card-title text-gold mr-3"><i class="fas fa-calendar-star mr-2"></i>Signature Projects</h3>
      <!-- Category Filter -->
      <div class="btn-group btn-group-sm">
        <a href="<?= BASE_URL ?>/events/index.php" class="btn <?= empty($category) ? 'btn-gold' : 'btn-outline-secondary' ?>">All</a>
        <a href="<?= BASE_URL ?>/events/index.php?category=Wedding" class="btn <?= $category === 'Wedding' ? 'btn-gold' : 'btn-outline-secondary' ?>">Weddings</a>
        <a href="<?= BASE_URL ?>/events/index.php?category=Corporate" class="btn <?= $category === 'Corporate' ? 'btn-gold' : 'btn-outline-secondary' ?>">Corporate</a>
      </div>
    </div>
    <div>
      <a href="<?= BASE_URL ?>/events/create.php" class="btn btn-gold btn-sm">
        <i class="fas fa-plus mr-1"></i> Add New Event
      </a>
    </div>
  </div>

  <div class="card-body table-responsive p-0">
    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th style="width: 70px;">Cover</th>
          <th>Event Title</th>
          <th>Category</th>
          <th>Location</th>
          <th>Client &amp; Year</th>
          <th>Order</th>
          <th class="text-right" style="width: 140px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($events)): ?>
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">
              No events found in this category. Click "+ Add New Event" to create one.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($events as $ev): ?>
            <tr>
              <td>
                <img src="<?= e($ev['hero_image']) ?>" alt="" style="width: 60px; height: 42px; object-fit: cover; border-radius: 6px; border: 1px solid #2c2c31;" onerror="this.src='https://via.placeholder.com/60x42/121215/d4af37?text=Image'">
              </td>
              <td>
                <strong><?= e($ev['title']) ?></strong>
                <?php if ($ev['featured']): ?>
                  <span class="badge badge-warning text-dark ml-1"><i class="fas fa-star"></i> Featured</span>
                <?php endif; ?>
                <br>
                <small class="text-muted"><?= e($ev['slug']) ?></small>
              </td>
              <td>
                <span class="badge <?= $ev['category'] === 'Wedding' ? 'badge-primary' : 'badge-info' ?>">
                  <?= e($ev['category']) ?>
                </span>
              </td>
              <td><i class="fas fa-map-marker-alt text-gold mr-1"></i> <?= e($ev['location']) ?></td>
              <td>
                <?= e($ev['client'] ?: '—') ?>
                <small class="text-muted d-block"><?= e($ev['year']) ?></small>
              </td>
              <td><?= (int)$ev['display_order'] ?></td>
              <td class="text-right">
                <a href="<?= BASE_URL ?>/events/edit.php?id=<?= $ev['id'] ?>" class="btn btn-sm btn-outline-warning mr-1" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="<?= BASE_URL ?>/events/delete.php?id=<?= $ev['id'] ?>&csrf_token=<?= csrf_token() ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this event?');">
                  <i class="fas fa-trash-alt"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
