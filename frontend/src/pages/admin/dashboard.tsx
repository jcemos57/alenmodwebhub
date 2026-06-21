'use client';
import { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { FaUsers, FaProjectDiagram, FaBlog, FaStar, FaEnvelope, FaEye, FaSignOutAlt, FaBars, FaTimes, FaChartBar, FaCog, FaTrash, FaCheck, FaPlus } from 'react-icons/fa';
import { useRouter } from 'next/router';

type Tab = 'dashboard' | 'projects' | 'blog' | 'testimonials' | 'messages' | 'services' | 'settings';

const API_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:5000/api';

export default function AdminDashboard() {
  const router = useRouter();
  const [activeTab, setActiveTab] = useState<Tab>('dashboard');
  const [sidebarOpen, setSidebarOpen] = useState(true);
  const [user, setUser] = useState<any>(null);
  const [stats, setStats] = useState({ projects: 0, blog: 0, messages: 0, testimonials: 0 });
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem('token');
    const userData = localStorage.getItem('user');
    if (!token || !userData) {
      router.push('/admin');
      return;
    }
    setUser(JSON.parse(userData));
    fetchStats();
  }, []);

  const fetchStats = async () => {
    try {
      const token = localStorage.getItem('token');
      const [projects, blog, messages, testimonials] = await Promise.all([
        fetch(`${API_URL}/projects`, { headers: { Authorization: `Bearer ${token}` } }).then(r => r.json()),
        fetch(`${API_URL}/blog`, { headers: { Authorization: `Bearer ${token}` } }).then(r => r.json()),
        fetch(`${API_URL}/contact`, { headers: { Authorization: `Bearer ${token}` } }).then(r => r.json()),
        fetch(`${API_URL}/testimonials`, { headers: { Authorization: `Bearer ${token}` } }).then(r => r.json()),
      ]);
      setStats({
        projects: Array.isArray(projects) ? projects.length : 0,
        blog: Array.isArray(blog) ? blog.length : 0,
        messages: Array.isArray(messages) ? messages.length : 0,
        testimonials: Array.isArray(testimonials) ? testimonials.length : 0,
      });
    } catch (err) {
      console.error('Error fetching stats:', err);
    }
    setLoading(false);
  };

  const handleLogout = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    router.push('/admin');
  };

  const sidebarLinks: { id: Tab; label: string; icon: any }[] = [
    { id: 'dashboard', label: 'Dashboard', icon: FaChartBar },
    { id: 'projects', label: 'Projects', icon: FaProjectDiagram },
    { id: 'blog', label: 'Blog Posts', icon: FaBlog },
    { id: 'testimonials', label: 'Testimonials', icon: FaStar },
    { id: 'messages', label: 'Messages', icon: FaEnvelope },
    { id: 'services', label: 'Services', icon: FaCog },
    { id: 'settings', label: 'Settings', icon: FaCog },
  ];

  if (loading) {
    return (
      <div className="min-h-screen bg-[#0a0a0f] flex items-center justify-center">
        <div className="loading-spinner" />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-[#0a0a0f] flex">
      <aside className={`fixed lg:static inset-y-0 left-0 z-50 w-64 bg-[#0a0a0f] border-r border-white/5 transform ${sidebarOpen ? 'translate-x-0' : '-translate-x-full'} lg:translate-x-0 transition-transform duration-300`}>
        <div className="p-6">
          <div className="flex items-center gap-3 mb-8">
            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
              <span className="text-white font-bold">A</span>
            </div>
            <div>
              <p className="font-display font-bold text-sm">AleciDeveloper</p>
              <p className="text-xs text-gray-500">Admin Panel</p>
            </div>
          </div>

          <nav className="space-y-1">
            {sidebarLinks.map((link) => (
              <button
                key={link.id}
                onClick={() => setActiveTab(link.id)}
                className={`w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all ${
                  activeTab === link.id
                    ? 'bg-primary-500/10 text-primary-400 border border-primary-500/20'
                    : 'text-gray-400 hover:text-white hover:bg-white/5'
                }`}
              >
                <link.icon size={16} />
                {link.label}
              </button>
            ))}
          </nav>
        </div>

        <div className="absolute bottom-0 left-0 right-0 p-6 border-t border-white/5">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-3">
              <div className="w-8 h-8 rounded-full bg-primary-500/20 flex items-center justify-center">
                <span className="text-xs font-bold text-primary-400">{user?.name?.charAt(0) || 'A'}</span>
              </div>
              <div>
                <p className="text-xs font-medium">{user?.name || 'Admin'}</p>
                <p className="text-xs text-gray-500">Administrator</p>
              </div>
            </div>
            <button onClick={handleLogout} className="p-2 rounded-lg hover:bg-white/5 text-gray-400 hover:text-red-400 transition-all">
              <FaSignOutAlt size={16} />
            </button>
          </div>
        </div>
      </aside>

      <div className="flex-1 min-h-screen">
        <header className="sticky top-0 z-40 bg-[#0a0a0f]/90 backdrop-blur-xl border-b border-white/5">
          <div className="flex items-center justify-between px-6 h-16">
            <button onClick={() => setSidebarOpen(!sidebarOpen)} className="lg:hidden p-2 rounded-lg hover:bg-white/5 text-gray-400">
              {sidebarOpen ? <FaTimes size={20} /> : <FaBars size={20} />}
            </button>
            <h2 className="text-lg font-display font-semibold capitalize">{activeTab}</h2>
            <div className="flex items-center gap-3">
              <span className="text-sm text-gray-400">{user?.email}</span>
            </div>
          </div>
        </header>

        <main className="p-6">
          {activeTab === 'dashboard' && <DashboardView stats={stats} />}
          {activeTab === 'projects' && <ProjectsManager />}
          {activeTab === 'messages' && <MessagesManager />}
          {activeTab === 'testimonials' && <TestimonialsManager />}
          {activeTab === 'blog' && <BlogManager />}
          {activeTab === 'services' && <ServicesManager />}
          {activeTab === 'settings' && <SettingsManager />}
        </main>
      </div>
    </div>
  );
}

function DashboardView({ stats }: { stats: any }) {
  const statCards = [
    { label: 'Total Projects', value: stats.projects, icon: FaProjectDiagram, color: 'from-blue-500 to-cyan-500' },
    { label: 'Blog Posts', value: stats.blog, icon: FaBlog, color: 'from-green-500 to-emerald-500' },
    { label: 'Messages', value: stats.messages, icon: FaEnvelope, color: 'from-yellow-500 to-orange-500' },
    { label: 'Testimonials', value: stats.testimonials, icon: FaStar, color: 'from-purple-500 to-pink-500' },
  ];

  return (
    <div className="space-y-6">
      <h3 className="text-2xl font-display font-bold">Welcome to Admin Dashboard</h3>
      <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {statCards.map((card) => (
          <motion.div
            key={card.label}
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="card p-6"
          >
            <div className="flex items-center justify-between mb-4">
              <div className={`w-12 h-12 rounded-xl bg-gradient-to-r ${card.color} flex items-center justify-center`}>
                <card.icon className="text-white" size={20} />
              </div>
            </div>
            <p className="text-3xl font-display font-bold">{card.value}</p>
            <p className="text-sm text-gray-400">{card.label}</p>
          </motion.div>
        ))}
      </div>
    </div>
  );
}

function ProjectsManager() {
  const [projects, setProjects] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchProjects();
  }, []);

  const fetchProjects = async () => {
    try {
      const token = localStorage.getItem('token');
      const data = await fetch(`${API_URL}/projects`, { headers: { Authorization: `Bearer ${token}` } }).then(r => r.json());
      setProjects(Array.isArray(data) ? data : []);
    } catch (err) {
      console.error(err);
    }
    setLoading(false);
  };

  const handleDelete = async (id: number) => {
    if (!confirm('Delete this project?')) return;
    try {
      const token = localStorage.getItem('token');
      await fetch(`${API_URL}/projects/${id}`, { method: 'DELETE', headers: { Authorization: `Bearer ${token}` } });
      fetchProjects();
    } catch (err) {
      console.error(err);
    }
  };

  if (loading) return <div className="loading-spinner" />;

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <h3 className="text-xl font-display font-semibold">Manage Projects</h3>
        <button className="btn-primary text-sm py-2 px-4"><FaPlus className="mr-1" /> Add Project</button>
      </div>
      <div className="space-y-3">
        {projects.map((project: any) => (
          <div key={project.id} className="card p-4 flex items-center justify-between">
            <div>
              <h4 className="font-medium">{project.title}</h4>
              <p className="text-sm text-gray-400">{project.category} · {project.year}</p>
            </div>
            <div className="flex gap-2">
              <button onClick={() => handleDelete(project.id)} className="p-2 rounded-lg hover:bg-red-500/10 text-red-400 transition-all">
                <FaTrash size={14} />
              </button>
            </div>
          </div>
        ))}
        {projects.length === 0 && <p className="text-gray-500 text-center py-8">No projects yet</p>}
      </div>
    </div>
  );
}

