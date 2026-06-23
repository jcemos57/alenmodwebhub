# Alenmodwebhub - Premium Portfolio CMS

Full-stack portfolio website with PHP frontend, Express API backend, and MySQL database.

## Stack
- **Frontend:** PHP (XAMPP), CSS, JavaScript
- **Backend API:** Node.js + Express
- **Database:** MySQL
- **Admin Panel:** PHP (built-in)

## Quick Start (XAMPP)

1. Clone to `htdocs/`
2. Import `database/schema.sql` into phpMyAdmin
3. Edit `config/database.php` if your DB credentials differ
4. Start Apache + MySQL in XAMPP
5. Open `http://localhost/alenmodwebhub`

## Admin Panel

- URL: `http://localhost/alenmodwebhub/admin/`
- Login: `admin@alenmodwebhub.com` / `admin123`

## Backend API (optional)

```bash
cd backend
npm install
npm run dev
```

API runs on `http://localhost:5000/api`
