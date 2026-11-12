<?php
/**
 * Eventure CMS — AdminLTE 3 Main Dashboard
 */
declare(strict_types=1);

$pageTitle = 'Dashboard Overview';
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

<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box bg-dark border border-secondary shadow-sm">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-envelope-open-text text-dark"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Inquiries</span>
        <span class="info-box-number font-weight-bold text-gold"><?= $stats['inquiries'] ?></span>
        <small class="text-warning"><?= $stats['new_leads'] ?> Pending Action</small>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box bg-dark border border-secondary shadow-sm">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-star"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Portfolio Events</span>
        <span class="info-box-number font-weight-bold text-gold"><?= $stats['events'] ?></span>
        <small class="text-muted">Weddings &amp; Summits</small>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box bg-dark border border-secondary shadow-sm">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-photo-video"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Gallery Photos</span>
        <span class="info-box-number font-weight-bold text-gold"><?= $stats['gallery'] ?></span>
        <small class="text-muted">CDN Hosted</small>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box bg-dark border border-secondary shadow-sm">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-layer-group"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Editable Pages</span>
        <span class="info-box-number font-weight-bold text-gold"><?= $stats['pages'] ?></span>
        <small class="text-muted">Segment Controlled</small>
      </div>
    </div>
  </div>
</div>
<!-- /.row -->

<!-- Quick Page Jump Cards -->
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Quick Page Content Editors</h3>
    <small class="text-muted">Click any page to edit its hero, headings, images, cards, and segments</small>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=home" class="btn btn-outline-secondary btn-block text-left py-3 d-flex align-items-center">
          <i class="fas fa-home fa-2x text-gold mr-3"></i>
          <div>
            <strong class="d-block text-white">01 Home</strong>
            <small class="text-muted">Hero, Story, Metrics, CTA</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=weddings" class="btn btn-outline-secondary btn-block text-left py-3 d-flex align-items-center">
          <i class="fas fa-ring fa-2x text-gold mr-3"></i>
          <div>
            <strong class="d-block text-white">02 Weddings</strong>
            <small class="text-muted">Destinations, Services, Process</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=corporate" class="btn btn-outline-secondary btn-block text-left py-3 d-flex align-items-center">
          <i class="fas fa-building fa-2x text-gold mr-3"></i>
          <div>
            <strong class="d-block text-white">03 Corporate</strong>
            <small class="text-muted">Formats, AV Staging, Summits</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=portfolio" class="btn btn-outline-secondary btn-block text-left py-3 d-flex align-items-center">
          <i class="fas fa-briefcase fa-2x text-gold mr-3"></i>
          <div>
            <strong class="d-block text-white">04 Portfolio</strong>
            <small class="text-muted">Header, Showcase Filter, Hero</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=gallery" class="btn btn-outline-secondary btn-block text-left py-3 d-flex align-items-center">
          <i class="fas fa-images fa-2x text-gold mr-3"></i>
          <div>
            <strong class="d-block text-white">05 Gallery</strong>
            <small class="text-muted">Archive Hero &amp; Categories</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=about" class="btn btn-outline-secondary btn-block text-left py-3 d-flex align-items-center">
          <i class="fas fa-landmark fa-2x text-gold mr-3"></i>
          <div>
            <strong class="d-block text-white">06 About</strong>
            <small class="text-muted">Genesis Story, 6 Differences</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/pages/edit.php?slug=contact" class="btn btn-outline-secondary btn-block text-left py-3 d-flex align-items-center">
          <i class="fas fa-paper-plane fa-2x text-gold mr-3"></i>
          <div>
            <strong class="d-block text-white">07 Contact</strong>
            <small class="text-muted">Kolkata Studio, Hours, FAQs</small>
          </div>
        </a>
      </div>
      <div class="col-md-3 col-sm-6 mb-3">
        <a href="<?= BASE_URL ?>/settings/site.php" class="btn btn-outline-secondary btn-block text-left py-3 d-flex align-items-center">
          <i class="fas fa-sliders-h fa-2x text-gold mr-3"></i>
          <div>
            <strong class="d-block text-white">Global Settings</strong>
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
    <div class="card">
      <div class="card-header border-0 d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-inbox mr-2"></i>Recent Event Inquiries</h3>
        <a href="<?= BASE_URL ?>/inquiries/index.php" class="text-gold text-xs font-weight-bold">VIEW ALL LEADS &rarr;</a>
      </div>
      <div class="card-body table-responsive p-0">
        <?php if (empty($recentLeads)): ?>
          <div class="text-center py-5 text-muted">
            <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i>
            <p>No client inquiries received yet.</p>
          </div>
        <?php else: ?>
          <table class="table table-valign-middle">
            <thead>
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
                  <td class="text-gold"><?= e($lead['budget']) ?></td>
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
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cloud-upload-alt mr-2"></i>Quick CDN Uploader</h3>
      </div>
      <div class="card-body">
        <p class="text-muted text-sm">
          Upload images directly to <code>cdn.myeventure.in</code>. It returns a permanent CDN link.
        </p>

        <div class="form-group">
          <label>Target Category</label>
          <select id="quickFolder" class="custom-select">
            <option value="weddings">Weddings (/uploads/weddings/)</option>
            <option value="corporate">Corporate (/uploads/corporate/)</option>
            <option value="gallery">Gallery (/uploads/gallery/)</option>
            <option value="portfolio">Portfolio (/uploads/portfolio/)</option>
            <option value="general" selected>General (/uploads/general/)</option>
          </select>
        </div>

        <div class="cdn-image-box text-center">
          <input type="file" id="quickFileInput" accept="image/*,video/mp4" class="d-none">
          <button type="button" class="btn btn-outline-gold btn-block py-2 mb-2" onclick="document.getElementById('quickFileInput').click()">
            <i class="fas fa-file-upload mr-1"></i> Choose Image or Video
          </button>
          <div id="quickUploadStatus" class="text-xs text-muted">Max size: 50MB &middot; WebP, JPG, PNG, MP4</div>
        </div>

        <div id="quickResultBox" class="mt-3 p-3 bg-dark border border-secondary rounded" style="display:none;">
          <label class="text-xs text-gold">Generated CDN URL:</label>
          <input type="text" id="quickCdnUrl" class="form-control form-control-sm mb-2" readonly>
          <button type="button" class="btn btn-gold btn-sm btn-block" onclick="copyQuickCdnUrl()">
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

  statusEl.innerHTML = '<span class="text-warning"><i class="fas fa-spinner fa-spin mr-1"></i> Uploading to CDN...</span>';

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
