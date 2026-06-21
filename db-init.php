<?php
// =============================================
// DATABASE INITIALIZATION SCRIPT
// Run this script once to set up the database
// =============================================

echo "<!DOCTYPE html><html lang='en' class='dark'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Database Installation</title>";
echo "<link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap' rel='stylesheet'>";
echo "<style>
body { font-family: 'Inter', sans-serif; background: #0a0a0f; color: #fff; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 2rem; }
.container { max-width: 600px; width: 100%; padding: 2rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; }
h1 { font-size: 1.5rem; margin-bottom: 1rem; }
.success { color: #10b981; }
.error { color: #ef4444; }
.info { color: #6366f1; }
code { background: rgba(255,255,255,0.05); padding: 0.2rem 0.4rem; border-radius: 4px; font-size: 0.9rem; }
.btn { display: inline-block; padding: 0.8rem 2rem; background: #6366f1; color: white; border-radius: 9999px; text-decoration: none; font-weight: 600; margin-top: 1rem; transition: all 0.3s; }
.btn:hover { background: #4f46e5; transform: translateY(-2px); }
.step { padding: 1rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
</style></head><body><div class='container'>";
echo "<h1>🚀 Database Installation</h1>";

// Step 1: Include config
echo "<div class='step'><strong>Step 1:</strong> Loading configuration... ";
require_once __DIR__ . '/config/database.php';
echo "<span class='success'>✓ Done</span></div>";

// Step 2: Connect to MySQL (create database if needed)
echo "<div class='step'><strong>Step 2:</strong> Connecting to MySQL server... ";
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "<span class='success'>✓ Connected</span>";

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo " | Database '<code>" . DB_NAME . "</code>' ready.</div>";

    // Step 3: Import schema
    echo "<div class='step'><strong>Step 3:</strong> Importing schema... ";
    $pdo->exec("USE `" . DB_NAME . "`");

    $sql = file_get_contents(__DIR__ . '/database/schema.sql');
    if ($sql === false) {
        echo "<span class='error'>✗ Could not read schema.sql file</span></div>";
    } else {
        // Remove USE/DATABASE statements if we're already in the database
        $statements = explode(';', $sql);
        $count = 0;
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (empty($statement)) continue;
            // Skip CREATE DATABASE and USE statements
            if (preg_match('/^(CREATE\s+DATABASE|USE)\s/i', $statement)) continue;
            try {
                $pdo->exec($statement);
                $count++;
            } catch (PDOException $e) {
                // Skip errors for "already exists" or "duplicate entry" type issues (re-running script)
                $msg = $e->getMessage();
                if (strpos($msg, 'already exists') === false && strpos($msg, 'Duplicate entry') === false) {
                    echo "<span class='error'>✗ Error: " . htmlspecialchars($msg) . "</span><br>";
                }
            }
        }
        echo "<span class='success'>✓ Schema imported (" . $count . " statements executed)</span></div>";
    }
} catch (PDOException $e) {
    echo "<span class='error'>✗ Connection failed: " . htmlspecialchars($e->getMessage()) . "</span></div>";
    echo "<p style='margin-top: 1rem; color: var(--text-secondary);'>Make sure your MySQL server is running and the credentials in <code>config/database.php</code> are correct.</p>";
    echo "</div></body></html>";
    exit;
}

// Step 4: Verify default admin
echo "<div class='step'><strong>Step 4:</strong> Verifying default admin user... ";
try {
    $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE email = ?");
    $stmt->execute(['admin@alenmodwebhub.com']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo "<span class='success'>✓ Admin user found: " . htmlspecialchars($user['name']) . " (" . htmlspecialchars($user['email']) . ")</span>";
    } else {
        echo "<span class='warning'>⚠ Default admin not found. You may need to run the schema.sql manually.</span>";
    }
} catch (PDOException $e) {
    echo "<span class='error'>✗ " . htmlspecialchars($e->getMessage()) . "</span>";
}
echo "</div>";

// Step 5: Check tables
echo "<div class='step'><strong>Step 5:</strong> Checking tables... ";
try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<span class='success'>✓ " . count($tables) . " tables found:</span> ";
    echo "<code>" . implode("</code>, <code>", $tables) . "</code>";
} catch (PDOException $e) {
    echo "<span class='error'>✗ " . htmlspecialchars($e->getMessage()) . "</span>";
}
echo "</div>";

echo "<div style='margin-top: 2rem; padding: 1.5rem; background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.2); border-radius: 12px;'>";
echo "<h2 style='font-size: 1.1rem; margin-bottom: 0.5rem;'>✅ Installation Complete</h2>";
echo "<p style='color: #a0a0b8; font-size: 0.9rem; line-height: 1.6;'>";
echo "Your database is ready! You can now:<br>";
echo "• Visit <a href='/' style='color: #818cf8;'>the homepage</a> to see your portfolio<br>";
echo "• Go to <a href='" . BASE_URL . "/admin/' style='color: #818cf8;'>the admin panel</a> to manage your content<br>";
echo "• Default login: <code>admin@alenmodwebhub.com</code> / <code>admin123</code><br>";
echo "• <strong>Important:</strong> Delete this file after installation for security!</p>";
echo "<a href='" . BASE_URL . "/' class='btn'>View Portfolio</a> ";
echo "<a href='" . BASE_URL . "/admin/' class='btn' style='background: transparent; border: 1px solid rgba(255,255,255,0.2);'>Go to Admin</a>";
echo "</div>";

echo "</div></body></html>";
