'use client';
import { motion } from 'framer-motion';
import { aboutContent } from '@/data/content';
import { FaAward, FaGlobeAfrica, FaCode, FaHeart } from 'react-icons/fa';

const highlights = [
  { icon: FaAward, text: '5+ Years Experience' },
  { icon: FaCode, text: '50+ Projects Delivered' },
  { icon: FaGlobeAfrica, text: 'Global Client Base' },
  { icon: FaHeart, text: 'Passionate About Quality' },
];

export default function About() {
  return (
    <section id="about" className="section-padding relative overflow-hidden">
      <div className="absolute inset-0">
        <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-[100px]" />
        <div className="absolute bottom-1/4 right-1/4 w-96 h-96 bg-accent-500/5 rounded-full blur-[100px]" />
      </div>

      <div className="section-container relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <div className="section-badge mx-auto">About Me</div>
          <h2 className="section-title text-center">
            The Story Behind{' '}
            <span className="gradient-text">The Code</span>
          </h2>
        </motion.div>

        <div className="grid lg:grid-cols-2 gap-16 items-center">
          <motion.div
            initial={{ opacity: 0, x: -30 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            className="space-y-6"
          >
            <div className="relative">
              <div className="w-full aspect-square max-w-md mx-auto rounded-2xl glass p-8 relative overflow-hidden">
                <div className="absolute inset-0 bg-gradient-to-br from-primary-500/10 to-accent-500/10" />
                <div className="relative z-10 h-full flex flex-col items-center justify-center text-center">
                  <div className="w-40 h-40 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center mb-6 shadow-2xl">
                    <span className="text-7xl font-bold text-white">A</span>
                  </div>
                  <h3 className="text-2xl font-display font-bold mb-2">Alenmodwebhub</h3>
                  <p className="text-gray-400 mb-6">Full Stack Web Developer</p>
                  <div className="flex flex-wrap justify-center gap-2">
                    {highlights.map((h, i) => (
                      <div key={i} className="flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 text-sm text-gray-300">
                        <h.icon className="text-primary-400 text-xs" />
                        {h.text}
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 30 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            className="space-y-6"
          >
            <p className="text-gray-300 leading-relaxed text-lg">
              {aboutContent.story}
            </p>

            <div className="grid grid-cols-2 gap-4 pt-4">
              {aboutContent.highlights.map((item, i) => (
                <motion.div
                  key={i}
                  initial={{ opacity: 0, y: 20 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ delay: i * 0.1 }}
                  className="flex items-center gap-3 p-3 rounded-lg glass"
                >
                  <div className="w-2 h-2 rounded-full bg-primary-500" />
                  <span className="text-sm text-gray-400">{item}</span>
                </motion.div>
              ))}
            </div>

            <motion.a
              href="#contact"
              className="btn-primary inline-flex mt-4"
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
            >
              Let&apos;s Work Together
            </motion.a>
          </motion.div>
        </div>
      </div>
    </section>
  );
}
