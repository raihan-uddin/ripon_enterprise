---
name: frontend-design
description: "Frontend design system guideline for Ripon Enterprise ERP. Enforces consistent styling across all views — colors, typography, spacing, components, animations. Use when creating or modifying any view, form, report, dashboard, or UI component."
trigger: auto
---

# Ripon Enterprise ERP — Frontend Design System

This is the canonical design guideline for all frontend work. Every view, form, report, grid, modal, and component MUST follow this system. No exceptions.

## Design Philosophy

- **Dark chrome, light canvas** — navbar/footer use slate-900, content area is white/light gray
- **Indigo accent throughout** — primary actions, focus states, active indicators all use the indigo palette
- **Elevated cards** — content lives in floating cards with subtle shadows, never flat on the page
- **Floating labels** — all form inputs use the floating-label pattern with animated transitions
- **Soft semantic colors** — action buttons use tinted backgrounds (not bold fills) for a calm, professional feel
- **Motion with purpose** — hover lifts, focus rings, staggered reveals. Never gratuitous animation

---

## 1. Color Tokens

All colors MUST use these exact values. Define as CSS custom properties when creating new shared stylesheets.

### Primary Palette (Indigo)

```
--c-primary:        #6366f1    /* Main accent — focus rings, active states, icons */
--c-primary-base:   #4f46e5    /* Button base */
--c-primary-hover:  #4338ca    /* Button hover */
--c-primary-active: #3730a3    /* Button press */
--c-primary-soft:   #eef2ff    /* Tinted backgrounds */
--c-primary-border: #c7d2fe    /* Soft borders on primary elements */
--c-primary-glow:   rgba(99,102,241,.12)   /* Focus ring shadow */
```

### Secondary Palette (Purple — gradients only)

```
--c-secondary:      #7c3aed    /* Gradient end point */
--c-secondary-light:#8b5cf6    /* Dashboard avatar gradient end */
```

### Gradient (Primary → Secondary)

```
--g-brand: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%)   /* Card headers */
--g-brand-light: linear-gradient(135deg, #6366f1, #7c3aed)     /* Buttons, avatars */
--g-brand-alt: linear-gradient(135deg, #6366f1, #8b5cf6)       /* Dashboard stat cards */
```

### Semantic Colors

| Token | Base | Dark | Hover | Shadow (50%) |
|-------|------|------|-------|-------------|
| Success | `#22c55e` | `#15803d` | `#16a34a` | `rgba(34,197,94,.5)` |
| Danger | `#ef4444` | `#b91c1c` | `#dc2626` | `rgba(239,68,68,.5)` |
| Warning | `#f59e0b` | `#b45309` | `#d97706` | `rgba(245,158,11,.5)` |
| Info | `#3b82f6` | `#1d4ed8` | `#2563eb` | `rgba(59,130,246,.5)` |
| Cyan | `#06b6d4` | `#0e7490` | `#0891b2` | `rgba(6,182,212,.5)` |
| Teal | `#14b8a6` | `#0f766e` | `#0d9488` | `rgba(20,184,166,.5)` |
| Rose | `#f43f5e` | `#be123c` | `#e11d48` | `rgba(244,63,94,.5)` |

### Neutral Scale

```
--c-text-primary:    #111827    /* Headings, strong text */
--c-text-secondary:  #374151    /* Body text */
--c-text-tertiary:   #6b7280    /* Labels, captions */
--c-text-muted:      #94a3b8    /* Placeholders, disabled */
--c-text-faint:      #d1d5db    /* Very light text */

--c-bg-page:         #f8fafc    /* Page background (card footer, sections) */
--c-bg-card:         #ffffff    /* Card body */
--c-bg-section:      #f8faff    /* Nested section inside card */
--c-bg-hover:        #fafbff    /* Section hover */

--c-border:          #e2e8f0    /* Default borders */
--c-border-light:    #f1f5f9    /* Subtle dividers */
--c-border-input:    #e2e8f0    /* Input borders */
--c-border-hover:    #94a3b8    /* Input hover border */
```

