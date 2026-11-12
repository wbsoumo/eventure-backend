<?php
/**
 * Eventure CMS — AdminLTE 3 Main Dashboard (Light Mode)
 */
declare(strict_types=1);

$pageTitle = 'Dashboard';
require_once __DIR__ . '/includes/header.php';

// Fetch quick stats
$stats = [
    'inquiries'  => (int)$pdo->query("SELECT COUNT(*) FROM `enquiries`")->fetchColumn(),
    'new_leads'  => (int)$pdo->query("SELECT COUNT(*) FROM `enquiries` WHERE `status` = 'new'")->fetchColumn(),
    'events'     => (int)$pdo->query("SELECT COUNT(*) FROM `portfolio_events`")->fetchColumn(),
    'gallery'    => (int)$pdo->query("SELECT COUNT(*) FROM `gallery_photos`")->fetchColumn(),
    'pages'      => (int)$pdo->query("SELECT COUNT(*) FROM `pages`")->fetchColumn(),
];

// Fetch recent 5 inquiries
$recentLeads = $pdo->query("SELECT * FROM `enquiries` ORDER BY `id` DESC LIMIT 5")->fetchAll();
?>

<!-- Small boxes (Stat box) - AdminLTE 3 Core Style -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $stats['inquiries'] ?></h3>
        <p>Event Inquiries (<?= $stats['new_leads'] ?> New)</p>
      </div>
      <div class="icon">
        <i class="fas fa-envelope-open-text"></i>
      </div>
      <a href="<?= BASE_URL ?>/inquiries/index.php" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= $stats['events'] ?></h3>
        <p>Portfolio Projects</p>
      </div>
      <div class="icon">
        <i class="fas fa-calendar-check"></i>
      </div>
      <a href="<?= BASE_URL ?>/events/index.php" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?= $stats['gallery'] ?></h3>
        <p>CDN Gallery Photos</p>
      </div>
      <div class="icon">
        <i class="fas fa-images"></i>
      </div>
      <a href="<?= BASE_URL ?>/gallery/index.php" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?= $stats['pages'] ?></h3>
        <p>Editable Pages</p>
      </div>
      <div class="icon">
        <i class="fas fa-layer-group"></i>
      </div>
      <a href="<?= BASE_URL ?>/pages/edit.php?slug=home" class="small-box-footer">
        More info <i class="fas fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
</div>
<!-- /.row -->

<!-- Quick Page Jump Cards -->
<div class="card card-primary card-outline mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title font-weight-bold"><i class="fas fa-edit mr-2 text-primary"></i>Quick Page Content Editors</h3>
    <small class="text-muted">Click any page to edit its hero, headings, CDN images, cards, and segments</small>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=home" class="btn btn-default btn-block text-left p-3 quick-page-card d-flex align-items-center">
          <i class="fas fa-home fa-2x text-primary mr-3"></i>
          <div>
            <strong class="d-block text-dark">01 Home</strong>
            <small class="text-muted">Hero, Story, Metrics, CTA</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=weddings" class="btn btn-default btn-block text-left p-3 quick-page-card d-flex align-items-center">
          <i class="fas fa-ring fa-2x text-danger mr-3"></i>
          <div>
            <strong class="d-block text-dark">02 Weddings</strong>
            <small class="text-muted">Destinations, Services, Process</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=corporate" class="btn btn-default btn-block text-left p-3 quick-page-card d-flex align-items-center">
          <i class="fas fa-building fa-2x text-info mr-3"></i>
          <div>
            <strong class="d-block text-dark">03 Corporate</strong>
            <small class="text-muted">Formats, AV Staging, Summits</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=portfolio" class="btn btn-default btn-block text-left p-3 quick-page-card d-flex align-items-center">
          <i class="fas fa-briefcase fa-2x text-success mr-3"></i>
          <div>
            <strong class="d-block text-dark">04 Portfolio</strong>
            <small class="text-muted">Header, Showcase Filter, Hero</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=gallery" class="btn btn-default btn-block text-left p-3 quick-page-card d-flex align-items-center">
          <i class="fas fa-images fa-2x text-warning mr-3"></i>
          <div>
            <strong class="d-block text-dark">05 Gallery</strong>
            <small class="text-muted">Archive Hero &amp; Categories</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=about" class="btn btn-default btn-block text-left p-3 quick-page-card d-flex align-items-center">
          <i class="fas fa-landmark fa-2x text-secondary mr-3"></i>
          <div>
            <strong class="d-block text-dark">06 About</strong>
            <small class="text-muted">Genesis Story, 6 Differences</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=contact" class="btn btn-default btn-block text-left p-3 quick-page-card d-flex align-items-center">
          <i class="fas fa-paper-plane fa-2x text-primary mr-3"></i>
          <div>
            <strong class="d-block text-dark">07 Contact</strong>
            <small class="text-muted">Kolkata Studio, Hours, FAQs</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/settings/site.php" class="btn btn-default btn-block text-left p-3 quick-page-card d-flex align-items-center">
          <i class="fas fa-sliders-h fa-2x text-dark mr-3"></i>
          <div>
            <strong class="d-block text-dark">Global Settings</strong>
            <small class="text-muted">Logo, Menus, 4-Col Footer</small>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Main Row: Recent Leads & Quick CDN Upload -->
