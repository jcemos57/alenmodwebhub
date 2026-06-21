<?php
// =============================================
// ADMIN DASHBOARD - Complete Management Panel
// =============================================
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
checkAuth();

$db = getDB();
$allowedTabs = ['dashboard', 'projects', 'blog', 'testimonials', 'messages', 'hire', 'services', 'skills', 'experience', 'settings', 'pricing', 'orders', 'menus'];
$activeTab = $_GET['tab'] ?? 'dashboard';
if (!in_array($activeTab, $allowedTabs)) {
    $activeTab = 'dashboard';
}
$settings = getAllSettings();
$stats = getStats();
$error = '';
$success = '';

// Handle hire request mark as read (GET)
if (isset($_GET['mark_read'])) {
    $stmt = $db->prepare("UPDATE hire_requests SET is_read = 1 WHERE id = ?");
    $stmt->execute([(int)$_GET['mark_read']]);
    $success = 'Hire request marked as read.';
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrfToken();
    $action = $_POST['action'] ?? '';

    // Update settings
    if ($action === 'update_settings') {
        $allowedKeys = ['hero_title', 'hero_subtitle', 'hero_availability', 'about_text', 'email', 'phone', 'location', 'whatsapp', 'telegram_chat', 'github_url', 'linkedin_url', 'twitter_url', 'facebook_url', 'instagram_url', 'youtube_url', 'footer_text', 'copyright_text', 'experience_years', 'projects_count', 'clients_count', 'countries_count', 'site_title', 'site_description', 'site_keywords', 'cv_url', 'default_currency_symbol', 'default_currency_code', 'bank_name', 'bank_account_name', 'bank_account_number', 'bank_account_usd', 'bank_usd_details', 'bank_ngn_details', 'usdt_wallet', 'usdt_network', 'btc_wallet'];
        foreach ($allowedKeys as $key) {
            if (isset($_POST[$key])) {
                $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
                $stmt->execute([$key, $_POST[$key]]);
            }
        }
        logActivity($_SESSION['admin_id'], 'update_settings', 'Updated site settings');
        $success = 'Settings updated successfully!';
        $settings = getAllSettings(); // Refresh
    }

    // Add project
    if ($action === 'add_project') {
        $slug = slugify($_POST['title']);
        $stmt = $db->prepare("INSERT INTO projects (title, slug, description, content, category, technologies, live_url, github_url, problem_solved, results, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['title'], $slug, $_POST['description'], $_POST['content'] ?? '',
            $_POST['category'], $_POST['technologies'], $_POST['live_url'],
            $_POST['github_url'], $_POST['problem_solved'], $_POST['results'],
            (int)$_POST['sort_order'], $_POST['status']
        ]);
        logActivity($_SESSION['admin_id'], 'add_project', 'Added project: ' . $_POST['title']);
        $success = 'Project added successfully!';
    }

    // Update project
    if ($action === 'update_project') {
        $slug = slugify($_POST['title']);
        $stmt = $db->prepare("UPDATE projects SET title=?, slug=?, description=?, content=?, category=?, technologies=?, live_url=?, github_url=?, problem_solved=?, results=?, sort_order=?, status=? WHERE id=?");
        $stmt->execute([
            $_POST['title'], $slug, $_POST['description'], $_POST['content'] ?? '',
            $_POST['category'], $_POST['technologies'], $_POST['live_url'],
            $_POST['github_url'], $_POST['problem_solved'], $_POST['results'],
            (int)$_POST['sort_order'], $_POST['status'], (int)$_POST['id']
        ]);
        logActivity($_SESSION['admin_id'], 'update_project', 'Updated project: ' . $_POST['title']);
        $success = 'Project updated successfully!';
    }

    // Delete project
    if ($action === 'delete_project') {
        $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        logActivity($_SESSION['admin_id'], 'delete_project', 'Deleted project ID: ' . $_POST['id']);
        $success = 'Project deleted successfully!';
    }

    // Add service
    if ($action === 'add_service') {
        $slug = slugify($_POST['title']);
        $features = json_encode(explode("\n", str_replace("\r", "", $_POST['features'])));
        $stmt = $db->prepare("INSERT INTO services (title, slug, description, icon, features, price, price_label, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['title'], $slug, $_POST['description'], $_POST['icon'],
            $features, $_POST['price'] ?: null, $_POST['price_label'],
            (int)$_POST['sort_order'], $_POST['status']
        ]);
        logActivity($_SESSION['admin_id'], 'add_service', 'Added service: ' . $_POST['title']);
        $success = 'Service added successfully!';
    }

    // Edit service
    if ($action === 'edit_service') {
        $slug = slugify($_POST['title']);
        $features = json_encode(explode("\n", str_replace("\r", "", $_POST['features'])));
        $stmt = $db->prepare("UPDATE services SET title=?, slug=?, description=?, icon=?, features=?, price=?, price_label=?, sort_order=?, status=? WHERE id=?");
        $stmt->execute([
            $_POST['title'], $slug, $_POST['description'], $_POST['icon'],
            $features, $_POST['price'] ?: null, $_POST['price_label'],
            (int)$_POST['sort_order'], $_POST['status'], (int)$_POST['id']
        ]);
        logActivity($_SESSION['admin_id'], 'edit_service', 'Edited service: ' . $_POST['title']);
        $success = 'Service updated successfully!';
    }

    // Delete service
    if ($action === 'delete_service') {
        $stmt = $db->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        $success = 'Service deleted successfully!';
    }

    // Add testimonial
    if ($action === 'add_testimonial') {
        $stmt = $db->prepare("INSERT INTO testimonials (name, role, company, content, rating, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'], $_POST['role'], $_POST['company'],
            $_POST['content'], (int)$_POST['rating'], (int)$_POST['sort_order'], $_POST['status']
        ]);
        logActivity($_SESSION['admin_id'], 'add_testimonial', 'Added testimonial from: ' . $_POST['name']);
        $success = 'Testimonial added successfully!';
    }

    // Delete testimonial
    if ($action === 'delete_testimonial') {
        $stmt = $db->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        $success = 'Testimonial deleted successfully!';
    }

    // Add blog post
    if ($action === 'add_blog') {
        $slug = slugify($_POST['title']);
        $tags = json_encode(array_map('trim', explode(',', $_POST['tags'])));
        $readingTime = getReadingTime($_POST['content']);
        $stmt = $db->prepare("INSERT INTO blog_posts (title, slug, excerpt, content, category, tags, reading_time, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['title'], $slug, $_POST['excerpt'], $_POST['content'],
            $_POST['category'], $tags, $readingTime, $_POST['status']
        ]);
        logActivity($_SESSION['admin_id'], 'add_blog', 'Added blog post: ' . $_POST['title']);
        $success = 'Blog post added successfully!';
    }

    // Delete blog post
    if ($action === 'delete_blog') {
        $stmt = $db->prepare("DELETE FROM blog_posts WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        $success = 'Blog post deleted successfully!';
    }

    // Add skill
    if ($action === 'add_skill') {
        $stmt = $db->prepare("INSERT INTO skills (name, level, category, sort_order) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], (int)$_POST['level'], $_POST['category'], (int)$_POST['sort_order']]);
        $success = 'Skill added successfully!';
    }

    // Edit skill
    if ($action === 'edit_skill') {
        $stmt = $db->prepare("UPDATE skills SET name=?, level=?, category=?, sort_order=? WHERE id=?");
        $stmt->execute([$_POST['name'], (int)$_POST['level'], $_POST['category'], (int)$_POST['sort_order'], (int)$_POST['id']]);
        $success = 'Skill updated successfully!';
    }

    // Delete skill
    if ($action === 'delete_skill') {
        $stmt = $db->prepare("DELETE FROM skills WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        $success = 'Skill deleted successfully!';
    }

    // Mark message as read
    if ($action === 'mark_read') {
        $stmt = $db->prepare("UPDATE contacts SET is_read = 1 WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        $success = 'Message marked as read.';
    }

    // Delete message
    if ($action === 'delete_message') {
        $stmt = $db->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        $success = 'Message deleted successfully!';
    }

    // Add experience
    if ($action === 'add_experience') {
        $stmt = $db->prepare("INSERT INTO experiences (title, company, location, start_date, end_date, current, description, type, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['title'], $_POST['company'], $_POST['location'],
            $_POST['start_date'], $_POST['end_date'] ?: null,
            isset($_POST['current']) ? 1 : 0, $_POST['description'],
            $_POST['type'], (int)$_POST['sort_order']
        ]);
        $success = 'Experience added successfully!';
    }

    // Edit experience
    if ($action === 'edit_experience') {
        $stmt = $db->prepare("UPDATE experiences SET title=?, company=?, location=?, start_date=?, end_date=?, current=?, description=?, type=?, sort_order=? WHERE id=?");
        $stmt->execute([
            $_POST['title'], $_POST['company'], $_POST['location'],
            $_POST['start_date'], $_POST['end_date'] ?: null,
            isset($_POST['current']) ? 1 : 0, $_POST['description'],
            $_POST['type'], (int)$_POST['sort_order'], (int)$_POST['id']
        ]);
        $success = 'Experience updated successfully!';
    }

    // Delete experience
    if ($action === 'delete_experience') {
        $stmt = $db->prepare("DELETE FROM experiences WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        $success = 'Experience deleted successfully!';
    }

    // ========== NAV MENU HANDLERS ==========
    if ($action === 'add_nav') {
        $stmt = $db->prepare("INSERT INTO nav_items (label, url, icon, location, target, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['label'], $_POST['url'], $_POST['icon'] ?: null, $_POST['location'], $_POST['target'], (int)$_POST['sort_order'], $_POST['status']]);
        $success = 'Menu item added!';
    }
    if ($action === 'edit_nav') {
        $stmt = $db->prepare("UPDATE nav_items SET label=?, url=?, icon=?, location=?, target=?, sort_order=?, status=? WHERE id=?");
        $stmt->execute([$_POST['label'], $_POST['url'], $_POST['icon'] ?: null, $_POST['location'], $_POST['target'], (int)$_POST['sort_order'], $_POST['status'], (int)$_POST['id']]);
        $success = 'Menu item updated!';
    }
    if ($action === 'delete_nav') {
        $db->prepare("UPDATE nav_items SET parent_id = NULL WHERE parent_id = ?")->execute([(int)$_POST['id']]);
        $stmt = $db->prepare("DELETE FROM nav_items WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        $success = 'Menu item deleted!';
    }

    // ========== PRICING HANDLERS ==========
    if ($action === 'add_pricing') {
        $features = json_encode(explode("\n", str_replace("\r", "", $_POST['features'])));
        $stmt = $db->prepare("INSERT INTO pricing_plans (name, price, currency, period, description, features, popular, cta_text, cta_link, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['price'], $_POST['currency'], $_POST['period'], $_POST['description'], $features, isset($_POST['popular']) ? 1 : 0, $_POST['cta_text'], $_POST['cta_link'], (int)$_POST['sort_order'], $_POST['status']]);
        $success = 'Pricing plan added!';
    }
    if ($action === 'edit_pricing') {
        $features = json_encode(explode("\n", str_replace("\r", "", $_POST['features'])));
        $stmt = $db->prepare("UPDATE pricing_plans SET name=?, price=?, currency=?, period=?, description=?, features=?, popular=?, cta_text=?, cta_link=?, sort_order=?, status=? WHERE id=?");
        $stmt->execute([$_POST['name'], $_POST['price'], $_POST['currency'], $_POST['period'], $_POST['description'], $features, isset($_POST['popular']) ? 1 : 0, $_POST['cta_text'], $_POST['cta_link'], (int)$_POST['sort_order'], $_POST['status'], (int)$_POST['id']]);
        $success = 'Pricing plan updated!';
    }
    if ($action === 'delete_pricing') {
        $stmt = $db->prepare("DELETE FROM pricing_plans WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        $success = 'Pricing plan deleted!';
    }
    if ($action === 'confirm_order') {
        $stmt = $db->prepare("UPDATE orders SET status = 'paid' WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
        logActivity($_SESSION['admin_id'], 'confirm_order', 'Confirmed order ID: ' . $_POST['id']);
        $success = 'Order marked as paid!';
    }

    // ========== IMAGE UPLOAD ==========
    $uploadFile = $_FILES['image'] ?? $_FILES['hero_image_file'] ?? null;
    if ($action === 'upload_image' && $uploadFile && $uploadFile['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg','jpeg','png','gif','webp','svg'];
        $ext = strtolower(pathinfo($uploadFile['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $uploadFile['name']);
            $dest = __DIR__ . '/../uploads/' . $filename;
            if (move_uploaded_file($uploadFile['tmp_name'], $dest)) {
                $url = 'uploads/' . $filename;
                $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
                $stmt->execute([$_POST['setting_key'], $url]);
                $success = 'Image uploaded!';
                $settings = getAllSettings();
            } else {
                $error = 'Upload failed.';
            }
        } else {
            $error = 'Invalid file type.';
        }
    }

    // Refresh page to avoid resubmission
    if ($success) {
        $params = ['success' => $success];
        if ($activeTab) {
            $params['tab'] = $activeTab;
        }
        header("Location: dashboard.php?" . http_build_query($params));
        exit;
    }
}

// Get data based on active tab
$projects = $db->query("SELECT * FROM projects ORDER BY sort_order ASC")->fetchAll();
$services = $db->query("SELECT * FROM services ORDER BY sort_order ASC")->fetchAll();
$testimonials = $db->query("SELECT * FROM testimonials ORDER BY sort_order ASC")->fetchAll();
$blogPosts = $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();
$messages = $db->query("SELECT * FROM contacts ORDER BY created_at DESC")->fetchAll();
$hireRequests = $db->query("SELECT * FROM hire_requests ORDER BY created_at DESC")->fetchAll();
$skills = $db->query("SELECT * FROM skills ORDER BY sort_order ASC")->fetchAll();
$experiences = $db->query("SELECT * FROM experiences ORDER BY sort_order ASC")->fetchAll();
$navItems = $db->query("SELECT * FROM nav_items ORDER BY sort_order ASC")->fetchAll();
$pricingPlans = $db->query("SELECT * FROM pricing_plans ORDER BY sort_order ASC")->fetchAll();
$orders = $db->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll();
$activityLogs = getActivityLogs(10);

$success = $_GET['success'] ?? $success;
?><!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Alenmodwebhub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <style>
    .ql-editor { min-height: 200px; font-family: Inter, sans-serif; font-size: 15px; line-height: 1.7; }
    .ql-toolbar { border-radius: 8px 8px 0 0; background: #f8f9fa; }
    .ql-container { border-radius: 0 0 8px 8px; }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.editor-html').forEach(el => {
            const textarea = el;
            const div = document.createElement('div');
            div.className = 'quill-editor';
            div.style.cssText = 'border:1px solid var(--border-glass);border-radius:8px;background:var(--bg-card);';
            textarea.parentNode.insertBefore(div, textarea);
            textarea.style.display = 'none';
            const quill = new Quill(div, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [1,2,3,false] }],
                        ['bold','italic','underline','strike'],
                        [{ color: [] }, { background: [] }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['blockquote','code-block'],
                        ['link','image'],
                        ['clean']
                    ]
                }
            });
            quill.on('text-change', () => {
                textarea.value = quill.root.innerHTML;
            });
            if (textarea.value) {
                quill.root.innerHTML = textarea.value;
            }
        });
    });
    </script>
</head>
<body>
    <div class="admin-dashboard">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <a href="dashboard.php" class="admin-sidebar-logo">Aleci Dev</a>
            <nav>
                <a href="?tab=dashboard" class="admin-nav-item <?php echo $activeTab === 'dashboard' ? 'active' : ''; ?>">
                    <span>📊</span> Dashboard
                </a>
                <a href="?tab=projects" class="admin-nav-item <?php echo $activeTab === 'projects' ? 'active' : ''; ?>">
                    <span>💻</span> Projects
                </a>
                <a href="?tab=blog" class="admin-nav-item <?php echo $activeTab === 'blog' ? 'active' : ''; ?>">
                    <span>📝</span> Blog
                </a>
                <a href="?tab=testimonials" class="admin-nav-item <?php echo $activeTab === 'testimonials' ? 'active' : ''; ?>">
                    <span>⭐</span> Testimonials
                </a>
                <a href="?tab=messages" class="admin-nav-item <?php echo $activeTab === 'messages' ? 'active' : ''; ?>">
                    <span>✉️</span> Messages
                    <?php if ($stats['unread_messages'] > 0): ?>
                    <span style="margin-left: auto; background: var(--error); color: white; padding: 0.1rem 0.5rem; border-radius: var(--radius-full); font-size: 0.7rem;"><?php echo $stats['unread_messages']; ?></span>
                    <?php endif; ?>
                </a>
                <a href="?tab=hire" class="admin-nav-item <?php echo $activeTab === 'hire' ? 'active' : ''; ?>">
                    <span>🤝</span> Hire Requests
                    <?php if (($stats['unread_hires'] ?? 0) > 0): ?>
                    <span style="margin-left: auto; background: var(--error); color: white; padding: 0.1rem 0.5rem; border-radius: var(--radius-full); font-size: 0.7rem;"><?php echo $stats['unread_hires']; ?></span>
                    <?php endif; ?>
                </a>
                <a href="?tab=services" class="admin-nav-item <?php echo $activeTab === 'services' ? 'active' : ''; ?>">
                    <span>🔧</span> Services
                </a>
                <a href="?tab=skills" class="admin-nav-item <?php echo $activeTab === 'skills' ? 'active' : ''; ?>">
                    <span>🎯</span> Skills
                </a>
                <a href="?tab=experience" class="admin-nav-item <?php echo $activeTab === 'experience' ? 'active' : ''; ?>">
                    <span>📅</span> Experience
                </a>
                <a href="?tab=pricing" class="admin-nav-item <?php echo $activeTab === 'pricing' ? 'active' : ''; ?>">
                    <span>💎</span> Pricing
                </a>
                <a href="?tab=orders" class="admin-nav-item <?php echo $activeTab === 'orders' ? 'active' : ''; ?>">
                    <span>📦</span> Orders
                </a>
                <a href="?tab=menus" class="admin-nav-item <?php echo $activeTab === 'menus' ? 'active' : ''; ?>">
                    <span>📋</span> Menus
                </a>
                <a href="?tab=settings" class="admin-nav-item <?php echo $activeTab === 'settings' ? 'active' : ''; ?>">
                    <span>⚙️</span> Settings
                </a>
                <hr style="border-color: var(--border-glass); margin: 1rem 0;">
                <a href="<?php echo BASE_URL; ?>/" class="admin-nav-item" target="_blank">
                    <span>👁️</span> View Site
                </a>
                <a href="logout.php" class="admin-nav-item" style="color: var(--error);">
                    <span>🚪</span> Logout
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <h1 class="admin-header-title">
                    <?php
                    $titles = [
                        'dashboard' => 'Dashboard Overview',
                        'projects' => 'Manage Projects',
                        'blog' => 'Manage Blog Posts',
                        'testimonials' => 'Manage Testimonials',
                        'messages' => 'Contact Messages',
                        'hire' => 'Hire Requests',
                        'services' => 'Manage Services',
                        'skills' => 'Manage Skills',
                        'experience' => 'Manage Experience',
                        'settings' => 'Site Settings',
                        'menus' => 'Manage Menus',
                        'pricing' => 'Manage Pricing Plans',
                        'orders' => 'Manage Orders'
                    ];
                    echo $titles[$activeTab] ?? 'Dashboard';
                    ?>
                </h1>
                <div class="admin-user-info">
                    <span style="color: var(--text-secondary);"><?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
                    <span class="admin-badge info">Admin</span>
                </div>
            </div>

            <?php if ($success): ?>
            <div class="admin-alert success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <input type="hidden" id="csrf_token" value="<?php echo htmlspecialchars(getCsrfToken()); ?>">
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var token = document.getElementById('csrf_token').value;
                document.querySelectorAll('form').forEach(function(form) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'csrf_token';
                    input.value = token;
                    form.appendChild(input);
                });
            });
            </script>

            <!-- ======================== -->
            <!-- DASHBOARD TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'dashboard'): ?>
            <div class="admin-stats-grid">
                <div class="admin-stat-card">
                    <div class="admin-stat-number"><?php echo $stats['projects']; ?></div>
                    <div class="admin-stat-label">Total Projects</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-number"><?php echo $stats['blog_posts']; ?></div>
                    <div class="admin-stat-label">Blog Posts</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-number"><?php echo $stats['messages']; ?></div>
                    <div class="admin-stat-label">Contact Messages</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-number"><?php echo $stats['testimonials']; ?></div>
                    <div class="admin-stat-label">Testimonials</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-number"><?php echo $stats['services']; ?></div>
                    <div class="admin-stat-label">Active Services</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-number"><?php echo $stats['visitors_today']; ?></div>
                    <div class="admin-stat-label">Visitors Today</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-number"><?php echo $stats['visitors']; ?></div>
                    <div class="admin-stat-label">Total Visitors</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-number"><?php echo $stats['unread_messages']; ?></div>
                    <div class="admin-stat-label">Unread Messages</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-number"><?php echo $stats['hires'] ?? 0; ?></div>
                    <div class="admin-stat-label">Hire Requests</div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-number"><?php echo $stats['unread_hires'] ?? 0; ?></div>
                    <div class="admin-stat-label">Unread Hire Requests</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Quick Actions</h2>
                </div>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="?tab=projects" class="btn btn-primary btn-sm">Add Project</a>
                    <a href="?tab=blog" class="btn btn-secondary btn-sm">Write Blog Post</a>
                    <a href="?tab=testimonials" class="btn btn-secondary btn-sm">Add Testimonial</a>
                    <a href="?tab=messages" class="btn btn-secondary btn-sm">View Messages</a>
                    <a href="?tab=hire" class="btn btn-secondary btn-sm">View Hire Requests</a>
                    <a href="?tab=settings" class="btn btn-secondary btn-sm">Update Settings</a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Recent Activity</h2>
                </div>
                <?php if (count($activityLogs) > 0): ?>
                <?php foreach ($activityLogs as $log): ?>
                <div class="activity-item">
                    <div class="activity-icon">🔵</div>
                    <div class="activity-content">
                        <div class="activity-action"><?php echo htmlspecialchars($log['action']); ?></div>
                        <?php if ($log['details']): ?>
                        <div class="activity-details"><?php echo htmlspecialchars($log['details']); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="activity-time"><?php echo formatDate($log['created_at'], 'M d, H:i'); ?></div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p style="color: var(--text-tertiary);">No activity logged yet.</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- PROJECTS TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'projects'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">All Projects</h2>
                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('addProjectModal').style.display='flex'">+ Add Project</button>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Sort</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $p): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($p['title']); ?></strong></td>
                            <td><?php echo htmlspecialchars($p['category']); ?></td>
                            <td><span class="admin-badge <?php echo $p['status'] === 'published' ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($p['status']); ?></span></td>
                            <td><?php echo $p['sort_order']; ?></td>
                            <td>
                                <form method="POST" style="display:inline" onsubmit="return confirm('Delete this project?')">
                                    <input type="hidden" name="action" value="delete_project">
                                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
            </div>

            <!-- Add Project Modal -->
            <div class="modal-overlay" id="addProjectModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Add New Project</h2>
                        <button class="modal-close" onclick="document.getElementById('addProjectModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="add_project">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Title *</label>
                                <input type="text" name="title" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Category</label>
                                <input type="text" name="category" class="admin-form-input" placeholder="Web Application, E-commerce, Dashboard">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Description</label>
                            <textarea name="description" class="admin-form-textarea editor-html"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Content (Full details)</label>
                            <textarea name="content" class="admin-form-textarea editor-html" style="min-height: 200px;"></textarea>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Technologies (JSON array)</label>
                                <input type="text" name="technologies" class="admin-form-input" placeholder='["PHP","MySQL","React"]'>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="admin-form-input" value="0">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Live URL</label>
                                <input type="url" name="live_url" class="admin-form-input">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">GitHub URL</label>
                                <input type="url" name="github_url" class="admin-form-input">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Problem Solved</label>
                                <textarea name="problem_solved" class="admin-form-textarea editor-html"></textarea>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Results</label>
                                <textarea name="results" class="admin-form-textarea editor-html"></textarea>
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Status</label>
                                <select name="status" class="admin-form-select">
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Project</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- BLOG TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'blog'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">All Blog Posts</h2>
                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('addBlogModal').style.display='flex'">+ Add Post</button>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($blogPosts as $post): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($post['title']); ?></strong></td>
                            <td><?php echo htmlspecialchars($post['category']); ?></td>
