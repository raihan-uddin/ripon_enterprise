<?php
$isNew = $model->isNewRecord;

$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'users-form',
    'action'               => $this->createUrl('users/create'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions'        => array('validateOnSubmit' => true),
));
?>
<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<style>
/* ══════════════════════════════════════════
   Users Form (create) — pf-card design
══════════════════════════════════════════ */
.pf-card{border:none;border-radius:16px;overflow:hidden;
    box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);}
.pf-card>.card-header{
    background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);
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
.pf-hd-chips{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px;position:relative;z-index:1;}
.pf-chip{display:inline-flex;align-items:center;gap:5px;
    padding:4px 10px;border-radius:99px;font-size:11px;font-weight:600;
    background:rgba(255,255,255,.15);color:rgba(255,255,255,.85);
    border:1px solid rgba(255,255,255,.2);transition:background .2s;}
.pf-chip.done{background:rgba(255,255,255,.28);color:#fff;}
.pf-chip i{font-size:10px;}
.pf-prog{display:flex;align-items:center;gap:10px;margin-top:10px;position:relative;z-index:1;}
.pf-prog-bg{flex:1;height:4px;border-radius:99px;background:rgba(255,255,255,.2);overflow:hidden;}
.pf-prog-fill{height:100%;border-radius:99px;background:#fff;
    transition:width .4s cubic-bezier(.4,0,.2,1);width:0%;}
.pf-prog-txt{font-size:11px;color:rgba(255,255,255,.75);font-weight:600;white-space:nowrap;}
.pf-card>.card-body{padding:0;background:#fff;}
.pf-section{padding:24px 28px;border-bottom:1px solid #f1f5f9;transition:background .2s;}
.pf-section:last-child{border-bottom:none;}
.pf-section:hover{background:#fafbff;}
.pf-sec-hd{display:flex;align-items:center;gap:12px;margin-bottom:18px;}
.pf-step-badge{
    width:30px;height:30px;border-radius:50%;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    background:#eef2ff;color:#6366f1;font-size:12px;font-weight:800;
    border:2px solid #c7d2fe;
    transition:all .3s cubic-bezier(.34,1.56,.64,1);}
.pf-section.is-complete .pf-step-badge{
    background:#6366f1;color:#fff;border-color:#6366f1;
    box-shadow:0 0 0 4px rgba(99,102,241,.18);}
.pf-sec-info{flex:1;}
.pf-sec-title{font-size:13.5px;font-weight:700;color:#1e293b;line-height:1.2;}
.pf-sec-sub{font-size:11px;color:#94a3b8;margin-top:2px;}
.pf-sec-body{background:#f8faff;border:1px solid #eef2ff;border-radius:12px;padding:18px 16px;}
.pf-fl{position:relative;margin-bottom:0;}
.pf-fl-input{
    width:100%;border:1.5px solid #e2e8f0;border-radius:8px;
    padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;
    outline:none;background:#fff;line-height:1.4;
    transition:border-color .18s,box-shadow .18s,transform .15s;
    -webkit-appearance:none;}
.pf-fl-input:focus{
    border-color:#6366f1;
    box-shadow:0 0 0 3.5px rgba(99,102,241,.12);
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
    font-size:9.5px;font-weight:700;color:#6366f1;
    letter-spacing:.5px;text-transform:uppercase;}
.pf-fl-icon{
    position:absolute;left:12px;top:50%;transform:translateY(-50%);
    color:#cbd5e1;font-size:13px;pointer-events:none;transition:color .18s;}
.pf-fl:focus-within .pf-fl-icon{color:#6366f1;}
.pf-fl-tick{
    position:absolute;right:10px;top:50%;transform:translateY(-50%);
    font-size:12px;pointer-events:none;opacity:0;transition:opacity .2s;}
.pf-field.is-valid .pf-fl-tick{opacity:1;color:#22c55e;}
.pf-field.is-invalid .pf-fl-input{border-color:#ef4444;}
.pf-pw-toggle{
    position:absolute;right:10px;top:50%;transform:translateY(-50%);
    background:none;border:none;cursor:pointer;
    color:#94a3b8;font-size:13px;padding:4px;transition:color .15s;line-height:1;}
.pf-pw-toggle:hover{color:#6366f1;}
.pf-fl.has-toggle .pf-fl-tick{right:34px;}
.pf-hint{font-size:11px;color:#94a3b8;margin-top:4px;display:block;}
.pf-label{
    display:flex;align-items:center;gap:5px;
    font-size:11.5px;font-weight:700;color:#475569;
    margin-bottom:6px;text-transform:uppercase;letter-spacing:.4px;
    transition:color .15s;}
.pf-label .req{color:#ef4444;}
.pf-field:focus-within .pf-label{color:#6366f1;}
.pf-field{margin-bottom:14px;}
.pf-field:last-child{margin-bottom:0;}
.pf-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block;}
@keyframes pfShake{
    0%,100%{transform:translateX(0);}
    20%{transform:translateX(-5px);}
    40%{transform:translateX(5px);}
    60%{transform:translateX(-4px);}
    80%{transform:translateX(4px);}
}
.pf-shake{animation:pfShake .4s ease;}
.pf-card>.card-footer{
    background:#f8fafc;border-top:1px solid #f1f5f9;
    padding:16px 28px;display:flex;align-items:center;gap:10px;}
.pf-req-note{margin-left:auto;font-size:11.5px;color:#94a3b8;}
.pf-req-note span{color:#ef4444;font-weight:700;}
.pf-submit{
    position:relative;overflow:hidden;
    display:inline-flex;align-items:center;gap:8px;
    padding:11px 26px;border-radius:9px;font-size:14px;font-weight:700;
    background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;
    cursor:pointer;letter-spacing:-.1px;
    box-shadow:0 4px 14px rgba(99,102,241,.4);
    transition:box-shadow .18s,transform .15s;}
.pf-submit:hover{box-shadow:0 6px 20px rgba(99,102,241,.5);transform:translateY(-2px);}
.pf-submit:active{transform:translateY(0);}
.pf-ripple{
    position:absolute;border-radius:50%;
    background:rgba(255,255,255,.38);transform:scale(0);
    animation:pfRipple .6s linear;pointer-events:none;}
@keyframes pfRipple{to{transform:scale(4);opacity:0;}}
#pf-spinner{display:none;align-items:center;gap:7px;color:#6366f1;font-size:13px;}

/* Roles select2 wrapper */
.pf-roles-wrap{border:1.5px solid #e2e8f0;border-radius:8px;padding:8px 10px;background:#fff;
    transition:border-color .18s,box-shadow .18s;}
.pf-roles-wrap:focus-within{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12);}
.pf-roles-wrap .select2-container{width:100%!important;}
</style>

<div class="card pf-card">

    <!-- ═══ Header ═══ -->
    <div class="card-header">
        <div class="pf-hd-top">
            <div class="pf-hd-title">
                <div class="pf-hd-title-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    Add New User
                    <div class="pf-hd-sub">Fill all required fields to create the user account</div>
                </div>
            </div>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="pf-hd-chips">
            <span class="pf-chip" id="chip-account"><i class="fas fa-user"></i> Account</span>
            <?php if (Yii::app()->user->isSuperuser): ?>
            <span class="pf-chip" id="chip-roles"><i class="fas fa-shield"></i> Roles</span>
            <?php endif; ?>
        </div>
        <div class="pf-prog">
            <div class="pf-prog-bg"><div class="pf-prog-fill" id="pfProg"></div></div>
            <span class="pf-prog-txt" id="pfProgTxt">0% complete</span>
        </div>
    </div>

    <div class="card-body">

        <!-- ═══ Section 1 — Account ═══ -->
        <div class="pf-section" id="sec-account">
            <div class="pf-sec-hd">
                <div class="pf-step-badge">1</div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Account Credentials</div>
                    <div class="pf-sec-sub">Set up the username and password for this user</div>
                </div>
            </div>
            <div class="pf-sec-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="pf-field" id="field-username">
                            <div class="pf-fl">
                                <?= CHtml::activeTextField($model, 'username', array(
                                    'class'       => 'pf-fl-input',
                                    'maxlength'   => 20,
                                    'placeholder' => ' ',
                                    'autocomplete'=> 'off',
                                    'data-pf-required' => '1',
                                )) ?>
                                <label class="pf-fl-label" for="<?= CHtml::activeId($model, 'username') ?>">
                                    Username <span class="req">*</span>
                                </label>
                                <i class="fas fa-user pf-fl-icon"></i>
                                <i class="fas fa-check pf-fl-tick"></i>
                            </div>
                            <span class="pf-error"><?= $form->error($model, 'username') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pf-field" id="field-password">
                            <div class="pf-fl has-toggle">
                                <?= CHtml::activePasswordField($model, 'password', array(
                                    'class'       => 'pf-fl-input',
                                    'maxlength'   => 20,
                                    'placeholder' => ' ',
                                    'data-pf-required' => '1',
                                    'id'          => 'uf-password',
                                )) ?>
                                <label class="pf-fl-label" for="uf-password">
                                    Password <span class="req">*</span>
                                </label>
                                <i class="fas fa-lock pf-fl-icon"></i>
                                <button type="button" class="pf-pw-toggle" id="pf-pw-btn1" tabindex="-1">
                                    <i class="fas fa-eye" id="pf-pw-icon1"></i>
                                </button>
                                <i class="fas fa-check pf-fl-tick"></i>
                            </div>
                            <span class="pf-error"><?= $form->error($model, 'password') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pf-field" id="field-password2">
                            <div class="pf-fl has-toggle">
                                <?= CHtml::activePasswordField($model, 'password2', array(
                                    'class'       => 'pf-fl-input',
                                    'maxlength'   => 20,
                                    'placeholder' => ' ',
                                    'data-pf-required' => '1',
                                    'id'          => 'uf-password2',
                                )) ?>
                                <label class="pf-fl-label" for="uf-password2">
                                    Confirm Password <span class="req">*</span>
                                </label>
                                <i class="fas fa-lock pf-fl-icon"></i>
                                <button type="button" class="pf-pw-toggle" id="pf-pw-btn2" tabindex="-1">
                                    <i class="fas fa-eye" id="pf-pw-icon2"></i>
                                </button>
                                <i class="fas fa-check pf-fl-tick"></i>
                            </div>
                            <span class="pf-error"><?= $form->error($model, 'password2') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (Yii::app()->user->isSuperuser): ?>
        <!-- ═══ Section 2 — Roles ═══ -->
        <div class="pf-section" id="sec-roles">
            <div class="pf-sec-hd">
                <div class="pf-step-badge">2</div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Role Assignment</div>
                    <div class="pf-sec-sub">Assign one or more roles to control permissions</div>
                </div>
            </div>
            <div class="pf-sec-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="pf-field">
                            <label class="pf-label"><i class="fas fa-shield"></i> Roles</label>
                            <div class="pf-roles-wrap">
                                <?php
                                $all_roles = new RAuthItemDataProvider('roles', array('type' => 2));
                                $data = $all_roles->fetchData();
                                $this->widget('ext.select2.ESelect2', array(
                                    'name'        => 'roles',
                                    'data'        => CHtml::listData($data, 'name', 'name'),
                                    'htmlOptions' => array(
                                        'multiple'   => 'multiple',
                                        'width'      => '100%',
                                        'allowClear' => true,
                                    ),
                                    'options' => array(
                                        'placeholder' => 'Select roles…',
                                        'width'       => '100%',
                                        'allowClear'  => true,
                                    ),
                                ));
                                ?>
                            </div>
                            <span class="pf-error"><?= $form->error($model, 'roles') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div><!-- /card-body -->

    <!-- ═══ Footer ═══ -->
    <div class="card-footer">
        <?= CHtml::ajaxSubmitButton(
            '<i class="fas fa-user-plus"></i> Add User',
            CHtml::normalizeUrl(array('users/create', 'render' => true)),
            array(
                'dataType'   => 'json',
                'type'       => 'post',
                'beforeSend' => 'function(){
                    $("#ajaxLoader").show();
                    document.getElementById("pf-submit-btn").style.display = "none";
                    document.getElementById("pf-spinner").style.display = "inline-flex";
                }',
                'success' => 'function(data) {
                    $("#ajaxLoader").hide();
                    document.getElementById("pf-submit-btn").style.display = "";
                    document.getElementById("pf-spinner").style.display = "none";
                    if(data.status=="success"){
                        afterSaveClearSelect2();
                        toastr.success("User created successfully.");
                        $("#users-form")[0].reset();
                        $.fn.yiiGridView.update("users-grid", {
                            data: $(this).serialize()
                        });
                    } else {
                        $.each(data, function(key, val) {
                            $("#users-form #"+key+"_em_").html(""+val+"").show();
                        });
                        toastr.error("Please fix the errors and try again.");
                    }
                }',
            ),
            array(
                'id'    => 'pf-submit-btn',
                'class' => 'pf-submit',
            )
        ) ?>
        <span id="pf-spinner" style="display:none; align-items:center; gap:7px; color:#6366f1; font-size:13px;">
            <i class="fas fa-spinner fa-spin"></i> Saving&hellip;
        </span>
        <span class="pf-req-note">Fields marked <span>*</span> are required</span>
    </div>

</div><!-- /pf-card -->

<?php $this->endWidget(); ?>

<script>
(function () {
    var requiredIds = [
        '<?= CHtml::activeId($model, 'username') ?>',
        'uf-password',
        'uf-password2'
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

    document.querySelectorAll('.pf-fl-input').forEach(function (el) {
        el.addEventListener('input', function () { markField(this); });
        el.addEventListener('change', function () { markField(this); });
        if (el.value.trim() !== '') markField(el);
    });

    function checkSections() {
        var accountDone = requiredIds.every(function (id) {
            var el = document.getElementById(id);
            return el && el.value.trim() !== '';
        });
        var secEl = document.getElementById('sec-account');
        if (secEl) secEl.classList.toggle('is-complete', accountDone);
        var chip = document.getElementById('chip-account');
        if (chip) chip.classList.toggle('done', accountDone);
    }
    document.querySelectorAll('.pf-fl-input').forEach(function (el) {
        el.addEventListener('change', checkSections);
        el.addEventListener('input', checkSections);
    });
    checkSections();
    updateProgress();

    /* Password toggles */
    [['pf-pw-btn1', 'uf-password', 'pf-pw-icon1'],
     ['pf-pw-btn2', 'uf-password2', 'pf-pw-icon2']].forEach(function (trio) {
        var btn  = document.getElementById(trio[0]);
        var inp  = document.getElementById(trio[1]);
        var icon = document.getElementById(trio[2]);
        if (btn && inp && icon) {
            btn.addEventListener('click', function () {
                if (inp.type === 'password') {
                    inp.type = 'text';
                    icon.className = 'fas fa-eye-slash';
                } else {
                    inp.type = 'password';
                    icon.className = 'fas fa-eye';
                }
            });
        }
    });

    /* Ripple on submit */
    var submitBtn = document.getElementById('pf-submit-btn');
    if (submitBtn) {
        submitBtn.addEventListener('click', function (e) {
            var ripple = document.createElement('span');
            ripple.className = 'pf-ripple';
            var r    = this.getBoundingClientRect();
            var size = Math.max(r.width, r.height);
            ripple.style.cssText = 'width:'+size+'px;height:'+size+'px;'
                + 'left:'+(e.clientX - r.left - size/2)+'px;'
                + 'top:'+(e.clientY - r.top  - size/2)+'px;';
            this.appendChild(ripple);
            setTimeout(function () { ripple.remove(); }, 700);
        });
    }
}());

function afterSaveClearSelect2() {
    $('#roles').val(null).trigger('change');
}

$(document).ready(function () {
    $(document).on('focus', ':input', function () {
        $(this).attr('autocomplete', 'off');
    });
});
</script>
