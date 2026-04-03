<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                     => 'prod-brands-form',
    'action'                 => $this->createUrl('prodBrands/create'),
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true),
));
?>
<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>
<style>
/* ── prodBrands form — prodModels palette ── */
.pb-card{border:none;border-radius:16px;overflow:hidden;
    box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);}
.pb-card>.card-header{
    background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);
    border:none;padding:20px 26px;position:relative;overflow:hidden;}
.pb-card>.card-header::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background-image:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);
    background-size:22px 22px;}
.pb-card>.card-header::after{
    content:'';position:absolute;top:-50px;right:-50px;
    width:150px;height:150px;border-radius:50%;
    background:rgba(255,255,255,.07);pointer-events:none;}
.pb-hd-top{display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;}
.pb-hd-title{font-size:16px;font-weight:800;color:#fff;letter-spacing:-.2px;
    display:flex;align-items:center;gap:9px;}
.pb-hd-icon{width:32px;height:32px;border-radius:9px;
    background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;
    font-size:14px;color:#fff;flex-shrink:0;}
.pb-hd-sub{font-size:11.5px;color:rgba(255,255,255,.65);margin-top:3px;font-weight:400;}
.card-tools .btn-tool{color:rgba(255,255,255,.6);transition:color .15s;}
.card-tools .btn-tool:hover{color:#fff;}
.pb-card>.card-body{padding:22px 26px;background:#fff;}
.pb-card>.card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;
    padding:14px 26px;display:flex;align-items:center;gap:10px;}

/* Floating label */
.pb-fl{position:relative;}
.pb-fl-input{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;
    outline:none;background:#fff;line-height:1.4;
    transition:border-color .18s,box-shadow .18s,transform .15s;
    -webkit-appearance:none;}
.pb-fl-input:focus{
    border-color:#6366f1;
    box-shadow:0 0 0 3.5px rgba(99,102,241,.12);
    transform:translateY(-1px);}
.pb-fl-input:hover:not(:focus){border-color:#94a3b8;}
.pb-fl-label{
    position:absolute;left:38px;top:12px;
    font-size:13px;color:#94a3b8;font-weight:500;
    pointer-events:none;
    transition:all .18s cubic-bezier(.4,0,.2,1);}
.pb-fl-input:focus+.pb-fl-label,
.pb-fl-input:not(:placeholder-shown)+.pb-fl-label{
    top:5px;font-size:9.5px;font-weight:700;color:#6366f1;
    letter-spacing:.5px;text-transform:uppercase;}
.pb-fl-icon{
    position:absolute;left:12px;top:50%;transform:translateY(-50%);
    color:#cbd5e1;font-size:13px;pointer-events:none;transition:color .18s;}
.pb-fl:focus-within .pb-fl-icon{color:#6366f1;}
.pb-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block;}

/* Label + select */
.pb-label{
    display:flex;align-items:center;gap:5px;
    font-size:11px;font-weight:700;color:#475569;
    margin-bottom:6px;text-transform:uppercase;letter-spacing:.4px;}
.pb-label .req{color:#ef4444;}
.pb-addon{display:flex;gap:6px;}
.pb-sel-wrap{position:relative;flex:1;}
.pb-sel-icon{
    position:absolute;left:11px;top:50%;transform:translateY(-50%);
    color:#cbd5e1;font-size:12px;pointer-events:none;transition:color .18s;}
.pb-sel-wrap:focus-within .pb-sel-icon{color:#6366f1;}
.pb-select{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:10px 28px 10px 32px;font-size:13px;color:#1e293b;background:#fff;
    outline:none;-webkit-appearance:none;cursor:pointer;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2394a3b8'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 10px center;
    transition:border-color .18s,box-shadow .18s;}
.pb-select:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12);}
.pb-select:hover:not(:focus){border-color:#94a3b8;}
.pb-add-btn{
    flex-shrink:0;height:40px;padding:0 12px;
    display:inline-flex;align-items:center;gap:4px;
    border-radius:8px;font-size:12px;font-weight:700;
    border:1.5px solid #6366f1;color:#6366f1;background:#fff;
    cursor:pointer;white-space:nowrap;
    transition:all .15s;text-decoration:none;}
.pb-add-btn:hover{background:#6366f1;color:#fff;
    box-shadow:0 4px 12px rgba(99,102,241,.35);transform:translateY(-1px);text-decoration:none;}
.pb-add-btn:active{transform:translateY(0);}

/* Submit */
.pb-submit{
    position:relative;overflow:hidden;
    display:inline-flex;align-items:center;gap:8px;
    padding:10px 24px;border-radius:9px;font-size:13.5px;font-weight:700;
    background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;
    cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);
    transition:box-shadow .18s,transform .15s;}
.pb-submit:hover{box-shadow:0 6px 20px rgba(99,102,241,.5);transform:translateY(-2px);}
.pb-submit:active{transform:translateY(0);}
.pb-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.38);
    transform:scale(0);animation:pbRipple .6s linear;pointer-events:none;}
@keyframes pbRipple{to{transform:scale(4);opacity:0;}}
</style>

<div id="formResult" class="ajaxTargetDiv"></div>
<div id="formResultError" class="ajaxTargetDivErr"></div>

<div class="card pb-card">

    <div class="card-header">
        <div class="pb-hd-top">
            <div class="pb-hd-title">
                <div class="pb-hd-icon"><i class="fa fa-bookmark"></i></div>
                <div>
                    <?= $model->isNewRecord ? 'Add New Sub-Category' : 'Update Sub-Category' ?>
                    <div class="pb-hd-sub">Brand / sub-category under a product category</div>
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

            <!-- Category dropdown + add-new -->
            <div class="col-md-6">
                <div style="margin-bottom:14px;">
                    <label class="pb-label"><i class="fa fa-tags"></i> Category <span class="req">*</span></label>
                    <div class="pb-addon">
                        <div class="pb-sel-wrap">
                            <i class="fa fa-tags pb-sel-icon"></i>
                            <?= $form->dropDownList(
                                $model, 'item_id',
                                CHtml::listData(ProdItems::model()->findAll(array('order' => 'item_name ASC')), 'id', 'item_name'),
                                array('prompt' => 'Select category…', 'class' => 'pb-select')
                            ) ?>
                        </div>
                        <a href="#" class="pb-add-btn" onclick="addProdItem(); $('#dialogAddProdItem').dialog('open'); return false;">
                            <i class="fa fa-plus"></i> New
                        </a>
                    </div>
                    <span class="pb-error"><?= $form->error($model, 'item_id') ?></span>
                </div>
            </div>

            <!-- Sub-category name -->
            <div class="col-md-6">
                <div style="margin-bottom:14px;">
                    <label class="pb-label"><i class="fa fa-bookmark-o"></i> Sub-Category Name <span class="req">*</span></label>
                    <div class="pb-fl">
                        <?= CHtml::activeTextField($model, 'brand_name', array(
                            'class'       => 'pb-fl-input',
                            'maxlength'   => 255,
                            'placeholder' => ' ',
                        )) ?>
                        <label class="pb-fl-label" for="<?= CHtml::activeId($model, 'brand_name') ?>">
                            Sub-Category Name <span style="color:#ef4444;">*</span>
                        </label>
                        <i class="fa fa-bookmark-o pb-fl-icon"></i>
                    </div>
                    <span class="pb-error"><?= $form->error($model, 'brand_name') ?></span>
                </div>
            </div>

        </div>
    </div>

    <div class="card-footer">
        <?= CHtml::ajaxSubmitButton(
            '<i class="fa fa-save"></i> Save',
            CHtml::normalizeUrl(array('prodBrands/create', 'render' => true)),
            array(
                'dataType'   => 'json',
                'type'       => 'post',
                'beforeSend' => 'function(){ $("#ajaxLoader").show(); }',
                'success'    => 'function(data) {
                    $("#ajaxLoader").hide();
                    if(data.status=="success"){
                        toastr.success("Sub-category saved successfully.");
                        $("#prod-brands-form")[0].reset();
                        $.fn.yiiGridView.update("prod-brands-grid", { data: $(this).serialize() });
                    } else {
                        toastr.error("Please fix the errors and try again.");
                        $.each(data, function(key, val) {
                            $("#prod-brands-form #"+key+"_em_").html(""+val+"").show();
                        });
                    }
                }',
            ),
            array('id' => 'pb-submit-btn', 'class' => 'pb-submit')
        ) ?>
    </div>

</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddProdItem',
    'options' => array(
        'title'     => 'Add Category',
        'autoOpen'  => false,
        'modal'     => true,
        'width'     => 550,
        'resizable' => false,
    ),
));
?>
<div class="divForForm">
    <div class="ajaxLoaderFormLoad" style="display:none;">
        <img src="<?= Yii::app()->theme->baseUrl ?>/images/ajax-loader.gif"/>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
