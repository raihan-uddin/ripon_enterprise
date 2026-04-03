---
name: crud
description: Scaffold CRUD for a new entity — model, controller, views. Use when the user says "create crud", "scaffold", "new entity", or "new module entity".
argument-hint: "<entity name> <table name> [module: sell|commercial|accounting|inventory|loan]"
---

Scaffold a complete CRUD (Create, Read, Update, Delete) for a new entity following this project's exact conventions.

## Required Input

`$ARGUMENTS` should contain:
- **Entity name** (PascalCase, e.g., "ProductCategory", "WarehouseZone")
- **Table name** (snake_case, e.g., "product_categories", "warehouse_zones")
- **Module** (optional: sell, commercial, accounting, inventory, loan — if omitted, creates in core)

If not provided, ask the user for entity name, table name, and whether it belongs to a module.

## Steps

### Phase 1: Discover Schema

1. Run `DESCRIBE {table_name}` to get all columns, types, keys
2. Run `SHOW INDEX FROM {table_name}` to get indexes
3. Determine:
   - Required fields (NOT NULL without DEFAULT)
   - Numeric fields (int, decimal, float, double)
   - String fields with max length
   - Foreign key columns (named `*_id`)
   - Audit columns (created_at, created_by, updated_at, updated_by, business_id, branch_id)
   - Soft delete flag (is_deleted)

### Phase 2: Read Existing Patterns

Before writing any code, read these reference files to match the exact style:

**For core entities:**
- Model: `protected/models/Units.php` or `protected/models/ProdBrands.php`
- Controller: `protected/controllers/UnitsController.php` or `protected/controllers/ProdBrandsController.php`
- Views: `themes/erp/views/units/admin.php`, `_form.php`, `_form2.php`

**For module entities:**
- Model: `protected/modules/{module}/models/` (pick one from target module)
- Controller: `protected/modules/{module}/controllers/` (pick one)
- Views: `protected/modules/{module}/views/` (pick one set)

### Phase 3: Create Model

**Location:**
- Core: `protected/models/{EntityName}.php`
- Module: `protected/modules/{module}/models/{EntityName}.php`

**Structure:**
```php
class EntityName extends CActiveRecord
{
    public function tableName() { return 'table_name'; }

    public function rules() {
        // Generated from DESCRIBE output:
        // - required: NOT NULL columns without defaults
        // - numerical: int/decimal/float columns
        // - length: varchar(N) columns
        // - unique: columns with UNIQUE index
        // - safe on search: all searchable columns
    }

    public function relations() {
        // Generated from *_id columns:
        // - BELONGS_TO for foreign keys
        // - Check if other tables reference this entity for HAS_MANY
    }

    public function attributeLabels() {
        // Human-readable labels from column names
        // snake_case → Title Case (e.g., 'customer_id' → 'Customer')
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function search() {
        // CDbCriteria with compare() for each searchable column
        // CActiveDataProvider with pagination (pageSize: 50) and sort (defaultOrder: 'id DESC')
    }

    public function beforeSave() {
        // Set business_id from session if column exists
        // Set created_by/updated_by if columns exist
        // Set created_at/updated_at timestamps if columns exist
        return parent::beforeSave();
    }
}
```

### Phase 4: Create Controller

**Location:**
- Core: `protected/controllers/{EntityName}Controller.php`
- Module: `protected/modules/{module}/controllers/{EntityName}Controller.php`

**Must include these actions:**
- `actionAdmin()` — list with grid (default action)
- `actionCreate()` — AJAX create with validation
- `actionUpdate($id)` — AJAX update via dialog
- `actionDelete($id)` — POST-only delete
- `actionCreate{EntityName}FromOutSide()` — AJAX create from modal dialog (for use from other forms)
- `loadModel($id)` — find by PK or throw 404
- `performAjaxValidation($model)` — AJAX form validation

**Key patterns:**
- Extends `RController` (NOT `Controller`)
- `$defaultAction = 'admin'`
- `filters()` returns `array('rights')`
- Create action returns JSON: `CJSON::encode(array('status' => 'success'))`
- Update action uses `Yii::app()->clientScript->scriptMap['jquery.js'] = false`
- Delete action checks `isPostRequest`

