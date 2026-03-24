# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a PHP/Yii 1.x enterprise ERP system for inventory management with integrated sales, procurement, accounting, and inventory modules. The application runs on Apache + PHP + MySQL with no build pipeline.

## Running the Application

**Requirements:** PHP 5.3+, MySQL, Apache/Nginx

1. Place the project in your web server root (Apache `DocumentRoot`)
2. Configure `protected/config/db.php` with MySQL credentials (default: `localhost`, db: `ripon_ent`, user: `root`, no password)
3. Import the database schema into MySQL
4. Access via `http://localhost/` (routes to `/site/login`)

**Gii code generator:** available at `/gii` (password: `admin`) — generates CRUD scaffolding for new models.

**Qodana static analysis:** configured in `qodana.yaml` for PHP 8.0 (run via JetBrains Qodana CLI).

## Architecture

### Request Flow

```
index.php
  → protected/config/main.php (loads modules, DB, auth, routing)
  → protected/config/urlManager.php (route matching)
  → Controller::action() (in protected/controllers/ or protected/modules/*/controllers/)
  → Model (in protected/models/ or protected/modules/*/models/)
  → themes/erp/views/.../*.php (rendered output)
```

### Module Structure

The app is split into 7 modules, each self-contained with `models/`, `controllers/`, and views (in `themes/erp/views/`):

| Module | Path | Responsibility |
|--------|------|----------------|
| `sell` | `protected/modules/sell/` | Sales orders, quotations, returns, warranty claims |
| `commercial` | `protected/modules/commercial/` | Purchase orders, suppliers |
| `accounting` | `protected/modules/accounting/` | Money receipts, payments, expenses |
| `inventory` | `protected/modules/inventory/` | Stock levels, warehouse locations |
| `user` | `protected/modules/user/` | User authentication & profiles |
| `rights` | `protected/modules/rights/` | RBAC authorization |
| `loan` | `protected/modules/loan/` | Loan management |

Core controllers (site dashboard, reports, manufacturers, product catalog) live in `protected/controllers/`.

### Authorization (RBAC)

- All controllers extend `protected/components/Controller.php` → `RController` (from the `rights` module)
- The `rights` module enforces per-action permission checks automatically
- Superuser role: `Admin`; default authenticated role: `Authenticated`
- `protected/components/UserIdentity.php` handles login authentication against the `users` table

### Views & Theming

- All view files live in `themes/erp/views/` (not in `protected/views/`)
- Layouts: `themes/erp/views/layouts/` — `column1.php` (single column), `column2.php` (sidebar), `login.php`
- Module views follow `themes/erp/views/{module}/{controller}/{action}.php`

### Database Patterns

- All models extend Yii's `CActiveRecord`
- Table name returned by `tableName()`, relations in `relations()`, validation in `rules()`
- Complex write operations use explicit DB transactions: `Yii::app()->db->beginTransaction()` → save → commit/rollback
- A MySQL trigger in `db/db-triggers.txt` archives deleted purchase order line items to `purchase_order_details_backup`

### Key Extensions (in `protected/extensions/`)

- `bootstrap/` — Yii widget wrappers for Bootstrap 3 UI components
- `highcharts/` — Chart rendering
- `EExcelView.php` — Excel export for grid views
- `dynamictabularform/` — Dynamic add/remove rows in forms
- `groupgridview/` — Grouped `CGridView` for reporting tables
- `AmountInWord.php` — Currency amount to words (used in vouchers/invoices)
- `yii-pdf/` — PDF generation for vouchers and reports

## Git Workflow

**Always follow this branching strategy — no exceptions:**

1. Create a new branch from `main` for every task:
   ```bash
   git checkout main && git pull origin main
   git checkout -b <branch-name>
   ```
2. Make changes and commit on the branch.
3. Push the branch and open a pull request (merge request) targeting `main`:
   ```bash
   git push origin <branch-name>
   gh pr create --base main --head <branch-name>
   ```
4. Merge the PR into `main` (squash or merge commit):
   ```bash
   gh pr merge --merge
   ```
5. Never commit directly to `main`.
6. Do **not** commit or push until the user explicitly says to.

### Frontend Stack

- Bootstrap 3.3.7 + jQuery 3.2.1 (loaded from CDN in layouts)
- Font Awesome 4.7.0 for icons
- Custom CSS in `themes/erp/css/` and global `css/` directory
- Print-specific styles in `css/print.css` (important for voucher/invoice printing)