(function(){
    var btn = document.getElementById('pb-submit-btn');
    if (btn) {
        btn.addEventListener('click', function(e){
            var r = document.createElement('span');
            r.className = 'pb-ripple';
            var rect = this.getBoundingClientRect();
            var sz = Math.max(rect.width, rect.height);
            r.style.cssText = 'width:'+sz+'px;height:'+sz+'px;'
                +'left:'+(e.clientX-rect.left-sz/2)+'px;'
                +'top:'+(e.clientY-rect.top-sz/2)+'px;';
            this.appendChild(r);
            setTimeout(function(){ r.remove(); }, 700);
        });
    }
}());

function addProdItem() {
    <?php
    echo CHtml::ajax(array(
        'url'        => array('prodItems/createProdItemsFromOutSide'),
        'data'       => "js:$(this).serialize()",
        'type'       => 'post',
        'dataType'   => 'json',
        'beforeSend' => "function(){ $('.ajaxLoaderFormLoad').show(); }",
        'complete'   => "function(){ $('.ajaxLoaderFormLoad').hide(); }",
        'success'    => "function(data){
            if (data.status == 'failure') {
                $('#dialogAddProdItem div.divForForm').html(data.div);
                $('#dialogAddProdItem div.divForForm form').submit(addProdItem);
            } else {
                $('#dialogAddProdItem div.divForForm').html(data.div);
                setTimeout(\"$('#dialogAddProdItem').dialog('close')\", 1000);
                $('#ProdBrands_item_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
            }
        }",
    ));
    ?>
    return false;
}
</script>