### Dark Chrome (Navbar / Footer / Dropdowns)

```
--c-chrome-bg:       #0f172a    /* Navbar & footer background */
--c-chrome-surface:  #1e293b    /* Dropdown background */
--c-chrome-mobile:   #111827    /* Mobile dropdown background */
--c-chrome-border:   rgba(255,255,255,.08)
--c-chrome-divider:  rgba(255,255,255,.07)
--c-chrome-text:     rgba(255,255,255,.78)
--c-chrome-text-dim: rgba(255,255,255,.68)
--c-chrome-text-muted: rgba(255,255,255,.45)
--c-chrome-hover:    rgba(255,255,255,.07)
--c-chrome-active:   rgba(99,102,241,.2)
--c-chrome-accent:   rgba(99,102,241,.18)
```

### Action Button Tints (Soft Style)

| Action | Background | Text | Border | Hover BG |
|--------|-----------|------|--------|----------|
| View | `#e8f4fd` | `#1a6fa3` | `#a8cce8` | `#cce6f8` |
| Create | `#e6f4ea` | `#1a7a40` | `#a8d5b5` | `#c8ecd1` |
| Edit | `#fff8e6` | `#8a6200` | `#e0c870` | `#ffefc0` |
| Delete | `#fdecea` | `#b71c1c` | `#e8a8a8` | `#fad4d0` |

---

## 2. Typography

### Font Stack

```css
font-family: "Helvetica Neue", Helvetica, Arial, Verdana, sans-serif;
```

Monospace (for numbers in tables/reports):
```css
font-family: "JetBrains Mono", "Courier New", Courier, monospace;
```

### Type Scale

| Element | Size | Weight | Transform | Spacing | Color |
|---------|------|--------|-----------|---------|-------|
| Page title (h1) | 21px | 700 | — | — | `--c-text-primary` |
| Card title | 17px | 800 | — | -0.2px | `#fff` (on gradient) |
| Section title | 13.5px | 700 | — | — | `#1e293b` |
| Body text | 13px–14px | 400–500 | — | — | `--c-text-secondary` |
| Form label (floating) | 13px | 500 | — | — | `--c-text-muted` |
| Form label (focused) | 9.5px | 700 | uppercase | 0.5px | `--c-primary` |
| Grid header | 11px | 700 | uppercase | 0.6px | `#1a2c3d` |
| Report table header | 11px | 600 | uppercase | 0.4px | `#fff` |
| Navbar link | 11px | 600 | uppercase | 0.35px | `rgba(255,255,255,.68)` |
| Dropdown header | 10px | 700 | uppercase | 0.8px | `#6b7280` |
| Dropdown item | 12.5px | 500 | — | — | `rgba(255,255,255,.78)` |
| Button (primary) | 14px | 700 | — | — | `#fff` |
| Button (secondary) | 13.5px | 600 | — | — | `#64748b` |
| Small text / help | 11.5px | 400 | — | — | varies |
| Badge / chip | 11px | 600 | — | — | varies |
| Dashboard stat number | 32px | 700 | — | — | `#fff` |
| Footer text | 12.5px | 500 | — | — | `rgba(255,255,255,.45)` |

### Line Heights

- **Tight** (buttons, single-line): `1`
- **Normal** (body, forms): `1.4`
- **Relaxed** (lists, descriptions): `1.6`

---

## 3. Spacing

### Base Unit: 4px

Use multiples of 4px for all spacing. Common values:

| Token | Value | Use |
|-------|-------|-----|
| `xs` | 4px | Tight gaps (icon–text in dropdowns) |
| `sm` | 8px | Between related items |
| `md` | 12px | Between form fields, section gaps |
| `lg` | 16px | Card padding (inner sections) |
| `xl` | 20px | Section margins |
| `2xl` | 24px | Card body padding |
| `3xl` | 28px | Card header/footer horizontal padding |
| `4xl` | 32px | Major section separators |

