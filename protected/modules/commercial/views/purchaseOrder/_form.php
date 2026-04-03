<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Purchase', 'url' => array('admin')),
        array('name' => 'Orders',   'url' => array('admin')),
        array('name' => $model->isNewRecord ? 'Create' : 'Update'),
    ),
));
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

<?php echo $form->hiddenField($model, 'order_type', array('value' => PurchaseOrder::PURCHASE)); ?>

<!-- ── Action bar ──────────────────────────────────────────────────────────── -->
<div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
    <a class="btn btn-sm btn-outline-secondary" href="<?= Yii::app()->request->requestUri ?>">
        <i class="fas fa-refresh"></i> Reload
    </a>
    <a class="btn btn-sm btn-outline-secondary"
       href="<?= Yii::app()->baseUrl ?>/index.php/commercial/purchaseOrder/admin">
        <i class="fas fa-list"></i> Manage Orders
    </a>
    <span id="po-dirty-indicator" class="badge"
          style="display:none; background:rgba(234,179,8,.18); color:#ca8a04;
                 border:1px solid rgba(234,179,8,.35); font-size:11px; padding:4px 8px;
                 border-radius:6px;">
        <i class="fas fa-circle" style="font-size:7px;"></i> Unsaved changes
    </span>
</div>

<!-- ── 3-column header cards ─────────────────────────────────────────────── -->
<div class="row">

    <!-- Col 1 — Order Details -->
    <div class="col-12 col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header text-white"
                 style="background:linear-gradient(135deg,#6366f1,#4f46e5); padding:10px 16px;">
                <i class="fas fa-file-lines mr-1"></i> Order Details
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'cash_due'); ?>
                    <?php echo $form->dropDownList($model, 'cash_due',
                        Lookup::items('cash_due'),
                        array(
                            'class'   => 'form-control',
                            'options' => array(Lookup::DUE => array('selected' => 'selected')),
                            'id'      => 'PurchaseOrder_cash_due',
                        )
                    ); ?>
                    <?php echo $form->error($model, 'cash_due', array('class' => 'text-danger small')); ?>
                </div>

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'date'); ?>
                    <?php echo $form->textField($model, 'date', array(
                        'class'       => 'form-control',
                        'placeholder' => 'YYYY-MM-DD',
                        'value'       => date('Y-m-d'),
                        'id'          => 'PurchaseOrder_date',
                        'autocomplete'=> 'off',
                    )); ?>
                    <?php echo $form->error($model, 'date', array('class' => 'text-danger small')); ?>
                </div>

                <div class="mb-3">
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
        <div class="card shadow-sm h-100">
            <div class="card-header text-white"
                 style="background:linear-gradient(135deg,#6366f1,#4f46e5); padding:10px 16px;">
                <i class="fas fa-truck mr-1"></i> Supplier
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'supplier_id'); ?>
                    <div class="input-group">
                        <input type="text" id="supplier_id_text" class="form-control"
                               placeholder="Search supplier…" autocomplete="off">
                        <?php echo $form->hiddenField($model, 'supplier_id', array('maxlength' => 255)); ?>
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="addSupplier(); $('#addSupplierDialog').dialog('open');"
                                    title="Add new supplier">
                                <i class="fas fa-plus"></i>
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

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'contact_no'); ?>
                    <?php echo $form->textField($model, 'contact_no', array(
                        'class'    => 'form-control',
                        'readonly' => true,
                        'disabled' => true,
                        'placeholder' => '—',
                    )); ?>
                </div>

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'address'); ?>
                    <?php echo $form->textField($model, 'address', array(
                        'class'    => 'form-control',
                        'readonly' => true,
                        'disabled' => true,
                        'placeholder' => '—',
                    )); ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Col 3 — Financials -->
    <div class="col-12 col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header text-white"
                 style="background:linear-gradient(135deg,#6366f1,#4f46e5); padding:10px 16px;">
                <i class="fas fa-calculator mr-1"></i> Financials
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <?php echo $form->labelEx($model, 'total_amount'); ?>
                    <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                        </div>
                        <?php echo $form->textField($model, 'total_amount', array(
                            'class'    => 'form-control',
                            'readonly' => true,
                            'value'    => '0.00',
                            'placeholder' => '0.00',
                        )); ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="control-label">VAT</label>
                    <div class="row no-gutters" style="gap:6px;">
                        <div class="col">
                            <div class="input-group">
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
                                    <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                </div>
                                <?php echo $form->textField($model, 'vat_amount', array(
                                    'class'    => 'form-control',
                                    'readonly' => true,
                                    'value'    => '0.00',
                                    'placeholder' => '0.00',
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="control-label">Discount</label>
                    <div class="row no-gutters" style="gap:6px;">
                        <div class="col">
                            <div class="input-group">
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
                                    <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                </div>
                                <?php echo $form->textField($model, 'discount', array(
                                    'class'    => 'form-control',
                                    'readonly' => true,
                                    'value'    => '0.00',
                                    'placeholder' => '0.00',
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 mb-0">
                    <?php echo $form->labelEx($model, 'grand_total'); ?>
                    <div class="input-group">
                        
                            <span class="input-group-text"
                                  style="background:#6366f1; border-color:#6366f1; color:#fff;">
                                <i class="fas fa-money-bill"></i>
                            </span>
                        </div>
                        <?php echo $form->textField($model, 'grand_total', array(
                            'class'    => 'form-control font-weight-bold',
                            'readonly' => true,
                            'value'    => '0.00',
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

<!-- ── Items card ──────────────────────────────────────────────────────────── -->
<div class="card shadow-sm mb-4">
    <div class="card-header d-flex align-items-center justify-content-between"
         style="background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; padding:10px 16px;">
        <span><i class="fas fa-th-list mr-1"></i> Items</span>
        <span id="item-count-badge"
              style="background:rgba(255,255,255,.2); font-size:11px; padding:2px 10px;
                     border-radius:20px; font-weight:600;">0 items</span>
    </div>
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-12 col-md-5">
                <div class="mb-3 mb-0">
                    <?php echo $form->labelEx($model, 'manufacturer_id'); ?>
                    <?php echo $form->dropDownList($model, 'manufacturer_id',
                        CHtml::listData(Company::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
                        array(
                            'prompt' => '— Select Manufacturer —',
                            'class'  => 'form-control',
                        )
                    ); ?>
                </div>
            </div>
            <div class="col-12 col-md-7 d-flex align-items-end">
                <div id="manufacturer-loading" style="display:none; color:#6366f1; font-size:13px;">
                    <i class="fas fa-spinner fa-spin"></i> Loading products…
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-sm table-hover mb-0" id="list"
                   style="font-size:13px;">
                <thead style="background:#f1f5f9; color:#374151;">
                <tr>
                    <th style="width:40px;" class="text-center">#</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Code</th>
                    <th class="text-center" style="width:80px;">Stock</th>
                    <th class="text-center" style="width:100px;">Qty</th>
                    <th class="text-center" style="width:120px;">Unit Price</th>
                    <th class="text-center" style="width:120px;">Row Total</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr id="table-empty-row">
                    <td colspan="8" class="text-center py-4" style="color:#9ca3af;">
                        <i class="fas fa-arrow-up mr-1"></i>
                        Select a manufacturer above to load products
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>

<!-- ── Notes & Save ───────────────────────────────────────────────────────── -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="mb-3 mb-0">
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
            <span id="ajaxLoader" style="display:none; color:#6366f1;">
                <i class="fas fa-spinner fa-spin"></i> Saving…
            </span>
            <?php
            echo CHtml::ajaxSubmitButton(
                'Save Order',
                CHtml::normalizeUrl(array('/commercial/purchaseOrder/create', 'render' => true)),
                array(
                    'dataType' => 'json',
                    'type'     => 'post',
                    'beforeSend' => 'function(){
                        var count  = $(".item").length;
                        var cashDue   = $("#PurchaseOrder_cash_due").val();
                        var date      = $("#PurchaseOrder_date").val();
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
                            clearDraft();
                            formDirty = false;
                            toastr.success("Purchase order saved successfully.");
                            $("#bom-form")[0].reset();
                            $("#list tbody").empty();
                            $("#table-empty-row").show();
                            updateItemBadge();
                            calculateTotal();
                            bootstrap.Modal.getOrCreateInstance(document.getElementById("information-modal")).show();
                            $("#information-modal .modal-body").html(data.soReportInfo);
                        } else {
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
                array('class' => 'btn btn-primary', 'id' => 'btn-save-po',
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
<div class="modal fade" id="information-modal" tabindex="-1" data-bs-backdrop="static" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header"
                 style="background:linear-gradient(135deg,#6366f1,#4f46e5); color:#fff;">
                <h5 class="modal-title"><i class="fas fa-file-lines mr-1"></i> Purchase Order Voucher</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" style="min-height:200px;">
                <p class="text-muted">Loading…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Close
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

/* ── Draft autosave ────────────────────────────────────────────────────────── */
var PO_DRAFT_KEY = 'po_draft_create';
function saveDraft(){
    var rows = {};
    $('#list tbody tr.item').each(function(){
        var mid = $(this).find('input[name="PurchaseOrderDetails[temp_model_id][]"]').val();
        if(mid) rows[mid] = {
            qty:   $(this).find('.temp_qty').val(),
            price: $(this).find('.temp_unit_price').val(),
        };
    });
    var d = {
        date:                $('#PurchaseOrder_date').val(),
        cash_due:            $('#PurchaseOrder_cash_due').val(),
        supplier_id:         $('#PurchaseOrder_supplier_id').val(),
        supplier_text:       $('#supplier_id_text').val(),
        contact_no:          $('#PurchaseOrder_contact_no').val(),
        address:             $('#PurchaseOrder_address').val(),
        vat_percentage:      $('#PurchaseOrder_vat_percentage').val(),
        discount_percentage: $('#PurchaseOrder_discount_percentage').val(),
        manual_po_no:        $('#PurchaseOrder_manual_po_no').val(),
        order_note:          $('#PurchaseOrder_order_note').val(),
        manufacturer_id:     $('#PurchaseOrder_manufacturer_id').val(),
        rows:                rows,
        saved_at:            new Date().toISOString(),
    };
    localStorage.setItem(PO_DRAFT_KEY, JSON.stringify(d));
}
function clearDraft(){
    localStorage.removeItem(PO_DRAFT_KEY);
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
}
function updateItemBadge(){
    var n = $('.item').length;
    $('#item-count-badge').text(n + (n === 1 ? ' item' : ' items'));
    $('#table-empty-row').toggle(n === 0);
}
function tableSerial(){
    var i = 1;
    $('#list tbody tr.item').each(function(){ $(this).find('.serial').text(i++); });
}

/* ── Row builder ───────────────────────────────────────────────────────────── */
function buildRow(data){
    var mid        = data.id;
    var modelName  = data.name;
    var itemName   = data.item_name;
    var code       = data.code;
    var pp         = safeNumber(data.purchasePrice);
    var stock      = safeNumber(data.current_stock);

    $('#table-empty-row').hide();
    $('#list tbody').append(
        '<tr class="item">' +
        '<td class="serial text-center"></td>' +
        '<td>' + (itemName || '—') + '</td>' +
        '<td>' + modelName +
            '<input type="hidden" value="' + mid +
            '" name="PurchaseOrderDetails[temp_model_id][]">' +
        '</td>' +
        '<td>' + (code || '—') + '</td>' +
        '<td class="text-center">' + stock + '</td>' +
        '<td class="text-center">' +
            '<input type="text" class="form-control form-control-sm text-center temp_qty"' +
            ' value="" name="PurchaseOrderDetails[temp_qty][]" style="width:70px;margin:auto;">' +
        '</td>' +
        '<td class="text-center">' +
            '<input type="text" class="form-control form-control-sm temp_unit_price"' +
            ' value="' + pp + '" name="PurchaseOrderDetails[temp_unit_price][]"' +
            ' style="width:90px;margin:auto;">' +
        '</td>' +
        '<td class="text-center">' +
            '<input type="text" readonly class="form-control form-control-sm row-total"' +
            ' value="0.00" name="PurchaseOrderDetails[temp_row_total][]"' +
            ' style="width:90px;margin:auto;background:#f8fafc;">' +
        '</td>' +
        '</tr>'
    );
    calculateTotal();
    markDirty();
}

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

/* ── Manufacturer change — load products ─────────────────────────────────── */
(function(){
    var xhr = null;
    $(function(){
        $('#PurchaseOrder_manufacturer_id').on('change', function(){
            var cid = $(this).val();
            if(!cid) return;

            if($('#list tbody .item').length > 0){
                if(!confirm('Changing manufacturer will remove all existing items. Continue?')){
                    $(this).val($(this).data('prev'));
                    return;
                }
                $('#list tbody').empty();
                updateItemBadge();
            }
            $(this).data('prev', cid);

            if(xhr) xhr.abort();
            var $ddl = $(this);
            $ddl.prop('disabled', true);
            $('#manufacturer-loading').show();

            xhr = $.ajax({
                url:      '<?= Yii::app()->createUrl("prodModels/Jquery_getCompanyProducts") ?>',
                type:     'GET',
                dataType: 'json',
                data:     { company_id: cid },
                success:  function(res){
                    $.each(res, function(i, row){ buildRow(row); });
                },
                error: function(x, s){
                    if(s !== 'abort') toastr.error('Failed to load products.');
                },
                complete: function(){
                    $ddl.prop('disabled', false);
                    $('#manufacturer-loading').hide();
                },
            });
        });
    });
})();

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
    calculateTotal();
    markDirty();
});

/* ── VAT / discount % ─────────────────────────────────────────────────────── */
$(document).on('keyup change', '#PurchaseOrder_vat_percentage, #PurchaseOrder_discount_percentage',
    function(){ calculateVat(); markDirty(); });

/* ── Dirty flag on any form field ─────────────────────────────────────────── */
var _draftTimer = null;
$('#bom-form').on('change keyup', 'input, select, textarea', function(){
    markDirty();
    clearTimeout(_draftTimer);
    _draftTimer = setTimeout(saveDraft, 600);
});

/* ── Ctrl+Enter to save ───────────────────────────────────────────────────── */
$(document).on('keydown', function(e){
    if((e.ctrlKey || e.metaKey) && e.key === 'Enter'){
        e.preventDefault();
        formDirty = false;
        $('#btn-save-po').trigger('click');
    }
});

/* ── Block Enter key from submitting ─────────────────────────────────────── */
$(document).on('keypress', function(e){
    if(e.which === 13) return false;
});

/* ── Date picker ─────────────────────────────────────────────────────────── */
new Lightpick({
    field: document.getElementById("PurchaseOrder_date"),
    onSelect: function(date){
        document.getElementById("PurchaseOrder_date").value = date.format('YYYY-MM-DD');
        markDirty();
    },
});

/* ── Restore draft on load ───────────────────────────────────────────────── */
$(function(){
    updateItemBadge();

    try {
        var raw = localStorage.getItem(PO_DRAFT_KEY);
        if(!raw) return;
        var d = JSON.parse(raw);
        if(!d.saved_at) return;

        var msg = 'A draft from ' + new Date(d.saved_at).toLocaleString() + ' was found.';
        toastr.info(
            msg + '<br><button id="discard-po-draft" class="btn btn-xs btn-danger mt-1">Discard</button>',
            'Restore Draft?',
            { timeOut: 0, extendedTimeOut: 0, closeButton: true, allowHtml: true }
        );

        // Restore fields
        if(d.date)                $('#PurchaseOrder_date').val(d.date);
        if(d.cash_due)            $('#PurchaseOrder_cash_due').val(d.cash_due);
        if(d.supplier_text)       $('#supplier_id_text').val(d.supplier_text);
        if(d.supplier_id)         $('#PurchaseOrder_supplier_id').val(d.supplier_id);
        if(d.contact_no)          $('#PurchaseOrder_contact_no').val(d.contact_no);
        if(d.address)             $('#PurchaseOrder_address').val(d.address);
        if(d.vat_percentage)      $('#PurchaseOrder_vat_percentage').val(d.vat_percentage);
        if(d.discount_percentage) $('#PurchaseOrder_discount_percentage').val(d.discount_percentage);
        if(d.manual_po_no)        $('#PurchaseOrder_manual_po_no').val(d.manual_po_no);
        if(d.order_note)          $('#PurchaseOrder_order_note').val(d.order_note);

        // Restore manufacturer + rows
        if(d.manufacturer_id && d.rows && Object.keys(d.rows).length > 0){
            $('#PurchaseOrder_manufacturer_id').val(d.manufacturer_id).trigger('change');
            // After products load, apply saved qty/price
            var restoreTimer = setInterval(function(){
                if($('.item').length > 0){
                    clearInterval(restoreTimer);
                    $('#list tbody tr.item').each(function(){
                        var mid = $(this).find('input[name="PurchaseOrderDetails[temp_model_id][]"]').val();
                        if(d.rows[mid]){
                            $(this).find('.temp_qty').val(d.rows[mid].qty);
                            $(this).find('.temp_unit_price').val(d.rows[mid].price);
                        }
                    });
                    calculateTotal();
                }
            }, 300);
        }

        $(document).on('click', '#discard-po-draft', function(){
            clearDraft();
            location.reload();
        });

    } catch(e){ clearDraft(); }
});
</script>