function MessagesManager() {
  const [messages, setMessages] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchMessages();
  }, []);

  const fetchMessages = async () => {
    try {
      const token = localStorage.getItem('token');
      const data = await fetch(`${API_URL}/contact`, { headers: { Authorization: `Bearer ${token}` } }).then(r => r.json());
      setMessages(Array.isArray(data) ? data : []);
    } catch (err) {
      console.error(err);
    }
    setLoading(false);
  };

  const handleDelete = async (id: number) => {
    if (!confirm('Delete this message?')) return;
    try {
      const token = localStorage.getItem('token');
      await fetch(`${API_URL}/contact/${id}`, { method: 'DELETE', headers: { Authorization: `Bearer ${token}` } });
      fetchMessages();
    } catch (err) {
      console.error(err);
    }
  };

  const markAsRead = async (id: number) => {
    try {
      const token = localStorage.getItem('token');
      await fetch(`${API_URL}/contact/${id}/read`, { method: 'PUT', headers: { Authorization: `Bearer ${token}` } });
      fetchMessages();
    } catch (err) {
      console.error(err);
    }
  };

  if (loading) return <div className="loading-spinner" />;

  return (
    <div className="space-y-4">
      <h3 className="text-xl font-display font-semibold">Contact Messages</h3>
      <div className="space-y-3">
        {messages.map((msg: any) => (
          <div key={msg.id} className={`card p-4 ${!msg.is_read ? 'border-primary-500/30' : ''}`}>
            <div className="flex items-start justify-between">
              <div>
                <h4 className="font-medium">{msg.name}</h4>
                <p className="text-sm text-gray-400">{msg.email} · {msg.subject}</p>
              </div>
              <div className="flex gap-2">
                {!msg.is_read && (
                  <button onClick={() => markAsRead(msg.id)} className="p-2 rounded-lg hover:bg-green-500/10 text-green-400 transition-all" title="Mark as read">
                    <FaCheck size={14} />
                  </button>
                )}
                <button onClick={() => handleDelete(msg.id)} className="p-2 rounded-lg hover:bg-red-500/10 text-red-400 transition-all" title="Delete">
                  <FaTrash size={14} />
                </button>
              </div>
            </div>
            <p className="text-sm text-gray-300 mt-3">{msg.message}</p>
            <p className="text-xs text-gray-500 mt-2">{new Date(msg.created_at).toLocaleString()}</p>
          </div>
        ))}
        {messages.length === 0 && <p className="text-gray-500 text-center py-8">No messages yet</p>}
      </div>
    </div>
  );
}

