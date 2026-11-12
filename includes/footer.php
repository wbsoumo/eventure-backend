      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer bg-light text-dark border-top border-light text-sm">
    <strong>Copyright &copy; <?= date('Y') ?> <a href="https://myeventure.in" target="_blank" class="text-primary">Eventure Experiences LLP</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0 &middot; <span class="text-muted">Kolkata Studio</span>
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- Bootstrap 4 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE 3 App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- CDN Uploader Widget -->
<script src="<?= BASE_URL ?>/assets/js/uploader.js"></script>

<?php
// Display Flash messages with SweetAlert2
$flash = get_flash();
if ($flash):
?>
<script>
Swal.fire({
  icon: '<?= $flash['type'] === 'error' ? 'error' : 'success' ?>',
  title: '<?= $flash['type'] === 'error' ? 'Notice' : 'Success!' ?>',
  text: '<?= addslashes($flash['message']) ?>',
  background: '#121215',
  color: '#f7f3ec',
  confirmButtonColor: '#d4af37',
  timer: 3500,
  timerProgressBar: true
});
</script>
<?php endif; ?>

</body>
</html>
