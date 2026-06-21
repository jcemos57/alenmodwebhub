'use client';
import { motion } from 'framer-motion';
import { experiences } from '@/data/content';

export default function Experience() {
  return (
    <section id="experience" className="section-padding relative overflow-hidden">
      <div className="absolute inset-0">
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-accent-500/3 rounded-full blur-[150px]" />
      </div>

      <div className="section-container relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <div className="section-badge mx-auto">Experience</div>
          <h2 className="section-title text-center">
            My Professional{' '}
            <span className="gradient-text">Journey</span>
          </h2>
        </motion.div>

        <div className="relative max-w-3xl mx-auto">
          <div className="absolute left-8 top-0 bottom-0 w-px bg-gradient-to-b from-primary-500 via-accent-500 to-transparent" />

          {experiences.map((exp, i) => (
            <motion.div
              key={exp.id}
              initial={{ opacity: 0, x: -30 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.2 }}
              className="relative pl-20 pb-12 last:pb-0"
            >
              <motion.div
                initial={{ scale: 0 }}
                whileInView={{ scale: 1 }}
                viewport={{ once: true }}
                className="absolute left-4 w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-primary-500/30"
              >
                {i + 1}
              </motion.div>

              <motion.div className="card" whileHover={{ x: 5 }}>
                <div className="flex flex-wrap items-center gap-3 mb-2">
                  <h3 className="text-lg font-display font-semibold">{exp.title}</h3>
                  <span className="px-3 py-1 rounded-full text-xs bg-primary-500/10 text-primary-300 border border-primary-500/20">
                    {exp.type}
                  </span>
                </div>
                <p className="text-primary-400 text-sm mb-2">{exp.company} · {exp.location}</p>
                <p className="text-xs text-gray-500 mb-3">{exp.startDate} - {exp.endDate}</p>
                <p className="text-gray-400 text-sm leading-relaxed mb-3">{exp.description}</p>
                <div className="flex flex-wrap gap-2">
                  {exp.technologies.map((tech) => (
                    <span key={tech} className="px-2 py-1 rounded text-xs bg-white/5 text-gray-400">
                      {tech}
                    </span>
                  ))}
                </div>
              </motion.div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
