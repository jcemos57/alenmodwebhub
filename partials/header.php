<?php
// =============================================
// HEADER PARTIAL
// =============================================
$settings = getAllSettings();
$pageTitle = $settings['site_title'] ?? 'Alenmodwebhub - Premium Full Stack Web Developer';
$pageDesc = $settings['site_description'] ?? 'Premium Full Stack Web Developer from Nigeria';
$pageKeywords = $settings['site_keywords'] ?? 'Full Stack Developer Nigeria';
$theme = $_COOKIE['theme'] ?? 'dark';
?>
<!DOCTYPE html>
<html lang="en" class="<?php echo $theme === 'light' ? 'light' : 'dark'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDesc); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($pageKeywords); ?>">
    <meta name="author" content="Alenmodwebhub">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDesc); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://alenmodwebhub.com">
    <meta property="og:image" content="/assets/images/og-image.jpg">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($pageDesc); ?>">

    <!-- Canonical -->
    <link rel="canonical" href="https://alenmodwebhub.com">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">

    <!-- Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "Alenmodwebhub",
        "jobTitle": "Full Stack Web Developer",
        "url": "https://alenmodwebhub.com",
        "sameAs": [
            "https://github.com/alenmodwebhub",
            "https://linkedin.com/in/alenmodwebhub",
            "https://twitter.com/alenmodwebhub"
        ]
    }
    </script>

    <!-- Theme color -->
    <meta name="theme-color" content="#0a0a0f">
    <meta name="msapplication-navbutton-color" content="#0a0a0f">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <style>
        .cursor-dot, .cursor-ring { display: none; }
        @media (hover: hover) and (pointer: fine) {
            .cursor-dot, .cursor-ring { display: block; }
        }
    </style>

    <script>var SITE_URL = '<?php echo BASE_URL; ?>';</script>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen">
        <div class="loading-content">
            <div class="loading-logo">Alenmodwebhub</div>
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading Premium Experience</p>
            <div class="loading-bar"></div>
        </div>
    </div>

    <!-- Custom Cursor -->
    <div class="cursor-dot"></div>
    <div class="cursor-ring"></div>

    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>

    <!-- Toast Notification -->
    <div class="toast"></div>

    <!-- Navigation -->
    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <div class="navbar-inner">
            <a href="#hero" class="nav-logo">
                <span class="nav-logo-icon">&#x25C6;</span>
                <span class="nav-logo-text">Alenmod</span>
            </a>

            <div class="nav-links">
                <?php
                $headerNav = getNavItems('header');
                ?>
                <?php foreach ($headerNav as $i => $nav):
                    $label = htmlspecialchars($nav['label']);
                ?>
                <a href="<?php echo htmlspecialchars($nav['url']); ?>" class="nav-link <?php echo $i === 0 ? 'active' : ''; ?>" <?php echo $nav['target'] === '_blank' ? 'target="_blank"' : ''; ?>>
                    <?php echo $label; ?>
                </a>
                <?php endforeach; ?>
            </div>

            <div class="nav-actions">
                <button class="theme-toggle" aria-label="Toggle theme">
                    <span class="theme-icon">🌙</span>
                </button>
                <a href="#hire" class="nav-hire-btn">Hire Me</a>
                <button class="mobile-menu-btn" aria-label="Toggle menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation -->
    <div class="mobile-overlay"></div>
    <div class="mobile-nav">
        <div class="mobile-nav-header">
            <span class="mobile-nav-title">Menu</span>
            <button class="mobile-nav-close" aria-label="Close menu">&times;</button>
        </div>
        <div class="mobile-nav-links">
            <?php $mobileNav = getNavItems('header'); ?>
            <?php foreach ($mobileNav as $nav):
                $label = htmlspecialchars($nav['label']);
            ?>
            <a href="<?php echo htmlspecialchars($nav['url']); ?>" class="mobile-nav-link" <?php echo $nav['target'] === '_blank' ? 'target="_blank"' : ''; ?>>
                <span class="mobile-nav-link-label"><?php echo $label; ?></span>
                <span class="mobile-nav-link-arrow">&rsaquo;</span>
            </a>
            <?php endforeach; ?>
        </div>
        <div class="mobile-nav-footer">
            <a href="#hire" class="btn btn-primary mobile-hire-btn">Hire Me Now</a>
        </div>
    </div>