### Component Spacing

```
Card padding:           24px 28px  (vertical horizontal)
Card header padding:    22px 28px 20px
Card footer padding:    16px 28px
Card section padding:   24px 28px
Nested box padding:     18px 16px
Form field gap:         14px (margin-bottom between fields)
Grid cell:              7px 10px
Grid header:            8px 10px
Primary button:         11px 26px
Secondary button:       11px 20px
Navbar item:            14px 11px
Dropdown item:          7px 12px
Footer inner:           14px 24px
```

---

## 4. Border Radius

| Component | Radius | Rationale |
|-----------|--------|-----------|
| Card shell | `16px` | Primary containers — prominent rounding |
| Nested section box | `12px` | Secondary containers |
| Dropdown menu | `10px` | Floating panels |
| Primary button | `9px` | Clickable actions |
| Secondary button | `9px` | Consistent with primary |
| Input / select | `8px` | Form elements |
| Avatar (navbar) | `8px` | Small square with rounding |
| Avatar (dashboard) | `14px` | Larger, more prominent |
| Icon background | `12px`–`14px` | Decorative icon containers |
| Action button (grid) | `6px` | Compact inline actions |
| Grid filter | `5px` | Small inline inputs |
| Pagination | `5px` | Small buttons |
| Badge / chip | `99px` | Fully rounded pill |
| Progress bar | `99px` | Fully rounded pill |
| Circle (step badge) | `50%` | Perfect circle |

---

## 5. Shadows

| Level | Value | Use |
|-------|-------|-----|
| **None** | `none` | Flat elements inside cards |
| **Subtle** | `0 1px 3px rgba(0,0,0,.08)` | Action buttons, small interactive elements |
| **Card** | `0 4px 6px rgba(0,0,0,.04), 0 12px 36px rgba(0,0,0,.1)` | Primary cards |
| **Elevated** | `0 8px 28px rgba(0,0,0,.35)` | Dropdown menus |
| **Focus ring** | `0 0 0 3.5px rgba(99,102,241,.12)` | Focused inputs |
| **Button glow** | `0 4px 12px rgba(79,70,229,.35)` | Primary button |
| **Button glow hover** | `0 6px 20px rgba(79,70,229,.5)` | Primary button hover |
| **Semantic glow** | `0 6px 20px rgba(R,G,B,.5)` | Dashboard stat cards (use semantic color) |
| **Navbar** | `0 2px 8px rgba(0,0,0,.25)` | Fixed navbar |

---

## 6. Transitions & Motion

### Timing

```
--t-fast:    .12s    /* Dropdown highlights, icon color */
--t-normal:  .15s    /* Buttons, borders, backgrounds */
--t-smooth:  .18s    /* Inputs, labels, nav items */
--t-slow:    .22s    /* Dashboard cards, stat tiles */
--t-reveal:  .5s     /* Page-load staggered reveals */
```

### Easing

```
--e-default:  ease
--e-smooth:   cubic-bezier(.4, 0, .2, 1)      /* Input labels */
--e-bounce:   cubic-bezier(.34, 1.56, .64, 1)  /* Step badges, icon scale */
--e-reveal:   cubic-bezier(.22, 1, .36, 1)     /* Dashboard fade-up */
```

### Standard Transitions

```css
/* Buttons */
transition: background var(--t-normal), border-color var(--t-normal), box-shadow var(--t-normal);

/* Inputs */
transition: border-color var(--t-smooth), box-shadow var(--t-smooth), transform var(--t-normal);

/* Navbar / dropdowns */
transition: color var(--t-smooth), background var(--t-smooth), border-color var(--t-smooth);

/* Cards / tiles */
transition: transform var(--t-slow) ease, box-shadow var(--t-slow) ease;
```

