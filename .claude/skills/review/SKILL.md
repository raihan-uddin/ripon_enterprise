---
name: review
description: Code review — lint PHP, check security, review patterns. Use when the user says "review", "check my code", or "code review".
argument-hint: "[optional file or path to focus on]"
---

Review code changes in the current session or branch for quality, security, and Yii conventions.

## Steps

### Phase 1: Identify Changes

1. If `$ARGUMENTS` specifies a file/path, focus on that.
2. Otherwise, run `git diff --stat` and `git diff --cached --stat` to find all changed files.
3. Read each changed file to understand the modifications.

### Phase 2: PHP Syntax Check

Run `php -l` on every changed `.php` file. Report any syntax errors immediately.

### Phase 3: Security Review

Check changed files for these common vulnerabilities:

| Risk | What to look for |
|------|-----------------|
| **SQL Injection** | Raw `$_POST`/`$_GET` values concatenated into SQL strings. Should use parameterized queries (`CDbCriteria->params`, `:placeholder` bindings) or `createCommand()->bindParam()` |
| **XSS** | Echoing user input without `CHtml::encode()`. All output in views should be encoded unless intentionally rendering HTML |
| **Mass Assignment** | `$model->attributes = $_POST[...]` without proper `rules()` safe attributes. Check model `rules()` for `'safe'` scenario |
| **CSRF** | Forms missing `enableCsrfValidation`. POST actions without CSRF token |
| **File Upload** | Unrestricted file types, missing validation on uploaded files |
| **Direct `$_POST`/`$_GET`** | Should use `Yii::app()->request->getPost()` / `getQuery()` instead |

### Phase 4: Yii Pattern Review

Check for these project conventions:

| Pattern | Expected |
|---------|----------|
| **Controller base** | Must extend `RController` (not `Controller` or `CController`) |
| **RBAC filter** | Controller `filters()` must include `'rights'` |
| **View location** | Views should be in `themes/erp/views/` (not `protected/views/`) |
| **Transactions** | Multi-table writes must use `beginTransaction()` / `commit()` / `rollBack()` |
| **Error handling** | Transaction catch blocks must check `$transaction->active` before rollback |
| **Model factory** | Must have `public static function model($className = __CLASS__)` |
| **Soft delete** | Check if `is_deleted` flag is used instead of hard deletes |
| **Business ID** | Models should set `business_id` in `beforeSave()` |
| **Date timezone** | Report/view actions should set `date_default_timezone_set("Asia/Dhaka")` |

### Phase 5: Code Quality

| Check | Details |
|-------|---------|
| **Dead code** | Commented-out code blocks, unused variables |
| **Duplication** | Same logic repeated across files — suggest extraction |
| **Large files** | Files over 500 lines — suggest splitting |
| **Naming** | Consistent naming (camelCase for PHP methods, snake_case for DB columns) |
| **Error messages** | User-facing errors should be clear, not raw exception dumps |

### Phase 6: Output Report

Format the review as:

```
/review summary
-----------------------------------------------
File                          Issues
-----------------------------------------------
path/to/file.php              2 security, 1 pattern
path/to/other.php              0 issues
-----------------------------------------------
Total: N files reviewed, X issues found

CRITICAL (fix now):
- [file:line] SQL injection: raw $_POST in query string
- [file:line] XSS: unencoded output

WARNING (should fix):
- [file:line] Missing transaction rollback check
- [file:line] Direct $_POST access, use getPost()

INFO (nice to have):
- [file:line] File is 600 lines, consider splitting
```

## Rules

- Only review files that were changed — don't audit the entire codebase
- Prioritize security issues above all else
- Be specific: include file path and line number for every issue
- Don't flag vendor/extension code — only project code
- Suggest fixes, don't just point out problems
