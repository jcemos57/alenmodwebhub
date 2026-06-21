<?php
// =============================================
// ADMIN LOGIN PAGE
// =============================================
require_once __DIR__ . '/../includes/auth.php';

// Redirect if already logged in
if (isAuthenticated()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = login($email, $password);

    if ($result['success']) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = $result['message'];
    }
}
?><!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Alenmodwebhub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <style>
        .admin-body { padding-top: 0; height: 100vh; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body class="admin-body">
    <div class="admin-login">
        <div class="admin-login-box">
            <div class="admin-login-logo">Alenmodwebhub</div>
            <h1 class="admin-login-title">Welcome Back</h1>
            <p class="admin-login-subtitle">Sign in to manage your portfolio</p>

            <?php if ($error): ?>
            <div class="admin-alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="admin@alenmodwebhub.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                    Sign In
                    <span class="btn-shimmer"></span>
                </button>
            </form>

            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-tertiary); font-size: 0.85rem;">
                Default: admin@alenmodwebhub.com / admin123
            </p>
        </div>
    </div>
</body>
</html>