### Hover Transforms

| Element | Transform |
|---------|-----------|
| Input (focus) | `translateY(-1px)` |
| Primary button (hover) | `translateY(-2px)` |
| Today tile (hover) | `translateY(-3px)` |
| Stat card (hover) | `translateY(-4px)` |
| Action card (hover) | `translateY(-5px) scale(1.03)` |

### Keyframe Animations

```css
/* Page-load reveal */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: none; }
}
/* Usage: animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both; */
/* Stagger: animation-delay: calc(var(--i) * .06s); */

/* Dropdown open */
@keyframes menuFadeIn {
  from { opacity: 0; transform: translateY(-4px); }
  to   { opacity: 1; transform: translateY(0); }
}
/* Usage: animation: menuFadeIn .14s ease-out both; */

/* Button ripple */
@keyframes ripple {
  to { transform: scale(4); opacity: 0; }
}
/* Usage: animation: ripple .6s linear; */

/* Invalid field shake */
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  20%, 60% { transform: translateX(-4px); }
  40%, 80% { transform: translateX(4px); }
}
/* Usage: animation: shake .4s ease; */

/* Skeleton loading */
@keyframes skeleton {
  0%   { background-position: -200% 0; }
  100% { background-position: 200% 0; }
}
/* Usage: background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
   background-size: 200% 100%; animation: skeleton 1.4s ease infinite; */
```

---

## 7. Component Patterns

### 7.1 Card (Form/CRUD)

```html
<div class="frm-card">
  <div class="card-header">
    <!-- Dot-grid overlay + decorative orb via ::before / ::after -->
    <div class="frm-hd-title">
      <span class="frm-hd-icon"><i class="fas fa-icon"></i></span>
      Title Text
    </div>
    <div class="frm-hd-sub">Subtitle text</div>
    <!-- Optional: progress chips + bar -->
  </div>
  <div class="card-body" style="padding:0">
    <div class="frm-section">
      <div class="frm-sec-hd">
        <span class="frm-step-badge">1</span>
        <div>
          <div class="frm-sec-title">Section Title</div>
          <div class="frm-sec-sub">Helper text</div>
        </div>
      </div>
      <div class="frm-sec-body">
        <!-- Form fields go here -->
      </div>
    </div>
  </div>
  <div class="card-footer">
    <button class="frm-submit" type="submit">Save</button>
    <a class="frm-cancel" href="...">Cancel</a>
  </div>
</div>
```

**Card header**: gradient `--g-brand`, dot-grid overlay, decorative orb
**Card body**: white, no padding (sections provide padding)
**Card footer**: `--c-bg-page` background, `--c-border-light` top border

### 7.2 Floating-Label Input

```html
<div class="frm-fl">
  <i class="fas fa-icon frm-fl-icon"></i>
  <input class="frm-fl-input" id="field" name="field" placeholder=" " required>
  <label class="frm-fl-label" for="field">Field Label</label>
  <span class="frm-fl-tick"><i class="fas fa-check"></i></span>
</div>
```

**States:**
- Default: gray border, icon `#cbd5e1`, label at `top: 12px`
- Hover: border `--c-border-hover`
- Focus: border `--c-primary`, shadow `--focus-ring`, label floats to `top: 5px` + uppercase + indigo
- Valid: green checkmark appears
- Invalid: red border, shake animation

### 7.3 Select Input

```html
<div class="frm-sel">
  <i class="fas fa-icon frm-sel-icon"></i>
  <select class="frm-select">
    <option value="">Choose...</option>
  </select>
</div>
```

Custom SVG arrow via `background-image`. Same focus/hover states as text input.

### 7.4 Currency Input

```html
<div class="frm-money">
  <span class="frm-money-sym">৳</span>
  <div class="frm-fl">
    <input class="frm-fl-input" ...>
    <label class="frm-fl-label" ...>Amount</label>
  </div>
</div>
```

