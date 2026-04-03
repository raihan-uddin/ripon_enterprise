# Bug Fix 001: SQL Injection & Security Hardening in InventoryController

**Date:** 2026-04-03
**Severity:** CRITICAL
**Affected file(s):**
- `protected/modules/inventory/controllers/InventoryController.php`
- `protected/modules/sell/views/sellReturn/_formProductReturnApprove.php`

---

## Symptom

Multiple security vulnerabilities in the inventory module allowed unauthenticated or low-privilege users to:
1. Execute arbitrary SQL via date parameters in the stock report.
2. Redirect users to malicious sites after deleting an inventory record.
3. Inject stored XSS through model fields rendered without encoding.
4. Bypass RBAC on the `removeProductSlFromCurrentStock` action.
5. Cause data corruption due to missing transactions around multi-row writes.

---

## Root Cause

### 1. SQL Injection in `actionStockReportView()`

User-supplied `$dateFrom` and `$dateTo` were interpolated directly into SQL strings without parameterization:

```php
// BEFORE (vulnerable)
$dateFrom = $_POST['Inventory']['date_from'];
$dateTo = $_POST['Inventory']['date_to'];
// ...
$criteria->select = "
    IFNULL((SELECT ... WHERE op.date < '$dateFrom' ...), 0) as opening_stock,
    SUM(CASE WHEN (inv.date BETWEEN '$dateFrom' AND '$dateTo') THEN inv.stock_in ELSE 0 END) as stock_in
";
```

An attacker could set `date_from` to `' OR 1=1; DROP TABLE inventory; --` and execute arbitrary SQL.

### 2. Direct `$_POST`/`$_GET` Access (All Actions)

Every action used raw superglobal access (`$_POST['key']`, `$_GET['key']`) instead of Yii's request object. This bypasses Yii's built-in input filtering and makes CSRF token validation inconsistent.

```php
// BEFORE
$product_sl = isset($_POST['product_sl']) ? $_POST['product_sl'] : "";
$search_prodName = trim($_POST['q']);
```

### 3. XSS in `_formProductReturnApprove.php`

Model attributes (including the user-editable `remarks` field) were echoed raw:

```php
// BEFORE (vulnerable to stored XSS)
<span class="pr-info-value"><?php echo $model->remarks; ?></span>
<td><?php echo $detail->model->model_name; ?></td>
```

### 4. Open Redirect in `actionDelete()`

```php
// BEFORE
$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
```

An attacker could POST `returnUrl=https://evil.com` to redirect a user after deletion.

### 5. RBAC Bypass on `removeProductSlFromCurrentStock`

The action was listed in the `allowedActions` string (prefixed with `-`), exempting it from RBAC permission checks:

```php
// BEFORE
'rights' => '-VoucherPreview -Jquery_showprodSlNoSearch -removeProductSlFromCurrentStock -fetchProductPrice',
```

### 6. Missing DB Transactions

`actionCreate()`, `actionFixPurchasePrice()`, and `actionFixSellOrderPP()` all saved multiple related rows in a loop. If any save failed mid-loop, earlier rows were already committed, leaving the database in an inconsistent state.

### 7. `var_dump()` + `exit` in Production

```php
// BEFORE
if (!$model2->save()) {
    var_dump($model2->getErrors());
    exit;
}
```

This leaked internal model structure to the browser and halted execution without cleanup.

### 8. Duplicate `$model->save()` in `actionRemoveProductSlFromCurrentStock()`

```php
// BEFORE
$model->save();
$model->save();   // identical call, writes the same row twice
```

---

## The Fix

### 1. Parameterized SQL Queries

```php
// AFTER
$criteria->params[':dateFrom'] = $dateFrom;
$criteria->params[':dateTo'] = $dateTo;
$criteria->select = "
    IFNULL((SELECT ... WHERE op.date < :dateFrom ...), 0) as opening_stock,
    SUM(CASE WHEN (inv.date BETWEEN :dateFrom AND :dateTo) THEN inv.stock_in ELSE 0 END) as stock_in
";
```

### 2. Yii Request Object for All Input

```php
// AFTER
$postData = Yii::app()->request->getPost('Inventory');
$product_sl = Yii::app()->request->getPost('product_sl', '');
$search_prodName = trim(Yii::app()->request->getPost('q', ''));
```

### 3. Output Encoding with `CHtml::encode()`

```php
// AFTER
<span class="pr-info-value"><?php echo CHtml::encode($model->remarks); ?></span>
<td><?php echo CHtml::encode($detail->model->model_name); ?></td>
```

### 4. Hardcoded Redirect (No User-Controlled URL)

```php
// AFTER
$this->redirect(array('admin'));
```

### 5. Removed RBAC Exemption

```php
// AFTER
'rights' => '-VoucherPreview -Jquery_showprodSlNoSearch -fetchProductPrice',
// removeProductSlFromCurrentStock now requires RBAC permission
```

### 6. Wrapped Multi-Row Writes in Transactions

```php
// AFTER (actionCreate example)
$transaction = Yii::app()->db->beginTransaction();
try {
    foreach ($postData['temp_model_id'] as $key => $model_id) {
        // ... build $model2 ...
        if (!$model2->save()) {
            throw new CException(CJSON::encode($model2->getErrors()));
        }
    }
    $transaction->commit();
} catch (Exception $e) {
    $transaction->rollback();
    echo CJSON::encode(array('status' => 'error', 'message' => 'Failed to save inventory records.'));
}
```

### 7. Replaced `var_dump()`+`exit` with Exception

Errors are now thrown as `CException` and caught by the transaction block, which rolls back and returns a JSON error response.

### 8. Removed Duplicate Save

The duplicate `$model->save()` was replaced with a single save wrapped in a success/error check.

---

## Key Rule

> **Never interpolate user input into SQL strings.** Always use parameterized queries (`$criteria->params`). Use `Yii::app()->request->getPost()`/`getQuery()` instead of raw `$_POST`/`$_GET`. Encode all model output in views with `CHtml::encode()`. Wrap multi-row writes in DB transactions.

---

## Files Involved

| File | Change |
|------|--------|
| `protected/modules/inventory/controllers/InventoryController.php` | SQL injection fix, $_POST/$_GET replaced, transactions added, var_dump removed, duplicate save removed, RBAC exemption removed, open redirect removed, output encoding on echo'd values |
| `protected/modules/sell/views/sellReturn/_formProductReturnApprove.php` | All model attribute output wrapped in `CHtml::encode()` |
