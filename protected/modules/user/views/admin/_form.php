<?php
/** @var CActiveForm $form */
/** @var User $model */
/** @var Profile $profile */

$isNew = $model->isNewRecord;
$profileFields = $profile->getFields();

$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'user-form',
    'enableAjaxValidation' => true,
    'htmlOptions'          => array('enctype' => 'multipart/form-data'),
));
?>
<style>
/* ══════════════════════════════════════════
   User Form — matches Product Form design
══════════════════════════════════════════ */
.pf-card{border:none;border-radius:16px;overflow:hidden;
    box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);}

/* Header */
.pf-card>.card-header{
    background:linear-gradient(135deg,#0f766e 0%,#0891b2 100%);
    border:none;padding:22px 28px 20px;position:relative;overflow:hidden;}
.pf-card>.card-header::before{
    content:'';position:absolute;inset:0;pointer-events:none;
    background-image:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);
    background-size:22px 22px;}
.pf-card>.card-header::after{
    content:'';position:absolute;top:-50px;right:-50px;
    width:160px;height:160px;border-radius:50%;
    background:rgba(255,255,255,.07);pointer-events:none;}
.pf-hd-top{display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;}
.pf-hd-title{font-size:17px;font-weight:800;color:#fff;letter-spacing:-.2px;
    display:flex;align-items:center;gap:9px;}
