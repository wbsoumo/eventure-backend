<?php
/**
 * Eventure CMS — Global Site & Footer Settings Editor
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

// Fetch current settings
$stmt = $pdo->query("SELECT * FROM `site_settings` WHERE `id` = 1");
$settings = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Token expired.');
        redirect(BASE_URL . '/settings/site.php');
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE `site_settings` SET
                `site_name`           = ?,
                `legal_name`          = ?,
                `tagline`             = ?,
                `logo_url`            = ?,
                `phone`               = ?,
                `phone_raw`           = ?,
                `whatsapp`            = ?,
                `email`               = ?,
                `address_street`      = ?,
                `address_locality`    = ?,
                `address_city`        = ?,
                `address_region`      = ?,
                `address_postal_code` = ?,
                `opening_hours`       = ?,
                `instagram_url`       = ?,
                `facebook_url`        = ?,
                `linkedin_url`        = ?,
                `youtube_url`         = ?,
                `footer_brand_text`   = ?,
                `footer_tagline`      = ?,
                `footer_copyright`    = ?,
                `meta_title`          = ?,
                `meta_description`    = ?
            WHERE `id` = 1
        ");

        $stmt->execute([
            trim($_POST['site_name'] ?? 'Eventure'),
            trim($_POST['legal_name'] ?? 'Eventure Experiences LLP'),
            trim($_POST['tagline'] ?? ''),
            trim($_POST['logo_url'] ?? ''),
            trim($_POST['phone'] ?? ''),
            trim($_POST['phone_raw'] ?? ''),
            trim($_POST['whatsapp'] ?? ''),
            trim($_POST['email'] ?? ''),
            trim($_POST['address_street'] ?? ''),
            trim($_POST['address_locality'] ?? ''),
            trim($_POST['address_city'] ?? 'Kolkata'),
            trim($_POST['address_region'] ?? 'West Bengal'),
            trim($_POST['address_postal_code'] ?? '700091'),
            trim($_POST['opening_hours'] ?? ''),
            trim($_POST['instagram_url'] ?? ''),
            trim($_POST['facebook_url'] ?? ''),
            trim($_POST['linkedin_url'] ?? ''),
            trim($_POST['youtube_url'] ?? ''),
            trim($_POST['footer_brand_text'] ?? ''),
            trim($_POST['footer_tagline'] ?? ''),
            trim($_POST['footer_copyright'] ?? ''),
            trim($_POST['meta_title'] ?? ''),
            trim($_POST['meta_description'] ?? '')
        ]);

        set_flash('success', 'Global site settings and footer updated successfully!');
        redirect(BASE_URL . '/settings/site.php');
    } catch (Exception $e) {
        set_flash('error', 'Update error: ' . $e->getMessage());
        redirect(BASE_URL . '/settings/site.php');
    }
}

$pageTitle = 'Global Site & Footer Settings';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="row">
  <div class="col-lg-10 mx-auto">
    <div class="card card-outline card-warning">
      <div class="card-header">
        <h3 class="card-title text-gold font-weight-bold">
          <i class="fas fa-sliders-h mr-2"></i>Global Website &amp; Footer Configuration
        </h3>
      </div>

      <form action="" method="post">
        <?= csrf_field() ?>

        <div class="card-body">
          <!-- 1. BRAND IDENTITY -->
          <h5 class="text-gold border-bottom border-secondary pb-2 mb-3">
            <i class="fas fa-gem mr-2"></i>1. Brand Identity &amp; Logo
          </h5>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="siteName">Brand Name</label>
                <input type="text" id="siteName" name="site_name" class="form-control" value="<?= e($settings['site_name']) ?>" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="legalName">Legal Entity Name</label>
                <input type="text" id="legalName" name="legal_name" class="form-control" value="<?= e($settings['legal_name']) ?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="tagline">Global Tagline</label>
                <input type="text" id="tagline" name="tagline" class="form-control" value="<?= e($settings['tagline']) ?>">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Header Brand Logo (SVG or PNG)</label>
                <div class="cdn-image-box">
                  <div class="mb-2 text-center bg-black p-2 rounded">
                    <img id="logoPreview" src="<?= e($settings['logo_url']) ?>" alt="Logo Preview" style="max-height: 50px;" class="mx-auto" onerror="this.src='/logos/eventure-logo.svg'">
                  </div>
                  <div class="input-group mb-2">
                    <input type="text" id="logoUrlInput" name="logo_url" class="form-control form-control-sm" value="<?= e($settings['logo_url']) ?>" required>
                  </div>
                  <div class="d-flex align-items-center justify-content-between pt-2 border-top border-secondary">
                    <label class="btn btn-outline-gold btn-sm mb-0 cursor-pointer">
                      <i class="fas fa-cloud-upload-alt mr-1"></i> Upload New Logo to CDN
                      <input type="file" class="d-none" data-cdn-upload data-target-input="logoUrlInput" data-target-preview="logoPreview" data-folder="logos" accept="image/*">
                    </label>
                    <div class="upload-status text-xs"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 2. CONTACT CHANNELS -->
          <h5 class="text-gold border-bottom border-secondary pb-2 mb-3 mt-4">
            <i class="fas fa-phone-alt mr-2"></i>2. Contact Details &amp; Direct WhatsApp
          </h5>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="phoneFormatted">Display Phone</label>
                <input type="text" id="phoneFormatted" name="phone" class="form-control" value="<?= e($settings['phone']) ?>" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="phoneRaw">Raw Phone (Dialer)</label>
                <input type="text" id="phoneRaw" name="phone_raw" class="form-control" value="<?= e($settings['phone_raw']) ?>" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="whatsappNum">WhatsApp Number</label>
                <input type="text" id="whatsappNum" name="whatsapp" class="form-control" value="<?= e($settings['whatsapp']) ?>" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="emailAddr">Official Email</label>
                <input type="email" id="emailAddr" name="email" class="form-control" value="<?= e($settings['email']) ?>" required>
              </div>
            </div>
          </div>

          <!-- 3. KOLKATA STUDIO ADDRESS -->
          <h5 class="text-gold border-bottom border-secondary pb-2 mb-3 mt-4">
            <i class="fas fa-map-marker-alt mr-2"></i>3. Studio Address (Kolkata)
          </h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="addrStreet">Street / Complex</label>
                <input type="text" id="addrStreet" name="address_street" class="form-control" value="<?= e($settings['address_street']) ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="addrLocality">Locality / Sector</label>
                <input type="text" id="addrLocality" name="address_locality" class="form-control" value="<?= e($settings['address_locality']) ?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="addrCity">City</label>
                <input type="text" id="addrCity" name="address_city" class="form-control" value="<?= e($settings['address_city']) ?>" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="addrRegion">State</label>
                <input type="text" id="addrRegion" name="address_region" class="form-control" value="<?= e($settings['address_region']) ?>" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="addrPostal">Postal Code</label>
                <input type="text" id="addrPostal" name="address_postal_code" class="form-control" value="<?= e($settings['address_postal_code']) ?>" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="hoursInput">Studio Hours</label>
                <input type="text" id="hoursInput" name="opening_hours" class="form-control" value="<?= e($settings['opening_hours']) ?>">
              </div>
            </div>
          </div>

          <!-- 4. SOCIAL MEDIA CHANNELS -->
          <h5 class="text-gold border-bottom border-secondary pb-2 mb-3 mt-4">
            <i class="fas fa-share-alt mr-2"></i>4. Social Media Channels
          </h5>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="instaUrl"><i class="fab fa-instagram mr-1 text-danger"></i> Instagram URL</label>
                <input type="url" id="instaUrl" name="instagram_url" class="form-control" value="<?= e($settings['instagram_url']) ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="fbUrl"><i class="fab fa-facebook mr-1 text-primary"></i> Facebook URL</label>
                <input type="url" id="fbUrl" name="facebook_url" class="form-control" value="<?= e($settings['facebook_url']) ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="linkedUrl"><i class="fab fa-linkedin mr-1 text-info"></i> LinkedIn URL</label>
                <input type="url" id="linkedUrl" name="linkedin_url" class="form-control" value="<?= e($settings['linkedin_url']) ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="ytUrl"><i class="fab fa-youtube mr-1 text-danger"></i> YouTube URL</label>
                <input type="url" id="ytUrl" name="youtube_url" class="form-control" value="<?= e($settings['youtube_url']) ?>">
              </div>
            </div>
          </div>

          <!-- 5. 4-COLUMN FOOTER STATEMENTS -->
          <h5 class="text-gold border-bottom border-secondary pb-2 mb-3 mt-4">
            <i class="fas fa-shoe-prints mr-2"></i>5. Footer 4-Column Text &amp; Bottom Bar
          </h5>
          <div class="form-group">
            <label for="footerBio">Column 1 Brand Statement</label>
            <textarea id="footerBio" name="footer_brand_text" class="form-control" rows="3"><?= e($settings['footer_brand_text']) ?></textarea>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="footerTagline">Footer Tagline</label>
                <input type="text" id="footerTagline" name="footer_tagline" class="form-control" value="<?= e($settings['footer_tagline']) ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="footerCopyright">Footer Copyright Line</label>
                <input type="text" id="footerCopyright" name="footer_copyright" class="form-control" value="<?= e($settings['footer_copyright']) ?>">
              </div>
            </div>
          </div>

          <!-- 6. SEO METADATA -->
          <h5 class="text-gold border-bottom border-secondary pb-2 mb-3 mt-4">
            <i class="fas fa-search mr-2"></i>6. Global SEO Defaults
          </h5>
          <div class="form-group">
            <label for="metaTitle">Default SEO Title</label>
            <input type="text" id="metaTitle" name="meta_title" class="form-control" value="<?= e($settings['meta_title']) ?>">
          </div>
          <div class="form-group">
            <label for="metaDesc">Default Meta Description</label>
            <textarea id="metaDesc" name="meta_description" class="form-control" rows="3"><?= e($settings['meta_description']) ?></textarea>
          </div>
        </div>

        <div class="card-footer bg-dark border-secondary text-right">
          <button type="submit" class="btn btn-gold px-4">
            <i class="fas fa-save mr-1"></i> Save Global Settings &amp; Footer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
