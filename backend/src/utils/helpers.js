function slugify(text) {
  return text.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
}

function getReadingTime(content) {
  return Math.max(1, Math.ceil((content.split(/\s+/).length || 1) / 200));
}

function parseJson(value, fallback = null) {
  try { return JSON.parse(value); } catch { return fallback; }
}

module.exports = { slugify, getReadingTime, parseJson };
