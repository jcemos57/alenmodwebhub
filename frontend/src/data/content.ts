import { Project, Service, Testimonial, Skill, Experience } from '@/types';

export const siteConfig = {
  name: 'Alenmodwebhub',
  title: 'Full Stack Web Developer | Nigeria',
  email: 'hello@alenmodwebhub.com',
  phone: '+234 XXX XXX XXXX',
  whatsapp: '234XXXXXXXXXX',
  location: 'Nigeria',
  availability: 'Available for Freelance & Remote Jobs Worldwide',
  social: {
    github: 'https://github.com/alenmodwebhub',
    linkedin: 'https://linkedin.com/in/alenmodwebhub',
    twitter: 'https://twitter.com/alenmodwebhub',
    instagram: 'https://instagram.com/alenmodwebhub',
    youtube: 'https://youtube.com/@alenmodwebhub',
  }
};

export const heroContent = {
  headline: 'I Build Powerful Web Experiences That Grow Businesses',
  subtitle: 'Full Stack Developer from Nigeria helping startups, businesses, and brands build scalable modern platforms that drive real results.',
  availability: 'Available for Freelance & Remote Jobs Worldwide',
};

export const stats = [
  { label: 'Years Experience', value: 5, suffix: '+' },
  { label: 'Projects Completed', value: 50, suffix: '+' },
  { label: 'Happy Clients', value: 30, suffix: '+' },
  { label: 'Technologies Mastered', value: 18, suffix: '+' },
  { label: 'Countries Worked With', value: 8, suffix: '+' },
];

export const aboutContent = {
  story: `My journey as a developer began with a simple curiosity about how websites work. From the vibrant tech scene in Nigeria, I've grown into a full-stack developer who builds digital solutions that make a real impact.

What drives me is the power of technology to transform businesses and lives. Every line of code I write is focused on solving real problems — whether it's helping a startup launch their platform, optimizing a business for efficiency, or creating experiences that users love.

I specialize in building complex systems that are scalable, secure, and beautifully designed. From e-commerce platforms and SaaS applications to real-time dashboards and management systems, I bring ideas to life with clean code and modern architecture.

My commitment to quality means I don't just deliver code — I deliver solutions that work, perform, and impress. Working with clients globally, I've learned to communicate clearly, deliver consistently, and build relationships based on trust and results.

My vision is simple: build impactful digital products that help businesses grow, solve problems, and make the world a little more connected through technology.`,
  highlights: [
    '5+ Years of Professional Experience',
    '50+ Successful Projects Delivered',
    'Global Client Base Across 8 Countries',
    'Expert in Modern Web Technologies',
    'Clean Code & Scalable Architecture',
    'Business-Focused Solutions',
  ]
};

export const whyHireMe = [
  {
    title: 'Reliability',
    description: 'I deliver on time, every time. Clear communication and consistent updates throughout the project.',
    icon: '🔒'
  },
  {
    title: 'Clean Code',
    description: 'I write maintainable, scalable code that follows best practices and industry standards.',
    icon: '✨'
  },
  {
    title: 'Business Focus',
    description: 'I build solutions that drive real business results, not just pretty interfaces.',
    icon: '🎯'
  },
  {
    title: 'Modern UI/UX',
    description: 'I create stunning user experiences that users love and remember.',
    icon: '🎨'
  },
  {
    title: 'Problem Solving',
    description: 'Complex challenges are my specialty. I find elegant solutions to difficult problems.',
    icon: '🧠'
  },
  {
    title: 'Speed & Performance',
    description: 'Fast-loading, optimized applications that perform flawlessly under any load.',
    icon: '⚡'
  },
];