function TestimonialsManager() {
  const [testimonials, setTestimonials] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchTestimonials();
  }, []);

  const fetchTestimonials = async () => {
    try {
      const token = localStorage.getItem('token');
      const data = await fetch(`${API_URL}/testimonials`, { headers: { Authorization: `Bearer ${token}` } }).then(r => r.json());
      setTestimonials(Array.isArray(data) ? data : []);
    } catch (err) {
      console.error(err);
    }
    setLoading(false);
  };

  const handleDelete = async (id: number) => {
    if (!confirm('Delete this testimonial?')) return;
    try {
      const token = localStorage.getItem('token');
      await fetch(`${API_URL}/testimonials/${id}`, { method: 'DELETE', headers: { Authorization: `Bearer ${token}` } });
      fetchTestimonials();
    } catch (err) {
      console.error(err);
    }
  };

  if (loading) return <div className="loading-spinner" />;

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <h3 className="text-xl font-display font-semibold">Manage Testimonials</h3>
        <button className="btn-primary text-sm py-2 px-4"><FaPlus className="mr-1" /> Add Testimonial</button>
      </div>
      <div className="space-y-3">
        {testimonials.map((t: any) => (
          <div key={t.id} className="card p-4">
            <div className="flex items-start justify-between">
              <div>
                <h4 className="font-medium">{t.name}</h4>
                <p className="text-sm text-gray-400">{t.role} at {t.company}</p>
              </div>
              <button onClick={() => handleDelete(t.id)} className="p-2 rounded-lg hover:bg-red-500/10 text-red-400 transition-all">
                <FaTrash size={14} />
              </button>
            </div>
            <p className="text-sm text-gray-300 mt-2 line-clamp-2">{t.content}</p>
            <div className="flex gap-1 mt-2">
              {[...Array(5)].map((_, i) => (
                <FaStar key={i} className={i < t.rating ? 'text-yellow-500' : 'text-gray-600'} size={12} />
              ))}
            </div>
          </div>
        ))}
        {testimonials.length === 0 && <p className="text-gray-500 text-center py-8">No testimonials yet</p>}
      </div>
    </div>
  );
}

