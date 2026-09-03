# Zerox Pharmaceuticals Ltd - Master E-Commerce & Admin Web Portal

A high-performance Laravel web application matching the official [Zerox.com](https://zzerox.com) digital platform, featuring dynamic catalog management, anti-counterfeit security code verification, interactive location pin map picker, RESTful API v1, Swagger UI playground, admin themes, and Vercel serverless deployment.

---

## 🌟 Key Application Features

- **Dynamic Brand Identity**: Dynamic Header Logo, Footer Logo, and Multi-format Favicon PNG/ICO upload & display.
- **Master Product Catalog**: Responsive catalog (`/category`) featuring 195+ realistic pharmaceutical products across 13 subcategories, interactive product gallery photo lightboxes, and Zerox gold accent pagination.
- **Anti-Counterfeit Scratch Code Verification**: Security code verification system (`/authenticity`) with IP logging, verification timestamps, and counterfeit warnings.
- **Interactive Location Pin Picker Map**: Drag & drop Leaflet map picker in Admin Settings for physical address coordinates (`map_latitude`, `map_longitude`).
- **CKEditor 5 & SEO Permalinks**: Rich text editing on product descriptions, chemical specs, and side effects with custom URL Slug auto-generators.
- **Admin Panel Theme Switcher**: Toggle between 4 distinct visual themes (**Dark**, **Light**, **Slate Gray**, **Ultra White**) with instant `localStorage` persistence.
- **Admin Profile & Social Management**: Profile view/edit for logged-in users with avatar photo uploads, mobile hotline, bio summary, and social links (WhatsApp, LinkedIn, Twitter/X, Telegram, Facebook).
- **RESTful API v1 & Swagger UI**: Full REST API endpoints (`/api/v1/...`) with OpenAPI 3.0 specification JSON and an interactive Swagger UI API playground (`/admin/swagger`).
- **Site Performance & Speed Manager**: Real-time database latency benchmarks, memory peak usage, disk metrics, and 1-Click speed optimization buttons (Config, Routes, Blade Views, and DB Indexes).
- **Vercel Serverless Production Ready**: Configured with `vercel.json` (`vercel-php@0.7.2`), `api/index.php`, and `/tmp` writable storage handlers for instant Vercel cloud deployment.

---

## 🚀 How to Run & Setup from GitHub

### Prerequisites
- **PHP**: 8.1 or 8.2+
- **Composer**: 2.x
- **Database**: MySQL 5.7 / 8.0+ or MariaDB
- **Node.js / NPM** (Optional)

---

### Step 1: Clone Repository
```bash
git clone https://github.com/rislrohitjain/zzerox.git
cd zzerox
```

---

### Step 2: Install Composer Dependencies
```bash
composer install
```

---

### Step 3: Configure Environment
Copy the example environment file and generate the application encryption key:
```bash
cp .env.example .env
php artisan key:generate
```

---

### Step 4: Configure Database Connection
Open your `.env` file and set your MySQL database credentials:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zzerox
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

---

### Step 5: Run Database Migrations & Data Seeder
Execute the master database migrations and seeder to populate all 195 products, 585 gallery images, 390 verification scratch codes, and default site settings:
```bash
php artisan migrate:fresh --seed
```

---

### Step 6: Default Admin Login Credentials
Access the Admin Panel at `/login` or `/admin`:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Super Admin** | `admin@zzerox.com` | `AdminPass@2026` |
| **Operator 1** | `operator@zzerox.com` | `OperatorPass@2026` |

---

### Step 7: Launch Local Server
Start the local Laravel development server:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```
Open your browser at: [http://localhost:8000](http://localhost:8000) or [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

### Step 8: Deploy to Vercel Serverless Cloud
To deploy your application live to Vercel:
```bash
# 1. Install Vercel CLI (if not already installed)
npm install -g vercel

# 2. Deploy to Production
vercel --prod
```
Live Production URL: [https://zzerox.vercel.app](https://zzerox.vercel.app)

---

## 📡 RESTful API Endpoints (`/api/v1`)

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/v1/products` | List active products with pagination & search |
| `GET` | `/api/v1/products/{slug}` | Get single product details & gallery |
| `GET` | `/api/v1/categories` | Get category tree & subcategories |
| `GET` | `/api/v1/categories/{slug}` | Get category with paginated products |
| `POST` | `/api/v1/verify-code` | Verify packaging security scratch code |
| `GET` | `/api/v1/banners` | List active hero banners |
| `GET` | `/api/v1/settings` | Get public site settings & location map coords |
| `POST` | `/api/v1/subscribe` | Subscribe email to official newsletter |
| `GET` | `/api/v1/health` | System health & DB latency status |
| `GET` | `/api/v1/openapi.json` | OpenAPI 3.0 specification JSON |
| `GET` | `/admin/swagger` | Interactive Admin Swagger UI Playground |

---

## 📄 License
This project is developed for **Zerox Pharmaceuticals Ltd**. All rights reserved.