export const services: Service[] = [
  {
    id: 'fullstack',
    title: 'Full Stack Web Development',
    description: 'End-to-end web applications built with modern technologies. From concept to deployment, I handle everything.',
    icon: '🌐',
    features: ['Custom Web Applications', 'Responsive Design', 'API Development', 'Database Design', 'Cloud Deployment'],
    price: 'Starting from $500'
  },
  {
    id: 'saas',
    title: 'SaaS Development',
    description: 'Scalable Software-as-a-Service platforms with subscription management, user auth, and analytics.',
    icon: '☁️',
    features: ['Multi-tenant Architecture', 'Subscription Billing', 'User Dashboards', 'Analytics', 'API Ecosystem'],
    price: 'Starting from $2,000'
  },
  {
    id: 'dashboard',
    title: 'Admin Dashboard Systems',
    description: 'Powerful admin panels with real-time data visualization, user management, and comprehensive controls.',
    icon: '📊',
    features: ['Real-time Charts', 'User Management', 'Content Management', 'Role-based Access', 'Activity Logs'],
    price: 'Starting from $800'
  },
  {
    id: 'ecommerce',
    title: 'E-commerce Solutions',
    description: 'Full-featured online stores with payment integration, inventory management, and seamless checkout.',
    icon: '🛒',
    features: ['Payment Integration', 'Inventory Management', 'Order Tracking', 'Multi-vendor Support', 'Mobile Optimized'],
    price: 'Starting from $1,000'
  },
  {
    id: 'api',
    title: 'API Development & Integration',
    description: 'RESTful and GraphQL APIs that connect your systems with third-party services and platforms.',
    icon: '🔗',
    features: ['RESTful APIs', 'Third-party Integration', 'Webhook Systems', 'API Documentation', 'Security'],
    price: 'Starting from $400'
  },
  {
    id: 'automation',
    title: 'Business Automation Systems',
    description: 'Streamline your operations with custom automation tools that save time and reduce errors.',
    icon: '⚙️',
    features: ['Workflow Automation', 'Report Generation', 'Notification Systems', 'Data Processing', 'Integration'],
    price: 'Starting from $600'
  },
  {
    id: 'management',
    title: 'Management Systems',
    description: 'Fuel station, school, church, real estate, and inventory management systems tailored to your needs.',
    icon: '🏗️',
    features: ['Inventory Tracking', 'Staff Management', 'Financial Reports', 'Customer Management', 'Analytics Dashboard'],
    price: 'Starting from $1,500'
  },
  {
    id: 'marketplace',
    title: 'Multi-Vendor Marketplaces',
    description: 'Platforms where multiple sellers can list products, manage orders, and grow their business.',
    icon: '🏪',
    features: ['Vendor Dashboards', 'Commission System', 'Product Management', 'Review System', 'Payment Splitting'],
    price: 'Starting from $2,500'
  },
  {
    id: 'custom',
    title: 'Custom Web Applications',
    description: 'Unique solutions built from the ground up to solve your specific business challenges.',
    icon: '💡',
    features: ['Requirements Analysis', 'Custom Development', 'Testing & QA', 'Deployment', 'Ongoing Support'],
    price: 'Varies by project'
  },
];

export const skills: Skill[] = [
  { name: 'HTML5', level: 98, category: 'frontend', icon: '🌐' },
  { name: 'CSS3', level: 95, category: 'frontend', icon: '🎨' },
  { name: 'JavaScript', level: 95, category: 'frontend', icon: '⚡' },
  { name: 'TypeScript', level: 88, category: 'frontend', icon: '📘' },
  { name: 'React', level: 92, category: 'frontend', icon: '⚛️' },
  { name: 'Next.js', level: 88, category: 'frontend', icon: '▲' },
  { name: 'Node.js', level: 90, category: 'backend', icon: '🟢' },
  { name: 'PHP', level: 95, category: 'backend', icon: '🐘' },
  { name: 'Laravel', level: 90, category: 'backend', icon: '🎭' },
  { name: 'MySQL', level: 92, category: 'database', icon: '🗄️' },
  { name: 'MongoDB', level: 82, category: 'database', icon: '🍃' },
  { name: 'Firebase', level: 80, category: 'database', icon: '🔥' },
  { name: 'Tailwind CSS', level: 95, category: 'frontend', icon: '🌊' },
  { name: 'Bootstrap', level: 90, category: 'frontend', icon: '🅱️' },
  { name: 'REST API', level: 92, category: 'backend', icon: '🔌' },
  { name: 'Git/GitHub', level: 90, category: 'tools', icon: '📝' },
  { name: 'Linux', level: 82, category: 'tools', icon: '🐧' },
  { name: 'Cloud Hosting', level: 85, category: 'tools', icon: '☁️' },
];

