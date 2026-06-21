<?php
// =============================================
// CONTACT FORM API
// =============================================
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

require_once __DIR__ . '/../includes/functions.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = $_POST;
}

$name = trim($input['name'] ?? '');
$email = trim($input['email'] ?? '');
$subject = trim($input['subject'] ?? '');
$message = trim($input['message'] ?? '');

if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

$db = getDB();
if (!$db) {
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
    exit;
}

try {
    $stmt = $db->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $subject, $message]);

    $adminEmail = getSetting('email', 'hello@alenmodwebhub.com');
    $siteName = getSetting('site_name', 'Alenmodwebhub');

    $safeSubject = str_replace(["\r", "\n"], '', $subject);
    $safeName = str_replace(["\r", "\n"], '', $name);
    $safeEmail = str_replace(["\r", "\n"], '', $email);

    $emailBody = "New contact form submission from $siteName\n\n";
    $emailBody .= "Name: $safeName\n";
    $emailBody .= "Email: $safeEmail\n";
    $emailBody .= "Subject: $safeSubject\n";
    $emailBody .= "Message:\n$message\n";

    $headers = "From: noreply@alenmodwebhub.com\r\nReply-To: $safeEmail";
    $mailSent = @mail($adminEmail, "New Contact: $safeSubject", $emailBody, $headers);
    if (!$mailSent) {
        error_log("Contact form: Failed to send email notification for $safeName <$safeEmail>");
    }

    echo json_encode(['success' => true, 'message' => 'Message sent successfully!']);
} catch (PDOException $e) {
    error_log("Contact form error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
