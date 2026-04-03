# Views & Theming Architecture

## Overview

All view files live in `themes/erp/views/` — NOT in `protected/views/`. The theme uses Bootstrap 3 with AdminLTE, Font Awesome 4.7, and a custom dark-themed navigation bar.

## Key Files

| Path | Role |
|------|------|
| `themes/erp/views/layouts/main.php` | Master HTML5 layout (loads all CSS/JS) |
| `themes/erp/views/layouts/column1.php` | Single-column content layout |
| `themes/erp/views/layouts/column2.php` | Two-column layout (sidebar + content) |
| `themes/erp/views/layouts/column3.php` | Three-column layout |
| `themes/erp/views/layouts/login.php` | Login page layout (no navbar) |
| `protected/components/views/UserMenu.php` | Top navigation bar (self-contained widget) |

## Layout Hierarchy

```
main.php (master)
  ├── <head> — meta, CSS (Bootstrap, AdminLTE, Font Awesome, toastr, custom)
  ├── <body>
  │   ├── UserMenu widget (navbar)
  │   ├── $content (from column layout)
  │   └── <script> tags (jQuery, Bootstrap, moment, toastr, custom JS)
  └── column1.php / column2.php (content layouts)
        ├── BreadCrumb widget
        ├── Notifications widget
        └── $this->renderPartial('{action}', $data)
```

## View Resolution

Controllers specify layout: `$layout = '//layouts/column1'`

Views are resolved by Yii's theme engine:
```
$this->render('create')
  → themes/erp/views/{controller}/create.php      (core controllers)
  → themes/erp/views/{module}/{controller}/create.php  (module controllers)
  → protected/modules/{module}/views/{controller}/create.php  (fallback)
```

## View File Conventions

Standard CRUD set per entity:
| File | Purpose |
|------|---------|
| `admin.php` | Grid listing (CGridView) |
| `create.php` | Create form wrapper |
| `update.php` | Update form wrapper |
| `view.php` | Detail view (CDetailView) |
| `_form.php` | Create form partial |
| `_form2.php` | Update form partial |
| `_form3.php` | Alternative form variant (some entities) |
| `_search.php` | Search form partial |
| `voucherPreview.php` | Print-ready voucher/invoice |

## Form View Design Pattern

All CRUD form views (`_form.php`, `_form2.php`, `_form3.php`) use a consistent modern design:

### Card Layout
- Card with rounded corners (`border-radius: 16px`), subtle box shadows
- **Header**: Gradient background (entity-specific colors), title with icon badge, decorative radial dot pattern
- **Body**: White background with floating-label form inputs
- **Footer**: Light gray (`#f8fafc`) background with action buttons

### Floating Label Inputs
Each entity uses a CSS prefix (e.g., `un-` for units, `cu-` for customers, `pb-` for prodBrands) with consistent patterns:
- `.{prefix}-fl` — floating label wrapper
- `.{prefix}-fl-input` — input field with `padding: 18px 12px 6px 38px` (space for icon + floating label)
- `.{prefix}-fl-label` — label that floats up on focus via `transform: translateY(-11px) scale(.82)`
- `.{prefix}-fl-icon` — Font Awesome icon positioned inside input (`left: 12px`)
- Focus state: indigo border (`#6366f1`), ring shadow (`rgba(99,102,241,.12)`)

### Color Palette
Header gradients vary by entity but follow a consistent style:
- Indigo/violet: `#4f46e5` → `#7c3aed` (units, prodBrands)
- Blue/cyan: `#0891b2` → `#0284c7` (customers, suppliers)
- Green/emerald: various shades (accounting, inventory)

### Responsive Design
- Grid system uses Bootstrap 3 `col-md-*` classes inside card body
- Mobile-friendly with proper field spacing (`margin-bottom: 18px`)

## CSS Architecture

### Theme CSS (`themes/erp/css/`)
- `custom.css` — Main custom styles
- `layout.css`, `style.css`, `reset.css` — Base styles
- `gridview/` (12 files) — Data grid styling
- `listview/` (7 files) — List view styling
- `detailview/` (3 files) — Detail view styling
- `pos/` (7 files) — Point-of-sale styles
- `report.css` — Report-specific styles
- Vendor CSS: bootstrap-datepicker, lightpick, dropzone, jquery-ui

### Root CSS (`css/`)
- `main.css`, `form.css`, `default.css`, `screen.css`, `print.css`, `ie.css`
- `print.css` — Critical for voucher/invoice printing

## JavaScript

### Theme JS (`themes/erp/js/`)
- jQuery, jQuery UI, alertify, bootstrap-datepicker, lightpick
- table2excel (Excel export from tables)
- dropzone (file uploads)
- print-jquery (print functionality)
- jqClock (clock widget)

## Navigation Bar (UserMenu)

The `UserMenu.php` is a self-contained widget with inline `<style>`, HTML, and `<script>`. It uses a dark theme (`#0f172a` background) with dropdown menus.

Key sections:
- Logo (logo.svg)
- Main menu: Dashboard, Common, Inventory, Sales, Purchase, Loan, Reports
- Right side: Draft notification bell + user dropdown

See CLAUDE.md for complete dark theme token reference and modification guidelines.

## Report Views

38+ report views in `themes/erp/views/report/`:
- Sales/Purchase reports (summary and detail)
- Customer/Supplier ledgers
- Collection/Payment reports
- Due reports (customer and supplier)
- Expense reports (summary and detail)
- Inventory reports (aging, dead stock, fast-moving, performance)
- Day in/out report
- Loan ledger
- Price lists