.pf-hd-title-icon{width:34px;height:34px;border-radius:9px;
    background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;
    font-size:14px;color:#fff;flex-shrink:0;}
.pf-hd-sub{font-size:12px;color:rgba(255,255,255,.65);margin-top:3px;font-weight:400;}
.card-tools .btn-tool{color:rgba(255,255,255,.6);transition:color .15s;}
.card-tools .btn-tool:hover{color:#fff;}

/* Chips */
.pf-hd-chips{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px;position:relative;z-index:1;}
.pf-chip{display:inline-flex;align-items:center;gap:5px;
    padding:4px 10px;border-radius:99px;font-size:11px;font-weight:600;
    background:rgba(255,255,255,.15);color:rgba(255,255,255,.85);
    border:1px solid rgba(255,255,255,.2);transition:background .2s;}
.pf-chip.done{background:rgba(255,255,255,.28);color:#fff;}
.pf-chip i{font-size:10px;}

/* Progress */
.pf-prog{display:flex;align-items:center;gap:10px;margin-top:10px;position:relative;z-index:1;}
.pf-prog-bg{flex:1;height:4px;border-radius:99px;background:rgba(255,255,255,.2);overflow:hidden;}
.pf-prog-fill{height:100%;border-radius:99px;background:#fff;
    transition:width .4s cubic-bezier(.4,0,.2,1);width:0%;}
.pf-prog-txt{font-size:11px;color:rgba(255,255,255,.75);font-weight:600;white-space:nowrap;}

/* Card body */
.pf-card>.card-body{padding:0;background:#fff;}

/* Section */
.pf-section{padding:24px 28px;border-bottom:1px solid #f1f5f9;transition:background .2s;}
.pf-section:last-child{border-bottom:none;}
.pf-section:hover{background:#fafbff;}
.pf-sec-hd{display:flex;align-items:center;gap:12px;margin-bottom:18px;}
.pf-step-badge{
    width:30px;height:30px;border-radius:50%;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    background:#ccfbf1;color:#0f766e;font-size:12px;font-weight:800;
    border:2px solid #99f6e4;
    transition:all .3s cubic-bezier(.34,1.56,.64,1);}
.pf-section.is-complete .pf-step-badge{
    background:#0f766e;color:#fff;border-color:#0f766e;
    box-shadow:0 0 0 4px rgba(15,118,110,.18);}
.pf-sec-info{flex:1;}
.pf-sec-title{font-size:13.5px;font-weight:700;color:#1e293b;line-height:1.2;}
.pf-sec-sub{font-size:11px;color:#94a3b8;margin-top:2px;}
.pf-sec-body{background:#f0fdfa;border:1px solid #ccfbf1;border-radius:12px;padding:18px 16px;}

/* Floating-label inputs */
.pf-fl{position:relative;margin-bottom:0;}
.pf-fl-input{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;
    outline:none;background:#fff;line-height:1.4;
    transition:border-color .18s,box-shadow .18s,transform .15s;
    -webkit-appearance:none;}
.pf-fl-input:focus{
    border-color:#0f766e;
    box-shadow:0 0 0 3.5px rgba(15,118,110,.12);
    transform:translateY(-1px);}
.pf-fl-input:hover:not(:focus){border-color:#94a3b8;}
.pf-fl-label{
    position:absolute;left:38px;top:12px;
    font-size:13px;color:#94a3b8;font-weight:500;
    pointer-events:none;
    transition:all .18s cubic-bezier(.4,0,.2,1);}
.pf-fl-input:focus+.pf-fl-label,
.pf-fl-input:not(:placeholder-shown)+.pf-fl-label{
    top:5px;left:38px;
    font-size:9.5px;font-weight:700;color:#0f766e;
    letter-spacing:.5px;text-transform:uppercase;}
.pf-fl-icon{
    position:absolute;left:12px;top:50%;transform:translateY(-50%);
    color:#cbd5e1;font-size:13px;pointer-events:none;transition:color .18s;}
.pf-fl:focus-within .pf-fl-icon{color:#0f766e;}
.pf-fl-tick{
    position:absolute;right:10px;top:50%;transform:translateY(-50%);
    font-size:12px;pointer-events:none;opacity:0;transition:opacity .2s;}
.pf-field.is-valid .pf-fl-tick{opacity:1;color:#22c55e;}
.pf-field.is-invalid .pf-fl-input{border-color:#ef4444;}

/* Password show/hide */
.pf-pw-toggle{
    position:absolute;right:10px;top:50%;transform:translateY(-50%);
    background:none;border:none;cursor:pointer;
    color:#94a3b8;font-size:13px;padding:4px;transition:color .15s;line-height:1;}
.pf-pw-toggle:hover{color:#0f766e;}
/* shift tick when password field has toggle btn */
.pf-fl.has-toggle .pf-fl-tick{right:34px;}

/* Hint text */
.pf-hint{font-size:11px;color:#94a3b8;margin-top:4px;display:block;}

/* Styled selects */
.pf-sel-wrap{position:relative;}
.pf-sel-icon{
    position:absolute;left:12px;top:50%;transform:translateY(-50%);
    color:#cbd5e1;font-size:12px;pointer-events:none;transition:color .18s;}
.pf-sel-wrap:focus-within .pf-sel-icon{color:#0f766e;}
.pf-select{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:10px 28px 10px 34px;font-size:13px;color:#1e293b;background:#fff;
    outline:none;-webkit-appearance:none;cursor:pointer;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2394a3b8'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 10px center;
    transition:border-color .18s,box-shadow .18s,transform .15s;}
.pf-select:focus{
    border-color:#0f766e;box-shadow:0 0 0 3.5px rgba(15,118,110,.12);
    transform:translateY(-1px);}
.pf-select:hover:not(:focus){border-color:#94a3b8;}

/* Label above selects */
.pf-label{
    display:flex;align-items:center;gap:5px;
    font-size:11.5px;font-weight:700;color:#475569;
    margin-bottom:6px;text-transform:uppercase;letter-spacing:.4px;
    transition:color .15s;}
.pf-label .req{color:#ef4444;}
.pf-field:focus-within .pf-label{color:#0f766e;}

/* Field spacing */
.pf-field{margin-bottom:14px;}
.pf-field:last-child{margin-bottom:0;}

/* Error */
.pf-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block;}

/* Shake */
@keyframes pfShake{
    0%,100%{transform:translateX(0);}
    20%{transform:translateX(-5px);}
    40%{transform:translateX(5px);}
    60%{transform:translateX(-4px);}
    80%{transform:translateX(4px);}
}
.pf-shake{animation:pfShake .4s ease;}

/* Footer */
.pf-card>.card-footer{
    background:#f8fafc;border-top:1px solid #f1f5f9;
    padding:16px 28px;display:flex;align-items:center;gap:10px;}
.pf-req-note{margin-left:auto;font-size:11.5px;color:#94a3b8;}
.pf-req-note span{color:#ef4444;font-weight:700;}

/* Submit */
.pf-submit{
    position:relative;overflow:hidden;
    display:inline-flex;align-items:center;gap:8px;
    padding:11px 26px;border-radius:9px;font-size:14px;font-weight:700;
    background:linear-gradient(135deg,#0f766e,#0891b2);color:#fff;border:none;
    cursor:pointer;letter-spacing:-.1px;
    box-shadow:0 4px 14px rgba(15,118,110,.4);
    transition:box-shadow .18s,transform .15s;}
.pf-submit:hover{box-shadow:0 6px 20px rgba(15,118,110,.5);transform:translateY(-2px);}
.pf-submit:active{transform:translateY(0);}
.pf-ripple{
    position:absolute;border-radius:50%;
    background:rgba(255,255,255,.38);transform:scale(0);
    animation:pfRipple .6s linear;pointer-events:none;}
@keyframes pfRipple{to{transform:scale(4);opacity:0;}}

/* Cancel */
.pf-cancel{
    display:inline-flex;align-items:center;gap:6px;
    padding:11px 20px;border-radius:9px;font-size:13.5px;font-weight:600;
    background:#fff;color:#64748b;border:1.5px solid #e2e8f0;text-decoration:none;
    transition:all .15s;}
.pf-cancel:hover{background:#f8fafc;color:#374151;border-color:#94a3b8;text-decoration:none;}

/* Spinner */
#pf-spinner{display:none;align-items:center;gap:7px;color:#0f766e;font-size:13px;}

/* Profile field textarea */
.pf-textarea{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:10px 12px;font-size:13px;color:#1e293b;outline:none;
    resize:vertical;min-height:80px;
    transition:border-color .18s,box-shadow .18s;}
.pf-textarea:focus{border-color:#0f766e;box-shadow:0 0 0 3.5px rgba(15,118,110,.12);}
.pf-textarea:hover:not(:focus){border-color:#94a3b8;}
</style>

<div class="card pf-card">

    <!-- ═══ Header ═══ -->
    <div class="card-header">
        <div class="pf-hd-top">
            <div class="pf-hd-title">
                <div class="pf-hd-title-icon">
                    <i class="fa fa-<?= $isNew ? 'user-plus' : 'user' ?>"></i>
                </div>
                <div>
                    <?= $isNew ? 'Create New User' : 'Update User' ?>
                    <div class="pf-hd-sub">Fill all required fields to <?= $isNew ? 'create' : 'update' ?> the user account</div>
                </div>
            </div>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="pf-hd-chips">
            <span class="pf-chip" id="chip-account"><i class="fa fa-user"></i> Account</span>
            <span class="pf-chip" id="chip-access"><i class="fa fa-shield"></i> Access</span>
            <?php if ($profileFields): ?>
            <span class="pf-chip" id="chip-profile"><i class="fa fa-id-card-o"></i> Profile</span>
            <?php endif; ?>
        </div>
        <div class="pf-prog">
            <div class="pf-prog-bg"><div class="pf-prog-fill" id="pfProg"></div></div>
            <span class="pf-prog-txt" id="pfProgTxt">0% complete</span>
        </div>
    </div>

    <div class="card-body">

        <?= $form->errorSummary(array($model, $profile), null, null, array('class' => 'alert alert-danger mx-3 mt-3')) ?>

        <!-- ═══ Section 1 — Account ═══ -->
        <div class="pf-section" id="sec-account">
            <div class="pf-sec-hd">
                <div class="pf-step-badge">1</div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Account Information</div>
                    <div class="pf-sec-sub">Login credentials for the user</div>
                </div>
            </div>
            <div class="pf-sec-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="pf-field" id="field-username">
                            <div class="pf-fl">
                                <input type="text"
                                    class="pf-fl-input"
                                    id="<?= CHtml::activeId($model, 'username') ?>"
                                    name="<?= CHtml::activeName($model, 'username') ?>"
                                    value="<?= CHtml::encode($model->username) ?>"
                                    maxlength="20"
                                    placeholder=" "
                                    data-pf-required="1">
                                <label class="pf-fl-label" for="<?= CHtml::activeId($model, 'username') ?>">
                                    Username <span class="req">*</span>
                                </label>
                                <i class="fa fa-user pf-fl-icon"></i>
                                <i class="fa fa-check pf-fl-tick"></i>
                            </div>
                            <?= $form->error($model, 'username', array('class' => 'pf-error')) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pf-field" id="field-email">
                            <div class="pf-fl">
                                <input type="email"
                                    class="pf-fl-input"
                                    id="<?= CHtml::activeId($model, 'email') ?>"
                                    name="<?= CHtml::activeName($model, 'email') ?>"
                                    value="<?= CHtml::encode($model->email) ?>"
                                    maxlength="128"
                                    placeholder=" "
                                    data-pf-required="1">
                                <label class="pf-fl-label" for="<?= CHtml::activeId($model, 'email') ?>">
                                    Email Address <span class="req">*</span>
                                </label>
                                <i class="fa fa-envelope pf-fl-icon"></i>
                                <i class="fa fa-check pf-fl-tick"></i>
                            </div>
                            <?= $form->error($model, 'email', array('class' => 'pf-error')) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="pf-field" id="field-password">
                            <div class="pf-fl has-toggle">
                                <input type="password"
                                    class="pf-fl-input"
                                    id="<?= CHtml::activeId($model, 'password') ?>"
                                    name="<?= CHtml::activeName($model, 'password') ?>"
                                    maxlength="128"
                                    placeholder=" "
                                    <?= $isNew ? 'data-pf-required="1"' : '' ?>>
                                <label class="pf-fl-label" for="<?= CHtml::activeId($model, 'password') ?>">
                                    Password <?= $isNew ? '<span class="req">*</span>' : '' ?>
                                </label>
                                <i class="fa fa-lock pf-fl-icon"></i>
                                <button type="button" class="pf-pw-toggle" id="pf-pw-btn" tabindex="-1">
                                    <i class="fa fa-eye" id="pf-pw-icon"></i>
                                </button>
                                <i class="fa fa-check pf-fl-tick"></i>
                            </div>
                            <?php if (!$isNew): ?>
                            <span class="pf-hint"><i class="fa fa-info-circle" style="margin-right:3px;"></i>Leave blank to keep current password</span>
                            <?php endif; ?>
                            <?= $form->error($model, 'password', array('class' => 'pf-error')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ Section 2 — Access & Permissions ═══ -->
        <div class="pf-section" id="sec-access">
            <div class="pf-sec-hd">
                <div class="pf-step-badge">2</div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Access &amp; Permissions</div>
                    <div class="pf-sec-sub">Control the user's role and account status</div>
                </div>
            </div>
            <div class="pf-sec-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="pf-field" id="field-superuser">
                            <label class="pf-label">
                                <i class="fa fa-shield"></i>
                                Admin Status <span class="req">*</span>
                            </label>
                            <div class="pf-sel-wrap">
                                <i class="fa fa-shield pf-sel-icon"></i>
                                <?= CHtml::activeDropDownList($model, 'superuser',
                                    User::itemAlias('AdminStatus'),
                                    array('class' => 'pf-select', 'data-pf-required' => '1')
                                ) ?>
                            </div>
                            <?= $form->error($model, 'superuser', array('class' => 'pf-error')) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pf-field" id="field-status">
                            <label class="pf-label">
                                <i class="fa fa-toggle-on"></i>
                                Account Status <span class="req">*</span>
                            </label>
                            <div class="pf-sel-wrap">
                                <i class="fa fa-toggle-on pf-sel-icon"></i>
                                <?= CHtml::activeDropDownList($model, 'status',
                                    User::itemAlias('UserStatus'),
                                    array('class' => 'pf-select', 'data-pf-required' => '1')
                                ) ?>
                            </div>
                            <?= $form->error($model, 'status', array('class' => 'pf-error')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($profileFields): ?>
        <!-- ═══ Section 3 — Profile Fields ═══ -->
        <div class="pf-section" id="sec-profile">
            <div class="pf-sec-hd">
                <div class="pf-step-badge">3</div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Profile Details</div>
                    <div class="pf-sec-sub">Additional information about the user</div>
                </div>
            </div>
            <div class="pf-sec-body">
                <div class="row">
                <?php foreach ($profileFields as $field):
                    $label = $profile->getAttributeLabel($field->varname);
                ?>
                    <div class="col-md-6">
                        <div class="pf-field">
                            <?php if ($widgetEdit = $field->widgetEdit($profile)): ?>
                                <label class="pf-label"><?= CHtml::encode($label) ?></label>
                                <?= $widgetEdit ?>
                            <?php elseif ($field->range): ?>
                                <label class="pf-label"><?= CHtml::encode($label) ?></label>
                                <div class="pf-sel-wrap">
                                    <i class="fa fa-list pf-sel-icon"></i>
                                    <?= CHtml::activeDropDownList($profile, $field->varname,
                                        Profile::range($field->range),
                                        array('class' => 'pf-select')
                                    ) ?>
                                </div>
                            <?php elseif ($field->field_type == 'TEXT'): ?>
                                <label class="pf-label"><?= CHtml::encode($label) ?></label>
                                <?= CHtml::activeTextArea($profile, $field->varname,
                                    array('rows' => 4, 'class' => 'pf-textarea')
                                ) ?>
                            <?php else: ?>
                                <div class="pf-fl">
                                    <input type="text"
                                        class="pf-fl-input"
                                        id="<?= CHtml::activeId($profile, $field->varname) ?>"
                                        name="<?= CHtml::activeName($profile, $field->varname) ?>"
                                        value="<?= CHtml::encode($profile->{$field->varname}) ?>"
                                        maxlength="<?= $field->field_size ? (int)$field->field_size : 255 ?>"
                                        placeholder=" ">
                                    <label class="pf-fl-label" for="<?= CHtml::activeId($profile, $field->varname) ?>">
                                        <?= CHtml::encode($label) ?>
                                    </label>
                                    <i class="fa fa-pencil pf-fl-icon"></i>
                                    <i class="fa fa-check pf-fl-tick"></i>
                                </div>
                            <?php endif; ?>
                            <?= $form->error($profile, $field->varname, array('class' => 'pf-error')) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div><!-- /card-body -->

    <!-- ═══ Footer ═══ -->
    <div class="card-footer">
        <button type="submit" class="pf-submit" id="pf-submit-btn">
            <i class="fa fa-<?= $isNew ? 'user-plus' : 'save' ?>"></i>
            <?= $isNew ? UserModule::t('Create User') : UserModule::t('Update User') ?>
        </button>
        <a href="<?= Yii::app()->createUrl('/user/admin/admin') ?>" class="pf-cancel">
            <i class="fa fa-times"></i> <?= UserModule::t('Cancel') ?>
        </a>
        <span id="pf-spinner">
            <i class="fa fa-spinner fa-spin"></i> Saving&hellip;
        </span>
        <span class="pf-req-note">Fields marked <span>*</span> are required</span>
    </div>

</div><!-- /pf-card -->

<?php $this->endWidget(); ?>

<script>
(function () {
    /* ── Required fields for progress ── */
    var requiredIds = [
        '<?= CHtml::activeId($model, 'username') ?>',
        '<?= CHtml::activeId($model, 'email') ?>',
        <?= $isNew ? "'".CHtml::activeId($model, 'password')."'," : '' ?>
        '<?= CHtml::activeId($model, 'superuser') ?>',
        '<?= CHtml::activeId($model, 'status') ?>'
    ];

    function updateProgress() {
        var filled = 0;
        requiredIds.forEach(function (id) {
            var el = document.getElementById(id);
            if (el && el.value.trim() !== '') filled++;
        });
        var pct = Math.round((filled / requiredIds.length) * 100);
        document.getElementById('pfProg').style.width = pct + '%';
        document.getElementById('pfProgTxt').textContent = pct + '% complete';
    }

    /* ── Field validation state ── */
    function markField(input) {
        var wrap = input.closest('.pf-field');
        if (!wrap) return;
        var required = input.getAttribute('data-pf-required') === '1';
        if (input.value.trim() !== '') {
            wrap.classList.remove('is-invalid');
            wrap.classList.add('is-valid');
        } else if (required) {
            wrap.classList.remove('is-valid');
        } else {
            wrap.classList.remove('is-valid', 'is-invalid');
        }
        updateProgress();
    }

    document.querySelectorAll('.pf-fl-input, .pf-select').forEach(function (el) {
        el.addEventListener('input', function () { markField(this); });
        el.addEventListener('change', function () { markField(this); });
        if (el.value.trim() !== '') markField(el);
    });

    /* ── Section complete state ── */
    function checkSections() {
        var secs = [
            { sec: 'sec-account', ids: ['<?= CHtml::activeId($model, 'username') ?>', '<?= CHtml::activeId($model, 'email') ?>'] },
            { sec: 'sec-access',  ids: ['<?= CHtml::activeId($model, 'superuser') ?>', '<?= CHtml::activeId($model, 'status') ?>'] }
        ];
        secs.forEach(function (s) {
            var done = s.ids.every(function (id) {
                var el = document.getElementById(id);
                return el && el.value.trim() !== '';
            });
            var secEl = document.getElementById(s.sec);
            if (secEl) secEl.classList.toggle('is-complete', done);
        });
    }
    document.querySelectorAll('.pf-fl-input, .pf-select').forEach(function (el) {
        el.addEventListener('change', checkSections);
        el.addEventListener('input',  checkSections);
    });
    checkSections();
    updateProgress();

    /* ── Password show/hide ── */
    var pwBtn = document.getElementById('pf-pw-btn');
    if (pwBtn) {
        pwBtn.addEventListener('click', function () {
            var inp  = document.getElementById('<?= CHtml::activeId($model, 'password') ?>');
            var icon = document.getElementById('pf-pw-icon');
            if (inp.type === 'password') {
                inp.type = 'text';
                icon.className = 'fa fa-eye-slash';
            } else {
                inp.type = 'password';
                icon.className = 'fa fa-eye';
            }
        });
    }

    /* ── Submit ripple + spinner ── */
    var submitBtn = document.getElementById('pf-submit-btn');
    if (submitBtn) {
        submitBtn.addEventListener('click', function (e) {
            var ripple = document.createElement('span');
            ripple.className = 'pf-ripple';
            var r = this.getBoundingClientRect();
            var size = Math.max(r.width, r.height);
            ripple.style.cssText = 'width:'+size+'px;height:'+size+'px;'
                + 'left:'+(e.clientX-r.left-size/2)+'px;'
                + 'top:'+(e.clientY-r.top-size/2)+'px;';
            this.appendChild(ripple);
            setTimeout(function () { ripple.remove(); }, 700);
        });

        document.getElementById('user-form').addEventListener('submit', function () {
            submitBtn.style.display = 'none';
            document.getElementById('pf-spinner').style.display = 'inline-flex';
        });
    }
}());
</script>
