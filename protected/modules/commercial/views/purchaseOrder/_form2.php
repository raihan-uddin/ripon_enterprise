<?php
/** @var mixed $model */
/** @var mixed $model2 */
/** @var mixed $model3 */
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Purchase', 'url' => array('admin')),
        array('name' => 'Orders',   'url' => array('admin')),
        array('name' => 'Update: ' . $model->po_no),
    ),
));
$supplier = Suppliers::model()->findByPk($model->supplier_id);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'bom-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions'        => array('validateOnSubmit' => true),
));
Yii::app()->clientScript->registerCoreScript('jquery.ui');
?>

<!-- ── Action bar ──────────────────────────────────────────────────────────── -->
<div class="d-flex align-items-center mb-3 flex-wrap" style="gap:8px;">
    <a class="btn btn-sm btn-outline-secondary" href="<?= Yii::app()->request->requestUri ?>">
        <i class="fa fa-refresh"></i> Reload
    </a>
    <a class="btn btn-sm btn-outline-secondary"
       href="<?= Yii::app()->baseUrl ?>/index.php/commercial/purchaseOrder/admin">
        <i class="fa fa-list"></i> Manage Orders
    </a>
    <span id="po-dirty-indicator" class="badge"
          style="display:none; background:rgba(234,179,8,.18); color:#ca8a04;
                 border:1px solid rgba(234,179,8,.35); font-size:11px; padding:4px 8px;
                 border-radius:6px;">
        <i class="fa fa-circle" style="font-size:7px;"></i> Unsaved changes
    </span>
</div>

