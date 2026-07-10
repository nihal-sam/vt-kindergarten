# 🌟 VT Kindergarten Play School — Full Stack Website

Premium animated school website for **VT Kindergarten Play School, Karaikudi**.
Built with **React + Vite** (frontend & admin) and **Laravel 10 + MySQL** (backend).

---

## 📁 Project Structure

```
vt-kindergarten/
├── frontend/     → Public website  (React, port 5173)
├── admin/        → Admin panel     (React, port 5174)
└── backend/      → Laravel 10 API  (port 8000)
    ├── composer.json   ✅ INCLUDED
    ├── artisan
    ├── .env
    ├── app/Http/Controllers/  (4 controllers)
    ├── app/Models/            (3 models)
    ├── config/                (cors, database, sanctum, auth, etc.)
    ├── database/migrations/   (3 migration files)
    ├── database/seeders/
    ├── routes/api.php
    ├── public/index.php
    └── storage/               (all dirs included)
```

---

## 🚀 Setup — 4 Steps

### Step 1 — Create MySQL database
```sql
CREATE DATABASE vt_kindergarten CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 2 — Backend (Laravel)
```bash
cd vt-kindergarten/backend

# Install all Laravel + Sanctum packages from composer.json
composer install

# Generate app key
php artisan key:generate

# (Optional) Edit .env if your MySQL password is not empty:
# DB_PASSWORD=your_password

# Create all tables
php artisan migrate

# Create admin user + sample data
php artisan db:seed

# Start API server
php artisan serve
# Running at: http://localhost:8000
```

### Step 3 — Public Website
```bash
cd vt-kindergarten/frontend
npm install
npm run dev
# Running at: http://localhost:5173
```

### Step 4 — Admin Panel
```bash
cd vt-kindergarten/admin
npm install
npm run dev
# Running at: http://localhost:5174
```

---

## 🔐 Admin Login

- **URL:** http://localhost:5174
- **Email:** admin@vtkindergarten.com
- **Password:** admin123

---

## 🌐 API Endpoints

### Public (no auth)
| POST | /api/admissions | Submit admission |
| POST | /api/enquiries  | Submit enquiry   |

### Admin (Bearer token)
| GET/DELETE | /api/admin/admissions | Manage admissions |
| GET/DELETE | /api/admin/enquiries  | Manage enquiries  |
| GET        | /api/admin/stats      | Dashboard stats   |
| POST       | /api/admin/login      | Login             |

---

## ✨ Website Features

### Public Site
- Custom animated cursor, floating bubbles, scroll progress bar
- Loading screen with animation
- Sticky navbar with blur backdrop
- Hero with rotating phrases and floating cards
- Scrolling admission banner ticker
- About, Programs (Playgroup/Nursery/LKG/UKG), Gallery
- Admissions form (saves to MySQL)
- Enquiry form (saves to MySQL)
- Instagram section, Contact, Footer
- Fully mobile responsive

### Admin Panel
- Secure login (Laravel Sanctum tokens)
- Dashboard with stats overview
- Admissions table: search, filter by program, view full details, delete
- Enquiries table: search, view, delete
- Excel export (.xlsx) for both admissions and enquiries

---

## 📞 School Info

VT Kindergarten Play School
11, 7th Street, South Extension, Vairavapuram,
Subramaniapuram, Karaikudi - 630002
Near Reliance Smart Bazaar
Programs: Playgroup · Nursery · LKG · UKG
Ages: 1.5 to 5.5 Years
