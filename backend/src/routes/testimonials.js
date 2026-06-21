const express = require('express');
const router = express.Router();
const { body, validationResult } = require('express-validator');
const pool = require('../config/database');
const auth = require('../middleware/auth');

router.get('/', async (req, res) => {
  try {
    const [testimonials] = await pool.query('SELECT * FROM testimonials ORDER BY created_at DESC');
    res.json(testimonials);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

const testimonialValidation = [
  body('name').trim().notEmpty().withMessage('Name is required'),
  body('content').trim().notEmpty().withMessage('Content is required'),
  body('role').optional().trim(),
  body('company').optional().trim(),
  body('rating').optional().isInt({ min: 1, max: 5 }),
];

router.post('/', auth, testimonialValidation, async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) return res.status(400).json({ errors: errors.array() });
  try {
    const { name, role, company, avatar, content, rating } = req.body;
    const [result] = await pool.query(
      'INSERT INTO testimonials (name, role, company, avatar, content, rating) VALUES (?, ?, ?, ?, ?, ?)',
      [name, role, company, avatar, content, rating || 5]
    );
    res.status(201).json({ id: result.insertId, message: 'Testimonial created' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

router.put('/:id', auth, testimonialValidation, async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) return res.status(400).json({ errors: errors.array() });
  try {
    const { name, role, company, avatar, content, rating } = req.body;
    await pool.query(
      'UPDATE testimonials SET name=?, role=?, company=?, avatar=?, content=?, rating=? WHERE id=?',
      [name, role, company, avatar, content, rating || 5, req.params.id]
    );
    res.json({ message: 'Testimonial updated' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

router.delete('/:id', auth, async (req, res) => {
  try {
    await pool.query('DELETE FROM testimonials WHERE id = ?', [req.params.id]);
    res.json({ message: 'Testimonial deleted' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
