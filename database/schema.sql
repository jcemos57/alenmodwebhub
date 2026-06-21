-- =============================================
-- Alenmodwebhub - Portfolio Database Schema
-- Premium Full Stack Developer Portfolio
-- =============================================

CREATE DATABASE IF NOT EXISTS alenmodwebhub;
USE alenmodwebhub;

-- Users / Admin
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','superadmin') DEFAULT 'admin',
    avatar VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Projects Portfolio
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    description TEXT,
    content TEXT,
    category VARCHAR(100) DEFAULT NULL,
    technologies TEXT,
    live_url VARCHAR(255) DEFAULT NULL,
    github_url VARCHAR(255) DEFAULT NULL,
    image VARCHAR(255) DEFAULT NULL,
    images TEXT DEFAULT NULL,
    featured BOOLEAN DEFAULT FALSE,
    problem_solved TEXT DEFAULT NULL,
    results TEXT DEFAULT NULL,
    sort_order INT DEFAULT 0,
    status ENUM('published','draft') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Blog Posts
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    excerpt TEXT,
    content LONGTEXT,
    cover_image VARCHAR(255) DEFAULT NULL,
    category VARCHAR(100) DEFAULT NULL,
    tags TEXT DEFAULT NULL,
    featured BOOLEAN DEFAULT FALSE,
    status ENUM('published','draft') DEFAULT 'published',
    reading_time INT DEFAULT 5,
    author VARCHAR(100) DEFAULT 'Alenmodwebhub',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Blog Comments