### Phase 5: Create Views

**Location:**
- Core: `themes/erp/views/{entityName}/`
- Module: `protected/modules/{module}/views/{entityName}/`

Create these files:

#### `admin.php` — Main list page
- BreadCrumb widget with navigation path
- Renders `_form` (new) or `_form2` (edit) based on `$model->isNewRecord`
- Flash messages display
- `GroupGridView` widget with:
  - Filter inputs in header
  - Columns for key fields
  - CButtonColumn with edit (pencil) and delete (trash) buttons
  - Edit button opens jQuery UI dialog
  - Pagination with CLinkPager (Font Awesome arrows)
  - Summary text with page/record counts
- "Go to page" input at bottom
- jQuery UI `CJuiDialog` widget for update modal

#### `_form.php` — Create form (AJAX submit)
- `CActiveForm` with `enableClientValidation: true`
- Card with gradient header (indigo/purple: `#4f46e5` → `#7c3aed`)
- Floating-label inputs with icon prefixes (`.mn-fl` pattern)
- Dropdowns for foreign key fields (populated from related model)
- `CHtml::ajaxSubmitButton` that:
  - Posts to `{entityName}/create`
  - On success: shows toastr, resets form, refreshes grid
  - On error: shows validation errors
- Ripple effect on submit button
- CSS class prefix: first two letters of entity name (e.g., `wz-` for WarehouseZone)

#### `_form2.php` — Update form (regular submit)
- Same layout as `_form.php` but:
  - Uses `CHtml::submitButton` instead of `ajaxSubmitButton`
  - Title shows entity name being edited
  - No grid refresh (handled by dialog close)

#### `create.php` — Simple wrapper
```php
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
```

#### `update.php` — Simple wrapper
```php
<?php echo $this->renderPartial('_form2', array('model' => $model)); ?>
```

#### `view.php` — Detail view (optional, create if entity has many fields)
- `CDetailView` widget showing all attributes
- Back button to admin list

### Phase 6: Register & Wire Up

1. **If module entity**: ensure the module's `init()` imports the new model
2. **Navigation**: add menu item in `UserMenu.php` under the appropriate dropdown:
   - Add permission key to `array_fill_keys` list
   - Add `$ca('EntityName.Admin')` check
   - Add dropdown item with Font Awesome icon

### Phase 7: Verify

1. Run `php -l` on all created files
2. Verify model's `tableName()` matches the actual DB table
3. Verify controller extends `RController` and has `'rights'` filter
4. Verify form IDs are consistent: `{entity-name}-form`, `{entity-name}-grid`
5. Verify AJAX URLs in forms point to correct actions

## Output

After scaffolding, show:

```
/crud summary
-----------------------------------------------
Entity:     EntityName
Table:      table_name
Location:   core | module/{module}
-----------------------------------------------
Created files:
  Model:      protected/models/EntityName.php
  Controller: protected/controllers/EntityNameController.php
  Views:
    - themes/erp/views/entityName/admin.php
    - themes/erp/views/entityName/_form.php
    - themes/erp/views/entityName/_form2.php
    - themes/erp/views/entityName/create.php
    - themes/erp/views/entityName/update.php
Modified files:
  - protected/components/views/UserMenu.php (nav item added)
-----------------------------------------------
Columns mapped: N fields
Relations: N BELONGS_TO, N HAS_MANY
```

## Rules

- Always read the DB schema first — don't guess column types
- Match the exact CSS/HTML patterns from existing forms (floating labels, gradient headers, card layout)
- Use `CHtml::encode()` for all displayed values
- Never hardcode business_id — always get from `Yii::app()->user->getState('business_id')`
- Form field IDs must match model: `EntityName_field_name`
- Grid ID: `entity-name-grid` (lowercase, hyphenated)
- Form ID: `entity-name-form` (lowercase, hyphenated)
- CSS class prefix: unique 2-3 letter abbreviation of entity name
- Include both create-from-page and create-from-modal (FromOutSide) actions