Currency symbol box: `#f1f5f9` bg, `--c-primary` text, `font-weight: 800`.

### 7.5 Report Table

```html
<div class="report-card">
  <table class="summaryTab">
    <thead>
      <tr><th>Column</th>...</tr>
    </thead>
    <tbody>
      <tr><td>Data</td>...</tr>
    </tbody>
    <tfoot>
      <tr class="total-row"><td>Total</td>...</tr>
    </tfoot>
  </table>
</div>
```

**Header**: dark (`#212529`), white text, uppercase 11px
**Rows**: alternating `#f8f9fa` / `#fff`, hover `#e9f5ff`
**Total row**: dark background matching header, white bold text

### 7.6 Admin Grid View

Grid views use Yii's `CGridView` widget. Styling is handled externally:

**Header row**: `#f0f4f8` bg, `#1a2c3d` text, 11px uppercase, `2px solid #2c3e50` bottom border
**Filter row**: inputs with `5px` radius, `#c8d8e8` border, teal focus ring
**Body cells**: 13px, `7px 10px` padding, vertical-align middle
**Row hover**: `#f0f7ff`
**Action buttons**: soft-tint style (see Action Button Tints above), `34px` square, `6px` radius

### 7.7 Dashboard Stat Cards

Gradient background (use semantic color), white text, decorative orb, icon in `rgba(255,255,255,.22)` circle. Hover lifts `-4px`. Shimmer animation on load.

### 7.8 Modal

Use Bootstrap 5 modal structure. Dark header (`#212529`, white text) for report/action modals. Standard white header for form modals. Always include `data-bs-dismiss` close button.

### 7.9 Pagination

Styled via `custom.css`:
- Items: `#fff` bg, `#c8d8e8` border, `#1a6fa3` text
- Hover: `#e8f4fd` bg, `#1a6fa3` border
- Active: `--c-primary-base` bg, `#fff` text, `font-weight: 700`
- Disabled: `#f8f9fa` bg, `#aaa` text

### 7.10 Alerts / Flash Messages

Use Bootstrap 5 alert classes (`.alert-success`, `.alert-danger`, `.alert-warning`, `.alert-info`). Auto-fade after 3 seconds using jQuery animate → fadeOut.

### 7.11 Toastr Notifications

For AJAX success/error feedback. Use default toastr positioning. Colors follow semantic palette.

---

## 8. Navbar & Footer

### Navbar

- Background: `--c-chrome-bg` (`#0f172a`)
- Shadow: `0 2px 8px rgba(0,0,0,.25)`
- z-index: `1050`
- Nav links: 11px uppercase, `--c-chrome-text-dim`, border-bottom `2px solid transparent`
- Active: `--c-chrome-active` bg, `#6366f1` border-bottom
- Hover: `--c-chrome-hover` bg, `rgba(99,102,241,.55)` border-bottom
- Dropdown: `--c-chrome-surface` bg, `10px` radius, `0 8px 28px rgba(0,0,0,.35)` shadow
- Dropdown items: `12.5px`, `7px 12px` padding, `6px` radius, hover `--c-chrome-accent`

See CLAUDE.md `UserMenu` section for complete navbar specification.

### Footer

- Background: `--c-chrome-bg`
- Border-top: `1px solid rgba(255,255,255,.06)`
- Flex layout: copyright left, version right
- Text: `12.5px`, `rgba(255,255,255,.45)`
- Link hover: `--c-primary`

---

## 9. Responsive Design (All Devices)

The app MUST work on all screen sizes — mobile phones, tablets, laptops, and large monitors. Responsive design is NOT optional. Every view, form, table, and component MUST be tested at all breakpoints.

### 9.1 Breakpoints (Bootstrap 5)