export const projects: Project[] = [
  {
    id: 'fuel-station',
    title: 'Fuel Station Management System',
    description: 'A comprehensive management platform for fuel stations with real-time tank monitoring, sales tracking, and inventory management.',
    problem: 'Fuel stations in Nigeria struggled with manual record-keeping, fuel theft, and lack of real-time visibility into operations.',
    solution: 'Built a full-featured system with automated tank gauging, POS integration, employee management, and detailed analytics dashboard.',
    results: 'Reduced fuel losses by 40%, improved operational efficiency by 60%, and provided real-time business intelligence.',
    technologies: ['PHP', 'Laravel', 'MySQL', 'JavaScript', 'Bootstrap', 'REST API'],
    images: ['/images/projects/fuel-station-1.jpg', '/images/projects/fuel-station-2.jpg'],
    category: 'Management System',
    featured: true,
    stats: [
      { label: 'Fuel Loss Reduction', value: '40%' },
      { label: 'Efficiency Gain', value: '60%' },
      { label: 'Active Users', value: '50+' },
    ],
    year: 2024
  },
  {
    id: 'multi-vendor',
    title: 'Multi-Vendor E-commerce Platform',
    description: 'A scalable marketplace platform where vendors can register, list products, and manage their online store.',
    problem: 'Small businesses needed a platform to sell online without the complexity and cost of building individual websites.',
    solution: 'Created a multi-vendor marketplace with vendor dashboards, commission system, payment splitting, and review management.',
    results: 'Onboarded 100+ vendors in 3 months, processed 10,000+ orders, and achieved 99.9% uptime.',
    technologies: ['Laravel', 'PHP', 'MySQL', 'JavaScript', 'Tailwind CSS', 'Paystack API'],
    images: ['/images/projects/marketplace-1.jpg', '/images/projects/marketplace-2.jpg'],
    category: 'E-commerce',
    featured: true,
    stats: [
      { label: 'Active Vendors', value: '100+' },
      { label: 'Orders Processed', value: '10K+' },
      { label: 'Uptime', value: '99.9%' },
    ],
    year: 2024
  },
  {
    id: 'church-streaming',
    title: 'Church Streaming & Management Platform',
    description: 'A complete church management system with live streaming, donation management, member directory, and event scheduling.',
    problem: 'Churches needed a unified platform for online services, member management, and digital giving.',
    solution: 'Developed an all-in-one platform with live streaming, tithe/donation tracking, member profiles, and event management.',
    results: 'Served 5,000+ congregation members, processed $200K+ in donations, and streamed 500+ services.',
    technologies: ['Next.js', 'Node.js', 'MongoDB', 'WebRTC', 'Stripe', 'Tailwind CSS'],
    images: ['/images/projects/church-1.jpg', '/images/projects/church-2.jpg'],
    category: 'Custom Application',
    featured: true,
    stats: [
      { label: 'Congregation Served', value: '5K+' },
      { label: 'Donations Processed', value: '$200K+' },
      { label: 'Services Streamed', value: '500+' },
    ],
    year: 2023
  },
  {
    id: 'real-estate',
    title: 'Real Estate Platform',
    description: 'A modern real estate platform with property listings, virtual tours, agent management, and mortgage calculator.',
    problem: 'Real estate agents needed a modern platform to showcase properties and manage client inquiries efficiently.',
    solution: 'Built a feature-rich platform with property search, virtual tours, agent dashboards, and automated inquiry management.',
    results: 'Listed 500+ properties, reduced inquiry response time by 80%, and increased agent productivity by 50%.',
    technologies: ['React', 'Node.js', 'PostgreSQL', 'Google Maps API', 'Cloudinary', 'Tailwind CSS'],
    images: ['/images/projects/realestate-1.jpg', '/images/projects/realestate-2.jpg'],
    category: 'Web Application',
    featured: true,
    stats: [
      { label: 'Properties Listed', value: '500+' },
      { label: 'Response Time Cut', value: '80%' },
      { label: 'Agent Productivity', value: '+50%' },
    ],
    year: 2023
  },
  {
    id: 'trading-dashboard',
    title: 'Broker Trading Dashboard',
    description: 'A real-time trading dashboard for brokers with live market data, portfolio management, and advanced charting.',
    problem: 'Brokers needed a professional dashboard to monitor markets, manage client portfolios, and execute trades efficiently.',
    solution: 'Created a real-time dashboard with live price feeds, interactive charts, portfolio tracking, and trade execution.',
    results: 'Processed $5M+ in trading volume, reduced trade execution time by 70%, and improved client satisfaction by 45%.',
    technologies: ['React', 'TypeScript', 'Node.js', 'WebSocket', 'Chart.js', 'Firebase'],
    images: ['/images/projects/trading-1.jpg', '/images/projects/trading-2.jpg'],
    category: 'Dashboard',
    featured: false,
    stats: [
      { label: 'Trading Volume', value: '$5M+' },
      { label: 'Execution Speed', value: '-70%' },
      { label: 'Client Satisfaction', value: '+45%' },
    ],
    year: 2024
  },
  {
    id: 'school-management',
    title: 'School Management System',
    description: 'A comprehensive school management platform with student records, attendance tracking, grade management, and parent portal.',
    problem: 'Schools struggled with paper-based record keeping, communication gaps with parents, and inefficient grade management.',
    solution: 'Developed a complete system with student profiles, automated attendance, gradebooks, parent communication portal, and report generation.',
    results: 'Served 2,000+ students, reduced administrative work by 55%, and improved parent-school communication by 70%.',
    technologies: ['PHP', 'Laravel', 'MySQL', 'JavaScript', 'Bootstrap', 'Twilio API'],
    images: ['/images/projects/school-1.jpg', '/images/projects/school-2.jpg'],
    category: 'Management System',
    featured: false,
    stats: [
      { label: 'Students Served', value: '2K+' },
      { label: 'Admin Work Reduced', value: '55%' },
      { label: 'Communication Boost', value: '70%' },
    ],
    year: 2023
  },
  {
    id: 'pos-inventory',
    title: 'POS & Inventory System',
    description: 'A point-of-sale and inventory management system for retail businesses with barcode scanning and sales analytics.',
    problem: 'Retail businesses needed an affordable, modern POS system with real-time inventory tracking.',
    solution: 'Built a comprehensive POS system with barcode scanning, inventory management, sales reports, and supplier management.',
    results: 'Reduced inventory discrepancies by 90%, improved checkout speed by 60%, and provided actionable sales insights.',
    technologies: ['PHP', 'MySQL', 'JavaScript', 'HTML5', 'CSS3', 'Barcode API'],
    images: ['/images/projects/pos-1.jpg', '/images/projects/pos-2.jpg'],
    category: 'Management System',
    featured: false,
    stats: [
      { label: 'Inventory Accuracy', value: '90%' },
      { label: 'Checkout Speed', value: '+60%' },
      { label: 'Businesses Served', value: '25+' },
    ],
    year: 2023
  },
  {
    id: 'admin-dashboard',
    title: 'Advanced Admin Dashboard',
    description: 'A powerful admin dashboard template with analytics, user management, and customizable widgets.',
    problem: 'Businesses needed a ready-to-use admin dashboard with modern UI and comprehensive features.',
    solution: 'Created a modular admin dashboard with real-time analytics, user roles, notification system, and theme customization.',
    results: 'Adopted by 10+ businesses, reduced development time by 80%, and provided enterprise-grade features out of the box.',
    technologies: ['React', 'TypeScript', 'Node.js', 'MongoDB', 'Chart.js', 'Tailwind CSS'],
    images: ['/images/projects/admin-1.jpg', '/images/projects/admin-2.jpg'],
    category: 'Dashboard',
    featured: false,
    stats: [
      { label: 'Businesses Using', value: '10+' },
      { label: 'Dev Time Saved', value: '80%' },
      { label: 'Dashboard Views', value: '50K+' },
    ],
    year: 2024
  },
];

