'use client';
import { useEffect, useRef } from 'react';
import { motion, useInView } from 'framer-motion';
import { FaStar, FaShieldAlt, FaRocket, FaHandshake, FaCode, FaChartLine } from 'react-icons/fa';
import { stats, whyHireMe } from '@/data/content';

function CountUp({ end, duration = 2, suffix = '' }: { end: number; duration?: number; suffix?: string }) {
  const ref = useRef<HTMLSpanElement>(null);
  const isInView = useInView(ref, { once: true });

  useEffect(() => {
    if (!isInView || !ref.current) return;
    let start = 0;
    const increment = end / (duration * 60);
    const timer = setInterval(() => {
      start += increment;
      if (ref.current) {
        if (start >= end) {
          ref.current.textContent = `${end}${suffix}`;
          clearInterval(timer);
        } else {
          ref.current.textContent = `${Math.floor(start)}${suffix}`;
        }
      }
    }, 16);
    return () => clearInterval(timer);
  }, [isInView, end, duration, suffix]);

  return <span ref={ref}>0</span>;
}

export default function TrustSection() {
  return (
    <section className="section-padding relative">
      <div className="section-container">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <div className="section-badge mx-auto">Trust & Authority</div>
          <h2 className="section-title text-center">
            Why Clients Trust{' '}
            <span className="gradient-text">My Work</span>
          </h2>
          <p className="section-subtitle mx-auto text-center">
            With years of experience delivering world-class solutions, I&apos;ve built a reputation for excellence
          </p>
        </motion.div>

        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-20">
          {stats.map((stat, i) => (
            <motion.div
              key={stat.label}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className="card text-center p-6"
              whileHover={{ y: -5 }}
            >
              <div className="text-3xl font-display font-bold gradient-text mb-1">
                <CountUp end={stat.value} suffix={stat.suffix} />
              </div>
              <div className="text-sm text-gray-400">{stat.label}</div>
            </motion.div>
          ))}
        </div>

        <div className="grid md:grid-cols-3 gap-6">
          {whyHireMe.map((item, i) => (
            <motion.div
              key={item.title}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className="card group"
              whileHover={{ y: -8 }}
            >
              <div className="text-3xl mb-4">{item.icon}</div>
              <h3 className="text-lg font-display font-semibold mb-2">{item.title}</h3>
              <p className="text-gray-400 text-sm leading-relaxed">{item.description}</p>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