| Breakpoint | Min-width | Target Devices | CSS Class |
|------------|-----------|---------------|-----------|
| `xs` | 0 | Small phones (iPhone SE, Galaxy S) | Default (no infix) |
| `sm` | 576px | Large phones (iPhone Pro, Pixel) | `-sm` |
| `md` | 768px | Tablets portrait (iPad Mini, Air) | `-md` |
| `lg` | 992px | Tablets landscape / Small laptops | `-lg` |
| `xl` | 1200px | Laptops / Desktop monitors | `-xl` |
| `xxl` | 1400px | Large monitors / Ultra-wide | `-xxl` |

**Mobile-first approach:** Write CSS for mobile first, then use `min-width` media queries to add complexity for larger screens.

### 9.2 Component Responsive Behavior

#### Navbar
| Breakpoint | Behavior |
|------------|----------|
| `≥992px` (lg+) | Full horizontal navbar, all menu items visible, dropdowns on hover/click |
| `<992px` | Collapsed hamburger menu, vertical dropdown, full-width menu items |
| `<576px` | Hamburger icon, dropdown items stack vertically, touch-friendly padding |

- Mobile menu: `max-height: 80vh; overflow-y: auto` (scrollable if many items)
- Touch targets: minimum `44px` height for all menu items on mobile
- Dropdown submenus: expand inline (not flyout) on mobile

#### Form Cards
| Breakpoint | Behavior |
|------------|----------|
| `≥992px` | Card max-width `720px`, centered. Multi-column field layout where appropriate |
| `768px–991px` | Card full width with `16px` horizontal margin. Single column fields |
| `<768px` | Card full width, no margin. Reduced padding (`16px` instead of `28px`) |
| `<576px` | Compact mode: card header padding reduced, font sizes scale down |

```css
/* Form card responsive */
.frm-card { max-width: 720px; margin: 0 auto; }
@media (max-width: 991px) { .frm-card { max-width: 100%; margin: 0 16px; } }
@media (max-width: 767px) { .frm-card { margin: 0; border-radius: 0; } }
@media (max-width: 575px) {
    .frm-section { padding: 16px; }
    .frm-hd-title { font-size: 15px; }
    .frm-fl-input { padding: 16px 10px 6px 34px; font-size: 13px; }
    .frm-submit { width: 100%; }
    .frm-cancel { width: 100%; }
}
```

#### Dashboard
| Breakpoint | Stat Cards | Today Tiles | Action Cards |
|------------|-----------|-------------|-------------|
| `≥1200px` | 4 columns | 4 columns | 6 columns |
| `992px–1199px` | 2 columns | 2 columns | 4 columns |
| `768px–991px` | 2 columns | 2 columns | 3 columns |
| `<768px` | 1 column (stacked) | 2 columns | 2 columns |
| `<576px` | 1 column | 1 column | 2 columns |

- Stat numbers: `32px` → `24px` on mobile
- Dashboard avatar: `52px` → `40px` on mobile
- Section headers: stack vertically on mobile

#### Tables (Grid Views & Reports)
| Breakpoint | Behavior |
|------------|----------|
| `≥992px` | Full table, all columns visible |
| `768px–991px` | Horizontal scroll wrapper (`.table-responsive`). All columns kept but scrollable |
| `<768px` | Horizontal scroll. Consider hiding low-priority columns with `.d-none .d-md-table-cell` |
| `<576px` | Compact table: reduced padding (`4px 6px`), smaller font (`11px`), action buttons stack vertically |

```css
/* Table responsive wrapper — ALWAYS use this */
.table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }

/* Compact table on mobile */
@media (max-width: 575px) {
    .grid-view th, .grid-view td { padding: 4px 6px; font-size: 11px; }
    .summaryTab th, .summaryTab td { padding: 3px 5px; font-size: 10px; }
    .action-btn { width: 30px; height: 30px; font-size: 12px; }
}
```

#### Modals
| Breakpoint | Behavior |
|------------|----------|
| `≥576px` | Standard Bootstrap modal (centered, max-width per size class) |
| `<576px` | Full-screen modal: `.modal-fullscreen-sm-down` class. Margin `0`, border-radius `0` |

