<?php
/**
 * Eventure CMS — Header Navigation & Menu Manager
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

// Handle Add Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_item') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Token expired.');
        redirect(BASE_URL . '/settings/navigation.php');
    }

    $name   = trim($_POST['name'] ?? '');
    $path   = trim($_POST['path'] ?? '/');
    $prefix = trim($_POST['num_prefix'] ?? '');
    $order  = (int)($_POST['display_order'] ?? 0);

    if (!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO `nav_items` (`name`, `path`, `num_prefix`, `display_order`, `is_active`) VALUES (?, ?, ?, ?, 1)");
        $stmt->execute([$name, $path, $prefix, $order]);
        set_flash('success', "Nav item [{$name}] added.");
    }
    redirect(BASE_URL . '/settings/navigation.php');
}

// Handle Update Items
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_all') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Token expired.');
        redirect(BASE_URL . '/settings/navigation.php');
    }

    $items = $_POST['items'] ?? [];
    $updateStmt = $pdo->prepare("UPDATE `nav_items` SET `name` = ?, `path` = ?, `num_prefix` = ?, `display_order` = ?, `is_active` = ? WHERE `id` = ?");

    foreach ($items as $id => $data) {
        $isActive = isset($data['is_active']) ? 1 : 0;
        $updateStmt->execute([
            trim($data['name'] ?? ''),
            trim($data['path'] ?? ''),
            trim($data['num_prefix'] ?? ''),
            (int)($data['display_order'] ?? 0),
            $isActive,
            (int)$id
        ]);
    }

    set_flash('success', 'Header navigation updated successfully!');
    redirect(BASE_URL . '/settings/navigation.php');
}

// Handle Delete Item
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    if (verify_csrf_token($_GET['csrf_token'] ?? '')) {
        $stmt = $pdo->prepare("DELETE FROM `nav_items` WHERE `id` = ?");
        $stmt->execute([$delId]);
        set_flash('success', 'Menu item deleted.');
    }
    redirect(BASE_URL . '/settings/navigation.php');
}

// Fetch all nav items
$items = $pdo->query("SELECT * FROM `nav_items` ORDER BY `display_order` ASC, `id` ASC")->fetchAll();

$pageTitle = 'Header Navigation & Menubar';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="row">
  <div class="col-lg-8">
    <div class="card card-outline card-warning">
      <div class="card-header">
        <h3 class="card-title text-gold font-weight-bold">
          <i class="fas fa-compass mr-2"></i>Header Navigation Menu Items
        </h3>
      </div>

      <form action="" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="update_all">

        <div class="card-body p-0 table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="width: 70px;">Prefix</th>
                <th>Menu Label</th>
                <th>Link Path / URL</th>
                <th style="width: 90px;">Order</th>
                <th style="width: 80px;">Active</th>
                <th style="width: 50px;"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item): ?>
                <tr>
                  <td>
                    <input type="text" name="items[<?= $item['id'] ?>][num_prefix]" class="form-control form-control-sm text-center font-weight-bold text-gold" value="<?= e($item['num_prefix']) ?>">
                  </td>
                  <td>
                    <input type="text" name="items[<?= $item['id'] ?>][name]" class="form-control form-control-sm font-weight-bold" value="<?= e($item['name']) ?>" required>
                  </td>
                  <td>
                    <input type="text" name="items[<?= $item['id'] ?>][path]" class="form-control form-control-sm" value="<?= e($item['path']) ?>" required>
                  </td>
                  <td>
                    <input type="number" name="items[<?= $item['id'] ?>][display_order]" class="form-control form-control-sm text-center" value="<?= (int)$item['display_order'] ?>">
                  </td>
                  <td class="text-center">
                    <input type="checkbox" name="items[<?= $item['id'] ?>][is_active]" value="1" <?= $item['is_active'] ? 'checked' : '' ?>>
                  </td>
                  <td>
                    <a href="<?= BASE_URL ?>/settings/navigation.php?delete=<?= $item['id'] ?>&csrf_token=<?= csrf_token() ?>" class="text-danger" onclick="return confirm('Delete this menu item?');">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="card-footer bg-dark border-secondary text-right">
          <button type="submit" class="btn btn-gold btn-sm px-4">
            <i class="fas fa-save mr-1"></i> Save Menu Ordering &amp; Labels
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Add New Menu Item -->
  <div class="col-lg-4">
    <div class="card card-outline card-secondary">
      <div class="card-header">
        <h3 class="card-title text-gold font-weight-bold"><i class="fas fa-plus-circle mr-1"></i>Add Menu Item</h3>
      </div>
      <form action="" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="add_item">

        <div class="card-body">
          <div class="form-group">
            <label for="numPrefix">Prefix (e.g. 08)</label>
            <input type="text" id="numPrefix" name="num_prefix" class="form-control" placeholder="08">
          </div>

          <div class="form-group">
            <label for="itemName">Menu Name *</label>
            <input type="text" id="itemName" name="name" class="form-control" placeholder="e.g. Experiences" required>
          </div>

          <div class="form-group">
            <label for="itemPath">Target Path / URL *</label>
            <input type="text" id="itemPath" name="path" class="form-control" placeholder="/experiences" required>
          </div>

          <div class="form-group">
            <label for="itemOrder">Display Order</label>
            <input type="number" id="itemOrder" name="display_order" class="form-control" value="8">
          </div>
        </div>

        <div class="card-footer bg-dark border-secondary">
          <button type="submit" class="btn btn-outline-gold btn-block btn-sm">
            <i class="fas fa-plus mr-1"></i> Add to Menu
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
