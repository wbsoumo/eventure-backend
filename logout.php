<?php
/**
 * Eventure CMS — Logout Handler
 */
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

logout_admin();
set_flash('info', 'You have been securely logged out.');
redirect(BASE_URL . '/login.php');