export const experiences: Experience[] = [
  {
    id: 'exp-1',
    title: 'Full Stack Developer (Freelance)',
    company: 'Self-Employed',
    location: 'Nigeria / Remote',
    startDate: '2020',
    endDate: 'Present',
    description: 'Building custom web applications, management systems, e-commerce platforms, and SaaS solutions for clients worldwide. Managing full project lifecycle from requirements to deployment.',
    technologies: ['React', 'Node.js', 'PHP', 'Laravel', 'MySQL', 'MongoDB', 'Tailwind CSS'],
    type: 'freelance'
  },
  {
    id: 'exp-2',
    title: 'Lead Developer',
    company: 'Tech Startup',
    location: 'Nigeria',
    startDate: '2022',
    endDate: '2024',
    description: 'Led development of multiple SaaS platforms and web applications. Managed team of 5 developers. Architected scalable systems serving 10,000+ users.',
    technologies: ['Next.js', 'TypeScript', 'Node.js', 'PostgreSQL', 'AWS', 'Docker'],
    type: 'fulltime'
  },
  {
    id: 'exp-3',
    title: 'Web Application Developer',
    company: 'Digital Agency',
    location: 'Nigeria',
    startDate: '2021',
    endDate: '2022',
    description: 'Developed custom web applications for diverse clients. Specialized in admin dashboards, e-commerce solutions, and content management systems.',
    technologies: ['PHP', 'Laravel', 'MySQL', 'JavaScript', 'Bootstrap', 'jQuery'],
    type: 'fulltime'
  },
  {
    id: 'exp-4',
    title: 'Junior Full Stack Developer',
    company: 'Software Company',
    location: 'Nigeria',
    startDate: '2019',
    endDate: '2021',
    description: 'Built and maintained web applications using PHP and JavaScript. Collaborated on database design, API development, and frontend implementation.',
    technologies: ['PHP', 'MySQL', 'JavaScript', 'HTML5', 'CSS3', 'Git'],
    type: 'fulltime'
  },
];

