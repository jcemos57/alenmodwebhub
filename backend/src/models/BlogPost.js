const pool = require('../config/database');

class BlogPost {
  static async findAll({ category, search, status = 'published' } = {}) {
    let query = "SELECT id, title, slug, excerpt, cover_image, category, tags, reading_time, author, created_at FROM blog_posts WHERE 1=1";
    const params = [];
    if (status) { query += ' AND status = ?'; params.push(status); }
    if (category) { query += ' AND category = ?'; params.push(category); }
    if (search) { query += ' AND (title LIKE ? OR excerpt LIKE ?)'; params.push(`%${search}%`, `%${search}%`); }
    query += ' ORDER BY created_at DESC';
    const [rows] = await pool.query(query, params);
    return rows;
  }

  static async findById(id) {
    const [rows] = await pool.query('SELECT * FROM blog_posts WHERE id = ? OR slug = ?', [id, id]);
    return rows[0] || null;
  }

  static async create(data) {
    const slug = data.title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    const readingTime = Math.max(1, Math.ceil((data.content.split(/\s+/).length || 1) / 200));
    const [result] = await pool.query(
      `INSERT INTO blog_posts (title, slug, excerpt, content, cover_image, category, tags, reading_time)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?)`,
      [data.title, slug, data.excerpt || '', data.content, data.cover_image || '', data.category || 'General', JSON.stringify(data.tags || []), readingTime]
    );
    return result.insertId;
  }

  static async update(id, data) {
    const slug = data.title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    const readingTime = Math.max(1, Math.ceil((data.content.split(/\s+/).length || 1) / 200));
    await pool.query(
      `UPDATE blog_posts SET title=?, slug=?, excerpt=?, content=?, cover_image=?, category=?, tags=?, reading_time=? WHERE id=?`,
      [data.title, slug, data.excerpt || '', data.content, data.cover_image || '', data.category || 'General', JSON.stringify(data.tags || []), readingTime, id]
    );
  }

  static async delete(id) {
    await pool.query('DELETE FROM blog_posts WHERE id = ?', [id]);
  }
}

module.exports = BlogPost;
