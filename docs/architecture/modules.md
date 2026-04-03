# Modules Architecture

Each module is self-contained under `protected/modules/{name}/` with its own controllers, models, and module class file. Views live in `themes/erp/views/` (or `protected/modules/{name}/views/` for some).

## Module Summary

| Module | Controllers | Models | Responsibility |
|--------|:-----------:|:------:|----------------|
| **sell** | 9 | 13 | Sales orders, quotations, returns, warranty claims, customers |
| **commercial** | 5 | 8 | Purchase orders, suppliers, supplier contacts |
| **accounting** | 4 | 7 | Money receipts, payment receipts, expenses |
| **inventory** | 4 | 3 | Stock ledger, warehouse stores, locations |
| **user** | 10 | 7 | Authentication, profiles, registration, recovery |
| **rights** | 3 | 4 | RBAC authorization (roles, permissions, assignments) |
| **loan** | 3 | 2 | Loan persons, loan transactions |

---

## Sell Module (`protected/modules/sell/`)

**Module class:** `SellModule extends CWebModule`

### Controllers
- `SellOrderController` — Sales invoice CRUD, voucher preview, challan
- `SellOrderQuotationController` — Quotation CRUD
- `SellReturnController` — Cash returns, product returns, return approvals
- `CustomersController` — Customer master CRUD
- `CustomerContactPersonsController` — Contact persons for customers
- `CrmBankController` — Customer bank account management
- `WarrantyClaimsController` — Warranty claim tracking
- `CustomerAbValidationController` — AB validation records

### Models
- `SellOrder` — Sales invoices (customer_id, date, grand_total, is_paid, order_type: NEW_ORDER/REPAIR_ORDER)
- `SellOrderDetails` — Line items (model_id, qty, amount, warranty)
- `SellOrderQuotation` / `SellOrderQuotationDetails` — Quotation documents
- `SellReturn` / `SellReturnDetails` — Return management
- `Customers` — Customer master (company_name, contact, opening_amount)
- `WarrantyClaims` / `WarrantyClaimProducts` — Warranty tracking
- `CrmBank` — Customer bank info
- `CustomerContactPersons`, `CustomerAbValidation`, `SellOrderDetailsBackup`

---

## Commercial Module (`protected/modules/commercial/`)

**Module class:** `CommercialModule extends CWebModule`

### Controllers
- `PurchaseOrderController` — Purchase order CRUD, voucher preview
- `SuppliersController` — Supplier master CRUD
- `SupplierContactPersonsController` — Supplier contact persons
- `ComBankController` — Supplier bank accounts

### Models
- `PurchaseOrder` — Purchase orders (supplier_id, date, grand_total, is_paid, store_id, location_id)
- `PurchaseOrderDetails` — Line items (model_id, qty, unit_price, is_all_received)
- `Suppliers` — Supplier master (company_name, contact, opening_amount)
- `PurchasePrices` / `PurchasePricesManual` — Price history
- `ComBank` — Supplier bank info
- `SupplierContactPersons`, `PurchaseOrderDetailsBackup`

**Note:** MySQL trigger archives deleted PO details to `purchase_order_details_backup` (see `db/db-triggers.txt`).

---

## Accounting Module (`protected/modules/accounting/`)

**Module class:** `AccountingModule extends CWebModule`

### Controllers
- `MoneyReceiptController` — Customer payment collection
- `PaymentReceiptController` — Supplier payment
- `ExpenseController` — Expense entry management
- `ExpenseHeadController` — Expense category master

### Models
- `MoneyReceipt` — Customer payments (customer_id, invoice_id, amount, payment_type, bank_id, is_approved)
- `PaymentReceipt` — Supplier payments (order_id, amount, payment_type, bank_id)
- `Expense` / `ExpenseDetails` — Expense records with line items by expense head
- `ExpenseHead` — Expense categories
- `Lookup` / `LookupAc` — Reference lookups

---

## Inventory Module (`protected/modules/inventory/`)

**Module class:** `InventoryModule extends CWebModule`

