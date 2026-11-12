<?php
/**
 * Eventure CMS — AdminLTE 3 Sidebar
 */
declare(strict_types=1);

$currentUri = $_SERVER['REQUEST_URI'] ?? '';
$activePage = $_GET['slug'] ?? '';

// Helper to mark active link
function is_nav_active(string $path, string $slug = ''): string {
    global $currentUri, $activePage;
    if ($slug !== '') {
        return ($slug === $activePage) ? 'active' : '';
    }
    return str_contains($currentUri, $path) ? 'active' : '';
}
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= BASE_URL ?>/dashboard.php" class="brand-link">
    <span class="brand-image img-circle elevation-3 d-inline-flex align-items-center justify-content-center bg-primary text-white font-weight-bold" style="width:33px; height:33px; font-size:1.1rem; opacity:0.9;">A</span>
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="image">
        <span class="img-circle elevation-2 d-inline-flex align-items-center justify-content-center bg-secondary text-white" style="width:34px; height:34px;">
          <i class="fas fa-user-shield"></i>
        </span>
      </div>
      <div class="info">
        <a href="<?= BASE_URL ?>/settings/site.php" class="d-block"><?= e($user['name'] ?? 'Administrator') ?></a>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/dashboard.php" class="nav-link <?= is_nav_active('/dashboard.php') ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Leads & Inquiries -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/inquiries/index.php" class="nav-link <?= is_nav_active('/inquiries/') ?>">
            <i class="nav-icon fas fa-envelope-open-text"></i>
            <p>
              Leads &amp; Inquiries
              <?php if (!empty($unreadLeadsCount) && $unreadLeadsCount > 0): ?>
                <span class="badge badge-warning right"><?= $unreadLeadsCount ?> New</span>
              <?php endif; ?>
            </p>
          </a>
        </li>

        <!-- PAGE EDITORS SECTION -->
        <li class="nav-header">PAGES CONTENT EDITORS</li>

        <!-- 01 Home Page -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/pages/edit.php?slug=home" class="nav-link <?= is_nav_active('/pages/edit.php', 'home') ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>01 Home Page</p>
          </a>
        </li>

        <!-- 02 Weddings Page -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/pages/edit.php?slug=weddings" class="nav-link <?= is_nav_active('/pages/edit.php', 'weddings') ?>">
            <i class="nav-icon fas fa-ring"></i>
            <p>02 Weddings Page</p>
          </a>
        </li>

        <!-- 03 Corporate Page -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/pages/edit.php?slug=corporate" class="nav-link <?= is_nav_active('/pages/edit.php', 'corporate') ?>">
            <i class="nav-icon fas fa-building"></i>
            <p>03 Corporate Page</p>
          </a>
        </li>

        <!-- 04 Portfolio Page -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/pages/edit.php?slug=portfolio" class="nav-link <?= is_nav_active('/pages/edit.php', 'portfolio') ?>">
            <i class="nav-icon fas fa-briefcase"></i>
            <p>04 Portfolio Page</p>
          </a>
        </li>

        <!-- 05 Gallery Page -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/pages/edit.php?slug=gallery" class="nav-link <?= is_nav_active('/pages/edit.php', 'gallery') ?>">
            <i class="nav-icon fas fa-images"></i>
            <p>05 Gallery Page</p>
          </a>
        </li>

        <!-- 06 About Page -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/pages/edit.php?slug=about" class="nav-link <?= is_nav_active('/pages/edit.php', 'about') ?>">
            <i class="nav-icon fas fa-landmark"></i>
            <p>06 About Page</p>
          </a>
        </li>

        <!-- 07 Contact Page -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/pages/edit.php?slug=contact" class="nav-link <?= is_nav_active('/pages/edit.php', 'contact') ?>">
            <i class="nav-icon fas fa-paper-plane"></i>
            <p>07 Contact Page</p>
          </a>
        </li>

        <!-- DATA MANAGEMENT SECTION -->
        <li class="nav-header">EVENTS &amp; MEDIA</li>

        <!-- Events / Portfolio CRUD -->
        <li class="nav-item has-treeview <?= str_contains($currentUri, '/events/') ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= str_contains($currentUri, '/events/') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-calendar-star"></i>
            <p>
              Portfolio Events
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= BASE_URL ?>/events/index.php" class="nav-link <?= ($currentUri === '/events/index.php' || str_ends_with($currentUri, '/events/')) ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>All Events / Projects</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_URL ?>/events/create.php" class="nav-link <?= str_contains($currentUri, '/events/create.php') ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>+ Add New Event</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Gallery Archive Photos -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/gallery/index.php" class="nav-link <?= is_nav_active('/gallery/index.php') ?>">
            <i class="nav-icon fas fa-photo-video"></i>
            <p>Gallery Archive (91+)</p>
          </a>
        </li>

        <!-- FAQs Manager -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/settings/faqs.php" class="nav-link <?= is_nav_active('/settings/faqs.php') ?>">
            <i class="nav-icon fas fa-question-circle"></i>
            <p>FAQs Manager</p>
          </a>
        </li>

        <!-- GLOBAL SITE SETTINGS -->
        <li class="nav-header">GLOBAL &amp; NAVIGATION</li>

        <!-- Site Settings -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/settings/site.php" class="nav-link <?= is_nav_active('/settings/site.php') ?>">
            <i class="nav-icon fas fa-sliders-h"></i>
            <p>Global Site Settings</p>
          </a>
        </li>

        <!-- Navigation & Menus -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/settings/navigation.php" class="nav-link <?= is_nav_active('/settings/navigation.php') ?>">
            <i class="nav-icon fas fa-compass"></i>
            <p>Header &amp; Footer Menus</p>
          </a>
        </li>

        <!-- CDN Media Uploader Tool -->
        <li class="nav-item">
          <a href="<?= BASE_URL ?>/uploader/index.php" class="nav-link <?= is_nav_active('/uploader/index.php') ?>">
            <i class="nav-icon fas fa-cloud-upload-alt"></i>
            <p>CDN Media Uploader</p>
          </a>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3">
          <a href="<?= BASE_URL ?>/logout.php" class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
