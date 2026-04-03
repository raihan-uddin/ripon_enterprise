# Extensions & Components

## Overview

Extensions in `protected/extensions/` provide reusable widgets and utilities. Components in `protected/components/` are application-level base classes and widgets.

## Extensions (`protected/extensions/`)

### UI Widgets

| Extension | Files | Purpose |
|-----------|-------|---------|
| `bootstrap/` | 10 PHP files | Bootstrap 3 widget wrappers (buttons, modals, tabs, collapse, progress bars, breadcrumbs) |
| `select2/ESelect2.php` | 1 file | Select2 enhanced dropdown widget |
| `editMe/` | — | Inline editing widget |
| `mbmenu/` | — | Custom menu component |
| `CMenuCustom.php` | 1 file | Extended CMenu widget |

### Data Grids & Tables

| Extension | Purpose |
|-----------|---------|
| `GroupGridView.php` | Grouped CGridView for reporting tables |
| `BootGroupGridView.php` | Bootstrap-styled grouped grid |
| `dynamictabularform/DynamicTabularForm.php` | Dynamic add/remove rows in forms |

### Date & Time Pickers

| Extension | Purpose |
|-----------|---------|
| `CJuiDateTimePicker/` | jQuery UI datetime picker |
| `YiiDateTimePicker/` | Yii wrapper for datetime |
| `EJuiMonthPicker/` | Month-only picker widget |
| `EDateRangePicker/` | Date range selection |

### Data Export & Documents

| Extension | Purpose |
|-----------|---------|
| `EExcelView.php` | Export CGridView data to Excel |
| `phpexcel/` | PHPExcel library (full Excel read/write) |
| `phpexcelreader/` | PHPExcel reading utilities |
| `HTML to Excel/` | HTML table to Excel conversion |
| `yii-pdf/EYiiPdf.php` | PDF generation for vouchers and reports |
| `mPrint/` | Print utilities |

### Charts

| Extension | Purpose |
|-----------|---------|
| `highcharts/` | HighCharts, HighMaps, HighStock chart widgets |

### File Upload

| Extension | Purpose |
|-----------|---------|
| `EAjaxUpload/` | AJAX file upload widget |

### Utilities

| Extension | Purpose |
|-----------|---------|
| `AmountInWord.php` | Convert currency amounts to words (used in vouchers/invoices) |
| `image/` | Image handling utilities |
| `jqrelcopy/` | jQuery relationship copy |

## Components (`protected/components/`)

| Component | Purpose |
|-----------|---------|
| `Controller.php` | Base controller extending `RController`; sets default layout, breadcrumbs, menu |
| `UserIdentity.php` | Login authenticator; validates against `UsersProfile`, MD5 password hash |
| `UserMenu.php` | Widget class for top navigation bar |
| `Navbar.php` | Navigation bar component |
| `Notifications.php` | Toast/push notification system |
| `Messages.php` | Flash message handling |
| `BreadCrumb.php` | Breadcrumb navigation widget |
| `UsersProfile.php` | User profile model for authentication |
| `EImageColumn.php` | Custom CGridView column type for displaying images |

### Component View Files (`protected/components/views/`)

| File | Purpose |
|------|---------|
| `UserMenu.php` | Full navigation bar HTML/CSS/JS (self-contained) |
| `breadCrumb.php` | Breadcrumb rendering template |

## Helpers (`protected/helpers/`)

| Helper | Purpose |
|--------|---------|
| `CArray.php` | Array utility functions |

## Vendor Packages (`protected/vendors/`)

| Package | Purpose |
|---------|---------|
| `html2pdf/` | HTML to PDF conversion (uses TCPDF 5.0.002) |
| `pjmail/` | Email sending utility |