<!-- ── 3-column header cards ─────────────────────────────────────────────── -->
<div class="row">

    <!-- Col 1 — Order Details -->
    <div class="col-12 col-md-4 mb-4">
        <div class="card card-primary shadow-sm h-100">
            <div class="card-header">
                <i class="fa fa-file-text-o mr-1"></i> Order Details
            </div>
            <div class="card-body">

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'cash_due'); ?>
                    <div style="pointer-events:none;">
                        <?php echo $form->dropDownList($model, 'cash_due',
                            Lookup::items('cash_due'),
                            array(
                                'class'    => 'form-control',
                                'readonly' => true,
                                'disabled' => true,
                            )
                        ); ?>
                    </div>
                    <?php echo $form->error($model, 'cash_due', array('class' => 'text-danger small')); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'date'); ?>
                    <?php echo $form->textField($model, 'date', array(
                        'class'        => 'form-control',
                        'placeholder'  => 'YYYY-MM-DD',
                        'id'           => 'PurchaseOrder_date',
                        'autocomplete' => 'off',
                    )); ?>
                    <?php echo $form->error($model, 'date', array('class' => 'text-danger small')); ?>
                </div>

                <div class="form-group">
                    <label class="control-label" for="PurchaseOrder_manual_po_no">Manual PO No</label>
                    <?php echo $form->textField($model, 'manual_po_no', array(
                        'class'       => 'form-control',
                        'placeholder' => 'Optional reference number',
                        'maxlength'   => 255,
                    )); ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Col 2 — Supplier -->
    <div class="col-12 col-md-4 mb-4">
        <div class="card card-primary shadow-sm h-100">
            <div class="card-header">
                <i class="fa fa-truck mr-1"></i> Supplier
            </div>
            <div class="card-body">

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'supplier_id'); ?>
                    <div class="input-group">
                        <input type="text" id="supplier_id_text" class="form-control"
                               value="<?= CHtml::encode($supplier->company_name) ?>"
                               placeholder="Search supplier…" autocomplete="off">
                        <?php echo $form->hiddenField($model, 'supplier_id', array('maxlength' => 255)); ?>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="addSupplier(); $('#addSupplierDialog').dialog('open');"
                                    title="Add new supplier">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <?php echo $form->error($model, 'supplier_id', array('class' => 'text-danger small')); ?>

                    <!-- Add Supplier dialog -->
                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'      => 'addSupplierDialog',
                        'options' => array(
                            'title'     => 'Add Supplier',
                            'autoOpen'  => false,
                            'modal'     => true,
                            'width'     => 984,
                            'resizable' => false,
                        ),
                    )); ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display:none;">
                            <img src="<?= Yii::app()->theme->baseUrl ?>/images/ajax-loader.gif">
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>

                    <script>
                    function addSupplier() {
                        <?php echo CHtml::ajax(array(
                            'url'        => array('/commercial/suppliers/createSupplierFromOutSide'),
                            'data'       => 'js:$(this).serialize()',
                            'type'       => 'post',
                            'dataType'   => 'json',
                            'beforeSend' => 'function(){ $(".ajaxLoaderFormLoad").show(); }',
                            'complete'   => 'function(){ $(".ajaxLoaderFormLoad").hide(); }',
                            'success'    => 'function(data){
                                if(data.status=="failure"){
                                    $("#addSupplierDialog div.divForForm").html(data.div);
                                    $("#addSupplierDialog div.divForForm form").submit(addSupplier);
                                } else {
                                    $("#addSupplierDialog div.divForForm").html(data.div);
                                    setTimeout(function(){ $("#addSupplierDialog").dialog("close"); }, 1000);
                                    $("#supplier_id_text").val(data.label);
                                    $("#PurchaseOrder_supplier_id").val(data.id).change();
                                    $("#PurchaseOrder_contact_no").val(data.contact_no);
                                    $("#PurchaseOrder_address").val(data.address);
                                }
                            }',
                        )); ?>
                        return false;
                    }
                    </script>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'contact_no'); ?>
                    <?php echo $form->textField($model, 'contact_no', array(
                        'class'       => 'form-control',
                        'readonly'    => true,
                        'disabled'    => true,
                        'placeholder' => '—',
                        'value'       => $supplier->company_contact_no,
                    )); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'address'); ?>
                    <?php echo $form->textField($model, 'address', array(
                        'class'       => 'form-control',
                        'readonly'    => true,
                        'disabled'    => true,
                        'placeholder' => '—',
                        'value'       => $supplier->company_address,
                    )); ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Col 3 — Financials -->
    <div class="col-12 col-md-4 mb-4">
        <div class="card card-primary shadow-sm h-100">
            <div class="card-header">
                <i class="fa fa-calculator mr-1"></i> Financials
            </div>
            <div class="card-body">

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'total_amount'); ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-money"></i></span>
                        </div>
                        <?php echo $form->textField($model, 'total_amount', array(
                            'class'    => 'form-control',
                            'readonly' => true,
                            'placeholder' => '0.00',
                        )); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">VAT</label>
                    <div class="row no-gutters" style="gap:6px;">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <?php echo $form->textField($model, 'vat_percentage', array(
                                    'class'       => 'form-control',
                                    'placeholder' => '0',
                                    'id'          => 'PurchaseOrder_vat_percentage',
                                )); ?>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-money"></i></span>
                                </div>
                                <?php echo $form->textField($model, 'vat_amount', array(
                                    'class'    => 'form-control',
                                    'readonly' => true,
                                    'placeholder' => '0.00',
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">Discount</label>
                    <div class="row no-gutters" style="gap:6px;">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <?php echo $form->textField($model, 'discount_percentage', array(
                                    'class'       => 'form-control',
                                    'placeholder' => '0',
                                    'id'          => 'PurchaseOrder_discount_percentage',
                                )); ?>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-money"></i></span>
                                </div>
                                <?php echo $form->textField($model, 'discount', array(
                                    'class'    => 'form-control',
                                    'readonly' => true,
                                    'placeholder' => '0.00',
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <?php echo $form->labelEx($model, 'grand_total'); ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"
                                  style="background:#6366f1; border-color:#6366f1; color:#fff;">
                                <i class="fa fa-money"></i>
                            </span>
                        </div>
                        <?php echo $form->textField($model, 'grand_total', array(
                            'class'    => 'form-control font-weight-bold',
                            'readonly' => true,
                            'placeholder' => '0.00',
                            'style'    => 'font-size:15px; color:#6366f1; font-weight:700;',
                        )); ?>
                    </div>
                    <div id="grand-total-words"
                         style="font-size:11px; color:#6b7280; margin-top:4px; font-style:italic;"></div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- ── Items table styles (matches sell order entry) ──────────────────────── -->
<style>
    #po-global-bar {
        background: #212529; color: #fff; padding: 6px 12px; font-size: 12px;
        display: flex; align-items: center; flex-wrap: wrap; border-bottom: 2px solid #17a2b8;
    }
    #po-global-bar .g-stat { margin-left: 12px; }
    #po-global-bar b { font-weight: 600; }

    .po-sub-header th {
        background: #1a2c3d; color: #fff; border-bottom: 3px solid #17a2b8; border-top: none;
        font-size: 12px; font-weight: 700; padding: 8px 10px; white-space: nowrap;
        text-transform: uppercase; letter-spacing: 1px;
    }
    .po-sub-header th:first-child { border-left: 4px solid #17a2b8; }

    .po-items #list td { padding: 4px 6px; font-size: 13px; vertical-align: middle; }
    .po-items .serial { color: #aaa; font-size: 11px; font-weight: 600; letter-spacing: 1px; }
    .po-items .p-name { font-weight: 600; font-size: 13px; }
    .po-items .p-meta { font-size: 11px; }
    .po-items .p-code {
        background: #e8f4fd; color: #1a6fa3; padding: 1px 5px; border-radius: 3px; font-family: monospace;
    }
    .po-items .p-dot  { color: #888; margin: 0 4px; }
    .po-items .p-cat  { color: #444; }

    .po-items .stock-badge {
        font-weight: 600; font-size: 13px; padding: 2px 10px; border-radius: 12px;
        display: inline-block; min-width: 36px;
    }
    .po-items .stock-out { background: #fdecea; color: #c0392b; border: 1px solid #e74c3c; }
    .po-items .stock-low { background: #fff4e0; color: #b7640a; border: 1px solid #f0a500; }
    .po-items .stock-ok  { background: #e6f9ee; color: #1a7a40; border: 1px solid #2ecc71; }

    .po-items #list input.form-control {
        margin: 0 auto; font-weight: 600; font-size: 14px; height: auto;
        border: 2px solid #c8d8e8; border-radius: 6px; padding: 4px 6px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }
    .po-items #list input.form-control:focus {
        border-color: #236280; box-shadow: 0 0 0 .15rem rgba(35, 98, 128, .25); outline: none;
    }
    .po-items #list .temp_qty        { width: 70px; text-align: center; }
    .po-items #list .temp_unit_price { width: 90px; text-align: right; }
    .po-items #list .row-total       { width: 100px; text-align: right; font-weight: 700; background: #f8fafc; }

    .po-items tr.item { transition: background .15s ease; }
    .po-items tr.item.focused { background: #eaf4ff; outline: 1.5px solid #90c8f0; outline-offset: -1px; }
    .po-items tr.item.error   { background: #fff0f0; outline: 1.5px solid #f5a0a0; outline-offset: -1px; }
    .po-items tr.item.ok      { background: #f0faf2; outline: 1.5px solid #6dbb85; outline-offset: -1px; }
</style>

<?php
$baseCompany = $baseCompanyId ? Company::model()->findByPk($baseCompanyId) : null;

// One product row — same markup for ordered items and the rest of the company's products
$renderRow = function ($modelId, $modelName, $code, $itemName, $stock, $qty, $unitPrice, $rowTotal) {
    $stock    = (float)$stock;
    $stockCls = $stock <= 0 ? 'stock-out' : ($stock <= 5 ? 'stock-low' : 'stock-ok');
    ?>
    <tr class="item">
        <td class="serial text-center"></td>
        <td>
            <span class="p-name"><?= CHtml::encode($modelName) ?></span><br>
            <span class="p-meta">
                <span class="p-code"><?= CHtml::encode($code ?: '—') ?></span><span class="p-dot">&bull;</span><span class="p-cat"><?= CHtml::encode($itemName ?: '—') ?></span>
            </span>
            <input type="hidden" class="tmep_model_id"
                   value="<?= $modelId ?>"
                   name="PurchaseOrderDetails[temp_model_id][]">
        </td>
        <td class="text-center"><span class="stock-badge <?= $stockCls ?>"><?= $stock + 0 ?></span></td>
        <td class="text-center">
            <input type="text" class="form-control temp_qty" placeholder="0" inputmode="decimal"
                   value="<?= $qty ?>"
                   name="PurchaseOrderDetails[temp_qty][]">
        </td>
        <td class="text-center">
            <input type="text" class="form-control temp_unit_price" autocomplete="off" inputmode="decimal"
                   value="<?= $unitPrice ?>"
                   name="PurchaseOrderDetails[temp_unit_price][]">
        </td>
        <td class="text-center">
            <input type="text" readonly class="form-control row-total"
                   value="<?= $rowTotal ?>"
                   name="PurchaseOrderDetails[temp_row_total][]">
        </td>
    </tr>
    <?php
};
?>

<!-- ── Items card ──────────────────────────────────────────────────────────── -->
<div class="card card-info shadow-sm mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="fa fa-th-list mr-1"></i> Items</span>
        <span id="item-count-badge"
              style="background:rgba(255,255,255,.2); font-size:11px; padding:2px 10px;
                     border-radius:20px; font-weight:600;">0 items</span>
    </div>
    <div class="card-body">
        <div class="table-responsive po-items">
            <div id="po-global-bar">
                <b>🏭 <?= CHtml::encode($baseCompany ? $baseCompany->name : '—') ?></b>
                <span class="g-stat">SKU <b id="po-g-sku">0</b></span>
                <span class="g-stat">QTY <b id="po-g-qty">0</b></span>
                <span class="g-stat">TOTAL <b id="po-g-total">৳ 0.00</b></span>
            </div>
            <table class="table table-bordered table-sm table-valign-middle mb-0" id="list">
                <thead>
                <tr class="po-sub-header">
                    <th style="width:50px;" class="text-center">#</th>
                    <th>Product</th>
                    <th class="text-center" style="width:90px;">Stock</th>
                    <th class="text-center" style="width:10%;">Qty</th>
                    <th class="text-center" style="width:10%;">Unit Price</th>
                    <th class="text-center" style="width:10%;">Row Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $currentProduct = array();
                foreach ($model3 as $key => $m3) {
                    $currentProduct[] = $m3->model_id;
                    $renderRow($m3->model_id, $m3->model_name, $m3->code, $m3->item_name,
                        $m3->closing_stock, $m3->qty, $m3->unit_price, $m3->row_total);
                }
                if (count($currentProduct) > 0) {
                    $criteraia = new CDbCriteria();
                    $criteraia->addNotInCondition('t.id', $currentProduct);
                    $criteraia->addCondition('manufacturer_id=' . $baseCompanyId);
                    $criteraia->order = "pi.item_name ASC, t.brand_id ASC, t.model_name ASC"; // same order as sell order entry
                    $criteraia->join  = " INNER JOIN prod_items pi ON pi.id = t.item_id ";
                    $criteraia->join .= " INNER JOIN prod_brands pb ON pb.id = t.brand_id ";
                    $criteraia->join .= "  LEFT JOIN (
                        SELECT
                            model_id,
                            SUM(stock_in) - SUM(stock_out) AS closing_stock
                        FROM inventory
                        GROUP BY model_id
                    ) inv ON inv.model_id = t.id ";
                    $criteraia->select = "t.id, t.model_name, t.code, pi.item_name, pb.brand_name, t.purchase_price, t.sell_price, IFNULL(inv.closing_stock, 0) AS closing_stock";

                    $newProducts = ProdModels::model()->findAll($criteraia);
                    foreach ($newProducts as $singleProduct) {
                        $renderRow($singleProduct->id, $singleProduct->model_name, $singleProduct->code,
                            $singleProduct->item_name, $singleProduct->closing_stock,
                            '', $singleProduct->purchase_price, '0.00');
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ── Notes & Save ───────────────────────────────────────────────────────── -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="form-group mb-0">
            <?php echo $form->labelEx($model, 'order_note'); ?>
            <?php echo $form->textArea($model, 'order_note', array(
                'class'       => 'form-control',
                'rows'        => 3,
                'placeholder' => 'Order note / remarks (optional)',
                'id'          => 'PurchaseOrder_order_note',
            )); ?>
        </div>
    </div>
    <div class="card-footer d-flex align-items-center justify-content-between flex-wrap"
         style="gap:8px;">
        <kbd style="background:#f1f5f9; color:#6b7280; font-size:11px; border:1px solid #e2e8f0;">
            Ctrl+Enter
        </kbd> to save
        <div class="d-flex align-items-center" style="gap:8px;">
            <div id="formResultError" class="alert alert-danger d-none mb-0" role="alert" style="font-size:13px;"></div>
            <span id="ajaxLoader" style="display:none; color:#6366f1;">
                <i class="fa fa-spinner fa-spin"></i> Saving…
            </span>
            <?php
            echo CHtml::ajaxSubmitButton(
                'Update Order',
                CHtml::normalizeUrl(array('/commercial/purchaseOrder/update/id/' . $model->id, 'render' => true)),
                array(
                    'dataType' => 'json',
                    'type'     => 'post',
                    'beforeSend' => 'function(){
                        $("#formResultError").addClass("d-none");
                        var count      = $(".item").length;
                        var cashDue    = $("#PurchaseOrder_cash_due").val();
                        var date       = $("#PurchaseOrder_date").val();
                        var supplierId = $("#PurchaseOrder_supplier_id").val();
                        var grandTotal = parseFloat($("#PurchaseOrder_grand_total").val()) || 0;
                        if(!cashDue){
                            toastr.error("Please select Cash / Due.");
                            return false;
                        }
                        if(!date){
                            toastr.error("Please enter a date.");
                            return false;
                        }
                        if(!supplierId){
                            toastr.error("Please select a supplier from the list.");
                            return false;
                        }
                        if(count <= 0){
                            toastr.error("Please add at least one product.");
                            return false;
                        }
                        if(grandTotal <= 0){
                            toastr.error("Grand total must be greater than zero.");
                            return false;
                        }
                        $("#overlay").fadeIn(300);
                        $("#ajaxLoader").show();
                    }',
                    'success' => 'function(data){
                        $("#ajaxLoader").hide();
                        if(data.status === "success"){
                            formDirty = false;
                            $("#po-dirty-indicator").hide();
                            toastr.success("Purchase order updated successfully.");
                            $("#information-modal").modal("show");
                            $("#information-modal .modal-body").html(data.soReportInfo);
                        } else {
                            $("#formResultError").html(data.message).removeClass("d-none");
                            $.each(data, function(key, val){
                                $("#bom-form #" + key + "_em_").html(val).show();
                            });
                            toastr.error("Please fix the errors and try again.");
                        }
                    }',
                    'error' => 'function(xhr){
                        toastr.error("Server error. Please try again.");
                        console.error(xhr.responseText);
                        $("#overlay").fadeOut(300);
                    }',
                    'complete' => 'function(){
                        $("#overlay").fadeOut(300);
                    }',
                ),
                array('class' => 'btn btn-primary', 'id' => 'btn-update-po',
                      'style' => 'background:#6366f1; border-color:#6366f1;')
            );
            ?>
        </div>
    </div>
</div>

<!-- ── Overlay spinner ────────────────────────────────────────────────────── -->
<div id="overlay">
    <div class="cv-spinner"><span class="spinner"></span></div>
</div>

<!-- ── Voucher preview modal ─────────────────────────────────────────────── -->
<div class="modal fade" id="information-modal" tabindex="-1" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header"
                 style="background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff;">
                <h5 class="modal-title"><i class="fa fa-file-text-o mr-1"></i> Purchase Order Voucher</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" style="min-height:200px;">
                <p class="text-muted">Loading…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    <i class="fa fa-times mr-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<!-- ── Scripts ────────────────────────────────────────────────────────────── -->
<script>
/* ── Unsaved-changes guard ─────────────────────────────────────────────────── */
var formDirty = false;
window.addEventListener('beforeunload', function(e){
    if(formDirty){ e.preventDefault(); e.returnValue = ''; }
});
function markDirty(){
    formDirty = true;
    $('#po-dirty-indicator').show();
}

/* ── Amount in words (Bangladeshi style) ──────────────────────────────────── */
function numberToWords(n){
    n = Math.round(n);
    if(n === 0) return 'Zero Taka';
    var units  = ['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine',
                  'Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen',
                  'Seventeen','Eighteen','Nineteen'];
    var tens   = ['','','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];
    function toWords(num){
        if(num < 20)   return units[num];
        if(num < 100)  return tens[Math.floor(num/10)] + (num%10 ? ' '+units[num%10] : '');
        if(num < 1000) return units[Math.floor(num/100)]+' Hundred'+(num%100 ? ' '+toWords(num%100) : '');
        return toWords(num);
    }
    var parts = [];
    var crore = Math.floor(n / 10000000); n %= 10000000;
    var lac   = Math.floor(n / 100000);   n %= 100000;
    var thou  = Math.floor(n / 1000);     n %= 1000;
    if(crore) parts.push(toWords(crore)+' Crore');
    if(lac)   parts.push(toWords(lac)+' Lac');
    if(thou)  parts.push(toWords(thou)+' Thousand');
    if(n)     parts.push(toWords(n));
    return parts.join(' ') + ' Taka';
}

/* ── Calculations ──────────────────────────────────────────────────────────── */
function safeNumber(val){
    val = parseFloat(val);
    return isNaN(val) ? 0 : val;
}
function calculateVat(){
    var total = safeNumber($('#PurchaseOrder_total_amount').val());
    var vatP  = safeNumber($('#PurchaseOrder_vat_percentage').val());
    var discP = safeNumber($('#PurchaseOrder_discount_percentage').val());
    var vat   = (vatP  / 100) * total;
    var disc  = (discP / 100) * total;
    var grand = total + vat - disc;
    grand = grand < 0 ? 0 : grand;
    $('#PurchaseOrder_vat_amount').val(vat.toFixed(2));
    $('#PurchaseOrder_discount').val(disc.toFixed(2));
    $('#PurchaseOrder_grand_total').val(grand.toFixed(2));
    $('#grand-total-words').text(grand > 0 ? numberToWords(grand) : '');
}
function calculateTotal(){
    var total = 0;
    $('.row-total').each(function(){ total += safeNumber($(this).val()); });
    $('#PurchaseOrder_total_amount').val(total.toFixed(2));
    calculateVat();
    updateItemBadge();
    tableSerial();
    updateGlobalBar(total);
}
function updateGlobalBar(total){
    var sku = 0, qty = 0;
    $('#list tbody tr.item').each(function(){
        var q     = safeNumber($(this).find('.temp_qty').val());
        var price = safeNumber($(this).find('.temp_unit_price').val());
        if(q > 0){ sku++; qty += q; }
        $(this).toggleClass('ok', q > 0 && price > 0)
               .toggleClass('error', q > 0 && price <= 0);
    });
    $('#po-g-sku').text(sku);
    $('#po-g-qty').text(qty);
    $('#po-g-total').text('৳ ' + total.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
}
function updateItemBadge(){
    var n = $('.item').length;
    $('#item-count-badge').text(n + (n === 1 ? ' item' : ' items'));
}
function tableSerial(){
    var i = 1;
    $('#list tbody tr.item').each(function(){ $(this).find('.serial').text('#' + i++); });
}

/* ── Row focus highlight ──────────────────────────────────────────────────── */
$(document).on('focus', '#list .temp_qty, #list .temp_unit_price', function(){
    $(this).closest('tr').addClass('focused');
}).on('blur', '#list .temp_qty, #list .temp_unit_price', function(){
    $(this).closest('tr').removeClass('focused');
});

/* ── Supplier autocomplete ─────────────────────────────────────────────────── */
$(document).ready(function(){
    $('#supplier_id_text').autocomplete({
        source: function(request, response){
            $.post('<?= Yii::app()->baseUrl ?>/index.php/commercial/suppliers/jquery_supplierSearch',
                { q: request.term },
                function(data){ response(data); },
                'json'
            );
        },
        minLength: 1,
        delay:     500,
        autoFocus: true,
        select: function(event, ui){
            $('#supplier_id_text').val(ui.item.value);
            $('#PurchaseOrder_supplier_id').val(ui.item.id);
            $('#PurchaseOrder_contact_no').val(ui.item.contact_no);
            $('#PurchaseOrder_address').val(ui.item.address);
            markDirty();
        },
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        return $('<li></li>').data('item.autocomplete', item)
            .append('<a>' + item.value +
                '<small><br>Contact: ' + item.contact_no +
                '<br>Address: ' + item.address + '</small></a>')
            .appendTo(ul);
    };
});

/* ── Qty / price change handlers ─────────────────────────────────────────── */
$(document).on('change keyup', '.temp_qty', function(){
    var qty   = safeNumber($(this).val());
    var price = safeNumber($(this).closest('tr').find('.temp_unit_price').val());
    $(this).closest('tr').find('.row-total').val((qty * price).toFixed(2));
    calculateTotal();
    markDirty();
});
$(document).on('change keyup', '.temp_unit_price', function(){
    var price = safeNumber($(this).val());
    var qty   = safeNumber($(this).closest('tr').find('.temp_qty').val());
    $(this).closest('tr').find('.row-total').val((qty * price).toFixed(2));
    changeUnitPriceForSameModel($(this).closest('tr').find('.tmep_model_id').val(), price);
    calculateTotal();
    markDirty();
});
function changeUnitPriceForSameModel(model_id, price){
    $('.tmep_model_id').each(function(){
        if($(this).val() == model_id){
            var $row = $(this).closest('tr');
            if($row.find('.temp_unit_price').val() != price){
                $row.find('.temp_unit_price').val(price);
                var qty = safeNumber($row.find('.temp_qty').val());
                $row.find('.row-total').val((qty * price).toFixed(2));
            }
        }
    });
}

/* ── VAT / discount % ─────────────────────────────────────────────────────── */
$(document).on('keyup change', '#PurchaseOrder_vat_percentage, #PurchaseOrder_discount_percentage',
    function(){ calculateVat(); markDirty(); });

/* ── Dirty flag on any form field ─────────────────────────────────────────── */
$('#bom-form').on('change keyup', 'input, select, textarea', function(){
    markDirty();
});

/* ── Ctrl+Enter to save ───────────────────────────────────────────────────── */
$(document).on('keydown', function(e){
    if((e.ctrlKey || e.metaKey) && e.key === 'Enter'){
        e.preventDefault();
        formDirty = false;
        $('#btn-update-po').trigger('click');
    }
});

/* ── Block Enter key from submitting ─────────────────────────────────────── */
$(document).on('keypress', function(e){
    if(e.which === 13) return false;
});

/* ── Date picker ─────────────────────────────────────────────────────────── */
var poDatePicker = new Lightpick({
    field: document.getElementById('PurchaseOrder_date'),
    onSelect: function(date){
        document.getElementById('PurchaseOrder_date').value = date.format('YYYY-MM-DD');
        markDirty();
    },
});
var savedDate = '<?php echo CHtml::encode($model->date); ?>';
if(savedDate){ poDatePicker.setStartDate(moment(savedDate)); }

/* ── Init on load ─────────────────────────────────────────────────────────── */
$(function(){
    calculateTotal();
});
</script>
