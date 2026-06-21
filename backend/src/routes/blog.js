const express = require('express');
const router = express.Router();
const { body, validationResult } = require('express-validator');
const pool = require('../config/database');
const auth = require('../middleware/auth');

router.get('/', async (req, res) => {
  try {
    const { category, search } = req.query;
    let query = `SELECT id, title, slug, excerpt, cover_image, category, tags, reading_time, author, created_at FROM blog_posts WHERE status = 'published'`;
    const params = [];
    if (category) { query += ' AND category = ?'; params.push(category); }
    if (search) { query += ' AND (title LIKE ? OR excerpt LIKE ?)'; params.push(`%${search}%`, `%${search}%`); }
    query += ' ORDER BY created_at DESC';
    const [posts] = await pool.query(query, params);
    res.json(posts);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

router.get('/:id', async (req, res) => {
  try {
    const [posts] = await pool.query('SELECT * FROM blog_posts WHERE (id = ? OR slug = ?) AND status = ?', [req.params.id, req.params.id, 'published']);
    if (posts.length === 0) return res.status(404).json({ error: 'Post not found' });
    res.json(posts[0]);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

const blogValidation = [
  body('title').trim().notEmpty().withMessage('Title is required'),
  body('content').trim().notEmpty().withMessage('Content is required'),
  body('excerpt').optional().trim(),
  body('category').optional().trim(),
  body('tags').optional().isArray(),
];

router.post('/', auth, blogValidation, async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) return res.status(400).json({ errors: errors.array() });
  try {
    const { title, excerpt, content, cover_image, category, tags } = req.body;
    const slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    const readingTime = Math.max(1, Math.ceil((content.split(/\s+/).length || 1) / 200));
    const [result] = await pool.query(
      `INSERT INTO blog_posts (title, slug, excerpt, content, cover_image, category, tags, reading_time)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?)`,
      [title, slug, excerpt || '', content, cover_image || '', category || 'General', JSON.stringify(tags || []), readingTime]
    );
    res.status(201).json({ id: result.insertId, message: 'Post created' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

router.put('/:id', auth, blogValidation, async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) return res.status(400).json({ errors: errors.array() });
  try {
    const { title, excerpt, content, cover_image, category, tags } = req.body;
    const slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    const readingTime = Math.max(1, Math.ceil((content.split(/\s+/).length || 1) / 200));
    await pool.query(
      `UPDATE blog_posts SET title=?, slug=?, excerpt=?, content=?, cover_image=?, category=?, tags=?, reading_time=? WHERE id=?`,
      [title, slug, excerpt || '', content, cover_image || '', category || 'General', JSON.stringify(tags || []), readingTime, req.params.id]
    );
    res.json({ message: 'Post updated' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

router.delete('/:id', auth, async (req, res) => {
  try {
    await pool.query('DELETE FROM blog_posts WHERE id = ?', [req.params.id]);
    res.json({ message: 'Post deleted' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
