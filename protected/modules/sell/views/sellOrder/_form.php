<?php
$this->widget('application.components.BreadCrumb', array(
        'crumbs' => array(
                array('name' => 'Sales', 'url' => array('admin')),
                array('name' => 'Order', 'url' => array('admin')),
                array('name' => 'Create'),
        ),
));
$form = $this->beginWidget('CActiveForm', array(
        'id' => 'bom-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
));
Yii::app()->clientScript->registerCoreScript("jquery.ui");

?>

<style>
    /* =========================================================
   SALES ENTRY UI — DOCUMENTED STYLESHEET
   Author: RAIHAN UDDIN SUFAL
   Purpose:
   - Provide consistent ERP-style UI for sales entry
   - Improve focus, readability, and financial clarity
   ========================================================= */


    /* =========================================================
       1) GLOBAL INPUT STYLES
       - Clean, professional feel
       - Subtle hover + focus feedback
       ========================================================= */

    input {
        background-color: #ffffff;
        color: #212529;
        border: 1px solid #ced4da;
        padding: 6px 10px;
        transition: background-color 0.2s ease,
        border-color 0.2s ease,
        box-shadow 0.2s ease;
    }

    /* Hover state */
    input:hover {
        background-color: #f1f7fb;
        border-color: #236280;
        cursor: text;
    }

    /* Focus state */
    input:focus {
        background-color: #ffffff;
        border-color: #236280;
        outline: none;
        box-shadow: 0 0 0 0.15rem rgba(35, 98, 128, 0.25);
    }

    /* Disabled state */
    input:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
        opacity: 0.7;
    }


    /* =========================================================
       2) INPUT GROUPS (PERCENT / SYMBOL FIELDS)
       - Prevent breaking on small screens
       ========================================================= */

    .input-group-custom {
        flex-wrap: nowrap;
    }

    .input-group-custom .input-group-text {
        height: 28px;
        line-height: 26px;
        padding: 0 8px;
        white-space: nowrap;
    }


    /* =========================================================
       3) GLOBAL SUMMARY BAR (TOP STICKY BAR)
       ========================================================= */

    #global-bar {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #212529;
        color: #ffffff;
        padding: 6px 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        border-bottom: 2px solid #17a2b8;
    }

    #global-bar .g-stat {
        margin-left: 12px;
    }

    #global-bar b {
        font-weight: 600;
    }

    #global-bar .btn {
        font-size: 12px;
        padding: 2px 8px;
    }


    /* =========================================================
       4) COMPANY HEADER BAR
       - Sticky section headers
       - Visual "ready" state
       ========================================================= */

    .company-bar {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 8px 12px;
        position: sticky;
        top: 0;
        z-index: 5;
        transition: box-shadow 0.2s ease, background 0.2s ease;
    }

    /* Ready state (all rows filled) */
    .company-bar.ready {
        background: #f0fff4;
        box-shadow: 0 0 0 1px #28a745 inset;
    }

    /* Top row inside company bar */
    .company-bar-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
    }

    /* Right side actions */
    .company-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Toggle arrow */
    .toggle-icon {
        cursor: pointer;
        font-size: 12px;
        opacity: 0.7;
    }

    .toggle-icon:hover {
        opacity: 1;
    }

    /* Stats row */
    .company-bar-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    /* Individual stat card */
    .company-bar-stats .stat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        min-width: 90px;
        padding: 2px 8px;
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        font-size: 12px;
    }

    .company-bar-stats .stat small {
        color: #6c757d;
    }

    /* Highlight stat (e.g. total / margin) */
    .company-bar-stats .highlight {
        background: #e8f5e9;
        border-color: #28a745;
    }

    /* Margin badges */
    .margin-badge.bad {
        background: #dc3545 !important;
    }

    .margin-badge.good {
        background: #28a745 !important;
    }

    /* Progress animation */
    .fill-progress {
        transition: width 0.3s ease;
    }


    /* =========================================================
       5) COMPANY SUB HEADER (TABLE COLUMN LABELS)
       - Sticky inside scroll container
       ========================================================= */

    .company-sub-header th {
        position: sticky;
        top: 92px; /* GLOBAL BAR + COMPANY BAR height */
        z-index: 6;
        background: #ffffff;
        border-bottom: 2px solid #dee2e6;
        font-size: 12px;
        font-weight: 600;
        color: #495057;
        padding: 6px 8px;
        white-space: nowrap;
    }

    /* Accent stripe */
    .company-sub-header th:first-child {
        border-left: 3px solid #17a2b8;
    }

    /* Active company highlight */
    .company-header.active + .company-sub-header th {
        background: #f0fbff;
    }


    /* =========================================================
       6) COMPACT TABLE STYLE
       ========================================================= */

    .table-compact td,
    .table-compact th {
        padding: 4px 6px;
        font-size: 13px;
        white-space: nowrap;
    }

    /* Inputs inside table cells */
    .table-compact input.form-control {
        height: 28px;
        padding: 2px 6px;
        font-size: 13px;
    }

    /* Utility */
    .hidden {
        display: none;
    }

    tbody {
        padding: 0;
        margin: 0;
    }


    /* =========================================================
       7) ROW STATES (DATA ENTRY FEEDBACK)
       ========================================================= */

    .item {
        transition: background 0.15s ease, box-shadow 0.15s ease;
    }

    /* Focused row */
    .item.focused {
        background: #f0fbff;
    }

    /* Error state */
    .item.error {
        background: #fff5f5;
    }

    /* Valid state */
    .item.ok {
        background: #f3fff5;
    }

    /* Inline hint text */
    .row-hint {
        font-size: 11px;
        margin-top: 2px;
    }


    /* =========================================================
   8) FINANCIAL SUMMARY PANEL
   - 3-column grid (label | spacer | fields)
   - Right-aligned accounting layout
   - Clear visual hierarchy for totals & adjustments
   ========================================================= */

    .summary-card {
        background: #f8f9fa;
        border-top: 3px solid #17a2b8;
        padding: 12px;
        font-size: 13px;
        border-radius: 4px;
    }

    /* Row layout: label | spacer | fields (fields hug right edge) */
    .summary-row {
        display: grid;
        grid-template-columns: max-content 1fr max-content;
        align-items: center;
        padding: 6px 0;
        column-gap: 12px;
        border-bottom: 1px dashed #dee2e6;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    /* ===== LABEL ===== */
    .summary-label {
        display: inline-flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;

        font-weight: 600;
        color: #343a40;
        white-space: nowrap;
        text-align: right;
    }

    /* Optional icon bubble (% / + / -) */
    .summary-label .label-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        font-size: 11px;
        font-weight: 700;
        background: #e3f2fd;
        color: #0d6efd;
    }

    /* (+) / (-) pill */
    .summary-label .label-sign {
        font-size: 11px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 700;
        line-height: 1;
    }

    .summary-label .label-sign.plus {
        background: #e6f4ea;
        color: #28a745;
    }

    .summary-label .label-sign.minus {
        background: #fdecea;
        color: #dc3545;
    }

    /* ===== FIELDS ===== */
    .summary-fields {
        display: flex;
        justify-content: flex-end; /* stick to right edge */
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Individual field containers */
    .field {
        min-width: 120px;
        text-align: right;
    }

    .field.wide {
        min-width: 220px;
    }

    /* Accounting-style inputs */
    .summary-card input {
        font-family: "JetBrains Mono", monospace;
        letter-spacing: 0.4px;
        height: 30px;
        padding: 4px 6px;
    }

    /* ===== PRIMARY TOTALS (Top Section) ===== */
    .summary-primary {
        background: #ffffff;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    /* ===== GRAND TOTAL ===== */
    .summary-grand {
        background: #e8f5e9;
        border-top: 3px solid #28a745;
        padding-top: 10px;
    }

    .grand-input {
        font-size: 18px;
        font-weight: 700;
        color: #28a745;
        border: 2px solid #28a745;
        background: #ffffff;
    }

    /* Subtle focus glow */
    .grand-input:focus {
        box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.15);
    }

    /* ===== HOVER POLISH ===== */
    .summary-row:hover {
        background: rgba(0, 123, 255, 0.03);
    }

    /* ===== MOBILE / TABLET ===== */
    @media (max-width: 768px) {
        .summary-row {
            grid-template-columns: 1fr;
            row-gap: 6px;
        }

        .summary-label {
            justify-content: flex-start;
            text-align: left;
        }

        .summary-fields {
            justify-content: flex-start;
        }

        .field,
        .field.wide {
            min-width: 100%;
        }
    }

    /* ================================
   CUSTOMER AUTOCOMPLETE PANEL
   ================================ */

    /* Container */
    .customer-ac {
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        max-height: 320px;
        overflow-y: auto;
        padding: 4px;
        z-index: 9999 !important;
    }

    /* Kill jQuery UI default spacing */
    .customer-ac .ui-menu-item {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Each row */
    .customer-ac-card {
        padding: 6px 10px;
        border-radius: 6px;

        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        gap: 6px;

        cursor: pointer;
        border: 1px solid transparent;

        transition: background 0.12s ease,
        border 0.12s ease,
        transform 0.05s ease;
    }

    /* Hover & keyboard focus */
    .customer-ac-card:hover,
    .customer-ac-card.active {
        background: #f0fbff;
        border-color: #17a2b8;
    }

    /* Main text column */
    .customer-ac-main {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    /* Customer name */
    .customer-ac-name {
        font-weight: 600;
        font-size: 13px;
        line-height: 1.2;
        color: #212529;
    }

    /* Meta row */
    .customer-ac-meta {
        font-size: 10px;
        line-height: 1.1;
        color: #6c757d;
        display: flex;
        gap: 10px;
    }

    /* Right-side indicator */
    .customer-ac-check {
        font-size: 12px;
        opacity: 0.5;
    }

    /* Scrollbar styling */
    .customer-ac::-webkit-scrollbar {
        width: 6px;
    }

    .customer-ac::-webkit-scrollbar-thumb {
        background: #ced4da;
        border-radius: 10px;
    }

    .customer-ac::-webkit-scrollbar-thumb:hover {
        background: #adb5bd;
    }


</style>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Order' : 'Update Order'); ?></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'date', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" id="entry_date" data-target-input="nearest">
                            <?php echo $form->textField($model, 'date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'date'); ?></span>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-4">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'customer_id', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" data-target-input="nearest">
                            <label for="customer_id_text"></label><input type="text" id="customer_id_text"
                                                                         class="form-control customer-ac-input">
                            <?php echo $form->hiddenField($model, 'customer_id', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => 'Search customer by name, ID, or phone...')); ?>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <?php echo CHtml::link(' <i class="fa fa-plus"></i>', "", array('onclick' => "{addDistributor(); $('#dialogAddDistributor').dialog('open');}")); ?>
                                    <?php
                                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                            'id' => 'dialogAddDistributor',
                                            'options' => array(
                                                    'title' => 'Add Customer',
                                                    'autoOpen' => false,
                                                    'modal' => true,
                                                    'width' => '1288px',
                                                    'left' => '30px',
                                                    'resizable' => false,
                                            ),
                                    ));
                                    ?>
                                    <div class="divForForm">
                                        <div class="ajaxLoaderFormLoad" style="display: none;"><img
                                                    src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/>
                                        </div>
                                    </div>
                                    <?php $this->endWidget(); ?>

                                    <script type="text/javascript">
                                        function addDistributor() {
                                            <?php
                                            echo CHtml::ajax(array(
                                                    'url' => array('/sell/customers/createCustomerFromOutSide'),
                                                    'data' => "js:$(this).serialize()",
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'beforeSend' => "function(){
                                                    $('.ajaxLoaderFormLoad').show();
                                                }",
                                                    'complete' => "function(){
                                                    $('.ajaxLoaderFormLoad').hide();
                                                }",
                                                    'success' => "function(data){
                                                    if (data.status == 'failure')
                                                    {
                                                        $('#dialogAddDistributor div.divForForm').html(data.div);
                                                              // Here is the trick: on submit-> once again this function!
                                                        $('#dialogAddDistributor div.divForForm form').submit(addDistributor);
                                                    }
                                                    else
                                                    {
                                                        $('#dialogAddDistributor div.divForForm').html(data.div);
                                                        setTimeout(\"$('#dialogAddDistributor').dialog('close') \",1000);
                                                        $('#customer_id_text').val(data.label);
                                                        $('#SellOrder_customer_id').val(data.id).change();
                                                        $('#SellOrder_city').val(data.city).change();
                                                        $('#SellOrder_state').val(data.state).change();
                                                    }
                                                }",
                                            ))
                                            ?>
                                            return false;
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'customer_id'); ?></span>

                    <script>
                        $(function () {

                            const $input = $('#customer_id_text');
                            const $hidden = $('#SellOrder_customer_id');

                            $input.autocomplete({
                                minLength: 1,
                                autoFocus: true,
                                delay: 200,
                                classes: {
                                    "ui-autocomplete": "customer-ac"
                                },

                                source: function (request, response) {
                                    $input.addClass('customer-ac-loading');

                                    $.post(
                                        '<?php echo Yii::app()->baseUrl ?>/index.php/sell/customers/Jquery_customerSearch',
                                        {q: request.term},
                                        function (data) {
                                            $input.removeClass('customer-ac-loading');

                                            // Auto-select if only ONE result
                                            if (Array.isArray(data) && data.length === 1) {
                                                const item = data[0];

                                                $input.val(item.value || item.name);
                                                $hidden.val(item.id);
                                                $input.autocomplete('close');
                                                return;
                                            }

                                            response(data);
                                        },
                                        'json'
                                    );
                                },

                                select: function (event, ui) {
                                    $input.val(ui.item.value || ui.item.name);
                                    $hidden.val(ui.item.id);
                                    return false;
                                }
                            })

                                // Custom card-style rendering
                                .autocomplete('instance')._renderItem = function (ul, item) {
                                return $('<li class="customer-ac-item">')
                                    .append(`
                <div class="customer-ac-card">
                    <div class="customer-ac-main">
                        <div class="customer-ac-name">${item.name}</div>
                        <div class="customer-ac-meta">
                            <span>ID: ${item.id}</span>
                            <span class="customer-ac-phone">📞 ${item.contact_no || 'N/A'}</span>
                        </div>
                    </div>
                    <div class="customer-ac-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            `)
                                    .appendTo(ul);
                            };

                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Order Items</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                        <div id="global-bar">
                            <div class="global-left">
                                <b>📊 ALL COMPANIES</b>
                                <span class="g-stat">SKU <b id="g-sku">0</b></span>
                                <span class="g-stat">QTY <b id="g-qty">0</b></span>
                                <span class="g-stat">TOTAL <b id="g-total">৳ 0.00</b></span>
                                <span class="g-stat">COST <b id="g-cost">৳ 0.00</b></span>
                                <span class="g-stat">MARGIN <b id="g-margin">0%</b></span>
                            </div>
                        </div>
                        <table class="table table-bordered table-sm table-valign-middle table-sticky table-compact"
                               id="list">
                            <tbody>
                            <?php
                            $criteria = new CDbCriteria();
                            $criteria->select = "
                                t.id, t.model_name, t.code, t.sell_price, t.purchase_price,
                                companies.name AS company_name,
                                (SUM(inventory.stock_in) - SUM(inventory.stock_out)) AS current_stock
                            ";
                            $criteria->addColumnCondition(['t.status' => 1]);
                            $criteria->join = "
                                LEFT JOIN companies ON companies.id = t.manufacturer_id
                                LEFT JOIN inventory ON inventory.model_id = t.id
                            ";
                            $criteria->group = "t.id";
                            $criteria->order = "companies.name ASC, t.model_name ASC";
                            $data = ProdModels::model()->findAll($criteria);

                            $sl = 1;
                            $currentCompany = '';
                            $groupIndex = 0;

                            foreach ($data as $item) {
                                if ($currentCompany !== $item->company_name) {
                                    $groupIndex++;
                                    $currentCompany = $item->company_name;
                                    ?>

                                    <!-- Company Header -->
                                    <tr class="company-header"
                                        data-target="company-<?= $groupIndex ?>">
                                        <td colspan="8" class="p-0">

                                            <div class="company-bar">

                                                <div class="company-bar-top">
                                                    <span class="company-name">
                                                        🏭 <?= CHtml::encode($currentCompany) ?>
                                                    </span>

                                                    <div class="company-actions">
                                                        <span class="margin-badge badge badge-secondary">
                                                            MARGIN: 0%
                                                        </span>
                                                        <span class="toggle-icon">▼</span>
                                                    </div>
                                                </div>

                                                <div class="company-bar-stats">
                                                    <span class="stat sku-count">
                                                        <small>SKU </small><b>0</b>
                                                    </span>

                                                    <span class="stat qty-total">
                                                        <small>QTY </small><b>0</b>
                                                    </span>

                                                    <span class="stat avg-price">
                                                        <small>AVG SP </small><b>৳ 0</b>
                                                    </span>

                                                    <span class="stat amount-total highlight">
                                                        <small>TOTAL </small><b>৳ 0.00</b>
                                                    </span>

                                                    <span class="stat cost-total">
                                                        <small>COST </small><b>৳ 0.00</b>
                                                    </span>
                                                </div>

                                                <div class="progress mt-1" style="height:6px;">
                                                    <div class="progress-bar bg-info fill-progress"
                                                         style="width:0%"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                    <!-- Company Sub-Header -->
                                    <tr class="company-<?= $groupIndex ?> company-sub-header hidden">
                                        <th style="width: 5px;">SL</th>
                                        <th style="max-width: 150px;">Product Name</th>
                                        <th style="width: 10px;" class="text-center">Stock</th>
                                        <th style="width: 10%;" class="text-center">Qty</th>
                                        <th style="width: 10%;" class="text-center">Unit Price</th>
                                        <th style="width: 10%;" class="text-center">Row Total</th>
                                    </tr>
                                    <?php
                                }
                                ?>

                                <!-- Product Row (collapsed by default) -->
                                <tr class="company-<?= $groupIndex ?> item hidden">
                                    <td class="serial text-center"><?= $sl++ ?></td>
                                    <td data-label="Product">
                                        <?php echo $item->model_name; ?>
                                        <br>
                                        <small>
                                            <i><?php echo $item->code; ?></i>
                                        </small>
                                        <input type="hidden" class="form-control temp_model_id"
                                               value="<?php echo $item->id; ?>"
                                               name="SellOrderDetails[temp_model_id][]">
                                    </td>
                                    <td class="text-center stock-cell"
                                        data-stock="<?= $item->current_stock ?>">
                                        <?= $item->current_stock ?>
                                        <div class="row-hint text-danger small d-none"></div>
                                    </td>

                                    <td class="text-center" data-label="Qty">
                                        <label>
                                            <input type="text"
                                                   class="form-control text-center temp_qty"
                                                   value=""
                                                   name="SellOrderDetails[temp_qty][]">
                                        </label>
                                    </td>

                                    <td class="text-center" data-label="Unit Price">
                                        <label>
                                            <input type="text"
                                                   class="form-control temp_unit_price text-right"
                                                   autocomplete="off"
                                                   inputmode="decimal"
                                                   value="<?php echo $item->sell_price; ?>"
                                                   name="SellOrderDetails[temp_unit_price][]">
                                        </label>
                                        <input type="hidden"
                                               class="form-control temp-costing"
                                               value="<?php echo $item->purchase_price; ?>"
                                               name="SellOrderDetails[temp_pp][]">
                                    </td>

                                    <td class="text-center" data-label="Row Total">
                                        <label>
                                            <input type="text"
                                                   class="form-control row-total text-right"
                                                   value=""
                                                   inputmode="decimal"
                                                   name="SellOrderDetails[temp_row_total][]">
                                        </label>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>

                            <tfoot>
                            <tr>
                                <td colspan="6" class="p-0">

                                    <div class="summary-card">

                                        <!-- Top Totals -->
                                        <div class="summary-row summary-primary ">
                                            <div class="summary-label">
                                                <?php echo $form->labelEx($model, 'total_amount'); ?>
                                            </div>
                                            <div></div> <!-- spacer column -->
                                            <div class="summary-fields">
                                                <div class="field">
                                                    <small>Total Qty</small>
                                                    <?php echo $form->textField($model, 'total_qty', [
                                                            'class' => 'form-control text-center',
                                                            'placeholder' => '0',
                                                            'readonly' => true
                                                    ]); ?>
                                                </div>

                                                <div class="field">
                                                    <small>Avg SP</small>
                                                    <?php echo $form->textField($model, 'avg_sp', [
                                                            'class' => 'form-control text-center',
                                                            'placeholder' => '0',
                                                            'readonly' => true
                                                    ]); ?>
                                                </div>

                                                <div class="field">
                                                    <small>Total Amount</small>
                                                    <?php echo $form->textField($model, 'total_amount', [
                                                            'class' => 'form-control text-center',
                                                            'placeholder' => '0.00',
                                                            'readonly' => true
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Adjustments -->
                                        <div class="summary-row">
                                            <div class="summary-label">
                                                <label><?php echo $form->labelEx($model, 'vat'); ?> (+)</label>
                                            </div>

                                            <div></div> <!-- spacer column -->

                                            <div class="summary-fields">
                                                <div class="field">
                                                    <div class="input-group input-group-custom">
                                                        <?php echo $form->textField($model, 'vat_percentage', [
                                                                'class' => 'form-control text-center',
                                                                'placeholder' => '0',
                                                                'value' => '0'
                                                        ]); ?>
                                                        <div class="input-group-append" style="height: 28px;">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="field">
                                                    <?php echo $form->textField($model, 'vat_amount', [
                                                            'class' => 'form-control text-center',
                                                            'placeholder' => '0.00',
                                                            'readonly' => true,
                                                            'value' => '0'
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="summary-row">
                                            <div class="summary-label">
                                                <label><?php echo $form->labelEx($model, 'delivery_charge'); ?>
                                                    (+)</label>
                                            </div>
                                            <div></div> <!-- spacer column -->
                                            <div class="summary-fields">
                                                <div class="field wide">
                                                    <?php echo $form->textField($model, 'delivery_charge', [
                                                            'class' => 'form-control text-center',
                                                            'placeholder' => '0.00',
                                                            'value' => '0'
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="summary-row">
                                            <div class="summary-label">
                                                <label> <?php echo $form->labelEx($model, 'discount_amount'); ?>
                                                    (-)</label>
                                            </div>
                                            <div></div> <!-- spacer column -->
                                            <div class="summary-fields">
                                                <div class="field wide">
                                                    <?php echo $form->textField($model, 'discount_amount', [
                                                            'class' => 'form-control text-center',
                                                            'placeholder' => '0.00',
                                                            'value' => '0'
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="summary-row">
                                            <div class="summary-label">
                                                <label><?php echo $form->labelEx($model, 'road_fee'); ?> (-)</label>
                                            </div>
                                            <div></div> <!-- spacer column -->
                                            <div class="summary-fields">
                                                <div class="field wide">
                                                    <?php echo $form->textField($model, 'road_fee', [
                                                            'class' => 'form-control text-center',
                                                            'placeholder' => '0.00',
                                                            'value' => '0'
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="summary-row">
                                            <div class="summary-label">
                                                <label><?php echo $form->labelEx($model, 'damage_value'); ?> (-)</label>
                                            </div>
                                            <div></div> <!-- spacer column -->
                                            <div class="summary-fields">
                                                <div class="field wide">
                                                    <?php echo $form->textField($model, 'damage_value', [
                                                            'class' => 'form-control text-center',
                                                            'placeholder' => '0.00',
                                                            'value' => '0'
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="summary-row">
                                            <div class="summary-label">
                                                <label><?php echo $form->labelEx($model, 'sr_commission'); ?>
                                                    (-)</label>
                                            </div>
                                            <div></div> <!-- spacer column -->
                                            <div class="summary-fields">
                                                <div class="field wide">
                                                    <?php echo $form->textField($model, 'sr_commission', [
                                                            'class' => 'form-control text-center',
                                                            'placeholder' => '0.00',
                                                            'value' => '0'
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Grand Total -->
                                        <div class="summary-row summary-grand">
                                            <div class="summary-label">
                                                <?php echo $form->labelEx($model, 'grand_total'); ?>
                                            </div>
                                            <div></div> <!-- spacer column -->
                                            <div class="summary-fields">
                                                <div class="field wide">
                                                    <?php echo $form->textField($model, 'grand_total', [
                                                            'class' => 'form-control text-center grand-input',
                                                            'placeholder' => '0.00',
                                                            'readonly' => true
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </td>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php echo $form->textArea($model, 'order_note', array('class' => 'form-control', 'placeholder' => 'Order Note')); ?>
            </div>
            <span class="help-block"
                  style="color: red; width: 100%"> <?php echo $form->error($model, 'order_note'); ?></span>
        </div>
    </div>

    <div class="card-footer">
        <div class="col-md-12">
            <?php
            echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('/sell/sellOrder/create', 'render' => true)), array(
                    'dataType' => 'json',
                    'type' => 'post',
                    'success' => 'function(data) {
                    $("#ajaxLoader").hide();  
                        if(data.status=="success"){
                            $("#formResult").fadeIn();
                            $("#formResult").html("Data saved successfully.");
                            toastr.success("Data saved successfully.");
                            $("#bom-form")[0].reset();
                            $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                            $("#list tbody").empty();
                            // $("#soReportDialogBox").dialog("open");
                            //$("#AjFlashReportSo").html(data.soReportInfo).show();
                            $("#information-modal").modal("show");
                            $("#information-modal .modal-body").html(data.soReportInfo);  
                        }else{
                            //$("#formResultError").html("Data not saved. Please solve the following errors.");
                            $.each(data, function(key, val) {
                                $("#bom-form #"+key+"_em_").html(""+val+"");                                                    
                                $("#bom-form #"+key+"_em_").show();
                            });
                        }       
                    }',
                    'beforeSend' => 'function(){  
                        let date = $("#SellOrder_date").val();  
                        let customer_id = $("#SellOrder_customer_id").val();  
                        let grand_total = $("#SellOrder_grand_total").val();  
                        if(date == ""){
                            toastr.error("Please insert date.");
                            return false;
                        }else if(customer_id == ""){
                            toastr.error("Please select customer from the list!");
                            return false;
                        }else if(grand_total == "" || grand_total <= 0){
                            toastr.error("Grand total amount is 0");
                            return false;
                        }else {                
                            $("#overlay").fadeIn(300);
                            $("#ajaxLoader").show();
                        }
                     }',
                    'error' => 'function(xhr, status, error) { 
                        // Code to handle errors
                        toastr.error(xhr.responseText); // Displaying error message using Toastr
                        // Optionally, you can display additional error details
                        console.error(xhr.statusText);
                        console.error(xhr.status);
                        console.error(xhr.responseText);
                    
                        $("#overlay").fadeOut(300);
                  }',
                    'complete' => 'function() {
                    $("#overlay").fadeOut(300);
                 $("#ajaxLoaderReport").hide(); 
              }',
            ), array('class' => 'btn btn-primary btn-md'));
            ?>
        </div>
        <div class="col-md-12 mt-1">
            <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
            </span>
            <div id="formResult" class="ajaxTargetDiv"></div>
            <div id="formResultError" class="ajaxTargetDivErr alert alert-danger  d-none" role="alert">
            </div>
        </div>
    </div>
</div>
<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<script>
    $(function () {

        /* ==========================
         * CONFIG
         * ========================== */
        const CFG = {
            DECIMALS: 4,
            MARGIN_WARNING: 4,
            SCROLL_OFFSET: 60,
            SELECTORS: {
                TABLE: '#list',
                COMPANY_HEADER: '.company-header',
                ROW: '.item',
                QTY: '.temp_qty',
                PRICE: '.temp_unit_price',
                ROW_TOTAL: '.row-total',
                COST: '.temp-costing',
                STOCK: '.stock-cell',

                GLOBAL: {
                    SKU: '#g-sku',
                    QTY: '#g-qty',
                    TOTAL: '#g-total',
                    COST: '#g-cost',
                    MARGIN: '#g-margin'
                },

                FORM: {
                    VAT_P: '#SellOrder_vat_percentage',
                    VAT_A: '#SellOrder_vat_amount',
                    ROAD: '#SellOrder_road_fee',
                    DAMAGE: '#SellOrder_damage_value',
                    DISCOUNT: '#SellOrder_discount_amount',
                    DELIVERY: '#SellOrder_delivery_charge',
                    COMMISSION: '#SellOrder_sr_commission',
                    TOTAL_QTY: '#SellOrder_total_qty',
                    TOTAL_AMOUNT: '#SellOrder_total_amount',
                    GRAND_TOTAL: '#SellOrder_grand_total',
                    AVG_SP: '#SellOrder_avg_sp'
                }
            }
        };

        /* ==========================
         * HELPERS
         * ========================== */
        const safeNumber = val => {
            const n = parseFloat(val);
            return isNaN(n) ? 0 : n;
        };

        const sanitizeDecimalInput = (el, decimals = CFG.DECIMALS) => {
            if (!el || !$(el).is('input, textarea')) return;

            let value = el.value || '';
            value = value
                .replace(/[^0-9.]/g, '')
                .replace(/(\..*)\./g, '$1');

            if (decimals !== null) {
                const re = new RegExp(`(\\.\\d{${decimals}}).+`);
                value = value.replace(re, '$1');
            }

            el.value = value;
        };

        /* ==========================
         * UI HELPERS
         * ========================== */
        function focusRow($row, state) {
            $row.toggleClass('focused', state);
        }

        function scrollTo($el) {
            $('html, body').animate({
                scrollTop: $el.offset().top - CFG.SCROLL_OFFSET
            }, 200);
        }

        /* ==========================
         * ROW LOGIC
         * ========================== */
        function updateRow($row) {
            const lastEdited = $row.data('lastEdited');

            const qty = safeNumber($row.find(CFG.SELECTORS.QTY).val());
            const price = safeNumber($row.find(CFG.SELECTORS.PRICE).val());
            const stock = safeNumber(
                $row.find(CFG.SELECTORS.STOCK).data('stock')
            );

            // Only recalc ROW TOTAL if user is NOT editing row total
            if (lastEdited !== 'row_total') {
                const total = qty * price;
                $row.find(CFG.SELECTORS.ROW_TOTAL)
                    .val(total > 0 ? total.toFixed(2) : '');
            }

            // Validation states
            $row.removeClass('error ok table-danger');

            if (qty > 0 && price <= 0) {
                $row.addClass('error');
            } else if (qty > stock && stock > 0) {
                $row.addClass('error table-danger');
            } else if (qty > 0 && price > 0) {
                $row.addClass('ok');
            }
        }


        /* ==========================
         * TOTALS
         * ========================== */
        function calculateTotals() {
            let qtyTotal = 0;
            let rowTotal = 0;
            let totalCost = 0;

            $(CFG.SELECTORS.ROW).each(function () {
                const $row = $(this);

                const qty = safeNumber($row.find(CFG.SELECTORS.QTY).val());
                const sell = safeNumber($row.find(CFG.SELECTORS.PRICE).val());
                const cost = safeNumber($row.find(CFG.SELECTORS.COST).val());

                qtyTotal += qty;
                rowTotal += qty * sell;
                totalCost += qty * cost;
            });

            $(CFG.SELECTORS.FORM.TOTAL_QTY).val(qtyTotal);
            $(CFG.SELECTORS.FORM.TOTAL_AMOUNT)
                .val(rowTotal.toFixed(CFG.DECIMALS))
                .trigger('change');

            return {
                qtyTotal,
                rowTotal,
                totalCost
            };
        }

        function calculateVat() {
            const total = safeNumber($(CFG.SELECTORS.FORM.TOTAL_AMOUNT).val());
            const vatP = safeNumber($(CFG.SELECTORS.FORM.VAT_P).val());

            const vat = (vatP / 100) * total;
            $(CFG.SELECTORS.FORM.VAT_A).val(vat.toFixed(2));
        }

        function calculateGrandTotal() {
            const f = CFG.SELECTORS.FORM;

            const total = safeNumber($(f.TOTAL_AMOUNT).val());
            const vat = safeNumber($(f.VAT_A).val());
            const delivery = safeNumber($(f.DELIVERY).val());
            const discount = safeNumber($(f.DISCOUNT).val());
            const road = safeNumber($(f.ROAD).val());
            const damage = safeNumber($(f.DAMAGE).val());
            const commission = safeNumber($(f.COMMISSION).val());

            const grand =
                (total + vat + delivery) -
                (discount + road + damage + commission);

            $(f.GRAND_TOTAL).val(grand.toFixed(2));
        }

        function calculateAvgSP(qtyTotal, totalAmount) {
            const avg = qtyTotal > 0 ? totalAmount / qtyTotal : 0;
            $(CFG.SELECTORS.FORM.AVG_SP).val(avg.toFixed(4));
        }

        /* ==========================
         * COMPANY SUMMARY
         * ========================== */
        function updateCompanySummary(groupClass) {
            let sku = 0;
            let qty = 0;
            let amount = 0;
            let cost = 0;
            let filled = 0;

            // ONLY product rows (not headers, not sub-headers, not spacers)
            const $rows = $('.' + groupClass + '.item');
            const rows = $rows.length;

            $rows.each(function () {
                const $row = $(this);

                const q = safeNumber($row.find(CFG.SELECTORS.QTY).val());
                const sp = safeNumber($row.find(CFG.SELECTORS.PRICE).val());
                const cp = safeNumber($row.find(CFG.SELECTORS.COST).val());

                if (q > 0) {
                    sku++;
                    filled++;
                    qty += q;
                    amount += q * sp;
                    cost += q * cp;
                }

                updateRow($row);
            });

            const avg = qty > 0 ? amount / qty : 0;
            const margin = amount > 0
                ? ((amount - cost) / amount) * 100
                : 0;

            const progress = rows > 0
                ? (filled / rows) * 100
                : 0;

            const $header = $(
                    `${CFG.SELECTORS.COMPANY_HEADER}[data-target="${groupClass}"]`
            );

            // ===== STATS =====
            $header.find('.sku-count b').text(sku);
            $header.find('.qty-total b').text(qty);
            $header.find('.amount-total b').text('৳ ' + amount.toFixed(2));
            $header.find('.avg-price b').text('৳ ' + avg.toFixed(2));
            $header.find('.cost-total b').text('৳ ' + cost.toFixed(2));

            // ===== PROGRESS BAR =====
            $header.find('.fill-progress')
                .css('width', progress.toFixed(0) + '%');

            // ===== MARGIN BADGE =====
            const $margin = $header.find('.margin-badge');
            $margin
                .text('MARGIN: ' + margin.toFixed(1) + '%')
                .removeClass('bad good')
                .addClass(
                    margin < CFG.MARGIN_WARNING
                        ? 'bad'
                        : 'good'
                );

            // ===== READY STATE =====
            $header.find('.company-bar')
                .toggleClass('ready', filled === rows && rows > 0);

            updateGlobalBar();
        }


        function updateGlobalBar() {
            let gSku = 0;
            let gQty = 0;
            let gTotal = 0;
            let gCost = 0;

            $(CFG.SELECTORS.COMPANY_HEADER).each(function () {
                gSku += safeNumber($(this).find('.sku-count b').text());
                gQty += safeNumber($(this).find('.qty-total b').text());
                gTotal += safeNumber(
                    $(this).find('.amount-total b').text().replace(/[^\d.]/g, '')
                );
                gCost += safeNumber(
                    $(this).find('.cost-total b').text().replace(/[^\d.]/g, '')
                );
            });

            const margin = gTotal > 0
                ? ((gTotal - gCost) / gTotal) * 100
                : 0;

            $(CFG.SELECTORS.GLOBAL.SKU).text(gSku);
            $(CFG.SELECTORS.GLOBAL.QTY).text(gQty);
            $(CFG.SELECTORS.GLOBAL.TOTAL).text('৳ ' + gTotal.toFixed(2));
            $(CFG.SELECTORS.GLOBAL.COST).text('৳ ' + gCost.toFixed(2));
            $(CFG.SELECTORS.GLOBAL.MARGIN)
                .text(margin.toFixed(1) + '%')
                .css('color', margin < 8 ? '#dc3545' : '#28a745');
        }

        /* ==========================
         * EVENTS
         * ========================== */

        // Select input on click
        $(document).on('click', 'input', function () {
            this.select();
        });

        // Sanitize numeric inputs
        $(document).on('input',
            `${CFG.SELECTORS.QTY},
         ${CFG.SELECTORS.PRICE},
         ${CFG.SELECTORS.ROW_TOTAL},
         ${CFG.SELECTORS.FORM.VAT_P},
         ${CFG.SELECTORS.FORM.ROAD},
         ${CFG.SELECTORS.FORM.DAMAGE},
         ${CFG.SELECTORS.FORM.DISCOUNT},
         ${CFG.SELECTORS.FORM.DELIVERY},
         ${CFG.SELECTORS.FORM.COMMISSION}`,
            function () {
                sanitizeDecimalInput(this);
            }
        );

        // Focus glow
        $(document)
            .on('focus', `${CFG.SELECTORS.QTY}, ${CFG.SELECTORS.PRICE}`, function () {
                focusRow($(this).closest('tr'), true);
            })
            .on('blur', `${CFG.SELECTORS.QTY}, ${CFG.SELECTORS.PRICE}`, function () {
                focusRow($(this).closest('tr'), false);
            });

        // Enter → next field
        $(document).on('keydown',
            `${CFG.SELECTORS.QTY}, ${CFG.SELECTORS.PRICE}`,
            function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const $inputs = $(
                            `${CFG.SELECTORS.QTY}:visible,
                            ${CFG.SELECTORS.PRICE}:visible`
                    );
                    const idx = $inputs.index(this);
                    if (idx > -1 && idx < $inputs.length - 1) {
                        $inputs.eq(idx + 1).focus();
                    }
                }
            }
        );

        // Live row + company update
        $(document).on('input',
            `${CFG.SELECTORS.QTY}, ${CFG.SELECTORS.PRICE}`,
            function () {
                const $row = $(this).closest('tr');
                $row.data('lastEdited', 'price_qty');

                const group = $row.attr('class')
                    .split(/\s+/)
                    .find(c => c.startsWith('company-'));

                updateRow($row);
                calculateVat();

                const totals = calculateTotals();
                calculateGrandTotal();
                calculateAvgSP(totals.qtyTotal, totals.rowTotal);

                if (group) {
                    updateCompanySummary(group);
                }
            }
        );

        $(document).on('input',
            `${CFG.SELECTORS.ROW_TOTAL}`,
            function () {
                const $row = $(this).closest('tr');

                $row.data('lastEdited', 'row_total');
                const qty = safeNumber($row.find(CFG.SELECTORS.QTY).val());
                const rowTotal = safeNumber($(this).val());

                if (qty > 0) {
                    const price = rowTotal / qty;
                    $row.find(CFG.SELECTORS.PRICE)
                        .val(price.toFixed(CFG.DECIMALS));
                }

                const group = $row.attr('class')
                    .split(/\s+/)
                    .find(c => c.startsWith('company-'));

                calculateVat();
                const totals = calculateTotals();
                calculateGrandTotal();
                calculateAvgSP(totals.qtyTotal, totals.rowTotal);

                if (group) {
                    updateCompanySummary(group);
                }
            }
        );


        // Live financial-only update (VAT, Road, Damage, Discount, Delivery, Commission)
        $(document).on('input keyup change',
            `${CFG.SELECTORS.FORM.VAT_P},
     ${CFG.SELECTORS.FORM.ROAD},
     ${CFG.SELECTORS.FORM.DAMAGE},
     ${CFG.SELECTORS.FORM.DISCOUNT},
     ${CFG.SELECTORS.FORM.DELIVERY},
     ${CFG.SELECTORS.FORM.COMMISSION}`,
            function () {

                // Only totals — no row logic here
                calculateVat();

                const totals = calculateTotals();
                calculateGrandTotal();
                calculateAvgSP(totals.qtyTotal, totals.rowTotal);
            }
        );

        // Accordion company toggle
        $(document).on('click', CFG.SELECTORS.COMPANY_HEADER, function () {
            const $clicked = $(this);
            const target = $clicked.data('target');
            const $rows = $('.' + target);

            $(CFG.SELECTORS.COMPANY_HEADER)
                .not($clicked)
                .each(function () {
                    const $r = $('.' + $(this).data('target'));
                    if ($r.is(':visible')) {
                        $r.fadeOut(150);
                        $(this).find('.toggle-icon').text('▼');
                    }
                });

            const open = $rows.is(':visible');
            $rows.stop(true, true).fadeToggle(150);
            $clicked.find('.toggle-icon').text(open ? '▼' : '▲');

            if (!open) scrollTo($clicked);
        });

        // Prevent global Enter submit
        $(document).on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
            }
        });

    });
</script>

<?php $this->endWidget(); ?>



<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'soReportDialogBox',
        'options' => array(
                'title' => 'ORDER VOUCHER PREVIEW',
                'autoOpen' => false,
                'modal' => true,
                'width' => 1030,
                'resizable' => false,
        ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>


<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