#### Action Buttons
| Breakpoint | Size | Touch Target |
|------------|------|-------------|
| `≥992px` | `34px` square | `34px` (mouse-friendly) |
| `<992px` | `38px` square | `38px` (touch-friendly) |
| `<576px` | `42px` square | `42px` (fat-finger safe) |

#### Pagination
| Breakpoint | Behavior |
|------------|----------|
| `≥768px` | Full pagination: first, prev, numbers, next, last + go-to-page input |
| `<768px` | Compact: prev/next only + current page indicator |

#### Print/Export Buttons
| Breakpoint | Behavior |
|------------|----------|
| `≥768px` | Inline buttons with text: `<i class="fas fa-print"></i> Print` |
| `<768px` | Icon-only buttons: `<i class="fas fa-print"></i>` (text hidden with `.d-none .d-md-inline`) |

### 9.3 Touch-Specific Rules

For touch devices (detected via `@media (hover: none)` or `@media (pointer: coarse)`):

```css
@media (pointer: coarse) {
    /* Larger touch targets */
    .action-btn { width: 42px; height: 42px; }
    .frm-fl-input { min-height: 48px; }
    .frm-select { min-height: 48px; }
    .nav-link { padding: 16px 14px !important; }
    .dropdown-item { padding: 10px 14px; }
    .pagination a { min-width: 40px; min-height: 40px; }

    /* Disable hover-only effects */
    .frm-section:hover { background: transparent; }
}
```

### 9.4 Viewport Meta Tag

Every layout MUST include:
```html
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
```

Note: `maximum-scale=5` (not `1`) — allow pinch-to-zoom for accessibility. Never use `user-scalable=no`.

### 9.5 Responsive Images

