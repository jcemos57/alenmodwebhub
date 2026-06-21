<?php
// =============================================
// CORE FUNCTIONS
// =============================================

require_once __DIR__ . '/../config/database.php';

function getSetting($key, $default = '') {
    $db = getDB();
    if (!$db) return $default;
    try {
        $stmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        return $row ? $row['setting_value'] : $default;
    } catch (PDOException $e) {
        error_log("Error fetching setting: " . $e->getMessage());
        return $default;
    }
}

function getAllSettings() {
    static $cached = null;
    if ($cached !== null) return $cached;
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT setting_key, setting_value FROM site_settings");
        $cached = [];
        while ($row = $stmt->fetch()) {
            $cached[$row['setting_key']] = $row['setting_value'];
        }
        return $cached;
    } catch (PDOException $e) {
        error_log("Error fetching settings: " . $e->getMessage());
        return [];
    }
}

function getProjects($limit = null, $category = null) {
    $db = getDB();
    if (!$db) return [];
    try {
        $sql = "SELECT * FROM projects WHERE status = 'published'";
        $params = [];
        if ($category) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }
        $sql .= " ORDER BY sort_order ASC, created_at DESC";
        if ($limit) {
            $sql .= " LIMIT ?";
            $params[] = $limit;
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching projects: " . $e->getMessage());
        return [];
    }
}

function getProject($slug) {
    $db = getDB();
    if (!$db) return null;
    try {
        $stmt = $db->prepare("SELECT * FROM projects WHERE slug = ? AND status = 'published'");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error fetching project: " . $e->getMessage());
        return null;
    }
}

function getProjectCategories() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT DISTINCT category FROM projects WHERE status = 'published' ORDER BY category");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        error_log("Error fetching categories: " . $e->getMessage());
        return [];
    }
}

function getServices() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT * FROM services WHERE status = 'active' ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching services: " . $e->getMessage());
        return [];
    }
}

function getSkills() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT * FROM skills ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching skills: " . $e->getMessage());
        return [];
    }
}

function getSkillsByCategory() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT * FROM skills ORDER BY sort_order ASC");
        $skills = $stmt->fetchAll();
        $grouped = [];
        foreach ($skills as $skill) {
            $grouped[$skill['category']][] = $skill;
        }
        return $grouped;
    } catch (PDOException $e) {
        error_log("Error fetching skills: " . $e->getMessage());
        return [];
    }
}

function getTestimonials() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT * FROM testimonials WHERE status = 'published' ORDER BY sort_order ASC, created_at DESC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching testimonials: " . $e->getMessage());
        return [];
    }
}

function getExperiences() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT * FROM experiences ORDER BY sort_order ASC, start_date DESC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching experiences: " . $e->getMessage());
        return [];
    }
}

function getPricingPlans() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT * FROM pricing_plans WHERE status = 'active' ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching pricing plans: " . $e->getMessage());
        return [];
    }
}

function getNavItems($location = 'header') {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->prepare("SELECT * FROM nav_items WHERE status = 'active' AND (location = ? OR location = 'both') ORDER BY sort_order ASC");
        $stmt->execute([$location]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching nav items: " . $e->getMessage());
        return [];
    }
}

function getBlogPosts($limit = null, $category = null) {
    $db = getDB();
    if (!$db) return [];
    try {
        $sql = "SELECT * FROM blog_posts WHERE status = 'published'";
        $params = [];
        if ($category) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }
        $sql .= " ORDER BY created_at DESC";
        if ($limit) {
            $sql .= " LIMIT ?";
            $params[] = $limit;
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching blog posts: " . $e->getMessage());
        return [];
    }
}

function getBlogPost($slug) {
    $db = getDB();
    if (!$db) return null;
    try {
        $stmt = $db->prepare("SELECT * FROM blog_posts WHERE slug = ? AND status = 'published'");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error fetching blog post: " . $e->getMessage());
        return null;
    }
}

function getBlogCategories() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT DISTINCT category FROM blog_posts WHERE status = 'published' ORDER BY category");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        error_log("Error fetching blog categories: " . $e->getMessage());
        return [];
    }
}

function getComments($postId) {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->prepare("SELECT * FROM blog_comments WHERE post_id = ? AND approved = 1 AND parent_id IS NULL ORDER BY created_at DESC");
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching comments: " . $e->getMessage());
        return [];
    }
}

