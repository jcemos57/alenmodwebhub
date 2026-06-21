'use client';
import { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { services } from '@/data/content';
import { FaArrowRight, FaCheck } from 'react-icons/fa';

export default function Services() {
  const [activeService, setActiveService] = useState<string | null>(null);

  return (
    <section id="services" className="section-padding relative">
      <div className="absolute inset-0 grid-bg opacity-20" />
      <div className="section-container relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <div className="section-badge mx-auto">What I Do</div>
          <h2 className="section-title text-center">
            Services I{' '}
            <span className="gradient-text">Provide</span>
          </h2>
          <p className="section-subtitle mx-auto text-center">
            From concept to deployment, I deliver comprehensive web solutions that drive real business results
          </p>
        </motion.div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {services.map((service, i) => (
            <motion.div
              key={service.id}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className="card group cursor-pointer relative overflow-hidden"
              onMouseEnter={() => setActiveService(service.id)}
              onMouseLeave={() => setActiveService(null)}
              whileHover={{ y: -8 }}
            >
              <div className="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-accent-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
              
              <div className="relative z-10">
                <div className="text-4xl mb-4">{service.icon}</div>
                <h3 className="text-xl font-display font-semibold mb-3 group-hover:gradient-text transition-all">
                  {service.title}
                </h3>
                <p className="text-gray-400 text-sm leading-relaxed mb-4">
                  {service.description}
                </p>

                <AnimatePresence>
                  {(activeService === service.id || true) && (
                    <motion.div
                      initial={{ opacity: 0, height: 0 }}
                      animate={{ opacity: 1, height: 'auto' }}
                      exit={{ opacity: 0, height: 0 }}
                      className="space-y-2 mb-4"
                    >
                      {service.features.map((feature, fi) => (
                        <div key={fi} className="flex items-center gap-2 text-sm text-gray-400">
                          <FaCheck className="text-primary-400 text-xs shrink-0" />
                          {feature}
                        </div>
                      ))}
                    </motion.div>
                  )}
                </AnimatePresence>

                <div className="flex items-center justify-between pt-4 border-t border-white/5">
                  <span className="text-sm text-primary-400 font-medium">{service.price}</span>
                  <button className="text-gray-500 group-hover:text-primary-400 transition-colors text-sm flex items-center gap-1">
                    Learn More <FaArrowRight size={12} />
                  </button>
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
