# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a PHP/Yii 1.x enterprise ERP system for inventory management with integrated sales, procurement, accounting, and inventory modules. The application runs on Apache + PHP + MySQL with no build pipeline.

**Company logo:** `themes/erp/images/logo.svg` — this is the canonical project logo. Always use `logo.svg` (not `logo.png`) when referencing "the logo".

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

## UserMenu (`protected/components/views/UserMenu.php`)

This file renders the entire top navigation bar. It is a self-contained PHP view widget — not a controller or layout — rendered from every layout via a widget call.

### Structure

```
<style>               ← all navbar CSS lives here (no external stylesheet)
<nav class="erp-nav"> ← Bootstrap 4 navbar
    navbar-brand      ← logo (logo.svg, brightness-inverted)
    navbar-toggler    ← mobile hamburger
    #erpNav           ← collapsible container
        .navbar-nav   ← left: main menu items (Dashboard, Common, Inventory, Sales, Purchase, Loan, Reports)
        .navbar-nav.ml-auto ← right: draft notification bell + user dropdown
<script>              ← draft notification logic (IIFE)
<script>              ← active-item highlight + mobile submenu JS
```

### Dark Theme Tokens

All dropdowns and UI elements must use these exact values — do not use Bootstrap light-theme defaults:

| Token | Value |
|-------|-------|
| Navbar bg | `#0f172a` |
| Dropdown bg | `#1e293b` |
| Dropdown border | `1px solid rgba(255,255,255,.08)` |
| Dropdown border-radius | `10px` |
| Dropdown box-shadow | `0 8px 28px rgba(0,0,0,.35)` |
| Header text | `#6b7280`, `10px`, `700`, uppercase, `letter-spacing:.8px` |
| Header icon | `#6366f1`, `10px` |
| Item text | `rgba(255,255,255,.78)`, `12.5px`, `font-weight:500` |
| Item padding | `7px 12px`, `border-radius:6px` |
| Item icon | `#6b7280`, `11px`, `width:14px` |
| Item hover bg | `rgba(99,102,241,.18)` |
| Item hover text | `#fff` |
| Item hover icon | `#a5b4fc` |
| Active item bg | `rgba(99,102,241,.22)`, `border-left:2px solid #6366f1` |
| Divider | `border-color:rgba(255,255,255,.07); margin:4px 6px` |

### Permission System

- All menu visibility is guarded by `$ca('Permission.Key')` — a closure wrapping `Yii::app()->user->checkAccess()`
- Permissions are cached in the session under `_nav_perms` (refreshed on logout) to avoid per-request DB queries
- Developer-only items use `$isDev` (hardcoded user ID list at top of file)
- Adding a new menu item requires: (1) add the permission key to the `array_fill_keys` list, (2) wrap the item in `if ($ca(...))`, (3) update `$showXxx` flags if a new section is needed

### Active State Detection

- `$inRoute(array $routes)` — marks a top-level nav item active if the current module/controller matches
- `$isPage($mod, $ctrl, $act)` — exact module + controller + optional action match
- JS also adds `.erp-di-active` to the matching dropdown item by comparing `window.location.pathname` to each `href`

### Draft Notification Bell (`#draft-notif-item`)

- Hidden by default (`style="display:none;"`); shown via JS as `display:flex; align-items:center` (not `show()` which sets `display:block`)
- Scans `localStorage` on every page load and on the `storage` event (cross-tab sync)
- Recognized draft keys: `so_draft_create` (Sales Order), `mr_draft_customer_<id>` (Money Receipt)
- Each draft entry exposes: `key`, `title`, `icon`, `color`, `url`, `label`, `savedAt`
- Icon colors on dark bg: `#818cf8` (indigo, SO) and `#34d399` (emerald, MR)
- To add a new draft type: add a detection block in `getDrafts()` with the same entry shape and point `url` to the correct form route
- Discard button uses `rgba(255,255,255,.18)` border — never use Bootstrap `btn-danger` here

### Adding New Nav Items

1. Add the permission key to the `array_fill_keys` list near the top of the file
2. Add `$ca('...')` check in the relevant `$showXxx` flag
3. Add the HTML inside the correct `<div class="dropdown-menu">` using `.dropdown-header` + `.dropdown-item` pattern
4. Use Font Awesome 4.7 icon classes; icon gets `color:#6b7280` via CSS automatically
5. For a new top-level section: add `$activeXxx` flag, a new `<li class="nav-item dropdown">`, and update `$activeCommon` exclusion logic if needed

### Icon-Only Nav Links

Nav links that contain only an icon (no text) must use `display:flex; align-items:center; justify-content:center` — otherwise the icon sits on the text baseline and appears vertically misaligned. Define this in the `<style>` block with the element's ID selector, not as an inline style.
