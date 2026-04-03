# Dashboard Architecture

## Overview

The dashboard is the main authenticated landing page, rendered by `SiteController::actionDashBoard()`. It provides real-time business metrics via AJAX JSON endpoints.

## Key Files

| File | Role |
|------|------|
| `protected/controllers/SiteController.php` | Controller with dashboard action + JSON API endpoints |
| `themes/erp/views/site/dashBoard.php` | Main dashboard view |
| `themes/erp/views/site/summary-widget.php` | Summary cards partial |
| `themes/erp/views/site/block-widget.php` | Block widget partial |
| `themes/erp/views/site/report-shortcut.php` | Report shortcut links |
| `themes/erp/views/site/shortcut-link.php` | Quick navigation links |
| `themes/erp/views/site/_alerts.php` | Alert notifications partial |
| `themes/erp/views/site/_graph.php` | Sales/purchase graph partial |
| `themes/erp/views/site/_graphInventory.php` | Inventory graph partial |
| `themes/erp/views/site/profitLossSummary.php` | P&L summary view |

## AJAX Endpoints

The dashboard loads data asynchronously from these JSON endpoints:

### `actionDashboardStats()`
Financial metrics for a date range:
- Total sales, purchase, expense, collection, payment
- Sales returns, purchase returns
- Profit calculation
- Trend data for charts

### `actionInventoryStats()`
Inventory insights:
- Closing stock value trend
- Top 10 items by closing value
- Stock aging buckets (0-30, 31-60, 61-90, 90+ days)
- Fast-moving vs slow-moving products
- Brand-wise stock distribution

### `actionTodayStats()`
Today's snapshot with yesterday comparison:
- Order count
- Total sales amount
- Total collection
- Total expense

### `actionAlerts()`
Operational alerts:
- Low-stock alerts (products with qty <= 5)
- Customer due alerts (sales total - money receipts)

### `actionQuickSearch()`
Global search endpoint:
- Searches customers by name
- Searches products by model name
- Searches sales orders by ID

## Data Flow

```
Dashboard Page Load
  ├── Renders static HTML shell
  └── AJAX calls (parallel)
        ├── /site/dashboardStats   → Financial summary cards + charts
        ├── /site/inventoryStats   → Inventory charts + tables
        ├── /site/todayStats       → Today's snapshot cards
        └── /site/alerts           → Alert badges + notifications
```

## Authentication

- `actionLogin()` — Login form, validates via `UserIdentity` against `Users` model (MD5 password)
- `actionDashBoard()` — Requires authenticated user (guests redirect to login)
- `actionLogout()` — Clears session, redirects to login
- Session timeout: 60 days with auto-renewal

## Profit/Loss Calculation

`actionProfitLossSummary()` computes:
```
Profit = Sales - COGS - Returns COGS - Discounts - Expense
```
Uses complex SQL aggregations across SellOrder, PurchaseOrder, MoneyReceipt, PaymentReceipt, Expense, and SellReturn tables.
