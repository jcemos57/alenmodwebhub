<?php
// =============================================
// Alenmodwebhub - Premium Portfolio Homepage
// =============================================
require_once __DIR__ . '/includes/functions.php';

// Track visit
trackVisitor('/');

// Get data
$settings = getAllSettings();
$projects = getProjects();
$categories = getProjectCategories();
$services = getServices();
$skillsByCategory = getSkillsByCategory();
$testimonials = getTestimonials();
$experiences = getExperiences();
$blogPosts = getBlogPosts(4);

// Stats
$expYears = $settings['experience_years'] ?? 5;
$projCount = $settings['projects_count'] ?? 50;
$clientCount = $settings['clients_count'] ?? 30;
$countriesCount = $settings['countries_count'] ?? 8;
$currencySymbol = $settings['default_currency_symbol'] ?? '$';
$currencyCode = $settings['default_currency_code'] ?? 'USD';

include __DIR__ . '/partials/header.php';
?>

<main>
    <!-- ============================================= -->
    <!-- 1. HERO SECTION -->
    <!-- ============================================= -->
    <section class="hero" id="hero">
        <div class="hero-particles"></div>
        <div class="hero-gradient"></div>
        <div class="hero-gradient-2"></div>
        <div class="hero-grid"></div>

        <div class="hero-content">
            <div class="hero-badge">
                <span class="status-dot"></span>
                <?php echo htmlspecialchars($settings['hero_availability'] ?? 'Available for Freelance & Remote Jobs'); ?>
            </div>

            <h1 class="hero-title">
                <span class="gradient-text"><?php echo htmlspecialchars($settings['hero_title'] ?? 'I Build Powerful Web Experiences That Grow Businesses'); ?></span>
            </h1>

            <p class="hero-subtitle">
                <?php echo htmlspecialchars($settings['hero_subtitle'] ?? 'Full Stack Developer from Nigeria helping startups, businesses, and brands build scalable modern platforms.'); ?>
            </p>

            <div class="hero-actions">
                <a href="#hire" class="btn btn-primary btn-lg magnetic-btn">
                    Hire Me Now
                    <span class="btn-shimmer"></span>
                </a>
                <a href="#projects" class="btn btn-secondary btn-lg magnetic-btn">View Projects</a>
                <a href="<?php echo htmlspecialchars($settings['cv_url'] ?? '#'); ?>" target="_blank" class="btn btn-outline btn-lg magnetic-btn">Download CV</a>
            </div>

            <div class="hero-tech-stack">
                <span class="hero-tech-item"><span class="tech-icon">⚛️</span> React</span>
                <span class="hero-tech-item"><span class="tech-icon">🟢</span> Node.js</span>
                <span class="hero-tech-item"><span class="tech-icon">🐘</span> PHP</span>
                <span class="hero-tech-item"><span class="tech-icon">🗄️</span> MySQL</span>
                <span class="hero-tech-item"><span class="tech-icon">📱</span> React Native</span>
                <span class="hero-tech-item"><span class="tech-icon">🔄</span> WP to Apps</span>
                <span class="hero-tech-item"><span class="tech-icon">🎨</span> UI/UX</span>
                <span class="hero-tech-item"><span class="tech-icon">📲</span> Android/iOS</span>
            </div>

            <div class="hero-social">
                <a href="<?php echo htmlspecialchars($settings['github_url'] ?? '#'); ?>" class="hero-social-link" target="_blank" rel="noopener" aria-label="GitHub">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                </a>
                <a href="<?php echo htmlspecialchars($settings['linkedin_url'] ?? '#'); ?>" class="hero-social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
                <a href="<?php echo htmlspecialchars($settings['twitter_url'] ?? '#'); ?>" class="hero-social-link" target="_blank" rel="noopener" aria-label="Twitter">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
                <a href="mailto:<?php echo htmlspecialchars($settings['email'] ?? ''); ?>" class="hero-social-link" aria-label="Email">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </a>
                <a href="https://wa.me/<?php echo htmlspecialchars(ltrim($settings['whatsapp'] ?? '2348012345678', '+')); ?>" class="hero-social-link" target="_blank" rel="noopener" aria-label="WhatsApp">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 2. TRUST & AUTHORITY SECTION -->
    <!-- ============================================= -->
    <section class="trust-section section" id="trust">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">Why Trust Me</span>
                <h2 class="section-title">Numbers That <span class="gradient-text">Speak Volumes</span></h2>
                <p class="section-subtitle">Over 5 years of delivering premium web solutions that drive real business results for clients worldwide.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card reveal">
                    <div class="stat-icon">📅</div>
                    <div class="stat-number" data-target="<?php echo (int)$expYears; ?>" data-suffix="+">0+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
                <div class="stat-card reveal reveal-delay-1">
                    <div class="stat-icon">🚀</div>
                    <div class="stat-number" data-target="<?php echo (int)$projCount; ?>" data-suffix="+">0+</div>
                    <div class="stat-label">Projects Delivered</div>
                </div>
                <div class="stat-card reveal reveal-delay-2">
                    <div class="stat-icon">😊</div>
                    <div class="stat-number" data-target="<?php echo (int)$clientCount; ?>" data-suffix="+">0+</div>
                    <div class="stat-label">Happy Clients</div>
                </div>
                <div class="stat-card reveal reveal-delay-3">
                    <div class="stat-icon">🌍</div>
                    <div class="stat-number" data-target="<?php echo (int)$countriesCount; ?>" data-suffix="+">0+</div>
                    <div class="stat-label">Countries Served</div>
                </div>
            </div>

            <div class="trust-cards">
                <div class="trust-card reveal">
                    <div class="trust-card-icon">✅</div>
                    <div class="trust-card-title">Reliability</div>
                    <div class="trust-card-text">I deliver on time, every time. Your project deadlines are my priority.</div>
                </div>
                <div class="trust-card reveal reveal-delay-1">
                    <div class="trust-card-icon">💬</div>
                    <div class="trust-card-title">Communication</div>
                    <div class="trust-card-text">Clear, consistent updates throughout the development process.</div>
                </div>
                <div class="trust-card reveal reveal-delay-2">
                    <div class="trust-card-icon">⚡</div>
                    <div class="trust-card-title">Speed & Performance</div>
                    <div class="trust-card-text">Optimized code that loads fast and performs flawlessly under pressure.</div>
                </div>
                <div class="trust-card reveal reveal-delay-3">
                    <div class="trust-card-icon">🧩</div>
                    <div class="trust-card-title">Problem Solving</div>
                    <div class="trust-card-text">Complex challenges are my specialty. I find solutions others miss.</div>
                </div>
                <div class="trust-card reveal reveal-delay-4">
                    <div class="trust-card-icon">📝</div>
                    <div class="trust-card-title">Clean Code</div>
                    <div class="trust-card-text">Maintainable, scalable, well-documented code that stands the test of time.</div>
                </div>
                <div class="trust-card reveal reveal-delay-5">
                    <div class="trust-card-icon">📈</div>
                    <div class="trust-card-title">Scalable Systems</div>
                    <div class="trust-card-text">Architectures designed to grow with your business from day one.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 3. ABOUT ME SECTION -->
    <!-- ============================================= -->
    <section class="section" id="about">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">About Me</span>
                <h2 class="section-title">Building Digital Excellence From <span class="gradient-text">Nigeria to the World</span></h2>
                <p class="section-subtitle">A passionate developer dedicated to crafting solutions that make a difference.</p>
            </div>

            <div class="about-grid">
                <div class="about-image-wrapper reveal">
                    <div class="about-image-container tilt-card">
                        <div class="about-image-placeholder">
                            <span>👨‍💻</span>
                        </div>
                    </div>
                    <div class="about-exp-badge">
                        <span class="exp-number"><?php echo (int)$expYears; ?>+</span>
                        <span class="exp-label">Years of Excellence</span>
                    </div>
                </div>

                <div class="about-text-content reveal">
                    <h3>Hi, I'm <span class="gradient-text">Alenmodwebhub</span></h3>
                    <?php
                    $aboutText = $settings['about_text'] ?? '';
                    $paragraphs = explode("\n\n", $aboutText);
                    foreach ($paragraphs as $p):
                        $p = trim($p);
                        if ($p):
                    ?>
                    <p><?php echo nl2br(htmlspecialchars($p)); ?></p>
                    <?php endif; endforeach; ?>

                    <div class="about-highlights">
                        <div class="about-highlight">
                            <span class="about-highlight-icon">🌍</span>
                            <span class="about-highlight-text">Global Mindset</span>
                        </div>
                        <div class="about-highlight">
                            <span class="about-highlight-icon">🎯</span>
                            <span class="about-highlight-text">Results Driven</span>
                        </div>
                        <div class="about-highlight">
                            <span class="about-highlight-icon">💡</span>
                            <span class="about-highlight-text">Innovative Solutions</span>
                        </div>
                        <div class="about-highlight">
                            <span class="about-highlight-icon">🤝</span>
                            <span class="about-highlight-text">Client Focused</span>
                        </div>
                        <div class="about-highlight">
                            <span class="about-highlight-icon">📱</span>
                            <span class="about-highlight-text">Web & Mobile Apps</span>
                        </div>
                        <div class="about-highlight">
                            <span class="about-highlight-icon">🔄</span>
                            <span class="about-highlight-text">Site to App Convert</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 4. SERVICES SECTION -->
    <!-- ============================================= -->
    <section class="section" id="services" style="background: var(--bg-secondary);">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">What I Do</span>
                <h2 class="section-title">Premium <span class="gradient-text">Services</span></h2>
                <p class="section-subtitle">End-to-end web development services designed to take your business to the next level.</p>
            </div>

            <div class="services-grid">
                <?php foreach ($services as $index => $service):
                    $features = json_decode($service['features'], true) ?? [];
                    $delay = min($index, 5);
                ?>
                <div class="service-card tilt-card reveal reveal-delay-<?php echo $delay; ?>">
                    <div class="service-icon"><?php
                        $icons = ['code', 'cloud', 'dashboard', 'cart', 'credit-card', 'server', 'smartphone', 'settings', 'fuel', 'church', 'home', 'users', 'graduation-cap', 'layout', 'image'];
                        $iconMap = [
                            'code' => '💻', 'cloud' => '☁️', 'dashboard' => '📊', 'cart' => '🛒',
                            'credit-card' => '💳', 'server' => '🖥️', 'smartphone' => '📱', 'settings' => '⚙️',
                            'fuel' => '⛽', 'church' => '⛪', 'home' => '🏠', 'users' => '👥',
                            'graduation-cap' => '🎓', 'layout' => '📐', 'image' => '🖼️'
                        ];
                        echo $iconMap[$service['icon']] ?? '💻';
                    ?></div>
                    <h3 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h3>
                    <p class="service-desc"><?php echo htmlspecialchars($service['description']); ?></p>
                    <div class="service-features">
                        <?php foreach ($features as $feature): ?>
                        <span class="service-feature-tag"><?php echo htmlspecialchars($feature); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($service['price']): ?>
                    <div class="service-price"><?php echo htmlspecialchars('Starting at ' . $currencySymbol . number_format((float)$service['price'], 0)); ?></div>
                    <?php elseif ($service['price_label']): ?>
                    <div class="service-price"><?php echo htmlspecialchars($service['price_label']); ?></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 5. SKILLS SECTION -->
    <!-- ============================================= -->
    <section class="skills-section section" id="skills">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">My Toolkit</span>
                <h2 class="section-title">Technologies I <span class="gradient-text">Master</span></h2>
                <p class="section-subtitle">A comprehensive stack of modern technologies I use to build world-class solutions.</p>
            </div>

            <div class="skills-grid">
                <?php
                $categoryLabels = [
                    'frontend' => '🎨 Frontend',
                    'backend' => '⚙️ Backend',
                    'database' => '🗄️ Database',
                    'tools' => '🔧 Tools & DevOps'
                ];
                $categoryOrder = ['frontend', 'backend', 'database', 'tools'];

                $extraSkills = [
                    'frontend' => [
                        ['name' => 'Joomla Design', 'level' => '99.9'],
                        ['name' => 'Drupal Design', 'level' => '99.9']
                    ],
                    'backend' => [
                        ['name' => 'Blockchain App/Website', 'level' => '99.9']
                    ],
                    'tools' => [
                        ['name' => 'Social Media Manager', 'level' => '99.9'],
                        ['name' => 'Graphics Design', 'level' => '99.9'],
                        ['name' => 'Webhosting Service', 'level' => '99.9']
                    ]
                ];
                ?>
                <?php foreach ($categoryOrder as $cat):
                    if (!isset($skillsByCategory[$cat])) continue;
                    $skills = array_merge($skillsByCategory[$cat], $extraSkills[$cat] ?? []);
                ?>
                <div class="reveal">
                    <h3 class="skill-category-title"><?php echo htmlspecialchars($categoryLabels[$cat] ?? ucfirst($cat)); ?></h3>
                    <div class="skill-items">
                        <?php foreach ($skills as $skill): ?>
                        <div class="skill-item">
                            <div class="skill-item-header">
                                <span class="skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                                <span class="skill-level"><?php echo $skill['level']; ?>%</span>
                            </div>
                            <div class="skill-bar">
                                <div class="skill-bar-fill" data-level="<?php echo $skill['level']; ?>"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 6. PROJECTS SECTION -->
    <!-- ============================================= -->
    <section class="section" id="projects" style="background: var(--bg-secondary);">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">Portfolio</span>
                <h2 class="section-title">Featured <span class="gradient-text">Projects</span></h2>
                <p class="section-subtitle">Real projects with real results. Each built with precision, care, and business impact in mind.</p>
            </div>

            <div class="projects-filter reveal">
                <button class="filter-btn active" data-filter="all">All Projects</button>
                <?php foreach ($categories as $cat): ?>
                <button class="filter-btn" data-filter="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></button>
                <?php endforeach; ?>
            </div>

            <div class="projects-grid">
                <?php foreach ($projects as $index => $project):
                    $techs = json_decode($project['technologies'], true) ?? [];
                    $delay = min($index % 4, 3);
                ?>
                <div class="project-card tilt-card reveal reveal-delay-<?php echo $delay; ?>" data-category="<?php echo htmlspecialchars($project['category'] ?? ''); ?>">
                    <div class="project-card-image">
                        <span>🖥️</span>
                        <?php if ($project['image']): ?>
                        <img src="<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" loading="lazy">
                        <?php endif; ?>
                        <div class="project-card-overlay">
                            <?php if ($project['live_url']): ?>
                            <a href="<?php echo htmlspecialchars($project['live_url']); ?>" class="btn btn-primary btn-sm" target="_blank" rel="noopener">Live Preview</a>
                            <?php endif; ?>
                            <?php if ($project['github_url']): ?>
                            <a href="<?php echo htmlspecialchars($project['github_url']); ?>" class="btn btn-secondary btn-sm" target="_blank" rel="noopener">GitHub</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="project-card-body">
                        <div class="project-card-category"><?php echo htmlspecialchars($project['category'] ?? 'Web Application'); ?></div>
                        <h3 class="project-card-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p class="project-card-desc"><?php echo htmlspecialchars($project['description']); ?></p>
                        <div class="project-card-tags">
                            <?php foreach ($techs as $tech): ?>
                            <span class="project-tag"><?php echo htmlspecialchars($tech); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 7. EXPERIENCE SECTION -->
    <!-- ============================================= -->
    <section class="section" id="experience">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">My Journey</span>
                <h2 class="section-title">Professional <span class="gradient-text">Experience</span></h2>
                <p class="section-subtitle">A track record of delivering excellence across diverse projects and collaborations.</p>
            </div>

            <div class="timeline">
                <?php foreach ($experiences as $index => $exp): ?>
                <div class="timeline-item reveal">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <?php if ($exp['current']): ?>
                        <span class="timeline-badge current">Current</span>
                        <?php else: ?>
                        <span class="timeline-badge contract"><?php echo htmlspecialchars(ucfirst($exp['type'] ?? 'contract')); ?></span>
                        <?php endif; ?>
                        <div class="timeline-date">
                            <?php echo $exp['start_date'] ? formatDate($exp['start_date'], 'M Y') : ''; ?>
                            - <?php echo $exp['current'] ? 'Present' : ($exp['end_date'] ? formatDate($exp['end_date'], 'M Y') : ''); ?>
                        </div>
                        <h3 class="timeline-title"><?php echo htmlspecialchars($exp['title']); ?></h3>
                        <div class="timeline-company">
                            <?php echo htmlspecialchars($exp['company'] ?? ''); ?>
                            <?php if ($exp['location']): ?> &middot; <?php echo htmlspecialchars($exp['location']); endif; ?>
                        </div>
                        <?php if ($exp['description']): ?>
                        <p class="timeline-desc"><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 8. TESTIMONIALS SECTION -->
    <!-- ============================================= -->
    <section class="testimonials-section section" id="testimonials">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">Testimonials</span>
                <h2 class="section-title">What <span class="gradient-text">Clients Say</span></h2>
                <p class="section-subtitle">Don't take my word for it. Here's what clients and collaborators have to say about working with me.</p>
            </div>

            <div class="testimonials-slider reveal">
                <div class="testimonials-track">
                    <?php foreach ($testimonials as $testimonial): ?>
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            <div class="testimonial-avatar-inner">
                                <?php if ($testimonial['avatar']): ?>
                                <img src="<?php echo htmlspecialchars($testimonial['avatar']); ?>" alt="<?php echo htmlspecialchars($testimonial['name']); ?>">
                                <?php else: ?>
                                <?php echo strtoupper(substr($testimonial['name'], 0, 1)); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="testimonial-stars">
                            <?php for ($i = 0; $i < (int)($testimonial['rating'] ?? 5); $i++): ?>★<?php endfor; ?>
                        </div>
                        <p class="testimonial-content">"<?php echo htmlspecialchars($testimonial['content']); ?>"</p>
                        <h4 class="testimonial-name"><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                        <div class="testimonial-role">
                            <?php echo htmlspecialchars($testimonial['role'] ?? ''); ?>
                            <?php if ($testimonial['company']): ?> &middot; <?php echo htmlspecialchars($testimonial['company']); endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="testimonial-nav">
                    <?php foreach ($testimonials as $i => $t): ?>
                    <button class="testimonial-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>"></button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 9. PROCESS SECTION -->
    <!-- ============================================= -->
    <section class="section" id="process">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">How I Work</span>
                <h2 class="section-title">My Development <span class="gradient-text">Process</span></h2>
                <p class="section-subtitle">A proven 7-step methodology that ensures your project is delivered flawlessly.</p>
            </div>

            <div class="process-grid">
                <div class="process-card tilt-card reveal">
                    <div class="process-icon">🔍</div>
                    <h3 class="process-title">Discovery & Research</h3>
                    <p class="process-desc">Understanding your business, goals, and requirements in depth.</p>
                </div>
                <div class="process-card tilt-card reveal reveal-delay-1">
                    <div class="process-icon">📋</div>
                    <h3 class="process-title">Planning</h3>
                    <p class="process-desc">Creating a detailed roadmap with timelines and milestones.</p>
                </div>
                <div class="process-card tilt-card reveal reveal-delay-2">
                    <div class="process-icon">🎨</div>
                    <h3 class="process-title">Design</h3>
                    <p class="process-desc">Crafting beautiful, intuitive interfaces that users love.</p>
                </div>
                <div class="process-card tilt-card reveal reveal-delay-3">
                    <div class="process-icon">💻</div>
                    <h3 class="process-title">Development</h3>
                    <p class="process-desc">Building with clean, scalable code and modern technologies.</p>
                </div>
                <div class="process-card tilt-card reveal reveal-delay-4">
                    <div class="process-icon">✅</div>
                    <h3 class="process-title">Testing</h3>
                    <p class="process-desc">Rigorous quality assurance to ensure everything works perfectly.</p>
                </div>
                <div class="process-card tilt-card reveal reveal-delay-5">
                    <div class="process-icon">🚀</div>
                    <h3 class="process-title">Deployment</h3>
                    <p class="process-desc">Smooth launch with zero downtime and full optimization.</p>
                </div>
                <div class="process-card tilt-card reveal reveal-delay-5" style="grid-column: span 1;">
                    <div class="process-icon">🤝</div>
                    <h3 class="process-title">Support</h3>
                    <p class="process-desc">Ongoing maintenance and support to keep your platform thriving.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 10. PRICING SECTION -->
    <!-- ============================================= -->
    <?php $pricingPlans = getPricingPlans(); ?>
    <section class="section" id="pricing" style="background: var(--bg-secondary);">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">Pricing</span>
                <h2 class="section-title">Invest in <span class="gradient-text">Excellence</span></h2>
                <p class="section-subtitle">Transparent pricing for premium web development services. Every project is tailored to your needs.</p>
            </div>

            <div class="pricing-grid">
                <?php if (count($pricingPlans) === 0): ?>
                <p style="text-align:center;color:var(--text-secondary);grid-column:1/-1;">Pricing plans are being updated. Please contact me for a custom quote.</p>
                <?php else: ?>
                <?php foreach ($pricingPlans as $i => $plan):
                $features = json_decode($plan['features'], true) ?: [];
                $delay = min($i, 5);
                ?>
                <div class="pricing-card <?php echo $plan['popular'] ? 'featured' : ''; ?> reveal<?php echo $delay > 0 ? ' reveal-delay-' . $delay : ''; ?>">
                    <?php if ($plan['popular']): ?>
                    <div class="pricing-popular">Most Popular</div>
                    <?php endif; ?>
                    <h3 class="pricing-name"><?php echo htmlspecialchars($plan['name']); ?></h3>
                    <div class="pricing-price"><span class="currency"><?php echo htmlspecialchars($currencySymbol); ?></span><?php echo htmlspecialchars($plan['price']); ?></div>
                    <div class="pricing-period"><?php echo htmlspecialchars($plan['period']); ?></div>
                    <div class="pricing-features">
                        <?php foreach ($features as $feature): ?>
                        <div class="pricing-feature"><span class="pricing-feature-icon">✓</span> <?php echo htmlspecialchars($feature); ?></div>
                        <?php endforeach; ?>
                    </div>
                    <button onclick="openCheckout(<?php echo $plan['id']; ?>)" class="btn <?php echo $plan['popular'] ? 'btn-primary' : 'btn-secondary'; ?>"><?php echo htmlspecialchars($plan['cta_text'] ?: 'Get Started'); ?></button>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 11. BLOG SECTION -->
    <!-- ============================================= -->
    <section class="section" id="blog">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">Latest Insights</span>
                <h2 class="section-title">From the <span class="gradient-text">Blog</span></h2>
                <p class="section-subtitle">Thoughts, insights, and tutorials on web development, technology, and building digital products.</p>
            </div>

            <div class="blog-grid">
                <?php if (count($blogPosts) > 0): ?>
                <?php foreach ($blogPosts as $index => $post):
                    $tags = json_decode($post['tags'], true) ?? [];
                    $delay = min($index, 3);
                ?>
                <article class="blog-card reveal reveal-delay-<?php echo $delay; ?>">
                    <div class="blog-card-image">
                        <span>📝</span>
                        <?php if ($post['cover_image']): ?>
                        <img src="<?php echo htmlspecialchars($post['cover_image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" loading="lazy">
                        <?php endif; ?>
                    </div>
                    <div class="blog-card-body">
                        <div class="blog-card-meta">
                            <span class="blog-card-category"><?php echo htmlspecialchars($post['category'] ?? 'General'); ?></span>
                            <span><?php echo formatDate($post['created_at']); ?></span>
                            <span><?php echo (int)$post['reading_time']; ?> min read</span>
                        </div>
                        <h3 class="blog-card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="blog-card-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                        <div class="project-card-tags">
                            <?php foreach (array_slice($tags, 0, 3) as $tag): ?>
                            <span class="project-tag"><?php echo htmlspecialchars($tag); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php else: ?>
                <?php
                // Fallback blog posts when database is empty
                $fallbackPosts = [
                    ['title' => 'The Future of Web Development in Africa', 'excerpt' => 'Exploring how African developers are reshaping the global tech landscape with innovation and resilience.', 'category' => 'Technology', 'reading_time' => 5, 'created_at' => '2024-12-01'],
                    ['title' => 'Building Scalable SaaS Platforms', 'excerpt' => 'A comprehensive guide to architecting and building SaaS platforms that scale from zero to millions of users.', 'category' => 'Development', 'reading_time' => 8, 'created_at' => '2024-11-15'],
                    ['title' => 'Why Your Business Needs a Custom Web Application', 'excerpt' => 'Discover how custom web applications give your business a competitive advantage over off-the-shelf solutions.', 'category' => 'Business', 'reading_time' => 6, 'created_at' => '2024-10-20'],
                    ['title' => 'The Art of Clean Code', 'excerpt' => 'Why writing clean, maintainable code matters for long-term project success.', 'category' => 'Development', 'reading_time' => 5, 'created_at' => '2024-09-10'],
                ];
                foreach ($fallbackPosts as $index => $post):
                    $delay = min($index, 3);
                ?>
                <article class="blog-card reveal reveal-delay-<?php echo $delay; ?>">
                    <div class="blog-card-image"><span>📝</span></div>
                    <div class="blog-card-body">
                        <div class="blog-card-meta">
							<span class="blog-card-category"><?php echo htmlspecialchars($post['category']); ?></span>
							<span><?php echo formatDate($post['created_at']); ?></span>
							<span><?php echo $post['reading_time']; ?> min read</span>
						</div>
						<h3 class="blog-card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
						<p class="blog-card-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 12. HIRE ME SECTION -->
    <!-- ============================================= -->
    <section class="hire-section section" id="hire">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">Hire Me</span>
                <h2 class="section-title">Let's Build Your <span class="gradient-text">Next Big Project</span></h2>
                <p class="section-subtitle">Tell me about your project and I'll get back to you within 24 hours with a custom proposal.</p>
            </div>

            <div class="hire-wrapper reveal">
                <div class="hire-banner">
                    <div class="hire-banner-content">
                        <div class="hire-banner-icon">🚀</div>
                        <h3 class="hire-banner-title">Ready to Start?</h3>
                        <p class="hire-banner-text">Fill out the form below and I'll review your project details immediately. Expect a personalized response within 24 hours with timeline and pricing.</p>
                        <div class="hire-banner-features">
                            <div class="hire-banner-feature"><span>✓</span> 24h Response Time</div>
                            <div class="hire-banner-feature"><span>✓</span> Free Consultation</div>
                            <div class="hire-banner-feature"><span>✓</span> Custom Proposal</div>
                            <div class="hire-banner-feature"><span>✓</span> No Obligation</div>
                        </div>
                    </div>
                </div>

                <form id="hireForm" class="hire-form">
                    <div class="hire-form-header">
                        <h3>Project Details</h3>
                        <p>Help me understand your vision</p>
                    </div>

                    <div class="hire-form-row">
                        <div class="form-group">
                            <label class="form-label" for="hire_name">Your Name <span class="required">*</span></label>
                            <input type="text" id="hire_name" name="name" class="form-input" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="hire_email">Email Address <span class="required">*</span></label>
                            <input type="email" id="hire_email" name="email" class="form-input" placeholder="john@example.com" required>
                        </div>
                    </div>

                    <div class="hire-form-row">
                        <div class="form-group">
                            <label class="form-label" for="hire_phone">Phone Number</label>
                            <input type="tel" id="hire_phone" name="phone" class="form-input" placeholder="+234 801 234 5678">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="hire_company">Company / Organization</label>
                            <input type="text" id="hire_company" name="company" class="form-input" placeholder="Your Company Ltd.">
                        </div>
                    </div>

                    <div class="hire-form-row hire-form-triple">
                        <div class="form-group">
                            <label class="form-label" for="hire_project_type">Project Type <span class="required">*</span></label>
                            <select id="hire_project_type" name="project_type" class="form-input form-select" required>
                                <option value="" disabled selected>Select project type</option>
                                <option value="web-application">Web Application</option>
                                <option value="mobile-app">Mobile App (Android/iOS)</option>
                                <option value="website-to-app">Website to App Conversion</option>
                                <option value="wordpress-to-app">WordPress to Mobile App</option>
                                <option value="e-commerce">E-commerce Website</option>
                                <option value="saas-platform">SaaS Platform</option>
                                <option value="admin-dashboard">Admin Dashboard</option>
                                <option value="api-development">API Development</option>
                                <option value="redesign">Website Redesign</option>
                                <option value="custom">Custom Project</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="hire_budget">Budget Range <span class="required">*</span></label>
                            <select id="hire_budget" name="budget" class="form-input form-select" required>
                                <option value="" disabled selected>Select budget</option>
                                <option value="500-1000">$500 - $1,000</option>
                                <option value="1000-2500">$1,000 - $2,500</option>
                                <option value="2500-5000">$2,500 - $5,000</option>
                                <option value="5000-10000">$5,000 - $10,000</option>
                                <option value="10000-plus">$10,000+</option>
                                <option value="not-sure">Not Sure / Let's Discuss</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="hire_timeline">Timeline <span class="required">*</span></label>
                            <select id="hire_timeline" name="timeline" class="form-input form-select" required>
                                <option value="" disabled selected>Select timeline</option>
                                <option value="asap">ASAP (Urgent)</option>
                                <option value="1-2-weeks">1 - 2 Weeks</option>
                                <option value="2-4-weeks">2 - 4 Weeks</option>
                                <option value="1-2-months">1 - 2 Months</option>
                                <option value="3-plus-months">3+ Months</option>
                                <option value="flexible">Flexible / Not Sure</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="website_type_group" style="display:none;">
                        <label class="form-label" for="hire_website_type">Existing Website Type</label>
                        <select id="hire_website_type" name="website_type" class="form-input form-select">
                            <option value="" disabled selected>Select your current platform</option>
                            <option value="wordpress">WordPress</option>
                            <option value="wix">Wix</option>
                            <option value="shopify">Shopify</option>
                            <option value="custom-php">Custom PHP Site</option>
                            <option value="html-css">Static HTML/CSS</option>
                            <option value="react-nextjs">React / Next.js</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Features You Need</label>
                        <div class="hire-features-grid">
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Responsive Design">
                                <span class="hire-checkmark"></span>
                                Responsive Design
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Payment Integration">
                                <span class="hire-checkmark"></span>
                                Payment Integration
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Admin Dashboard">
                                <span class="hire-checkmark"></span>
                                Admin Dashboard
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="User Authentication">
                                <span class="hire-checkmark"></span>
                                User Authentication
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Database Design">
                                <span class="hire-checkmark"></span>
                                Database Design
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="API Integration">
                                <span class="hire-checkmark"></span>
                                API Integration
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="SEO Optimization">
                                <span class="hire-checkmark"></span>
                                SEO Optimization
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Push Notifications">
                                <span class="hire-checkmark"></span>
                                Push Notifications
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="E-commerce">
                                <span class="hire-checkmark"></span>
                                E-commerce
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Multi-language">
                                <span class="hire-checkmark"></span>
                                Multi-language
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Real-time Chat">
                                <span class="hire-checkmark"></span>
                                Real-time Chat
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="School Website">
                                <span class="hire-checkmark"></span>
                                School Website
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Church Website">
                                <span class="hire-checkmark"></span>
                                Church Website
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Hotel Website">
                                <span class="hire-checkmark"></span>
                                Hotel Website
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Company Website">
                                <span class="hire-checkmark"></span>
                                Company Website
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Banking Website">
                                <span class="hire-checkmark"></span>
                                Banking Website
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Crypto Website">
                                <span class="hire-checkmark"></span>
                                Crypto Website
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Mobile Application">
                                <span class="hire-checkmark"></span>
                                Mobile Application (Android/iOS)
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Joomla Design">
                                <span class="hire-checkmark"></span>
                                Joomla Design
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Drupal Design">
                                <span class="hire-checkmark"></span>
                                Drupal Design
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Blockchain App/Website">
                                <span class="hire-checkmark"></span>
                                Blockchain App/Website
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Social Media Manager">
                                <span class="hire-checkmark"></span>
                                Social Media Manager
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Graphics Design">
                                <span class="hire-checkmark"></span>
                                Graphics Design
                            </label>
                            <label class="hire-feature-check">
                                <input type="checkbox" name="features[]" value="Other">
                                <span class="hire-checkmark"></span>
                                Other (specify below)
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hire_description">Project Description <span class="required">*</span></label>
                        <textarea id="hire_description" name="description" class="form-textarea" placeholder="Describe your project in detail... What is the goal? Who is the target audience? Do you have any design preferences or references?" required></textarea>
                        <div class="hire-char-count"><span id="hireCharCount">0</span> / 2000</div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg hire-submit-btn">
                        <span class="hire-submit-text">Submit Hire Request</span>
                        <span class="btn-shimmer"></span>
                    </button>

                    <p class="hire-form-footer">I respect your privacy. Your information will never be shared.</p>
                </form>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- 13. CONTACT SECTION -->
    <!-- ============================================= -->
    <section class="contact-section section" id="contact">
        <div class="section-inner">
            <div class="section-header reveal">
                <span class="section-label">Get In Touch</span>
                <h2 class="section-title">Let's Build Something <span class="gradient-text">Extraordinary Together</span></h2>
                <p class="section-subtitle">Have a project in mind? Let's talk about how I can help bring your vision to life.</p>
            </div>

            <div class="contact-grid">
                <div class="contact-form reveal">
                    <form id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="name">Your Name</label>
                                <input type="text" id="name" name="name" class="form-input" placeholder="John Doe" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Your Email</label>
                                <input type="email" id="email" name="email" class="form-input" placeholder="john@example.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-input" placeholder="Project Inquiry">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="message">Message</label>
                            <textarea id="message" name="message" class="form-textarea" placeholder="Tell me about your project..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                            Send Message
                            <span class="btn-shimmer"></span>
                        </button>
                    </form>
                </div>

                <div class="contact-info reveal reveal-delay-2">
                    <div class="contact-info-card">
                        <div class="contact-info-icon">📧</div>
                        <div>
                            <div class="contact-info-label">Email</div>
                            <div class="contact-info-value">
                                <a href="mailto:<?php echo htmlspecialchars($settings['email'] ?? 'hello@alenmodwebhub.com'); ?>">
                                    <?php echo htmlspecialchars($settings['email'] ?? 'hello@alenmodwebhub.com'); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon">💬</div>
                        <div>
                            <div class="contact-info-label">WhatsApp</div>
                            <div class="contact-info-value">
                                <a href="https://wa.me/<?php echo htmlspecialchars(ltrim($settings['whatsapp'] ?? '2348012345678', '+')); ?>" target="_blank" rel="noopener">
                                    Chat on WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon">📍</div>
                        <div>
                            <div class="contact-info-label">Location</div>
                            <div class="contact-info-value"><?php echo htmlspecialchars($settings['location'] ?? 'Nigeria (Remote Worldwide)'); ?></div>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon">📅</div>
                        <div>
                            <div class="contact-info-label">Book a Call</div>
                            <div class="contact-info-value">
                                <a href="<?php echo htmlspecialchars($settings['calendly_url'] ?? '#'); ?>" target="_blank" rel="noopener">Schedule a Meeting</a>
                            </div>
                        </div>
                    </div>

                    <div class="contact-social">
                        <a href="<?php echo htmlspecialchars($settings['github_url'] ?? '#'); ?>" class="contact-social-link" target="_blank" rel="noopener" aria-label="GitHub">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                        </a>
                        <a href="<?php echo htmlspecialchars($settings['linkedin_url'] ?? '#'); ?>" class="contact-social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="<?php echo htmlspecialchars($settings['twitter_url'] ?? '#'); ?>" class="contact-social-link" target="_blank" rel="noopener" aria-label="Twitter">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="mailto:<?php echo htmlspecialchars($settings['email'] ?? ''); ?>" class="contact-social-link" aria-label="Email">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </a>
                        <a href="https://wa.me/<?php echo htmlspecialchars(ltrim($settings['whatsapp'] ?? '2348012345678', '+')); ?>" class="contact-social-link" target="_blank" rel="noopener" aria-label="WhatsApp">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- ============================================= -->