export const testimonials: Testimonial[] = [
  {
    id: 'test-1',
    name: 'Chioma Okafor',
    role: 'CEO',
    company: 'TechVault Solutions',
    avatar: '/images/testimonials/client-1.jpg',
    content: 'Working with Aleci was an absolute game-changer for our business. He built a custom management system that transformed our operations. His technical expertise is world-class, and his understanding of business needs sets him apart from any developer I\'ve worked with.',
    rating: 5
  },
  {
    id: 'test-2',
    name: 'Emmanuel Adeyemi',
    role: 'Founder',
    company: 'GreenFuel Services',
    avatar: '/images/testimonials/client-2.jpg',
    content: 'The fuel station management system Aleci developed for us is incredible. It gave us real-time visibility into our operations and saved us millions in potential losses. He delivered on time and exceeded our expectations. Highly recommended!',
    rating: 5
  },
  {
    id: 'test-3',
    name: 'Sarah Ibrahim',
    role: 'Project Manager',
    company: 'WebCraft Agency',
    avatar: '/images/testimonials/client-3.jpg',
    content: 'Aleci is the most reliable developer I\'ve collaborated with. His code is clean, his communication is excellent, and he always delivers beyond what was promised. Any team would be lucky to have him.',
    rating: 5
  },
  {
    id: 'test-4',
    name: 'Michael Obi',
    role: 'CTO',
    company: 'PayStream Africa',
    avatar: '/images/testimonials/client-4.jpg',
    content: 'I was blown away by the quality of work Aleci delivered. He built our payment integration system with such precision and attention to security that we passed every compliance check on the first try. A truly gifted developer.',
    rating: 5
  },
  {
    id: 'test-5',
    name: 'Esther Ogunlade',
    role: 'Director',
    company: 'Royal Oaks Church',
    avatar: '/images/testimonials/client-5.jpg',
    content: 'Our church streaming platform has been a blessing to our congregation. Aleci understood our vision perfectly and created something beautiful and functional. Many churches have reached out asking about our platform!',
    rating: 5
  },
  {
    id: 'test-6',
    name: 'David Nwachukwu',
    role: 'Business Owner',
    company: 'ShopNaija Online',
    avatar: '/images/testimonials/client-6.jpg',
    content: 'The e-commerce platform Aleci built for us helped triple our sales in the first quarter. The user experience is smooth, and the admin panel makes managing our store so easy. Best investment we made for our business.',
    rating: 5
  },
];