<div class="row">
  <!-- Left Column: Recent Leads -->
  <div class="col-lg-8">
    <div class="card card-primary card-outline">
      <div class="card-header border-0 d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold"><i class="fas fa-inbox mr-2 text-primary"></i>Recent Event Inquiries</h3>
        <a href="<?= BASE_URL ?>/inquiries/index.php" class="text-primary text-sm font-weight-bold">View All Leads &rarr;</a>
      </div>
      <div class="card-body table-responsive p-0">
        <?php if (empty($recentLeads)): ?>
          <div class="text-center py-5 text-muted">
            <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i>
            <p>No client inquiries received yet.</p>
          </div>
        <?php else: ?>
          <table class="table table-hover table-striped">
            <thead class="thead-light">
              <tr>
                <th>Client Name</th>
                <th>Event Type</th>
                <th>Destination</th>
                <th>Budget</th>
                <th>Status</th>
                <th class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentLeads as $lead): ?>
                <tr>
                  <td>
                    <strong><?= e($lead['name']) ?></strong><br>
                    <small class="text-muted"><i class="fas fa-phone-alt mr-1"></i> <?= e($lead['phone']) ?></small>
                  </td>
                  <td><span class="badge badge-secondary"><?= e($lead['event_type']) ?></span></td>
                  <td><?= e($lead['city'] ?: 'Kolkata') ?></td>
                  <td class="font-weight-bold text-dark"><?= e($lead['budget']) ?></td>
                  <td>
                    <?php if ($lead['status'] === 'new'): ?>
                      <span class="badge badge-warning">New</span>
                    <?php elseif ($lead['status'] === 'contacted'): ?>
                      <span class="badge badge-info">Contacted</span>
                    <?php else: ?>
                      <span class="badge badge-success"><?= ucfirst(e($lead['status'])) ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="text-right">
                    <?php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $lead['phone']);
                    $waMsg = urlencode("Hello {$lead['name']}, this is Eventure Kolkata. Thank you for your inquiry regarding {$lead['event_type']}. We would love to discuss your vision.");
                    ?>
                    <a href="https://wa.me/<?= $cleanPhone ?>?text=<?= $waMsg ?>" target="_blank" class="btn btn-sm btn-success rounded-pill px-3" title="Chat on WhatsApp">
                      <i class="fab fa-whatsapp mr-1"></i> WhatsApp
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Right Column: Quick CDN Uploader Widget -->
  <div class="col-lg-4">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title font-weight-bold"><i class="fas fa-cloud-upload-alt mr-2 text-primary"></i>Quick CDN Uploader</h3>
      </div>
      <div class="card-body">
        <p class="text-muted text-sm">
          Upload media directly to <code>cdn.myeventure.in</code>. Generates permanent CDN links.
        </p>

        <div class="form-group">
          <label>Target Category</label>
          <select id="quickFolder" class="custom-select">
            <option value="weddings">Weddings (/uploads/weddings/)</option>
            <option value="corporate">Corporate (/uploads/corporate/)</option>
            <option value="gallery">Gallery (/uploads/gallery/)</option>
            <option value="portfolio">Portfolio (/uploads/portfolio/)</option>
            <option value="logos">Logos (/uploads/logos/)</option>
            <option value="general" selected>General (/uploads/general/)</option>
          </select>
        </div>

        <div class="cdn-image-box text-center">
          <input type="file" id="quickFileInput" accept="image/*,video/mp4" class="d-none">
          <button type="button" class="btn btn-primary btn-block py-2 mb-2" onclick="document.getElementById('quickFileInput').click()">
            <i class="fas fa-file-upload mr-1"></i> Choose Image or Video
          </button>
          <div id="quickUploadStatus" class="text-xs text-muted">Max size: 50MB &middot; WebP, JPG, PNG, MP4</div>
        </div>

        <div id="quickResultBox" class="mt-3 p-3 bg-light border rounded" style="display:none;">
          <label class="text-xs text-primary font-weight-bold">Generated CDN URL:</label>
          <input type="text" id="quickCdnUrl" class="form-control form-control-sm mb-2" readonly>
          <button type="button" class="btn btn-success btn-sm btn-block" onclick="copyQuickCdnUrl()">
            <i class="far fa-copy mr-1"></i> Copy URL to Clipboard
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('quickFileInput')?.addEventListener('change', async (e) => {
  const file = e.target.files[0];
  if (!file) return;

  const folder = document.getElementById('quickFolder').value;
  const statusEl = document.getElementById('quickUploadStatus');
  const resultBox = document.getElementById('quickResultBox');
  const urlInput = document.getElementById('quickCdnUrl');

  statusEl.innerHTML = '<span class="text-primary"><i class="fas fa-spinner fa-spin mr-1"></i> Uploading to CDN...</span>';

  const formData = new FormData();
  formData.append('file', file);
  formData.append('folder', folder);
  formData.append('api_key', 'eventure_secret_cdn_key_9748328654');

  try {
    const res = await fetch('https://cdn.myeventure.in/upload.php', {
      method: 'POST',
      body: formData
    });
    const data = await res.json();
    if (data.success && data.url) {
      statusEl.innerHTML = '<span class="text-success"><i class="fas fa-check-circle mr-1"></i> Upload Complete!</span>';
      urlInput.value = data.url;
      resultBox.style.display = 'block';
    } else {
      throw new Error(data.error || 'Upload failed');
    }
  } catch (err) {
    statusEl.innerHTML = `<span class="text-danger"><i class="fas fa-times-circle mr-1"></i> ${err.message}</span>`;
  }
});

function copyQuickCdnUrl() {
  const copyText = document.getElementById('quickCdnUrl');
  copyText.select();
  document.execCommand('copy');
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: 'CDN URL copied to clipboard!',
    showConfirmButton: false,
    timer: 2000
  });
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
