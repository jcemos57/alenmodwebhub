'use client';
import { useEffect, useRef } from 'react';
import { motion, useScroll, useTransform } from 'framer-motion';
import { FaGithub, FaLinkedin, FaTwitter, FaDownload, FaArrowRight, FaMapMarkerAlt, FaCode } from 'react-icons/fa';
import { heroContent, siteConfig } from '@/data/content';

const techIcons = ['React', 'Node.js', 'PHP', 'Laravel', 'TypeScript', 'Next.js', 'MySQL', 'MongoDB'];

export default function Hero() {
  const containerRef = useRef<HTMLDivElement>(null);
  const { scrollYProgress } = useScroll({ target: containerRef, offset: ['start start', 'end start'] });
  const y = useTransform(scrollYProgress, [0, 1], [0, 300]);
  const opacity = useTransform(scrollYProgress, [0, 0.8], [1, 0]);

  return (
    <section id="home" ref={containerRef} className="relative min-h-screen flex items-center overflow-hidden">
      <div className="animated-gradient-bg absolute inset-0" />
      <div className="grid-bg absolute inset-0 opacity-30" />
      
      <div className="absolute inset-0 overflow-hidden">
        {[...Array(50)].map((_, i) => (
          <motion.div
            key={i}
            className="absolute w-1 h-1 bg-primary-500/20 rounded-full"
            style={{
              left: `${Math.random() * 100}%`,
              top: `${Math.random() * 100}%`,
            }}
            animate={{
              opacity: [0.2, 0.8, 0.2],
              scale: [1, 1.5, 1],
            }}
            transition={{
              duration: Math.random() * 3 + 2,
              repeat: Infinity,
              delay: Math.random() * 2,
            }}
          />
        ))}
      </div>

      <motion.div style={{ y, opacity }} className="relative z-10 w-full">
        <div className="section-container">
          <div className="grid lg:grid-cols-2 gap-12 items-center min-h-screen pt-24 pb-12">
            <div className="space-y-8">
              <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5 }}
                className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-500/10 border border-primary-500/20"
              >
                <span className="w-2 h-2 rounded-full bg-green-500 animate-ping-slow" />
                <span className="text-sm text-primary-300">{siteConfig.availability}</span>
              </motion.div>

              <motion.h1
                initial={{ opacity: 0, y: 30 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: 0.2 }}
                className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-display font-bold leading-tight"
              >
                {heroContent.headline.split('That Grow')[0]}
                <span className="gradient-text">That Grow</span>
                <br />
                <span className="gradient-text">Businesses</span>
              </motion.h1>

              <motion.p
                initial={{ opacity: 0, y: 30 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: 0.4 }}
                className="text-lg md:text-xl text-gray-400 max-w-xl leading-relaxed"
              >
                {heroContent.subtitle}
              </motion.p>

              <motion.div
                initial={{ opacity: 0, y: 30 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: 0.6 }}
                className="flex flex-wrap gap-4"
              >
                <motion.a
                  href="#contact"
                  className="btn-primary group"
                  whileHover={{ scale: 1.05 }}
                  whileTap={{ scale: 0.95 }}
                >
                  Hire Me Now
                  <FaArrowRight className="group-hover:translate-x-1 transition-transform" />
                </motion.a>
                <motion.a
                  href="#projects"
                  className="btn-secondary group"
                  whileHover={{ scale: 1.05 }}
                  whileTap={{ scale: 0.95 }}
                >
                  View Projects
                </motion.a>
                <motion.a
                  href="#"
                  className="btn-secondary group"
                  whileHover={{ scale: 1.05 }}
                  whileTap={{ scale: 0.95 }}
                >
                  <FaDownload />
                  Download CV
                </motion.a>
              </motion.div>

              <motion.div
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ duration: 0.6, delay: 0.8 }}
                className="flex items-center gap-4 pt-4"
              >
                <span className="text-sm text-gray-500">Follow me:</span>
                {[
                  { icon: FaGithub, href: siteConfig.social.github },
                  { icon: FaLinkedin, href: siteConfig.social.linkedin },
                  { icon: FaTwitter, href: siteConfig.social.twitter },
                ].map((social, i) => (
                  <motion.a
                    key={i}
                    href={social.href}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="w-10 h-10 rounded-full glass flex items-center justify-center text-gray-400 hover:text-primary-400 hover:border-primary-400/50 transition-all"
                    whileHover={{ scale: 1.2, y: -2 }}
                    whileTap={{ scale: 0.9 }}
                  >
                    <social.icon size={18} />
                  </motion.a>
                ))}
              </motion.div>

              <motion.div
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ duration: 0.6, delay: 1 }}
                className="flex items-center gap-2 text-sm text-gray-500"
              >
                <FaMapMarkerAlt className="text-primary-400" />
                Nigeria — Open for Global Opportunities
              </motion.div>
            </div>

            <motion.div
              initial={{ opacity: 0, scale: 0.8 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ duration: 0.8, delay: 0.4 }}
              className="relative hidden lg:flex items-center justify-center"
            >
              <div className="relative">
                <div className="w-80 h-80 rounded-full bg-gradient-to-br from-primary-500/20 via-accent-500/20 to-primary-500/20 blur-3xl absolute -top-20 -left-20 animate-pulse-slow" />
                <div className="w-96 h-96 relative">
                  <div className="absolute inset-0 rounded-full border border-primary-500/20 animate-ping-slow" />
                  <div className="absolute inset-4 rounded-full border border-accent-500/20 animate-ping-slow" style={{ animationDelay: '0.5s' }} />
                  <div className="absolute inset-8 rounded-full glass flex items-center justify-center">
                    <div className="text-center">
                      <div className="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center mb-4 shadow-2xl shadow-primary-500/30">
                        <span className="text-5xl font-bold text-white">A</span>
                      </div>
                      <p className="text-lg font-display font-semibold">Alenmodwebhub</p>
                      <p className="text-sm text-gray-400">Full Stack Developer</p>
                    </div>
                  </div>
                </div>
              </div>

              <motion.div
                className="absolute -bottom-4 -right-4 glass px-4 py-3 rounded-xl"
                animate={{ y: [0, -8, 0] }}
                transition={{ duration: 3, repeat: Infinity }}
              >
                <div className="flex items-center gap-2">
                  <FaCode className="text-primary-400" />
                  <span className="text-sm font-medium">5+ Years Exp</span>
                </div>
              </motion.div>
            </motion.div>
          </div>

          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6, delay: 1.2 }}
            className="pb-12"
          >
            <p className="text-sm text-gray-500 mb-4 text-center">Technologies I Work With</p>
            <div className="flex flex-wrap justify-center gap-3">
              {techIcons.map((tech, i) => (
                <motion.span
                  key={tech}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ delay: 1.2 + i * 0.1 }}
                  className="px-4 py-2 text-sm rounded-full glass text-gray-300 border border-white/5 hover:border-primary-500/30 hover:text-primary-300 transition-all cursor-default"
                  whileHover={{ scale: 1.1, y: -2 }}
                >
                  {tech}
                </motion.span>
              ))}
            </div>
          </motion.div>
        </div>
      </motion.div>

      <div className="absolute bottom-8 left-1/2 -translate-x-1/2">
        <motion.div
          animate={{ y: [0, 8, 0] }}
          transition={{ duration: 2, repeat: Infinity }}
          className="w-6 h-10 rounded-full border-2 border-gray-600 flex items-start justify-center p-2"
        >
          <motion.div className="w-1.5 h-3 rounded-full bg-primary-500" />
        </motion.div>
      </div>
    </section>
  );
}
