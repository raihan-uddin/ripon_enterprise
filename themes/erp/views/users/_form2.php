<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                     => 'users-form-update',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true),
));

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
?>
<style>
/* ══════════════════════════════════════════
   Users Update Form (_form2) — pf-card design
══════════════════════════════════════════ */
.pf2-card{border:none;border-radius:12px;overflow:hidden;
    box-shadow:0 2px 12px rgba(0,0,0,.08);}
.pf2-card>.card-header{
    background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);
    border:none;padding:16px 22px;position:relative;overflow:hidden;}
.pf2-card>.card-header::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background-image:radial-gradient(rgba(255,255,255,.15) 1px,transparent 1px);
    background-size:18px 18px;}
.pf2-hd-title{font-size:15px;font-weight:800;color:#fff;
    display:flex;align-items:center;gap:8px;position:relative;z-index:1;}
.pf2-hd-icon{width:30px;height:30px;border-radius:8px;
    background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;
    font-size:13px;color:#fff;flex-shrink:0;}
.pf2-hd-sub{font-size:11.5px;color:rgba(255,255,255,.65);margin-top:2px;font-weight:400;}
.pf2-card>.card-body{padding:20px 22px;background:#fff;}
.pf2-card>.card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;
    padding:14px 22px;display:flex;align-items:center;gap:8px;}

/* Floating-label */
.pf2-fl{position:relative;margin-bottom:0;}
.pf2-fl-input{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:18px 12px 6px 36px;font-size:13px;color:#1e293b;
    outline:none;background:#fff;line-height:1.4;
    transition:border-color .18s,box-shadow .18s;
    -webkit-appearance:none;}
.pf2-fl-input:focus{
    border-color:#6366f1;
    box-shadow:0 0 0 3px rgba(99,102,241,.12);}
.pf2-fl-input:hover:not(:focus){border-color:#94a3b8;}
.pf2-fl-label{
    position:absolute;left:36px;top:11px;
    font-size:12.5px;color:#94a3b8;font-weight:500;
    pointer-events:none;
    transition:all .18s cubic-bezier(.4,0,.2,1);}
.pf2-fl-input:focus+.pf2-fl-label,
.pf2-fl-input:not(:placeholder-shown)+.pf2-fl-label{
    top:4px;left:36px;
    font-size:9px;font-weight:700;color:#6366f1;
    letter-spacing:.5px;text-transform:uppercase;}
.pf2-fl-icon{
    position:absolute;left:11px;top:50%;transform:translateY(-50%);
    color:#cbd5e1;font-size:12px;pointer-events:none;transition:color .18s;}
.pf2-fl:focus-within .pf2-fl-icon{color:#6366f1;}
.pf2-pw-toggle{
    position:absolute;right:9px;top:50%;transform:translateY(-50%);
    background:none;border:none;cursor:pointer;
    color:#94a3b8;font-size:12px;padding:4px;transition:color .15s;line-height:1;}
.pf2-pw-toggle:hover{color:#6366f1;}

/* Label above selects */
.pf2-label{
    display:flex;align-items:center;gap:5px;
    font-size:11px;font-weight:700;color:#475569;
    margin-bottom:5px;text-transform:uppercase;letter-spacing:.4px;}
.pf2-label .req{color:#ef4444;}
.pf2-sel-wrap{position:relative;}
.pf2-sel-icon{
    position:absolute;left:11px;top:50%;transform:translateY(-50%);
    color:#cbd5e1;font-size:12px;pointer-events:none;}
.pf2-select{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:9px 28px 9px 32px;font-size:13px;color:#1e293b;background:#fff;
    outline:none;-webkit-appearance:none;cursor:pointer;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2394a3b8'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 10px center;
    transition:border-color .18s,box-shadow .18s;}
.pf2-select:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.12);}
.pf2-select:hover:not(:focus){border-color:#94a3b8;}

.pf2-field{margin-bottom:14px;}
.pf2-field:last-child{margin-bottom:0;}
.pf2-error{font-size:11px;color:#ef4444;margin-top:4px;display:block;}
.pf2-hint{font-size:11px;color:#94a3b8;margin-top:3px;display:block;}

/* Submit */
.pf2-submit{
    position:relative;overflow:hidden;
    display:inline-flex;align-items:center;gap:7px;
    padding:9px 22px;border-radius:8px;font-size:13.5px;font-weight:700;
    background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;
    cursor:pointer;
    box-shadow:0 3px 10px rgba(15,118,110,.35);
    transition:box-shadow .18s,transform .15s;}
.pf2-submit:hover{box-shadow:0 5px 16px rgba(15,118,110,.45);transform:translateY(-1px);}
.pf2-submit:active{transform:translateY(0);}
</style>

<div class="card pf2-card">

    <!-- ═══ Header ═══ -->
    <div class="card-header">
        <div class="pf2-hd-title">
            <div class="pf2-hd-icon"><i class="fa fa-pencil"></i></div>
            <div>
                Update User: <strong><?= CHtml::encode($model->username) ?></strong>
                <div class="pf2-hd-sub">Modify credentials or account status</div>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row">

            <!-- Username -->
            <div class="col-sm-6">
                <div class="pf2-field">
                    <div class="pf2-fl">
                        <?= CHtml::activeTextField($model, 'username', array(
                            'class'       => 'pf2-fl-input',
                            'maxlength'   => 20,
                            'placeholder' => ' ',
                        )) ?>
                        <label class="pf2-fl-label" for="<?= CHtml::activeId($model, 'username') ?>">
                            Username <span class="req">*</span>
                        </label>
                        <i class="fa fa-user pf2-fl-icon"></i>
                    </div>
                    <span class="pf2-error"><?= $form->error($model, 'username') ?></span>
                </div>
            </div>

            <!-- Status -->
            <div class="col-sm-6">
                <div class="pf2-field">
                    <label class="pf2-label"><i class="fa fa-toggle-on"></i> Account Status <span class="req">*</span></label>
                    <div class="pf2-sel-wrap">
                        <i class="fa fa-toggle-on pf2-sel-icon"></i>
                        <?= CHtml::activeDropDownList($model, 'status',
                            array(1 => 'Active', 0 => 'Inactive'),
                            array('class' => 'pf2-select')
                        ) ?>
                    </div>
                    <span class="pf2-error"><?= $form->error($model, 'status') ?></span>
                </div>
            </div>

            <!-- New Password -->
            <div class="col-sm-6">
                <div class="pf2-field">
                    <div class="pf2-fl">
                        <?= CHtml::activePasswordField($model, 'password', array(
                            'class'       => 'pf2-fl-input',
                            'maxlength'   => 20,
                            'value'       => '',
                            'placeholder' => ' ',
                            'id'          => 'uf2-password',
                        )) ?>
                        <label class="pf2-fl-label" for="uf2-password">New Password</label>
                        <i class="fa fa-lock pf2-fl-icon"></i>
                        <button type="button" class="pf2-pw-toggle" id="pf2-pw-btn1" tabindex="-1">
                            <i class="fa fa-eye" id="pf2-pw-icon1"></i>
                        </button>
                    </div>
                    <span class="pf2-hint"><i class="fa fa-info-circle" style="margin-right:3px;"></i>Leave blank to keep current password</span>
                    <span class="pf2-error"><?= $form->error($model, 'password') ?></span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="col-sm-6">
                <div class="pf2-field">
                    <div class="pf2-fl">
                        <?= CHtml::activePasswordField($model, 'password2', array(
                            'class'       => 'pf2-fl-input',
                            'maxlength'   => 20,
                            'value'       => '',
                            'placeholder' => ' ',
                            'id'          => 'uf2-password2',
                        )) ?>
                        <label class="pf2-fl-label" for="uf2-password2">Confirm Password</label>
                        <i class="fa fa-lock pf2-fl-icon"></i>
                        <button type="button" class="pf2-pw-toggle" id="pf2-pw-btn2" tabindex="-1">
                            <i class="fa fa-eye" id="pf2-pw-icon2"></i>
                        </button>
                    </div>
                    <span class="pf2-error"><?= $form->error($model, 'password2') ?></span>
                </div>
            </div>

        </div>
    </div><!-- /card-body -->

    <!-- ═══ Footer ═══ -->
    <div class="card-footer">
        <?= CHtml::submitButton('Save Changes', array(
            'onclick' => 'loadingDivDisplay2();',
            'class'   => 'pf2-submit',
            'id'      => 'pf2-submit-btn',
        )) ?>
        <span id="ajaxLoaderMR2" style="display:none; align-items:center; gap:6px; color:#6366f1; font-size:13px;">
            <i class="fa fa-spinner fa-spin"></i> Saving&hellip;
        </span>
    </div>

</div><!-- /pf2-card -->

<?php $this->endWidget(); ?>

<script>
function loadingDivDisplay2() {
    document.getElementById('pf2-submit-btn').style.display = 'none';
    document.getElementById('ajaxLoaderMR2').style.display = 'inline-flex';
}

(function () {
    /* Password toggles */
    [['pf2-pw-btn1','uf2-password','pf2-pw-icon1'],
     ['pf2-pw-btn2','uf2-password2','pf2-pw-icon2']].forEach(function (trio) {
        var btn  = document.getElementById(trio[0]);
        var inp  = document.getElementById(trio[1]);
        var icon = document.getElementById(trio[2]);
        if (btn && inp && icon) {
            btn.addEventListener('click', function () {
                if (inp.type === 'password') {
                    inp.type = 'text';
                    icon.className = 'fa fa-eye-slash';
                } else {
                    inp.type = 'password';
                    icon.className = 'fa fa-eye';
                }
            });
        }
    });
}());
</script>
