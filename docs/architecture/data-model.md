# Data Model & Entity Relationships

## Core Product Hierarchy

```
ProdItems (Category: e.g., "Electronics")
  └── HAS_MANY ProdBrands (Sub-category: e.g., "Samsung")
        └── HAS_MANY ProdModels (SKU: e.g., "Galaxy A15 Blue")
              ├── BELONGS_TO Units (measurement: kg, pcs, box)
              └── BELONGS_TO Manufacturers
```

| Model | Table | Key Fields |
|-------|-------|------------|
| `ProdItems` | `prod_items` | id, item_name, business_id, branch_id |
| `ProdBrands` | `prod_brands` | id, item_id, brand_name, ca_id |
| `ProdModels` | `prod_models` | id, item_id, brand_id, model_name, code, unit_id, purchase_price, sell_price, warranty, image, stockable, status, manufacturer_id |
| `Units` | `units` | id, label, value, remarks (constants: CURR_UNIT=7, QTY_UNIT=8, MEASUREMENT=17, WEIGHT=18) |
| `Manufacturers` | `manufacturers` | id, name, description |

## Inter-Module Data Flow

### Sales → Inventory
```
SellOrder (sell_order_id)
  └── SellOrderDetails (model_id, qty)
        └── Inventory (stock_out, source_id=3 SALES_DELIVERY)
```

### Purchase → Inventory
```
PurchaseOrder (order_id)
  └── PurchaseOrderDetails (model_id, qty)
        └── Inventory (stock_in, source_id=1 PURCHASE_RECEIVE)
```

### Sales → Accounting
```
SellOrder (customer_id)
  └── MoneyReceipt (customer_id, invoice_id → SellOrder.id)
```

### Purchase → Accounting
```
PurchaseOrder (supplier_id)
  └── PaymentReceipt (order_id → PurchaseOrder.id)
```

### Returns → Inventory
```
SellReturn → Inventory (stock_in, source_id=4 CASH_SALE_RETURN)
WarrantyClaims → Inventory (source_id=5 WARRANTY_RETURN)
Product Replacement → Inventory (source_id=6 PRODUCT_REPLACEMENT)
```

## Explicit Model Relations

These are defined in `relations()` methods:

| Model | Relation | Type | Target |
|-------|----------|------|--------|
| `SellOrder` | customer | BELONGS_TO | `Customers` |
| `PurchaseOrder` | supplier | BELONGS_TO | `Suppliers` |
| `LoanPersons` | loanTransactions | HAS_MANY | `LoanTransactions` |
| `LoanTransactions` | person | BELONGS_TO | `LoanPersons` |
| `User` | profile | HAS_ONE | `Profile` |
| `ProdItems` | prodBrands | HAS_MANY | `ProdBrands` |
| `ProdItems` | prodModels | HAS_MANY | `ProdModels` |
| `ProdBrands` | prodItems | BELONGS_TO | `ProdItems` |
| `ProdModels` | prodBrands | BELONGS_TO | `ProdBrands` |
| `ProdModels` | units | BELONGS_TO | `Units` |

## Implicit Relations (via foreign keys, no explicit relations())

| Child Model | FK Field | Parent Model |
|-------------|----------|-------------|
| `SellOrderDetails` | sell_order_id | `SellOrder` |
| `PurchaseOrderDetails` | order_id | `PurchaseOrder` |
| `ExpenseDetails` | expense_id | `Expense` |
| `ExpenseDetails` | expense_head_id | `ExpenseHead` |
| `SellReturnDetails` | — | `SellReturn` |
| `WarrantyClaimProducts` | — | `WarrantyClaims` |
| `MoneyReceipt` | customer_id, invoice_id | `Customers`, `SellOrder` |
| `PaymentReceipt` | order_id | `PurchaseOrder` |
| `Inventory` | model_id | `ProdModels` |
| `Inventory` | master_id, source_id | Various (PO, SO, Return) |

## Inventory Source ID Reference

The `Inventory.source_id` field identifies what created the stock movement:

| source_id | Constant | Meaning |
|:---------:|----------|---------|
| 0 | `MANUAL_ENTRY` | Manual stock adjustment |
| 1 | `PURCHASE_RECEIVE` | Purchase order received |
| 3 | `SALES_DELIVERY` | Sales order delivered (stock out) |
| 4 | `CASH_SALE_RETURN` | Cash sale return (stock in) |
| 5 | `WARRANTY_RETURN` | Warranty return (stock in) |
| 6 | `PRODUCT_REPLACEMENT` | Product replacement |

## Audit Trail

All models track creation/modification via:
- `created_by` / `create_by` — User ID
- `created_at` / `create_time` — Timestamp
- Referenced against the `Users` model

## Database Triggers

A MySQL trigger (`after_purchase_order_details_delete`) archives deleted purchase order line items to the `purchase_order_details_backup` table. Defined in `db/db-triggers.txt`.