### Controllers
- `InventoryController` — Stock ledger, stock reports, product verification, price-fix utilities
- `LocationController` — Warehouse location CRUD
- `StoresController` — Store/warehouse CRUD

### Security Hardening (InventoryController)

The inventory controller has been hardened with the following patterns:

- **Parameterized queries:** All stock report SQL (e.g. `actionStockReport`) uses `:dateFrom` / `:dateTo` bound parameters via `CDbCriteria::params` instead of string interpolation, preventing SQL injection.
- **Safe POST access:** All `$_POST` / `$_GET` superglobal access replaced with `Yii::app()->request->getPost()` / `getQuery()` with safe defaults.
- **DB transactions:** Multi-row write operations (`actionCreate`, `actionFixPurchasePrice`, `actionFixSellOrderPurchasePrice`) are wrapped in `beginTransaction()` / `commit()` / `rollback()` to ensure atomicity.
- **RBAC enforcement:** The `removeProductSlFromCurrentStock` action was removed from the `allowedActions` exclusion list, so it now requires RBAC authorization.
- **XSS prevention:** Output in price-fix actions uses `CHtml::encode()` on user-derived data.
- **Error handling:** Failed saves throw `CException` inside transactions (caught and rolled back) instead of `var_dump()` / `exit`.

### Models
- `Inventory` — Stock transaction ledger (the central stock model)
  - Tracks stock_in / stock_out per model_id
  - `source_id` constants identify origin:
    - `0` = Manual entry
    - `1` = Purchase receive
    - `3` = Sales delivery
    - `4` = Cash sale return
    - `5` = Warranty return
    - `6` = Product replacement
  - Includes product_serial_no, purchase_price, sell_price
- `Stores` — Warehouse master
- `Location` — Physical storage locations within stores

### Key Views
- `stockReport.php` / `stockReportView.php` — Current stock reports
- `stockReportSupplierWise.php` — Stock by supplier
- `stockLedgerView.php` — Full stock ledger
- `currentStockReportBatchWiseView.php` — Batch-wise stock
- `_verifyProduct.php` / `verifyProductResult.php` — Product verification

---

## User Module (`protected/modules/user/`)

**Module class:** `UserModule extends CWebModule` (Yii-User plugin with customization)

### Controllers
- `AdminController` — User admin CRUD
- `LoginController` / `LogoutController` — Authentication
- `ProfileController` — Profile management
- `RegistrationController` — New user registration
- `RecoveryController` — Password recovery
- `ActivationController` — Account activation
- `ProfileFieldController` — Custom profile field management

### Models
- `User` — User accounts (username, password, email, status, superuser flag)
  - Status constants: NOACTIVE, ACTIVE, BANNED
- `Profile` — User profile (HAS_ONE from User)
- `ProfileField` — Custom field definitions
- `UserLogin` / `UserChangePassword` / `RegistrationForm` / `UserRecoveryForm` — Form models

---

## Rights Module (`protected/modules/rights/`)

**Module class:** `RightsModule extends CWebModule`

RBAC authorization framework. All controllers in the app extend `RController` from this module.

### Controllers
- `AuthItemController` — Manage auth items (operations, tasks, roles)
- `AssignmentController` — Assign roles to users
- `InstallController` — Module installation

### Key Config
- Superuser role: `Admin`
- Default authenticated role: `Authenticated`
- Auth manager: `RDbAuthManager` (DB-backed)
- Business rules enabled (`enableBizRule=true`)

---

## Loan Module (`protected/modules/loan/`)

**Module class:** `LoanModule extends CWebModule`

Standalone module, independent from core business modules.

### Controllers
- `LoanPersonsController` — Loan person master
- `LoanTransactionsController` — Loan transactions

### Models
- `LoanPersons` — Loan persons (name, phone, email, address)
  - Relation: HAS_MANY → LoanTransactions
- `LoanTransactions` — Transactions (person_id, transaction_type: lend/borrow, amount, date)
  - Relation: BELONGS_TO → LoanPersons
