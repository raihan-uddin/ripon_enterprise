<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                     => 'prod-items-form',
    'action'                 => $this->createUrl('inventory/create'),
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true),
));
?>
<script>
    let prev_product_id = 0;
    let prev_sell_price = 0;
</script>
<style>
/* ══════════════════════════════════════════
   Inventory Form — prodModels indigo palette
══════════════════════════════════════════ */

/* ── Outer card ── */
.inv-card{border:none;border-radius:16px;overflow:hidden;
    box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);}

/* ── Header ── */
.inv-card>.card-header{
    background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);
    border:none;padding:20px 28px;position:relative;overflow:hidden;}
.inv-card>.card-header::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background-image:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);
    background-size:22px 22px;}
.inv-card>.card-header::after{
    content:'';position:absolute;top:-50px;right:-50px;
    width:160px;height:160px;border-radius:50%;
    background:rgba(255,255,255,.07);pointer-events:none;}
.inv-hd-top{display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;}
.inv-hd-title{font-size:17px;font-weight:800;color:#fff;letter-spacing:-.2px;
    display:flex;align-items:center;gap:9px;}
.inv-hd-icon{width:34px;height:34px;border-radius:9px;
    background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;
    font-size:15px;color:#fff;flex-shrink:0;}
.inv-hd-sub{font-size:12px;color:rgba(255,255,255,.65);margin-top:3px;font-weight:400;}
.inv-hd-chips{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px;position:relative;z-index:1;}
.inv-chip{display:inline-flex;align-items:center;gap:5px;
    padding:4px 10px;border-radius:99px;font-size:11px;font-weight:600;
    background:rgba(255,255,255,.15);color:rgba(255,255,255,.85);
    border:1px solid rgba(255,255,255,.2);}
.inv-chip i{font-size:10px;}
.card-tools .btn-tool{color:rgba(255,255,255,.6);transition:color .15s;}
.card-tools .btn-tool:hover{color:#fff;}

/* ── Card body — sections ── */
.inv-card>.card-body{padding:0;background:#fff;}
.inv-section{padding:22px 28px;border-bottom:1px solid #f1f5f9;transition:background .2s;}
.inv-section:last-child{border-bottom:none;}
.inv-section:hover{background:#fafbff;}

/* ── Section header ── */
.inv-sec-hd{display:flex;align-items:center;gap:12px;margin-bottom:18px;}
.inv-step-badge{
    width:28px;height:28px;border-radius:50%;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    background:#eef2ff;color:#6366f1;font-size:12px;font-weight:800;
    border:2px solid #c7d2fe;transition:all .3s cubic-bezier(.34,1.56,.64,1);}
.inv-sec-title{font-size:13.5px;font-weight:700;color:#1e293b;line-height:1.2;}
.inv-sec-sub{font-size:11px;color:#94a3b8;margin-top:1px;}

/* ── Section body box ── */
.inv-sec-body{background:#f8faff;border:1px solid #eef2ff;border-radius:12px;padding:18px 16px;}

/* ── Field label ── */
.inv-label{
    display:block;font-size:11px;font-weight:700;color:#475569;
    margin-bottom:5px;text-transform:uppercase;letter-spacing:.4px;transition:color .15s;}
.inv-field{margin-bottom:0;}
.inv-field:focus-within .inv-label{color:#6366f1;}

/* ── Styled input ── */
.inv-input{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:9px 12px;font-size:13px;color:#1e293b;background:#fff;
    outline:none;transition:border-color .18s,box-shadow .18s,transform .15s;
    -webkit-appearance:none;}
.inv-input:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12);transform:translateY(-1px);}
.inv-input:hover:not(:focus){border-color:#94a3b8;}
.inv-input[readonly]{background:#f8fafc;color:#64748b;transform:none!important;}

/* ── Styled select ── */
.inv-select{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:9px 30px 9px 12px;font-size:13px;color:#1e293b;background:#fff;
    outline:none;-webkit-appearance:none;cursor:pointer;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2394a3b8'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 10px center;
    transition:border-color .18s,box-shadow .18s,transform .15s;}
.inv-select:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12);transform:translateY(-1px);}
.inv-select:hover:not(:focus){border-color:#94a3b8;}

/* ── Transaction type pills ── */
.inv-type-pills{display:flex;gap:8px;}
.inv-type-pill{
    flex:1;display:flex;align-items:center;justify-content:center;gap:6px;
    padding:9px 12px;border-radius:8px;font-size:12px;font-weight:700;
    border:1.5px solid #e2e8f0;background:#fff;color:#64748b;
    cursor:pointer;transition:all .15s;user-select:none;}
.inv-type-pill:hover{border-color:#6366f1;color:#6366f1;background:#f8faff;}
.inv-type-pill.active-in{border-color:#22c55e;background:#f0fdf4;color:#16a34a;}
.inv-type-pill.active-out{border-color:#ef4444;background:#fef2f2;color:#dc2626;}
.inv-type-pill i{font-size:13px;}

/* ── Styled textarea ── */
.inv-textarea{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:9px 12px;font-size:13px;color:#1e293b;background:#fff;
    outline:none;resize:vertical;min-height:68px;
    transition:border-color .18s,box-shadow .18s;}
.inv-textarea:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12);}
.inv-textarea:hover:not(:focus){border-color:#94a3b8;}

/* ── Error ── */
.inv-error{font-size:11px;color:#ef4444;margin-top:4px;display:block;}

/* ── Input + unit suffix ── */
.inv-igroup{display:flex;}
.inv-igroup .inv-input{border-radius:8px 0 0 8px;flex:1;}
.inv-unit-suffix{
    display:inline-flex;align-items:center;justify-content:center;
    padding:0 10px;border:1.5px solid #e2e8f0;border-left:none;
    border-radius:0 8px 8px 0;background:#eef2ff;
    font-size:12px;font-weight:700;color:#6366f1;white-space:nowrap;min-width:32px;}

/* ── Add to list button ── */
.inv-add-btn{
    position:relative;overflow:hidden;
    display:inline-flex;align-items:center;gap:6px;
    padding:9px 18px;border-radius:8px;font-size:13px;font-weight:700;
    background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;
    cursor:pointer;box-shadow:0 3px 10px rgba(99,102,241,.35);
    transition:box-shadow .18s,transform .15s;white-space:nowrap;}
.inv-add-btn:hover{box-shadow:0 5px 16px rgba(99,102,241,.45);transform:translateY(-1px);}
.inv-add-btn:active{transform:translateY(0);}

/* ── Product table ── */
.inv-table-wrap{margin-top:16px;border-radius:10px;overflow:hidden;border:1px solid #eef2ff;}
.inv-table{width:100%;border-collapse:collapse;font-size:13px;}
.inv-table thead th{
    background:linear-gradient(135deg,#4f46e5,#7c3aed);
    color:#fff;font-size:11px;font-weight:700;
    text-transform:uppercase;letter-spacing:.5px;
    padding:10px 14px;white-space:nowrap;text-align:center;}
.inv-table thead th:first-child{text-align:left;}
.inv-table tbody tr{border-bottom:1px solid #f1f5f9;transition:background .15s;}
.inv-table tbody tr:last-child{border-bottom:none;}
.inv-table tbody tr:hover{background:#f8faff;}
.inv-table tbody td{padding:8px 12px;vertical-align:middle;text-align:center;}
.inv-table tbody td:first-child{text-align:left;font-weight:500;color:#1e293b;}
.inv-table .inv-input{font-size:12px;padding:5px 8px;transform:none!important;}
.inv-table-empty{padding:24px;text-align:center;color:#94a3b8;font-size:13px;font-style:italic;}

/* ── Delete button ── */
.inv-dlt-btn{
    display:inline-flex;align-items:center;justify-content:center;
    width:30px;height:30px;border-radius:6px;border:none;cursor:pointer;
    background:#fdecea;color:#b71c1c;font-size:13px;
    transition:background .15s,transform .1s;}
.inv-dlt-btn:hover{background:#fad4d0;transform:scale(1.1);}

/* ── Footer ── */
.inv-card>.card-footer{
    background:#f8fafc;border-top:1px solid #f1f5f9;
    padding:16px 28px;display:flex;align-items:center;gap:10px;}
.inv-req-note{margin-left:auto;font-size:11.5px;color:#94a3b8;}
.inv-req-note span{color:#ef4444;font-weight:700;}

/* ── Submit button ── */
.inv-submit{
    position:relative;overflow:hidden;
    display:inline-flex;align-items:center;gap:8px;
    padding:11px 28px;border-radius:9px;font-size:14px;font-weight:700;
    background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;
    cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);
    transition:box-shadow .18s,transform .15s;}
.inv-submit:hover{box-shadow:0 6px 20px rgba(99,102,241,.5);transform:translateY(-2px);}
.inv-submit:active{transform:translateY(0);}
.inv-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.38);
    transform:scale(0);animation:invRipple .6s linear;pointer-events:none;}
@keyframes invRipple{to{transform:scale(4);opacity:0;}}

/* ── Full-page overlay ── */
#overlay{display:none;position:fixed;inset:0;
    background:rgba(255,255,255,.65);z-index:9999;
    align-items:center;justify-content:center;}
.cv-spinner{display:flex;align-items:center;justify-content:center;}
.spinner{width:48px;height:48px;border-radius:50%;
    border:5px solid #eef2ff;border-top-color:#6366f1;
    animation:invSpin .8s linear infinite;}
@keyframes invSpin{to{transform:rotate(360deg);}}

/* ── Autocomplete dropdown ── */
.ui-autocomplete{
    border:1px solid #e2e8f0!important;border-radius:10px!important;
    box-shadow:0 8px 24px rgba(0,0,0,.12)!important;
    padding:4px 0!important;max-height:260px;overflow-y:auto;}
.ui-autocomplete .ui-menu-item a,
.ui-autocomplete .ui-menu-item-wrapper{
    padding:6px 12px!important;font-size:13px!important;
    border-radius:6px;margin:2px 4px;display:block;}
.ui-autocomplete .ui-menu-item a:hover,
.ui-autocomplete .ui-state-focus{
    background:#eef2ff!important;color:#4f46e5!important;}
</style>

<div class="card inv-card">

    <!-- ═══ Header ═══ -->
    <div class="card-header">
        <div class="inv-hd-top">
            <div class="inv-hd-title">
                <div class="inv-hd-icon"><i class="fa fa-cubes"></i></div>
                <div>
                    <?= $model->isNewRecord ? 'Add Stock Entry' : 'Update Stock Entry' ?>
                    <div class="inv-hd-sub">Record product stock movement — in or out</div>
                </div>
            </div>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="inv-hd-chips">
            <span class="inv-chip"><i class="fa fa-calendar"></i> Date &amp; Type</span>
            <span class="inv-chip"><i class="fa fa-th-list"></i> Product Lines</span>
        </div>
    </div>

    <div class="card-body">

        <!-- ═══ Section 1 — Entry Info ═══ -->
        <div class="inv-section">
            <div class="inv-sec-hd">
                <div class="inv-step-badge">1</div>
                <div>
                    <div class="inv-sec-title">Entry Information</div>
                    <div class="inv-sec-sub">Date, transaction type, and optional remarks</div>
                </div>
            </div>
            <div class="inv-sec-body">
                <div class="row" style="align-items:flex-start; gap-y:14px;">

                    <!-- Date -->
                    <div class="col-sm-6 col-md-3" style="margin-bottom:14px;">
                        <div class="inv-field">
                            <label class="inv-label"><i class="fa fa-calendar" style="color:#6366f1;margin-right:3px;"></i> Date <span style="color:#ef4444;">*</span></label>
                            <div id="entry_date" data-target-input="nearest">
                                <?= $form->textField($model, 'date', array(
                                    'class'       => 'inv-input datetimepicker-input',
                                    'placeholder' => 'YYYY-MM-DD',
                                    'value'       => date('Y-m-d'),
                                )) ?>
                            </div>
                            <?= $form->error($model, 'date', array('class' => 'inv-error')) ?>
                        </div>
                    </div>

                    <!-- Transaction type — pill toggle -->
                    <div class="col-sm-6 col-md-3" style="margin-bottom:14px;">
                        <div class="inv-field">
                            <label class="inv-label"><i class="fa fa-exchange" style="color:#6366f1;margin-right:3px;"></i> Transaction Type <span style="color:#ef4444;">*</span></label>
                            <div class="inv-type-pills">
                                <div class="inv-type-pill active-in" id="pill-in" onclick="setType(<?= Inventory::STOCK_IN ?>)">
                                    <i class="fa fa-arrow-circle-down"></i> Stock In
                                </div>
                                <div class="inv-type-pill" id="pill-out" onclick="setType(<?= Inventory::STOCK_OUT ?>)">
                                    <i class="fa fa-arrow-circle-up"></i> Stock Out
                                </div>
                            </div>
                            <?= $form->dropDownList($model, 't_type',
                                [Inventory::STOCK_IN => 'STOCK IN', Inventory::STOCK_OUT => 'STOCK OUT'],
                                array('class' => 'inv-select', 'style' => 'display:none;')
                            ) ?>
                            <?= $form->error($model, 't_type', array('class' => 'inv-error')) ?>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="col-sm-12 col-md-6" style="margin-bottom:14px;">
                        <div class="inv-field">
                            <label class="inv-label"><i class="fa fa-comment-o" style="color:#6366f1;margin-right:3px;"></i> Remarks</label>
                            <?= $form->textArea($model, 'remarks', array('class' => 'inv-textarea', 'placeholder' => 'Optional note about this entry…')) ?>
                            <?= $form->error($model, 'remarks', array('class' => 'inv-error')) ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ═══ Section 2 — Product Lines ═══ -->
        <div class="inv-section">
            <div class="inv-sec-hd">
                <div class="inv-step-badge">2</div>
                <div>
                    <div class="inv-sec-title">Product Lines</div>
                    <div class="inv-sec-sub">Search a product, set quantity, then add to the list</div>
                </div>
            </div>
            <div class="inv-sec-body">

                <!-- Input row -->
                <div class="row" style="align-items:flex-end;">

                    <!-- Product autocomplete -->
                    <div class="col-sm-6 col-md-3 col-lg-3" style="margin-bottom:14px;">
                        <div class="inv-field">
                            <label class="inv-label"><i class="fa fa-search" style="color:#6366f1;margin-right:3px;"></i> Product <span style="color:#ef4444;">*</span></label>
                            <input type="text" id="model_id_text" class="inv-input" placeholder="Type to search…" autocomplete="off">
                            <?= $form->hiddenField($model, 'model_id',   array('maxlength' => 255)) ?>
                            <?= $form->hiddenField($model, 'sell_price', array('maxlength' => 255)) ?>
                            <div style="display:none;">
                                <?= $form->dropDownList($model, 'unit_id',
                                    CHtml::listData(Units::model()->findAll(array('order' => 'label ASC')), 'id', 'label'),
                                    array('prompt' => 'Select', 'class' => 'inv-select')
                                ) ?>
                            </div>
                            <?= $form->error($model, 'model_id', array('class' => 'inv-error')) ?>
                        </div>
                    </div>


                    <!-- Stock In -->
                    <div class="col-sm-6 col-md-2 col-lg-2 stock-in" style="margin-bottom:14px;">
                        <div class="inv-field">
                            <label class="inv-label"><i class="fa fa-arrow-circle-down" style="color:#22c55e;margin-right:3px;"></i> Qty In <span style="color:#ef4444;">*</span></label>
                            <div class="inv-igroup">
                                <?= $form->textField($model, 'stock_in', array(
                                    'maxlength' => 255,
                                    'class'     => 'inv-input',
                                    'value'     => 1,
                                    'style'     => 'border-radius:8px 0 0 8px;',
                                )) ?>
                                <span class="inv-unit-suffix product_unit_text" id="product_unit_text"></span>
                            </div>
                            <?= $form->error($model, 'stock_in', array('class' => 'inv-error')) ?>
                        </div>
                    </div>

                    <!-- Stock Out (hidden by default) -->
                    <div class="col-sm-6 col-md-2 col-lg-2 stock-out" style="display:none;margin-bottom:14px;">
                        <div class="inv-field">
                            <label class="inv-label"><i class="fa fa-arrow-circle-up" style="color:#ef4444;margin-right:3px;"></i> Qty Out <span style="color:#ef4444;">*</span></label>
                            <div class="inv-igroup">
                                <?= $form->textField($model, 'stock_out', array(
                                    'maxlength' => 255,
                                    'class'     => 'inv-input',
                                    'style'     => 'border-radius:8px 0 0 8px;',
                                )) ?>
                                <span class="inv-unit-suffix product_unit_text" id="product_unit_text2"></span>
                            </div>
                            <?= $form->error($model, 'stock_out', array('class' => 'inv-error')) ?>
                        </div>
                    </div>

                    <!-- Closing Stock (hidden, readonly) -->
                    <div class="col-sm-6 col-md-2 col-lg-2 stock-out" style="display:none;margin-bottom:14px;">
                        <div class="inv-field">
                            <label class="inv-label"><i class="fa fa-archive" style="color:#94a3b8;margin-right:3px;"></i> Current Stock</label>
                            <div class="inv-igroup">
                                <?= $form->textField($model, 'closing_stock', array(
                                    'maxlength' => 255,
                                    'class'     => 'inv-input',
                                    'readonly'  => true,
                                    'style'     => 'border-radius:8px 0 0 8px;',
                                )) ?>
                                <span class="inv-unit-suffix product_unit_text" id="product_unit_text3"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Add button -->
                    <div class="col-sm-12 col-md-1 col-lg-1" style="margin-bottom:14px;">
                        <button class="inv-add-btn" onclick="addToList()" type="button">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </div>

                </div><!-- /input row -->

                <!-- Product list table -->
                <div class="inv-table-wrap">
                    <table class="inv-table" id="list">
                        <thead>
                            <tr>
                                <th style="text-align:left;">Product Name</th>
                                <th style="width:18%;">Stock In</th>
                                <th style="width:18%;">Stock Out</th>
                                <th style="width:8%;">Del</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="inv-empty-row">
                                <td colspan="5" class="inv-table-empty">
                                    <i class="fa fa-inbox" style="font-size:20px;display:block;margin-bottom:6px;color:#c7d2fe;"></i>
                                    No products added yet — search and add above
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div><!-- /inv-sec-body -->
        </div><!-- /section 2 -->

    </div><!-- /card-body -->

    <!-- ═══ Footer ═══ -->
    <div class="card-footer">
        <?= CHtml::ajaxSubmitButton(
            '<i class="fa fa-save"></i> Save Entry',
            CHtml::normalizeUrl(array('inventory/create', 'render' => true)),
            array(
                'dataType'   => 'text',
                'type'       => 'post',
                'beforeSend' => 'function(){
                    if($(".item").length <= 0){
                        toastr.error("Please add at least one product to the list.");
                        return false;
                    }
                    $("#overlay").fadeIn(300);
                    $("#ajaxLoader").show();
                }',
                'success' => 'function(raw){
                    $("#ajaxLoader").hide();
                    var data = {};
                    try {
                        var match = raw.match(/\{[\s\S]*\}/);
                        if(match){ data = JSON.parse(match[0]); }
                    } catch(e){}
                    if(data.status=="success"){
                        toastr.success("Stock entry saved successfully.");
                        $("#prod-items-form")[0].reset();
                        $("#inv-empty-row").show();
                        $("#list tbody .item").remove();
                        $.fn.yiiGridView.update("inventory-grid",{data:$(this).serialize()});
                    } else {
                        var hasError = false;
                        $.each(data,function(key,val){
                            var $el = $("#prod-items-form #"+key+"_em_");
                            if($el.length){ $el.html(""+val+"").show(); hasError = true; }
                        });
                        if(!hasError){ toastr.error("Please fix the errors and try again."); }
                    }
                }',
                'error'    => 'function(){ $("#overlay").fadeOut(300); toastr.error("Server error. Please try again."); }',
                'complete' => 'function(){ $("#overlay").fadeOut(300); }',
            ),
            array('id' => 'inv-submit-btn', 'class' => 'inv-submit')
        ) ?>
        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display:none;">
            <i class="fa fa-spinner fa-spin" style="color:#6366f1;font-size:18px;"></i>
        </span>
        <div id="formResult" class="ajaxTargetDiv"></div>
        <div id="formResultError" class="ajaxTargetDivErr"></div>
        <span class="inv-req-note">Fields marked <span>*</span> are required</span>
    </div>

</div><!-- /inv-card -->

<!-- Full-page overlay -->
<div id="overlay" style="display:none;position:fixed;inset:0;background:rgba(255,255,255,.65);z-index:9999;align-items:center;justify-content:center;">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
/* ── Prevent accidental Enter submit ── */
$(document).keypress(function(e){
    if((e.keyCode||e.which)==13){ return false; }
});

/* ── Date picker ── */
var picker = new Lightpick({
    field: document.getElementById('entry_date'),
    onSelect: function(date){
        document.getElementById('Inventory_date').value = date.format('YYYY-MM-DD');
    }
});

/* ── Type pill toggle ── */
function setType(type) {
    $('#Inventory_t_type').val(type);
    if (type == <?= Inventory::STOCK_OUT ?>) {
        $('#pill-in').removeClass('active-in');
        $('#pill-out').addClass('active-out');
        $('.stock-in').hide();
        $('.stock-out').show();
        $('#Inventory_stock_in').val('');
    } else {
        $('#pill-out').removeClass('active-out');
        $('#pill-in').addClass('active-in');
        $('.stock-out').hide();
        $('.stock-in').show();
        $('#Inventory_stock_out').val('');
    }
}

/* ── Product autocomplete ── */
$(document).ready(function(){
    $('#model_id_text').autocomplete({
        source: function(request, response){
            $.post('<?= Yii::app()->baseUrl ?>/index.php/prodModels/Jquery_showprodSearch',
                {"q": request.term},
                function(data){ response(data); }, "json");
        },
        minLength: 1,
        delay: 700,
        select: function(event, ui){
            $('#model_id_text').val(ui.item.value);
            $('#Inventory_model_id').val(ui.item.id);
            $('#Inventory_unit_id').val(ui.item.unit_id);
            $('#Inventory_sell_price').val(ui.item.sell_price);
            $('.product_unit_text').html($('#Inventory_unit_id option:selected').text());
            if($('#Inventory_t_type').val() == <?= Inventory::STOCK_OUT ?>){
                $.post('<?= Yii::app()->baseUrl ?>/index.php/inventory/inventory/Jquery_getStockQty',
                    {model_id: ui.item.id},
                    function(res){ $('#Inventory_closing_stock').val(res); });
            }
        }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        return $('<li></li>')
            .data('item.autocomplete', item)
            .append(`<a><img style="height:40px;width:40px;border-radius:6px;margin-right:8px;object-fit:cover;" src="${item.img}"> ${item.name}<br><small style="color:#94a3b8;">${item.code}</small></a>`)
            .appendTo(ul);
    };
});

/* ── Add product to list ── */
function addToList(){
    let t_type        = parseInt($('#Inventory_t_type').val());
    let model_id      = $('#Inventory_model_id').val();
    let model_id_text = $('#model_id_text').val();
    let unit_price    = $('#Inventory_sell_price').val();
    let stock_in      = parseFloat($('#Inventory_stock_in').val())  || 0;
    let stock_out     = parseFloat($('#Inventory_stock_out').val()) || 0;

    if(!model_id || !model_id_text){
        toastr.error('Please select a product.');
        return false;
    }
    if(stock_in === 0 && stock_out === 0){
        toastr.error('Please enter a quantity.');
        return false;
    }

    $('#inv-empty-row').hide();
    $('#list tbody').append(`
        <tr class="item">
            <td>${model_id_text}</td>
            <td class="text-center">
                <input type="text" class="inv-input text-center" value="${stock_in}"
                    name="Inventory[temp_stock_in][]"
                    ${t_type == <?= Inventory::STOCK_OUT ?> ? 'readonly' : ''}>
            </td>
            <td class="text-center">
                <input type="text" class="inv-input text-center" value="${stock_out}"
                    name="Inventory[temp_stock_out][]"
                    ${t_type == <?= Inventory::STOCK_IN ?> ? 'readonly' : ''}>
            </td>
            <td class="text-center">
                <button type="button" class="inv-dlt-btn dlt"><i class="fa fa-trash-o"></i></button>
                <input type="hidden" value="${model_id}"   name="Inventory[temp_model_id][]">
                <input type="hidden" value="${unit_price}" name="Inventory[temp_sell_price][]">
            </td>
        </tr>`);

    clearDynamicItem();
    prev_sell_price = unit_price;
    prev_product_id = model_id;
}

function clearDynamicItem(){
    $('#Inventory_unit_id').val('');
    $('#Inventory_closing_stock').val('');
}

/* ── Delete row ── */
$('#list').on('click', '.dlt', function(){
    $(this).closest('tr').remove();
    if($('#list tbody .item').length === 0) $('#inv-empty-row').show();
});

/* ── Submit ripple ── */
(function(){
    var btn = document.getElementById('inv-submit-btn');
    if(!btn) return;
    btn.addEventListener('click', function(e){
        var r = document.createElement('span');
        r.className = 'inv-ripple';
        var rect = this.getBoundingClientRect();
        var sz = Math.max(rect.width, rect.height);
        r.style.cssText = 'width:'+sz+'px;height:'+sz+'px;'
            +'left:'+(e.clientX-rect.left-sz/2)+'px;'
            +'top:'+(e.clientY-rect.top-sz/2)+'px;';
        this.appendChild(r);
        setTimeout(function(){ r.remove(); }, 700);
    });
}());
</script>
