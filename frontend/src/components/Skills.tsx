'use client';
import { motion } from 'framer-motion';
import { skills } from '@/data/content';

const categories = [
  { key: 'frontend', label: 'Frontend', color: 'from-blue-500 to-cyan-500' },
  { key: 'backend', label: 'Backend', color: 'from-green-500 to-emerald-500' },
  { key: 'database', label: 'Database', color: 'from-yellow-500 to-orange-500' },
  { key: 'tools', label: 'Tools & More', color: 'from-purple-500 to-pink-500' },
];

export default function Skills() {
  return (
    <section id="skills" className="section-padding relative">
      <div className="absolute inset-0">
        <div className="absolute top-0 right-0 w-96 h-96 bg-primary-500/5 rounded-full blur-[100px]" />
      </div>

      <div className="section-container relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <div className="section-badge mx-auto">My Skills</div>
          <h2 className="section-title text-center">
            Technologies I{' '}
            <span className="gradient-text">Master</span>
          </h2>
          <p className="section-subtitle mx-auto text-center">
            Years of hands-on experience with modern technologies across the full stack
          </p>
        </motion.div>

        <div className="space-y-12">
          {categories.map((category, catIdx) => {
            const categorySkills = skills.filter(s => s.category === category.key);
            return (
              <motion.div
                key={category.key}
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: catIdx * 0.1 }}
              >
                <h3 className="text-lg font-display font-semibold mb-6 flex items-center gap-3">
                  <span className={`w-3 h-3 rounded-full bg-gradient-to-r ${category.color}`} />
                  {category.label}
                </h3>
                <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                  {categorySkills.map((skill, i) => (
                    <motion.div
                      key={skill.name}
                      initial={{ opacity: 0, x: -20 }}
                      whileInView={{ opacity: 1, x: 0 }}
                      viewport={{ once: true }}
                      transition={{ delay: (catIdx * 0.1) + (i * 0.05) }}
                      className="card p-5 group"
                      whileHover={{ y: -4 }}
                    >
                      <div className="flex items-center gap-3 mb-3">
                        <span className="text-2xl">{skill.icon}</span>
                        <span className="font-display font-medium">{skill.name}</span>
                      </div>
                      <div className="relative h-2 rounded-full bg-white/5 overflow-hidden">
                        <motion.div
                          initial={{ width: 0 }}
                          whileInView={{ width: `${skill.level}%` }}
                          viewport={{ once: true }}
                          transition={{ duration: 1, delay: 0.3, ease: 'easeOut' }}
                          className={`h-full rounded-full bg-gradient-to-r ${category.color}`}
                        />
                      </div>
                      <span className="text-xs text-gray-500 mt-1 block text-right">{skill.level}%</span>
                    </motion.div>
                  ))}
                </div>
              </motion.div>
            );
          })}
        </div>
      </div>
    </section>
  );
}
