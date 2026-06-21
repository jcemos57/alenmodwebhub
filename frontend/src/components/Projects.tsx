'use client';
import { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { projects } from '@/data/content';
import { FaExternalLinkAlt, FaGithub, FaArrowRight, FaTimes } from 'react-icons/fa';

const categories = ['All', 'Management System', 'E-commerce', 'Dashboard', 'Web Application', 'Custom Application'];

export default function Projects() {
  const [activeFilter, setActiveFilter] = useState('All');
  const [selectedProject, setSelectedProject] = useState<string | null>(null);

  const filtered = activeFilter === 'All' 
    ? projects 
    : projects.filter(p => p.category === activeFilter);

  return (
    <section id="projects" className="section-padding relative">
      <div className="absolute inset-0 grid-bg opacity-20" />
      <div className="section-container relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <div className="section-badge mx-auto">Portfolio</div>
          <h2 className="section-title text-center">
            Featured{' '}
            <span className="gradient-text">Projects</span>
          </h2>
          <p className="section-subtitle mx-auto text-center">
            Real solutions that delivered measurable results for businesses
          </p>
        </motion.div>

        <div className="flex flex-wrap justify-center gap-2 mb-12">
          {categories.map((cat) => (
            <button
              key={cat}
              onClick={() => setActiveFilter(cat)}
              className={`px-5 py-2 rounded-full text-sm font-medium transition-all ${
                activeFilter === cat
                  ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/25'
                  : 'glass text-gray-400 hover:text-white hover:border-primary-500/30'
              }`}
            >
              {cat}
            </button>
          ))}
        </div>

        <motion.div layout className="grid md:grid-cols-2 gap-6">
          <AnimatePresence mode="popLayout">
            {filtered.map((project, i) => (
              <motion.div
                key={project.id}
                layout
                initial={{ opacity: 0, scale: 0.9 }}
                animate={{ opacity: 1, scale: 1 }}
                exit={{ opacity: 0, scale: 0.9 }}
                transition={{ duration: 0.3 }}
                className="card group overflow-hidden"
                whileHover={{ y: -8 }}
              >
                <div className="relative h-48 rounded-xl overflow-hidden mb-5 bg-gradient-to-br from-primary-500/10 to-accent-500/10">
                  <div className="absolute inset-0 flex items-center justify-center">
                    <span className="text-4xl font-display font-bold gradient-text">
                      {project.title.split(' ')[0]}
                    </span>
                  </div>
                  <div className="absolute inset-0 bg-gradient-to-t from-[#0a0a0f] via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                    <div className="flex gap-2">
                      {project.liveUrl && (
                        <a href={project.liveUrl} target="_blank" rel="noopener noreferrer" className="btn-primary text-xs py-2 px-4">
                          <FaExternalLinkAlt size={12} /> Live Preview
                        </a>
                      )}
                      {project.githubUrl && (
                        <a href={project.githubUrl} target="_blank" rel="noopener noreferrer" className="btn-secondary text-xs py-2 px-4">
                          <FaGithub size={12} /> GitHub
                        </a>
                      )}
                    </div>
                  </div>
                </div>

                <h3 className="text-xl font-display font-semibold mb-2 group-hover:gradient-text transition-all">
                  {project.title}
                </h3>
                <p className="text-gray-400 text-sm leading-relaxed mb-4">{project.description}</p>

                <div className="flex flex-wrap gap-2 mb-4">
                  {project.technologies.slice(0, 4).map((tech) => (
                    <span key={tech} className="px-2.5 py-1 rounded-full text-xs bg-primary-500/10 text-primary-300 border border-primary-500/20">
                      {tech}
                    </span>
                  ))}
                  {project.technologies.length > 4 && (
                    <span className="px-2.5 py-1 rounded-full text-xs bg-white/5 text-gray-400">
                      +{project.technologies.length - 4}
                    </span>
                  )}
                </div>

                <div className="flex items-center justify-between pt-4 border-t border-white/5">
                  <span className="text-xs text-gray-500">{project.year}</span>
                  <button
                    onClick={() => setSelectedProject(project.id === selectedProject ? null : project.id)}
                    className="text-sm text-primary-400 hover:text-primary-300 transition-colors flex items-center gap-1"
                  >
                    Case Study <FaArrowRight size={12} />
                  </button>
                </div>

                <AnimatePresence>
                  {selectedProject === project.id && (
                    <motion.div
                      initial={{ opacity: 0, height: 0 }}
                      animate={{ opacity: 1, height: 'auto' }}
                      exit={{ opacity: 0, height: 0 }}
                      className="mt-4 pt-4 border-t border-white/5 space-y-3"
                    >
                      <div>
                        <h4 className="text-sm font-semibold text-primary-400 mb-1">The Problem</h4>
                        <p className="text-sm text-gray-400">{project.problem}</p>
                      </div>
                      <div>
                        <h4 className="text-sm font-semibold text-primary-400 mb-1">The Solution</h4>
                        <p className="text-sm text-gray-400">{project.solution}</p>
                      </div>
                      <div>
                        <h4 className="text-sm font-semibold text-primary-400 mb-1">Results</h4>
                        <p className="text-sm text-gray-400">{project.results}</p>
                      </div>
                      {project.stats && (
                        <div className="grid grid-cols-3 gap-2 pt-2">
                          {project.stats.map((stat) => (
                            <div key={stat.label} className="text-center p-2 rounded-lg bg-white/5">
                              <div className="text-sm font-bold gradient-text">{stat.value}</div>
                              <div className="text-xs text-gray-500">{stat.label}</div>
                            </div>
                          ))}
                        </div>
                      )}
                    </motion.div>
                  )}
                </AnimatePresence>
              </motion.div>
            ))}
          </AnimatePresence>
        </motion.div>
      </div>
    </section>
  );
}
