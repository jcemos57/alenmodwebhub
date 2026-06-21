const express = require('express');
const router = express.Router();
const { body, validationResult } = require('express-validator');
const pool = require('../config/database');
const auth = require('../middleware/auth');

router.get('/', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT setting_key, setting_value FROM site_settings');
    const settings = {};
    for (const row of rows) {
      settings[row.setting_key] = row.setting_value;
    }
    res.json(settings);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

router.put('/', auth, async (req, res) => {
  try {
    const allowedKeys = ['hero_title', 'hero_subtitle', 'hero_availability', 'about_text', 'email', 'phone', 'location', 'whatsapp', 'github_url', 'linkedin_url', 'twitter_url', 'facebook_url', 'instagram_url', 'youtube_url', 'footer_text', 'copyright_text', 'experience_years', 'projects_count', 'clients_count', 'countries_count', 'site_title', 'site_description', 'site_keywords', 'cv_url', 'default_currency_symbol', 'default_currency_code'];
    const updates = Object.keys(req.body).filter(k => allowedKeys.includes(k));
    for (const key of updates) {
      await pool.query(
        'INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)',
        [key, req.body[key]]
      );
    }
    res.json({ message: 'Settings updated', updated: updates });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