export const processSteps = [
  {
    number: '01',
    title: 'Discovery',
    description: 'Understanding your business, goals, and requirements through in-depth consultation.',
    icon: '🔍'
  },
  {
    number: '02',
    title: 'Planning',
    description: 'Creating a detailed roadmap with timelines, milestones, and technical architecture.',
    icon: '📋'
  },
  {
    number: '03',
    title: 'Design',
    description: 'Crafting beautiful, user-centered interfaces with modern design principles.',
    icon: '🎨'
  },
  {
    number: '04',
    title: 'Development',
    description: 'Building your solution with clean code, best practices, and regular updates.',
    icon: '💻'
  },
  {
    number: '05',
    title: 'Testing',
    description: 'Rigorous testing across devices, browsers, and scenarios to ensure quality.',
    icon: '✅'
  },
  {
    number: '06',
    title: 'Deployment',
    description: 'Launching your project with proper configuration, security, and monitoring.',
    icon: '🚀'
  },
  {
    number: '07',
    title: 'Support',
    description: 'Ongoing maintenance, updates, and support to keep your solution running smoothly.',
    icon: '🛡️'
  },
];

export const pricingPlans = [
  {
    name: 'Starter',
    price: '$500',
    description: 'Perfect for simple websites and basic web applications.',
    features: [
      '5 Pages Responsive Website',
      'Basic Admin Dashboard',
      'Contact Form Integration',
      'SEO Optimization',
      'Social Media Integration',
      '1 Month Support',
    ],
    popular: false,
    cta: 'Get Started'
  },
  {
    name: 'Professional',
    price: '$1,500',
    description: 'Ideal for businesses needing powerful web applications.',
    features: [
      'Full Stack Web Application',
      'Advanced Admin Dashboard',
      'Payment Integration',
      'API Development',
      'Database Design & Optimization',
      '3 Months Support',
      'Performance Optimization',
      'Priority Support',
    ],
    popular: true,
    cta: 'Most Popular'
  },
  {
    name: 'Enterprise',
    price: 'Let\'s Talk',
    description: 'For complex systems and large-scale platforms.',
    features: [
      'Custom SaaS Platform',
      'Multi-vendor/Multi-tenant',
      'Real-time Features',
      'Advanced Analytics',
      'Third-party Integrations',
      '6 Months Support',
      'Dedicated Project Manager',
      '24/7 Priority Support',
      'Training & Documentation',
    ],
    popular: false,
    cta: 'Contact Me'
  },
];