CREATE TABLE blog_comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    parent_id INT DEFAULT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) DEFAULT NULL,
    content TEXT NOT NULL,
    approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES blog_comments(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Contact Messages
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    subject VARCHAR(200) DEFAULT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    replied BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Hire Requests
CREATE TABLE IF NOT EXISTS hire_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    company VARCHAR(200) DEFAULT NULL,
    project_type VARCHAR(100) NOT NULL,
    budget VARCHAR(100) NOT NULL,
    timeline VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    website_type VARCHAR(100) DEFAULT NULL,
    features TEXT DEFAULT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    replied BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Testimonials
CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(100) DEFAULT NULL,
    company VARCHAR(100) DEFAULT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    content TEXT NOT NULL,
    rating INT DEFAULT 5,
    featured BOOLEAN DEFAULT FALSE,
    sort_order INT DEFAULT 0,
    status ENUM('published','draft') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Services
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(100) DEFAULT 'code',
    features TEXT DEFAULT NULL,
    price DECIMAL(10,2) DEFAULT NULL,
    price_label VARCHAR(100) DEFAULT NULL,
    sort_order INT DEFAULT 0,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Skills
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    level INT DEFAULT 0,
    category VARCHAR(50) DEFAULT 'frontend',
    icon VARCHAR(100) DEFAULT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Experience
CREATE TABLE experiences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    company VARCHAR(200) DEFAULT NULL,
    location VARCHAR(200) DEFAULT NULL,
    start_date DATE DEFAULT NULL,
    end_date DATE DEFAULT NULL,
    current BOOLEAN DEFAULT FALSE,
    description TEXT,
    type VARCHAR(50) DEFAULT 'freelance',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Site Settings
CREATE TABLE site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value LONGTEXT,
    setting_group VARCHAR(50) DEFAULT 'general',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Visitor Analytics
CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT,
    page VARCHAR(255) DEFAULT NULL,
    referrer VARCHAR(255) DEFAULT NULL,
    country VARCHAR(100) DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Activity Logs
CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    action VARCHAR(100) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Pricing Plans
CREATE TABLE pricing_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price VARCHAR(50) NOT NULL DEFAULT 'Custom',
    currency VARCHAR(10) DEFAULT '$',
    period VARCHAR(50) DEFAULT 'per project',
    description TEXT,
    features TEXT,
    popular BOOLEAN DEFAULT FALSE,
    cta_text VARCHAR(100) DEFAULT 'Get Started',
    cta_link VARCHAR(255) DEFAULT '#contact',
    sort_order INT DEFAULT 0,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Navigation Menu Items
CREATE TABLE nav_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(100) NOT NULL,
    url VARCHAR(255) NOT NULL DEFAULT '#',
    icon VARCHAR(50) DEFAULT NULL,
    parent_id INT DEFAULT NULL,
    location ENUM('header','footer','both') DEFAULT 'header',
    target ENUM('_self','_blank') DEFAULT '_self',
    sort_order INT DEFAULT 0,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES nav_items(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Purchase Orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plan_name VARCHAR(100) NOT NULL,
    plan_price VARCHAR(50) NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(50) DEFAULT NULL,
    payment_method VARCHAR(20) NOT NULL DEFAULT 'bank_transfer',
    payment_currency VARCHAR(10) NOT NULL DEFAULT 'NGN',
    status ENUM('pending','paid','confirmed','cancelled') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Newsletter Subscribers
CREATE TABLE subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================
-- DEFAULT DATA
-- =============================================

-- Default Admin (password: admin123)
INSERT INTO users (name, email, password, role) VALUES
('Alenmodwebhub', 'admin@alenmodwebhub.com', '$2y$10$LFMQl2ngoaOgp5sLQAeuo.fi./oirHOsFEMPrAmuqCV8wTZ8oZpUC', 'superadmin');

-- Default Site Settings
INSERT INTO site_settings (setting_key, setting_value, setting_group) VALUES
('site_name', 'Alenmodwebhub', 'general'),
('site_title', 'Alenmodwebhub - Premium Full Stack Web & Mobile Developer from Nigeria', 'general'),
('site_description', 'Premium Full Stack Web and Mobile Developer from Nigeria specializing in modern web applications, SaaS platforms, e-commerce, admin dashboard systems, and cross-platform mobile apps (Android/iOS).', 'general'),
('site_keywords', 'Full Stack Developer Nigeria, Mobile App Developer Nigeria, Web Developer Nigeria, Hire Full Stack Developer, Remote Web Developer, React Developer, PHP Developer, WordPress to App', 'seo'),
('hero_title', 'I Build Powerful Web & Mobile Experiences That Grow Businesses', 'hero'),
('hero_subtitle', 'Full Stack & Mobile Developer from Nigeria helping startups, businesses, and brands build scalable modern platforms and mobile apps that drive real results.', 'hero'),
('hero_availability', 'Available for Freelance & Remote Jobs Worldwide', 'hero'),
('about_text', 'I am a passionate Full Stack Web & Mobile Developer from Nigeria with over 5 years of experience building premium digital solutions. My journey began with a curiosity for how websites work and evolved into a full-fledged career crafting sophisticated web applications and mobile apps that solve real business problems.

I specialize in building everything from stunning frontend interfaces to robust backend architectures, as well as cross-platform mobile applications for Android and iOS. Whether it is a complex SaaS platform, an e-commerce empire, a real-time dashboard, a mobile app, or converting your WordPress site into a native mobile application, I bring the same level of dedication, precision, and creativity to every project.

My approach combines technical excellence with business-focused thinking. I don\'t just write code — I build solutions that drive growth, streamline operations, and create memorable user experiences across both web and mobile platforms.

Based in Nigeria but working globally, I have collaborated with clients across multiple countries, delivering projects on time, within budget, and beyond expectations.', 'about'),
('about_image', '', 'about'),
('experience_years', '5', 'stats'),
('projects_count', '50', 'stats'),
('clients_count', '30', 'stats'),
('countries_count', '8', 'stats'),
('technologies_count', '50', 'stats'),
('email', 'hello@alenmodwebhub.com', 'contact'),
('phone', '+2348012345678', 'contact'),
('location', 'Nigeria (Remote Worldwide)', 'contact'),
('whatsapp', '2348012345678', 'contact'),
('calendly_url', 'https://calendly.com/alenmodwebhub', 'contact'),
('github_url', 'https://github.com/alenmodwebhub', 'social'),
('linkedin_url', 'https://linkedin.com/in/alenmodwebhub', 'social'),
('twitter_url', 'https://twitter.com/alenmodwebhub', 'social'),
('facebook_url', 'https://facebook.com/alenmodwebhub', 'social'),
('instagram_url', 'https://instagram.com/alenmodwebhub', 'social'),
('youtube_url', 'https://youtube.com/@alenmodwebhub', 'social'),
('footer_text', 'Building premium digital experiences that transform businesses. Available for freelance, contract, and full-time remote opportunities worldwide.', 'footer'),
('footer_email', 'hello@alenmodwebhub.com', 'footer'),
('copyright_text', '© 2024 Alenmodwebhub. All rights reserved.', 'footer'),
('primary_color', '#6366f1', 'design'),
('secondary_color', '#ec4899', 'design'),
('font_family', 'Inter', 'design'),
('theme_mode', 'dark', 'design'),
('bank_name', 'Access Bank', 'payment'),
('bank_account_name', 'Alenmodwebhub', 'payment'),
('bank_account_number', '1234567890', 'payment'),
('bank_ngn_details', 'Bank: Access Bank\nAccount Name: Alenmodwebhub\nAccount Number: 1234567890', 'payment'),
('bank_usd_details', 'Bank: Access Bank (USD)\nAccount Name: Alenmodwebhub\nAccount Number: 0987654321\nSwift Code: ACCINGLA', 'payment'),
('usdt_wallet', '0x1234567890abcdef1234567890abcdef12345678', 'payment'),
('usdt_network', 'ERC20 (Ethereum) / TRC20 (Tron)', 'payment'),
('btc_wallet', 'bc1qxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'payment');

-- Default Pricing Plans
INSERT INTO pricing_plans (name, price, currency, period, features, popular, cta_text, cta_link, sort_order) VALUES
('Starter', '500', '$', 'per project', '["Single Page Website","Responsive Design","Basic SEO","Contact Form","1 Revision","2 Weeks Delivery"]', FALSE, 'Get Started', '#contact', 1),
('Professional', '1,500', '$', 'per project', '["Full Stack Web Application","Custom UI/UX Design","Database Architecture","API Integration","Admin Dashboard","3 Revisions","4 Weeks Delivery","SEO Optimization","Deployment & Hosting Setup"]', TRUE, 'Get Started', '#contact', 2),
('Enterprise', 'Custom', '$', 'per project', '["Custom SaaS Platform","Multi-tenant Architecture","Advanced Security","Real-time Features","Third-party Integrations","Unlimited Revisions","Priority Support","24/7 Maintenance","Custom Timeline"]', FALSE, 'Contact Me', '#contact', 3);

-- Default Navigation Menu Items
INSERT INTO nav_items (label, url, icon, location, sort_order) VALUES
('Home', '#hero', NULL, 'both', 1),
('About', '#about', NULL, 'both', 2),
('Services', '#services', NULL, 'both', 3),
('Projects', '#projects', NULL, 'both', 4),
('Testimonials', '#testimonials', NULL, 'both', 5),
('Blog', '#blog', NULL, 'both', 6),
('Hire Me', '#hire', NULL, 'both', 7),
('Contact', '#contact', NULL, 'both', 8),
('Skills', '#skills', NULL, 'header', 9),
('Experience', '#experience', NULL, 'header', 10),
('Pricing', '#pricing', NULL, 'header', 11);

-- Default Skills
INSERT INTO skills (name, level, category, sort_order) VALUES
('HTML5', 98, 'frontend', 1),
('CSS3', 95, 'frontend', 2),
('JavaScript', 95, 'frontend', 3),
('TypeScript', 88, 'frontend', 4),
('React', 92, 'frontend', 5),
('Next.js', 88, 'frontend', 6),
('Tailwind CSS', 95, 'frontend', 7),
('Bootstrap', 90, 'frontend', 8),
('Node.js', 90, 'backend', 9),
('PHP', 92, 'backend', 10),
('Laravel', 88, 'backend', 11),
('Python', 75, 'backend', 12),
('MySQL', 90, 'database', 13),
('MongoDB', 82, 'database', 14),
('Firebase', 80, 'database', 15),
('REST API', 92, 'backend', 16),
('Git/GitHub', 90, 'tools', 17),
('Linux', 78, 'tools', 18),
('Docker', 72, 'tools', 19),
('Cloud Hosting', 85, 'tools', 20),
('React Native', 85, 'mobile', 21),
('Flutter', 78, 'mobile', 22),
('Android Development', 82, 'mobile', 23),
('iOS Development', 75, 'mobile', 24),
('PWA Development', 90, 'mobile', 25),
('Apache Cordova/Capacitor', 80, 'mobile', 26);

-- Default Services
INSERT INTO services (title, slug, description, icon, features, price, price_label, sort_order) VALUES
('Full Stack Web Development', 'full-stack-web-development', 'Complete web applications from concept to deployment with modern technologies.', 'code', '["Custom Web Applications","Frontend & Backend Development","API Integration","Database Design","Responsive Design","Deployment & Hosting"]', 1500.00, 'Starting at $1,500', 1),
('SaaS Development', 'saas-development', 'Scalable software-as-a-service platforms with subscription management.', 'cloud', '["Multi-tenant Architecture","Subscription Management","Payment Integration","User Dashboards","Admin Panels","Analytics & Reporting"]', 3000.00, 'Starting at $3,000', 2),
('Admin Dashboard Systems', 'admin-dashboard-systems', 'Powerful admin interfaces with real-time data visualization.', 'dashboard', '["Custom Admin Panels","Data Visualization","User Management","Role-based Access","Real-time Updates","Export & Reporting"]', 2000.00, 'Starting at $2,000', 3),
('E-commerce Websites', 'e-commerce-websites', 'Full-featured online stores with payment processing and inventory management.', 'cart', '["Product Management","Shopping Cart","Payment Gateway","Order Management","Inventory Tracking","Customer Accounts"]', 2500.00, 'Starting at $2,500', 4),
('Payment Integration', 'payment-integration', 'Secure payment processing with multiple gateway support.', 'credit-card', '["Paystack Integration","Flutterwave","Stripe Payments","PayPal Integration","Recurring Billing","Fraud Protection"]', 800.00, 'Starting at $800', 5),
('API Development', 'api-development', 'RESTful and GraphQL APIs built for performance and scalability.', 'server', '["RESTful APIs","GraphQL APIs","Third-party Integration","API Documentation","Rate Limiting","Security & Auth"]', 1200.00, 'Starting at $1,200', 6),
('Mobile Responsive Websites', 'mobile-responsive-websites', 'Websites that look perfect on every device.', 'smartphone', '["Responsive Design","Mobile-first Approach","Cross-browser Support","Touch Interactions","Performance Optimization","SEO Friendly"]', 600.00, 'Starting at $600', 7),
('Business Automation Systems', 'business-automation-systems', 'Automate workflows and streamline business operations.', 'settings', '["Workflow Automation","Report Generation","Notification Systems","Data Processing","Integration Services","Custom Workflows"]', 2000.00, 'Starting at $2,000', 8),
('Fuel Station Management', 'fuel-station-management', 'Complete management systems for fuel stations and petroleum businesses.', 'fuel', '["Fuel Inventory Tracking","Tank Level Monitoring","Sales Management","Supplier Management","Employee Management","Financial Reports"]', 3500.00, 'Starting at $3,500', 9),
('Church Websites', 'church-websites', 'Beautiful church websites with live streaming and event management.', 'church', '["Live Streaming","Sermon Library","Event Calendar","Donation System","Member Directory","Announcements"]', 1000.00, 'Starting at $1,000', 10),
('Real Estate Platforms', 'real-estate-platforms', 'Property listing platforms with advanced search and virtual tours.', 'home', '["Property Listings","Advanced Search","Image Galleries","Virtual Tours","Inquiry System","Agent Profiles"]', 2500.00, 'Starting at $2,500', 11),
('Multi Vendor Marketplaces', 'multi-vendor-marketplaces', 'Multi-vendor e-commerce platforms with vendor management.', 'users', '["Vendor Registration","Product Management","Commission System","Vendor Dashboards","Rating & Reviews","Dispute Resolution"]', 4000.00, 'Starting at $4,000', 12),
('School Management Systems', 'school-management-systems', 'Comprehensive school management platforms.', 'graduation-cap', '["Student Management","Attendance Tracking","Grade Management","Timetable Scheduling","Fee Management","Parent Portal"]', 3000.00, 'Starting at $3,000', 13),
('Custom Web Applications', 'custom-web-applications', 'Tailored web applications built to your exact specifications.', 'layout', '["Custom Development","Requirement Analysis","UI/UX Design","Database Architecture","Testing & QA","Maintenance & Support"]', 2000.00, 'Starting at $2,000', 14),
('Portfolio Websites', 'portfolio-websites', 'Premium portfolio websites that showcase your work beautifully.', 'image', '["Custom Design","Project Showcase","CMS Integration","Animation Effects","SEO Optimization","Contact System"]', 800.00, 'Starting at $800', 15),
('Mobile App Development', 'mobile-app-development', 'Native and cross-platform mobile applications for Android and iOS using React Native and Flutter.', 'smartphone', '["Cross-platform Development","Native Android Apps","Native iOS Apps","App Store Deployment","Push Notifications","Offline Support"]', 3000.00, 'Starting at $3,000', 16),
('Website to App Conversion', 'website-to-app-conversion', 'Convert your WordPress site or any existing website into a fully functional Android/iOS mobile app.', 'refresh-cw', '["WordPress to App","Existing Site to App","Push Notifications","Offline Mode","App Store Submission","Ongoing Support"]', 1500.00, 'Starting at $1,500', 17);

-- Default Experiences
INSERT INTO experiences (title, company, location, start_date, end_date, current, description, type, sort_order) VALUES
('Full Stack Developer', 'Freelance / Self-Employed', 'Nigeria (Remote Worldwide)', '2021-01-01', NULL, TRUE, 'Building premium web applications for international clients. Specializing in SaaS platforms, e-commerce solutions, admin dashboards, and custom web applications using modern technologies.', 'freelance', 1),
('Senior Web Developer', 'Tech Startup Collaborations', 'Remote', '2022-06-01', NULL, TRUE, 'Partnering with startups to build scalable platforms from concept to launch. Architected complete backend systems, frontend interfaces, and deployment pipelines.', 'freelance', 2),
('Web Development Consultant', 'Various International Clients', 'Global Remote', '2020-01-01', NULL, TRUE, 'Providing technical consulting and development services to businesses across multiple countries including USA, UK, Canada, and UAE.', 'freelance', 3),
('Full Stack Developer (Contract)', 'Digital Agencies', 'Remote', '2019-01-01', '2021-01-01', FALSE, 'Worked with multiple digital agencies on client projects ranging from e-commerce platforms to custom web applications and content management systems.', 'contract', 4);

-- Default Testimonials
INSERT INTO testimonials (name, role, company, content, rating, featured, sort_order) VALUES
('James Anderson', 'CEO', 'TechFlow Solutions', 'Working with Aleci was an absolute game-changer for our business. He built our entire SaaS platform from scratch, and the results exceeded every expectation. His understanding of both frontend and backend is remarkable. Highly recommended for any serious project.', 5, TRUE, 1),
('Sarah Mitchell', 'Founder', 'GreenLeaf Enterprises', 'I have worked with developers from around the world, and Aleci stands out for his professionalism, communication, and technical excellence. He transformed our outdated website into a modern, high-performing platform. Our conversions increased by 200%.', 5, TRUE, 2),
('Michael Chen', 'CTO', 'DataVault Systems', 'Aleci delivered our admin dashboard ahead of schedule with exceptional quality. His code is clean, well-documented, and scalable. The real-time features and data visualization he implemented are world-class.', 5, TRUE, 3),
('Emily Roberts', 'Project Manager', 'WebCraft Agency', 'Aleci is the kind of developer every agency dreams of working with. He understands deadlines, communicates proactively, and delivers code that works flawlessly. Our clients have been consistently impressed with his work.', 5, TRUE, 4),
('David Okonkwo', 'Business Owner', 'Premier Motors Ltd', 'Aleci built our fuel station management system and it completely transformed our operations. We went from manual tracking to a fully automated system. The ROI was immediate and substantial. Thank you for your amazing work.', 5, TRUE, 5),
('Amara Williams', 'Director', 'Bloom Digital', 'Our church website built by Aleci has received countless compliments. The live streaming integration, sermon library, and donation system work seamlessly. He truly understands how to blend functionality with beautiful design.', 5, TRUE, 6);

-- Default Projects
INSERT INTO projects (title, slug, description, category, technologies, live_url, github_url, featured, problem_solved, results, sort_order) VALUES
('Fuel Station Management System', 'fuel-station-management-system', 'A comprehensive management platform for fuel stations featuring real-time tank level monitoring, inventory tracking, sales management, employee oversight, and detailed financial reporting. Built with modern web technologies for optimal performance.', 'Web Application', '["PHP","MySQL","JavaScript","Bootstrap","REST API","Chart.js"]', 'https://demo.alenmodwebhub.com/fuelstation', 'https://github.com/alenmodwebhub/fuelstation', TRUE, 'Fuel stations were struggling with manual inventory tracking, fuel theft, and lack of real-time data on tank levels and sales.', 'Reduced fuel losses by 40%, automated reporting saved 20 hours/week, real-time monitoring prevented stockouts.', 1),
('Multi Vendor E-commerce Platform', 'multi-vendor-ecommerce-platform', 'A powerful multi-vendor marketplace platform that enables multiple sellers to register, list products, and manage their own stores within a single ecosystem. Features commission management, vendor dashboards, and comprehensive analytics.', 'E-commerce', '["PHP","Laravel","MySQL","JavaScript","Paystack","Tailwind CSS"]', 'https://demo.alenmodwebhub.com/marketplace', 'https://github.com/alenmodwebhub/marketplace', TRUE, 'Businesses needed a platform where multiple vendors could sell products with automated commission tracking and vendor management.', 'Platform launched with 50+ vendors in first month, processing 1000+ transactions monthly with zero downtime.', 2),
('Church Streaming & Management Website', 'church-streaming-website', 'A modern church website with live streaming capabilities, sermon library, event management, online donations, member directory, and announcement system. Designed to engage both local and online congregations.', 'Web Application', '["React","Node.js","MySQL","Socket.io","Stripe","Tailwind CSS"]', 'https://demo.alenmodwebhub.com/church', 'https://github.com/alenmodwebhub/church', TRUE, 'Churches needed a unified platform for live streaming, sermon management, online donations, and community engagement.', 'Online attendance grew by 300%, donations increased by 150%, congregation engagement improved significantly.', 3),
('Real Estate Platform', 'real-estate-platform', 'A feature-rich real estate platform with property listings, advanced search filters, virtual tours, agent profiles, and inquiry management. Built for both property seekers and real estate agents.', 'Web Application', '["React","Node.js","MongoDB","Google Maps API","Cloudinary","Tailwind CSS"]', 'https://demo.alenmodwebhub.com/realestate', 'https://github.com/alenmodwebhub/realestate', TRUE, 'Real estate agencies needed a modern platform for property listings with powerful search capabilities and virtual tour support.', 'Property inquiries increased by 250%, agent productivity improved by 60%, user engagement doubled.', 4),
('Broker Trading Dashboard', 'broker-trading-dashboard', 'An advanced trading dashboard for brokers featuring real-time market data, portfolio management, trade execution, performance analytics, and risk management tools. Built for speed and reliability.', 'Dashboard', '["React","TypeScript","Node.js","WebSocket","PostgreSQL","D3.js"]', 'https://demo.alenmodwebhub.com/trading', 'https://github.com/alenmodwebhub/trading', TRUE, 'Brokers needed a professional-grade trading dashboard with real-time data, advanced charts, and reliable trade execution.', 'Trading efficiency improved by 70%, real-time data accuracy at 99.9%, client satisfaction scores increased.', 5),
('School Management System', 'school-management-system', 'A complete school management platform covering student records, attendance tracking, grade management, timetable scheduling, fee management, and parent-teacher communication.', 'Web Application', '["PHP","Laravel","MySQL","JavaScript","Bootstrap","REST API"]', 'https://demo.alenmodwebhub.com/school', 'https://github.com/alenmodwebhub/school', TRUE, 'Schools were managing records manually with paper-based systems leading to data loss and inefficiency.', 'Administrative workload reduced by 60%, data accuracy improved to 100%, parent satisfaction increased significantly.', 6),
('POS & Inventory System', 'pos-inventory-system', 'A point of sale and inventory management system with barcode scanning, real-time stock tracking, sales reporting, supplier management, and multi-branch support.', 'Web Application', '["PHP","MySQL","JavaScript","Bootstrap","REST API","Chart.js"]', 'https://demo.alenmodwebhub.com/pos', 'https://github.com/alenmodwebhub/pos', TRUE, 'Retail businesses needed an affordable POS system with comprehensive inventory management and sales analytics.', 'Sales processing speed increased by 80%, inventory accuracy improved to 99%, reporting time reduced by 90%.', 7),
('Advanced Admin Dashboard', 'advanced-admin-dashboard', 'A sophisticated admin dashboard with real-time analytics, user management, role-based access control, activity logging, and customizable widgets. Designed for enterprise-level administration.', 'Dashboard', '["React","TypeScript","Node.js","MySQL","Socket.io","Tailwind CSS"]', 'https://demo.alenmodwebhub.com/admin', 'https://github.com/alenmodwebhub/admin-dashboard', TRUE, 'Businesses needed a centralized admin panel to manage users, monitor activities, and generate comprehensive reports.', 'Management efficiency improved by 200%, real-time monitoring reduced response time by 60%, user management became seamless.', 8);

-- Default Blog Posts
INSERT INTO blog_posts (title, slug, excerpt, content, category, tags, featured, reading_time) VALUES
('The Future of Web Development in Africa', 'future-of-web-development-africa', 'Exploring how African developers are reshaping the global tech landscape with innovation and resilience.', '<p>Africa is experiencing a digital revolution, and web development is at the heart of this transformation. From Lagos to Nairobi, a new generation of developers is building solutions that solve local problems while competing on a global scale.</p><p>The rise of remote work has opened unprecedented opportunities for African developers. Companies around the world are discovering the talent, dedication, and innovation that African developers bring to the table.</p><p>Key trends shaping the future include the growth of fintech, e-commerce expansion, and the increasing demand for custom web applications across various sectors.</p>', 'Technology', '["Web Development","Africa","Technology","Remote Work","Innovation"]', TRUE, 5),
('Building Scalable SaaS Platforms', 'building-scalable-saas-platforms', 'A comprehensive guide to architecting and building SaaS platforms that scale from zero to millions of users.', '<p>Building a SaaS platform that scales requires careful planning, robust architecture, and the right technology choices. In this guide, I share the principles and practices I have learned from building multiple successful SaaS platforms.</p><p>From choosing the right database to implementing caching strategies, every decision impacts your platform ability to scale. I cover multi-tenant architecture, subscription management, and performance optimization.</p>', 'Development', '["SaaS","Scalability","Architecture","Web Development","Best Practices"]', TRUE, 8),
('Why Your Business Needs a Custom Web Application', 'why-business-needs-custom-web-application', 'Discover how custom web applications give your business a competitive advantage over off-the-shelf solutions.', '<p>Off-the-shelf software can only take your business so far. When you need specific features, unique workflows, or a competitive edge, custom web applications are the answer.</p><p>Custom applications are built around your exact business processes, not the other way around. This means higher efficiency, better user adoption, and a direct impact on your bottom line.</p><p>In this post, I break down the ROI of custom development and when it makes sense to invest in a bespoke solution.</p>', 'Business', '["Business","Custom Software","Web Applications","Digital Transformation","ROI"]', TRUE, 6),
('The Art of Clean Code', 'the-art-of-clean-code', 'Why writing clean, maintainable code matters for long-term project success.', '<p>Clean code is not just about aesthetics — it is about maintainability, scalability, and professional pride. Every time I write code, I think about the developer who will maintain it months or years later.</p><p>In this article, I share my principles for writing clean code: meaningful names, single responsibility, proper abstraction, and comprehensive error handling. These practices have saved countless hours of debugging and refactoring.</p>', 'Development', '["Clean Code","Best Practices","Development","Quality","Professionalism"]', TRUE, 5);
