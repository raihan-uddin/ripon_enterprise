---
name: report
description: Scaffold a new report — creates controller action + filter view + result view. Use when the user says "create report", "new report", or "add report".
argument-hint: "<report name> [entity: customer|supplier|product|inventory|order]"
---

Scaffold a new report following the existing report pattern in this Yii 1.x ERP project.

## Required Input

`$ARGUMENTS` should contain:
- **Report name** (e.g., "Product Performance", "Monthly Sales")
- **Entity type** (optional: customer, supplier, product, inventory, order)

If not provided, ask the user for the report name and what data it should show.

## Steps

### Phase 1: Understand the Report

1. Ask the user (if not clear from arguments):
   - What data should this report display?
   - What filters are needed? (date range, customer, supplier, product, user, etc.)
   - Should it support grouping? (by date, month, year, customer, etc.)
   - Should it support sorting?
2. Determine the primary table(s) and joins needed.

### Phase 2: Read Existing Patterns

1. Read `protected/controllers/ReportController.php` to see the existing action pattern.
2. Read one existing report view (e.g., `themes/erp/views/report/salesReport.php`) for form structure.
3. Read one existing report view result (e.g., `themes/erp/views/report/salesReportView.php`) for table structure.

### Phase 3: Create Controller Actions

Add two actions to `protected/controllers/ReportController.php`:

**Action 1: `action{ReportName}()`** — renders the filter form
```php
public function action{ReportName}()
{
    $model = new Inventory();
    $this->pageTitle = 'REPORT TITLE';
    $this->render('{reportName}', array('model' => $model));
}
```

**Action 2: `action{ReportName}View()`** — AJAX endpoint that queries data and renders partial
```php
public function action{ReportName}View()
{
    if (Yii::app()->request->isAjaxRequest) {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
    }
    date_default_timezone_set("Asia/Dhaka");

    // Extract POST params safely
    $inv = Yii::app()->request->getPost('Inventory', []);
    $dateFrom = isset($inv['date_from']) ? trim($inv['date_from']) : null;
    $dateTo = isset($inv['date_to']) ? trim($inv['date_to']) : null;

    // Validate & query
    // ... (use CDbCriteria or raw SQL with parameterized queries)

    echo $this->renderPartial('{reportName}View', array(
        'data' => $data,
        'message' => $message,
        // ... other vars
    ), true, true);

    Yii::app()->end();
}
```

**Key rules for the controller action:**
- Always use parameterized queries (`:placeholder` bindings) — NEVER concatenate `$_POST` into SQL
- Whitelist any `group_by` / `sort_by` values against an allowed array
- Use `Yii::app()->request->getPost()` instead of direct `$_POST`
- Call `Yii::app()->end()` after `renderPartial`

### Phase 4: Create Filter Form View

Create `themes/erp/views/report/{reportName}.php`:

**Structure:**
1. Include `report.css` stylesheet
2. BreadCrumb widget: `Report > Category > Report Name`
3. `CActiveForm` with id `inventory-form`
4. Card with filter fields:
   - Date From / Date To (with Lightpick date picker)
   - Entity dropdowns (customer autocomplete, supplier, product, etc.)
   - Group By / Sort By dropdowns (if applicable)
5. Search button with AJAX submit to `{reportName}View` action
6. Result div: `<div id="resultDiv"></div>`
7. Lightpick initialization script at bottom

**Date picker pattern:**
```javascript
var picker = new Lightpick({
    field: document.getElementById('Inventory_date_from'),
    onSelect: function(date) {
        document.getElementById('Inventory_date_from').value = date.format('YYYY-MM-DD');
    }
});
```

**AJAX submit pattern:**
```php
echo CHtml::submitButton('Search', array(
    'ajax' => array(
        'type' => 'POST',
        'url' => CController::createUrl('/report/{reportName}View'),
        'beforeSend' => 'function(){ /* validate, show loader */ }',
        'complete' => 'function(){ /* hide loader */ }',
        'update' => '#resultDiv',
    ),
    'class' => 'btn btn-success btn-md',
    'id' => 'reportSearchButton',
));
```

### Phase 5: Create Result View

Create `themes/erp/views/report/{reportName}View.php`:

**Structure:**
1. Print & Excel export buttons (mPrint widget + table2excel)
2. Report meta card (company name, date range, filters applied, generated time)
3. HTML table with class `summaryTab table2excel`:
   - `<thead>` with column headers (dark bg `#212529`)
   - `<tbody>` with data rows (foreach loop, accumulate totals)
   - Alert div if no data found
   - Footer row with grand totals (dark bg, bold)
4. Optional: modal for drill-down (invoice preview)
5. Excel export script at bottom

**Table styling pattern:**
- Use inline `number_format($value, 2)` for currency columns
- Right-align numeric columns: `style="text-align: right;"`
- Center-align serial/date columns: `style="text-align: center;"`
- Serial number counter: `$sl = 1; echo $sl++;`

### Phase 6: Add to Navigation

1. Read `protected/components/views/UserMenu.php`
2. Add the report link under the Reports dropdown menu
3. Add the permission key to the `array_fill_keys` list
4. Wrap in `$ca('Report.{ReportName}')` permission check

### Phase 7: Verify

1. Run `php -l` on all created/modified files
2. Confirm the action names match the view filenames
3. Confirm the AJAX URL in the form matches the View action

## Rules

- Always use the `Inventory` model for filter form fields (project convention)
- Always use parameterized SQL queries — never concatenate user input
- Whitelist group_by and sort_by values
- Follow existing naming: `camelCase` for action names, same for view filenames
- Include both print and Excel export in result views
- Set `date_default_timezone_set("Asia/Dhaka")` in view actions
- Use `CHtml::encode()` for all user-supplied output
