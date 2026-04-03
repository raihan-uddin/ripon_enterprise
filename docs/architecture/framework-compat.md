# Framework PHP 8.x Compatibility Patches

The project uses Yii 1.x (`framework/`), which predates PHP 8.0. Several framework source files have been patched in-tree to eliminate deprecation warnings and runtime errors under PHP 8.x.

## Patched Files

| File | Fix |
|------|-----|
| `framework/db/schema/CDbColumnSchema.php` | `strpos()` strict comparison (`!== false`) |
| `framework/db/schema/pgsql/CPgsqlColumnSchema.php` | `strpos()` strict comparison |
| `framework/db/schema/oci/COciColumnSchema.php` | `strpos()` strict comparison |
| `framework/utils/CPropertyValue.php` | Null guard in `ensureArray()`; `(boolean)` cast replaced with `(bool)` |
| `framework/utils/CTimestamp.php` | Null guard for `$fmt` parameter; `(string)` cast on `$year` for `strlen()`/`substr()` |
| `framework/web/helpers/CJSON.php` | `(string)` cast on argument to `strlen()` |
| `framework/web/CHttpRequest.php` | `(double)` cast replaced with `(float)` (4 occurrences) |
| `framework/web/CController.php` | `strpos()` strict comparison |
| `framework/web/widgets/CWidget.php` | `strpos()` strict comparison |
| `framework/logging/CLogFilter.php` | `"${var}"` interpolation replaced with `"\$".$name."="` concatenation |
| `framework/validators/CTypeValidator.php` | `(boolean)` cast replaced with `(bool)` |
| `framework/yiilite.php` | Compiled copy — mirrors all fixes from the source files above |

## Fix Patterns

### 1. `strpos()` Strict Comparison

PHP 8.x made `strpos()` return `false` more consistently and deprecated loose truthiness checks. All calls like `if(strpos($s, '.'))` were changed to `if(strpos($s, '.') !== false)` to avoid treating position `0` as falsy.

**Affected:** `CDbColumnSchema`, `CPgsqlColumnSchema`, `COciColumnSchema`, `CController`, `CWidget`

### 2. Null Guards

PHP 8.x raises `TypeError` when built-in string functions receive `null`. Guards were added to convert `null` to a safe default before the function call.

**Affected:** `CPropertyValue::ensureArray()` (returns `array()` on null), `CTimestamp::formatDate()` (defaults `$fmt` to `''`)

### 3. Deprecated Type Casts

`(boolean)` and `(double)` are deprecated aliases in PHP 8.x. Replaced with `(bool)` and `(float)`.

**Affected:** `CPropertyValue`, `CTypeValidator`, `CHttpRequest`

### 4. `${var}` String Interpolation

PHP 8.2 deprecated `"${var}"` interpolation syntax. Replaced with explicit concatenation.

**Affected:** `CLogFilter`

### 5. `strlen()`/`substr()` on Non-String Arguments

PHP 8.x is stricter about passing non-string values to string functions. Added explicit `(string)` casts.

**Affected:** `CTimestamp` (`$year` argument), `CJSON` (`$str` argument)

## Important: `yiilite.php`

`framework/yiilite.php` is a **compiled single-file copy** of the core framework classes. Any fix applied to a source file must also be applied to the corresponding section in `yiilite.php`. The current patched classes in `yiilite.php` are:

- `CHttpRequest` — `(double)` to `(float)`
- `CController` — `strpos()` strict comparison
- `CWidget` — `strpos()` strict comparison

When patching additional framework files in the future, always check whether the same class appears in `yiilite.php` and apply the fix there as well.
