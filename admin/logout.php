<?php
// =============================================
// ADMIN LOGOUT
// =============================================
require_once __DIR__ . '/../includes/auth.php';
logout();
header('Location: ' . BASE_URL . '/admin/');
exit;