function BlogManager() {
  const [posts, setPosts] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchPosts();
  }, []);

  const fetchPosts = async () => {
    try {
      const token = localStorage.getItem('token');
      const data = await fetch(`${API_URL}/blog`, { headers: { Authorization: `Bearer ${token}` } }).then(r => r.json());
      setPosts(Array.isArray(data) ? data : []);
    } catch (err) {
      console.error(err);
    }
    setLoading(false);
  };

  const handleDelete = async (id: number) => {
    if (!confirm('Delete this post?')) return;
    try {
      const token = localStorage.getItem('token');
      await fetch(`${API_URL}/blog/${id}`, { method: 'DELETE', headers: { Authorization: `Bearer ${token}` } });
      fetchPosts();
    } catch (err) {
      console.error(err);
    }
  };

  if (loading) return <div className="loading-spinner" />;

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <h3 className="text-xl font-display font-semibold">Manage Blog Posts</h3>
        <button className="btn-primary text-sm py-2 px-4"><FaPlus className="mr-1" /> New Post</button>
      </div>
      <div className="space-y-3">
        {posts.map((post: any) => (
          <div key={post.id} className="card p-4 flex items-center justify-between">
            <div>
              <h4 className="font-medium">{post.title}</h4>
              <p className="text-sm text-gray-400">{post.category} · {new Date(post.published_at).toLocaleDateString()}</p>
            </div>
            <div className="flex gap-2">
              <button onClick={() => handleDelete(post.id)} className="p-2 rounded-lg hover:bg-red-500/10 text-red-400 transition-all">
                <FaTrash size={14} />
              </button>
            </div>
          </div>
        ))}
        {posts.length === 0 && <p className="text-gray-500 text-center py-8">No blog posts yet</p>}
      </div>
    </div>
  );
}

function ServicesManager() {
  const [services, setServices] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchServices();
  }, []);

  const fetchServices = async () => {
    try {
      const token = localStorage.getItem('token');
      const data = await fetch(`${API_URL}/services`, { headers: { Authorization: `Bearer ${token}` } }).then(r => r.json());
      setServices(Array.isArray(data) ? data : []);
    } catch (err) {
      console.error(err);
    }
    setLoading(false);
  };

  if (loading) return <div className="loading-spinner" />;

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <h3 className="text-xl font-display font-semibold">Manage Services</h3>
        <button className="btn-primary text-sm py-2 px-4"><FaPlus className="mr-1" /> Add Service</button>
      </div>
      <div className="space-y-3">
        {services.map((service: any) => (
          <div key={service.id} className="card p-4">
            <div className="flex items-center gap-3">
              <span className="text-2xl">{service.icon}</span>
              <div>
                <h4 className="font-medium">{service.title}</h4>
                <p className="text-sm text-gray-400">{service.price}</p>
              </div>
            </div>
          </div>
        ))}
        {services.length === 0 && <p className="text-gray-500 text-center py-8">No services yet</p>}
      </div>
    </div>
  );
}

function SettingsManager() {
  const [settings, setSettings] = useState({
    hero_title: '',
    hero_subtitle: '',
    availability: '',
    email: '',
  });
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    fetchSettings();
  }, []);

  const fetchSettings = async () => {
    try {
      const data = await fetch(`${API_URL}/settings`).then(r => r.json());
      if (data && data.hero_title) setSettings(data);
    } catch (err) {
      console.error(err);
    }
  };

  const handleSave = async () => {
    setSaving(true);
    try {
      const token = localStorage.getItem('token');
      await fetch(`${API_URL}/settings`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${token}` },
        body: JSON.stringify(settings),
      });
      alert('Settings saved!');
    } catch (err) {
      console.error(err);
    }
    setSaving(false);
  };

  return (
    <div className="space-y-6 max-w-2xl">
      <h3 className="text-xl font-display font-semibold">Site Settings</h3>
      <div className="space-y-4">
        <div>
          <label className="block text-sm text-gray-400 mb-2">Hero Title</label>
          <input
            value={settings.hero_title}
            onChange={e => setSettings(prev => ({ ...prev, hero_title: e.target.value }))}
            className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:border-primary-500/50 focus:outline-none transition-all"
          />
        </div>
        <div>
          <label className="block text-sm text-gray-400 mb-2">Hero Subtitle</label>
          <textarea
            value={settings.hero_subtitle}
            onChange={e => setSettings(prev => ({ ...prev, hero_subtitle: e.target.value }))}
            rows={3}
            className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:border-primary-500/50 focus:outline-none transition-all resize-none"
          />
        </div>
        <div>
          <label className="block text-sm text-gray-400 mb-2">Availability Status</label>
          <input
            value={settings.availability}
            onChange={e => setSettings(prev => ({ ...prev, availability: e.target.value }))}
            className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:border-primary-500/50 focus:outline-none transition-all"
          />
        </div>
        <div>
          <label className="block text-sm text-gray-400 mb-2">Email</label>
          <input
            value={settings.email}
            onChange={e => setSettings(prev => ({ ...prev, email: e.target.value }))}
            className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:border-primary-500/50 focus:outline-none transition-all"
          />
        </div>
        <motion.button
          onClick={handleSave}
          disabled={saving}
          className="btn-primary disabled:opacity-50"
          whileHover={{ scale: saving ? 1 : 1.02 }}
        >
          {saving ? 'Saving...' : 'Save Settings'}
        </motion.button>
      </div>
    </div>
  );
}