<!-- CHECKOUT MODAL -->
<!-- ============================================= -->
<div class="modal-overlay" id="checkoutModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);z-index:9999;align-items:center;justify-content:center;" onclick="if(event.target===this)closeCheckout()">
    <div class="modal-content" style="background:#151528;border-radius:16px;max-width:600px;width:90%;max-height:90vh;overflow-y:auto;padding:0;">
        <div style="padding:1.5rem 2rem;border-bottom:1px solid #2a2a4a;display:flex;justify-content:space-between;align-items:center;">
            <h3 style="margin:0;font-size:1.3rem;color:#f0f0f5;" id="checkoutPlanName">Complete Your Order</h3>
            <button onclick="closeCheckout()" style="background:none;border:none;font-size:1.8rem;cursor:pointer;color:#a0a0c0;">&times;</button>
        </div>
        <div style="padding:2rem;">
            <div style="background:#1e1e36;border-radius:12px;padding:1rem 1.5rem;margin-bottom:1.5rem;display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <div style="font-size:0.85rem;color:#8888aa;">Selected Plan</div>
                    <div style="font-weight:600;font-size:1.1rem;color:#f0f0f5;" id="checkoutPlanLabel">-</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:0.85rem;color:#8888aa;">Amount</div>
                    <div style="font-weight:700;font-size:1.3rem;color:#6366f1;" id="checkoutPlanPrice">-</div>
                </div>
            </div>

            <form id="orderForm" onsubmit="submitOrder(event)">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                    <div>
                        <label style="display:block;margin-bottom:0.3rem;font-size:0.85rem;color:var(--text-secondary);">Your Name *</label>
                        <input type="text" name="customer_name" required style="width:100%;padding:0.7rem 1rem;border-radius:8px;border:1px solid #3a3a5c;background:#1e1e36;color:#f0f0f5;font-size:0.95rem;">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:0.3rem;font-size:0.85rem;color:#a0a0c0;">Email *</label>
                        <input type="email" name="customer_email" required style="width:100%;padding:0.7rem 1rem;border-radius:8px;border:1px solid #3a3a5c;background:#1e1e36;color:#f0f0f5;font-size:0.95rem;">
                    </div>
                </div>
                <div style="margin-bottom:1.5rem;">
                    <label style="display:block;margin-bottom:0.3rem;font-size:0.85rem;color:#a0a0c0;">Phone</label>
                    <input type="text" name="customer_phone" style="width:100%;padding:0.7rem 1rem;border-radius:8px;border:1px solid #3a3a5c;background:#1e1e36;color:#f0f0f5;font-size:0.95rem;">
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label style="display:block;margin-bottom:0.8rem;font-size:0.95rem;font-weight:600;color:#f0f0f5;">Choose Payment Method</label>
                    <div style="display:flex;flex-direction:column;gap:0.6rem;" id="paymentMethods">
                        <label class="payment-option" style="display:flex;align-items:center;gap:0.8rem;padding:0.8rem 1rem;border-radius:10px;border:2px solid #2a2a4a;cursor:pointer;transition:all 0.2s;background:#1e1e36;" onclick="selectPayment(this,'bank_ngn')">
                            <input type="radio" name="payment_method" value="bank_ngn" style="accent-color:#6366f1;" checked>
                            <div>
                                <div style="font-weight:600;font-size:0.95rem;color:#f0f0f5;">🇳🇬 Bank Transfer (NGN)</div>
                                <div style="font-size:0.8rem;color:#8888aa;">Pay in Nigerian Naira</div>
                            </div>
                        </label>
                        <label class="payment-option" style="display:flex;align-items:center;gap:0.8rem;padding:0.8rem 1rem;border-radius:10px;border:2px solid #2a2a4a;cursor:pointer;transition:all 0.2s;background:#1e1e36;" onclick="selectPayment(this,'bank_usd')">
                            <input type="radio" name="payment_method" value="bank_usd" style="accent-color:#6366f1;">
                            <div>
                                <div style="font-weight:600;font-size:0.95rem;color:#f0f0f5;">🌍 Bank Transfer (USD)</div>
                                <div style="font-size:0.8rem;color:#8888aa;">International wire transfer</div>
                            </div>
                        </label>
                        <label class="payment-option" style="display:flex;align-items:center;gap:0.8rem;padding:0.8rem 1rem;border-radius:10px;border:2px solid #2a2a4a;cursor:pointer;transition:all 0.2s;background:#1e1e36;" onclick="selectPayment(this,'usdt')">
                            <input type="radio" name="payment_method" value="usdt" style="accent-color:#6366f1;">
                            <div>
                                <div style="font-weight:600;font-size:0.95rem;color:#f0f0f5;">₮ USDT (TRC20 / ERC20)</div>
                                <div style="font-size:0.8rem;color:#8888aa;">Tether on Tron or Ethereum</div>
                            </div>
                        </label>
                        <label class="payment-option" style="display:flex;align-items:center;gap:0.8rem;padding:0.8rem 1rem;border-radius:10px;border:2px solid #2a2a4a;cursor:pointer;transition:all 0.2s;background:#1e1e36;" onclick="selectPayment(this,'btc')">
                            <input type="radio" name="payment_method" value="btc" style="accent-color:#6366f1;">
                            <div>
                                <div style="font-weight:600;font-size:0.95rem;color:#f0f0f5;">₿ Bitcoin (BTC)</div>
                                <div style="font-size:0.8rem;color:#8888aa;">Pay with Bitcoin</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Payment Details (shown after selecting method) -->
                <div id="paymentDetails" style="display:none;background:#1e1e36;border-radius:12px;padding:1.2rem 1.5rem;margin-bottom:1.5rem;border:1px solid #2a2a4a;"></div>

                <div style="margin-bottom:1rem;">
                    <label style="display:block;margin-bottom:0.3rem;font-size:0.85rem;color:var(--text-secondary);">Notes (optional)</label>
                    <textarea name="notes" style="width:100%;padding:0.7rem 1rem;border-radius:8px;border:1px solid #3a3a5c;background:#1e1e36;color:#f0f0f5;font-size:0.95rem;min-height:60px;resize:vertical;"></textarea>
                </div>

                <input type="hidden" name="plan_id" id="checkoutPlanId">
                <input type="hidden" name="plan_name" id="checkoutPlanNameHidden">
                <input type="hidden" name="plan_price" id="checkoutPlanPriceHidden">

                <div id="checkoutSubmitArea">
                    <button type="submit" class="btn btn-primary" style="width:100%;padding:1rem;font-size:1.05rem;background:#6366f1;color:white;border:none;border-radius:10px;cursor:pointer;font-weight:600;">Submit Order</button>
                    <p style="text-align:center;font-size:0.8rem;color:#8888aa;margin-top:0.8rem;">You will receive payment instructions after submitting.</p>
                </div>

                <div id="checkoutWhatsAppArea" style="display:none;">
                    <div style="background:rgba(37,211,102,0.1);border:1px solid rgba(37,211,102,0.3);border-radius:12px;padding:1.2rem;text-align:center;margin-bottom:1rem;">
                        <div style="font-size:1.1rem;font-weight:600;color:#25D366;margin-bottom:0.5rem;">✓ Order Submitted!</div>
                        <p style="font-size:0.9rem;color:#c0c0d0;margin:0;">Please send your payment receipt via WhatsApp for confirmation.</p>
                    </div>
                    <a id="checkoutWhatsAppBtn" href="#" target="_blank" style="width:100%;padding:1rem;font-size:1.05rem;display:flex;align-items:center;justify-content:center;gap:0.5rem;background:#25D366;color:white;border:none;border-radius:10px;cursor:pointer;font-weight:600;text-decoration:none;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
                        Contact via WhatsApp to Confirm
                    </a>
                    <button onclick="closeCheckout()" style="width:100%;padding:0.8rem;margin-top:0.6rem;background:#2a2a4a;color:#f0f0f5;border:1px solid #3a3a5c;border-radius:10px;cursor:pointer;font-size:0.95rem;">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.payment-option.selected { border-color: #6366f1 !important; background: rgba(99,102,241,0.15) !important; }
.modal-overlay { display:none; }
.modal-overlay.show { display:flex; }
</style>

<script>
const pricingPlans = <?php echo json_encode($pricingPlans ?: []) ?: '[]'; ?>;
const siteSettings = <?php echo json_encode($settings ?: []) ?: '{}'; ?>;

function openCheckout(planId) {
    const plan = pricingPlans.find(p => p.id == planId);
    if (!plan) return;
    document.getElementById('checkoutPlanId').value = plan.id;
    document.getElementById('checkoutPlanNameHidden').value = plan.name;
    const cur = siteSettings.default_currency_symbol || '$';
    document.getElementById('checkoutPlanPriceHidden').value = cur + plan.price;
    document.getElementById('checkoutPlanLabel').textContent = plan.name;
    document.getElementById('checkoutPlanPrice').textContent = cur + plan.price;
    document.getElementById('checkoutPlanName').textContent = 'Order: ' + plan.name;
    document.getElementById('orderForm').reset();
    document.getElementById('checkoutSubmitArea').style.display = 'block';
    document.getElementById('checkoutWhatsAppArea').style.display = 'none';
    document.getElementById('paymentDetails').style.display = 'none';
    document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
    const firstOption = document.querySelector('.payment-option');
    if (firstOption) {
        firstOption.classList.add('selected');
        const firstRadio = firstOption.querySelector('input[type=radio]');
        if (firstRadio) selectPayment(firstOption, firstRadio.value);
    }
    document.getElementById('checkoutModal').classList.add('show');
    document.getElementById('checkoutModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeCheckout() {
    document.getElementById('checkoutModal').classList.remove('show');
    document.getElementById('checkoutModal').style.display = 'none';
    document.body.style.overflow = '';
}

function esc(s) { return (s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

function selectPayment(el, method) {
    document.querySelectorAll('.payment-option').forEach(e => e.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input[type=radio]').checked = true;

    const details = document.getElementById('paymentDetails');
    const settings = siteSettings;
    let html = '';

    if (method === 'bank_ngn') {
        html = '<div style="font-weight:600;margin-bottom:0.8rem;color:#f0f0f5;">🇳🇬 Bank Transfer (NGN)</div>' +
            '<pre style="font-family:inherit;white-space:pre-wrap;margin:0;line-height:1.7;font-size:0.9rem;color:#c0c0d0;">' + esc(settings.bank_ngn_details || 'Bank: Access Bank\nAccount: Alenmodwebhub\nAccount No: 1234567890') + '</pre>';
    } else if (method === 'bank_usd') {
        html = '<div style="font-weight:600;margin-bottom:0.8rem;color:#f0f0f5;">🌍 Bank Transfer (USD)</div>' +
            '<pre style="font-family:inherit;white-space:pre-wrap;margin:0;line-height:1.7;font-size:0.9rem;color:#c0c0d0;">' + esc(settings.bank_usd_details || 'Bank: Access Bank (USD)\nAccount: Alenmodwebhub\nAccount No: 0987654321\nSwift: ACCINGLA') + '</pre>';
    } else if (method === 'usdt') {
        html = '<div style="font-weight:600;margin-bottom:0.8rem;color:#f0f0f5;">₮ USDT Payment</div>' +
            '<div style="margin-bottom:0.5rem;font-size:0.9rem;color:#c0c0d0;"><strong style="color:#f0f0f5;">Network:</strong> ' + esc(settings.usdt_network || 'ERC20 / TRC20') + '</div>' +
            '<div style="font-size:0.9rem;color:#c0c0d0;"><strong style="color:#f0f0f5;">Wallet:</strong></div>' +
            '<code style="display:block;padding:0.6rem;background:#0d0d1a;border-radius:6px;font-size:0.8rem;word-break:break-all;margin-top:0.3rem;color:#e0e0f0;">' + esc(settings.usdt_wallet || '0x...') + '</code>' +
            '<button onclick="copyText(this)" data-copy="' + esc(settings.usdt_wallet || '') + '" style="margin-top:0.5rem;padding:0.3rem 0.8rem;border-radius:6px;border:1px solid #3a3a5c;background:#151528;color:#f0f0f5;cursor:pointer;font-size:0.8rem;">Copy Address</button>';
    } else if (method === 'btc') {
        html = '<div style="font-weight:600;margin-bottom:0.8rem;color:#f0f0f5;">₿ Bitcoin (BTC)</div>' +
            '<div style="font-size:0.9rem;color:#c0c0d0;"><strong style="color:#f0f0f5;">Wallet:</strong></div>' +
            '<code style="display:block;padding:0.6rem;background:#0d0d1a;border-radius:6px;font-size:0.8rem;word-break:break-all;margin-top:0.3rem;color:#e0e0f0;">' + esc(settings.btc_wallet || 'bc1...') + '</code>' +
            '<button onclick="copyText(this)" data-copy="' + esc(settings.btc_wallet || '') + '" style="margin-top:0.5rem;padding:0.3rem 0.8rem;border-radius:6px;border:1px solid #3a3a5c;background:#151528;color:#f0f0f5;cursor:pointer;font-size:0.8rem;">Copy Address</button>';
    }

    details.innerHTML = html;
    details.style.display = 'block';
}

function copyText(btn) {
    const text = btn.getAttribute('data-copy');
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(() => {
            btn.textContent = 'Copied!';
            setTimeout(() => { btn.textContent = 'Copy Address'; }, 2000);
        }).catch(() => fallbackCopy(text, btn));
    } else {
        fallbackCopy(text, btn);
    }
}
function fallbackCopy(text, btn) {
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.style.position = 'fixed';
    ta.style.opacity = '0';
    document.body.appendChild(ta);
    ta.select();
    document.execCommand('copy');
    document.body.removeChild(ta);
    btn.textContent = 'Copied!';
    setTimeout(() => { btn.textContent = 'Copy Address'; }, 2000);
}

function submitOrder(e) {
    e.preventDefault();
    const submitBtn = e.target.querySelector('button[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;
    const form = document.getElementById('orderForm');
    const data = {
        plan_id: form.plan_id.value,
        plan_name: form.plan_name.value,
        plan_price: form.plan_price.value,
        customer_name: form.customer_name.value,
        customer_email: form.customer_email.value,
        customer_phone: form.customer_phone.value,
        payment_method: form.payment_method.value,
        notes: form.notes.value
    };

    fetch((window.SITE_URL || '') + '/api/order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => {
        if (!res.ok) throw new Error('Server error');
        return res.json();
    })
    .then(res => {
        if (res.success) {
            document.getElementById('checkoutSubmitArea').style.display = 'none';
            document.getElementById('paymentDetails').style.display = 'none';
            const rawNum = siteSettings.whatsapp || '2348012345678';
            const waNum = rawNum.replace(/^\+/, '');
            const msg = encodeURIComponent('Hello! I just ordered the ' + data.plan_name + ' plan (' + data.plan_price + '). My name is ' + data.customer_name + '. Please send me payment instructions.');
            document.getElementById('checkoutWhatsAppBtn').href = 'https://wa.me/' + waNum + '?text=' + msg;
            document.getElementById('checkoutWhatsAppArea').style.display = 'block';
        } else {
            alert(res.message || 'Something went wrong. Please try again.');
        }
    })
    .catch(() => alert('Network error. Please try again.'))
    .finally(() => { if (submitBtn) submitBtn.disabled = false; });
}

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeCheckout();
});
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
