<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                     => 'units-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true),
));
?>
<style>
/* ── Units extended form — prodModels palette ── */
.un-card{border:none;border-radius:16px;overflow:hidden;
    box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);}
.un-card>.card-header{
    background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);
    border:none;padding:20px 26px;position:relative;overflow:hidden;}
.un-card>.card-header::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background-image:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);
    background-size:22px 22px;}
.un-card>.card-header::after{
    content:'';position:absolute;top:-50px;right:-50px;
    width:150px;height:150px;border-radius:50%;
    background:rgba(255,255,255,.07);pointer-events:none;}
.un-hd-top{display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;}
.un-hd-title{font-size:16px;font-weight:800;color:#fff;letter-spacing:-.2px;
    display:flex;align-items:center;gap:9px;}
.un-hd-icon{width:32px;height:32px;border-radius:9px;
    background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;
    font-size:14px;color:#fff;flex-shrink:0;}
.un-hd-sub{font-size:11.5px;color:rgba(255,255,255,.65);margin-top:3px;font-weight:400;}
.card-tools .btn-tool{color:rgba(255,255,255,.6);transition:color .15s;}
.card-tools .btn-tool:hover{color:#fff;}
.un-card>.card-body{padding:22px 26px;background:#fff;}
.un-card>.card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;
    padding:14px 26px;display:flex;align-items:center;gap:10px;}

/* Floating label — text inputs */
.un-fl{position:relative;}
.un-fl-input{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;
    outline:none;background:#fff;line-height:1.4;
    transition:border-color .18s,box-shadow .18s,transform .15s;
    -webkit-appearance:none;}
.un-fl-input:focus{
    border-color:#6366f1;
    box-shadow:0 0 0 3.5px rgba(99,102,241,.12);
    transform:translateY(-1px);}
.un-fl-input:hover:not(:focus){border-color:#94a3b8;}
.un-fl-label{
    position:absolute;left:38px;top:12px;
    font-size:13px;color:#94a3b8;font-weight:500;
    pointer-events:none;
    transition:all .18s cubic-bezier(.4,0,.2,1);}
.un-fl-input:focus+.un-fl-label,
.un-fl-input:not(:placeholder-shown)+.un-fl-label{
    top:5px;font-size:9.5px;font-weight:700;color:#6366f1;
    letter-spacing:.5px;text-transform:uppercase;}
.un-fl-icon{
    position:absolute;left:12px;top:50%;transform:translateY(-50%);
    color:#cbd5e1;font-size:13px;pointer-events:none;transition:color .18s;}
.un-fl:focus-within .un-fl-icon{color:#6366f1;}

/* Floating label — textarea variant */
.un-fl-textarea{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;
    outline:none;background:#fff;line-height:1.6;resize:vertical;min-height:90px;
    transition:border-color .18s,box-shadow .18s;
    -webkit-appearance:none;}
.un-fl-textarea:focus{
    border-color:#6366f1;
    box-shadow:0 0 0 3.5px rgba(99,102,241,.12);}
.un-fl-textarea:hover:not(:focus){border-color:#94a3b8;}
.un-fl-textarea:focus+.un-fl-label,
.un-fl-textarea:not(:placeholder-shown)+.un-fl-label{
    top:5px;font-size:9.5px;font-weight:700;color:#6366f1;
    letter-spacing:.5px;text-transform:uppercase;}
.un-fl .un-fl-icon-top{
    position:absolute;left:12px;top:18px;
    color:#cbd5e1;font-size:13px;pointer-events:none;transition:color .18s;}
.un-fl:focus-within .un-fl-icon-top{color:#6366f1;}

/* Floating label — select variant */
.un-fl-select{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;
    outline:none;background:#fff;line-height:1.4;
    transition:border-color .18s,box-shadow .18s,transform .15s;
    -webkit-appearance:none;appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 12px center;}
.un-fl-select:focus{
    border-color:#6366f1;
    box-shadow:0 0 0 3.5px rgba(99,102,241,.12);
    transform:translateY(-1px);}
.un-fl-select:hover:not(:focus){border-color:#94a3b8;}
.un-fl-select+.un-fl-label{
    top:5px;font-size:9.5px;font-weight:700;color:#6366f1;
    letter-spacing:.5px;text-transform:uppercase;}

.un-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block;}
.un-field-gap{margin-bottom:18px;}

/* Submit */
.un-submit{
    position:relative;overflow:hidden;
    display:inline-flex;align-items:center;gap:8px;
    padding:10px 24px;border-radius:9px;font-size:13.5px;font-weight:700;
    background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;
    cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);
    transition:box-shadow .18s,transform .15s;}
.un-submit:hover{box-shadow:0 6px 20px rgba(99,102,241,.5);transform:translateY(-2px);}
.un-submit:active{transform:translateY(0);}
.un-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.38);
    transform:scale(0);animation:unRipple .6s linear;pointer-events:none;}
@keyframes unRipple{to{transform:scale(4);opacity:0;}}
</style>

<div class="card un-card">

    <div class="card-header">
        <div class="un-hd-top">
            <div class="un-hd-title">
                <div class="un-hd-icon"><i class="fas fa-balance-scale"></i></div>
                <div>
                    <?= $model->isNewRecord ? 'Add New Unit' : 'Update Unit Info' ?>
                    <div class="un-hd-sub">Measurement unit (kg, pcs, box…)</div>
                </div>
            </div>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">

            <!-- Unit Type -->
            <div class="col-md-6 un-field-gap">
                <?php $model->unit_type = Units::CURR_UNIT; ?>
                <div class="un-fl">
                    <?= CHtml::activeDropDownList($model, 'unit_type', Lookup::items('unit_type'), array(
                        'class'  => 'un-fl-select',
                        'prompt' => 'Select type…',
                    )) ?>
                    <label class="un-fl-label" for="<?= CHtml::activeId($model, 'unit_type') ?>">
                        Unit Type <span style="color:#ef4444;">*</span>
                    </label>
                    <i class="fas fa-tag un-fl-icon"></i>
                </div>
                <span class="un-error"><?= $form->error($model, 'unit_type') ?></span>
            </div>

            <!-- Label -->
            <div class="col-md-6 un-field-gap">
                <div class="un-fl">
                    <?= CHtml::activeTextField($model, 'label', array(
                        'class'       => 'un-fl-input',
                        'placeholder' => ' ',
                    )) ?>
                    <label class="un-fl-label" for="<?= CHtml::activeId($model, 'label') ?>">
                        Unit Label <span style="color:#ef4444;">*</span>
                    </label>
                    <i class="fas fa-pencil un-fl-icon"></i>
                </div>
                <span class="un-error"><?= $form->error($model, 'label') ?></span>
            </div>

            <!-- Value -->
            <div class="col-md-6 un-field-gap">
                <div class="un-fl">
                    <?= CHtml::activeTextField($model, 'value', array(
                        'class'       => 'un-fl-input',
                        'placeholder' => ' ',
                    )) ?>
                    <label class="un-fl-label" for="<?= CHtml::activeId($model, 'value') ?>">
                        Value
                    </label>
                    <i class="fas fa-hashtag un-fl-icon"></i>
                </div>
                <span class="un-error"><?= $form->error($model, 'value') ?></span>
            </div>

            <!-- Remarks -->
            <div class="col-md-12 un-field-gap">
                <div class="un-fl">
                    <?= CHtml::activeTextArea($model, 'remarks', array(
                        'class'       => 'un-fl-textarea',
                        'rows'        => 4,
                        'placeholder' => ' ',
                    )) ?>
                    <label class="un-fl-label" for="<?= CHtml::activeId($model, 'remarks') ?>">
                        Remarks
                    </label>
                    <i class="fas fa-comment un-fl-icon-top"></i>
                </div>
                <span class="un-error"><?= $form->error($model, 'remarks') ?></span>
            </div>

        </div>
    </div>

    <div class="card-footer">
        <?= CHtml::submitButton(
            '<i class="fas fa-save"></i> ' . ($model->isNewRecord ? 'Add' : 'Update'),
            array(
                'id'      => 'un-submit-btn3',
                'class'   => 'un-submit',
                'onclick' => 'loadingDivDisplay3();',
            )
        ) ?>
        <span id="ajaxLoaderMR" style="display:none;">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
        </span>
    </div>

</div>

<?php $this->endWidget(); ?>

<script>
function loadingDivDisplay3() {
    $("#ajaxLoaderMR").show();
}
(function(){
    var btn = document.getElementById('un-submit-btn3');
    if (btn) {
        btn.addEventListener('click', function(e){
            var r = document.createElement('span');
            r.className = 'un-ripple';
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
