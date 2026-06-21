const pool = require('../config/database');

class Project {
  static async findAll({ category, status = 'published' } = {}) {
    let query = 'SELECT * FROM projects WHERE 1=1';
    const params = [];
    if (status) { query += ' AND status = ?'; params.push(status); }
    if (category) { query += ' AND category = ?'; params.push(category); }
    query += ' ORDER BY sort_order ASC, created_at DESC';
    const [rows] = await pool.query(query, params);
    return rows;
  }

  static async findById(id) {
    const [rows] = await pool.query('SELECT * FROM projects WHERE id = ? OR slug = ?', [id, id]);
    return rows[0] || null;
  }

  static async create(data) {
    const slug = data.title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    const [result] = await pool.query(
      `INSERT INTO projects (title, slug, description, content, category, technologies, live_url, github_url, problem_solved, results, sort_order, status)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      [data.title, slug, data.description, data.content || '', data.category, JSON.stringify(data.technologies || []), data.live_url || '', data.github_url || '', data.problem_solved || '', data.results || '', data.sort_order || 0, data.status || 'published']
    );
    return result.insertId;
  }

  static async update(id, data) {
    const slug = data.title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    await pool.query(
      `UPDATE projects SET title=?, slug=?, description=?, content=?, category=?, technologies=?, live_url=?, github_url=?, problem_solved=?, results=?, sort_order=?, status=? WHERE id=?`,
      [data.title, slug, data.description, data.content || '', data.category, JSON.stringify(data.technologies || []), data.live_url || '', data.github_url || '', data.problem_solved || '', data.results || '', data.sort_order || 0, data.status || 'published', id]
    );
  }

  static async delete(id) {
    await pool.query('DELETE FROM projects WHERE id = ?', [id]);
  }
}

module.exports = Project;
