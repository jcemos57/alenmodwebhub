<?php
// =============================================
// AUTHENTICATION HANDLER
// =============================================

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);

session_start();

function login($email, $password) {
    $db = getDB();
    if (!$db) return ['success' => false, 'message' => 'Database connection failed'];

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        session_regenerate_id(true);

        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['name'];
        $_SESSION['admin_email'] = $user['email'];
        $_SESSION['admin_role'] = $user['role'];
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        logActivity($user['id'], 'login', 'Admin logged in');

        return ['success' => true, 'user' => $user];
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred'];
    }
}

function logout() {
    if (isset($_SESSION['admin_id'])) {
        logActivity($_SESSION['admin_id'], 'logout', 'Admin logged out');
    }
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}

function checkAuth() {
    if (!isset($_SESSION['admin_id'])) {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            jsonResponse(['error' => 'Unauthorized'], 401);
        }
        header('Location: ' . BASE_URL . '/admin/');
        exit;
    }
}

function getCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        return false;
    }
    return true;
}

function requireCsrfToken() {
    $token = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($token)) {
        jsonResponse(['error' => 'Invalid CSRF token'], 419);
        exit;
    }
}
