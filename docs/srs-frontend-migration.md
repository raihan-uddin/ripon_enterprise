# Software Requirements Specification (SRS)

## Frontend Migration: Remove AdminLTE, Upgrade to Bootstrap 5 + jQuery 3.7, CSS Consolidation & Dead Code Cleanup

| Field | Value |
|-------|-------|
| **Document Version** | 1.0 |
| **Date** | 2026-04-03 |
| **Project** | Ripon Enterprise ERP |
| **Status** | Draft |

---

## Table of Contents

1. [Introduction](#1-introduction)
2. [Current State Analysis](#2-current-state-analysis)
3. [Scope of Changes](#3-scope-of-changes)
4. [Functional Requirements](#4-functional-requirements)
5. [Non-Functional Requirements](#5-non-functional-requirements)
6. [Migration Phases](#6-migration-phases)
7. [File-Level Change Inventory](#7-file-level-change-inventory)
8. [Class Migration Reference](#8-class-migration-reference)
9. [Risk Assessment](#9-risk-assessment)
10. [Acceptance Criteria](#10-acceptance-criteria)
11. [CSS Consolidation](#11-css-consolidation)
12. [Dead File Cleanup Inventory](#12-dead-file-cleanup-inventory)
13. [Yii Framework jQuery Core Replacement](#13-yii-framework-jquery-core-replacement)
14. [Frontend Design System](#14-frontend-design-system)
15. [Inline JavaScript Consolidation](#15-inline-javascript-consolidation)
16. [Accessibility Improvements](#16-accessibility-improvements)
17. [Performance Budget](#17-performance-budget)
18. [Security Hardening (CSP Readiness)](#18-security-hardening-csp-readiness)
19. [Security Vulnerabilities & Fixes](#19-security-vulnerabilities--fixes)
20. [Testing Strategy & QA Checklist](#20-testing-strategy--qa-checklist)
21. [Yii Extension Widget Compatibility](#21-yii-extension-widget-compatibility)
22. [JS-Generated HTML & Dynamic Content Migration](#22-js-generated-html--dynamic-content-migration)
23. [Browser Cache Busting Strategy](#23-browser-cache-busting-strategy)
24. [Deployment & Migration Runbook](#24-deployment--migration-runbook)
25. [Database Query Optimization](#25-database-query-optimization)
26. [Error Handling & User Feedback Standardization](#26-error-handling--user-feedback-standardization)
27. [Framework Patches Registry](#27-framework-patches-registry)
28. [Print & PDF Export Standardization](#28-print--pdf-export-standardization)
29. [Performance Baseline Metrics](#29-performance-baseline-metrics)
30. [Responsive Design & Multi-Device Support](#30-responsive-design--multi-device-support)

---

## 1. Introduction

### 1.1 Purpose

This document specifies all requirements for removing the AdminLTE 3 framework, upgrading from Bootstrap 4 to Bootstrap 5.3, upgrading jQuery from 3.5.1 to 3.7.x, unifying Font Awesome to version 6, and cleaning up all legacy/dead frontend assets from the Ripon Enterprise ERP codebase.

### 1.2 Goals

| # | Goal |
|---|------|
| G1 | Remove all AdminLTE CSS, JS, and plugin dependencies |
| G2 | Replace Bootstrap 4 with Bootstrap 5.3 (latest stable) |
| G3 | Upgrade jQuery from 3.5.1 to 3.7.x and override Yii's bundled jQuery 1.12.4 |
| G4 | Unify Font Awesome to version 6 across all layouts |
| G5 | Remove dead/unused frontend assets (49 unused plugins, legacy Blueprint CSS, dead extensions) |
| G6 | Maintain all existing functionality — zero regressions in UI behavior |
| G7 | Preserve the existing dark indigo theme and custom design language |
| G8 | Consolidate duplicated inline CSS into shared external stylesheets |
| G9 | Delete all unused/dead files (CSS, JS, images, plugins, extensions) from the codebase |
| G10 | Replace Yii framework's bundled jQuery 1.12.4 with jQuery 3.7.x at the source level |
| G11 | Establish a frontend design system skill to enforce consistency across all future views |
| G12 | Consolidate inline JavaScript into external files where feasible |
| G13 | Improve accessibility (ARIA, keyboard nav, focus management) |
| G14 | Define a performance budget for frontend assets |
| G15 | Prepare the codebase for Content Security Policy (CSP) headers |
| G16 | Fix all critical and high security vulnerabilities (SQL injection, XSS, CSRF, weak auth) |
| G17 | Provide a structured QA test plan covering every module's critical pages |
| G18 | Ensure all Yii extension widgets (groupgridview, dynamictabularform, EExcelView, yii-pdf) are BS5-compatible |
| G19 | Migrate JS-generated HTML (innerHTML, .html() calls) to use BS5 data attributes |
| G20 | Implement cache-busting strategy for all vendor assets to prevent stale cache issues |
| G21 | Document a step-by-step deployment runbook with rollback procedure |
| G22 | Optimize database query patterns — fix N+1 problems, parameterize all queries, define model relations |
| G23 | Standardize error handling and user feedback into one unified pattern |
| G24 | Maintain a registry of all Yii framework patches for PHP 8.x and jQuery upgrades |
| G25 | Standardize print/PDF/Excel export pipeline across all reports and vouchers |
| G26 | Capture before/after performance baseline metrics to verify improvements |
| G27 | Ensure fully responsive design that works on all devices — phones, tablets, laptops, large monitors |

### 1.3 Out of Scope

- Redesigning views or changing the visual appearance beyond what the migration requires
- Migrating away from jQuery entirely (jQuery is still needed for Yii 1.x widgets)
- Replacing Yii 1.x widget rendering (CGridView, CActiveForm, CLinkPager)
- Changing the PHP backend, controllers, or models
- Mobile app or PWA functionality

### 1.4 Phase Grouping: Phase A vs Phase B

| Group | Phases | Description |
|-------|--------|-------------|
| **Phase A** (core migration) | Phases 0–7 | The primary deliverable of this SRS — asset swap, BS5 upgrade, class migration, security fixes, jQuery upgrade, cleanup |
| **Phase B** (extended scope) | Sections 16, 25, 26 | Optional enhancements (Accessibility, DB optimization, Error handling standardization) — NOT blockers for Phase A |

Phase B items SHALL only be started after Phase A is fully complete and passing the QA checklist (Section 20).

### 1.5 Effort Estimates

| Phase | Tasks | Estimated Effort | Notes |
|-------|-------|-----------------|-------|
| Phase 0 | Dead code cleanup, asset removal | 2–3 days | Low risk, no testing overhead |
| Phase 1 | Bootstrap 5 upgrade (data attributes, CSS classes) | 5–7 days | Requires visual regression testing |
| Phase 2 | Font Awesome 6 migration | 2–3 days | Mostly find-replace |
| Phase 3 | CSS consolidation | 4–5 days | Requires per-file class mapping |
| Phase 4 | JS consolidation | 3–4 days | Requires inline script audit |
| Phase 5 | Security fixes (8 CRITICAL + 12 HIGH) | 7–10 days | Each fix needs testing |
| Phase 6 | jQuery 3.7 upgrade + framework patches | 3–5 days | Risk: Yii plugin compat |
| Phase 7 | Final cleanup + QA | 3–4 days | Full 50-item QA matrix |
| **Total** | | **29–41 days (6–8 weeks)** | 1–2 developers + 1 QA |

---

## 2. Current State Analysis

### 2.1 Frontend Stack (As-Is)

| Component | Version | Location | Status |
|-----------|---------|----------|--------|
| AdminLTE | 3.x | `themes/erp/dist/` (14 MB) | **To remove** |
| Bootstrap | 4.x (bundled with AdminLTE) | `themes/erp/plugins/bootstrap/` | **To replace** |
| jQuery | 3.5.1 (AdminLTE) | `themes/erp/plugins/jquery/` | **To upgrade** |
| jQuery | 1.12.4 (Yii core) | `framework/web/js/source/` | **To override** |
| Font Awesome | 4.7.0 | `themes/erp/font-awesome/` | **To replace** (main layout) |
| Font Awesome | 6.0 | `themes/erp/plugins/fontawesome-free/` | **To keep** (login layout) |
| Blueprint CSS | 1.0.1 | `css/screen.css`, `css/main.css`, etc. | **To remove** (dead code) |
| EBootstrap Extension | n/a | `protected/extensions/bootstrap/` | **To remove** (zero usage) |
| Ionicons | n/a | `themes/erp/css/ionicons.min.css` | **Keep as-is** |

### 2.2 AdminLTE Plugin Inventory (57 Total)

**8 plugins actively used:**

| Plugin | Used In | Replacement Strategy |
|--------|---------|---------------------|
| `bootstrap` | main.php, login.php | Replace with Bootstrap 5.3 standalone |
| `jquery` | main.php | Replace with jQuery 3.7.x standalone |
| `toastr` | main.php | Keep — jQuery plugin, BS-independent |
| `moment` | main.php | Keep — standalone library |
| `inputmask` | main.php | Keep — jQuery plugin, BS-independent |
| `bootstrap-switch` | main.php | Replace with BS5 form-check/form-switch |
| `fontawesome-free` | login.php | Move to standalone FA6, use for all layouts |
| `icheck-bootstrap` | login.php | Replace with BS5 native form-check |
| `bs-custom-file-input` | prodModels/_form.php, _form2.php | Replace with BS5 native file input |
| `chart.js` | site/chart.php | Keep — standalone library |

**49 plugins NOT used anywhere — to delete:**

bootstrap-colorpicker, bootstrap-slider, bootstrap4-duallistbox, bs-stepper, codemirror, datatables (+ 10 datatables-* variants), daterangepicker, dropzone, ekko-lightbox, fastclick, filterizr, flag-icon-css, flot, fullcalendar, ion-rangeslider, jquery-knob, jquery-mapael, jquery-mousewheel, jquery-ui (using local copy instead), jquery-validation, jqvmap, jsgrid, jszip, overlayScrollbars, pace-progress, pdfmake, popper, raphael, select2, select2-bootstrap4-theme, sparklines, summernote, sweetalert2, sweetalert2-theme-bootstrap-4, tempusdominus-bootstrap-4, uplot

### 2.3 Codebase Impact Metrics

| Metric | Count | Files Affected |
|--------|-------|----------------|
| Total PHP view files | 346 | — |
| `card-*` class usage | 1,969 | 205 |
| `form-control` / `form-group` / `input-group` | 762 | 81 |
| `col-*` grid classes | 614 | 120 |
| Modal components | 616 | 74 |
| `btn-*` classes | 345 | 157 |
| `data-toggle` / `data-dismiss` / `data-target` | 378 | 101 |
| `badge` / `label` classes | 358 | 80 |
| `alert-*` classes | 112 | 87 |
| jQuery usage patterns | 586 | 206 |
| `ml-*` / `mr-*` / `pl-*` / `pr-*` utilities | 191 | 38 |
| `text-right` / `text-left` / `float-left` / `float-right` | 300 | 70 |
| Inline `<style>` blocks | — | 67 |
| Inline `<script>` blocks | — | 75 |
| Font Awesome icon references | 550 | 89 |
| Dropdown components | 142 | 2 |

### 2.4 Layout Files

| Layout | Path | Role |
|--------|------|------|
| main.php | `themes/erp/views/layouts/main.php` | Master layout — loads ALL global CSS/JS |
| login.php | `themes/erp/views/layouts/login.php` | Login page — separate asset loading |
| column1.php | `themes/erp/views/layouts/column1.php` | Single-column content + footer |
| column2.php | `themes/erp/views/layouts/column2.php` | Sidebar content layout |
| column3.php | `themes/erp/views/layouts/column3.php` | Alternate layout |
| column_rights.php | `themes/erp/views/layouts/column_rights.php` | Rights module layout |

---

## 3. Scope of Changes

### 3.1 Assets to Remove

| Asset | Path | Size |
|-------|------|------|
| AdminLTE dist (CSS/JS/images) | `themes/erp/dist/` | 14 MB |
| AdminLTE plugins (all 57 dirs) | `themes/erp/plugins/` | 56 MB |
| EBootstrap extension (dead code) | `protected/extensions/bootstrap/` | ~500 KB |
| Font Awesome 4.7.0 | `themes/erp/font-awesome/` | ~2 MB |
| Blueprint CSS - screen.css | `css/screen.css` | 13 KB |
| Blueprint CSS - main.css | `css/main.css` | 3 KB |
| Blueprint CSS - default.css | `css/default.css` | 4 KB |
| Blueprint CSS - form.css | `css/form.css` | 3 KB |
| Blueprint CSS - ie.css | `css/ie.css` | 2 KB |
| Blueprint CSS - bg.gif | `css/bg.gif` | 243 B |
| Dead breadcrumb CSS | `themes/erp/css/breadcumb.css` | 49 B |
| Layout legacy CSS | `themes/erp/css/layout-old.css` | 28 KB |
| jQuery UI old CSS | `themes/erp/css/jquery-ui-old.css` | 25 KB |
| **Total removal** | | **~72 MB** |

### 3.2 Assets to Add

| Asset | Target Path | Size (approx) |
|-------|-------------|---------------|
| Bootstrap 5.3.x CSS | `themes/erp/vendor/bootstrap5/css/bootstrap.min.css` | ~230 KB |
| Bootstrap 5.3.x JS bundle | `themes/erp/vendor/bootstrap5/js/bootstrap.bundle.min.js` | ~80 KB |
| jQuery 3.7.x | `themes/erp/vendor/jquery/jquery.min.js` | ~90 KB |
| Font Awesome 6.x (all) | `themes/erp/vendor/fontawesome6/` | ~2 MB |
| **Total addition** | | **~2.4 MB** |

### 3.3 Assets to Relocate (from plugins/ to vendor/)

These are currently inside `themes/erp/plugins/` and must be moved to a clean `themes/erp/vendor/` directory:

| Library | Current Path | New Path |
|---------|------------|----------|
| Toastr | `plugins/toastr/` | `vendor/toastr/` |
| Moment.js | `plugins/moment/` | `vendor/moment/` |
| Inputmask | `plugins/inputmask/` | `vendor/inputmask/` |
| Chart.js | `plugins/chart.js/` | `vendor/chartjs/` |

### 3.4 Assets to Keep Unchanged

| Asset | Path | Reason |
|-------|------|--------|
| custom.css | `themes/erp/css/custom.css` | Indigo theme overrides — update selectors only |
| layout.css | `themes/erp/css/layout.css` | Structural layout — update selectors only |
| print.css | `css/print.css` | Print-specific, no BS dependency |
| jQuery UI | `themes/erp/js/jquery-ui.js` + `themes/erp/css/jquery-ui.css` | Local copy, not from plugins |
| Lightpick | `themes/erp/js/lightpick.js` + `themes/erp/css/lightpick.css` | Date picker, BS-independent |
| Alertify | `themes/erp/js/alertify.js` | Alert dialogs, BS-independent |
| as-min.js | `themes/erp/js/as-min.js` | Autocomplete, BS-independent |
| Ionicons | `themes/erp/css/ionicons.min.css` | Icon font, BS-independent |
| Dropzone | `themes/erp/js/dropzone.min.js` + `themes/erp/css/dropzone.min.css` | File upload, BS-independent |

---

## 4. Functional Requirements

### FR-1: Layout Asset Loading

**FR-1.1** — `main.php` SHALL load the following assets in this order:
1. Font Awesome 6 CSS
2. Ionicons CSS
3. Toastr CSS
4. jQuery UI CSS
5. Bootstrap 5.3 CSS
6. Lightpick CSS
7. `custom.css` (with filemtime cache-busting)
8. jQuery 3.7.x JS
9. jQuery UI JS
10. Alertify JS
11. Bootstrap 5.3 Bundle JS (includes Popper)
12. Moment JS
13. Inputmask JS
14. Toastr JS
15. Lightpick JS
16. as-min.js

**FR-1.2** — `main.php` SHALL NOT load `adminlte.min.css`, `adminlte.min.js`, or `bootstrap-switch.js`.

**FR-1.3** — `main.php` body tag SHALL NOT use AdminLTE classes (`hold-transition`, `layout-top-nav`).

**FR-1.4** — `login.php` SHALL load Bootstrap 5.3 CSS/JS and Font Awesome 6 CSS. SHALL NOT load AdminLTE CSS/JS or `icheck-bootstrap`.

**FR-1.5** — Yii's core jQuery SHALL be overridden via `clientScript.scriptMap` in `protected/config/main.php` to point to jQuery 3.7.x, preventing double-loading of jQuery 1.12.4.

**FR-1.6** — Toastr CSS SHALL be loaded only once (currently loaded twice in main.php — deduplicate).

### FR-2: Bootstrap Data Attribute Migration

**FR-2.1** — All `data-toggle` attributes SHALL be changed to `data-bs-toggle` across all 101 affected files.

**FR-2.2** — All `data-dismiss` attributes SHALL be changed to `data-bs-dismiss`.

**FR-2.3** — All `data-target` attributes SHALL be changed to `data-bs-target`.

**FR-2.4** — All `data-backdrop` attributes SHALL be changed to `data-bs-backdrop`.

**FR-2.5** — All `data-ride` attributes SHALL be changed to `data-bs-ride`.

### FR-3: CSS Class Migration

**FR-3.1** — `form-group` (108 occurrences) SHALL be replaced with `mb-3`.

**FR-3.2** — `btn-default` SHALL be replaced with `btn-secondary`.

**FR-3.3** — Directional utility classes SHALL be updated:
| BS4 Class | BS5 Class |
|-----------|-----------|
| `ml-*` | `ms-*` |
| `mr-*` | `me-*` |
| `pl-*` | `ps-*` |
| `pr-*` | `pe-*` |
| `float-left` | `float-start` |
| `float-right` | `float-end` |
| `text-left` | `text-start` |
| `text-right` | `text-end` |

**FR-3.4** — `input-group-append` and `input-group-prepend` SHALL be removed (flattened in BS5 — children go directly inside `.input-group`).

**FR-3.5** — `.close` dismiss buttons SHALL be replaced with `.btn-close`.

**FR-3.6** — `label label-*` (Bootstrap 3 remnants) SHALL be replaced with `badge bg-*` (BS5 badge syntax).

**FR-3.7** — `badge-*` color classes SHALL be replaced with `bg-*` utility classes (e.g., `badge badge-success` → `badge bg-success`).

**FR-3.8** — `btn-block` SHALL be replaced with `d-grid` wrapper + `w-100` on the button, or `d-grid gap-2` parent pattern.

**FR-3.9** — Card classes (`card`, `card-header`, `card-body`, `card-footer`, `card-title`) SHALL remain unchanged — these are native Bootstrap 5 classes and are forward-compatible.

**FR-3.10** — Grid classes (`col-*`, `row`, `container`, `container-fluid`) SHALL remain unchanged — these are forward-compatible in BS5.

**FR-3.11** — Modal classes (`modal`, `modal-dialog`, `modal-content`, `modal-header`, `modal-body`, `modal-footer`) SHALL remain unchanged — these are forward-compatible in BS5 (only data attributes change).

### FR-4: Component Replacements

**FR-4.1 — bootstrap-switch → BS5 form-switch**

All `bootstrap-switch` initializations (`$(...).bootstrapSwitch()`) SHALL be replaced with BS5 native form-switch markup:
```html
<!-- Before -->
<input type="checkbox" data-bootstrap-switch>

<!-- After -->
<div class="form-check form-switch">
  <input class="form-check-input" type="checkbox" role="switch">
  <label class="form-check-label">...</label>
</div>
```

**FR-4.2 — icheck-bootstrap → BS5 form-check**

Login page checkbox styling SHALL use BS5 native `form-check`:
```html
<!-- Before -->
<div class="icheck-primary">
  <input type="checkbox" id="remember">
  <label for="remember">Remember Me</label>
</div>

<!-- After -->
<div class="form-check">
  <input class="form-check-input" type="checkbox" id="remember">
  <label class="form-check-label" for="remember">Remember Me</label>
</div>
```

**FR-4.3 — bs-custom-file-input → BS5 native file input**

Product model form file inputs SHALL use BS5 native file input:
```html
<!-- Before -->
<div class="custom-file">
  <input type="file" class="custom-file-input">
  <label class="custom-file-label">Choose file</label>
</div>
<script>bsCustomFileInput.init()</script>

<!-- After -->
<input class="form-control" type="file">
```

### FR-5: Font Awesome Unification

**FR-5.1** — All layouts SHALL load Font Awesome 6 from `themes/erp/vendor/fontawesome6/css/all.min.css`.

**FR-5.2** — Font Awesome 4 icon syntax SHALL be updated where incompatible:
| FA4 Syntax | FA6 Syntax | Notes |
|------------|------------|-------|
| `fa fa-*` | `fas fa-*` or `fa-solid fa-*` | Most icons migrate directly |
| `fa fa-code-fork` | `fas fa-code-branch` | Renamed icon |
| `fa fa-*` (general) | Check per icon | Some icons moved to `far` (regular) |

**FR-5.3** — Font Awesome 4.7.0 directory (`themes/erp/font-awesome/`) SHALL be deleted after migration.

**FR-5.4** — All 550 icon references across 89 files SHALL be audited and updated for FA6 compatibility.

### FR-6: JavaScript API Changes

**FR-6.1** — Bootstrap 5 drops jQuery dependency. All programmatic Bootstrap calls using jQuery syntax SHALL be updated:

```javascript
// Before (BS4 + jQuery)
$('#myModal').modal('show');
$('[data-toggle="tooltip"]').tooltip();

// After (BS5 vanilla JS)
var modal = new bootstrap.Modal(document.getElementById('myModal'));
modal.show();
// OR use data attributes (preferred for simple cases)
```

**FR-6.2** — However, since jQuery 3.7.x is still loaded for Yii widgets and custom code, a **compatibility approach** is acceptable: Bootstrap 5 can coexist with jQuery. The requirement is that Bootstrap's own JS API is called via the BS5 vanilla API, not via jQuery plugin syntax.

**FR-6.3** — jQuery `.modal()`, `.tooltip()`, `.popover()`, `.dropdown()`, `.collapse()` calls (96 occurrences across 66 files) SHALL be migrated to BS5 vanilla JS API.

### FR-7: UserMenu.php Navigation

**FR-7.1** — UserMenu SHALL update all `data-toggle` to `data-bs-toggle` and `data-target` to `data-bs-target`.

**FR-7.2** — `ml-auto` class SHALL be changed to `ms-auto`.

**FR-7.3** — Mobile hamburger toggle SHALL be verified working with BS5 collapse API.

**FR-7.4** — All existing dark theme tokens (defined in CLAUDE.md) SHALL be preserved exactly — the visual appearance must not change.

### FR-8: Yii Widget Compatibility

**FR-8.1** — `CGridView` SHALL render correctly with BS5. Grid view CSS in `themes/erp/css/gridview/` SHALL be updated if needed.

**FR-8.2** — `CActiveForm` error message display SHALL render correctly with BS5. The `.errorMessage`, `.errorSummary` classes SHALL be styled consistently.

**FR-8.3** — `CLinkPager` pagination output SHALL be styled using BS5 pagination classes. If Yii generates incompatible markup, a CSS bridge SHALL be added to `custom.css`.

**FR-8.4** — `CDetailView` SHALL render correctly. Detail view CSS in `themes/erp/css/detailview/` SHALL be updated if needed.

### FR-9: Custom CSS Updates

**FR-9.1** — `themes/erp/css/custom.css` SHALL be updated to:
- Remove any AdminLTE-specific overrides that are no longer needed
- Update any BS4-specific selectors to BS5 equivalents
- Preserve the indigo theme colors (#4f46e5, #6366f1, #6b7280)
- Preserve all custom component styles (action buttons, grid view, pagination, form focus rings)

**FR-9.2** — `themes/erp/css/layout.css` SHALL be updated to:
- Remove AdminLTE layout-dependent selectors
- Update wrapper classes if needed
- Preserve structural layout behavior

### FR-10: Dead Code Removal

**FR-10.1** — `protected/extensions/bootstrap/` (25+ EBootstrap widget classes) SHALL be deleted entirely — zero usage detected in any view file.

**FR-10.2** — Any `import` or `application.extensions.bootstrap.*` references in `protected/config/main.php` SHALL be removed.

**FR-10.3** — Legacy Blueprint CSS files SHALL be deleted: `css/screen.css`, `css/main.css`, `css/default.css`, `css/form.css`, `css/ie.css`, `css/bg.gif`.

**FR-10.4** — Dead theme CSS files SHALL be deleted: `themes/erp/css/breadcumb.css`, `themes/erp/css/layout-old.css`, `themes/erp/css/jquery-ui-old.css`.

**FR-10.5** — AdminLTE demo/sample files SHALL be deleted: `themes/erp/dist/js/demo.js`, `themes/erp/dist/js/pages/`.

---

## 5. Non-Functional Requirements

### NFR-1: Performance

**NFR-1.1** — Total CSS payload SHALL decrease. Removing AdminLTE CSS (723 KB) and adding BS5 CSS (~230 KB) results in a net reduction of ~493 KB.

**NFR-1.2** — Total JS payload SHALL decrease. Removing AdminLTE JS (40 KB) + Bootstrap 4 bundle (~80 KB) and adding BS5 bundle (~80 KB) + jQuery 3.7 (~90 KB, replacing 3.5.1 at ~87 KB) results in a net reduction of ~37 KB.

**NFR-1.3** — Total static asset size SHALL decrease from ~72 MB (plugins + dist) to ~2.4 MB (vendor), a **97% reduction**.

### NFR-2: Compatibility

**NFR-2.1** — All changes SHALL be compatible with PHP 8.x.

**NFR-2.2** — All changes SHALL work in current versions of Chrome, Firefox, Safari, and Edge.

**NFR-2.3** — All changes SHALL maintain compatibility with Yii 1.x framework JavaScript (yii.js, yiiactiveform.js, yiigridview.js).

**NFR-2.4** — Print stylesheets (`css/print.css`, inline print styles) SHALL continue to function correctly.

### NFR-3: Maintainability

**NFR-3.1** — All third-party libraries SHALL be in `themes/erp/vendor/` with clear version identification.

**NFR-3.2** — No AdminLTE classes or references SHALL remain in the codebase after migration.

**NFR-3.3** — Font Awesome SHALL use a single version (6.x) across all layouts.

---

## 6. Migration Phases

### Phase 0: Cleanup Dead Code

**Priority:** Do first — zero risk, reduces noise for subsequent phases.

| Task | Files | Risk |
|------|-------|------|
| Delete `protected/extensions/bootstrap/` | ~25 files | None (zero usage) |
| Remove EBootstrap import from `protected/config/main.php` | 1 file | Low |
| Delete legacy Blueprint CSS (`css/screen.css`, `css/main.css`, `css/default.css`, `css/form.css`, `css/ie.css`, `css/bg.gif`) | 6 files | None (unused) |
| Delete dead theme CSS (`breadcumb.css`, `layout-old.css`, `jquery-ui-old.css`) | 3 files | None (unused) |

### Phase 1: Add New Assets, Update Layouts

**Priority:** Foundation — everything else depends on this.

| Task | Files | Risk |
|------|-------|------|
| Download Bootstrap 5.3.x to `themes/erp/vendor/bootstrap5/` | New files | None |
| Download jQuery 3.7.x to `themes/erp/vendor/jquery/` | New file | None |
| Download Font Awesome 6.x to `themes/erp/vendor/fontawesome6/` | New files | None |
| Move used plugins (toastr, moment, inputmask, chart.js) to `themes/erp/vendor/` | 4 dirs | Low |
| Update `main.php` layout — swap all CSS/JS links | 1 file | High |
| Update `login.php` layout — swap all CSS/JS links | 1 file | High |
| Configure `clientScript.scriptMap` in `protected/config/main.php` | 1 file | Medium |
| Remove AdminLTE body classes from layouts | 2 files | Medium |
| Deduplicate toastr CSS load | 1 file | None |

### Phase 2: Global Data Attribute Migration

**Priority:** Required for any BS5 JS-driven component to work.

| Task | Occurrences | Files | Risk |
|------|-------------|-------|------|
| `data-toggle` → `data-bs-toggle` | ~200 | ~101 | Medium |
| `data-dismiss` → `data-bs-dismiss` | ~80 | ~40 | Medium |
| `data-target` → `data-bs-target` | ~80 | ~40 | Medium |
| `data-backdrop` → `data-bs-backdrop` | ~10 | ~5 | Low |
| `data-ride` → `data-bs-ride` | ~8 | ~3 | Low |

### Phase 3: CSS Class Migration

**Priority:** Required for visual correctness.

| Task | Occurrences | Files | Risk |
|------|-------------|-------|------|
| `form-group` → `mb-3` | ~108 | ~50 | Medium |
| `btn-default` → `btn-secondary` | ~20 | ~15 | Low |
| `ml-*` → `ms-*` | ~40 | ~20 | Low |
| `mr-*` → `me-*` | ~40 | ~20 | Low |
| `pl-*` → `ps-*` | ~20 | ~10 | Low |
| `pr-*` → `pe-*` | ~20 | ~10 | Low |
| `float-left` → `float-start` | ~15 | ~10 | Low |
| `float-right` → `float-end` | ~15 | ~10 | Low |
| `text-left` → `text-start` | ~30 | ~15 | Low |
| `text-right` → `text-end` | ~50 | ~25 | Low |
| `input-group-append/prepend` → remove wrapper | ~30 | ~15 | Medium |
| `label label-*` → `badge bg-*` | ~80 | ~40 | Low |
| `badge-*` → `bg-*` | ~50 | ~30 | Low |
| `.close` → `.btn-close` | ~40 | ~20 | Low |
| `btn-block` → `d-grid` / `w-100` | ~10 | ~8 | Low |

### Phase 4: Component Replacements

**Priority:** Required for specific features.

| Task | Occurrences | Files | Risk |
|------|-------------|-------|------|
| Replace `bootstrap-switch` init with BS5 `form-switch` | ~15 | ~10 | Medium |
| Replace `icheck-bootstrap` with BS5 `form-check` | ~3 | 1 | Low |
| Replace `bs-custom-file-input` with BS5 file input | ~4 | 2 | Low |
| Migrate Bootstrap jQuery plugin calls to BS5 vanilla API | ~96 | ~66 | High |

### Phase 5: Font Awesome Migration

**Priority:** Required for icon rendering.

| Task | Occurrences | Files | Risk |
|------|-------------|-------|------|
| Audit all 550 FA icon refs for FA6 compatibility | 550 | 89 | Medium |
| Update renamed icons (e.g., `fa-code-fork` → `fa-code-branch`) | ~20 | ~15 | Low |
| Update class prefix where needed (`fa fa-*` → `fas fa-*`) | ~530 | ~89 | Medium |

### Phase 6: Custom CSS & Yii Widget Fixes

**Priority:** Polish and edge cases.

| Task | Files | Risk |
|------|-------|------|
| Update `custom.css` — remove AdminLTE overrides, update BS5 selectors | 1 | Medium |
| Update `layout.css` — remove AdminLTE layout dependencies | 1 | Medium |
| Style CLinkPager pagination for BS5 | 1 | Medium |
| Verify CGridView rendering | Test | Low |
| Verify CActiveForm error display | Test | Low |
| Verify CDetailView rendering | Test | Low |
| Update UserMenu.php data attributes and utility classes | 1 | Medium |

### Phase 7: Full Cleanup

**Priority:** After everything works.

| Task | Size | Risk |
|------|------|------|
| Delete `themes/erp/dist/` (entire AdminLTE dist) | 14 MB | None (no longer referenced) |
| Delete `themes/erp/plugins/` (entire plugins dir) | 56 MB | None (all used libs moved to vendor/) |
| Delete `themes/erp/font-awesome/` (FA 4.7) | ~2 MB | None (replaced by FA 6) |

---

## 7. File-Level Change Inventory

### 7.1 Configuration Files

| File | Change Type | Details |
|------|-------------|---------|
| `protected/config/main.php` | Modify | Add `clientScript.scriptMap` for jQuery override; remove EBootstrap import |

### 7.2 Layout Files (All Modified)

| File | Change Type |
|------|-------------|
| `themes/erp/views/layouts/main.php` | Major rewrite — all asset links |
| `themes/erp/views/layouts/login.php` | Major rewrite — all asset links |
| `themes/erp/views/layouts/column1.php` | Minor — verify footer classes |
| `themes/erp/views/layouts/column2.php` | Minor — verify wrapper classes |

### 7.3 View Files by Module (Estimated Changes)

| Module/Area | View Files | data-attr changes | CSS class changes | JS API changes |
|-------------|-----------|-------------------|-------------------|----------------|
| `themes/erp/views/site/` | ~20 | Yes | Yes | Yes (dashboard) |
| `themes/erp/views/prodModels/` | ~8 | Yes | Yes | Yes (file input) |
| `themes/erp/views/prodItems/` | ~8 | Yes | Yes | Minor |
| `themes/erp/views/manufacturers/` | ~6 | Yes | Yes | Minor |
| `themes/erp/views/units/` | ~4 | Yes | Yes | Minor |
| `themes/erp/views/report/` | ~15 | Yes | Yes | Minor |
| `sell` module views | ~40 | Yes | Yes | Yes (modals) |
| `commercial` module views | ~30 | Yes | Yes | Yes (modals) |
| `accounting` module views | ~35 | Yes | Yes | Yes (modals) |
| `inventory` module views | ~20 | Yes | Yes | Minor |
| `user` module views | ~10 | Yes | Yes | Minor |
| `rights` module views | ~8 | Minor | Minor | Minor |
| `loan` module views | ~8 | Yes | Yes | Minor |

### 7.4 Component Files

| File | Change Type |
|------|-------------|
| `protected/components/views/UserMenu.php` | Modify — data attributes, `ml-auto` → `ms-auto` |

### 7.5 Custom CSS Files

| File | Change Type |
|------|-------------|
| `themes/erp/css/custom.css` | Modify — update selectors for BS5 |
| `themes/erp/css/layout.css` | Modify — remove AdminLTE dependencies |

---

## 8. Class Migration Reference

### 8.1 Data Attributes (Find → Replace)

```
data-toggle="modal"      →  data-bs-toggle="modal"
data-toggle="dropdown"   →  data-bs-toggle="dropdown"
data-toggle="collapse"   →  data-bs-toggle="collapse"
data-toggle="tab"        →  data-bs-toggle="tab"
data-toggle="tooltip"    →  data-bs-toggle="tooltip"
data-toggle="popover"    →  data-bs-toggle="popover"
data-dismiss="modal"     →  data-bs-dismiss="modal"
data-dismiss="alert"     →  data-bs-dismiss="alert"
data-target="..."        →  data-bs-target="..."
data-backdrop="..."      →  data-bs-backdrop="..."
data-ride="..."          →  data-bs-ride="..."
```

### 8.2 CSS Classes (Find → Replace)

```
form-group               →  mb-3
btn-default              →  btn-secondary
btn-block                →  w-100 (+ d-grid on parent if needed)
ml-auto                  →  ms-auto
ml-1, ml-2, ml-3...     →  ms-1, ms-2, ms-3...
mr-auto                  →  me-auto
mr-1, mr-2, mr-3...     →  me-1, me-2, me-3...
pl-1, pl-2, pl-3...     →  ps-1, ps-2, ps-3...
pr-1, pr-2, pr-3...     →  pe-1, pe-2, pe-3...
float-left               →  float-start
float-right              →  float-end
text-left                →  text-start
text-right               →  text-end
input-group-append       →  (remove wrapper, keep children in input-group)
input-group-prepend      →  (remove wrapper, keep children in input-group)
label label-default      →  badge bg-secondary
label label-primary      →  badge bg-primary
label label-success      →  badge bg-success
label label-info         →  badge bg-info
label label-warning      →  badge text-dark bg-warning
label label-danger       →  badge bg-danger
badge-primary            →  bg-primary
badge-success            →  bg-success
badge-danger             →  bg-danger
badge-warning            →  bg-warning text-dark
badge-info               →  bg-info
badge-secondary          →  bg-secondary
close                    →  btn-close
custom-file-input        →  form-control (type="file")
custom-file-label        →  (remove)
custom-file              →  (remove wrapper)
```

### 8.3 JavaScript API Migration

```javascript
// Modal
$('#x').modal('show')          →  bootstrap.Modal.getOrCreateInstance(el).show()
$('#x').modal('hide')          →  bootstrap.Modal.getOrCreateInstance(el).hide()
$('#x').modal('toggle')        →  bootstrap.Modal.getOrCreateInstance(el).toggle()

// Tooltip
$('[data-toggle="tooltip"]').tooltip()  →  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el))

// Collapse
$('#x').collapse('show')       →  bootstrap.Collapse.getOrCreateInstance(el).show()
$('#x').collapse('hide')       →  bootstrap.Collapse.getOrCreateInstance(el).hide()

// Dropdown
$('#x').dropdown('toggle')     →  bootstrap.Dropdown.getOrCreateInstance(el).toggle()

// Tab
$('#x').tab('show')            →  bootstrap.Tab.getOrCreateInstance(el).show()

// Events
$('#x').on('shown.bs.modal')   →  el.addEventListener('shown.bs.modal', ...)  // Same event names
$('#x').on('hidden.bs.modal')  →  el.addEventListener('hidden.bs.modal', ...)
```

### 8.4 Font Awesome Icon Renames (FA4 → FA6)

```
fa fa-code-fork           →  fas fa-code-branch
fa fa-arrow-circle-*      →  fas fa-circle-arrow-*
fa fa-pencil              →  fas fa-pencil (or fa-pen)
fa fa-remove / fa-close   →  fas fa-xmark
fa fa-warning             →  fas fa-triangle-exclamation
fa fa-calendar            →  fas fa-calendar (compatible) / far fa-calendar
fa fa-file-text-o         →  far fa-file-lines
fa fa-money               →  fas fa-money-bill
fa fa-*                   →  fas fa-* (default — most map directly)
```

> **Note:** Most `fa fa-*` icons work in FA6 by changing to `fas fa-*`. Only renamed icons need individual attention. A full compatibility check of all 550 references is required during Phase 5.

---

## 9. Risk Assessment

### 9.1 Risk Matrix

| Risk | Likelihood | Impact | Severity | Mitigation |
|------|-----------|--------|----------|------------|
| Modals stop opening/closing | High (if data-attrs missed) | High | **Critical** | Phase 2 global find-replace; test every modal |
| Dropdowns stop working | High (if data-attrs missed) | High | **Critical** | Phase 2 global find-replace; test UserMenu |
| Form layouts break (form-group removal) | Medium | Medium | **High** | `mb-3` is direct equivalent; visual test all forms |
| CLinkPager pagination unstyled | High | Low | **Medium** | CSS bridge in custom.css |
| jQuery conflict (dual version load) | Medium | High | **High** | scriptMap override; test Yii AJAX forms |
| Bootstrap-switch features broken | Medium | Medium | **Medium** | Direct BS5 form-switch replacement |
| FA icons missing/wrong | Medium | Low | **Medium** | Audit all 550 refs; FA6 has shim layer |
| jQuery upgrade breaks Yii plugins | Medium | High | **Medium** | Yii framework jQuery plugins may use `.live()`, `.die()`, `.size()` removed in jQuery 3; requires audit of all 13+ plugins |
| CGridView sort/filter JS breaks | Low | High | **Medium** | Yii JS uses its own event handlers, not BS |
| Print layouts break | Low | Medium | **Low** | Print CSS is BS-independent |
| Inline styles conflict with BS5 resets | Low | Medium | **Low** | 67 files have inline styles; most are self-contained |

### 9.2 Rollback Strategy

Each phase SHALL be committed separately, allowing targeted rollback:
- Phase 0: Independent, no rollback needed
- Phase 1: Can revert layout changes to restore AdminLTE loading
- Phase 2–6: Individual commits per phase, revertable independently
- Phase 7: Only executed after full validation; restoring deleted files from git if needed

---

## 10. Acceptance Criteria

### AC-1: Zero AdminLTE References

- [ ] `grep -r "adminlte" themes/erp/` returns zero results
- [ ] `grep -r "AdminLTE" themes/erp/` returns zero results
- [ ] `themes/erp/dist/` directory does not exist
- [ ] `themes/erp/plugins/` directory does not exist
- [ ] `hold-transition` class not used in any layout
- [ ] `layout-top-nav` class not used in any layout

### AC-2: Bootstrap 5 Loaded Correctly

- [ ] Browser DevTools shows Bootstrap 5.3.x CSS loaded
- [ ] Browser DevTools shows Bootstrap 5.3.x JS bundle loaded
- [ ] No Bootstrap 4 CSS or JS files loaded
- [ ] `bootstrap` object available in browser console with BS5 API

### AC-3: jQuery Correct Version

- [ ] `jQuery.fn.jquery` in browser console returns `3.7.x`
- [ ] Only one jQuery version loaded (no 1.12.4 duplicate)
- [ ] Yii AJAX features (CGridView filter, CActiveForm validation) work correctly

### AC-4: Font Awesome Unified

- [ ] Only Font Awesome 6 CSS loaded in all layouts
- [ ] No broken/missing icons on any page
- [ ] `themes/erp/font-awesome/` directory does not exist

### AC-5: All UI Components Functional

- [ ] All modals open and close correctly (74 files with modals)
- [ ] All dropdowns function (UserMenu, report shortcuts)
- [ ] All forms submit correctly with validation
- [ ] All CGridView tables render with sorting and filtering
- [ ] All pagination links work
- [ ] All alert/flash messages display and auto-dismiss
- [ ] All badges/labels display with correct colors
- [ ] All tooltips display (if any)
- [ ] Bootstrap switches replaced with working form-switches
- [ ] File upload inputs work in product model forms
- [ ] Login page renders correctly with form-check
- [ ] Dashboard renders with all cards, stats, and charts
- [ ] Report filter forms work with Lightpick date pickers
- [ ] Print views render correctly (vouchers, invoices, reports)
- [ ] Mobile hamburger menu toggles correctly

### AC-6: Performance

- [ ] Total frontend asset size reduced by >90% (from ~72 MB to <5 MB)
- [ ] No 404 errors in browser console for CSS/JS resources
- [ ] Page load time not degraded

### AC-7: Dead Code Removed

- [ ] `protected/extensions/bootstrap/` does not exist
- [ ] No Blueprint CSS files in `css/` directory
- [ ] No `breadcumb.css`, `layout-old.css`, `jquery-ui-old.css` files
- [ ] No unused plugin directories

---

---

## 11. CSS Consolidation

### 11.1 Problem Statement

67 of 154 view files (43.5%) contain inline `<style>` blocks totaling ~3,738 lines of CSS. Analysis reveals **79% of this CSS is duplicated** across files with only class-prefix changes (e.g., `.co-card` vs `.pb-card` vs `.pi-card` — identical styles, different prefixes).

### 11.2 Duplication Analysis

| Pattern | Files Affected | Inline Lines | Consolidated Lines | Savings |
|---------|---------------|-------------|-------------------|---------|
| Floating-label form cards | 14 | 1,148 | 200 | 82% |
| Report table styling | 20 | 1,120 | 150 | 86% |
| Admin grid view styling | 14 | 840 | 120 | 86% |
| Dashboard/alert cards | 5 | 350 | 200 | 43% |
| Login/misc styles | 14 | 280 | 100 | 64% |
| **Total** | **67** | **3,738** | **770** | **79%** |

### 11.3 Duplicated Pattern Details

#### A) Floating-Label Form Card Styles (14 files)

**Affected files:**
- `themes/erp/views/companies/_form.php`, `_form2.php`
- `themes/erp/views/prodBrands/_form.php`, `_form2.php`, `_form3.php`
- `themes/erp/views/prodItems/_form.php`, `_form2.php`
- `themes/erp/views/prodModels/_form.php`, `_form2.php`
- `themes/erp/views/units/_form.php`, `_form2.php`, `_form3.php`
- `themes/erp/views/users/_form.php`, `_form2.php`

**Repeated CSS per file (~82 lines each):**
- `.XX-card` — card container with shadow and border-radius
- `.XX-card-header` — gradient header (`linear-gradient(135deg, #4f46e5, #7c3aed)`)
- `.XX-card-header::before` — decorative dot-grid overlay
- `.XX-card-header .XX-orb` — decorative circle element
- `.XX-fl` — floating-label wrapper
- `.XX-fl-input` — input styling with absolute-positioned icon
- `.XX-fl-label` — animated label (transform on focus/filled)
- `.XX-fl-icon` — icon positioning inside input
- `.XX-error` — error text color
- `.XX-card-footer` — footer background and border
- `.XX-submit` — gradient submit button with hover shadow
- `.XX-ripple` — ripple animation keyframes

**All 14 files use identical CSS — only the prefix changes.** Colors, dimensions, animations, transitions are 100% identical.

#### B) Report Table Styles (20 files)

**Affected files:** All `themes/erp/views/report/*View.php` files

**Repeated CSS per file (~56 lines each):**
- `.report-card` — card container
- `.summaryTab` — table base with border-collapse
- `.summaryTab thead th` — dark header (#212529), white text, sticky positioning
- `.summaryTab tbody tr:nth-child(even)` — striped rows (#f8f9fa)
- `.summaryTab tbody tr:hover` — hover highlight
- `.summaryTab tfoot td` — total row bold styling
- Print `@media` overrides
- Sticky header clone styles

**Variations:** 8 newer reports use a consistent modern style; 12 older reports have slight inconsistencies (background colors, padding) that should be standardized.

#### C) Admin Grid View Styles (14 files)

**Affected files:** All `*/admin.php` views across entities

**Repeated CSS per file (~60 lines each):**
- Grid header gradient and title styling
- Filter row input/select styling
- Pagination button styling (overlap with `custom.css`)
- Action button colors (view, edit, delete)
- Responsive table wrapper

### 11.4 New Shared CSS Files

The following new CSS files SHALL be created to replace inline styles:

#### FR-CSS-1: `themes/erp/css/form-components.css` (~200 lines)

**Purpose:** Unified floating-label form card system

**Requirements:**
- Use generic `.frm-` prefix (replacing all entity-specific prefixes)
- Define CSS custom properties for theming:
  ```css
  :root {
    --frm-accent: #4f46e5;
    --frm-accent-end: #7c3aed;
    --frm-shadow: 0 4px 6px rgba(0,0,0,.04), 0 12px 36px rgba(0,0,0,.10);
    --frm-footer-bg: #f8fafc;
    --frm-footer-border: #f1f5f9;
    --frm-error: #ef4444;
  }
  ```
- Include all card container, header, footer, floating-label, input, icon, error, submit button, and ripple animation styles
- Include responsive media queries
- SHALL produce identical visual output as existing inline styles

**Migration per form file:**
1. Remove the entire `<style>` block
2. Replace entity-prefixed classes with `.frm-` classes in HTML
3. The CSS file is loaded once in `main.php` layout

#### FR-CSS-2: `themes/erp/css/report-tables.css` (~150 lines)

**Purpose:** Unified report table and card styling

**Requirements:**
- Standardize `.report-card` container styling
- Standardize `.summaryTab` table styling (header, rows, hover, totals)
- Include sticky header styles
- Include print `@media` overrides
- Define CSS custom properties for report theming:
  ```css
  :root {
    --rpt-header-bg: #212529;
    --rpt-header-text: #fff;
    --rpt-stripe: #f8f9fa;
    --rpt-hover: #e9ecef;
    --rpt-border: #dee2e6;
  }
  ```
- Normalize the 12 older report files to match the 8 newer ones

**Migration per report file:**
1. Remove the `<style>` block
2. Ensure HTML uses standardized `.report-card` + `.summaryTab` classes
3. The CSS file is loaded once in `main.php` layout

#### FR-CSS-3: `themes/erp/css/admin-grids.css` (~120 lines)

**Purpose:** Shared admin grid view styling

**Requirements:**
- Grid header (title, subtitle, action buttons)
- Filter row input styling
- Pagination button styling
- Action column button styling
- Responsive wrapper
- SHALL not conflict with `themes/erp/css/gridview/styles.css` (which handles Yii CGridView internals)

**Migration per admin.php file:**
1. Remove duplicate inline styles
2. Keep only truly page-specific styles inline (if any)
3. The CSS file is loaded once in `main.php` layout

#### FR-CSS-4: `themes/erp/css/dashboard.css` (~200 lines)

**Purpose:** Dashboard-specific styles extracted from `dashBoard.php`

**Requirements:**
- Extract the ~200 lines of inline CSS from `themes/erp/views/site/dashBoard.php`
- Include stat card styles, gradient cards, animation keyframes
- Include responsive breakpoints
- Keep as a separate file (loaded only on dashboard, or globally if small enough)

### 11.5 CSS File Loading Order (Updated)

After consolidation, `main.php` SHALL load CSS in this order:

```
1. Font Awesome 6 CSS
2. Ionicons CSS
3. Toastr CSS
4. jQuery UI CSS
5. Bootstrap 5.3 CSS
6. Lightpick CSS
7. form-components.css      ← NEW
8. report-tables.css        ← NEW
9. admin-grids.css          ← NEW
10. dashboard.css           ← NEW (or loaded per-page)
11. custom.css (with filemtime cache-busting)
```

### 11.6 View File Modifications

Each of the 67 files with inline `<style>` blocks SHALL be modified:

| File Group | Count | Action |
|-----------|-------|--------|
| Form `_form*.php` files | 14 | Remove `<style>` block; replace `.XX-` prefixed classes with `.frm-` classes |
| Report `*View.php` files | 20 | Remove `<style>` block; standardize to `.report-card` + `.summaryTab` classes |
| Admin `admin.php` files | 14 | Remove duplicate grid styles from `<style>` block; keep only unique overrides |
| Dashboard `dashBoard.php` | 1 | Move `<style>` block content to `dashboard.css` |
| Login `login.php` | 1 | Keep inline (unique, only loaded on login page) |
| Other misc files | 17 | Evaluate individually — keep if unique, extract if duplicated |

### 11.7 CSS Class Migration Mapping

The entity-specific prefixes below are present across form view files and must be renamed to the unified `.frm-` prefix during CSS consolidation.

**CSS Class Migration Mapping**

| Legacy Prefix | Used In | Migrates To | Notes |
|--------------|---------|------------|-------|
| `.co-card` | commercial views | `.frm-card` | |
| `.co-card-header` | commercial views | `.frm-card-header` | |
| `.co-card-body` | commercial views | `.frm-card-body` | |
| `.pb-card` | purchase bill views | `.frm-card` | |
| `.pb-card-header` | purchase bill views | `.frm-card-header` | |
| `.pi-card` | purchase invoice views | `.frm-card` | |
| `.pi-card-header` | purchase invoice views | `.frm-card-header` | |
| `.pr-card` | product views | `.frm-card` | |
| `.so-card` | sales order views | `.frm-card` | |
| `.si-card` | sales invoice views | `.frm-card` | |
| `.un-card` | unit views | `.frm-card` | |
| `.us-card` | user views | `.frm-card` | |
| `[prefix]-label` | all form views | `.frm-label` | |
| `[prefix]-input` | all form views | `.frm-input` | |
| `[prefix]-section-title` | all form views | `.frm-section-title` | |
| `[prefix]-divider` | all form views | `.frm-divider` | |

**Grep command to find all files requiring class prefix migration:**

```bash
grep -r "class=\"[a-z][a-z]-card" themes/erp/views/ --include="*.php" -l
```

### 11.8 Acceptance Criteria for CSS Consolidation

- [ ] No form view file contains duplicate floating-label CSS inline
- [ ] No report view file contains duplicate table CSS inline
- [ ] No admin view file contains duplicate grid CSS inline
- [ ] `form-components.css` exists and is loaded in main layout
- [ ] `report-tables.css` exists and is loaded in main layout
- [ ] `admin-grids.css` exists and is loaded in main layout
- [ ] All forms render identically before and after consolidation
- [ ] All reports render identically before and after consolidation
- [ ] All admin grids render identically before and after consolidation
- [ ] Total inline CSS reduced from ~3,738 lines to <500 lines (page-specific only)
- [ ] CSS custom properties used for theming values

---

## 12. Dead File Cleanup Inventory

### 12.1 Overview

The codebase contains ~72 MB of unused static assets accumulated from AdminLTE template scaffolding, deprecated features (POS system), legacy frameworks (Blueprint CSS), and experimental plugins. This section provides a complete, file-by-file deletion inventory.

### 12.2 Deletion Categories

| Category | Files | Size | Risk |
|----------|-------|------|------|
| AdminLTE dist directory | ~66 files | 14 MB | None (replaced by BS5) |
| Unused AdminLTE plugins (49 of 57) | ~5,000+ files | 56 MB | None (not referenced) |
| Dead PHP extension (EBootstrap) | ~25 files | ~500 KB | None (zero usage in views) |
| Legacy Blueprint CSS | 6 files | 25 KB | None (not loaded) |
| Dead theme CSS files | 8+ files | 220 KB | None (not referenced) |
| Dead theme JS files | 2 files | ~30 KB | None (commented out / not referenced) |
| POS system CSS/assets | 20+ files | 50 KB | None (not deployed) |
| Old Font Awesome 4.7 | ~20 files | ~2 MB | None (replaced by FA6) |
| **Total** | **~5,150+ files** | **~72.8 MB** | **None** |

### 12.3 Complete Deletion List

#### A) AdminLTE Distribution (`themes/erp/dist/`) — DELETE ENTIRE DIRECTORY

| Path | Size | Reason |
|------|------|--------|
| `themes/erp/dist/css/adminlte.min.css` | 723 KB | Replaced by Bootstrap 5.3 |
| `themes/erp/dist/css/adminlte.css` | 857 KB | Unminified version |
| `themes/erp/dist/css/adminlte.min.css.map` | 2.2 MB | Source map |
| `themes/erp/dist/css/adminlte.css.map` | 1.5 MB | Source map |
| `themes/erp/dist/css/alt/` (6 files + 12 maps) | 4.5 MB | Alt component CSS |
| `themes/erp/dist/js/adminlte.min.js` | 40 KB | AdminLTE JS |
| `themes/erp/dist/js/adminlte.js` | 101 KB | Unminified version |
| `themes/erp/dist/js/adminlte.min.js.map` | 116 KB | Source map |
| `themes/erp/dist/js/adminlte.js.map` | 153 KB | Source map |
| `themes/erp/dist/js/demo.js` | 15 KB | Demo animations |
| `themes/erp/dist/js/pages/` (3 files) | 20 KB | Dashboard demos |
| `themes/erp/dist/js/.eslintrc.json` | 866 B | Linter config |
| `themes/erp/dist/img/` (22 files) | 3.3 MB | Product mockups, avatars |
| **Subtotal** | **~14 MB** | |

#### B) Unused AdminLTE Plugins — DELETE EACH DIRECTORY

| Plugin Directory | Size | Reason Not Used |
|-----------------|------|-----------------|
| `themes/erp/plugins/pdfmake/` | 11 MB | No PDF generation via JS |
| `themes/erp/plugins/flag-icon-css/` | 6.1 MB | No country selectors |
| `themes/erp/plugins/summernote/` | 5.6 MB | No rich text editor |
| `themes/erp/plugins/jqvmap/` | 4.1 MB | No interactive maps |
| `themes/erp/plugins/codemirror/` | 2.8 MB | No code editing |
| `themes/erp/plugins/fullcalendar/` | 1.3 MB | No calendar features |
| `themes/erp/plugins/jquery-mapael/` | 1.3 MB | No map charting |
| `themes/erp/plugins/pace-progress/` | 1.1 MB | No page load progress bar |
| `themes/erp/plugins/jquery-ui/` | 956 KB | Using local `themes/erp/js/jquery-ui.js` instead |
| `themes/erp/plugins/overlayScrollbars/` | 812 KB | No custom scrollbars |
| `themes/erp/plugins/raphael/` | 788 KB | No SVG charting |
| `themes/erp/plugins/select2/` | 752 KB | No advanced selects |
| `themes/erp/plugins/bootstrap-colorpicker/` | 720 KB | No color pickers |
| `themes/erp/plugins/jquery-validation/` | 664 KB | Using Yii validation |
| `themes/erp/plugins/datatables/` | 524 KB | Using Yii CGridView |
| `themes/erp/plugins/jszip/` | 456 KB | No ZIP generation |
| `themes/erp/plugins/flot/` | 432 KB | Not referenced |
| `themes/erp/plugins/sweetalert2/` | 416 KB | Using toastr/alertify |
| `themes/erp/plugins/sparklines/` | ~100 KB | No sparkline charts |
| `themes/erp/plugins/uplot/` | 272 KB | No micro charts |
| `themes/erp/plugins/chart.js/` | 1.4 MB | Not referenced in any view |
| `themes/erp/plugins/datatables-bs4/` | ~500 KB | Not referenced |
| `themes/erp/plugins/datatables-autofill/` | ~100 KB | Not referenced |
| `themes/erp/plugins/datatables-buttons/` | ~500 KB | Not referenced |
| `themes/erp/plugins/datatables-colreorder/` | ~100 KB | Not referenced |
| `themes/erp/plugins/datatables-fixedcolumns/` | ~100 KB | Not referenced |
| `themes/erp/plugins/datatables-fixedheader/` | ~100 KB | Not referenced |
| `themes/erp/plugins/datatables-keytable/` | ~100 KB | Not referenced |
| `themes/erp/plugins/datatables-responsive/` | ~200 KB | Not referenced |
| `themes/erp/plugins/datatables-rowgroup/` | ~100 KB | Not referenced |
| `themes/erp/plugins/datatables-rowreorder/` | ~100 KB | Not referenced |
| `themes/erp/plugins/datatables-scroller/` | ~100 KB | Not referenced |
| `themes/erp/plugins/datatables-searchpanes/` | ~200 KB | Not referenced |
| `themes/erp/plugins/datatables-select/` | ~100 KB | Not referenced |
| `themes/erp/plugins/daterangepicker/` | ~50 KB | Using lightpick instead |
| `themes/erp/plugins/dropzone/` | ~100 KB | Using local dropzone.min.js |
| `themes/erp/plugins/ekko-lightbox/` | ~50 KB | No lightbox features |
| `themes/erp/plugins/fastclick/` | ~10 KB | Outdated mobile lib |
| `themes/erp/plugins/filterizr/` | ~20 KB | No portfolio filtering |
| `themes/erp/plugins/ion-rangeslider/` | ~100 KB | No range sliders |
| `themes/erp/plugins/jquery-knob/` | ~80 KB | No circular dials |
| `themes/erp/plugins/jquery-mousewheel/` | ~10 KB | Not referenced |
| `themes/erp/plugins/jsgrid/` | 272 KB | Using Yii CGridView |
| `themes/erp/plugins/bs-stepper/` | ~50 KB | No step wizards |
| `themes/erp/plugins/bootstrap-slider/` | ~50 KB | No slider widgets |
| `themes/erp/plugins/bootstrap4-duallistbox/` | ~50 KB | No dual list boxes |
| `themes/erp/plugins/select2-bootstrap4-theme/` | ~50 KB | Select2 not used |
| `themes/erp/plugins/sweetalert2-theme-bootstrap-4/` | ~10 KB | SweetAlert2 not used |
| `themes/erp/plugins/tempusdominus-bootstrap-4/` | ~100 KB | Not referenced |
| **Subtotal** | **~42 MB** | |

#### C) Used Plugins to Relocate Then Delete Original

After relocating to `themes/erp/vendor/`, delete the original plugin directories:

| Plugin Directory | New Location | Size |
|-----------------|-------------|------|
| `themes/erp/plugins/bootstrap/` | Replaced by BS5 in vendor | 1.6 MB |
| `themes/erp/plugins/jquery/` | Replaced by jQuery 3.7 in vendor | 920 KB |
| `themes/erp/plugins/fontawesome-free/` | Moved to vendor | 3.2 MB |
| `themes/erp/plugins/moment/` | Moved to vendor | 2.9 MB |
| `themes/erp/plugins/inputmask/` | Moved to vendor | 700 KB |
| `themes/erp/plugins/toastr/` | Moved to vendor | ~100 KB |
| `themes/erp/plugins/popper/` | Bundled with BS5 | 1.6 MB |
| `themes/erp/plugins/bootstrap-switch/` | Replaced by BS5 form-switch | ~100 KB |
| `themes/erp/plugins/icheck-bootstrap/` | Replaced by BS5 form-check | ~50 KB |
| `themes/erp/plugins/bs-custom-file-input/` | Replaced by BS5 file input | ~20 KB |
| **Subtotal** | | **~11 MB** |

**After relocation, delete the entire `themes/erp/plugins/` directory.**

#### D) Dead PHP Extension

| Path | Size | Reason |
|------|------|--------|
| `protected/extensions/bootstrap/` (entire dir) | ~500 KB | Zero usage across all 346 view files. Contains 25+ EBootstrap* widget classes that wrap Bootstrap 2/3 — completely dead code. |

**Also remove** any reference in `protected/config/main.php`:
- `application.extensions.bootstrap.*` import line (if present)

#### E) Legacy Blueprint CSS Files

| File | Size | Reason |
|------|------|--------|
| `css/screen.css` | 13 KB | Blueprint 1.0.1 grid system (2007). Not loaded in any layout. |
| `css/main.css` | 3 KB | Blueprint default styles. Not loaded in AdminLTE layouts. |
| `css/default.css` | 4 KB | Blueprint form defaults. Not loaded. |
| `css/form.css` | 3 KB | Blueprint form layout. Not loaded. |
| `css/ie.css` | 2 KB | IE 6-8 compatibility hacks. Obsolete (app requires PHP 8.x / modern browsers). |
| `css/bg.gif` | 243 B | Background image for Blueprint nav. Not referenced. |
| **Subtotal** | **25 KB** | |

#### F) Dead Theme CSS Files

| File | Size | Reason |
|------|------|--------|
| `themes/erp/css/layout-old.css` | 28 KB | Superseded by `layout.css` — "old" suffix confirms deprecated |
| `themes/erp/css/jquery-ui-old.css` | 25 KB | Superseded by `jquery-ui.css` — "old" suffix confirms deprecated |
| `themes/erp/css/breadcumb.css` | 49 B | Contains only a garbage comment (`12:42 PM 5/19/2020`), no valid CSS |
| `themes/erp/css/pegi-css.css` | 5.3 KB | PEGI rating styles — zero references in any PHP file |
| `themes/erp/css/quick_sell_style.css` | 13 KB | POS quick-sell interface — feature not deployed, zero references |
| `themes/erp/css/vtcss.css` | 2.1 KB | Alternative gridview style — not actively loaded |
| `themes/erp/css/ie.css` | 653 B | IE-specific fixes — obsolete |
| Bootstrap-datepicker CSS variants (8 files) | 150 KB | Not referenced — app uses jQuery UI datepicker + Lightpick |
| **Subtotal** | **~224 KB** | |

#### G) Dead Theme JS Files

| File | Size | Reason |
|------|------|--------|
| `themes/erp/js/bootstrap-autocomplete.min.js` | ~15 KB | Commented out in main.php layout — not active |
| `themes/erp/js/asteroid-alert.js` | ~15 KB | Not referenced in any PHP file |
| **Subtotal** | **~30 KB** | |

#### H) POS System Assets (Entirely Unused)

| Path | Size | Reason |
|------|------|--------|
| `themes/erp/css/pos/` (entire directory) | ~50 KB | POS feature not deployed. Contains `pos.css`, clock assets, images, sounds. Zero references. |
| **Subtotal** | **~50 KB** | |

#### I) Old Menu System (Deprecated)

| Path | Size | Reason |
|------|------|--------|
| `themes/erp/css/menu/` (entire directory) | ~20 KB | Old dropdown menu CSS and images. Replaced by `UserMenu.php` widget with inline dark-theme styles. Zero references. |
| **Subtotal** | **~20 KB** | |

#### J) Font Awesome 4.7 (Replaced by FA6)

| Path | Size | Reason |
|------|------|--------|
| `themes/erp/font-awesome/` (entire directory) | ~2 MB | FA 4.7.0 — replaced by Font Awesome 6. All icon references will be migrated to FA6 syntax in Phase 5. |
| **Subtotal** | **~2 MB** | |

### 12.4 Deletion Phases

Deletions SHALL be executed in dependency order to avoid breaking the app:

| Phase | What to Delete | Prerequisite |
|-------|---------------|-------------|
| Phase 0 | Dead code: EBootstrap extension, Blueprint CSS, dead theme CSS/JS, POS, menu, unused plugins (49) | None — zero references |
| Phase 1 | AdminLTE dist, remaining plugins (after relocation to vendor) | Phase 1 of Migration (new assets loaded) |
| Phase 5 | Font Awesome 4.7 directory | Phase 5 of Migration (FA6 fully deployed) |
| Phase 7 | Final sweep — `themes/erp/plugins/` directory itself | All used plugins relocated to `vendor/` |

### 12.5 Post-Cleanup Directory Structure

```
themes/erp/
├── vendor/                          ← NEW (replaces plugins/)
│   ├── bootstrap5/
│   │   ├── css/bootstrap.min.css
│   │   └── js/bootstrap.bundle.min.js
│   ├── jquery/
│   │   └── jquery-3.7.1.min.js
│   ├── fontawesome6/
│   │   ├── css/all.min.css
│   │   └── webfonts/
│   ├── toastr/
│   │   ├── toastr.min.css
│   │   └── toastr.min.js
│   ├── moment/
│   │   └── moment.min.js
│   ├── inputmask/
│   │   └── jquery.inputmask.min.js
│   └── chartjs/                     (if needed)
│       └── chart.min.js
├── css/
│   ├── custom.css                   (updated for BS5)
│   ├── layout.css                   (updated, AdminLTE deps removed)
│   ├── form-components.css          ← NEW
│   ├── report-tables.css            ← NEW
│   ├── admin-grids.css              ← NEW
│   ├── dashboard.css                ← NEW
│   ├── lightpick.css                (kept)
│   ├── jquery-ui.css                (kept)
│   ├── ionicons.min.css             (kept)
│   ├── report.css                   (kept)
│   ├── reset.css                    (kept)
│   ├── style.css                    (kept)
│   ├── dropzone.min.css             (kept)
│   ├── gridview/                    (kept)
│   ├── detailview/                  (kept)
│   ├── listview/                    (kept)
│   └── images/                      (kept — jQuery UI sprites)
├── js/
│   ├── jquery-ui.js                 (kept)
│   ├── alertify.js                  (kept)
│   ├── as-min.js                    (kept)
│   ├── lightpick.js                 (kept)
│   ├── print-jquery.js              (kept)
│   ├── html-table-search.js         (kept)
│   ├── jquery.table2excel.min.js    (kept)
│   ├── dropzone.min.js              (kept)
│   ├── jqClock.min.js               (kept)
│   └── bootstrap-datepicker.js      (kept — evaluate if still needed)
├── images/                          (kept — 129 files, all referenced)
├── locales/                         (kept — datepicker i18n)
├── views/                           (all views updated)
└── pagination/                      (kept)
```

**Directories removed:**
- `themes/erp/dist/` — AdminLTE distribution (14 MB)
- `themes/erp/plugins/` — All AdminLTE plugins (56 MB)
- `themes/erp/font-awesome/` — FA 4.7 (2 MB)
- `themes/erp/css/pos/` — POS styles
- `themes/erp/css/menu/` — Old menu styles

### 12.6 Size Impact Summary

| Metric | Before | After | Change |
|--------|--------|-------|--------|
| `themes/erp/dist/` | 14 MB | 0 | -14 MB |
| `themes/erp/plugins/` | 56 MB | 0 | -56 MB |
| `themes/erp/vendor/` (new) | 0 | ~2.4 MB | +2.4 MB |
| `themes/erp/font-awesome/` | 2 MB | 0 | -2 MB |
| Dead CSS files | ~224 KB | 0 | -224 KB |
| Dead JS files | ~30 KB | 0 | -30 KB |
| Blueprint CSS (`css/`) | 25 KB | 0 | -25 KB |
| EBootstrap extension | 500 KB | 0 | -500 KB |
| New consolidated CSS files | 0 | ~670 B | +670 B |
| Inline CSS in views | 3,738 lines | <500 lines | -3,238 lines |
| **Net total** | **~72.8 MB** | **~2.4 MB** | **-70.4 MB (97%)** |

### 12.7 Acceptance Criteria for Dead File Cleanup

- [ ] `themes/erp/dist/` directory does not exist
- [ ] `themes/erp/plugins/` directory does not exist
- [ ] `themes/erp/font-awesome/` directory does not exist
- [ ] `protected/extensions/bootstrap/` directory does not exist
- [ ] `css/screen.css`, `css/main.css`, `css/default.css`, `css/form.css`, `css/ie.css`, `css/bg.gif` do not exist
- [ ] `themes/erp/css/layout-old.css`, `jquery-ui-old.css`, `breadcumb.css`, `pegi-css.css`, `quick_sell_style.css`, `vtcss.css`, `ie.css` do not exist
- [ ] `themes/erp/css/bootstrap-datepicker*.css` (all 8 variants) do not exist
- [ ] `themes/erp/css/pos/` directory does not exist
- [ ] `themes/erp/css/menu/` directory does not exist
- [ ] `themes/erp/js/bootstrap-autocomplete.min.js` and `asteroid-alert.js` do not exist
- [ ] `themes/erp/vendor/` contains only Bootstrap 5, jQuery 3.7, FA6, toastr, moment, inputmask
- [ ] Zero 404 errors in browser console on any page
- [ ] All existing functionality works identically
- [ ] Total `themes/erp/` size under 10 MB (excluding `views/`)

---

---

## 13. Yii Framework jQuery Core Replacement

### 13.1 Problem Statement

The Yii 1.x framework bundles jQuery **1.12.4** in `framework/web/js/source/`. This ancient version (released 2016) is loaded via Yii's asset publishing system whenever any widget (`CGridView`, `CActiveForm`, `CLinkPager`, etc.) calls `registerCoreScript('jquery')`. The result is either:
- **Dual jQuery loading** — both 1.12.4 (Yii) and 3.5.1 (AdminLTE) load, causing conflicts
- **Stale override** — `clientScript.scriptMap` redirects to a newer version, but the old files remain as dead weight

The user requires jQuery 3.7.x to be the **only** jQuery version in the entire project, including within the framework source.

### 13.2 Current jQuery Loading Mechanism

```
Yii Widget (CGridView, CActiveForm, etc.)
  → calls Yii::app()->clientScript->registerCoreScript('jquery')
  → CClientScript looks up 'jquery' in framework/web/js/packages.php
  → Package maps to: jquery.min.js (production) or jquery.js (debug)
  → Files served from: framework/web/js/source/ (published to /assets/ hash dir)
  → Outputs: <script src="/assets/{hash}/jquery.min.js"></script>
```

**Package definition** (`framework/web/js/packages.php`, line 15-17):
```php
'jquery' => array(
    'js' => array(YII_DEBUG ? 'jquery.js' : 'jquery.min.js'),
),
```

### 13.3 Files to Replace

| File | Current | Replace With | Size |
|------|---------|-------------|------|
| `framework/web/js/source/jquery.js` | jQuery 1.12.4 (287 KB) | jQuery 3.7.1 uncompressed | ~302 KB |
| `framework/web/js/source/jquery.min.js` | jQuery 1.12.4 (95 KB) | jQuery 3.7.1 minified | ~87 KB |

### 13.4 Compatibility Verification

jQuery 3.7.x has breaking changes from 1.x. The following Yii framework jQuery plugins MUST be tested:

| Plugin File | Purpose | Risk | Reason |
|-------------|---------|------|--------|
| `jquery.yii.js` | Yii core adapter (CSRF token injection) | LOW | Simple utility functions, no deprecated API usage expected |
| `jquery.yiiactiveform.js` | Form validation | MEDIUM | Uses `.on()`, `.data()`, `.trigger()` — may use deprecated form-validation patterns |
| `jquery.yiitab.js` | Tab widget | LOW | Simple show/hide tab switching |
| `jquery.yiilistview.js` | List AJAX refresh | MEDIUM | AJAX list refresh may use removed event shorthands |
| `jquery.yiiqtip.js` | Tooltip wrapper | LOW | Thin wrapper, unlikely to use removed APIs |
| `jquery.yiicartmanager.js` | Cart management | LOW | Not used in this project |
| `jquery.yiitreegridview.js` | Tree grid view | MEDIUM | Complex widget, may use `.live()` or `.delegate()` |
| `jquery.ajaxqueue.js` | AJAX queueing | MEDIUM | Uses `$.ajax` internals; may use `deferred.pipe()` (removed) |
| `jquery.autocomplete.js` | Autocomplete widget | HIGH | Old jQuery UI pattern; likely uses `.live()` or `.bind()` removed in jQuery 3 |
| `jquery.ba-bbq.js` | URL hash/history management | MEDIUM | Uses deprecated `$.browser` or `deferred.pipe()` APIs |
| `jquery.cookie.js` | Cookie management | LOW | Simple utility, compatible with jQuery 3 |
| `jquery.maskedinput.js` | Input masking | LOW | Compatible with jQuery 3 per library changelog |
| `jquery.metadata.js` | Metadata extraction | MEDIUM | May use `$.fn.data()` or removed parsing APIs |
| `jquery.multifile.js` | Multi-file upload | HIGH | Uses deprecated jQuery methods for file input handling |
| `jquery.rating.js` | Star rating widget | LOW | Simple event binding, low risk |
| `jquery.treeview.js` | Tree view widget | MEDIUM | May use `.bind()` / `.delegate()` |
| `jquery.fileupload.js` | File upload (if present) | HIGH | Uses deprecated jQuery methods for AJAX and form serialization |
| `jquery.colorbox.js` | Lightbox (if present) | MEDIUM | Uses older jQuery event model |
| `jquery.bgiframe.js` | IE6 z-index fix | **DELETE** | Completely obsolete — IE6 is not a supported browser |

### 13.5 Known jQuery 1.x → 3.x Breaking Changes to Check

| Removed API | Replacement | Files to Check |
|-------------|-------------|----------------|
| `.andSelf()` | `.addBack()` | All jquery.*.js plugins |
| `.size()` | `.length` | All jquery.*.js plugins |
| `$.isArray()` | `Array.isArray()` | Plugins using type checking |
| `$.parseJSON()` | `JSON.parse()` | Plugins parsing JSON |
| `.error()` event shorthand | `.on('error', ...)` | Image/script loading |
| `.load()` event shorthand | `.on('load', ...)` | Document/image ready |
| `.unload()` event shorthand | `.on('unload', ...)` | Page unload handlers |
| `deferred.pipe()` | `deferred.then()` | AJAX chaining in plugins |
| `$.event.props` | `$.event.fixHooks` | Custom event handling |
| `.bind()` / `.unbind()` | `.on()` / `.off()` | All older plugins |
| `.delegate()` / `.undelegate()` | `.on()` / `.off()` | Event delegation |

### 13.6 Requirements

**FR-JQUERY-1** — `framework/web/js/source/jquery.js` SHALL be replaced with jQuery 3.7.1 uncompressed source.

**FR-JQUERY-2** — `framework/web/js/source/jquery.min.js` SHALL be replaced with jQuery 3.7.1 minified source.

**FR-JQUERY-3** — `framework/web/js/packages.php` SHALL NOT be modified — the package name `'jquery'` and file mapping remain the same.

**FR-JQUERY-4** — `clientScript.scriptMap` in `protected/config/main.php` SHALL be configured as a safety net to ensure the correct jQuery version is served:
```php
'clientScript' => array(
    'scriptMap' => array(
        'jquery.js' => '/themes/erp/vendor/jquery/jquery-3.7.1.js',
        'jquery.min.js' => '/themes/erp/vendor/jquery/jquery-3.7.1.min.js',
    ),
),
```

**FR-JQUERY-5** — All 18 jQuery plugin files in `framework/web/js/source/` SHALL be audited for jQuery 3.x compatibility. Any using removed APIs SHALL be patched.

**FR-JQUERY-6** — `jquery.bgiframe.js` (IE6 z-index hack) SHALL be deleted — completely obsolete.

**FR-JQUERY-7** — The `themes/erp/vendor/jquery/` directory SHALL contain the canonical jQuery 3.7.1 files. The framework source files SHALL be copies of these.

**FR-JQUERY-8** — After replacement, `jQuery.fn.jquery` in browser console SHALL return `3.7.1` on every page, with zero duplicate jQuery loads.

### 13.7 Acceptance Criteria

- [ ] `framework/web/js/source/jquery.min.js` contains jQuery 3.7.1
- [ ] `framework/web/js/source/jquery.js` contains jQuery 3.7.1
- [ ] `jQuery.fn.jquery` returns `3.7.1` in browser console
- [ ] Only ONE `<script>` tag for jQuery appears in page source
- [ ] `CGridView` sort, filter, and pagination work correctly
- [ ] `CActiveForm` client-side validation works correctly
- [ ] `CLinkPager` AJAX pagination works (if used)
- [ ] All jQuery UI widgets (datepicker, autocomplete, dialog) work correctly
- [ ] All custom AJAX calls (`$.ajax`, `$.post`, `$.get`) work correctly
- [ ] `jquery.bgiframe.js` is deleted
- [ ] All framework jQuery plugins pass basic smoke test

---

## 14. Frontend Design System

### 14.1 Overview

A comprehensive frontend design system has been created as a Claude Code skill at `.claude/skills/frontend-design/SKILL.md`. This skill is **automatically applied** whenever any view, form, report, dashboard, or UI component is created or modified.

### 14.2 Design System Contents

The design system defines exact specifications for:

| Section | What It Covers |
|---------|---------------|
| **Color Tokens** | Primary (indigo), secondary (purple), semantic (success/danger/warning/info), neutral scale, dark chrome, action button tints — all as CSS custom properties |
| **Typography** | Font stack, type scale (14 sizes from 9.5px to 32px), weights, transforms, letter-spacing, line-heights |
| **Spacing** | 4px base unit, 8 spacing tokens (xs through 4xl), per-component padding/margin specs |
| **Border Radius** | 14 component-specific values from `5px` (pagination) to `99px` (pills) |
| **Shadows** | 9 shadow levels from subtle to elevated, plus semantic glow variants |
| **Transitions & Motion** | 5 timing tokens, 4 easing curves, 6 standard transitions, 5 hover transforms, 6 keyframe animations |
| **Component Patterns** | Exact HTML + CSS for: cards, floating-label inputs, selects, currency inputs, report tables, admin grids, dashboard stats, modals, pagination, alerts, toastr |
| **Navbar & Footer** | Complete dark chrome specification (mirrors CLAUDE.md UserMenu docs) |
| **Responsive Breakpoints** | Bootstrap 5 breakpoints with key behavior changes per breakpoint |
| **Icons** | Font Awesome 6 icon library, common icon mapping, per-context sizing |
| **Print Styles** | Print-specific typography, color, margin, and visibility rules |
| **Z-Index Scale** | 7-level stacking context hierarchy |
| **Accessibility** | Label association, alt text, touch targets, focus management, color-not-sole-indicator |
| **Anti-Patterns** | 18 explicit "do NOT" rules to prevent design drift |

### 14.3 Embedded Design System Summary

The following is a condensed reference of the canonical design system. For full specifications, see `.claude/skills/frontend-design/SKILL.md`. Developers MUST implement from these tokens — do not invent new values.

#### Color Tokens

**Primary Palette (Indigo — use for all accents, focus rings, active states):**

```
--c-primary:        #6366f1   (focus rings, active states, icons)
--c-primary-base:   #4f46e5   (button base)
--c-primary-hover:  #4338ca   (button hover)
--c-primary-soft:   #eef2ff   (tinted backgrounds)
--c-primary-glow:   rgba(99,102,241,.12)  (focus ring shadow)
```

**Gradients:**
```
--g-brand:          linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%)   (card headers)
--g-brand-light:    linear-gradient(135deg, #6366f1, #7c3aed)           (buttons, avatars)
```

**Semantic colors (base values):** success `#22c55e`, danger `#ef4444`, warning `#f59e0b`, info `#3b82f6`

**Neutral scale:**
```
--c-text-primary:   #111827   (headings)
--c-text-secondary: #374151   (body)
--c-text-tertiary:  #6b7280   (labels, captions)
--c-border:         #e2e8f0   (default borders)
--c-bg-page:        #f8fafc   (page / card footer background)
```

**Dark chrome (navbar, footer, dropdowns):**
```
--c-chrome-bg:      #0f172a   (navbar & footer)
--c-chrome-surface: #1e293b   (dropdown background)
--c-chrome-text:    rgba(255,255,255,.78)
--c-chrome-accent:  rgba(99,102,241,.18)  (dropdown item hover)
```

**Action button tints (soft style — no bold fills):**

| Action | Background | Text | Border |
|--------|-----------|------|--------|
| View | `#e8f4fd` | `#1a6fa3` | `#a8cce8` |
| Create | `#e6f4ea` | `#1a7a40` | `#a8d5b5` |
| Edit | `#fff8e6` | `#8a6200` | `#e0c870` |
| Delete | `#fdecea` | `#b71c1c` | `#e8a8a8` |

#### Typography

Font stack: `"Helvetica Neue", Helvetica, Arial, Verdana, sans-serif`

| Element | Size | Weight |
|---------|------|--------|
| Page title (h1) | 21px | 700 |
| Card title | 17px | 800 |
| Section title | 13.5px | 700 |
| Body text | 13–14px | 400–500 |
| Form label (floating) | 13px normal → 9.5px focused | 500 → 700 |
| Grid / report header | 11px | 700, uppercase |
| Button (primary) | 14px | 700 |

#### Spacing (4px base unit)

Card body padding: `24px 28px` | Form field gap: `14px` | Grid cell: `7px 10px` | Primary button: `11px 26px`

#### Border Radius

Card: `16px` | Nested section: `12px` | Dropdown: `10px` | Button: `9px` | Input: `8px` | Action button (grid): `6px` | Badge/pill: `99px`

#### Shadows

| Level | Value |
|-------|-------|
| Card | `0 4px 6px rgba(0,0,0,.04), 0 12px 36px rgba(0,0,0,.1)` |
| Focus ring | `0 0 0 3.5px rgba(99,102,241,.12)` |
| Button glow | `0 4px 12px rgba(79,70,229,.35)` |
| Dropdown | `0 8px 28px rgba(0,0,0,.35)` |

#### Component Patterns

**Form card structure:** `.frm-card` > `.card-header` (gradient) > `.card-body` > `.frm-section` > `.frm-sec-body` > form fields > `.card-footer`

**Floating label input:** `.frm-fl` wrapper > icon + `.frm-fl-input` (placeholder=" ") + `.frm-fl-label` + checkmark tick

**Report table:** `.report-card` > `table.summaryTab` — dark header `#212529`, white text, alternating `#f8f9fa`/`#fff` rows, hover `#e9ecef`

#### Anti-Patterns (Do NOT)

- Do NOT use Bootstrap default blue (`#007bff`) — use indigo (`#4f46e5`)
- Do NOT use `data-toggle` — use `data-bs-toggle` (Bootstrap 5)
- Do NOT use `form-group` — use `mb-3`
- Do NOT use `ml-*`/`mr-*` — use `ms-*`/`me-*`
- Do NOT use Font Awesome 4 syntax (`fa fa-*`) — use FA6 (`fas fa-*`)
- Do NOT use AdminLTE classes
- Do NOT add inline `<style>` for styles that exist in shared CSS files
- Do NOT create new color values outside the token list above

### 14.4 Requirements

**FR-DS-1** — All new views created after this migration SHALL follow the design system.

**FR-DS-2** — All existing views modified during this migration SHALL be updated to use design system tokens (colors, spacing) where the change is low-risk and within scope of the modification.

**FR-DS-3** — The design system skill SHALL be loaded automatically by Claude Code when modifying any `.php` view file under `themes/erp/views/`.

**FR-DS-4** — CSS custom properties for the color palette SHALL be defined in a root-level block within `custom.css` (or a new `design-tokens.css`).

**FR-DS-5** — The design system document SHALL be kept up-to-date as new components or patterns are introduced.

---

## 15. Inline JavaScript Consolidation

### 15.1 Problem Statement

75 of 154 view files (49%) contain inline `<script>` blocks. This causes:
- **Code duplication** — alert fade-out, form validation, date picker init repeated across files
- **No caching** — inline JS is re-downloaded with every page load
- **CSP incompatibility** — inline scripts require `unsafe-inline` in Content Security Policy
- **Maintenance burden** — changes to common patterns require editing dozens of files

### 15.2 Identified Patterns for Extraction

| Pattern | Files | Lines | Target External File |
|---------|-------|-------|---------------------|
| Alert auto-fade (`$(".alert").animate(...)`) | ~30 | ~3 each | `common.js` |
| Lightpick date picker initialization | ~18 | ~15 each | `report-filters.js` |
| Print button handler | ~15 | ~5 each | `report-filters.js` |
| Excel export handler | ~12 | ~5 each | `report-filters.js` |
| Toastr flash message display | ~10 | ~5 each | `common.js` |
| Form field dynamic add/remove (tabular form) | ~8 | ~30 each | `form-utils.js` |
| Bootstrap switch init (`.bootstrapSwitch()`) | ~10 | ~3 each | Remove (BS5 form-switch) |
| Modal show/hide handlers | ~15 | ~10 each | Inline OK (page-specific) |
| AJAX form submission | ~20 | ~15 each | Inline OK (page-specific) |

### 15.3 New External JS Files

#### `themes/erp/js/common.js` (~50 lines)

**Purpose:** App-wide utilities loaded on every page.

**Contents:**
- Alert auto-fade (3s delay → fadeOut)
- Toastr default configuration
- CSRF token injection for AJAX requests
- Global error handler for failed AJAX calls
- Confirmation dialog wrapper (alertify)

#### `themes/erp/js/report-filters.js` (~80 lines)

**Purpose:** Shared logic for all report filter forms.

**Contents:**
- Lightpick date range picker initialization (with standard config)
- Print button handler (using `print-jquery.js`)
- Excel export button handler (using `jquery.table2excel.js`)
- Report form AJAX submission pattern
- Sticky table header clone logic

#### `themes/erp/js/form-utils.js` (~60 lines)

**Purpose:** Shared form helpers.

**Contents:**
- Dynamic tabular row add/remove
- Floating-label focus/blur handlers (if not pure CSS)
- Input mask initialization
- Currency field formatting
- Form validation error display

### 15.4 Requirements

**FR-JS-1** — Common inline patterns (alert fade, toastr config, CSRF setup) SHALL be extracted to `common.js` and loaded in `main.php` layout.

**FR-JS-2** — Report-specific inline patterns (date picker init, print, export) SHALL be extracted to `report-filters.js` and loaded only in report views.

**FR-JS-3** — Form utility patterns SHALL be extracted to `form-utils.js` and loaded in form views.

**FR-JS-4** — Page-specific AJAX handlers and modal logic MAY remain inline where they depend on PHP-generated variables (e.g., `$model->id`).

**FR-JS-5** — After consolidation, the number of view files with inline `<script>` blocks SHALL decrease from 75 to under 40 (page-specific scripts only).

### 15.5 Acceptance Criteria

- [ ] `common.js` exists and is loaded in main layout
- [ ] `report-filters.js` exists and is loaded in report views
- [ ] `form-utils.js` exists and is loaded in form views
- [ ] Alert auto-fade works identically on all pages
- [ ] All report date pickers initialize correctly
- [ ] Print and Excel export buttons work on all reports
- [ ] Inline `<script>` count reduced from 75 to <40 files

---

## 16. Accessibility Improvements

> **Phase B — Extended Scope (Optional)**
> This section is outside the core frontend migration scope. It should be treated as a separate enhancement initiative (Phase B) and is NOT a blocker for Phase A completion. Implement only after Phase A (Phases 0–7) is fully complete and tested.

### 16.1 Current State

The application has minimal accessibility support:
- No ARIA attributes on dynamic content
- No `role` attributes on alerts, modals, or navigation
- No skip-to-content link
- No keyboard navigation support beyond browser defaults
- Color used as sole state indicator in some badge/status elements
- Form error messages not associated with inputs via `aria-describedby`
- Grid action buttons have no `title` or `aria-label` attributes

### 16.2 Requirements

**FR-A11Y-1** — All pages SHALL include a "Skip to main content" link as the first focusable element, hidden until focused.

**FR-A11Y-2** — The navbar SHALL have `role="navigation"` and `aria-label="Main navigation"`.

**FR-A11Y-3** — All modal dialogs SHALL have `role="dialog"`, `aria-modal="true"`, and `aria-labelledby` pointing to the modal title.

**FR-A11Y-4** — All flash messages and toastr notifications SHALL have `role="alert"` and `aria-live="polite"`.

**FR-A11Y-5** — All form inputs SHALL have an associated `<label>` element (floating labels already satisfy this). Error messages SHALL be linked via `aria-describedby`.

**FR-A11Y-6** — Grid view action buttons (view, edit, delete) SHALL have `title` attributes describing the action and target (e.g., `title="Edit Product Model: XYZ"`).

**FR-A11Y-7** — Status badges/labels that use color SHALL also include an icon or text indicator:
```html
<!-- Before: color only -->
<span class="badge bg-success">Paid</span>

<!-- After: color + icon -->
<span class="badge bg-success"><i class="fas fa-check"></i> Paid</span>
```

**FR-A11Y-8** — All `<img>` tags SHALL have `alt` attributes. Decorative images use `alt=""`.

**FR-A11Y-9** — Minimum touch target size SHALL be `34px` (desktop) and `38px` (mobile) for all interactive elements.

**FR-A11Y-10** — Tab order SHALL follow visual layout. No `tabindex` values greater than 0.

### 16.3 Acceptance Criteria

- [ ] Skip-to-content link present on all pages
- [ ] Navbar has `role="navigation"` with aria-label
- [ ] All modals have proper ARIA attributes
- [ ] All alerts have `role="alert"`
- [ ] All form errors linked via `aria-describedby`
- [ ] All action buttons have `title` attributes
- [ ] Color-only indicators supplemented with icons/text
- [ ] All images have `alt` attributes

---

## 17. Performance Budget

### 17.1 Asset Size Budget

| Asset Type | Max Size (gzipped) | Current (pre-migration) | Target (post-migration) |
|-----------|-------------------|------------------------|------------------------|
| Total CSS (all files) | 150 KB | ~780 KB (AdminLTE + BS4 + custom) | ~80 KB (BS5 + custom) |
| Total JS (all files) | 200 KB | ~350 KB (AdminLTE + BS4 + jQuery + plugins) | ~180 KB (BS5 + jQuery + plugins) |
| Total images per page | 500 KB | Varies | Varies (no change) |
| Font files (FA6 webfonts) | 300 KB | ~200 KB (FA4) + ~300 KB (FA6 login) | ~300 KB (FA6 unified) |
| **Total first-load payload** | **1 MB** | **~1.6 MB** | **~560 KB** |

### 17.2 Loading Performance

| Metric | Target |
|--------|--------|
| No render-blocking JS in `<head>` | JS loaded at end of `<body>` or with `defer` |
| No duplicate library loads | Single jQuery, single Bootstrap, single FA |
| CSS files concatenation | Consider combining custom + form-components + admin-grids + report-tables into one file for production |
| Cache-busting | All custom CSS/JS use `?v=filemtime()` query strings |
| No 404 errors | Zero failed asset requests |

### 17.3 Requirements

**FR-PERF-1** — Total CSS payload (all files combined) SHALL NOT exceed 150 KB gzipped.

**FR-PERF-2** — Total JS payload (all files combined) SHALL NOT exceed 200 KB gzipped.

**FR-PERF-3** — jQuery and Bootstrap JS SHALL be loaded at the end of `<body>`, not in `<head>`.

**FR-PERF-4** — No library SHALL be loaded more than once (currently toastr CSS loads twice — fix this).

**FR-PERF-5** — All custom CSS and JS files SHALL use cache-busting via `filemtime()` query parameter.

**FR-PERF-6** — Report-specific JS (`report-filters.js`) SHALL only be loaded on report pages, not globally.

---

## 18. Security Hardening (CSP Readiness)

### 18.1 Problem Statement

The application currently uses extensive inline `<style>` and `<script>` blocks (67 files with inline CSS, 75 with inline JS). This makes it impossible to deploy a strict Content Security Policy (CSP) without `unsafe-inline` directives, leaving the app vulnerable to XSS injection.

### 18.2 CSP Readiness Requirements

**FR-CSP-1** — After CSS consolidation (Section 11) and JS consolidation (Section 15), the number of files with inline `<style>` blocks SHALL be reduced from 67 to under 15 (page-specific only).

**FR-CSP-2** — The number of files with inline `<script>` blocks SHALL be reduced from 75 to under 40.

**FR-CSP-3** — Remaining inline scripts that depend on PHP-generated data SHALL use the `data-*` attribute pattern instead of inline JS variables:
```php
<!-- Before -->
<script>var modelId = <?= $model->id ?>;</script>

<!-- After -->
<div id="form-container" data-model-id="<?= $model->id ?>">
```

**FR-CSP-4** — No inline `onclick`, `onchange`, `onsubmit`, or other inline event handlers SHALL be added in new code. Use `addEventListener` or jQuery `.on()` in external JS files.

**FR-CSP-5** — After migration, the application SHALL be testable with the following CSP header (as a stretch goal, not blocking):
```
Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; font-src 'self'; img-src 'self' data:;
```
Note: `unsafe-inline` for styles is acceptable in the short term due to remaining page-specific inline styles and Bootstrap's own inline style usage.

### 18.3 Acceptance Criteria

- [ ] Inline `<style>` blocks reduced from 67 to <15 files
- [ ] Inline `<script>` blocks reduced from 75 to <40 files
- [ ] No new inline event handlers (`onclick`, etc.) introduced
- [ ] PHP data passed via `data-*` attributes where possible
- [ ] Application functions with `script-src 'self'` CSP (stretch goal)

---

---

## 19. Security Vulnerabilities & Fixes

### 19.1 Executive Summary

A full security audit identified **8 CRITICAL**, **12 HIGH**, and **8 MEDIUM** severity vulnerabilities spanning SQL injection, XSS, CSRF bypass, insecure password hashing, code injection via `eval()`, file upload exploits, debug mode in production, and hardcoded credentials. These MUST be fixed as part of the modernization effort.

### 19.2 CRITICAL Severity — Fix Immediately

**Effort: High** — Each fix requires parameterized query rewrites, bcrypt migration scripts, `eval()` removal with business rule mapping, and regression testing across all affected endpoints.

#### SEC-C1: SQL Injection (Multiple Controllers)

**Affected Files:**
| File | Lines | Input Source | Pattern |
|------|-------|-------------|---------|
| `protected/controllers/ReportController.php` | 61, 67, 74, 139-140, 239, 289, 295, 302, 306, 374, 420, 426, 432, 444, 450, 456, 1339-1353 | `$_POST['Inventory']` (date_from, date_to, customer_id) | String interpolation in `addCondition()` and raw SQL |
| `protected/controllers/ProdModelsController.php` | 34-36 | `$_REQUEST['company_id']` | Direct variable in `addCondition()` |
| `protected/controllers/UsersController.php` | 158 | URL parameter `$id` | DELETE statement with string interpolation |
| `protected/models/Users.php` | 255 | `$user_id` parameter | SELECT with string interpolation |
| `protected/models/SellPrice.php` | 218 | `$model_id` parameter | SELECT with `{$model_id}` interpolation |

**Fix:** Replace ALL string interpolation with parameterized queries:
```php
// BEFORE (vulnerable)
$criteria->addCondition("date < '$dateFrom'");

// AFTER (secure)
$criteria->addCondition('date < :dateFrom');
$criteria->params[':dateFrom'] = $dateFrom;

// BEFORE (vulnerable)
$sql = "SELECT * FROM AuthAssignment WHERE userid = '$user_id'";

// AFTER (secure)
$sql = "SELECT * FROM AuthAssignment WHERE userid = :userId";
$command = Yii::app()->db->createCommand($sql);
$command->bindParam(':userId', $user_id, PDO::PARAM_STR);
```

For numeric IDs, also type-cast as a defense-in-depth:
```php
$company_id = (int) $_REQUEST['company_id'];
```

**Total instances to fix:** ~25+ across 5 files

---

#### SEC-C2: MD5 Password Hashing (No Salt)

**Affected Files:**
| File | Lines | Issue |
|------|-------|-------|
| `protected/models/Users.php` | 79-81 | `hashPassword()` returns `md5($password)` |
| `protected/models/Users.php` | 91-92 | `beforeSave()` stores `md5($password)` and double-MD5 for `activkey` |
| `protected/config/main.php` | 40 | `'hash' => 'md5'` config |

**Fix:** Replace MD5 with `password_hash()` (bcrypt) and `password_verify()`:
```php
// Users.php
public function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

public function validatePassword($password)
{
    return password_verify($password, $this->password);
}
```

**Migration plan:**
1. Add `password_new` column (VARCHAR 255)
2. On each successful login with old MD5, rehash with bcrypt and store in `password_new`
3. Check `password_new` first, fall back to MD5 for not-yet-migrated users
4. After all users have logged in (or after 90 days), drop MD5 column
5. Remove `'hash' => 'md5'` from config

---

#### SEC-C3: Remote Code Execution via eval() in RBAC

**Affected Files:**
| File | Lines | Issue |
|------|-------|-------|
| `protected/modules/rights/components/RWebUser.php` | 122 | `eval($bizRule)` executes RBAC business rules |
| `protected/modules/rights/components/RAuthorizer.php` | 452 | `@eval($code)` with bypassable sanitization |

**Fix:** Remove `eval()` entirely. Replace with:
```php
// Option A: Hardcoded business rules (safest)
public function executeBizRule($bizRule, $params, $data)
{
    if (empty($bizRule)) return true;
    // Map rule names to PHP callbacks
    $rules = [
        'isOwner' => function($params) { return $params['user_id'] == Yii::app()->user->id; },
        // Add other rules as needed
    ];
    return isset($rules[$bizRule]) ? $rules[$bizRule]($params) : false;
}

// Option B: If no business rules are actually used (check AuthItem table), simply return true
public function executeBizRule($bizRule, $params, $data)
{
    return empty($bizRule) || $bizRule === null;
}
```

---

#### SEC-C4: Debug Mode Enabled in Production

**Affected Files:**
| File | Lines | Issue |
|------|-------|-------|
| `index.php` | 8 | `define('YII_DEBUG', TRUE)` |
| `protected/config/main.php` | 2-4 | `display_errors=1`, `error_reporting(E_ALL)` |

**Fix:**
```php
// index.php — use environment variable
defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG') === 'true');

// protected/config/main.php — remove or conditionalize
if (!YII_DEBUG) {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
}
```

---

#### SEC-C5: Hardcoded Database Credentials in Controller

**Affected File:** `protected/controllers/UsersController.php` line 201

```php
// FOUND: Hardcoded credentials
mysqli_connect('localhost', 'root', 'OF1YKK4HxtLSFUtF', 'erp')
```

**Fix:** Remove entirely. Use Yii's DB connection for backup operations, or use environment variables.

---

### 19.3 HIGH Severity — Fix Within 1-2 Weeks

**Effort: Medium** — CSRF enablement, XSS escaping, session regeneration, and file upload hardening each require focused work but are well-understood patterns. Mass assignment audit spans all models.

#### SEC-H1: CSRF Protection Not Enabled

**Issue:** No global `enableCsrfValidation` in `protected/config/main.php`. All POST endpoints are vulnerable to cross-site request forgery.

**Fix:** Add to `protected/config/main.php`:
```php
'request' => array(
    'enableCsrfValidation' => true,
),
```

Then ensure all forms use `CHtml::form()` or `CActiveForm` (which auto-include CSRF tokens). For AJAX requests, include the token:
```javascript
$.ajaxSetup({
    data: { YII_CSRF_TOKEN: '<?= Yii::app()->request->csrfToken ?>' }
});
```

---

#### SEC-H2: XSS via json_encode() in CHttpException

**Affected Files (15+ controllers):**
| File | Lines |
|------|-------|
| `protected/modules/accounting/controllers/ExpenseController.php` | 81, 153 |
| `protected/modules/accounting/controllers/PaymentReceiptController.php` | 73, 296, 301, 322, 327, 350, 355 |
| `protected/modules/accounting/controllers/MoneyReceiptController.php` | 72 |
| `protected/modules/sell/controllers/SellOrderController.php` | 129, 292, 329, 368 |
| `protected/modules/sell/controllers/SellOrderQuotationController.php` | 124, 227 |

**Pattern:**
```php
throw new CHttpException(500, sprintf('Error! %s', json_encode($model->getErrors())));
```

**Fix:** Use `JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT`:
```php
throw new CHttpException(500, sprintf('Error! %s',
    json_encode($model->getErrors(), JSON_HEX_TAG | JSON_HEX_AMP)));
```

---

#### SEC-H3: XSS via .html() with AJAX Responses

**Affected Files (20+ views):**
All report `*View.php` files, all `admin.php` grid views with update dialogs, dashboard widgets.

**Pattern:**
```javascript
$('#modal .modal-body').html(response);  // Unescaped server response
```

**Fix:** For HTML content that MUST render (like voucher previews), sanitize on the server side using `CHtml::encode()` on all user-controlled values. For text-only content, use `.text()` instead of `.html()`.

---

#### SEC-H4: XSS via innerHTML with AJAX Data

**Affected File:** `themes/erp/views/site/_alerts.php` lines 92, 104

```javascript
// User data injected directly into innerHTML
'<span title="'+r.model_name+'">'+r.model_name+'</span>'
```

**Fix:** Escape HTML entities in JavaScript:
```javascript
function escHtml(s) {
    var d = document.createElement('div');
    d.textContent = s;
    return d.innerHTML;
}
// Usage:
'<span title="'+escHtml(r.model_name)+'">'+escHtml(r.model_name)+'</span>'
```

---

#### SEC-H5: Session Fixation (No ID Regeneration on Login)

**Fix:** Add to the login action or `UserIdentity.authenticate()`:
```php
Yii::app()->session->regenerateID(true);
```

---

#### SEC-H6: Excessive Session Timeout (60 Days)

**Affected File:** `protected/config/main.php` lines 117-121

**Fix:** Reduce to 30 minutes (1800 seconds):
```php
'timeout' => 1800,
'cookieParams' => array(
    'lifetime' => 0,  // Session cookie (expires when browser closes)
    'httpOnly' => true,
    'secure' => true,  // If using HTTPS
),
```

---

#### SEC-H7: Gii Module Accessible with Weak Password

**Affected File:** `protected/config/main.php` line 83

**Fix:** Either disable Gii entirely in production or add IP restriction:
```php
'gii' => array(
    'class' => 'system.gii.GiiModule',
    'password' => 'strong-random-password-here',
    'ipFilters' => array('127.0.0.1', '::1'),  // Localhost only
),
```

Or better — remove Gii config entirely from production config and only include in `main-dev.php`.

---

#### SEC-H8: File Upload Vulnerabilities

**Affected Files:**
| File | Issue |
|------|-------|
| `protected/extensions/EAjaxUpload/qqFileUploader.php` line 65 | `$_GET['qqfile']` used as filename (path traversal) |
| `protected/modules/user/components/UWfile.php` line 51 | Original filename used without sanitization |

**Fix:**
```php
// Sanitize filename
$filename = preg_replace('/[^a-zA-Z0-9._-]/', '', basename($_GET['qqfile']));

// Whitelist extensions
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'xlsx', 'csv'];
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    throw new CHttpException(400, 'File type not allowed');
}

// Generate random filename to prevent overwrites
$safeName = uniqid() . '.' . $ext;
```

---

#### SEC-H9: Mass Assignment Vulnerability

**Fix:** Ensure all models have explicit `rules()` that only mark user-editable fields as `safe`:
```php
public function rules()
{
    return array(
        // Only these fields can be mass-assigned
        array('username, email, first_name, last_name', 'safe'),
        // Never: id, roles, status, create_by, etc.
    );
}
```

Review ALL model `rules()` methods and remove sensitive fields from `safe` validators.

---

### 19.4 MEDIUM Severity — Fix Within 1 Month

**Effort: Low** — All MEDIUM items are single-line or single-file config changes (param logging flag, cookie flags, json_encode flags, error display). Each fix takes minutes; testing adds a day.

#### SEC-M1: Error Param Logging Enabled

**File:** `protected/config/db.php` line 12 — `'enableParamLogging' => true`

**Fix:** Set to `false` in production (SQL parameters may contain passwords/sensitive data).

---

#### SEC-M2: Cookie Security Flags Missing

**Fix:** Add to session cookie config:
```php
'cookieParams' => array(
    'httpOnly' => true,
    'secure' => true,      // Requires HTTPS
    'sameSite' => 'Lax',   // CSRF protection
),
```

---

#### SEC-M3: json_encode Without Flags in Views

**Affected Files:** Multiple view files using `<?= json_encode($data) ?>` in `<script>` blocks.

**Fix:** Always use `json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)` when outputting into HTML contexts.

---

#### SEC-M4: Verbose Error Messages to Users

**File:** `protected/controllers/SiteController.php` lines 45-49

**Fix:** Show generic messages in production:
```php
if (YII_DEBUG) {
    echo $error['message'];
} else {
    echo 'An error occurred. Please try again.';
}
```

---

### 19.5 Summary Table

| ID | Vulnerability | Severity | CVSS | Files | Fix Effort |
|----|-------------|----------|------|-------|------------|
| SEC-C1 | SQL Injection (string interpolation) | CRITICAL | 9.8 | 5 controllers + 2 models | Medium (25+ queries) |
| SEC-C2 | MD5 Password Hashing | CRITICAL | 9.8 | Users.php + config | High (migration needed) |
| SEC-C3 | eval() RCE in RBAC | CRITICAL | 10.0 | 2 RBAC components | Medium |
| SEC-C4 | Debug Mode in Production | CRITICAL | 5.3 | index.php + config | Low |
| SEC-C5 | Hardcoded DB Credentials | CRITICAL | 7.5 | UsersController.php | Low |
| SEC-H1 | No CSRF Protection | HIGH | 6.5 | Config + all forms | Medium |
| SEC-H2 | XSS via json_encode in exceptions | HIGH | 7.1 | 15+ controllers | Low |
| SEC-H3 | XSS via .html() with AJAX | HIGH | 6.1 | 20+ views | Medium |
| SEC-H4 | XSS via innerHTML | HIGH | 6.1 | _alerts.php | Low |
| SEC-H5 | Session Fixation | HIGH | 6.2 | Login flow | Low |
| SEC-H6 | 60-Day Session Timeout | HIGH | 6.5 | Config | Low |
| SEC-H7 | Gii Weak Password | HIGH | 8.8 | Config | Low |
| SEC-H8 | File Upload Exploits | HIGH | 8.2 | 2 extensions | Medium |
| SEC-H9 | Mass Assignment | HIGH | 5.3 | All models | Medium |
| SEC-M1 | Param Logging Enabled | MEDIUM | 4.2 | db.php | Low |
| SEC-M2 | Cookie Flags Missing | MEDIUM | 4.3 | Config | Low |
| SEC-M3 | json_encode Without Flags | MEDIUM | 5.4 | Multiple views | Low |
| SEC-M4 | Verbose Error Messages | MEDIUM | 3.1 | SiteController | Low |

### 19.6 Fix Priority Order

**Phase A: Immediate (before any deployment)**
1. SEC-C4 — Disable debug mode (5 min)
2. SEC-C5 — Remove hardcoded credentials (5 min)
3. SEC-H7 — Secure or disable Gii (5 min)
4. SEC-H6 — Reduce session timeout (5 min)
5. SEC-M2 — Add cookie security flags (5 min)

**Phase B: Critical fixes (1-3 days)**
1. SEC-C1 — Parameterize all SQL queries (25+ instances)
2. SEC-H1 — Enable CSRF globally
3. SEC-C3 — Remove eval() from RBAC
4. SEC-H5 — Add session ID regeneration

**Phase C: High fixes (1-2 weeks)**
1. SEC-C2 — Migrate passwords to bcrypt (requires rollout plan)
2. SEC-H2 — Fix json_encode in exceptions
3. SEC-H3/H4 — Fix XSS in views
4. SEC-H8 — Secure file uploads
5. SEC-H9 — Audit model mass assignment rules

**Phase D: Medium fixes (ongoing)**
1. SEC-M1, SEC-M3, SEC-M4 — Config and output hardening

### 19.7 Acceptance Criteria

- [ ] Zero SQL queries use string interpolation with user input — all use parameter binding
- [ ] `password_hash(PASSWORD_BCRYPT)` used for all password storage
- [ ] No `eval()` calls in application code
- [ ] `YII_DEBUG` is `false` in production
- [ ] No hardcoded credentials in any PHP file
- [ ] CSRF validation enabled globally
- [ ] Session timeout ≤ 30 minutes
- [ ] Session ID regenerated on login
- [ ] Cookie flags: `httpOnly=true`, `sameSite=Lax`
- [ ] Gii disabled or IP-restricted in production
- [ ] All `json_encode()` in HTML contexts use `JSON_HEX_TAG`
- [ ] File uploads validate extension whitelist and sanitize filenames
- [ ] All models have explicit `safe` attribute lists (no sensitive fields)
- [ ] No `display_errors` in production config

---

---

## 20. Testing Strategy & QA Checklist

### 20.1 Approach

With 346 view files across 7 modules changing, automated testing is impractical for a Yii 1.x app without a test suite. Instead, this section defines a **prioritized manual test plan** organized by module and criticality.

### 20.2 Pre-Migration Baseline

Before starting any migration work:

**FR-TEST-1** — Capture full-page screenshots of every page listed in Section 20.4 using the current (pre-migration) codebase. Store in `docs/qa-screenshots/before/`.

**FR-TEST-2** — Record the following metrics per page (use browser DevTools → Network tab):
- Total page weight (transferred)
- Number of HTTP requests
- DOMContentLoaded time
- Load complete time

Store in `docs/qa-screenshots/before/metrics.md`.

### 20.3 Testing Methodology

For each page in the checklist:

1. **Visual comparison** — Side-by-side screenshot comparison (before vs after)
2. **Functional test** — Perform the listed actions and verify expected behavior
3. **Console check** — Open DevTools console, verify zero JS errors and zero 404s
4. **Responsive test** — Resize to 768px and 375px, verify layout doesn't break
5. **Print test** (where applicable) — Ctrl+P and verify print preview is clean

### 20.4 Module Test Checklists

#### Tier 1: Critical (test FIRST — revenue-affecting)

| # | Module | Page | URL Pattern | Actions to Test |
|---|--------|------|-------------|-----------------|
| 1 | **Dashboard** | Main dashboard | `/site/dashboard` | Cards render, stat numbers load via AJAX, charts display, action cards clickable, alerts widget loads low stock/dues |
| 2 | **Sell** | Sales order create | `/sell/sellOrder/create` | Form renders with floating labels, product autocomplete works, dynamic row add/remove, total calculation, save + voucher preview modal, print voucher |
| 3 | **Sell** | Sales order list (admin) | `/sell/sellOrder/admin` | Grid view loads, filters work, sort works, pagination works, action buttons (view/edit/delete) work, inline update dialog |
| 4 | **Sell** | Voucher preview | `/sell/sellOrder/voucherPreview` | Modal renders correctly, print button works, barcode displays |
| 5 | **Accounting** | Money receipt create | `/accounting/moneyReceipt/create` | Form renders, customer autocomplete, amount calculation, draft save to localStorage, submit + voucher preview |
| 6 | **Accounting** | Money receipt list | `/accounting/moneyReceipt/admin` | Grid view, filters, pagination, action buttons |
| 7 | **Commercial** | Purchase order create | `/commercial/purchaseOrder/create` | Form renders, supplier select, dynamic product rows, total calculation, save |
| 8 | **Commercial** | Purchase order list | `/commercial/purchaseOrder/admin` | Grid view, all CGridView features |
| 9 | **Inventory** | Stock report | `/inventory/inventory/stockReport` | Filter form with date pickers, AJAX table load, print, Excel export |
| 10 | **Login** | Login page | `/site/login` | Form renders, validation works, remember-me checkbox, submit |

#### Tier 2: High (test SECOND — daily operations)

| # | Module | Page | Actions to Test |
|---|--------|------|-----------------|
| 11 | **Sell** | Sales return create | Form, dynamic rows, save |
| 12 | **Sell** | Quotation create | Form, dynamic rows, save |
| 13 | **Sell** | Customer list | Grid view, inline edit dialog |
| 14 | **Accounting** | Payment receipt create | Form, save, voucher preview |
| 15 | **Accounting** | Expense create | Form, save |
| 16 | **Commercial** | Supplier list | Grid view, inline edit |
| 17 | **Inventory** | Stock ledger report | Date filter, AJAX load, print, Excel |
| 18 | **Inventory** | Product verify | Scan/search, result display |
| 19 | **Report** | Customer ledger | Date filter, customer select, table, print, Excel |
| 20 | **Report** | Supplier ledger | Same as above for suppliers |
| 21 | **Report** | Day in/out report | Date range, aggregation table |
| 22 | **Report** | Sales report | Filter, AJAX table, drill-down modal |
| 23 | **Report** | Purchase report | Same pattern |
| 24 | **Report** | Customer due report | Filter, grouped table |
| 25 | **Report** | Supplier due report | Same pattern |

#### Tier 3: Medium (test THIRD — admin/setup)

| # | Module | Page | Actions to Test |
|---|--------|------|-----------------|
| 26 | **Core** | Product models CRUD | Create form (floating label), list (grid), update, delete |
| 27 | **Core** | Product brands CRUD | Same pattern |
| 28 | **Core** | Product items CRUD | Same pattern |
| 29 | **Core** | Companies CRUD | Same pattern |
| 30 | **Core** | Units CRUD | Same pattern |
| 31 | **Core** | Manufacturers list | Grid view |
| 32 | **Users** | User list | Grid view with role badges, status toggle switch |
| 33 | **Users** | User create/edit | Form with role assignment |
| 34 | **Rights** | RBAC assignment | Role/permission grid |
| 35 | **Loan** | Loan management | CRUD forms + ledger report |
| 36 | **Report** | Expense summary/detail | Filter + table |
| 37 | **Report** | Price list | Table + Excel |
| 38 | **Report** | Fast/slow/dead stock | Filter + multi-tab results |
| 39 | **Report** | Inventory aging | Filter + aging buckets |
| 40 | **Report** | Product performance | Filter + metrics |

#### Tier 4: Edge Cases

| # | Test | What to Check |
|---|------|---------------|
| 41 | Mobile navbar | Hamburger menu opens/closes, submenus expand, active state highlights |
| 42 | Draft notification bell | Shows draft count, dropdown lists drafts, discard works, cross-tab sync via localStorage |
| 43 | Print: Sales voucher | A5 format, barcode renders, company header, line items table |
| 44 | Print: Money receipt | Voucher layout, amount in words |
| 45 | Print: Report table | Table headers repeat on pages, no navbar/footer |
| 46 | Excel export | Downloads .xls file, data matches table, headers present |
| 47 | Bootstrap switch → form-switch | All toggle switches function (user status, etc.) |
| 48 | File upload | Product model image upload works |
| 49 | Date pickers | Lightpick date range picker initializes on all report filter forms |
| 50 | jQuery UI autocomplete | Product search, customer search, supplier search all return results |

### 20.5 Regression Detection

**FR-TEST-3** — After each migration phase (Phases 1-7), re-test all Tier 1 pages before proceeding.

**FR-TEST-4** — After full migration, test ALL 50 items in the checklist above.

**FR-TEST-5** — Any visual regression (spacing, alignment, color, font) found during testing SHALL be logged with a screenshot and fixed before the phase is marked complete.

### 20.6 Screenshot Comparison Workflow

```
docs/qa-screenshots/
├── before/
│   ├── 01-dashboard.png
│   ├── 02-sell-order-create.png
│   ├── ...
│   └── metrics.md
├── after/
│   ├── 01-dashboard.png
│   ├── 02-sell-order-create.png
│   ├── ...
│   └── metrics.md
└── diffs/               (optional — visual diff overlay)
```

---

## 21. Yii Extension Widget Compatibility

### 21.1 Overview

The SRS core sections cover native Yii widgets (CGridView, CActiveForm, CLinkPager). This section addresses custom extensions in `protected/extensions/` that generate HTML markup and may contain Bootstrap 4/AdminLTE classes.

### 21.2 Extensions Generating HTML

#### 21.2.1 GroupGridView (`protected/extensions/groupgridview/`)

**Purpose:** CGridView subclass that groups rows by a column value (used in reporting tables).

**Risk:** Generates `<table>` markup with CSS classes. May use:
- `table`, `table-striped`, `table-bordered` (BS4 — compatible with BS5)
- Custom CSS in `groupgridview/assets/`

**Action Required:**
- Audit generated HTML for any BS4-only classes
- Check if the extension's CSS assets conflict with BS5
- Test with grouped report tables

#### 21.2.2 DynamicTabularForm (`protected/extensions/dynamictabularform/`)

**Purpose:** Generates dynamic add/remove form rows (used in sales order, purchase order detail lines).

**Risk:** May generate HTML with:
- `form-group` (must become `mb-3`)
- `form-control` (compatible)
- `input-group-append` / `input-group-prepend` (must be removed in BS5)
- `btn-default` (must become `btn-secondary`)
- `data-toggle` in JS-generated markup

**Action Required:**
- Read the extension source to find all HTML class generation
- Update class names in the extension PHP code
- Test dynamic row add/remove on sales order and purchase order forms

#### 21.2.3 EExcelView (`protected/extensions/EExcelView.php`)

**Purpose:** CGridView subclass that exports to Excel via PHPExcel.

**Risk:** Generates HTML table before converting to Excel. May include Bootstrap classes in cell rendering.

**Action Required:**
- Check if Bootstrap classes affect Excel output (they shouldn't — PHPExcel strips HTML classes)
- Verify Excel export still works after BS5 migration
- Low risk — Excel output is content-based, not style-based

#### 21.2.4 yii-pdf / HTML2PDF (`protected/extensions/yii-pdf/`)

**Purpose:** Server-side PDF generation from HTML templates.

**Affected views (10 voucher/invoice previews):**
- `accounting/moneyReceipt/voucherPreview.php`
- `accounting/paymentReceipt/voucherPreview.php`
- `accounting/expense/voucherPreview.php`
- `sell/sellOrder/voucherPreview.php`
- `sell/sellOrder/challanPreview.php`
- `sell/sellOrderQuotation/voucherPreview.php`
- `sell/sellOrderQuotation/challanPreview.php`
- `commercial/purchaseOrder/voucherPreview.php`
- `inventory/inventory/voucherPreview.php`
- `sell/sellReturn/warrantyVoucherPreview.php`

**Risk:** PDF templates use inline CSS and may reference:
- Bootstrap grid classes (`col-*`, `row`)
- Bootstrap table classes
- Font Awesome icons (rendered as text in PDF, not as font glyphs)

**Action Required:**
- Audit each voucher preview template for BS4 classes
- Update `data-toggle` / `data-dismiss` if present
- Test PDF generation after migration — HTML2PDF uses its own CSS parser, not a browser
- Verify barcode rendering still works (uses TCPDF 5.0.002)

#### 21.2.5 mPrint (`protected/extensions/mPrint/`)

**Purpose:** Client-side partial-page printing via jQuery iframe injection.

**Risk:** Copies DOM elements including their CSS classes into a print iframe. If BS5 classes differ from BS4, print output may break.

**Action Required:**
- Verify mPrint captures BS5-styled content correctly
- Test print output on 3+ reports after migration
- Check `mprint.css` for any BS4-specific overrides

#### 21.2.6 Bootstrap Extension (`protected/extensions/bootstrap/`) — DELETE

**Status:** 25+ EBootstrap* widget classes with ZERO usage. Delete entirely (already specified in Section 12).

### 21.3 Requirements

**FR-EXT-1** — `groupgridview` SHALL be audited and updated for BS5 class compatibility.

**FR-EXT-2** — `dynamictabularform` SHALL be audited and updated — specifically `form-group`, `input-group-append/prepend`, `btn-default`, and any `data-toggle` in generated HTML.

**FR-EXT-3** — All 10 voucher/invoice preview templates SHALL be tested for PDF generation after migration.

**FR-EXT-4** — `mPrint` print output SHALL be tested on at least 3 different report types.

**FR-EXT-5** — `EExcelView` Excel export SHALL be tested on at least 2 different grid views.

### 21.4 Acceptance Criteria

- [ ] GroupGridView renders correctly with BS5
- [ ] DynamicTabularForm add/remove rows work with BS5 classes
- [ ] All 10 voucher PDFs generate without errors
- [ ] mPrint print output matches screen display
- [ ] EExcelView export produces valid Excel files

---

## 22. JS-Generated HTML & Dynamic Content Migration

### 22.1 Problem Statement

The data attribute migration (Section 4, FR-2.1–FR-2.5) covers HTML in `.php` view files. However, **many views generate HTML dynamically via JavaScript** using `.html()`, `innerHTML`, template literals, or string concatenation. These JS-generated HTML strings also contain BS4 data attributes and classes that won't be caught by a simple find-replace on PHP files.

### 22.2 Affected Patterns

#### Pattern A: Modal Show/Hide in JS Strings

```javascript
// Found in 15+ view files
$('#myModal').modal('show');        // BS4 jQuery API — must become BS5 vanilla
$('#myModal').modal('hide');
```

**Files:** All report `*View.php` files, admin grid views with update dialogs, voucher preview handlers.

#### Pattern B: data-toggle in JS-Generated HTML

```javascript
// String concatenation building HTML with data attributes
html += '<button data-toggle="modal" data-target="#previewModal">View</button>';
```

**Action:** Search all `.php` files for `data-toggle` and `data-target` inside JavaScript string literals (both single and double quoted), template literals, and concatenation.

#### Pattern C: .html() Injecting Server-Rendered HTML

```javascript
$('#modal-body').html(response);  // response from renderPartial() may contain data-toggle
```

**Action:** The server-rendered HTML (from `renderPartial()`) will be updated when the PHP view files are updated. No additional JS changes needed for this pattern — but verify during testing.

#### Pattern D: innerHTML with Hardcoded HTML

```javascript
element.innerHTML = '<div class="form-group">...</div>';  // Must become mb-3
element.innerHTML = '<span class="label label-success">Active</span>';  // Must become badge bg-success
```

#### Pattern E: jQuery Plugin Calls

```javascript
$('[data-toggle="tooltip"]').tooltip();     // Must become BS5 API
$('.bootstrapSwitch').bootstrapSwitch();     // Must be removed (BS5 form-switch)
```

### 22.3 Search Strategy

**FR-JSHTML-1** — After completing PHP view file migration (Phases 2-3), perform a secondary search within `<script>` blocks for:

```
Pattern to search (in <script> blocks only):
- data-toggle
- data-dismiss
- data-target
- data-backdrop
- form-group
- btn-default
- label label-
- badge-primary (etc.)
- .modal(
- .tooltip(
- .popover(
- .collapse(
- .dropdown(
- .bootstrapSwitch(
- input-group-append
- input-group-prepend
- ml-auto, mr-auto, ml-1, mr-1 (etc.)
```

**FR-JSHTML-2** — Each match SHALL be updated to the BS5 equivalent per the class migration reference (Section 8).

**FR-JSHTML-3** — All `$('#x').modal('show/hide')` calls SHALL be migrated to:
```javascript
bootstrap.Modal.getOrCreateInstance(document.getElementById('x')).show();
// or shorthand helper (add to common.js):
function bsModal(id, action) {
    bootstrap.Modal.getOrCreateInstance(document.getElementById(id))[action]();
}
bsModal('myModal', 'show');
```

### 22.4 Acceptance Criteria

- [ ] Zero instances of `data-toggle` in any `<script>` block
- [ ] Zero instances of `.modal('show')` or `.modal('hide')` jQuery syntax
- [ ] Zero instances of `.bootstrapSwitch()` calls
- [ ] Zero instances of `.tooltip()` jQuery syntax (use BS5 vanilla)
- [ ] All dynamically generated HTML uses BS5 classes

---

## 23. Browser Cache Busting Strategy

### 23.1 Problem Statement

After swapping AdminLTE + BS4 assets for BS5 + new vendor libraries, users with cached CSS/JS will see broken pages until their cache expires. The migration must force browsers to fetch new assets immediately.

### 23.2 Current Cache Busting

Only `custom.css` uses cache busting:
```php
<link rel="stylesheet" href="<?= $themeUrl ?>/css/custom.css?v=<?= filemtime($themePath.'/css/custom.css') ?>">
```

All other CSS/JS files have NO cache busting — browsers cache indefinitely.

### 23.3 Requirements

**FR-CACHE-1** — ALL CSS and JS files loaded in layouts SHALL use `filemtime()` cache-busting query strings:
```php
<link rel="stylesheet" href="<?= $themeUrl ?>/vendor/bootstrap5/css/bootstrap.min.css?v=<?= filemtime($themePath.'/vendor/bootstrap5/css/bootstrap.min.css') ?>">
<script src="<?= $themeUrl ?>/vendor/jquery/jquery-3.7.1.min.js?v=<?= filemtime($themePath.'/vendor/jquery/jquery-3.7.1.min.js') ?>"></script>
```

**FR-CACHE-2** — For vendor libraries that rarely change, a manual version string is acceptable as an alternative:
```php
<script src="<?= $themeUrl ?>/vendor/jquery/jquery-3.7.1.min.js?v=3.7.1"></script>
```

**FR-CACHE-3** — The new consolidated CSS files (`form-components.css`, `report-tables.css`, `admin-grids.css`, `dashboard.css`) SHALL use `filemtime()` cache busting since they will change frequently during development.

**FR-CACHE-4** — Font Awesome 6 CSS SHALL use version-string cache busting (changes rarely):
```php
<link rel="stylesheet" href="<?= $themeUrl ?>/vendor/fontawesome6/css/all.min.css?v=6.5">
```

**FR-CACHE-5** — After deployment, verify in browser DevTools that:
- No old AdminLTE CSS/JS files are served from cache
- All new vendor files load with cache-busting query strings
- Second page load uses cached versions (304 Not Modified)

### 23.4 Layout Helper (Optional)

To reduce repetition in layouts, consider a PHP helper:
```php
// In Controller.php or a helper
function assetUrl($path) {
    $fullPath = Yii::app()->theme->basePath . '/' . $path;
    $url = Yii::app()->theme->baseUrl . '/' . $path;
    return $url . '?v=' . (file_exists($fullPath) ? filemtime($fullPath) : time());
}
```

---

## 24. Deployment & Migration Runbook

### 24.1 Pre-Deployment Preparation

| Step | Action | Responsible |
|------|--------|-------------|
| 1 | Complete all migration phases on development branch | Developer |
| 2 | Run full QA checklist (Section 20) on dev environment | QA / Developer |
| 3 | Capture "after" screenshots and performance metrics | Developer |
| 4 | Compare before/after screenshots for regressions | QA |
| 5 | Fix any visual regressions found | Developer |
| 6 | Re-test Tier 1 pages after fixes | QA |
| 7 | Create a git tag on `main` for rollback point: `git tag pre-frontend-migration` | Developer |

### 24.2 Deployment Steps (Production)

```
STEP 1: BACKUP (5 minutes)
─────────────────────────
□ SSH into production server
□ Create full backup of current theme directory:
    tar -czf /backups/themes-erp-$(date +%Y%m%d).tar.gz themes/erp/
□ Create database backup:
    mysqldump -u root -p ripon_ent > /backups/db-$(date +%Y%m%d).sql
□ Note the current git commit hash:
    git rev-parse HEAD > /backups/last-commit.txt

STEP 2: MAINTENANCE MODE (1 minute)
────────────────────────────────────
□ Enable maintenance page (if available) or notify users
□ Note: Yii 1.x has no built-in maintenance mode — consider adding
  a .maintenance file check in index.php

STEP 3: DEPLOY CODE (5 minutes)
───────────────────────────────
□ Pull the migration branch:
    git fetch origin
    git checkout main
    git pull origin main
□ Verify new vendor directory exists:
    ls themes/erp/vendor/bootstrap5/ themes/erp/vendor/jquery/ themes/erp/vendor/fontawesome6/
□ Verify old directories are removed:
    ls themes/erp/dist/    # Should not exist
    ls themes/erp/plugins/ # Should not exist

STEP 4: CLEAR CACHES (2 minutes)
────────────────────────────────
□ Clear Yii asset cache:
    rm -rf assets/*
□ Clear Yii runtime cache:
    rm -rf protected/runtime/cache/*
□ Clear browser cache on test device
□ Note: Yii publishes framework JS to /assets/ — this MUST be cleared
  so the new jQuery 3.7.1 from framework/web/js/source/ gets published

STEP 5: SMOKE TEST (10 minutes)
───────────────────────────────
□ Test login page — verify BS5 loads, form works
□ Test dashboard — verify cards, charts, stats load
□ Test sales order create — verify form, autocomplete, save
□ Test a report — verify filter, table, print, Excel
□ Open DevTools console — verify ZERO JS errors and ZERO 404s
□ Check jQuery version: run jQuery.fn.jquery in console — must be 3.7.1
□ Check Bootstrap version: run bootstrap.Tooltip.VERSION — must be 5.3.x

STEP 6: DISABLE MAINTENANCE MODE (1 minute)
────────────────────────────────────────────
□ Remove maintenance flag
□ Monitor for user-reported issues for 30 minutes
```

### 24.3 Rollback Procedure

If critical issues are found during or after deployment:

```
IMMEDIATE ROLLBACK (5 minutes)
──────────────────────────────
□ Re-enable maintenance mode
□ Restore from git:
    git checkout $(cat /backups/last-commit.txt)
□ Clear Yii asset cache:
    rm -rf assets/*
    rm -rf protected/runtime/cache/*
□ Verify old AdminLTE files are restored:
    ls themes/erp/dist/css/adminlte.min.css
□ Smoke test login + dashboard
□ Disable maintenance mode

ALTERNATIVE: Restore from backup
────────────────────────────────
□ tar -xzf /backups/themes-erp-YYYYMMDD.tar.gz -C /
□ rm -rf assets/*
□ Smoke test
```

### 24.4 Post-Deployment Monitoring

| Check | When | What |
|-------|------|------|
| Error logs | +1 hour | Check `protected/runtime/application.log` for new errors |
| User reports | +4 hours | Monitor for UI issues reported by users |
| Browser testing | +1 day | Test on Chrome, Firefox, Safari, Edge |
| Mobile testing | +1 day | Test on iOS Safari, Android Chrome |
| Performance metrics | +1 day | Compare load times to pre-migration baseline |

### 24.5 Password Migration (SEC-C2 Specific)

> **IRREVERSIBLE OPERATION — No Rollback After Phase 1**
> Once the password migration script runs and users begin logging in with bcrypt-hashed passwords, rolling back to MD5 is NOT possible without forcing all users to reset their passwords. This migration is one-way. Ensure a full database backup exists before proceeding. The 90-day dual-check window is the only "rollback" — after it expires, MD5 support must be fully removed.

The bcrypt password migration requires special handling since it cannot be rolled back:

```
PHASE 1 (deploy with migration code):
□ Add password_hash column to users table (VARCHAR 255, nullable)
□ Deploy dual-check login: try bcrypt first, fall back to MD5
□ On successful MD5 login, rehash with bcrypt and store in password_hash

PHASE 2 (after 90 days):
□ Check how many users still have MD5-only passwords
□ Force password reset for remaining MD5 users
□ Drop old password column
□ Remove MD5 fallback code
```

---

## 25. Database Query Optimization

> **Phase B — Extended Scope (Optional)**
> This section is outside the core frontend migration scope. It should be treated as a separate enhancement initiative (Phase B) and is NOT a blocker for Phase A completion. Implement only after Phase A (Phases 0–7) is fully complete and tested.

### 25.1 Current State

| Pattern | Count | Files |
|---------|-------|-------|
| Raw SQL (`createCommand`) | 10+ queries | ReportController.php |
| N+1 query loops | 4+ critical loops | ReportController, SellOrderController, InventoryController, PurchaseOrderController |
| Empty `relations()` in models | 2+ models | ProdModels.php, Inventory.php |
| Eager loading (`with()`) | 1 instance | UserModule.php |
| Parameterized queries | 2 instances | ReportController (loan ledger only) |
| String-interpolated WHERE | 25+ instances | Multiple controllers (also SQL injection — see SEC-C1) |

### 25.2 Critical N+1 Problems

#### N+1-1: Inventory Aging Report

**File:** `protected/controllers/ReportController.php` lines 1331-1391

```php
foreach ($products as $p) {                    // Loop over all products
    $closingStock = Yii::app()->db->createCommand(  // Query 1 per product
        "SELECT SUM(stock_in - stock_out)..."
    )->queryScalar();

    $batches = Yii::app()->db->createCommand(       // Query 2 per product
        "SELECT id, date, stock_in..."
    )->queryAll();
}
// For 100 products: 200+ queries
```

**Fix:** Single query with GROUP BY + window functions, or pre-fetch all inventory data and process in PHP:
```php
// Pre-fetch all inventory in one query
$allInventory = Yii::app()->db->createCommand(
    "SELECT model_id, SUM(stock_in - stock_out) as closing_stock,
     id, date, stock_in, stock_out
     FROM inventory WHERE date <= :dateTo AND is_deleted = 0
     GROUP BY model_id"
)->bindParam(':dateTo', $dateTo)->queryAll();
// Then loop over results in PHP — 1 query instead of 200
```

#### N+1-2: Sales Order Save

**File:** `protected/modules/sell/controllers/SellOrderController.php` lines 349-371

```php
foreach ($sellOrderDetails as $detail) {
    $product = ProdModels::model()->findByPk($detail->model_id);  // N+1
    // ...
}
```

**Fix:** Pre-fetch all products for the order:
```php
$modelIds = array_map(function($d) { return $d->model_id; }, $sellOrderDetails);
$products = ProdModels::model()->findAllByAttributes(array('id' => $modelIds));
$productMap = array();
foreach ($products as $p) $productMap[$p->id] = $p;
// Then use $productMap[$detail->model_id] in the loop
```

#### N+1-3: Inventory Price Fix

**File:** `protected/modules/inventory/controllers/InventoryController.php` lines 704-792

Multiple `findByPk()` calls inside a loop (lines 720, 761, 766, 773).

**Fix:** Same pre-fetch pattern — collect all IDs first, batch-load, then loop.

#### N+1-4: Purchase Order Save

**File:** `protected/modules/commercial/controllers/PurchaseOrderController.php` lines 70-90

```php
foreach ($_POST['PurchaseOrderDetails']['temp_model_id'] as $key => $model_id) {
    $product = ProdModels::model()->findByPk($model_id);  // N+1
}
```

**Fix:** Same pre-fetch pattern.

### 25.3 Missing Model Relations

#### ProdModels.php (line 116)

```php
public function relations() {
    return array();  // EMPTY
}
```

**Should define:**
```php
public function relations() {
    return array(
        'manufacturer' => array(self::BELONGS_TO, 'Manufacturers', 'manufacturer_id'),
        'prodItem' => array(self::BELONGS_TO, 'ProdItems', 'prod_item_id'),
        'prodBrand' => array(self::BELONGS_TO, 'ProdBrands', 'prod_brand_id'),
        'inventories' => array(self::HAS_MANY, 'Inventory', 'model_id'),
        'sellPrices' => array(self::HAS_MANY, 'SellPrice', 'model_id'),
    );
}
```

#### Inventory.php (line 132)

```php
public function relations() {
    return array();  // EMPTY
}
```

**Should define:**
```php
public function relations() {
    return array(
        'prodModel' => array(self::BELONGS_TO, 'ProdModels', 'model_id'),
        'supplier' => array(self::BELONGS_TO, 'Suppliers', 'supplier_id'),
    );
}
```

### 25.4 Index Recommendations

Fields frequently used in WHERE clauses that should have database indexes:

| Table | Column(s) | Query Type | Priority |
|-------|----------|------------|----------|
| `inventory` | `model_id, date` | Composite — aging, ledger reports | HIGH |
| `inventory` | `is_deleted` | Filter on most queries | HIGH |
| `inventory` | `source_id` | Lookup in price fix loops | HIGH |
| `sell_order` | `customer_id, date` | Ledger, due reports | HIGH |
| `sell_order` | `is_deleted` | Filter on most queries | HIGH |
| `purchase_order` | `supplier_id, date` | Ledger, due reports | HIGH |
| `money_receipt` | `customer_id, date` | Ledger reports | MEDIUM |
| `sell_order_details` | `sell_order_id` | Detail lookups | MEDIUM |
| `sell_order_details` | `model_id` | Product performance | MEDIUM |
| `purchase_order_details` | `purchase_order_id` | Detail lookups | MEDIUM |

**FR-DB-1** — Run `SHOW INDEX FROM table_name` for each table above and add missing indexes.

### 25.5 Requirements

**FR-DB-2** — All N+1 query patterns identified in Section 25.2 SHALL be refactored to use batch pre-fetching.

**FR-DB-3** — `ProdModels` and `Inventory` models SHALL have proper `relations()` defined.

**FR-DB-4** — All raw SQL queries in ReportController SHALL use parameter binding (overlaps with SEC-C1).

**FR-DB-5** — Missing database indexes SHALL be added for frequently queried columns.

### 25.6 Acceptance Criteria

- [ ] Inventory aging report executes ≤5 queries regardless of product count
- [ ] Sales order save executes ≤10 queries regardless of line item count
- [ ] ProdModels and Inventory models have non-empty `relations()`
- [ ] Zero raw SQL queries use string interpolation
- [ ] All recommended indexes exist in database schema

---

## 26. Error Handling & User Feedback Standardization

> **Phase B — Extended Scope (Optional)**
> This section is outside the core frontend migration scope. It should be treated as a separate enhancement initiative (Phase B) and is NOT a blocker for Phase A completion. Implement only after Phase A (Phases 0–7) is fully complete and tested.

### 26.1 Current State

The app uses **5 different feedback mechanisms** inconsistently:

| Mechanism | Count | Used For |
|-----------|-------|----------|
| Flash messages (`setFlash`) | 26 instances | Page-reload feedback (success/error) |
| Toastr notifications | 172 instances | AJAX feedback, validation, warnings |
| JSON responses (`CJSON::encode`) | 123 instances | AJAX status + data |
| `CHttpException` | 28 instances | HTTP errors (404, 400, 500) |
| Native `alert()` / `confirm()` | 20 instances | Validation + delete confirmations |
| Alertify | 0 active calls | Loaded but unused (dead library) |

**Issues:**
- Flash keys inconsistent: `'success'`, `'error'`, `'recoveryMessage'`, `'profileMessage'`, etc.
- No global AJAX error handler — every request implements its own `error:` callback
- Native `alert()` / `confirm()` used instead of styled modals
- Error page (`site/error.php`) is bare-bones with minimal styling
- AJAX validation disabled on all forms (`enableAjaxValidation: false`)

### 26.2 Standard Patterns (To Implement)

#### Pattern 1: AJAX Response Format

All AJAX endpoints SHALL return this JSON structure:
```json
{
    "status": "success" | "error",
    "message": "Human-readable message",
    "data": { ... }  // Optional: additional payload
}
```

No other keys (`'soReportInfo'`, `'remove_rows'`, etc.) at the root level — put them inside `data`.

#### Pattern 2: Global AJAX Error Handler

Add to `common.js` (Section 15):
```javascript
$(document).ajaxError(function(event, xhr, settings) {
    if (xhr.status === 401) {
        window.location.href = '/site/login';
    } else if (xhr.status === 403) {
        toastr.error('You do not have permission to perform this action.');
    } else if (xhr.status >= 500) {
        toastr.error('Server error. Please try again or contact support.');
    }
});
```

#### Pattern 3: Flash Message Keys

Standardize to **3 keys only**:
- `'success'` → displayed as `alert-success` (green)
- `'error'` → displayed as `alert-danger` (red)
- `'warning'` → displayed as `alert-warning` (amber)

Module-specific keys (`'recoveryMessage'`, `'profileMessage'`) SHALL be replaced.

#### Pattern 4: Delete Confirmations

Replace all native `confirm()` dialogs with Bootstrap 5 modal:
```javascript
// Add to common.js
function confirmAction(message, callback) {
    var modal = document.getElementById('confirm-modal');
    modal.querySelector('.modal-body').textContent = message;
    var btn = modal.querySelector('.btn-confirm');
    btn.onclick = function() {
        bootstrap.Modal.getInstance(modal).hide();
        callback();
    };
    bootstrap.Modal.getOrCreateInstance(modal).show();
}
```

Add a global confirm modal to `column1.php` layout.

#### Pattern 5: Error Page

Redesign `themes/erp/views/site/error.php` with:
- Proper card layout matching design system
- Friendly error messages per HTTP code (404: "Page not found", 403: "Access denied", 500: "Something went wrong")
- "Go to Dashboard" and "Go Back" buttons
- No stack traces in production

### 26.3 Requirements

**FR-ERR-1** — All AJAX responses SHALL use the standard `{status, message, data}` format.

**FR-ERR-2** — A global AJAX error handler SHALL be added to `common.js`.

**FR-ERR-3** — Flash message keys SHALL be standardized to `success`, `error`, `warning` only.

**FR-ERR-4** — All native `alert()` calls (12 instances) SHALL be replaced with `toastr` calls.

**FR-ERR-5** — All native `confirm()` calls (8 instances) SHALL be replaced with Bootstrap 5 confirm modals.

**FR-ERR-6** — The error page (`site/error.php`) SHALL be redesigned with proper styling.

**FR-ERR-7** — Alertify library SHALL be removed from `main.php` layout (loaded but never called).

### 26.4 Acceptance Criteria

- [ ] All AJAX responses follow `{status, message, data}` format
- [ ] Global AJAX error handler exists in `common.js`
- [ ] Only 3 flash keys used: `success`, `error`, `warning`
- [ ] Zero native `alert()` calls remain
- [ ] Zero native `confirm()` calls remain
- [ ] Error page properly styled with design system
- [ ] Alertify JS removed from layout

---

## 27. Framework Patches Registry

### 27.1 Purpose

The Yii 1.x framework source has been directly modified for PHP 8.x compatibility. The jQuery core replacement (Section 13) adds another framework modification. This registry documents every patch to prevent surprises during any framework update and to ensure `yiilite.php` (compiled framework) stays in sync.

### 27.2 Existing PHP 8.x Compatibility Patches (13 files)

| File | Patch Category | What Changed |
|------|---------------|-------------|
| `framework/db/schema/CDbColumnSchema.php` | strpos strict | `strpos(...)` → `strpos(...) !== false` |
| `framework/db/schema/pgsql/CPgsqlColumnSchema.php` | strpos strict | Same pattern |
| `framework/db/schema/oci/COciColumnSchema.php` | strpos strict | Same pattern |
| `framework/utils/CPropertyValue.php` | Null guard + cast | Null check before array conversion; `(bool)` instead of `(boolean)` |
| `framework/utils/CTimestamp.php` | Null guard + cast | Null guard for `$fmt`; `(string)` cast on `$year` |
| `framework/web/helpers/CJSON.php` | String cast | `(string)` cast on `strlen()` argument |
| `framework/web/CHttpRequest.php` | Deprecated cast | `(double)` → `(float)` (4 occurrences) |
| `framework/web/CController.php` | strpos strict | `strpos()` → `strpos(...) !== false` |
| `framework/web/widgets/CWidget.php` | strpos strict | Same pattern |
| `framework/logging/CLogFilter.php` | String interpolation | `"${var}"` → concatenation (PHP 8.2 deprecation) |
| `framework/validators/CTypeValidator.php` | Deprecated cast | `(boolean)` → `(bool)` |
| `framework/yiilite.php` | Multiple | Compiled copy — mirrors patches for CHttpRequest, CController, CWidget |
| `framework/yiic.php` | Minor | Referenced in patch set |

### 27.3 New Patches (This Migration)

| File | Patch Category | What Changed |
|------|---------------|-------------|
| `framework/web/js/source/jquery.js` | jQuery upgrade | Replaced jQuery 1.12.4 → 3.7.1 (uncompressed) |
| `framework/web/js/source/jquery.min.js` | jQuery upgrade | Replaced jQuery 1.12.4 → 3.7.1 (minified) |
| `framework/web/js/source/jquery.bgiframe.js` | Dead code removal | Deleted — IE6 z-index hack, obsolete |

### 27.4 Potentially Needed Patches (Verify During Migration)

| File | Issue | Action |
|------|-------|--------|
| `framework/web/js/source/jquery.ajaxqueue.js` | May use removed jQuery 1.x APIs | Audit for `.bind()`, `.delegate()`, `$.isArray()` |
| `framework/web/js/source/jquery.autocomplete.js` | Old jQuery UI pattern | Audit for removed APIs |
| `framework/web/js/source/jquery.ba-bbq.js` | Uses deprecated APIs | Audit for `$.browser`, `deferred.pipe()` |
| `framework/web/js/source/jquery.metadata.js` | May use removed APIs | Audit |
| `framework/web/js/source/jquery.yiiactiveform.js` | Core form validation | Audit — MUST work with jQuery 3.7 |
| `framework/web/js/source/jquery.yii.js` | Core adapter | Audit — MUST work with jQuery 3.7 |

### 27.5 Maintenance Rules

**FR-FW-1** — Every modification to a file in `framework/` SHALL be documented in this registry with file path, patch category, and description.

**FR-FW-2** — After modifying any framework source file, the corresponding section in `framework/yiilite.php` SHALL be updated to match.

**FR-FW-3** — The registry SHALL be stored in `docs/architecture/framework-compat.md` (existing file — update with jQuery patches).

**FR-FW-4** — Before applying any future Yii 1.x patch or update, check this registry to re-apply all custom patches.

---

## 28. Print & PDF Export Standardization

### 28.1 Current State

The app uses **4 different export mechanisms** across reports and vouchers:

| Mechanism | Library | Used In | Count |
|-----------|---------|---------|-------|
| **Client-side print** | mPrint extension (jQuery iframe) | Report views | 22 views |
| **Client-side Excel** | jquery.table2excel.js (jQuery plugin) | Report views | 22 views |
| **Server-side PDF** | HTML2PDF + TCPDF 5.0.002 | Voucher/invoice previews | 10 views |
| **Server-side Excel** | EExcelView + PHPExcel | Grid views (available but NOT actively used) | 0 active |

### 28.2 Issues

1. **Print buttons** are implemented inline in each report view — duplicate JS across 22 files
2. **Excel export** initialization is inline in each view — duplicate JS across 22 files
3. **PDF vouchers** use TCPDF 5.0.002 (2010-era) — consider if upgrade needed
4. **Print CSS** is scattered: `css/print.css` (Blueprint), `themes/erp/css/print.css` (custom), `themes/erp/css/report.css`, `mprint.css`, plus inline `@media print` blocks in 20 report views
5. **No consistent print header/footer** — each voucher implements its own

### 28.3 Standardized Pipeline

#### For Reports (22 views):

```
PRINT:   Click print → report-filters.js → mPrint widget captures table → browser print dialog
EXCEL:   Click export → report-filters.js → table2excel captures table → .xls download
```

Extract all print/Excel button handlers to `report-filters.js` (Section 15):
```javascript
// report-filters.js
function initReportExport(tableId, reportName) {
    $('#btn-print').on('click', function() {
        // mPrint logic
    });
    $('#btn-excel').on('click', function() {
        $('#' + tableId).table2excel({
            filename: reportName + '_' + new Date().toISOString().slice(0,10),
            fileext: '.xls'
        });
    });
}
```

#### For Vouchers/Invoices (10 views):

```
PREVIEW: Click preview → AJAX renderPartial → modal → inline print styles
PRINT:   Click print in modal → window.print() → @page CSS handles layout
PDF:     (If needed) Server-side HTML2PDF generates downloadable PDF
```

No change to PDF pipeline — HTML2PDF/TCPDF works independently of Bootstrap.

### 28.4 Print CSS Consolidation

Create a unified print stylesheet:

**File:** `themes/erp/css/print-report.css` (~50 lines)

```css
@media print {
    /* Hide UI chrome */
    .erp-nav, .erp-footer, .report-filters, .btn-print, .btn-excel,
    .no-print { display: none !important; }

    /* Table formatting */
    .summaryTab { width: 100%; border-collapse: collapse; }
    .summaryTab th, .summaryTab td { border: 1px solid #000; padding: 4px 6px; }
    .summaryTab thead th { background: #eee !important; -webkit-print-color-adjust: exact; }

    /* Page setup */
    @page { margin: 1.5cm; }
    body { font-size: 10pt; }
}
```

This replaces the inline `@media print` blocks in 20 report views.

### 28.5 Requirements

**FR-PRINT-1** — Print and Excel export button handlers SHALL be extracted from individual report views into `report-filters.js`.

**FR-PRINT-2** — A unified `print-report.css` SHALL be created and loaded in report views, replacing inline `@media print` blocks.

**FR-PRINT-3** — All 10 voucher preview templates SHALL be tested for print output after BS5 migration.

**FR-PRINT-4** — The legacy `css/print.css` (Blueprint print styles) SHALL be deleted (already dead — Section 12).

**FR-PRINT-5** — `themes/erp/css/report.css` SHALL be reviewed and merged into `report-tables.css` if overlapping.

### 28.6 Acceptance Criteria

- [ ] Print button works on all 22 report views
- [ ] Excel export works on all 22 report views
- [ ] Print/Excel JS logic centralized in `report-filters.js`
- [ ] Unified `print-report.css` replaces inline `@media print` blocks
- [ ] All 10 voucher prints produce correct output
- [ ] PDF generation works for all voucher types

---

## 29. Performance Baseline Metrics

### 29.1 Purpose

To verify the "97% asset reduction" claim and measure real-world improvement, we must capture before/after metrics on the same pages using the same network conditions.

### 29.2 Measurement Pages

Capture metrics on these 5 representative pages:

| Page | URL | Why |
|------|-----|-----|
| Login | `/site/login` | First page users see, minimal JS |
| Dashboard | `/site/dashboard` | Heaviest page — charts, AJAX, animations |
| Sales order create | `/sell/sellOrder/create` | Complex form with dynamic rows, autocomplete |
| Report (customer ledger) | `/report/customerLedger` | AJAX table load, date picker, print/Excel |
| Admin grid (product models) | `/prodModels/admin` | CGridView with filters, pagination, action buttons |

### 29.3 Metrics to Capture

For each page, record in `docs/qa-screenshots/metrics.md`:

| Metric | How to Measure |
|--------|---------------|
| **Total CSS transferred** (KB) | DevTools → Network → filter CSS → Size column → sum |
| **Total JS transferred** (KB) | DevTools → Network → filter JS → Size column → sum |
| **Total requests** | DevTools → Network → bottom bar request count |
| **DOMContentLoaded** (ms) | DevTools → Network → bottom bar timing |
| **Load complete** (ms) | DevTools → Network → bottom bar timing |
| **Largest Contentful Paint** (ms) | DevTools → Performance → LCP marker |
| **JS errors in console** | DevTools → Console → error count |
| **404 requests** | DevTools → Console → failed resource count |

### 29.4 Expected Improvements

| Metric | Before (Est.) | After (Est.) | Change |
|--------|--------------|-------------|--------|
| CSS transferred (login) | ~750 KB | ~250 KB | -67% |
| CSS transferred (dashboard) | ~780 KB | ~280 KB | -64% |
| JS transferred (dashboard) | ~370 KB | ~260 KB | -30% |
| Total requests (dashboard) | ~15 | ~12 | -20% |
| Static asset disk size | 72 MB | 2.4 MB | -97% |
| Duplicate jQuery loads | 2 | 1 | -50% |
| Duplicate toastr CSS loads | 2 | 1 | -50% |
| JS console errors | TBD | 0 | Clean |
| 404 requests | TBD | 0 | Clean |

### 29.5 Requirements

**FR-METRICS-1** — Before starting migration, capture all metrics for the 5 measurement pages and store in `docs/qa-screenshots/before/metrics.md`.

**FR-METRICS-2** — After completing migration, capture the same metrics and store in `docs/qa-screenshots/after/metrics.md`.

**FR-METRICS-3** — Total CSS payload SHALL decrease by at least 50%.

**FR-METRICS-4** — Total JS payload SHALL not increase.

**FR-METRICS-5** — Zero JS console errors on all 5 measurement pages.

**FR-METRICS-6** — Zero 404 resource requests on all 5 measurement pages.

**FR-METRICS-7** — DOMContentLoaded time SHALL not increase by more than 10% on any page (migration should improve or maintain load times, not degrade them).

### 29.6 Metrics Template

```markdown
# Performance Metrics — [Before/After]
Date: YYYY-MM-DD
Browser: Chrome XXX
Network: [Throttling setting or "No throttling"]

## Login Page (/site/login)
- CSS transferred: ___ KB
- JS transferred: ___ KB
- Total requests: ___
- DOMContentLoaded: ___ ms
- Load complete: ___ ms
- LCP: ___ ms
- JS errors: ___
- 404 requests: ___

## Dashboard (/site/dashboard)
[same fields]

## Sales Order Create (/sell/sellOrder/create)
[same fields]

## Customer Ledger Report (/report/customerLedger)
[same fields]

## Product Models Admin (/prodModels/admin)
[same fields]
```

---

## 30. Responsive Design & Multi-Device Support

### 30.1 Requirement

The application MUST be fully responsive and functional on all device categories:

| Device Category | Min Viewport | Examples | Priority |
|----------------|-------------|----------|----------|
| Small phones | 375px | iPhone SE, Galaxy A | HIGH |
| Standard phones | 414px | iPhone 14, Pixel 7 | HIGH |
| Tablets portrait | 768px | iPad Mini, iPad Air | HIGH |
| Tablets landscape | 1024px | iPad Pro landscape | MEDIUM |
| Laptops | 1280px | MacBook, ThinkPad | HIGH (primary) |
| Large monitors | 1920px | External monitors | MEDIUM |

### 30.2 Current Responsive Issues

The existing codebase has these known responsive problems:

| Issue | Affected Views | Root Cause |
|-------|---------------|------------|
| Tables overflow horizontally on mobile | All CGridView admin pages, all report tables | No `.table-responsive` wrapper |
| Form fields don't stack on narrow screens | Most `_form.php` views | Fixed `col-md-*` without `col-12` fallback |
| Dashboard cards stay in 4 columns on tablet | `dashBoard.php` | Fixed column layout, no responsive grid |
| Action buttons too small for touch | All admin grids | `34px` buttons below touch target minimum |
| Voucher modal too narrow on phone | All voucher preview modals | Default Bootstrap modal size |
| Footer text overlaps on narrow screens | `column1.php` footer | No `flex-wrap` |
| Print/export buttons overflow | All report filter bars | Inline layout without stacking |
| Navbar dropdowns cut off on phone | `UserMenu.php` | Absolute positioning without viewport check |

### 30.3 Responsive Requirements by Component

#### FR-RESP-1: Viewport Meta Tag

ALL layouts SHALL include:
```html
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
```
`maximum-scale=5` (NOT `1`) — never disable pinch-to-zoom (accessibility requirement).

#### FR-RESP-2: Navigation

- Navbar SHALL collapse to hamburger at `<992px`
- Mobile menu SHALL be scrollable (`max-height: 80vh; overflow-y: auto`)
- All touch targets in mobile menu SHALL be minimum `44px` height
- Dropdown submenus SHALL expand inline (not flyout) on mobile

#### FR-RESP-3: Form Cards

- Form cards SHALL be max-width `720px` centered on desktop
- Form cards SHALL be full-width on tablet and mobile
- Form fields SHALL stack to single column at `<768px`
- Submit/cancel buttons SHALL be full-width at `<576px`
- Card padding SHALL reduce from `24px 28px` to `16px` at `<576px`
- All grid layouts SHALL use `col-12 col-md-6` (not just `col-md-6`) to ensure mobile stacking

#### FR-RESP-4: Tables (Grid Views & Reports)

- ALL tables SHALL be wrapped in `.table-responsive` for horizontal scrolling on mobile
- Table font-size SHALL reduce to `11px` at `<576px`
- Cell padding SHALL reduce to `4px 6px` at `<576px`
- Low-priority columns MAY be hidden on mobile using `.d-none .d-md-table-cell`
- Action buttons SHALL increase to `42px` at `<576px` for touch targets

#### FR-RESP-5: Dashboard

- Stat cards: `col-12 col-sm-6 col-lg-3` (4→2→1 columns)
- Today tiles: `col-6 col-sm-3` (4→2 columns)
- Action cards: `col-6 col-sm-4 col-lg-2` (6→3→2 columns)
- Stat numbers: `32px` → `24px` at `<768px`
- Chart widgets SHALL resize to container width

#### FR-RESP-6: Modals

- Voucher preview modals SHALL use `.modal-fullscreen-sm-down` (full screen at `<576px`)
- Report detail modals SHALL use `.modal-lg` with scroll
- All modals SHALL be dismissible by swipe-down gesture (BS5 default)

#### FR-RESP-7: Pagination

- Full pagination with page numbers at `≥768px`
- Compact pagination (prev/next only) at `<768px`

#### FR-RESP-8: Print/Export Buttons

- Show text + icon at `≥768px`: `<i class="fas fa-print"></i> Print`
- Show icon only at `<768px`: `<i class="fas fa-print"></i>` (text hidden with `.d-none .d-md-inline`)
- Stack buttons vertically at `<576px`

#### FR-RESP-9: Footer

- Flex layout SHALL use `flex-wrap: wrap` and center-align on mobile
- Stack copyright and version text vertically at `<576px`

#### FR-RESP-10: Touch Targets

For touch devices (`@media (pointer: coarse)`):
- Minimum interactive element size: `44px × 44px`
- Form inputs: `min-height: 48px`
- Nav items: `padding: 16px 14px`
- Dropdown items: `padding: 10px 14px`
- Pagination links: `min-width: 40px; min-height: 40px`

### 30.4 Device Testing Matrix

| Page | 375px | 768px | 1024px | 1280px | 1920px |
|------|-------|-------|--------|--------|--------|
| Login | [ ] | [ ] | [ ] | [ ] | [ ] |
| Dashboard | [ ] | [ ] | [ ] | [ ] | [ ] |
| Sales order create | [ ] | [ ] | [ ] | [ ] | [ ] |
| Sales order admin | [ ] | [ ] | [ ] | [ ] | [ ] |
| Purchase order create | [ ] | [ ] | [ ] | [ ] | [ ] |
| Money receipt create | [ ] | [ ] | [ ] | [ ] | [ ] |
| Stock report | [ ] | [ ] | [ ] | [ ] | [ ] |
| Customer ledger | [ ] | [ ] | [ ] | [ ] | [ ] |
| Product models CRUD | [ ] | [ ] | [ ] | [ ] | [ ] |
| Voucher preview | [ ] | [ ] | [ ] | [ ] | [ ] |

### 30.5 Acceptance Criteria

- [ ] No horizontal page overflow at any viewport width ≥375px
- [ ] All tables scrollable horizontally on mobile (no content cut off)
- [ ] All form fields stack to single column at `<768px`
- [ ] All touch targets ≥44px on touch devices
- [ ] Dashboard cards reflow correctly at each breakpoint
- [ ] Navbar hamburger menu works on mobile
- [ ] All modals are usable on phone screens
- [ ] Print/export buttons accessible on mobile
- [ ] Footer doesn't overlap on narrow screens
- [ ] `maximum-scale` is NOT set to `1` (pinch zoom allowed)
- [ ] Text is readable without horizontal scrolling at 375px width
- [ ] Orientation change (portrait ↔ landscape) doesn't break layout

---

*End of SRS Document*
