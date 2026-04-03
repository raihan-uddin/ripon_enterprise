# Bug Fix 002: Yii 1.x Framework PHP 8.x Compatibility Fixes

**Date:** 2026-04-03
**Severity:** HIGH
**Affected file(s):**
- `framework/db/schema/CDbColumnSchema.php`
- `framework/utils/CPropertyValue.php`
- `framework/utils/CTimestamp.php`
- `framework/web/helpers/CJSON.php`
- `framework/yiilite.php` (bundled copies of CHttpRequest, CController, CWidget)

---

## Symptom

On PHP 8.x, the application produces deprecation warnings, type errors, and logic bugs:

1. **Logic bug:** `strpos()` without strict comparison causes columns with `(` at position 0 to be silently skipped (e.g., PostgreSQL enum types). Same issue in `CController::getViewFile()` and `CWidget::getViewFile()` for view names starting with `.`.
2. **TypeError:** `strlen()` and `trim()` receive `null` instead of a string, which is a fatal error in PHP 8.1+.
3. **Deprecation:** `(double)` and `(boolean)` casts emit notices in PHP 8.5 / PHP 8.2+.

---

## Root Cause

### 1. `strpos()` Without Strict Comparison

PHP's `strpos()` returns `0` (a falsy int) when the needle is found at position 0, and `false` when not found. Using the return value in a boolean context treats position-0 matches as "not found":

```php
// BEFORE (CDbColumnSchema::extractLimit)
if(strpos($dbType,'(') && preg_match('/\((.*)\)/',$dbType,$matches))
```

When `$dbType` starts with `(`, `strpos()` returns `0`, the condition is falsy, and the column's size/precision is never extracted.

Same pattern in `CController::getViewFile()` and `CWidget::getViewFile()`:

```php
// BEFORE
elseif(strpos($viewName,'.'))   // fails for view "." or ".aliasPath"
```

### 2. Null Passed to String Functions

PHP 8.1 made it a TypeError to pass `null` to internal string functions like `strlen()`, `trim()`.

```php
// BEFORE (CJSON::reduce_string)
for ($i = 0; $i < strlen( $str ); $i++ )
// $str can be null when decoding malformed JSON

// BEFORE (CTimestamp::formatDate)
case 'y': $dates .= substr($year, strlen($year)-2, 2);
// $year is an int, strlen(int) deprecated in PHP 8.1

// BEFORE (CPropertyValue::ensureArray)
$value = trim($value);
// $value can be null
```

### 3. Deprecated Cast Syntax

```php
// BEFORE (CHttpRequest, inside yiilite.php)
$q=(double)$matches[5][$i];

// BEFORE (CPropertyValue)
return (boolean)$value;
```

`(double)` is an alias for `(float)` and `(boolean)` is an alias for `(bool)`. Both are deprecated in favor of the canonical forms.

---

## The Fix

### 1. Strict `strpos()` Comparison

```php
// AFTER (CDbColumnSchema)
if(strpos($dbType,'(')!==false && preg_match('/\((.*)\)/',$dbType,$matches))

// AFTER (CController, CWidget in yiilite.php)
elseif(strpos($viewName,'.')!==false)
```

### 2. Null Guards and Type Casts

```php
// AFTER (CJSON)
for ($i = 0; $i < strlen( (string)$str ); $i++ )

// AFTER (CTimestamp)
case 'y': $dates .= substr((string)$year, strlen((string)$year)-2, 2);

// AFTER (CTimestamp::formatDate - null $fmt guard)
if ($fmt === null)
    $fmt = '';

// AFTER (CPropertyValue::ensureArray - null guard)
if($value===null)
    return array();
```

### 3. Canonical Cast Syntax

```php
// AFTER (CHttpRequest)
$q=(float)$matches[5][$i];

// AFTER (CPropertyValue)
return (bool)$value;
```

---

## Key Rule

> **Always use strict comparison (`!== false`) with `strpos()`.** In PHP 8.1+, never pass `null` to string functions -- add a null check or cast to `(string)`. Use `(bool)` and `(float)` instead of the deprecated `(boolean)` and `(double)` aliases.

---

## Files Involved

| File | Change |
|------|--------|
| `framework/db/schema/CDbColumnSchema.php` | `strpos()` strict comparison in `extractLimit()` |
| `framework/utils/CPropertyValue.php` | `(boolean)` to `(bool)`, null guard in `ensureArray()` |
| `framework/utils/CTimestamp.php` | Null guard on `$fmt`, `(string)` cast on `$year` for `strlen()`/`substr()` |
| `framework/web/helpers/CJSON.php` | `(string)` cast on `$str` for `strlen()` |
| `framework/yiilite.php` | `(double)` to `(float)` in CHttpRequest (4 occurrences), `strpos()` strict comparison in CController and CWidget |
