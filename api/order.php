<?php
// =============================================
// ORDER API - Submit Purchase Order
// =============================================
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = [];
}

$name = trim($input['customer_name'] ?? '');
$email = trim($input['customer_email'] ?? '');
$planName = trim($input['plan_name'] ?? '');
$planPrice = trim($input['plan_price'] ?? '');
$paymentMethod = trim($input['payment_method'] ?? '');
$phone = trim($input['customer_phone'] ?? '');
$notes = trim($input['notes'] ?? '');

if (!$name || !$email || !$planName) {
    echo json_encode(['success' => false, 'message' => 'Name, email, and plan are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

try {
    $db = getDB();
    if (!$db) {
        throw new Exception('Database connection failed');
    }

    $stmt = $db->prepare("INSERT INTO orders (plan_name, plan_price, customer_name, customer_email, customer_phone, payment_method, notes, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$planName, $planPrice, $name, $email, $phone, $paymentMethod, $notes]);

    $adminEmail = getSetting('email', 'admin@alenmodwebhub.com');

    $safeName = str_replace(["\r", "\n"], '', $name);
    $safePlanName = str_replace(["\r", "\n"], '', $planName);

    $subject = "New Order: $safePlanName - $safeName";
    $message = "New order received!\n\nPlan: $safePlanName\nPrice: $planPrice\nName: $safeName\nEmail: $email\nPhone: $phone\nPayment: $paymentMethod\nNotes: $notes";
    $mailSent = @mail($adminEmail, $subject, $message, "From: noreply@alenmodwebhub.com");
    if (!$mailSent) {
        error_log("Order form: Failed to send email notification for $safeName <$email>");
    }

    echo json_encode(['success' => true, 'message' => 'Order submitted successfully!']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again.']);
}
