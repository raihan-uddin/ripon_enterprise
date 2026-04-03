<?php
/** @var Inventory $model */

$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Inventory', 'url' => array('')),
        array('name' => 'Stock', 'url' => array('admin')),
        array('name' => 'Verify Product'),
    ),
));

$form = $this->beginWidget('CActiveForm', array(
    'id'                     => 'verify-items-form',
    'action'                 => $this->createUrl('inventory/verifyProduct'),
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true),
));
?>
<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>
<style>
/* ── Verify Product — prodModels indigo palette ── */
.vfy-card{border:none;border-radius:16px;overflow:hidden;
    box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);}
.vfy-card>.card-header{
    background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);
    border:none;padding:20px 26px;position:relative;overflow:hidden;}
.vfy-card>.card-header::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background-image:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);
    background-size:22px 22px;}
.vfy-card>.card-header::after{
    content:'';position:absolute;top:-50px;right:-50px;
    width:150px;height:150px;border-radius:50%;
    background:rgba(255,255,255,.07);pointer-events:none;}
.vfy-hd{display:flex;align-items:center;justify-content:space-between;position:relative;z-index:1;}
.vfy-hd-title{font-size:16px;font-weight:800;color:#fff;letter-spacing:-.2px;
    display:flex;align-items:center;gap:9px;}
.vfy-hd-icon{width:32px;height:32px;border-radius:9px;
    background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;
    font-size:14px;color:#fff;flex-shrink:0;}
.vfy-hd-sub{font-size:11.5px;color:rgba(255,255,255,.65);margin-top:3px;font-weight:400;}
.card-tools .btn-tool{color:rgba(255,255,255,.6);transition:color .15s;}
.card-tools .btn-tool:hover{color:#fff;}
.vfy-card>.card-body{padding:24px 26px;background:#fff;}

/* Input group */
.vfy-label{display:block;font-size:11px;font-weight:700;color:#475569;
    margin-bottom:6px;text-transform:uppercase;letter-spacing:.4px;}
.vfy-igroup{display:flex;border-radius:9px;overflow:hidden;
    border:1.5px solid #e2e8f0;transition:border-color .18s,box-shadow .18s;}
.vfy-igroup:focus-within{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12);}
.vfy-igroup:hover:not(:focus-within){border-color:#94a3b8;}
.vfy-igroup-icon{
    display:flex;align-items:center;padding:0 13px;
    background:#f8faff;border-right:1.5px solid #e2e8f0;
    color:#6366f1;font-size:15px;flex-shrink:0;}
.vfy-input{
    flex:1;border:none;outline:none;
    padding:10px 13px;font-size:13.5px;color:#1e293b;background:#fff;}
.vfy-input::placeholder{color:#94a3b8;}
.vfy-search-btn{
    display:inline-flex;align-items:center;gap:6px;
    padding:0 18px;font-size:13px;font-weight:700;
    background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;
    cursor:pointer;flex-shrink:0;white-space:nowrap;
    transition:filter .15s;}
.vfy-search-btn:hover{filter:brightness(1.1);}
.vfy-search-btn:active{filter:brightness(.95);}
.vfy-error{font-size:11px;color:#ef4444;margin-top:5px;display:block;}

/* Hint chip */
.vfy-hint{display:inline-flex;align-items:center;gap:5px;
    margin-top:10px;padding:5px 11px;border-radius:99px;
    background:#eef2ff;color:#6366f1;font-size:11.5px;font-weight:600;
    border:1px solid #c7d2fe;}
.vfy-hint i{font-size:10px;}

/* Overlay */
#vfy-overlay{display:none;position:fixed;inset:0;
    background:rgba(255,255,255,.65);z-index:9999;
    align-items:center;justify-content:center;}
.vfy-spinner{display:flex;align-items:center;justify-content:center;}
.vfy-spin{width:46px;height:46px;border-radius:50%;
    border:5px solid #eef2ff;border-top-color:#6366f1;
    animation:vfySpin .8s linear infinite;}
@keyframes vfySpin{to{transform:rotate(360deg);}}
</style>

<div class="card vfy-card">
    <div class="card-header">
        <div class="vfy-hd">
            <div class="vfy-hd-title">
                <div class="vfy-hd-icon"><i class="fa fa-barcode"></i></div>
                <div>
                    Verify Product
                    <div class="vfy-hd-sub">Scan or type a serial number to look up product history</div>
                </div>
            </div>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <label class="vfy-label">
                    <i class="fa fa-barcode" style="color:#6366f1;margin-right:3px;"></i>
                    Product Serial No <span style="color:#ef4444;">*</span>
                </label>
                <div class="vfy-igroup">
                    <div class="vfy-igroup-icon"><i class="fa fa-barcode"></i></div>
                    <input type="text" id="product_sl_no_text" class="vfy-input"
                           placeholder="Scan barcode or type serial number…" autocomplete="off">
                    <?= $form->hiddenField($model, 'product_sl_no', array('maxlength' => 255)) ?>
                    <button class="vfy-search-btn" type="button" onclick="verifyProductSlNo()">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
                <?= $form->error($model, 'product_sl_no', array('class' => 'vfy-error')) ?>
                <span class="vfy-hint"><i class="fa fa-keyboard-o"></i> Press Enter to search</span>
            </div>
        </div>
    </div>
</div>

<div id="vfy-overlay">
    <div class="vfy-spinner"><span class="vfy-spin"></span></div>
</div>

<div id="formResult" class="ajaxTargetDiv"></div>
<div id="formResultError" class="ajaxTargetDivErr"></div>

<?php $this->endWidget(); ?>

<script>
$(document).ready(function(){
    $('#product_sl_no_text').focus();
});

$(document).keypress(function(event){
    let keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        verifyProductSlNo();
        return false;
    }
});

function verifyProductSlNo(){
    $('#formResultError').html('');
    let product_sl = $('#product_sl_no_text').val().trim();
    if(product_sl.length === 0){
        toastr.error('Please enter a valid Product Serial No.');
        return;
    }
    $('#vfy-overlay').css('display','flex').hide().fadeIn(200);
    $.ajax({
        type: 'POST',
        url:  '<?= $this->createUrl('inventory/verifyProduct') ?>',
        data: {product_sl: product_sl},
        success: function(data){
            $('#formResult').html(data);
            $('#vfy-overlay').fadeOut(200);
        },
        error: function(data){
            $('#formResultError').html(
                '<div class="alert alert-danger alert-dismissible" role="alert">' +
                '<strong>Error!</strong> ' + data.responseText +
                '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>' +
                '</div>'
            );
            $('#vfy-overlay').fadeOut(200);
        }
    });
    $('#product_sl_no_text').focus();
}
</script>
