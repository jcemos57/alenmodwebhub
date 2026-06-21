// =============================================
// Alenmodwebhub - Premium Portfolio JavaScript
// Animations | Interactions | Effects | API
// =============================================

(function() {
  'use strict';

  // ----- DOM Ready -----
  document.addEventListener('DOMContentLoaded', init);

  function init() {
    initLoadingScreen();
    initCursor();
    initNavbar();
    initMobileMenu();
    initThemeToggle();
    initScrollReveal();
    initTypingEffect();
    initCounters();
    initSkillBars();
    initProjectFilter();
    initTestimonialSlider();
    initContactForm();
    initHireForm();
    initNewsletterForm();
    initBackToTop();
    initSmoothScroll();
    initParticles();
    initTiltCards();
    initMagneticButtons();
    initToast();
  }

  // =============================================
  // LOADING SCREEN
  // =============================================
  function initLoadingScreen() {
    const loader = document.querySelector('.loading-screen');
    if (!loader) return;

    window.addEventListener('load', () => {
      setTimeout(() => {
        loader.classList.add('hidden');
        document.body.style.overflow = '';
      }, 1500);
    });

    // Fallback: hide after 4s max
    setTimeout(() => {
      if (!loader.classList.contains('hidden')) {
        loader.classList.add('hidden');
        document.body.style.overflow = '';
      }
    }, 4000);
  }

  // =============================================
  // CUSTOM CURSOR
  // =============================================
  function initCursor() {
    const dot = document.querySelector('.cursor-dot');
    const ring = document.querySelector('.cursor-ring');
    if (!dot || !ring) return;

    let mouseX = 0, mouseY = 0;
    let ringX = 0, ringY = 0;

    document.addEventListener('mousemove', (e) => {
      mouseX = e.clientX;
      mouseY = e.clientY;
      dot.style.transform = `translate(${mouseX}px, ${mouseY}px)`;
    });

    function animateRing() {
      ringX += (mouseX - ringX) * 0.15;
      ringY += (mouseY - ringY) * 0.15;
      ring.style.transform = `translate(${ringX}px, ${ringY}px)`;
      requestAnimationFrame(animateRing);
    }
    animateRing();

    // Hover effect on interactive elements
    const interactives = document.querySelectorAll('a, button, .btn, .service-card, .project-card, .glass-card, .trust-card, .pricing-card, .blog-card, .process-card, .stat-card');
    interactives.forEach(el => {
      el.addEventListener('mouseenter', () => ring.classList.add('hover'));
      el.addEventListener('mouseleave', () => ring.classList.remove('hover'));
    });

    // Click effect
    document.addEventListener('mousedown', () => ring.classList.add('click'));
    document.addEventListener('mouseup', () => ring.classList.remove('click'));

    // Hide cursor on touch devices
    if ('ontouchstart' in window) {
      dot.style.display = 'none';
      ring.style.display = 'none';
    }
  }

  // =============================================
  // NAVBAR
  // =============================================
  function initNavbar() {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;

    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
      updateActiveNavLink();
    });

    // Active nav link based on scroll position
    function updateActiveNavLink() {
      const sections = document.querySelectorAll('section[id]');
      const navLinks = document.querySelectorAll('.nav-link');
      let current = '';

      sections.forEach(section => {
        const top = section.offsetTop - 150;
        if (window.scrollY >= top) {
          current = section.getAttribute('id');
        }
      });

      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + current) {
          link.classList.add('active');
        }
      });
    }
  }

  // =============================================
  // MOBILE MENU
  // =============================================
  function initMobileMenu() {
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const mobileNav = document.querySelector('.mobile-nav');
    const overlay = document.querySelector('.mobile-overlay');
    const closeBtn = document.querySelector('.mobile-nav-close');
    if (!menuBtn || !mobileNav) return;

    function openMenu() {
      menuBtn.classList.add('active');
      mobileNav.classList.add('open');
      if (overlay) overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
      menuBtn.classList.remove('active');
      mobileNav.classList.remove('open');
      if (overlay) overlay.classList.remove('open');
      document.body.style.overflow = '';
    }

    menuBtn.addEventListener('click', () => {
      mobileNav.classList.contains('open') ? closeMenu() : openMenu();
    });

    if (closeBtn) closeBtn.addEventListener('click', closeMenu);
    if (overlay) overlay.addEventListener('click', closeMenu);

    // Close on link click
    mobileNav.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', closeMenu);
    });
  }

  // =============================================
  // THEME TOGGLE
  // =============================================
  function initThemeToggle() {
    const toggle = document.querySelector('.theme-toggle');
    if (!toggle) return;

    const html = document.documentElement;
    const icon = toggle.querySelector('.theme-icon');

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'dark';
    if (savedTheme === 'light') {
      html.classList.remove('dark');
      html.classList.add('light');
      if (icon) icon.textContent = '☀️';
    }

    toggle.addEventListener('click', () => {
      if (html.classList.contains('light')) {
        html.classList.remove('light');
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        if (icon) icon.textContent = '🌙';
      } else {
        html.classList.remove('dark');
        html.classList.add('light');
        localStorage.setItem('theme', 'light');
        if (icon) icon.textContent = '☀️';
      }
    });
  }

  // =============================================
  // SCROLL REVEAL ANIMATIONS
  // =============================================
  function initScrollReveal() {
    const reveals = document.querySelectorAll('.reveal');

    if (!reveals.length) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });

    reveals.forEach(el => observer.observe(el));
  }

  // =============================================
  // TYPING EFFECT
  // =============================================
  function initTypingEffect() {
    const element = document.querySelector('.typing-text');
    if (!element) return;

    const words = JSON.parse(element.getAttribute('data-words') || '["Full Stack Developer","Problem Solver","Tech Innovator"]');
    let wordIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let isPaused = false;

    function type() {
      const currentWord = words[wordIndex];

      if (isPaused) {
        setTimeout(type, 2000);
        isPaused = false;
        return;
      }

      if (isDeleting) {
        element.textContent = currentWord.substring(0, charIndex - 1);
        charIndex--;
      } else {
        element.textContent = currentWord.substring(0, charIndex + 1);
        charIndex++;
      }

      let speed = isDeleting ? 50 : 100;

      if (!isDeleting && charIndex === currentWord.length) {
        speed = 2000;
        isPaused = true;
        isDeleting = true;
      } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        wordIndex = (wordIndex + 1) % words.length;
        speed = 500;
      }

      setTimeout(type, speed);
    }

    type();
  }

  // =============================================
  // ANIMATED COUNTERS
  // =============================================
  function initCounters() {
    const counters = document.querySelectorAll('.stat-number[data-target]');

    if (!counters.length) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const counter = entry.target;
          const target = parseInt(counter.getAttribute('data-target'));
          const suffix = counter.getAttribute('data-suffix') || '+';
          animateCounter(counter, target, suffix);
          observer.unobserve(counter);
        }
      });
    }, { threshold: 0.5 });

    counters.forEach(c => observer.observe(c));
  }

  function animateCounter(element, target, suffix) {
    const duration = 2000;
    const startTime = performance.now();
    const startValue = 0;

    function update(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);

      // Ease out cubic
      const eased = 1 - Math.pow(1 - progress, 3);
      const current = Math.floor(eased * target);

      element.textContent = current + suffix;

      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        element.textContent = target + suffix;
      }
    }

    requestAnimationFrame(update);
  }

  // =============================================
  // SKILL BARS ANIMATION
  // =============================================
  function initSkillBars() {
    const skillBars = document.querySelectorAll('.skill-bar-fill');

    if (!skillBars.length) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const bar = entry.target;
          const level = bar.getAttribute('data-level');
          if (level) {
            setTimeout(() => {
              bar.style.width = level + '%';
            }, 200);
          }
          observer.unobserve(bar);
        }
      });
    }, { threshold: 0.3 });

    skillBars.forEach(bar => observer.observe(bar));
  }

  // =============================================
  // PROJECT FILTER
  // =============================================
  function initProjectFilter() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');

    if (!filterBtns.length) return;

    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        // Update active button
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.getAttribute('data-filter');

        projectCards.forEach(card => {
          if (filter === 'all' || card.getAttribute('data-category') === filter) {
            card.style.display = 'block';
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
              card.style.opacity = '1';
              card.style.transform = 'translateY(0)';
            }, 50);
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  }

  // =============================================
  // TESTIMONIAL SLIDER
  // =============================================
  function initTestimonialSlider() {
    const track = document.querySelector('.testimonials-track');
    const dots = document.querySelectorAll('.testimonial-dot');
    const cards = track ? track.querySelectorAll('.testimonial-card') : [];
    if (!track || !cards.length) return;

    let current = 0;
    let autoplayInterval;

    function goTo(index) {
      current = index;
      track.style.transform = `translateX(-${current * 100}%)`;
      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === current);
      });
    }

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => {
        goTo(i);
        resetAutoplay();
      });
    });

    function next() {
      goTo((current + 1) % cards.length);
    }

    function resetAutoplay() {
      clearInterval(autoplayInterval);
      autoplayInterval = setInterval(next, 5000);
    }

    autoplayInterval = setInterval(next, 5000);

    // Swipe support
    let startX, isDragging = false;
    track.addEventListener('touchstart', (e) => {
      startX = e.touches[0].clientX;
      isDragging = true;
      clearInterval(autoplayInterval);
    }, { passive: true });

    track.addEventListener('touchend', (e) => {
      if (!isDragging) return;
      const endX = e.changedTouches[0].clientX;
      const diff = startX - endX;
      if (Math.abs(diff) > 50) {
        if (diff > 0 && current < cards.length - 1) goTo(current + 1);
        else if (diff < 0 && current > 0) goTo(current - 1);
      }
      isDragging = false;
      resetAutoplay();
    }, { passive: true });
  }

  // =============================================
  // CONTACT FORM
  // =============================================
  function initContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Sending...';
      submitBtn.disabled = true;

      const formData = new FormData(form);
      const data = Object.fromEntries(formData.entries());

      try {
        const response = await fetch((window.SITE_URL || '') + '/api/contact.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
          showToast('Message sent successfully! I will get back to you soon.', 'success');
          form.reset();
        } else {
          showToast(result.message || 'Failed to send message. Please try again.', 'error');
        }
      } catch (err) {
        showToast('Network error. Please try again later.', 'error');
      } finally {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      }
    });
  }

  // =============================================
  // HIRE ME FORM
  // =============================================
  function initHireForm() {
    const form = document.getElementById('hireForm');
    if (!form) return;

    // Show website type field when project type is website-to-app or wordpress-to-app
    const projectType = document.getElementById('hire_project_type');
    const websiteTypeGroup = document.getElementById('website_type_group');
    if (projectType && websiteTypeGroup) {
      projectType.addEventListener('change', () => {
        const val = projectType.value;
        websiteTypeGroup.style.display = (val === 'website-to-app' || val === 'wordpress-to-app') ? 'block' : 'none';
      });
    }

    // Character count
    const desc = document.getElementById('hire_description');
    const charCount = document.getElementById('hireCharCount');
    if (desc && charCount) {
      desc.addEventListener('input', () => {
        const len = desc.value.length;
        charCount.textContent = len;
        if (len > 2000) desc.value = desc.value.substring(0, 2000);
      });
    }

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn.querySelector('.hire-submit-text').textContent;
      submitBtn.querySelector('.hire-submit-text').textContent = 'Submitting...';
      submitBtn.disabled = true;

      const formData = new FormData(form);

      // Collect checkboxes as comma-separated string
      const features = [];
      form.querySelectorAll('input[name="features[]"]:checked').forEach(cb => {
        features.push(cb.value);
      });

      const data = {
        name: formData.get('name'),
        email: formData.get('email'),
        phone: formData.get('phone') || '',
        company: formData.get('company') || '',
        project_type: formData.get('project_type'),
        budget: formData.get('budget'),
        timeline: formData.get('timeline'),
        description: formData.get('description'),
        website_type: formData.get('website_type') || '',
        features: features.join(', ')
      };

      try {
        const response = await fetch((window.SITE_URL || '') + '/api/hire.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
          showToast(result.message, 'success');
          form.reset();
          if (charCount) charCount.textContent = '0';
          if (websiteTypeGroup) websiteTypeGroup.style.display = 'none';
        } else {
          showToast(result.message || 'Failed to submit. Please try again.', 'error');
        }
      } catch (err) {
        showToast('Network error. Please try again later.', 'error');
      } finally {
        submitBtn.querySelector('.hire-submit-text').textContent = originalText;
        submitBtn.disabled = false;
      }
    });
  }

  // =============================================
  // NEWSLETTER FORM
  // =============================================
  function initNewsletterForm() {
    const form = document.getElementById('newsletterForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const input = form.querySelector('input');
      const email = input.value.trim();
      if (!email) return;

      const submitBtn = form.querySelector('button');
      submitBtn.textContent = '...';
      submitBtn.disabled = true;

      try {
        const response = await fetch((window.SITE_URL || '') + '/api/newsletter.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email })
        });

        const result = await response.json();

        if (result.success) {
          showToast('Subscribed successfully!', 'success');
          form.reset();
        } else {
          showToast(result.message || 'Subscription failed.', 'error');
        }
      } catch (err) {
        showToast('Network error.', 'error');
      } finally {
        submitBtn.textContent = 'Subscribe';
        submitBtn.disabled = false;
      }
    });
  }

  // =============================================
  // BACK TO TOP
  // =============================================
  function initBackToTop() {
    const btn = document.querySelector('.back-to-top');
    if (!btn) return;

    window.addEventListener('scroll', () => {
      if (window.scrollY > 500) {
        btn.classList.add('visible');
      } else {
        btn.classList.remove('visible');
      }
    });

    btn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // =============================================
  // SMOOTH SCROLL FOR ANCHOR LINKS
  // =============================================
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', (e) => {
        const targetId = anchor.getAttribute('href');
        if (targetId === '#') return;
        const target = document.querySelector(targetId);
        if (target) {
          e.preventDefault();
          const offset = 80;
          const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
          window.scrollTo({ top, behavior: 'smooth' });
        }
      });
    });
  }

  // =============================================
  // PARTICLE BACKGROUND
  // =============================================
  function initParticles() {
    const container = document.querySelector('.hero-particles');
    if (!container) return;

    const colors = ['#6366f1', '#ec4899', '#06b6d4', '#818cf8', '#f472b6'];
    const particleCount = 30;

    for (let i = 0; i < particleCount; i++) {
      const particle = document.createElement('div');
      particle.className = 'hero-particle';

      const size = Math.random() * 8 + 2;
      const color = colors[Math.floor(Math.random() * colors.length)];

      particle.style.width = size + 'px';
      particle.style.height = size + 'px';
      particle.style.background = color;
      particle.style.left = Math.random() * 100 + '%';
      particle.style.top = Math.random() * 100 + '%';
      particle.style.animationDuration = (Math.random() * 20 + 15) + 's';
      particle.style.animationDelay = (Math.random() * 10) + 's';

      container.appendChild(particle);
    }
  }

  // =============================================
  // 3D TILT CARDS
  // =============================================
  function initTiltCards() {
    const cards = document.querySelectorAll('.tilt-card');

    cards.forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = (y - centerY) / centerY * -10;
        const rotateY = (x - centerX) / centerX * 10;

        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
      });

      card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
      });
    });
  }

  // =============================================
  // MAGNETIC BUTTONS
  // =============================================
  function initMagneticButtons() {
    const buttons = document.querySelectorAll('.magnetic-btn');

    buttons.forEach(btn => {
      btn.addEventListener('mousemove', (e) => {
        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        btn.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
      });

      btn.addEventListener('mouseleave', () => {
        btn.style.transform = 'translate(0, 0)';
      });
    });
  }

  // =============================================
  // TOAST NOTIFICATIONS
  // =============================================
  function initToast() {
    // Create toast container if not exists
    if (!document.querySelector('.toast')) {
      const toast = document.createElement('div');
      toast.className = 'toast';
      document.body.appendChild(toast);
    }
  }

  function showToast(message, type = 'success') {
    const toast = document.querySelector('.toast');
    if (!toast) return;

    toast.textContent = message;
    toast.className = 'toast ' + type;
    toast.classList.add('visible');

    clearTimeout(toast._timeout);
    toast._timeout = setTimeout(() => {
      toast.classList.remove('visible');
    }, 4000);
  }

  // Make showToast globally available
  window.showToast = showToast;

})();
