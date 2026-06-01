# SMS — Shop Management System

A lightweight, web-based **Shop Management System** built for small cafés and retail shops.
The project is written in plain **PHP + MySQL** (no framework) and styled with the **HopeUI / Bootstrap 5** template. The UI is localized in **Lao (ລາວ)** with the *Noto Sans Lao* font, and currency is displayed in **Kip (ກີບ)**.

It bundles everything a small shop needs into a single dashboard:

- A touch-friendly **Point of Sale (POS)** screen
- **Product** and **Category** management (with image uploads)
- **Stock / Inventory** tracking with a full audit log of stock movements
- **Sales history** and printable **receipts**
- **Sales reports** (daily, monthly, best sellers, date-range filters)
- **User management** with `admin` / `staff` roles and session-based authentication
- A real-time **dashboard** with KPIs, a 7-day revenue chart, and low-stock alerts

---

## Table of Contents

1. [Tech Stack](#tech-stack)
2. [Features](#features)
3. [Project Structure](#project-structure)
4. [Database Schema](#database-schema)
5. [Requirements](#requirements)
6. [Installation](#installation)
7. [Creating the First Admin User](#creating-the-first-admin-user)
8. [Roles & Access Control](#roles--access-control)
9. [Configuration](#configuration)
10. [Usage Guide](#usage-guide)
11. [Security Notes](#security-notes)
12. [Troubleshooting](#troubleshooting)
13. [Roadmap](#roadmap)
14. [License](#license)

---

## Tech Stack

| Layer        | Technology                                                |
| ------------ | --------------------------------------------------------- |
| Backend      | PHP 7.4+ (8.x recommended), `mysqli`, native sessions     |
| Database     | MySQL 5.7+ / MariaDB 10.3+ (utf8mb4)                      |
| Frontend     | HopeUI / Bootstrap 5, vanilla JavaScript, Chart.js        |
| Fonts        | Google Fonts — *Noto Sans Lao*                            |
| Server       | Any LAMP / WAMP / XAMPP / MAMP / Laragon environment      |

The codebase has **no Composer dependencies** and no build step is required to run the app — assets are already compiled under `assets/`. The `gulp+scss+hbs/` folder contains the original template source for anyone who wants to recompile the CSS/JS.

---

## Features

### Point of Sale (POS)
- Product grid with category filter and live search
- Add to cart, change quantity, remove items
- Real-time total, cash received, change calculation
- Server-side validation of price and stock (with `FOR UPDATE` row locking)
- Atomic checkout inside a SQL transaction — sales, sale items, stock decrements, and stock-movement logs are committed together or rolled back together
- Auto-redirect to a printable receipt on success

### Products & Categories
- CRUD for products: name, category, price, cost, stock, low-stock threshold, image
- Image upload with MIME-type validation (jpg / png / webp / gif), size capped at 5 MB
- Random filenames to prevent collisions; old images are deleted on replace
- Category-tinted placeholder icons (coffee ☕, tea 🧋, juice 🥤, cake 🍰, other 🛍) when no image is set
- Soft toggle (`status` flag) instead of hard delete where appropriate

### Inventory
- Lists current stock for every active product
- Highlights items at or below their **low-stock threshold**
- Full audit trail in `stock_movements` — every sale, manual adjustment, or initial stock entry is logged with reason, reference, user, and timestamp
- Low-stock badge on the sidebar updates automatically

### Sales History & Receipts
- Paginated list of all sales with filters
- Each sale links to a print-ready receipt page
- Receipts show line items, totals, paid amount, change, cashier, and timestamp

### Reports (Admin only)
- Pick any date range
- Summary cards: total transactions and total revenue
- Daily breakdown table
- Last-6-months trend (chart-ready)
- Top-10 best-selling products by quantity and revenue

### Dashboard
- Today's revenue and transaction count
- Month-to-date revenue and transaction count
- Active product count
- Low-stock alert count
- 7-day rolling sales chart
- Top-selling products of the current month

### Users & Authentication
- Login with username + password (passwords are **hashed with `password_hash` / `PASSWORD_DEFAULT`**)
- Session-based auth via `includes/auth.php`
- Two roles: `admin` (full access) and `staff` (POS + product list + sales view)
- Admins can add / edit / disable / delete users
- Users cannot delete themselves
- Account status flag (`status = 0`) to suspend a user without deleting them
- Lock-screen, recover-password, and sign-up template pages are included for future use

### UX / UI niceties
- Custom **toast** notification system (success / error / warning / info) — server-side flash messages are auto-rendered as toasts on the next page
- Custom **confirmation modal** — any form or link with `data-confirm="..."` triggers a styled modal instead of the native `confirm()` dialog
- Mobile-friendly responsive sidebar with backdrop and swipe-friendly tap targets
- Sticky navbar, card-based layouts, accessible color palette
- All dates formatted with Lao month abbreviations (ມ.ກ, ກ.ພ, ມີ.ນ …)

---

## Project Structure

```
dashboard-main/
├── index.php              # Entry point — redirects to Views/
├── config.php             # MySQL connection settings
│
├── Views/                 # All page templates (PHP + HTML)
│   ├── index.php          #  → Login page
│   ├── main.php           #  → Dashboard wrapper
│   ├── dashboard.php      #  → Dashboard content (KPIs, charts)
│   ├── pos.php            #  → Point of Sale
│   ├── products.php       #  → Product list
│   ├── product-form.php   #  → Product add / edit form
│   ├── categories.php     #  → Category management (admin)
│   ├── inventory.php      #  → Current stock + low-stock view
│   ├── sales-list.php     #  → Sales history
│   ├── sale-receipt.php   #  → Printable receipt
│   ├── reports.php        #  → Sales reports (admin)
│   ├── user-list.php      #  → User management (admin)
│   ├── user-add.php       #  → Add / edit user form (admin)
│   ├── user-profile.php   #  → Current user's profile
│   ├── sidebar.php        #  → Shared left sidebar
│   ├── navbar.php         #  → Shared top bar
│   ├── footer.php         #  → Shared footer
│   ├── auth/              #  → Lock screen, recover password, sign-up
│   ├── app/               #  → User account & privacy settings
│   ├── icons/, maps/, errors/, extra/
│
├── controller/            # POST handlers — all form submissions land here
│   ├── login.php          #  → Authenticates user, creates session
│   ├── logout.php         #  → Destroys session
│   ├── products.php       #  → Product add / edit / delete / toggle
│   ├── categories.php     #  → Category CRUD
│   ├── inventory.php      #  → Manual stock adjustments
│   ├── sales.php          #  → POS checkout (transactional)
│   ├── users.php          #  → User CRUD (admin)
│   ├── addStaffs.php      #  → Staff helpers
│   ├── editStaffs.php     #  → Staff helpers
│   └── profile.php        #  → Update own profile / password
│
├── includes/
│   ├── auth.php           # Session helpers, role checks, URL helpers,
│   │                      # date/money formatters, avatar/category visuals
│   └── layout.php         # Shared <head>, custom CSS, sidebar/navbar
│                          # injection, toast & confirm-modal JS
│
├── sql/
│   └── schema.sql         # Database schema (run this once)
│
├── assets/
│   ├── css/               # Compiled CSS (libs.min.css, tecdig.css)
│   ├── js/                # Compiled JS (libs.min.js, app.js)
│   ├── images/, img/      # Static images / icons
│   ├── vendor/            # Third-party UI vendor assets
│   ├── uploads/products/  # Uploaded product images (auto-created)
│   └── logo.png           # App logo
│
└── gulp+scss+hbs/         # Original HopeUI source (Gulp + SCSS + HBS) —
                           # only needed if you want to recompile assets
```

---

## Database Schema

The full schema lives in [`sql/schema.sql`](sql/schema.sql). At a glance:

| Table             | Purpose                                                       |
| ----------------- | ------------------------------------------------------------- |
| `users`           | Login accounts. Roles: `admin`, `staff`. Hashed passwords.    |
| `categories`      | Product categories (e.g. Coffee, Tea, Bakery).                |
| `products`        | Products — price, cost, stock, low-stock threshold, image.    |
| `sales`           | One row per completed POS transaction.                        |
| `sale_items`      | Line items belonging to a sale (denormalized name + price).   |
| `stock_movements` | Audit log of every stock change (sale, adjustment, initial).  |

Foreign keys use `ON DELETE SET NULL` for soft references (so a deleted product or user does not destroy historical sales data) and `ON DELETE CASCADE` only where appropriate (`sale_items` → `sales`).

---

## Requirements

- **PHP 7.4 or later** (PHP 8.x recommended)
  - Enabled extensions: `mysqli`, `fileinfo`, `mbstring`, `session`, `json`
- **MySQL 5.7+** or **MariaDB 10.3+** with `utf8mb4` support
- **Apache** (or nginx + php-fpm) with URL rewriting **not** required — the app uses plain `.php` URLs
- Write permission on `assets/uploads/` for the web-server user

A bundled stack such as **XAMPP**, **MAMP**, **WAMP**, or **Laragon** is the simplest way to satisfy all of the above on a developer machine.

---

## Installation

### 1. Clone or copy the project into your web root

```bash
# Example for XAMPP on macOS / Linux
cd /Applications/XAMPP/htdocs        # or /opt/lampp/htdocs
git clone <your-repo-url> shop_management_system
```

For XAMPP on Windows, place the folder under `C:\xampp\htdocs\`.

### 2. Create the database

Open phpMyAdmin (or the `mysql` CLI) and run:

```bash
mysql -u root -p < sql/schema.sql
```

This creates a database called `cafe_system` together with all required tables.

### 3. Configure the database connection

Edit `config.php` and adjust the credentials if they differ from the defaults:

```php
$servername = "localhost";
$username   = "root";
$password   = "";          // ← set your MySQL password here
$dbname     = "cafe_system";
```

### 4. Make the uploads directory writable

```bash
mkdir -p assets/uploads/products
chmod -R 775 assets/uploads
```

(The application will also auto-create this folder on the first image upload.)

### 5. Start your local server and open the app

Visit:

```
http://localhost/shop_management_system/dashboard-main/
```

You will be redirected to the login page.

---

## Creating the First Admin User

The `users` table is empty after a fresh install, so you need to insert one admin manually. Run this in phpMyAdmin or the `mysql` CLI — replace the username, full name, and password with your own:

```sql
INSERT INTO users (username, password_hash, fullname, role, status)
VALUES (
  'admin',
  -- Generate the hash in PHP: echo password_hash('your-password', PASSWORD_DEFAULT);
  '$2y$10$REPLACE_WITH_HASH_FROM_PHP',
  'Administrator',
  'admin',
  1
);
```

The easiest way to generate the hash is to create a temporary PHP file containing:

```php
<?php echo password_hash('YourStrongPassword!', PASSWORD_DEFAULT);
```

Run it once (`php hash.php` from the CLI, or open it in the browser), copy the output into the SQL above, then delete the file. Once you can log in, create additional users from **User Management** in the dashboard instead.

---

## Roles & Access Control

| Capability                              | `admin` | `staff` |
| --------------------------------------- | :-----: | :-----: |
| Log in / view dashboard                 |    ✅   |    ✅   |
| POS — make sales                        |    ✅   |    ✅   |
| View product list                       |    ✅   |    ✅   |
| Add / edit / delete products            |    ✅   |    ❌   |
| Manage categories                       |    ✅   |    ❌   |
| Adjust stock (manual movements)         |    ✅   |    ❌   |
| View sales history & receipts           |    ✅   |    ✅   |
| Reports                                 |    ✅   |    ❌   |
| Manage users                            |    ✅   |    ❌   |
| Edit own profile / password             |    ✅   |    ✅   |

Access is enforced server-side in every controller via `require_login()` and `require_admin()` (see `includes/auth.php`). Staff-only menu items are also hidden from the sidebar.

---

## Configuration

All runtime configuration lives in a single file:

**`config.php`** — MySQL connection (`$servername`, `$username`, `$password`, `$dbname`) and the default UTF-8 charset on the connection.

Other behavior that can be customized in code:

- **Money format** — `money($value)` in `includes/auth.php` returns `"1,200 ກີບ"`. Change the suffix or formatting there to use a different currency.
- **Date format** — `format_datetime()` / `format_date()` in `includes/auth.php` use Lao month abbreviations. Replace `$months` if you want English or a different locale.
- **Low-stock threshold** — set per-product on the product form; the default for new products is `5`.
- **Upload limits** — `controller/products.php` caps uploads at 5 MB and allows `jpg/png/webp/gif`. Change the constants at the top of `handle_image_upload()` if needed.

---

## Usage Guide

### Logging in
Open the app's root URL, enter username + password. Wrong credentials or a suspended account (`status = 0`) display an inline error.

### Making a sale (POS)
1. Open **POS (ໜ້າຂາຍ)** from the sidebar.
2. Filter products by category or search by name.
3. Click a product card to add it to the cart. Click again or use the qty input to increase the quantity.
4. Enter the cash amount received in **ເງິນຮັບ** — change is calculated automatically.
5. Click **ບັນທຶກການຂາຍ / Checkout**. On success you are redirected to the printable receipt.

The checkout endpoint re-validates prices and stock against the database inside a SQL transaction. If anything fails (insufficient stock, missing product), the entire sale is rolled back and an error toast is shown.

### Adding a product (admin)
1. **ຈັດການສິນຄ້າ → ລາຍການສິນຄ້າ** → **ເພີ່ມສິນຄ້າ**.
2. Fill in name, category, price, cost, initial stock, and low-stock threshold.
3. (Optional) Upload a product image.
4. Save — the initial stock is recorded as a stock movement with reason `initial`.

### Adjusting stock manually (admin)
Go to **ສິນຄ້າຄົງເຫຼືອ (Inventory)** → choose a product → enter a positive or negative adjustment and a note. The change is reflected on `products.stock` and logged in `stock_movements` with reason `manual`.

### Running a report (admin)
Open **ລາຍງານ (Reports)**, pick a date range, and review:
- Headline totals (transactions + revenue)
- Daily breakdown
- Last 6 months trend
- Top 10 best sellers

### Managing users (admin)
**User List** shows everyone. Use **ເພີ່ມຜູ້ໃຊ້** to add a user, the row actions to edit/disable, and the delete button to remove. You cannot delete yourself.

---

## Security Notes

- ✅ Passwords are stored with `password_hash()` and verified with `password_verify()`.
- ✅ All SQL is parameterized with `mysqli` prepared statements (except a few read-only dashboard queries that interpolate already-validated `DATE()` strings).
- ✅ Output is HTML-escaped via the `e()` helper.
- ✅ POS checkout is wrapped in a transaction and uses `SELECT ... FOR UPDATE` to prevent overselling under concurrency.
- ✅ Uploaded files are validated by MIME type (`finfo`) and renamed to random hex names — the user-supplied filename is never used.
- ⚠️ Sessions are PHP defaults — for production, set `session.cookie_secure`, `session.cookie_httponly`, and `session.cookie_samesite` in `php.ini`, and serve the app over **HTTPS**.
- ⚠️ The app does **not** ship CSRF tokens. If you deploy publicly, add CSRF protection to every state-changing form.
- ⚠️ Change the default MySQL credentials in `config.php` and never commit a real production password.

---

## Troubleshooting

**"ບໍ່ສາມາດເຊື່ອມຕໍ່ຖານຂໍ້ມູນໄດ້" (cannot connect to database)**
Check that MySQL is running and that the credentials in `config.php` are correct. On XAMPP this is usually `root` with an empty password.

**Login page just reloads with no error**
The `users` table is empty. See [Creating the First Admin User](#creating-the-first-admin-user).

**"ອັບໂຫຼດຮູບບໍ່ສຳເລັດ" (image upload failed)**
- Confirm `assets/uploads/products/` exists and is writable by the web-server user.
- Check `php.ini` for `upload_max_filesize` and `post_max_size` (must be ≥ 5 MB).

**Lao text shows as `?` or boxes**
Make sure your database / table / column collation is `utf8mb4_unicode_ci` and that your browser has access to Google Fonts (the *Noto Sans Lao* font is loaded from `fonts.googleapis.com`).

**Sidebar links go to the wrong path**
The `base_url()` / `url()` helpers in `includes/auth.php` infer the base path from `$_SERVER['SCRIPT_NAME']`. If you deploy under a non-standard path, double-check that helper.

---

## Roadmap

Ideas worth adding next:

- CSRF tokens on every form
- Soft-delete for products and sales (instead of hard delete)
- Multi-store / branch support
- Tax / VAT and discounts at the line and order level
- Multi-language toggle (Lao / English / Thai)
- Export reports to CSV / Excel / PDF
- Customer loyalty (phone, points, redemption)
- Barcode scanning in POS

---

## License

This project is provided **as-is** for educational and small-business use. The bundled HopeUI template assets in `assets/` and `gulp+scss+hbs/` are © their original authors and ship under their own license — please review it before redistributing.

If you intend to deploy this in production, you are responsible for hardening it (HTTPS, CSRF, backups, MySQL credentials, file permissions).

---

**Made with ❤️ for small cafés and shops.**
