'use client';
import { motion } from 'framer-motion';
import { processSteps } from '@/data/content';
import { FaArrowRight } from 'react-icons/fa';

export default function Process() {
  return (
    <section id="process" className="section-padding relative overflow-hidden">
      <div className="absolute inset-0 grid-bg opacity-20" />

      <div className="section-container relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <div className="section-badge mx-auto">How I Work</div>
          <h2 className="section-title text-center">
            My Development{' '}
            <span className="gradient-text">Process</span>
          </h2>
          <p className="section-subtitle mx-auto text-center">
            A proven 7-step process to deliver exceptional results every time
          </p>
        </motion.div>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          {processSteps.map((step, i) => (
            <motion.div
              key={step.number}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className="card group relative overflow-hidden"
              whileHover={{ y: -8 }}
            >
              <div className="absolute top-0 right-0 text-6xl font-display font-bold text-white/5 group-hover:text-primary-500/10 transition-colors">
                {step.number}
              </div>
              <div className="relative z-10">
                <div className="text-3xl mb-4">{step.icon}</div>
                <h3 className="text-lg font-display font-semibold mb-2">{step.title}</h3>
                <p className="text-gray-400 text-sm leading-relaxed">{step.description}</p>
              </div>
              {i < processSteps.length - 1 && (
                <div className="hidden xl:block absolute -right-3 top-1/2 -translate-y-1/2 text-primary-500/30">
                  <FaArrowRight />
                </div>
              )}
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
