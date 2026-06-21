const pool = require('../config/database');

exports.getAll = async (req, res) => {
  try {
    const { category } = req.query;
    let query = "SELECT * FROM projects WHERE status = 'published'";
    const params = [];
    if (category) { query += ' AND category = ?'; params.push(category); }
    query += ' ORDER BY sort_order ASC, created_at DESC';
    const [projects] = await pool.query(query, params);
    res.json(projects);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};

exports.getById = async (req, res) => {
  try {
    const [projects] = await pool.query('SELECT * FROM projects WHERE id = ? OR slug = ?', [req.params.id, req.params.id]);
    if (projects.length === 0) return res.status(404).json({ error: 'Project not found' });
    res.json(projects[0]);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};

exports.create = async (req, res) => {
  try {
    const { title, description, content, category, technologies, live_url, github_url, problem_solved, results, sort_order, status } = req.body;
    const slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    const [result] = await pool.query(
      `INSERT INTO projects (title, slug, description, content, category, technologies, live_url, github_url, problem_solved, results, sort_order, status)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      [title, slug, description, content || '', category, JSON.stringify(technologies || []), live_url || '', github_url || '', problem_solved || '', results || '', sort_order || 0, status || 'published']
    );
    res.status(201).json({ id: result.insertId, message: 'Project created' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};

exports.update = async (req, res) => {
  try {
    const { title, description, content, category, technologies, live_url, github_url, problem_solved, results, sort_order, status } = req.body;
    const slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    await pool.query(
      `UPDATE projects SET title=?, slug=?, description=?, content=?, category=?, technologies=?, live_url=?, github_url=?, problem_solved=?, results=?, sort_order=?, status=? WHERE id=?`,
      [title, slug, description, content || '', category, JSON.stringify(technologies || []), live_url || '', github_url || '', problem_solved || '', results || '', sort_order || 0, status || 'published', req.params.id]
    );
    res.json({ message: 'Project updated' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};

exports.remove = async (req, res) => {
  try {
    await pool.query('DELETE FROM projects WHERE id = ?', [req.params.id]);
    res.json({ message: 'Project deleted' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};