- Logo in navbar: `max-width: 100%; height: auto;` with explicit `height` attribute to prevent layout shift
- Product images: `max-width: 100%; height: auto;` within card/form containers
- Avatar/icons: Fixed dimensions (don't scale) — they're small enough already

### 9.6 Container Strategy

| Context | Container Class | Max-width Behavior |
|---------|----------------|-------------------|
| Main content | `.container-fluid` | Full width with padding |
| Form cards | `.container` or max-width on card | Centered, maxes out at 720px |
| Dashboard | `.container-fluid` | Full width, grid handles columns |
| Report results | `.container-fluid` | Full width (tables need space) |
| Login page | `.container` | Centered, narrow card |

### 9.7 Testing Requirements

Every page MUST be tested at these viewport widths:
- **375px** — iPhone SE / small Android (minimum supported width)
- **414px** — iPhone Pro / standard Android
- **768px** — iPad Mini portrait
- **1024px** — iPad landscape / small laptop
- **1280px** — Standard laptop
- **1920px** — Full HD monitor

Use Chrome DevTools Device Toolbar for testing. Also test:
- **Orientation change** (portrait ↔ landscape) on tablet sizes
- **Text zoom** (browser 150% zoom) — layout must not break
- **Touch scrolling** on tables with horizontal overflow

### 9.8 Known Responsive Issues to Fix During Migration

| Issue | Current Behavior | Required Fix |
|-------|-----------------|-------------|
| Tables overflow on mobile | No horizontal scroll wrapper | Add `.table-responsive` wrapper to ALL CGridView and report tables |
| Form fields don't stack on mobile | Fixed `col-md-6` without `col-12` fallback | Add `col-12 col-md-6` pattern to all form grid layouts |
| Dashboard cards don't stack | Fixed 4-column layout | Use `col-12 col-sm-6 col-lg-3` responsive grid |
| Print/export buttons overflow | Fixed inline layout | Stack vertically on mobile |
| Voucher preview modal too small on mobile | Default modal size | Use `.modal-fullscreen-sm-down` |
| Footer text overlaps on narrow screens | `justify-content: space-between` | Stack vertically with `flex-wrap: wrap` + `justify-content: center` on mobile |

---

## 10. Icons

Use **Font Awesome 6** exclusively. Prefix: `fas` (solid), `far` (regular), `fab` (brands).

Common icons used in this project:

| Purpose | Icon Class |
|---------|-----------|
| Dashboard | `fas fa-chart-line` |
| Sales | `fas fa-shopping-cart` |
| Purchase | `fas fa-truck` |
| Inventory | `fas fa-boxes-stacked` |
| Accounting | `fas fa-calculator` |
| Users | `fas fa-users` |
| Settings | `fas fa-cog` |
| Add/Create | `fas fa-plus` |
| Edit | `fas fa-pen` |
| Delete | `fas fa-trash` |
| View | `fas fa-eye` |
| Print | `fas fa-print` |
| Export | `fas fa-file-excel` |
| Search | `fas fa-search` |
| Calendar | `fas fa-calendar` |
| Money | `fas fa-money-bill` |
| Save | `fas fa-check` |
| Cancel | `fas fa-times` |
| Back | `fas fa-arrow-left` |
| Notification | `fas fa-bell` |

Icon sizing follows the context:
- Navbar: `11px`–`14px`
- Card header: `15px` (inside 34px icon box)
- Form field: `13px`
- Action button: `14px`
- Dashboard stat: `22px`

---

## 11. Print Styles

When a view supports printing:
- Hide navbar, footer, filters, action buttons
- Remove shadows and border-radius
- Use `13pt Georgia, "Times New Roman", serif` for body
- Use `#000` text on `#fff` background
- Show link URLs in parentheses
- Page margins: `2cm`
- Table borders: `1px solid #000`

---

## 12. Z-Index Scale

| Layer | Z-Index | Use |
|-------|---------|-----|
| Base content | `1` | Default stacking |
| Grid filter | `100` | Sticky filters |
| Sticky table header | `1000` | Report sticky headers |
| Navbar | `1050` | Fixed navigation |
| Dropdown menu | `1050` | Navbar dropdowns |
| Modal backdrop | `1055` | Bootstrap modal |
| Modal dialog | `1056` | Bootstrap modal |
| Toastr | `9999` | Notifications always on top |

---

## 13. Accessibility Guidelines

- All form inputs MUST have associated labels (floating labels serve this purpose)
- All images MUST have `alt` attributes
- All action buttons MUST have `title` attributes for tooltip context
- Color MUST NOT be the only indicator of state — combine with icons or text
- Minimum touch target: `34px` (desktop), `38px` (mobile)
- Focus states MUST be visible — never remove outline without providing alternative focus ring
- Modal trap focus within the dialog when open
- Use `role="alert"` for flash messages and toastr notifications

---

## 14. Anti-Patterns (Do NOT)

- Do NOT use inline `<style>` blocks for styles that exist in shared CSS files
- Do NOT create new color values — use the tokens above
- Do NOT use Bootstrap's default blue (`#007bff`) — use indigo (`#4f46e5`)
- Do NOT use `!important` except in custom.css overrides of Bootstrap defaults
- Do NOT hardcode font-size in pixels without checking the type scale
- Do NOT use AdminLTE classes — the framework has been removed
- Do NOT use Font Awesome 4 syntax (`fa fa-*`) — use FA6 (`fas fa-*`)
- Do NOT use `data-toggle` — use `data-bs-toggle` (Bootstrap 5)
- Do NOT use `form-group` — use `mb-3`
- Do NOT use `ml-*`/`mr-*` — use `ms-*`/`me-*`
- Do NOT use `float-left`/`float-right` — use `float-start`/`float-end`
- Do NOT use `text-left`/`text-right` — use `text-start`/`text-end`
- Do NOT duplicate CSS across view files — add to shared stylesheet
- Do NOT add new jQuery plugins without justification — prefer vanilla JS or BS5 native
