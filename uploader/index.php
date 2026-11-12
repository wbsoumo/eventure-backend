<?php
/**
 * Eventure CMS — CDN Media Uploader Tool
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

$pageTitle = 'CDN Media Uploader';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="row">
  <div class="col-lg-8 mx-auto">
    <div class="card card-outline card-warning">
      <div class="card-header">
        <h3 class="card-title text-gold font-weight-bold">
          <i class="fas fa-cloud-upload-alt mr-2"></i>Upload Assets to CDN
        </h3>
      </div>

      <div class="card-body">
        <p class="text-muted">
          All files uploaded here are stored directly on <strong>cdn.myeventure.in</strong> and served with HTTP/2 and LiteSpeed edge caching.
        </p>

        <div class="form-group">
          <label for="mediaFolder">Select Target Folder / Category</label>
          <select id="mediaFolder" class="custom-select">
            <option value="weddings">Weddings (/uploads/weddings/)</option>
            <option value="corporate">Corporate (/uploads/corporate/)</option>
            <option value="portfolio">Portfolio (/uploads/portfolio/)</option>
            <option value="gallery">Gallery (/uploads/gallery/)</option>
            <option value="logos">Logos (/uploads/logos/)</option>
            <option value="banners">Banners (/uploads/banners/)</option>
            <option value="general" selected>General (/uploads/general/)</option>
          </select>
        </div>

        <div class="p-5 border border-secondary rounded text-center bg-dark" id="dropArea" style="cursor: pointer; border-style: dashed !important; border-width: 2px !important;">
          <i class="fas fa-cloud-upload-alt fa-4x text-gold mb-3"></i>
          <h4>Click to browse or drag and drop image here</h4>
          <p class="text-muted text-sm mb-3">Supports JPG, PNG, WebP, SVG, AVIF, MP4 (Max 50MB)</p>
          <input type="file" id="mediaFileInput" accept="image/*,video/mp4" class="d-none">
          <button type="button" class="btn btn-outline-gold" onclick="document.getElementById('mediaFileInput').click()">
            <i class="fas fa-folder-open mr-1"></i> Choose File
          </button>
        </div>

        <div id="mediaUploadProgress" class="mt-4" style="display: none;">
          <div class="progress progress-sm active">
            <div id="mediaProgressBar" class="progress-bar bg-warning progress-bar-striped" role="progressbar" style="width: 50%"></div>
          </div>
          <small id="mediaProgressText" class="text-warning mt-1 d-block text-center">Uploading to cdn.myeventure.in...</small>
        </div>

        <div id="mediaUploadSuccess" class="mt-4 p-3 bg-black border border-success rounded" style="display: none;">
          <h5 class="text-success"><i class="fas fa-check-circle mr-1"></i> Asset Uploaded Successfully!</h5>
          <div class="text-center my-3">
            <img id="mediaUploadedPreview" src="" alt="Preview" style="max-height: 200px; border-radius: 8px;" class="border border-secondary">
          </div>
          <div class="input-group">
            <input type="text" id="mediaCdnResultUrl" class="form-control" readonly>
            <div class="input-group-append">
              <button class="btn btn-gold" type="button" onclick="copyCdnLink()">
                <i class="far fa-copy mr-1"></i> Copy Link
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const dropArea = document.getElementById('dropArea');
const fileInput = document.getElementById('mediaFileInput');

dropArea.addEventListener('click', () => fileInput.click());

['dragenter', 'dragover'].forEach(eventName => {
  dropArea.addEventListener(eventName, (e) => {
    e.preventDefault();
    dropArea.style.borderColor = '#d4af37';
    dropArea.style.backgroundColor = 'rgba(212, 175, 55, 0.05)';
  });
});

['dragleave', 'drop'].forEach(eventName => {
  dropArea.addEventListener(eventName, (e) => {
    e.preventDefault();
    dropArea.style.borderColor = '#2c2c31';
    dropArea.style.backgroundColor = '#121215';
  });
});

dropArea.addEventListener('drop', (e) => {
  const dt = e.dataTransfer;
  const files = dt.files;
  if (files.length) {
    handleFileUpload(files[0]);
  }
});

fileInput.addEventListener('change', (e) => {
  if (e.target.files.length) {
    handleFileUpload(e.target.files[0]);
  }
});

async function handleFileUpload(file) {
  const folder = document.getElementById('mediaFolder').value;
  const progressBox = document.getElementById('mediaUploadProgress');
  const successBox = document.getElementById('mediaUploadSuccess');
  const resultUrl = document.getElementById('mediaCdnResultUrl');
  const previewImg = document.getElementById('mediaUploadedPreview');

  progressBox.style.display = 'block';
  successBox.style.display = 'none';

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
      resultUrl.value = data.url;
      previewImg.src = data.url;
      successBox.style.display = 'block';
      Swal.fire({
        icon: 'success',
        title: 'Upload Successful',
        text: 'File stored at ' + data.url,
        background: '#121215',
        color: '#f7f3ec',
        confirmButtonColor: '#d4af37'
      });
    } else {
      throw new Error(data.error || 'Upload error');
    }
  } catch (err) {
    Swal.fire({
      icon: 'error',
      title: 'Upload Failed',
      text: err.message,
      background: '#121215',
      color: '#f7f3ec'
    });
  } finally {
    progressBox.style.display = 'none';
    fileInput.value = '';
  }
}

function copyCdnLink() {
  const copyText = document.getElementById('mediaCdnResultUrl');
  copyText.select();
  document.execCommand('copy');
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: 'CDN Link copied!',
    showConfirmButton: false,
    timer: 2000
  });
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
