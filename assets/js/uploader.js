/**
 * Eventure CMS — CDN Image Uploader Widget
 * Uploads media straight to https://cdn.myeventure.in/upload.php
 */
document.addEventListener('DOMContentLoaded', () => {
  const uploadInputs = document.querySelectorAll('[data-cdn-upload]');

  uploadInputs.forEach((input) => {
    input.addEventListener('change', async (e) => {
      const file = e.target.files[0];
      if (!file) return;

      const targetFieldId = input.dataset.targetInput;
      const targetPreviewId = input.dataset.targetPreview;
      const folder = input.dataset.folder || 'general';
      const statusElement = input.closest('.cdn-image-box')?.querySelector('.upload-status');

      const targetField = document.getElementById(targetFieldId);
      const targetPreview = document.getElementById(targetPreviewId);

      if (statusElement) {
        statusElement.innerHTML = `<span class="text-warning"><i class="fas fa-spinner fa-spin"></i> Uploading ${file.name} to CDN...</span>`;
      }

      const formData = new FormData();
      formData.append('file', file);
      formData.append('folder', folder);
      formData.append('api_key', 'eventure_secret_cdn_key_9748328654');

      try {
        const response = await fetch('https://cdn.myeventure.in/upload.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (data.success && data.url) {
          if (targetField) {
            targetField.value = data.url;
            // trigger change event
            targetField.dispatchEvent(new Event('input', { bubbles: true }));
          }
          if (targetPreview) {
            targetPreview.src = data.url;
            targetPreview.style.display = 'block';
          }
          if (statusElement) {
            statusElement.innerHTML = `<span class="text-success"><i class="fas fa-check-circle"></i> Uploaded: <a href="${data.url}" target="_blank" class="text-gold">${data.filename}</a></span>`;
          }

          if (typeof Swal !== 'undefined') {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'Asset uploaded to CDN',
              showConfirmButton: false,
              timer: 2500
            });
          }
        } else {
          throw new Error(data.error || 'Upload failed');
        }
      } catch (err) {
        if (statusElement) {
          statusElement.innerHTML = `<span class="text-danger"><i class="fas fa-exclamation-circle"></i> Error: ${err.message}</span>`;
        }
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'error',
            title: 'Upload Failed',
            text: err.message
          });
        }
      } finally {
        input.value = ''; // reset so same file can be picked again
      }
    });
  });
});
