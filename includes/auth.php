<?php
/**
 * Eventure CMS — Authentication & Authorization
 */
declare(strict_types=1);

/**
 * Check if admin is currently logged in
 */
function is_logged_in(): bool {
    return !empty($_SESSION['admin_user_id']);
}

/**
 * Get current logged in admin user
 */
function current_user(): ?array {
    global $pdo;
    if (!is_logged_in()) {
        return null;
    }
    static $user = null;
    if ($user === null) {
        $stmt = $pdo->prepare("SELECT id, name, email, role, created_at FROM `admins` WHERE id = ?");
        $stmt->execute([$_SESSION['admin_user_id']]);
        $user = $stmt->fetch() ?: null;
    }
    return $user;
}

/**
 * Guard page: Redirect to login if not logged in
 */
function require_login(): void {
    if (!is_logged_in()) {
        $current = $_SERVER['REQUEST_URI'] ?? '/dashboard.php';
        redirect(BASE_URL . '/login.php?redirect=' . urlencode($current));
    }
}

/**
 * Attempt login with email and password
 */
function attempt_login(string $email, string $password): bool {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, name, email, password_hash, role FROM `admins` WHERE email = ? LIMIT 1");
    $stmt->execute([trim($email)]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        // Regenerate session ID for security against session fixation
        session_regenerate_id(true);
        $_SESSION['admin_user_id'] = $admin['id'];
        $_SESSION['admin_name']    = $admin['name'];
        $_SESSION['admin_email']   = $admin['email'];
        $_SESSION['admin_role']    = $admin['role'];
        return true;
    }
    return false;
}

/**
 * Log out admin
 */
function logout_admin(): void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
