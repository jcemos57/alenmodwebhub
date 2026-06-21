'use client';
import { motion } from 'framer-motion';
import { FaArrowUp, FaGithub, FaLinkedin, FaTwitter, FaInstagram, FaHeart, FaCode } from 'react-icons/fa';
import { siteConfig } from '@/data/content';

export default function Footer() {
  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <footer className="relative border-t border-white/5 bg-[#0a0a0f]">
      <div className="absolute inset-0 grid-bg opacity-10" />

      <div className="section-container relative z-10 py-16">
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-10">
          <div className="space-y-4">
            <a href="/" className="flex items-center gap-2">
              <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
                <span className="text-white font-bold text-lg">A</span>
              </div>
              <span className="font-display text-xl font-bold">
                Aleci<span className="gradient-text">Developer</span>
              </span>
            </a>
            <p className="text-sm text-gray-400 leading-relaxed">
              Full Stack Developer from Nigeria building powerful web experiences that grow businesses.
            </p>
            <div className="flex gap-2">
              {[
                { icon: FaGithub, href: siteConfig.social.github },
                { icon: FaLinkedin, href: siteConfig.social.linkedin },
                { icon: FaTwitter, href: siteConfig.social.twitter },
                { icon: FaInstagram, href: siteConfig.social.instagram },
              ].map((social) => (
                <motion.a
                  key={social.href}
                  href={social.href}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="w-9 h-9 rounded-lg glass flex items-center justify-center text-gray-400 hover:text-primary-400 hover:border-primary-500/30 transition-all"
                  whileHover={{ scale: 1.1, y: -2 }}
                >
                  <social.icon size={15} />
                </motion.a>
              ))}
            </div>
          </div>

          <div>
            <h4 className="font-display font-semibold mb-4">Quick Links</h4>
            <ul className="space-y-3">
              {[
                { name: 'Home', href: '#home' },
                { name: 'About', href: '#about' },
                { name: 'Services', href: '#services' },
                { name: 'Projects', href: '#projects' },
                { name: 'Blog', href: '#blog' },
                { name: 'Contact', href: '#contact' },
              ].map((link) => (
                <li key={link.name}>
                  <a
                    href={link.href}
                    className="text-sm text-gray-400 hover:text-primary-400 transition-colors"
                  >
                    {link.name}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h4 className="font-display font-semibold mb-4">Services</h4>
            <ul className="space-y-3">
              {[
                'Web Development',
                'SaaS Platforms',
                'Admin Dashboards',
                'E-commerce',
                'API Development',
                'Custom Solutions',
              ].map((service) => (
                <li key={service}>
                  <a
                    href="#services"
                    className="text-sm text-gray-400 hover:text-primary-400 transition-colors"
                  >
                    {service}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          <div className="space-y-4">
            <h4 className="font-display font-semibold">Get In Touch</h4>
            <p className="text-sm text-gray-400">
              Have a project in mind? Let&apos;s discuss how I can help bring your vision to life.
            </p>
            <motion.a
              href="#contact"
              className="btn-primary text-sm py-3 inline-flex"
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
            >
              Start a Project
            </motion.a>
          </div>
        </div>
      </div>

      <div className="border-t border-white/5">
        <div className="section-container py-6">
          <div className="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-500">
            <p className="flex items-center gap-1">
              © {new Date().getFullYear()} AleciDeveloper. Built with <FaHeart className="text-red-500" /> and <FaCode className="text-primary-400" /> in Nigeria
            </p>
            <div className="flex items-center gap-4">
              <span>Full Stack Developer Nigeria</span>
              <span className="w-1 h-1 rounded-full bg-gray-600" />
              <span>Remote Developer</span>
            </div>
          </div>
        </div>
      </div>

      <motion.button
        onClick={scrollToTop}
        className="fixed bottom-8 right-8 w-12 h-12 rounded-full glass flex items-center justify-center text-primary-400 hover:border-primary-500/50 hover:text-primary-300 transition-all z-50 shadow-xl"
        whileHover={{ scale: 1.1, y: -2 }}
        whileTap={{ scale: 0.9 }}
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 1 }}
      >
        <FaArrowUp />
      </motion.button>
    </footer>
  );
}
