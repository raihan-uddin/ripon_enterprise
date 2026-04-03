<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'crm-bank-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>

<style>
/* ── cb- design system (crmBank _form3) ────────────────────────── */
.cb-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,.04), 0 12px 36px rgba(0,0,0,.10);
    margin-bottom: 0;
}

/* Header */
.cb-card .cb-header {
    position: relative;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    padding: 16px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    overflow: hidden;
}
.cb-card .cb-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,.18) 1.2px, transparent 1.2px);
    background-size: 22px 22px;
    pointer-events: none;
}
.cb-card .cb-header::after {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: rgba(255,255,255,.07);
    pointer-events: none;
}
.cb-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    z-index: 1;
}
.cb-header-icon {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    background: rgba(255,255,255,.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 14px;
    flex-shrink: 0;
}
.cb-header-title {
    color: #fff;
    font-size: 16px;
    font-weight: 800;
    margin: 0;
    line-height: 1.2;
}
.cb-header-subtitle {
    color: rgba(255,255,255,.65);
    font-size: 11.5px;
    margin: 2px 0 0;
    line-height: 1;
}
.cb-card-tools {
    position: relative;
    z-index: 1;
}
.cb-card-tools .btn-tool {
    color: rgba(255,255,255,.6);
    background: none;
    border: none;
    padding: 2px 6px;
    line-height: 1;
    transition: color .15s;
}
.cb-card-tools .btn-tool:hover {
    color: #fff;
}

/* Body */
.cb-card .cb-body {
    padding: 20px 24px;
    background: #fff;
}

/* Footer */
.cb-card .cb-footer {
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
    padding: 12px 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Floating label wrapper */
.cb-fl {
    position: relative;
    margin-bottom: 16px;
}
.cb-fl-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #cbd5e1;
    font-size: 13px;
    pointer-events: none;
    transition: color .2s;
    z-index: 2;
}
.cb-fl-input {
    width: 100%;
    padding: 18px 12px 6px 38px;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    font-size: 13.5px;
    color: #1e293b;
    background: #fff;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    display: block;
    box-sizing: border-box;
}
.cb-fl-input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3.5px rgba(99,102,241,.12);
}
.cb-fl-input:focus ~ .cb-fl-icon,
.cb-fl:focus-within .cb-fl-icon {
    color: #6366f1;
}
.cb-fl-label {
    position: absolute;
    left: 38px;
    top: 13px;
    font-size: 13px;
    color: #94a3b8;
    pointer-events: none;
    transition: top .18s, font-size .18s, color .18s;
    z-index: 2;
    line-height: 1;
}
.cb-fl-input:focus + .cb-fl-label,
.cb-fl-input:not(:placeholder-shown) + .cb-fl-label {
    top: 5px;
    font-size: 9.5px;
    color: #6366f1;
    font-weight: 700;
    letter-spacing: .4px;
    text-transform: uppercase;
}

/* Error */
.cb-error {
    display: block;
    color: #ef4444;
    font-size: 11.5px;
    margin-top: 5px;
}

/* Submit button */
.cb-submit {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #6366f1, #7c3aed);
    color: #fff;
    border: none;
    border-radius: 9px;
    padding: 9px 22px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(99,102,241,.4);
    transition: opacity .15s, transform .1s;
    letter-spacing: .2px;
}
.cb-submit:hover { opacity: .92; }
.cb-submit:active { transform: scale(.97); }

/* Ripple */
.cb-ripple {
    position: absolute;
    border-radius: 50%;
    transform: scale(0);
    background: rgba(255,255,255,.35);
    animation: cb-ripple-anim .55s linear;
    pointer-events: none;
}
@keyframes cb-ripple-anim {
    to { transform: scale(4); opacity: 0; }
}
</style>

<div class="cb-card">
    <div class="cb-header">
        <div class="cb-header-left">
            <div class="cb-header-icon">
                <i class="fa fa-university"></i>
            </div>
            <div>
                <div class="cb-header-title"><?php echo($model->isNewRecord ? 'Add New Bank' : 'Update Bank: ' . CHtml::encode($model->name)); ?></div>
                <div class="cb-header-subtitle"><?php echo($model->isNewRecord ? 'Register a new bank account' : 'Edit bank account details'); ?></div>
            </div>
        </div>
        <div class="cb-card-tools card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="cb-body">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-6">
                <div class="cb-fl">
                    <?php echo $form->textField($model, 'name', array(
                        'maxlength' => 255,
                        'class'       => 'cb-fl-input',
                        'placeholder' => ' ',
                        'id'          => 'CrmBank_name',
                    )); ?>
                    <label class="cb-fl-label" for="CrmBank_name">Bank Name</label>
                    <i class="fa fa-university cb-fl-icon"></i>
                    <?php echo $form->error($model, 'name', array('class' => 'cb-error')); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="cb-footer">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('onclick' => 'loadingDivDisplay();', 'class' => 'cb-submit')); ?>
        <span id="ajaxLoaderMR2" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>
    </div>
    <script type="text/javascript">
        function loadingDivDisplay() {
            $("#ajaxLoaderMR2").show();
        }
    </script>
</div>

<script>
(function () {
    document.querySelectorAll('.cb-submit').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var rect = btn.getBoundingClientRect();
            var ripple = document.createElement('span');
            ripple.className = 'cb-ripple';
            var size = Math.max(rect.width, rect.height);
            ripple.style.cssText = 'width:'+size+'px;height:'+size+'px;left:'+(e.clientX-rect.left-size/2)+'px;top:'+(e.clientY-rect.top-size/2)+'px';
            btn.appendChild(ripple);
            ripple.addEventListener('animationend', function () { ripple.remove(); });
        });
    });
})();
</script>

<?php $this->endWidget(); ?>