<td><span class="admin-badge <?php echo $post['status'] === 'published' ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($post['status']); ?></span></td>
                            <td><?php echo formatDate($post['created_at'], 'M d, Y'); ?></td>
                            <td>
                                <form method="POST" style="display:inline" onsubmit="return confirm('Delete this post?')">
                                    <input type="hidden" name="action" value="delete_blog">
                                    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
            </div>

            <!-- Add Blog Modal -->
            <div class="modal-overlay" id="addBlogModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Add New Blog Post</h2>
                        <button class="modal-close" onclick="document.getElementById('addBlogModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="add_blog">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Title *</label>
                                <input type="text" name="title" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Category</label>
                                <input type="text" name="category" class="admin-form-input" placeholder="Technology, Development, Business">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Excerpt</label>
                            <textarea name="excerpt" class="admin-form-textarea editor-html"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Content (HTML)</label>
                            <textarea name="content" class="admin-form-textarea editor-html" style="min-height: 300px;"></textarea>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Tags (comma separated)</label>
                                <input type="text" name="tags" class="admin-form-input" placeholder="tag1, tag2, tag3">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Status</label>
                                <select name="status" class="admin-form-select">
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Post</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- TESTIMONIALS TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'testimonials'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">All Testimonials</h2>
                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('addTestimonialModal').style.display='flex'">+ Add Testimonial</button>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testimonials as $t): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($t['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($t['company']); ?></td>
                            <td><?php echo str_repeat('★', (int)$t['rating']); ?></td>
                            <td><span class="admin-badge <?php echo $t['status'] === 'published' ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($t['status']); ?></span></td>
                            <td>
                                <form method="POST" style="display:inline" onsubmit="return confirm('Delete this testimonial?')">
                                    <input type="hidden" name="action" value="delete_testimonial">
                                    <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="modal-overlay" id="addTestimonialModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Add Testimonial</h2>
                        <button class="modal-close" onclick="document.getElementById('addTestimonialModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="add_testimonial">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Name *</label>
                                <input type="text" name="name" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Company</label>
                                <input type="text" name="company" class="admin-form-input">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Role</label>
                                <input type="text" name="role" class="admin-form-input" placeholder="CEO, Founder, etc.">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Rating (1-5)</label>
                                <input type="number" name="rating" class="admin-form-input" min="1" max="5" value="5">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Testimonial Content *</label>
                            <textarea name="content" class="admin-form-textarea editor-html" required></textarea>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="admin-form-input" value="0">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Status</label>
                                <select name="status" class="admin-form-select">
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Testimonial</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- MESSAGES TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'messages'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Contact Messages (<?php echo count($messages); ?>)</h2>
                </div>
                <?php if (count($messages) > 0): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                        <tr style="<?php echo !$msg['is_read'] ? 'background: var(--primary-glow);' : ''; ?>">
                            <td><strong><?php echo htmlspecialchars($msg['name']); ?></strong></td>
                            <td><a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>"><?php echo htmlspecialchars($msg['email']); ?></a></td>
                            <td><?php echo htmlspecialchars($msg['subject'] ?: 'No subject'); ?></td>
                            <td>
                                <?php if (!$msg['is_read']): ?>
                                <span class="admin-badge warning">Unread</span>
                                <?php else: ?>
                                <span class="admin-badge success">Read</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo formatDate($msg['created_at'], 'M d, H:i'); ?></td>
                            <td>
                                <?php if (!$msg['is_read']): ?>
                                <form method="POST" style="display:inline">
                                    <input type="hidden" name="action" value="mark_read">
                                    <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">Mark Read</button>
                                </form>
                                <?php endif; ?>
                                <form method="POST" style="display:inline" onsubmit="return confirm('Delete this message?')">
                                    <input type="hidden" name="action" value="delete_message">
                                    <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php if (!$msg['is_read']): ?>
                        <tr style="<?php echo !$msg['is_read'] ? 'background: var(--primary-glow);' : ''; ?>">
                            <td colspan="6" style="padding: 0.5rem 1rem 1rem; font-size: 0.9rem; color: var(--text-secondary);">
                                <strong>Message:</strong> <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color: var(--text-tertiary); padding: 2rem; text-align: center;">No messages yet.</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- SERVICES TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'services'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">All Services</h2>
                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('addServiceModal').style.display='flex'">+ Add Service</button>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Sort</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $s): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($s['title']); ?></strong></td>
                            <td><?php echo $s['price'] ? htmlspecialchars($settings['default_currency_symbol'] ?? '$') . number_format((float)$s['price'], 0) : 'Custom'; ?></td>
                            <td><span class="admin-badge <?php echo $s['status'] === 'active' ? 'success' : 'warning'; ?>"><?php echo $s['status']; ?></span></td>
                            <td><?php echo $s['sort_order']; ?></td>
                            <td>
                                <button class="admin-btn admin-btn-sm" onclick="openEditService(<?php echo $s['id']; ?>)">Edit</button>
                                <form method="POST" style="display:inline" onsubmit="return confirm('Delete this service?')">
                                    <input type="hidden" name="action" value="delete_service">
                                    <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Edit Service Modal -->
            <div class="modal-overlay" id="editServiceModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Edit Service</h2>
                        <button class="modal-close" onclick="document.getElementById('editServiceModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="edit_service">
                        <input type="hidden" name="id" id="edit_service_id">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Title *</label>
                                <input type="text" name="title" id="edit_service_title" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Icon</label>
                                <input type="text" name="icon" id="edit_service_icon" class="admin-form-input" placeholder="code, cloud, dashboard, cart">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Description</label>
                            <textarea name="description" id="edit_service_description" class="admin-form-textarea editor-html"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Features (one per line)</label>
                            <textarea name="features" id="edit_service_features" class="admin-form-textarea" placeholder="Feature 1"></textarea>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Price</label>
                                <input type="number" name="price" id="edit_service_price" class="admin-form-input" step="0.01">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Price Label</label>
                                <input type="text" name="price_label" id="edit_service_price_label" class="admin-form-input" placeholder="Starting at $1,500">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Sort Order</label>
                                <input type="number" name="sort_order" id="edit_service_sort_order" class="admin-form-input" value="0">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Status</label>
                                <select name="status" id="edit_service_status" class="admin-form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Service</button>
                    </form>
                </div>
            </div>

            <div class="modal-overlay" id="addServiceModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Add Service</h2>
                        <button class="modal-close" onclick="document.getElementById('addServiceModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="add_service">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Title *</label>
                                <input type="text" name="title" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Icon (emoji name)</label>
                                <input type="text" name="icon" class="admin-form-input" value="code" placeholder="code, cloud, dashboard, cart">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Description</label>
                            <textarea name="description" class="admin-form-textarea editor-html"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Features (one per line)</label>
                            <textarea name="features" class="admin-form-textarea" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Price</label>
                                <input type="number" name="price" class="admin-form-input" step="0.01">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Price Label</label>
                                <input type="text" name="price_label" class="admin-form-input" placeholder="Starting at $1,500">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="admin-form-input" value="0">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Status</label>
                                <select name="status" class="admin-form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Service</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- SKILLS TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'skills'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">All Skills</h2>
                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('addSkillModal').style.display='flex'">+ Add Skill</button>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Level</th>
                            <th>Sort</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($skills as $skill): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($skill['name']); ?></strong></td>
                            <td><span class="admin-badge info"><?php echo htmlspecialchars($skill['category']); ?></span></td>
                            <td><?php echo (int)$skill['level']; ?>%</td>
                            <td><?php echo $skill['sort_order']; ?></td>
                            <td>
                                <button class="admin-btn admin-btn-sm" onclick="openEditSkill(<?php echo $skill['id']; ?>)">Edit</button>
                                <form method="POST" style="display:inline" onsubmit="return confirm('Delete this skill?')">
                                    <input type="hidden" name="action" value="delete_skill">
                                    <input type="hidden" name="id" value="<?php echo $skill['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Edit Skill Modal -->
            <div class="modal-overlay" id="editSkillModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Edit Skill</h2>
                        <button class="modal-close" onclick="document.getElementById('editSkillModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="edit_skill">
                        <input type="hidden" name="id" id="edit_skill_id">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Name *</label>
                                <input type="text" name="name" id="edit_skill_name" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Level (0-100)</label>
                                <input type="number" name="level" id="edit_skill_level" class="admin-form-input" min="0" max="100">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Category</label>
                                <select name="category" id="edit_skill_category" class="admin-form-select">
                                    <option value="frontend">Frontend</option>
                                    <option value="backend">Backend</option>
                                    <option value="database">Database</option>
                                    <option value="tools">Tools & DevOps</option>
                                    <option value="mobile">Mobile</option>
                                </select>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Sort Order</label>
                                <input type="number" name="sort_order" id="edit_skill_sort_order" class="admin-form-input" value="0">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Skill</button>
                    </form>
                </div>
            </div>

            <div class="modal-overlay" id="addSkillModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Add Skill</h2>
                        <button class="modal-close" onclick="document.getElementById('addSkillModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="add_skill">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Name *</label>
                                <input type="text" name="name" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Level (0-100)</label>
                                <input type="number" name="level" class="admin-form-input" min="0" max="100" value="80">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Category</label>
                                <select name="category" class="admin-form-select">
                                    <option value="frontend">Frontend</option>
                                    <option value="backend">Backend</option>
                                    <option value="database">Database</option>
                                    <option value="tools">Tools & DevOps</option>
                                </select>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="admin-form-input" value="0">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Skill</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- EXPERIENCE TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'experience'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Work Experience</h2>
                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('addExpModal').style.display='flex'">+ Add Experience</button>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Type</th>
                            <th>Period</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($experiences as $exp): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($exp['title']); ?></strong></td>
                            <td><?php echo htmlspecialchars($exp['company'] ?: '—'); ?></td>
                            <td><span class="admin-badge info"><?php echo htmlspecialchars($exp['type']); ?></span></td>
                            <td><?php echo $exp['start_date'] ? formatDate($exp['start_date'], 'M Y') : ''; ?> - <?php echo $exp['current'] ? 'Present' : ($exp['end_date'] ? formatDate($exp['end_date'], 'M Y') : ''); ?></td>
                            <td>
                                <button class="admin-btn admin-btn-sm" onclick="openEditExp(<?php echo $exp['id']; ?>)">Edit</button>
                                <form method="POST" style="display:inline" onsubmit="return confirm('Delete this experience?')">
                                    <input type="hidden" name="action" value="delete_experience">
                                    <input type="hidden" name="id" value="<?php echo $exp['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Edit Experience Modal -->
            <div class="modal-overlay" id="editExpModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Edit Experience</h2>
                        <button class="modal-close" onclick="document.getElementById('editExpModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="edit_experience">
                        <input type="hidden" name="id" id="edit_exp_id">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Title *</label>
                                <input type="text" name="title" id="edit_exp_title" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Company</label>
                                <input type="text" name="company" id="edit_exp_company" class="admin-form-input">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Location</label>
                                <input type="text" name="location" id="edit_exp_location" class="admin-form-input" placeholder="Nigeria (Remote)">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Type</label>
                                <select name="type" id="edit_exp_type" class="admin-form-select">
                                    <option value="freelance">Freelance</option>
                                    <option value="contract">Contract</option>
                                    <option value="fulltime">Full-time</option>
                                </select>
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Start Date</label>
                                <input type="date" name="start_date" id="edit_exp_start" class="admin-form-input">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">End Date</label>
                                <input type="date" name="end_date" id="edit_exp_end" class="admin-form-input">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <input type="checkbox" name="current" id="edit_exp_current" value="1"> Currently working here
                            </label>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Description</label>
                            <textarea name="description" id="edit_exp_description" class="admin-form-textarea editor-html"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="edit_exp_sort" class="admin-form-input" value="0">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Experience</button>
                    </form>
                </div>
            </div>

            <div class="modal-overlay" id="addExpModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Add Experience</h2>
                        <button class="modal-close" onclick="document.getElementById('addExpModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="add_experience">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Title *</label>
                                <input type="text" name="title" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Company</label>
                                <input type="text" name="company" class="admin-form-input">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Location</label>
                                <input type="text" name="location" class="admin-form-input" placeholder="Nigeria (Remote)">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Type</label>
                                <select name="type" class="admin-form-select">
                                    <option value="freelance">Freelance</option>
                                    <option value="contract">Contract</option>
                                    <option value="fulltime">Full-time</option>
                                </select>
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Start Date</label>
                                <input type="date" name="start_date" class="admin-form-input">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">End Date</label>
                                <input type="date" name="end_date" class="admin-form-input">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <input type="checkbox" name="current" value="1"> Currently working here
                            </label>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Description</label>
                            <textarea name="description" class="admin-form-textarea editor-html"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="admin-form-input" value="0">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Experience</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- ORDERS TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'orders'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Orders (<?php echo count($orders); ?>)</h2>
                </div>
                <?php if (count($orders) > 0): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $o): ?>
                        <tr>
                            <td style="white-space:nowrap;font-size:0.8rem;"><?php echo date('M j, Y', strtotime($o['created_at'])); ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($o['customer_name']); ?></strong>
                                <br><small style="color:var(--text-muted);"><?php echo htmlspecialchars($o['customer_email']); ?><?php echo $o['customer_phone'] ? ' | ' . htmlspecialchars($o['customer_phone']) : ''; ?></small>
                            </td>
                            <td><span class="admin-badge info"><?php echo htmlspecialchars($o['plan_name']); ?></span></td>
                            <td><strong><?php echo htmlspecialchars($o['plan_price']); ?></strong></td>
                            <td><?php echo strtoupper(str_replace('_', ' ', htmlspecialchars($o['payment_method']))); ?></td>
                            <td>
                                <span class="admin-badge <?php echo $o['status'] === 'paid' ? 'success' : ($o['status'] === 'pending' ? 'warning' : 'info'); ?>">
                                    <?php echo htmlspecialchars(ucfirst($o['status'])); ?>
                                </span>
                                <?php if ($o['status'] === 'pending'): ?>
                                <form method="POST" style="display:inline;margin-left:0.3rem;">
                                    <input type="hidden" name="action" value="confirm_order">
                                    <input type="hidden" name="id" value="<?php echo $o['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-sm" style="background:var(--success);color:white;" onclick="return confirm('Mark as paid?')">✓</button>
                                </form>
                                <?php endif; ?>
                                <?php if ($o['notes']): ?>
                                <br><small style="color:var(--text-muted);font-size:0.75rem;"><?php echo htmlspecialchars($o['notes']); ?></small>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color:var(--text-tertiary);padding:2rem;text-align:center;">No orders yet.</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- PRICING TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'pricing'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Pricing Plans</h2>
                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('addPricingModal').style.display='flex'">+ Add Plan</button>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Popular</th>
                            <th>Sort</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pricingPlans as $plan): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($plan['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars(($settings['default_currency_symbol'] ?? '$') . $plan['price']); ?> <small style="color:var(--text-muted)">/ <?php echo htmlspecialchars($plan['period']); ?></small></td>
                            <td><?php echo $plan['popular'] ? '<span class="admin-badge success">Popular</span>' : ''; ?></td>
                            <td><?php echo $plan['sort_order']; ?></td>
                            <td><span class="admin-badge <?php echo $plan['status'] === 'active' ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($plan['status']); ?></span></td>
                            <td>
                                <button class="admin-btn admin-btn-sm" onclick="openEditPricing(<?php echo $plan['id']; ?>)">Edit</button>
                                <form method="POST" style="display:inline" onsubmit="return confirm('Delete this plan?')">
                                    <input type="hidden" name="action" value="delete_pricing">
                                    <input type="hidden" name="id" value="<?php echo $plan['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Pricing Modal -->
            <div class="modal-overlay" id="addPricingModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Add Pricing Plan</h2>
                        <button class="modal-close" onclick="document.getElementById('addPricingModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="add_pricing">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Plan Name *</label>
                                <input type="text" name="name" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Price</label>
                                <input type="text" name="price" class="admin-form-input" value="Custom" placeholder="500 or Custom">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Currency</label>
                                <input type="text" name="currency" class="admin-form-input" value="<?php echo htmlspecialchars($settings['default_currency_symbol'] ?? '$'); ?>" maxlength="5">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Period</label>
                                <input type="text" name="period" class="admin-form-input" value="per project">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Description</label>
                            <textarea name="description" class="admin-form-textarea editor-html"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Features (one per line)</label>
                            <textarea name="features" class="admin-form-textarea" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">CTA Text</label>
                                <input type="text" name="cta_text" class="admin-form-input" value="Get Started">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">CTA Link</label>
                                <input type="text" name="cta_link" class="admin-form-input" value="#contact">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="admin-form-input" value="0">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Status</label>
                                <select name="status" class="admin-form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <input type="checkbox" name="popular" value="1"> Mark as Popular
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Plan</button>
                    </form>
                </div>
            </div>

            <!-- Edit Pricing Modal -->
            <div class="modal-overlay" id="editPricingModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Edit Pricing Plan</h2>
                        <button class="modal-close" onclick="document.getElementById('editPricingModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="edit_pricing">
                        <input type="hidden" name="id" id="edit_pricing_id">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Plan Name *</label>
                                <input type="text" name="name" id="edit_pricing_name" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Price</label>
                                <input type="text" name="price" id="edit_pricing_price" class="admin-form-input" placeholder="500 or Custom">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Currency</label>
                                <input type="text" name="currency" id="edit_pricing_currency" class="admin-form-input" value="<?php echo htmlspecialchars($settings['default_currency_symbol'] ?? '$'); ?>" maxlength="5">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Period</label>
                                <input type="text" name="period" id="edit_pricing_period" class="admin-form-input" value="per project">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Description</label>
                            <textarea name="description" id="edit_pricing_description" class="admin-form-textarea editor-html"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Features (one per line)</label>
                            <textarea name="features" id="edit_pricing_features" class="admin-form-textarea" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">CTA Text</label>
                                <input type="text" name="cta_text" id="edit_pricing_cta_text" class="admin-form-input">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">CTA Link</label>
                                <input type="text" name="cta_link" id="edit_pricing_cta_link" class="admin-form-input">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Sort Order</label>
                                <input type="number" name="sort_order" id="edit_pricing_sort_order" class="admin-form-input" value="0">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Status</label>
                                <select name="status" id="edit_pricing_status" class="admin-form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <input type="checkbox" name="popular" id="edit_pricing_popular" value="1"> Mark as Popular
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Plan</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- HIRE REQUESTS TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'hire'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Hire Requests (<?php echo count($hireRequests); ?>)</h2>
                </div>
                <?php if (count($hireRequests) > 0): ?>
                <div class="admin-table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email / Phone</th>
                                <th>Project Type</th>
                                <th>Budget</th>
                                <th>Timeline</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($hireRequests as $hr):
                            $hrFeatures = $hr['features'] ? explode(', ', $hr['features']) : [];
                            ?>
                            <tr style="<?php echo !$hr['is_read'] ? 'background: rgba(99, 102, 241, 0.05);' : ''; ?>">
                                <td style="white-space: nowrap; font-size: 0.8rem;"><?php echo date('M j, Y g:i A', strtotime($hr['created_at'])); ?></td>
                                <td><strong><?php echo htmlspecialchars($hr['name']); ?></strong><?php echo $hr['company'] ? '<br><small>' . htmlspecialchars($hr['company']) . '</small>' : ''; ?></td>
                                <td>
                                    <a href="mailto:<?php echo htmlspecialchars($hr['email']); ?>"><?php echo htmlspecialchars($hr['email']); ?></a>
                                    <?php if ($hr['phone']): ?><br><small><?php echo htmlspecialchars($hr['phone']); ?></small><?php endif; ?>
                                </td>
                                <td><span class="admin-badge info"><?php echo htmlspecialchars(str_replace('-', ' ', ucwords($hr['project_type']))); ?></span></td>
                                <td><strong><?php echo htmlspecialchars($hr['budget']); ?></strong></td>
                                <td><?php echo htmlspecialchars(ucwords(str_replace('-', ' ', $hr['timeline']))); ?></td>
                                <td>
                                    <?php if ($hr['is_read']): ?>
                                    <span class="admin-badge success">Read</span>
                                    <?php else: ?>
                                    <span class="admin-badge warning">New</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-secondary" onclick="toggleHireDetails(<?php echo $hr['id']; ?>)">View</button>
                                </td>
                            </tr>
                            <tr id="hire-details-<?php echo $hr['id']; ?>" style="display:none;">
                                <td colspan="8" style="padding: 1.5rem; background: var(--bg-tertiary);">
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                        <div>
                                            <strong style="color: var(--text-secondary); display: block; margin-bottom: 0.3rem;">Project Description</strong>
                                            <p style="line-height: 1.6;"><?php echo nl2br(htmlspecialchars($hr['description'])); ?></p>
                                        </div>
                                        <div>
                                            <strong style="color: var(--text-secondary); display: block; margin-bottom: 0.3rem;">Website Type</strong>
                                            <p><?php echo $hr['website_type'] ? htmlspecialchars(ucwords(str_replace('-', ' ', $hr['website_type']))) : 'N/A'; ?></p>
                                            <strong style="color: var(--text-secondary); display: block; margin: 0.8rem 0 0.3rem;">Requested Features</strong>
                                            <?php if (count($hrFeatures) > 0 && $hrFeatures[0] !== ''): ?>
                                            <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                                                <?php foreach ($hrFeatures as $f): ?>
                                                <span style="padding: 0.2rem 0.6rem; background: var(--bg-glass); border: 1px solid var(--border-glass); border-radius: var(--radius-full); font-size: 0.75rem;"><?php echo htmlspecialchars($f); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php else: ?>
                                            <p style="color: var(--text-muted); font-size: 0.85rem;">No specific features listed.</p>
                                            <?php endif; ?>
                                            <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                                                <a href="mailto:<?php echo htmlspecialchars($hr['email']); ?>?subject=Re: Hire Request - <?php echo htmlspecialchars(str_replace('-', ' ', ucwords($hr['project_type']))); ?>" class="btn btn-primary btn-sm">Reply via Email</a>
                                                <?php if (!$hr['is_read']): ?>
                                                <a href="?tab=hire&mark_read=<?php echo $hr['id']; ?>" class="btn btn-secondary btn-sm">Mark as Read</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p style="color: var(--text-tertiary); padding: 2rem; text-align: center;">No hire requests yet.</p>
                <?php endif; ?>
            </div>

            <script>
            function toggleHireDetails(id) {
                const row = document.getElementById('hire-details-' + id);
                if (row) {
                    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
                }
            }
            </script>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- MENUS TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'menus'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Navigation Menus</h2>
                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('addNavModal').style.display='flex'">+ Add Menu Item</button>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>URL</th>
                            <th>Location</th>
                            <th>Target</th>
                            <th>Sort</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($navItems as $nav): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($nav['label']); ?></strong><?php echo $nav['icon'] ? ' <span style="font-size:0.8rem;color:var(--text-muted)">(' . htmlspecialchars($nav['icon']) . ')</span>' : ''; ?></td>
                            <td><code><?php echo htmlspecialchars($nav['url']); ?></code></td>
                            <td><span class="admin-badge info"><?php echo htmlspecialchars($nav['location']); ?></span></td>
                            <td><?php echo $nav['target'] === '_blank' ? 'New tab' : 'Same tab'; ?></td>
                            <td><?php echo $nav['sort_order']; ?></td>
                            <td><span class="admin-badge <?php echo $nav['status'] === 'active' ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($nav['status']); ?></span></td>
                            <td>
                                <button class="admin-btn admin-btn-sm" onclick="openEditNav(<?php echo $nav['id']; ?>)">Edit</button>
                                <form method="POST" style="display:inline" onsubmit="return confirm('Delete this menu item?')">
                                    <input type="hidden" name="action" value="delete_nav">
                                    <input type="hidden" name="id" value="<?php echo $nav['id']; ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Nav Modal -->
            <div class="modal-overlay" id="addNavModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Add Menu Item</h2>
                        <button class="modal-close" onclick="document.getElementById('addNavModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="add_nav">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Label *</label>
                                <input type="text" name="label" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">URL</label>
                                <input type="text" name="url" class="admin-form-input" value="#hero">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Icon (emoji)</label>
                                <input type="text" name="icon" class="admin-form-input" placeholder="🔧, 🎯, etc.">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Location</label>
                                <select name="location" class="admin-form-select">
                                    <option value="header">Header</option>
                                    <option value="footer">Footer</option>
                                    <option value="both">Both</option>
                                </select>
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Target</label>
                                <select name="target" class="admin-form-select">
                                    <option value="_self">Same Tab</option>
                                    <option value="_blank">New Tab</option>
                                </select>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="admin-form-input" value="0">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Status</label>
                            <select name="status" class="admin-form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Menu Item</button>
                    </form>
                </div>
            </div>

            <!-- Edit Nav Modal -->
            <div class="modal-overlay" id="editNavModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Edit Menu Item</h2>
                        <button class="modal-close" onclick="document.getElementById('editNavModal').style.display='none'">&times;</button>
                    </div>
                    <form method="POST" class="admin-form">
                        <input type="hidden" name="action" value="edit_nav">
                        <input type="hidden" name="id" id="edit_nav_id">
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Label *</label>
                                <input type="text" name="label" id="edit_nav_label" class="admin-form-input" required>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">URL</label>
                                <input type="text" name="url" id="edit_nav_url" class="admin-form-input">
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Icon (emoji)</label>
                                <input type="text" name="icon" id="edit_nav_icon" class="admin-form-input">
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Location</label>
                                <select name="location" id="edit_nav_location" class="admin-form-select">
                                    <option value="header">Header</option>
                                    <option value="footer">Footer</option>
                                    <option value="both">Both</option>
                                </select>
                            </div>
                        </div>
                        <div class="admin-form-row">
                            <div class="admin-form-group">
                                <label class="admin-form-label">Target</label>
                                <select name="target" id="edit_nav_target" class="admin-form-select">
                                    <option value="_self">Same Tab</option>
                                    <option value="_blank">New Tab</option>
                                </select>
                            </div>
                            <div class="admin-form-group">
                                <label class="admin-form-label">Sort Order</label>
                                <input type="number" name="sort_order" id="edit_nav_sort_order" class="admin-form-input" value="0">
                            </div>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Status</label>
                            <select name="status" id="edit_nav_status" class="admin-form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Menu Item</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- ======================== -->
            <!-- SETTINGS TAB -->
            <!-- ======================== -->
            <?php if ($activeTab === 'settings'): ?>
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Site Settings</h2>
                </div>
                <form method="POST" class="admin-form" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update_settings">

                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">Hero Section</h3>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Hero Title</label>
                        <input type="text" name="hero_title" class="admin-form-input" value="<?php echo htmlspecialchars($settings['hero_title'] ?? ''); ?>">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Hero Subtitle</label>
                        <textarea name="hero_subtitle" class="admin-form-textarea editor-html"><?php echo htmlspecialchars($settings['hero_subtitle'] ?? ''); ?></textarea>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Availability Text</label>
                        <input type="text" name="hero_availability" class="admin-form-input" value="<?php echo htmlspecialchars($settings['hero_availability'] ?? ''); ?>">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">CV Download URL</label>
                        <input type="url" name="cv_url" class="admin-form-input" value="<?php echo htmlspecialchars($settings['cv_url'] ?? ''); ?>" placeholder="https://example.com/cv.pdf or /uploads/cv.pdf">
                    </div>

                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">Currency</h3>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Default Currency Symbol</label>
                            <input type="text" name="default_currency_symbol" class="admin-form-input" value="<?php echo htmlspecialchars($settings['default_currency_symbol'] ?? '$'); ?>" maxlength="5" placeholder="$">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Default Currency Code</label>
                            <input type="text" name="default_currency_code" class="admin-form-input" value="<?php echo htmlspecialchars($settings['default_currency_code'] ?? 'USD'); ?>" maxlength="5" placeholder="USD">
                        </div>
                    </div>

                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">Images</h3>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Hero Image</label>
                            <?php if (!empty($settings['hero_image'])): ?>
                            <div style="margin-bottom:0.5rem;"><img src="<?php echo BASE_URL . '/' . htmlspecialchars($settings['hero_image']); ?>" style="max-width:200px;border-radius:8px;border:1px solid var(--border-glass);"></div>
                            <?php endif; ?>
                            <input type="file" name="hero_image_file" class="admin-form-input" accept="image/*" onchange="this.form.querySelector('[name=action]').value='upload_image'; this.form.querySelector('[name=setting_key]').value='hero_image'; this.form.submit();">
                            <input type="hidden" name="setting_key" value="">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">About Image</label>
                            <?php if (!empty($settings['about_image'])): ?>
                            <div style="margin-bottom:0.5rem;"><img src="<?php echo BASE_URL . '/' . htmlspecialchars($settings['about_image']); ?>" style="max-width:200px;border-radius:8px;border:1px solid var(--border-glass);"></div>
                            <?php endif; ?>
                            <input type="file" name="image" class="admin-form-input" accept="image/*" onchange="this.form.querySelector('[name=action]').value='upload_image'; this.form.querySelector('[name=setting_key]').value='about_image'; this.form.submit();">
                        </div>
                    </div>

                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">About</h3>
                    <div class="admin-form-group">
                        <label class="admin-form-label">About Text</label>
                        <textarea name="about_text" class="admin-form-textarea editor-html" style="min-height: 200px;"><?php echo htmlspecialchars($settings['about_text'] ?? ''); ?></textarea>
                    </div>

                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">Contact</h3>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Email</label>
                            <input type="email" name="email" class="admin-form-input" value="<?php echo htmlspecialchars($settings['email'] ?? ''); ?>">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Phone</label>
                            <input type="text" name="phone" class="admin-form-input" value="<?php echo htmlspecialchars($settings['phone'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Location</label>
                            <input type="text" name="location" class="admin-form-input" value="<?php echo htmlspecialchars($settings['location'] ?? ''); ?>">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">WhatsApp Number</label>
                            <input type="text" name="whatsapp" class="admin-form-input" value="<?php echo htmlspecialchars($settings['whatsapp'] ?? ''); ?>" placeholder="2348012345678 (without +)">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Telegram Username/Link</label>
                            <input type="text" name="telegram_chat" class="admin-form-input" value="<?php echo htmlspecialchars($settings['telegram_chat'] ?? ''); ?>" placeholder="@username or https://t.me/username">
                        </div>
                    </div>

                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">Social Links</h3>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">GitHub</label>
                            <input type="url" name="github_url" class="admin-form-input" value="<?php echo htmlspecialchars($settings['github_url'] ?? ''); ?>">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">LinkedIn</label>
                            <input type="url" name="linkedin_url" class="admin-form-input" value="<?php echo htmlspecialchars($settings['linkedin_url'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Twitter</label>
                            <input type="url" name="twitter_url" class="admin-form-input" value="<?php echo htmlspecialchars($settings['twitter_url'] ?? ''); ?>">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Instagram</label>
                            <input type="url" name="instagram_url" class="admin-form-input" value="<?php echo htmlspecialchars($settings['instagram_url'] ?? ''); ?>">
                        </div>
                    </div>

                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">Stats</h3>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Years Experience</label>
                            <input type="number" name="experience_years" class="admin-form-input" value="<?php echo htmlspecialchars($settings['experience_years'] ?? 5); ?>">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Projects Count</label>
                            <input type="number" name="projects_count" class="admin-form-input" value="<?php echo htmlspecialchars($settings['projects_count'] ?? 50); ?>">
                        </div>
                    </div>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Clients Count</label>
                            <input type="number" name="clients_count" class="admin-form-input" value="<?php echo htmlspecialchars($settings['clients_count'] ?? 30); ?>">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Countries Count</label>
                            <input type="number" name="countries_count" class="admin-form-input" value="<?php echo htmlspecialchars($settings['countries_count'] ?? 8); ?>">
                        </div>
                    </div>

                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">SEO</h3>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Site Title</label>
                        <input type="text" name="site_title" class="admin-form-input" value="<?php echo htmlspecialchars($settings['site_title'] ?? ''); ?>">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Site Description</label>
                        <textarea name="site_description" class="admin-form-textarea editor-html"><?php echo htmlspecialchars($settings['site_description'] ?? ''); ?></textarea>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Site Keywords</label>
                        <input type="text" name="site_keywords" class="admin-form-input" value="<?php echo htmlspecialchars($settings['site_keywords'] ?? ''); ?>">
                    </div>

                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">Payment Settings</h3>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Bank Name (NGN)</label>
                            <input type="text" name="bank_name" class="admin-form-input" value="<?php echo htmlspecialchars($settings['bank_name'] ?? 'Access Bank'); ?>">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Account Name</label>
                            <input type="text" name="bank_account_name" class="admin-form-input" value="<?php echo htmlspecialchars($settings['bank_account_name'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Account Number (NGN)</label>
                            <input type="text" name="bank_account_number" class="admin-form-input" value="<?php echo htmlspecialchars($settings['bank_account_number'] ?? ''); ?>">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Account Number (USD)</label>
                            <input type="text" name="bank_account_usd" class="admin-form-input" value="<?php echo htmlspecialchars($settings['bank_account_usd'] ?? ''); ?>" placeholder="Bank, Account, Swift">
                        </div>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Bank Transfer NGN Details (shown to customer)</label>
                        <textarea name="bank_ngn_details" class="admin-form-textarea" style="min-height:80px;"><?php echo htmlspecialchars($settings['bank_ngn_details'] ?? ''); ?></textarea>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Bank Transfer USD Details (shown to customer)</label>
                        <textarea name="bank_usd_details" class="admin-form-textarea" style="min-height:80px;"><?php echo htmlspecialchars($settings['bank_usd_details'] ?? ''); ?></textarea>
                    </div>
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">USDT Wallet Address</label>
                            <input type="text" name="usdt_wallet" class="admin-form-input" value="<?php echo htmlspecialchars($settings['usdt_wallet'] ?? ''); ?>">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">USDT Network</label>
                            <input type="text" name="usdt_network" class="admin-form-input" value="<?php echo htmlspecialchars($settings['usdt_network'] ?? 'ERC20 / TRC20'); ?>">
                        </div>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">BTC Wallet Address</label>
                        <input type="text" name="btc_wallet" class="admin-form-input" value="<?php echo htmlspecialchars($settings['btc_wallet'] ?? ''); ?>">
                    </div>

                    <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">Footer</h3>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Footer Text</label>
                        <textarea name="footer_text" class="admin-form-textarea editor-html"><?php echo htmlspecialchars($settings['footer_text'] ?? ''); ?></textarea>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Copyright</label>
                        <input type="text" name="copyright_text" class="admin-form-input" value="<?php echo htmlspecialchars($settings['copyright_text'] ?? ''); ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Save All Settings</button>
                </form>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        // Close modals on overlay click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) overlay.style.display = 'none';
            });
        });

        const servicesData = <?php echo json_encode($services); ?>;
        const skillsData = <?php echo json_encode($skills); ?>;
        const experiencesData = <?php echo json_encode($experiences); ?>;
        const navItemsData = <?php echo json_encode($navItems); ?>;
        const pricingData = <?php echo json_encode($pricingPlans); ?>;

        function openEditService(id) {
            const s = servicesData.find(s => s.id == id);
            if (!s) return;
            document.getElementById('edit_service_id').value = s.id;
            document.getElementById('edit_service_title').value = s.title || '';
            document.getElementById('edit_service_icon').value = s.icon || '';
            document.getElementById('edit_service_description').value = s.description || '';
            document.getElementById('edit_service_features').value = (s.features ? JSON.parse(s.features) : []).join('\n');
            document.getElementById('edit_service_price').value = s.price || '';
            document.getElementById('edit_service_price_label').value = s.price_label || '';
            document.getElementById('edit_service_sort_order').value = s.sort_order || 0;
            document.getElementById('edit_service_status').value = s.status || 'active';
            document.getElementById('editServiceModal').style.display = 'flex';
        }

        function openEditSkill(id) {
            const sk = skillsData.find(s => s.id == id);
            if (!sk) return;
            document.getElementById('edit_skill_id').value = sk.id;
            document.getElementById('edit_skill_name').value = sk.name || '';
            document.getElementById('edit_skill_level').value = sk.level || '';
            document.getElementById('edit_skill_category').value = sk.category || 'frontend';
            document.getElementById('edit_skill_sort_order').value = sk.sort_order || 0;
            document.getElementById('editSkillModal').style.display = 'flex';
        }

        function openEditPricing(id) {
            const p = pricingData.find(x => x.id == id);
            if (!p) return;
            document.getElementById('edit_pricing_id').value = p.id;
            document.getElementById('edit_pricing_name').value = p.name || '';
            document.getElementById('edit_pricing_price').value = p.price || 'Custom';
            document.getElementById('edit_pricing_currency').value = p.currency || '<?php echo htmlspecialchars($settings['default_currency_symbol'] ?? '$', ENT_QUOTES); ?>';
            document.getElementById('edit_pricing_period').value = p.period || 'per project';
            document.getElementById('edit_pricing_description').value = p.description || '';
            document.getElementById('edit_pricing_features').value = (p.features ? JSON.parse(p.features) : []).join('\n');
            document.getElementById('edit_pricing_popular').checked = p.popular == 1;
            document.getElementById('edit_pricing_cta_text').value = p.cta_text || 'Get Started';
            document.getElementById('edit_pricing_cta_link').value = p.cta_link || '#contact';
            document.getElementById('edit_pricing_sort_order').value = p.sort_order || 0;
            document.getElementById('edit_pricing_status').value = p.status || 'active';
            document.getElementById('editPricingModal').style.display = 'flex';
        }

        function openEditNav(id) {
            const n = navItemsData.find(x => x.id == id);
            if (!n) return;
            document.getElementById('edit_nav_id').value = n.id;
            document.getElementById('edit_nav_label').value = n.label || '';
            document.getElementById('edit_nav_url').value = n.url || '';
            document.getElementById('edit_nav_icon').value = n.icon || '';
            document.getElementById('edit_nav_location').value = n.location || 'header';
            document.getElementById('edit_nav_target').value = n.target || '_self';
            document.getElementById('edit_nav_sort_order').value = n.sort_order || 0;
            document.getElementById('edit_nav_status').value = n.status || 'active';
            document.getElementById('editNavModal').style.display = 'flex';
        }

        function openEditExp(id) {
            const e = experiencesData.find(x => x.id == id);
            if (!e) return;
            document.getElementById('edit_exp_id').value = e.id;
            document.getElementById('edit_exp_title').value = e.title || '';
            document.getElementById('edit_exp_company').value = e.company || '';
            document.getElementById('edit_exp_location').value = e.location || '';
            document.getElementById('edit_exp_type').value = e.type || 'freelance';
            document.getElementById('edit_exp_start').value = e.start_date || '';
            document.getElementById('edit_exp_end').value = e.end_date || '';
            document.getElementById('edit_exp_current').checked = e.current == 1;
            document.getElementById('edit_exp_description').value = e.description || '';
            document.getElementById('edit_exp_sort').value = e.sort_order || 0;
            document.getElementById('editExpModal').style.display = 'flex';
        }
    </script>
</body>
</html>
