<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                     => 'prod-items-form',
    'action'                 => $this->createUrl('prodItems/create'),
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true),
));
?>
<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>
<style>
/* ── prodItems form — prodModels palette ── */
.pi-card{border:none;border-radius:16px;overflow:hidden;
    box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);}
.pi-card>.card-header{
    background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);
    border:none;padding:20px 26px;position:relative;overflow:hidden;}
.pi-card>.card-header::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background-image:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);
    background-size:22px 22px;}
.pi-card>.card-header::after{
    content:'';position:absolute;top:-50px;right:-50px;
    width:150px;height:150px;border-radius:50%;
    background:rgba(255,255,255,.07);pointer-events:none;}
.pi-hd-title{font-size:16px;font-weight:800;color:#fff;letter-spacing:-.2px;
    display:flex;align-items:center;gap:9px;position:relative;z-index:1;}
.pi-hd-icon{width:32px;height:32px;border-radius:9px;
    background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;
    font-size:14px;color:#fff;flex-shrink:0;}
.pi-hd-sub{font-size:11.5px;color:rgba(255,255,255,.65);margin-top:3px;font-weight:400;}
.pi-hd-top{display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;}
.card-tools .btn-tool{color:rgba(255,255,255,.6);transition:color .15s;}
.card-tools .btn-tool:hover{color:#fff;}
.pi-card>.card-body{padding:22px 26px;background:#fff;}
.pi-card>.card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;
    padding:14px 26px;display:flex;align-items:center;gap:10px;}

/* Floating label */
.pi-fl{position:relative;}
.pi-fl-input{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;
    outline:none;background:#fff;line-height:1.4;
    transition:border-color .18s,box-shadow .18s,transform .15s;
    -webkit-appearance:none;}
.pi-fl-input:focus{
    border-color:#6366f1;
    box-shadow:0 0 0 3.5px rgba(99,102,241,.12);
    transform:translateY(-1px);}
.pi-fl-input:hover:not(:focus){border-color:#94a3b8;}
.pi-fl-label{
    position:absolute;left:38px;top:12px;
    font-size:13px;color:#94a3b8;font-weight:500;
    pointer-events:none;
    transition:all .18s cubic-bezier(.4,0,.2,1);}
.pi-fl-input:focus+.pi-fl-label,
.pi-fl-input:not(:placeholder-shown)+.pi-fl-label{
    top:5px;font-size:9.5px;font-weight:700;color:#6366f1;
    letter-spacing:.5px;text-transform:uppercase;}
.pi-fl-icon{
    position:absolute;left:12px;top:50%;transform:translateY(-50%);
    color:#cbd5e1;font-size:13px;pointer-events:none;transition:color .18s;}
.pi-fl:focus-within .pi-fl-icon{color:#6366f1;}
.pi-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block;}

/* Submit */
.pi-submit{
    position:relative;overflow:hidden;
    display:inline-flex;align-items:center;gap:8px;
    padding:10px 24px;border-radius:9px;font-size:13.5px;font-weight:700;
    background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;
    cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);
    transition:box-shadow .18s,transform .15s;}
.pi-submit:hover{box-shadow:0 6px 20px rgba(99,102,241,.5);transform:translateY(-2px);}
.pi-submit:active{transform:translateY(0);}
.pi-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.38);
    transform:scale(0);animation:piRipple .6s linear;pointer-events:none;}
@keyframes piRipple{to{transform:scale(4);opacity:0;}}
</style>

<div class="card pi-card">

    <div class="card-header">
        <div class="pi-hd-top">
            <div class="pi-hd-title">
                <div class="pi-hd-icon"><i class="fa fa-tags"></i></div>
                <div>
                    <?= $model->isNewRecord ? 'Add New Category' : 'Update Category' ?>
                    <div class="pi-hd-sub">Product category / item type</div>
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
                <div class="pi-fl">
                    <?= CHtml::activeTextField($model, 'item_name', array(
                        'class'       => 'pi-fl-input',
                        'maxlength'   => 255,
                        'placeholder' => ' ',
                    )) ?>
                    <label class="pi-fl-label" for="<?= CHtml::activeId($model, 'item_name') ?>">
                        Category Name <span style="color:#ef4444;">*</span>
                    </label>
                    <i class="fa fa-tag pi-fl-icon"></i>
                </div>
                <span class="pi-error"><?= $form->error($model, 'item_name') ?></span>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <?= CHtml::ajaxSubmitButton(
            '<i class="fa fa-save"></i> Save',
            CHtml::normalizeUrl(array('prodItems/create', 'render' => true)),
            array(
                'dataType'   => 'json',
                'type'       => 'post',
                'beforeSend' => 'function(){ $("#ajaxLoader").show(); }',
                'success'    => 'function(data) {
                    $("#ajaxLoader").hide();
                    if(data.status=="success"){
                        toastr.success("Category saved successfully.");
                        $("#prod-items-form")[0].reset();
                        $.fn.yiiGridView.update("prod-items-grid", { data: $(this).serialize() });
                    } else {
                        $.each(data, function(key, val) {
                            $("#prod-items-form #"+key+"_em_").html(""+val+"").show();
                        });
                    }
                }',
            ),
            array('id' => 'pi-submit-btn', 'class' => 'pi-submit')
        ) ?>
        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display:none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>
        <div id="formResult" class="ajaxTargetDiv"></div>
        <div id="formResultError" class="ajaxTargetDivErr"></div>
    </div>

</div>

<?php $this->endWidget(); ?>

<script>
(function(){
    var btn = document.getElementById('pi-submit-btn');
    if (btn) {
        btn.addEventListener('click', function(e){
            var r = document.createElement('span');
            r.className = 'pi-ripple';
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
</script>
