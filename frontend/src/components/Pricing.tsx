'use client';
import { motion } from 'framer-motion';
import { pricingPlans } from '@/data/content';
import { FaCheck, FaArrowRight } from 'react-icons/fa';

export default function Pricing() {
  return (
    <section id="pricing" className="section-padding relative">
      <div className="absolute inset-0">
        <div className="absolute bottom-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-accent-500/5 rounded-full blur-[120px]" />
      </div>

      <div className="section-container relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <div className="section-badge mx-auto">Pricing</div>
          <h2 className="section-title text-center">
            Plans That{' '}
            <span className="gradient-text">Scale</span>
          </h2>
          <p className="section-subtitle mx-auto text-center">
            Transparent pricing for projects of any size
          </p>
        </motion.div>

        <div className="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
          {pricingPlans.map((plan, i) => (
            <motion.div
              key={plan.name}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className={`card relative overflow-hidden ${
                plan.popular ? 'border-primary-500/40 shadow-xl shadow-primary-500/10 scale-105 md:scale-110' : ''
              }`}
              whileHover={{ y: -8 }}
            >
              {plan.popular && (
                <div className="absolute top-4 right-4 px-3 py-1 rounded-full bg-gradient-to-r from-primary-500 to-accent-500 text-xs font-semibold">
                  Popular
                </div>
              )}
              <div className="space-y-6">
                <div>
                  <h3 className="text-xl font-display font-semibold mb-1">{plan.name}</h3>
                  <p className="text-sm text-gray-400">{plan.description}</p>
                </div>
                <div>
                  <span className="text-4xl font-display font-bold gradient-text">{plan.price}</span>
                </div>
                <div className="space-y-3">
                  {plan.features.map((feature) => (
                    <div key={feature} className="flex items-center gap-3 text-sm text-gray-400">
                      <FaCheck className="text-primary-400 shrink-0" />
                      {feature}
                    </div>
                  ))}
                </div>
                <motion.a
                  href="#contact"
                  className={`w-full flex items-center justify-center gap-2 py-3 rounded-xl font-semibold transition-all ${
                    plan.popular
                      ? 'bg-gradient-to-r from-primary-500 to-accent-500 text-white shadow-lg shadow-primary-500/25'
                      : 'glass text-gray-300 hover:text-white hover:border-primary-500/30'
                  }`}
                  whileHover={{ scale: 1.02 }}
                  whileTap={{ scale: 0.98 }}
                >
                  {plan.cta} <FaArrowRight size={14} />
                </motion.a>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
