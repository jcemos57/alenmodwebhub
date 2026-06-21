<?php
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
$phone = trim($input['phone'] ?? '');
$company = trim($input['company'] ?? '');
$projectType = trim($input['project_type'] ?? '');
$budget = trim($input['budget'] ?? '');
$timeline = trim($input['timeline'] ?? '');
$description = trim($input['description'] ?? '');
$websiteType = trim($input['website_type'] ?? '');
$features = trim($input['features'] ?? '');

if (empty($name) || empty($email) || empty($projectType) || empty($budget) || empty($timeline) || empty($description)) {
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
    $stmt = $db->prepare("INSERT INTO hire_requests (name, email, phone, company, project_type, budget, timeline, description, website_type, features) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $company, $projectType, $budget, $timeline, $description, $websiteType, $features]);

    $adminEmail = getSetting('email', 'hello@alenmodwebhub.com');
    $siteName = getSetting('site_name', 'Alenmodwebhub');

    $safeName = str_replace(["\r", "\n"], '', $name);
    $safeEmail = str_replace(["\r", "\n"], '', $email);
    $safeProjectType = str_replace(["\r", "\n"], '', $projectType);

    $emailBody = "New Hire Request from $siteName\n\n";
    $emailBody .= "Name: $safeName\n";
    $emailBody .= "Email: $safeEmail\n";
    $emailBody .= "Phone: $phone\n";
    $emailBody .= "Company: $company\n";
    $emailBody .= "Project Type: $safeProjectType\n";
    $emailBody .= "Website Type: $websiteType\n";
    $emailBody .= "Budget: $budget\n";
    $emailBody .= "Timeline: $timeline\n";
    $emailBody .= "Features: $features\n";
    $emailBody .= "Description:\n$description\n";

    $headers = "From: noreply@alenmodwebhub.com\r\nReply-To: $safeEmail";
    $mailSent = @mail($adminEmail, "New Hire Request: $safeProjectType from $safeName", $emailBody, $headers);
    if (!$mailSent) {
        error_log("Hire form: Failed to send email notification for $safeName <$safeEmail>");
    }

    echo json_encode(['success' => true, 'message' => 'Hire request submitted successfully! I will contact you within 24 hours.']);
} catch (PDOException $e) {
    error_log("Hire form error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
