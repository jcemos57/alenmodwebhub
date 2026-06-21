const express = require('express');
const router = express.Router();
const pool = require('../config/database');
const auth = require('../middleware/auth');

router.get('/', async (req, res) => {
  try {
    const [services] = await pool.query('SELECT * FROM services ORDER BY sort_order ASC');
    res.json(services);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

router.post('/', auth, async (req, res) => {
  try {
    const { title, description, icon, features, price, sort_order } = req.body;
    const [result] = await pool.query(
      'INSERT INTO services (title, description, icon, features, price, sort_order) VALUES (?, ?, ?, ?, ?, ?)',
      [title, description, icon, JSON.stringify(features || []), price, sort_order || 0]
    );
    res.status(201).json({ id: result.insertId, message: 'Service created' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

router.put('/:id', auth, async (req, res) => {
  try {
    const { title, description, icon, features, price, sort_order } = req.body;
    await pool.query(
      'UPDATE services SET title=?, description=?, icon=?, features=?, price=?, sort_order=? WHERE id=?',
      [title, description, icon, JSON.stringify(features), price, sort_order, req.params.id]
    );
    res.json({ message: 'Service updated' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

router.delete('/:id', auth, async (req, res) => {
  try {
    await pool.query('DELETE FROM services WHERE id = ?', [req.params.id]);
    res.json({ message: 'Service deleted' });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