function getContactMessages($limit = null) {
    $db = getDB();
    if (!$db) return [];
    try {
        $sql = "SELECT * FROM contacts ORDER BY created_at DESC";
        if ($limit) {
            $sql .= " LIMIT ?";
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($limit ? [$limit] : []);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error fetching messages: " . $e->getMessage());
        return [];
    }
}

function getStats() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stats = [];
        $stats['projects'] = $db->query("SELECT COUNT(*) FROM projects WHERE status = 'published'")->fetchColumn();
        $stats['services'] = $db->query("SELECT COUNT(*) FROM services WHERE status = 'active'")->fetchColumn();
        $stats['testimonials'] = $db->query("SELECT COUNT(*) FROM testimonials WHERE status = 'published'")->fetchColumn();
        $stats['blog_posts'] = $db->query("SELECT COUNT(*) FROM blog_posts WHERE status = 'published'")->fetchColumn();
        $stats['messages'] = $db->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
        $stats['unread_messages'] = $db->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
        $stats['hires'] = $db->query("SELECT COUNT(*) FROM hire_requests")->fetchColumn();
        $stats['unread_hires'] = $db->query("SELECT COUNT(*) FROM hire_requests WHERE is_read = 0")->fetchColumn();
        $stats['visitors'] = $db->query("SELECT COUNT(*) FROM visitors")->fetchColumn();
        $stats['visitors_today'] = $db->query("SELECT COUNT(*) FROM visitors WHERE DATE(created_at) = CURDATE()")->fetchColumn();
        return $stats;
    } catch (PDOException $e) {
        error_log("Error fetching stats: " . $e->getMessage());
        return [];
    }
}

function logActivity($userId, $action, $details = null) {
    $db = getDB();
    if (!$db) return;
    try {
        $stmt = $db->prepare("INSERT INTO activity_logs (user_id, action, details, ip_address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $action, $details, $_SERVER['REMOTE_ADDR'] ?? null]);
    } catch (PDOException $e) {
        error_log("Error logging activity: " . $e->getMessage());
    }
}

function trackVisitor($page = '/') {
    $db = getDB();
    if (!$db) return;
    try {
        $stmt = $db->prepare("INSERT INTO visitors (ip_address, user_agent, page, referrer) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_SERVER['REMOTE_ADDR'] ?? null,
            $_SERVER['HTTP_USER_AGENT'] ?? null,
            $page,
            $_SERVER['HTTP_REFERER'] ?? null
        ]);
    } catch (PDOException $e) {
        // Silently fail for visitor tracking
    }
}

function formatDate($date, $format = 'M d, Y') {
    if (!$date) return '';
    $timestamp = strtotime($date);
    return date($format, $timestamp);
}

function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return $text ?: 'n-a';
}

function truncate($text, $length = 100) {
    if (strlen($text) <= $length) return $text;
    $truncated = substr($text, 0, $length);
    $lastSpace = strrpos($truncated, ' ');
    if ($lastSpace !== false) {
        $truncated = substr($truncated, 0, $lastSpace);
    }
    return $truncated . '...';
}

function getReadingTime($content) {
    $words = str_word_count(strip_tags($content));
    $minutes = ceil($words / 200);
    return max(1, $minutes);
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function isAuthenticated() {
    return isset($_SESSION['admin_id']);
}

function requireAuth() {
    if (!isAuthenticated()) {
        header('Location: ' . BASE_URL . '/admin/');
        exit;
    }
}

function getActivityLogs($limit = 20) {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->prepare("SELECT al.*, u.name as user_name FROM activity_logs al LEFT JOIN users u ON al.user_id = u.id ORDER BY al.created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function getSubscribers() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT * FROM subscribers ORDER BY created_at DESC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function subscribeEmail($email) {
    $db = getDB();
    if (!$db) return false;
    try {
        $stmt = $db->prepare("INSERT IGNORE INTO subscribers (email) VALUES (?)");
        return $stmt->execute([$email]);
    } catch (PDOException $e) {
        return false;
    }
}

function getUsers() {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT id, name, email, role, avatar, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function getRecentProjects($limit = 5) {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->prepare("SELECT id, title, slug, status, created_at FROM projects ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function getRecentMessages($limit = 5) {
    $db = getDB();
    if (!$db) return [];
    try {
        $stmt = $db->prepare("SELECT id, name, email, subject, is_read, created_at FROM contacts ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}
