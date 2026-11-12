<?php
/**
 * Eventure CMS — Frequently Asked Questions (FAQ) Manager
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

// Handle Add FAQ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_faq') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Token expired.');
        redirect(BASE_URL . '/settings/faqs.php');
    }

    $q = trim($_POST['question'] ?? '');
    $a = trim($_POST['answer'] ?? '');
    $c = trim($_POST['category'] ?? 'general');
    $o = (int)($_POST['display_order'] ?? 0);

    if (!empty($q) && !empty($a)) {
        $stmt = $pdo->prepare("INSERT INTO `faqs` (`category`, `question`, `answer`, `display_order`) VALUES (?, ?, ?, ?)");
        $stmt->execute([$c, $q, $a, $o]);
        set_flash('success', 'FAQ added successfully!');
    }
    redirect(BASE_URL . '/settings/faqs.php');
}

// Handle Delete FAQ
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    if (verify_csrf_token($_GET['csrf_token'] ?? '')) {
        $stmt = $pdo->prepare("DELETE FROM `faqs` WHERE `id` = ?");
        $stmt->execute([$delId]);
        set_flash('success', 'FAQ item deleted.');
    }
    redirect(BASE_URL . '/settings/faqs.php');
}

$faqs = $pdo->query("SELECT * FROM `faqs` ORDER BY `display_order` ASC, `id` ASC")->fetchAll();

$pageTitle = 'FAQs Manager';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="row">
  <div class="col-lg-8">
    <div class="card card-outline card-warning">
      <div class="card-header">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-question-circle mr-2"></i>Frequently Asked Questions</h3>
      </div>
      <div class="card-body p-0 table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="width: 50px;">Order</th>
              <th>Question &amp; Answer</th>
              <th style="width: 110px;">Category</th>
              <th style="width: 60px;" class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($faqs as $f): ?>
              <tr>
                <td class="text-center font-weight-bold"><?= (int)$f['display_order'] ?></td>
                <td>
                  <strong class="text-white d-block mb-1"><?= e($f['question']) ?></strong>
                  <p class="text-muted text-sm mb-0"><?= e($f['answer']) ?></p>
                </td>
                <td><span class="badge badge-secondary"><?= e($f['category']) ?></span></td>
                <td class="text-right">
                  <a href="<?= BASE_URL ?>/settings/faqs.php?delete=<?= $f['id'] ?>&csrf_token=<?= csrf_token() ?>" class="text-danger" onclick="return confirm('Delete this FAQ?');">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card card-outline card-secondary">
      <div class="card-header">
        <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-plus mr-1"></i>Add New Question</h3>
      </div>
      <form action="" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="add_faq">

        <div class="card-body">
          <div class="form-group">
            <label for="faqCategory">Category</label>
            <select id="faqCategory" name="category" class="custom-select">
              <option value="general" selected>General</option>
              <option value="weddings">Weddings</option>
              <option value="corporate">Corporate</option>
              <option value="enquiries">Enquiries</option>
            </select>
          </div>

          <div class="form-group">
            <label for="faqQuestion">Question *</label>
            <input type="text" id="faqQuestion" name="question" class="form-control" placeholder="e.g. Which cities do you operate in?" required>
          </div>

          <div class="form-group">
            <label for="faqAnswer">Answer *</label>
            <textarea id="faqAnswer" name="answer" class="form-control" rows="4" placeholder="Detailed answer..." required></textarea>
          </div>

          <div class="form-group">
            <label for="faqOrder">Display Order</label>
            <input type="number" id="faqOrder" name="display_order" class="form-control" value="0">
          </div>
        </div>

        <div class="card-footer bg-light text-dark border-light">
          <button type="submit" class="btn btn-outline-primary btn-block btn-sm">
            <i class="fas fa-check mr-1"></i> Save FAQ
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
