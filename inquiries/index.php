<?php
/**
 * Eventure CMS — Leads & Inquiries Manager
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

// Handle Status / Notes Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Token expired.');
        redirect(BASE_URL . '/inquiries/index.php');
    }

    $inquiryId = (int)($_POST['inquiry_id'] ?? 0);
    $newStatus = trim($_POST['status'] ?? 'new');
    $notes     = trim($_POST['notes'] ?? '');

    $stmt = $pdo->prepare("UPDATE `enquiries` SET `status` = ?, `notes` = ? WHERE `id` = ?");
    $stmt->execute([$newStatus, $notes, $inquiryId]);

    set_flash('success', "Lead #{$inquiryId} updated to [{$newStatus}].");
    redirect(BASE_URL . '/inquiries/index.php');
}

// Handle Delete Inquiry
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    if (verify_csrf_token($_GET['csrf_token'] ?? '')) {
        $stmt = $pdo->prepare("DELETE FROM `enquiries` WHERE `id` = ?");
        $stmt->execute([$delId]);
        set_flash('success', 'Lead record deleted.');
    }
    redirect(BASE_URL . '/inquiries/index.php');
}

// Handle CSV Export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=eventure-leads-' . date('Y-m-d') . '.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Date', 'Name', 'Phone', 'Email', 'Event Type', 'City', 'Target Date', 'Guests', 'Budget', 'Status', 'Message', 'Notes']);

    $all = $pdo->query("SELECT * FROM `enquiries` ORDER BY `id` DESC")->fetchAll();
    foreach ($all as $r) {
        fputcsv($output, [
            $r['id'], $r['created_at'], $r['name'], $r['phone'], $r['email'],
            $r['event_type'], $r['city'], $r['target_date'], $r['guests'],
            $r['budget'], $r['status'], $r['message'], $r['notes']
        ]);
    }
    fclose($output);
    exit;
}

// Filter inquiries by status
$statusFilter = trim($_GET['status'] ?? '');
$sql = "SELECT * FROM `enquiries`";
$params = [];
if (!empty($statusFilter)) {
    $sql .= " WHERE `status` = ?";
    $params[] = $statusFilter;
}
$sql .= " ORDER BY `id` DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$leads = $stmt->fetchAll();

$pageTitle = 'Leads & Inquiries (' . count($leads) . ')';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="card card-outline card-warning">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <h3 class="card-title text-primary mr-3"><i class="fas fa-inbox mr-2"></i>Event Inquiries Inbox</h3>
      <div class="btn-group btn-group-sm">
        <a href="<?= BASE_URL ?>/inquiries/index.php" class="btn <?= empty($statusFilter) ? 'btn-primary' : 'btn-outline-secondary' ?>">All</a>
        <a href="<?= BASE_URL ?>/inquiries/index.php?status=new" class="btn <?= $statusFilter === 'new' ? 'btn-primary' : 'btn-outline-secondary' ?>">New</a>
        <a href="<?= BASE_URL ?>/inquiries/index.php?status=contacted" class="btn <?= $statusFilter === 'contacted' ? 'btn-primary' : 'btn-outline-secondary' ?>">Contacted</a>
        <a href="<?= BASE_URL ?>/inquiries/index.php?status=booked" class="btn <?= $statusFilter === 'booked' ? 'btn-primary' : 'btn-outline-secondary' ?>">Booked</a>
      </div>
    </div>
    <div>
      <a href="<?= BASE_URL ?>/inquiries/index.php?export=csv" class="btn btn-sm btn-outline-success">
        <i class="fas fa-file-csv mr-1"></i> Export CSV
      </a>
    </div>
  </div>

  <div class="card-body p-0 table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Client &amp; Contact</th>
          <th>Event Details</th>
          <th>Destination &amp; Date</th>
          <th>Budget</th>
          <th>Status</th>
          <th class="text-right" style="width: 200px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($leads)): ?>
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              <i class="fas fa-envelope-open fa-3x mb-2 text-secondary"></i>
              <p>No leads found in this view.</p>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($leads as $l): ?>
            <tr>
              <td>
                <strong class="text-white"><?= e($l['name']) ?></strong><br>
                <small class="text-primary"><i class="fas fa-phone mr-1"></i><?= e($l['phone']) ?></small><br>
                <small class="text-muted"><i class="fas fa-envelope mr-1"></i><?= e($l['email']) ?></small>
              </td>
              <td>
                <span class="badge badge-secondary"><?= e($l['event_type']) ?></span>
                <?php if ($l['guests']): ?>
                  <small class="d-block text-muted mt-1"><i class="fas fa-users mr-1"></i> <?= e($l['guests']) ?> Guests</small>
                <?php endif; ?>
              </td>
              <td>
                <i class="fas fa-map-marker-alt text-warning mr-1"></i> <?= e($l['city'] ?: 'Kolkata') ?><br>
                <small class="text-muted"><i class="far fa-calendar-alt mr-1"></i> <?= e($l['target_date'] ?: 'Flexible') ?></small>
              </td>
              <td class="text-primary font-weight-bold">
                <?= e($l['budget'] ?: 'TBD') ?>
              </td>
              <td>
                <?php if ($l['status'] === 'new'): ?>
                  <span class="badge badge-warning">New Lead</span>
                <?php elseif ($l['status'] === 'contacted'): ?>
                  <span class="badge badge-info">Contacted</span>
                <?php elseif ($l['status'] === 'booked'): ?>
                  <span class="badge badge-success">Booked</span>
                <?php else: ?>
                  <span class="badge badge-secondary"><?= ucfirst(e($l['status'])) ?></span>
                <?php endif; ?>
                <br>
                <small class="text-muted"><?= date('M j, Y', strtotime($l['created_at'])) ?></small>
              </td>
              <td class="text-right">
                <?php
                $cleanPhone = preg_replace('/[^0-9]/', '', $l['phone']);
                $waMsg = urlencode("Hello {$l['name']}, this is Eventure Kolkata. Thank you for your inquiry for {$l['event_type']}. We are reviewing your brief and would love to schedule a consultation with our senior planners.");
                ?>
                <a href="https://wa.me/<?= $cleanPhone ?>?text=<?= $waMsg ?>" target="_blank" class="btn btn-sm btn-success rounded-pill px-2 mr-1" title="Reply on WhatsApp">
                  <i class="fab fa-whatsapp"></i> Chat
                </a>

                <!-- View & Update Modal Trigger -->
                <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-2 mr-1" data-toggle="modal" data-target="#leadModal<?= $l['id'] ?>">
                  <i class="fas fa-eye"></i> Details
                </button>

                <a href="<?= BASE_URL ?>/inquiries/index.php?delete=<?= $l['id'] ?>&csrf_token=<?= csrf_token() ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2" onclick="return confirm('Delete lead record?');">
                  <i class="fas fa-trash"></i>
                </a>

                <!-- Modal for Lead Details & Status Change -->
                <div class="modal fade text-left" id="leadModal<?= $l['id'] ?>" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content bg-light text-dark border-light">
                      <div class="modal-header border-light">
                        <h5 class="modal-title text-primary font-weight-bold">
                          <i class="fas fa-briefcase mr-2"></i>Event Brief: <?= e($l['name']) ?>
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                      </div>
                      <form action="" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="inquiry_id" value="<?= $l['id'] ?>">

                        <div class="modal-body">
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label>Client</label>
                              <p class="text-white font-weight-bold"><?= e($l['name']) ?> (<?= e($l['phone']) ?> &middot; <?= e($l['email']) ?>)</p>
                            </div>
                            <div class="col-md-6">
                              <label>Event Type &amp; Budget</label>
                              <p class="text-white"><?= e($l['event_type']) ?> &mdash; <span class="text-primary"><?= e($l['budget']) ?></span></p>
                            </div>
                            <div class="col-md-6">
                              <label>Destination &amp; Date</label>
                              <p class="text-white"><?= e($l['city'] ?: 'Kolkata') ?> (Date: <?= e($l['target_date'] ?: 'Flexible') ?>, Guests: <?= e($l['guests'] ?: 'TBD') ?>)</p>
                            </div>
                            <div class="col-md-6">
                              <label>Submission Timestamp</label>
                              <p class="text-muted"><?= date('F j, Y, g:i a', strtotime($l['created_at'])) ?></p>
                            </div>
                          </div>

                          <div class="form-group">
                            <label>Client's Notes &amp; Message</label>
                            <div class="p-3 bg-black border border-light rounded text-sm text-white">
                              <?= nl2br(e($l['message'] ?: 'No additional notes provided.')) ?>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="leadStatus<?= $l['id'] ?>">Lead Status</label>
                                <select id="leadStatus<?= $l['id'] ?>" name="status" class="custom-select">
                                  <option value="new" <?= $l['status'] === 'new' ? 'selected' : '' ?>>New</option>
                                  <option value="contacted" <?= $l['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                                  <option value="in_discussion" <?= $l['status'] === 'in_discussion' ? 'selected' : '' ?>>In Discussion</option>
                                  <option value="booked" <?= $l['status'] === 'booked' ? 'selected' : '' ?>>Booked / Confirmed</option>
                                  <option value="closed" <?= $l['status'] === 'closed' ? 'selected' : '' ?>>Closed / Not a Fit</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-8">
                              <div class="form-group">
                                <label for="leadNotes<?= $l['id'] ?>">Internal Staff Notes</label>
                                <input type="text" id="leadNotes<?= $l['id'] ?>" name="notes" class="form-control" value="<?= e($l['notes'] ?? '') ?>" placeholder="e.g. Call scheduled for tomorrow 4 PM">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer border-light">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save Status &amp; Notes</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- /.modal -->

              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
