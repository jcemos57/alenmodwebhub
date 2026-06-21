'use client';
import { motion } from 'framer-motion';
import { FaCalendar, FaClock, FaArrowRight, FaSearch, FaCode, FaLaptop, FaServer, FaMobile } from 'react-icons/fa';

const blogPosts = [
  {
    title: 'Building Scalable APIs with Node.js and Express',
    excerpt: 'Learn how to structure and build production-ready APIs that can handle millions of requests.',
    category: 'Backend',
    date: '2024-12-15',
    readTime: '8 min read',
    icon: FaServer,
    tags: ['Node.js', 'API', 'Backend'],
  },
  {
    title: 'The Future of Full Stack Development in 2025',
    excerpt: 'Exploring the trends and technologies shaping the future of web development.',
    category: 'Development',
    date: '2024-11-20',
    readTime: '6 min read',
    icon: FaLaptop,
    tags: ['Trends', 'Full Stack', 'Future'],
  },
  {
    title: 'Building Premium UI with Tailwind CSS & Framer Motion',
    excerpt: 'A comprehensive guide to creating stunning user interfaces with modern tools.',
    category: 'Frontend',
    date: '2024-10-10',
    readTime: '10 min read',
    icon: FaCode,
    tags: ['Tailwind CSS', 'Framer Motion', 'UI/UX'],
  },
  {
    title: 'Mobile-First Development Best Practices',
    excerpt: 'Why mobile-first matters and how to implement it effectively in your projects.',
    category: 'Mobile',
    date: '2024-09-05',
    readTime: '5 min read',
    icon: FaMobile,
    tags: ['Mobile', 'Responsive', 'Best Practices'],
  },
];

export default function Blog() {
  return (
    <section id="blog" className="section-padding relative">
      <div className="absolute inset-0 grid-bg opacity-20" />

      <div className="section-container relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <div className="section-badge mx-auto">Blog</div>
          <h2 className="section-title text-center">
            Latest{' '}
            <span className="gradient-text">Articles</span>
          </h2>
          <p className="section-subtitle mx-auto text-center">
            Insights, tutorials, and thoughts on web development and technology
          </p>
        </motion.div>

        <div className="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
          {blogPosts.map((post, i) => (
            <motion.article
              key={post.title}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className="card group cursor-pointer"
              whileHover={{ y: -8 }}
            >
              <div className="flex items-center gap-3 mb-4">
                <div className="w-10 h-10 rounded-lg glass flex items-center justify-center text-primary-400">
                  <post.icon size={18} />
                </div>
                <span className="px-3 py-1 rounded-full text-xs bg-primary-500/10 text-primary-300 border border-primary-500/20">
                  {post.category}
                </span>
              </div>
              <h3 className="text-lg font-display font-semibold mb-2 group-hover:gradient-text transition-all">
                {post.title}
              </h3>
              <p className="text-gray-400 text-sm leading-relaxed mb-4">{post.excerpt}</p>
              <div className="flex items-center justify-between text-xs text-gray-500">
                <div className="flex items-center gap-3">
                  <span className="flex items-center gap-1"><FaCalendar size={12} /> {post.date}</span>
                  <span className="flex items-center gap-1"><FaClock size={12} /> {post.readTime}</span>
                </div>
                <span className="text-primary-400 group-hover:translate-x-1 transition-transform flex items-center gap-1">
                  Read More <FaArrowRight size={10} />
                </span>
              </div>
            </motion.article>
          ))}
        </div>
      </div>
    </section>
  );
}
