<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'customers-form',
    'action' => $this->createUrl('customers/create'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>
<style>
    .hidden { display: none; }

    /* ── Card shell ── */
    .cu-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,.04), 0 12px 36px rgba(0,0,0,.10);
        margin-bottom: 0;
    }

    /* ── Header ── */
    .cu-card .card-header {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border: none;
        padding: 18px 22px;
        position: relative;
        overflow: hidden;
    }
    .cu-card .card-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,.18) 1.2px, transparent 1.2px);
        background-size: 22px 22px;
        pointer-events: none;
    }
    .cu-card .card-header::after {
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
    .cu-header-inner {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .cu-header-icon {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: rgba(255,255,255,.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #fff;
        font-size: 14px;
    }
    .cu-header-title {
        color: #fff;
        font-size: 16px;
        font-weight: 800;
        margin: 0;
        line-height: 1.2;
    }
    .cu-header-subtitle {
        color: rgba(255,255,255,.65);
        font-size: 11.5px;
        margin: 2px 0 0;
        line-height: 1;
    }
    .cu-card .card-tools {
        position: relative;
        z-index: 1;
    }
    .cu-card .card-tools .btn-tool {
        color: rgba(255,255,255,.6);
        transition: color .15s;
    }
    .cu-card .card-tools .btn-tool:hover {
        color: #fff;
    }

    /* ── Card body ── */
    .cu-card .card-body {
        padding: 22px 26px;
        background: #fff;
    }

    /* ── Card footer ── */
    .cu-card .card-footer {
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        padding: 14px 26px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ── Floating label wrapper ── */
    .cu-fl {
        position: relative;
        margin-bottom: 0;
    }
    .cu-fl-input {
        width: 100%;
        padding: 18px 12px 6px 38px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        color: #1e293b;
        background: #fff;
        outline: none;
        transition: border-color .18s, box-shadow .18s;
        box-sizing: border-box;
        line-height: 1.4;
    }
    .cu-fl-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3.5px rgba(99,102,241,.12);
    }
    .cu-fl-label {
        position: absolute;
        left: 38px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 13px;
        color: #94a3b8;
        pointer-events: none;
        transition: top .15s, font-size .15s, color .15s, transform .15s;
        line-height: 1;
    }
    .cu-fl-input:focus + .cu-fl-label,
    .cu-fl-input:not(:placeholder-shown) + .cu-fl-label {
        top: 5px;
        transform: none;
        font-size: 9.5px;
        color: #6366f1;
        font-weight: 700;
        letter-spacing: .4px;
        text-transform: uppercase;
    }
    .cu-fl-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #cbd5e1;
        font-size: 12px;
        pointer-events: none;
        transition: color .18s;
        line-height: 1;
    }
    .cu-fl:focus-within .cu-fl-icon {
        color: #6366f1;
    }

    /* ── Error ── */
    .cu-error {
        display: block;
        color: #ef4444;
        font-size: 11.5px;
        margin-top: 5px;
        min-height: 0;
    }
    .cu-error:empty { display: none; }

    /* ── Submit button ── */
    .cu-submit {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #6366f1, #7c3aed);
        color: #fff;
        border: none;
        border-radius: 9px;
        padding: 9px 24px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 4px 14px rgba(99,102,241,.4);
        cursor: pointer;
        transition: opacity .2s, box-shadow .2s;
        letter-spacing: .3px;
    }
    .cu-submit:hover {
        opacity: .92;
        box-shadow: 0 6px 18px rgba(99,102,241,.5);
    }
    .cu-submit:active { opacity: .85; }

    /* ── Ripple ── */
    .cu-ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,.35);
        transform: scale(0);
        animation: cu-ripple-anim .55s linear;
        pointer-events: none;
    }
    @keyframes cu-ripple-anim {
        to { transform: scale(4); opacity: 0; }
    }

    /* ── Row gap ── */
    .cu-row-gap > [class*="col-"] {
        margin-bottom: 16px;
    }
</style>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<div class="card cu-card">
    <div class="card-header">
        <div class="cu-header-inner">
            <div class="cu-header-icon">
                <i class="fa fa-user-plus"></i>
            </div>
            <div>
                <div class="cu-header-title"><?php echo($model->isNewRecord ? 'Add New Customer' : 'Update Customer'); ?></div>
                <div class="cu-header-subtitle"><?php echo($model->isNewRecord ? 'Fill in the details below to register a customer' : 'Edit the customer information below'); ?></div>
            </div>
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row cu-row-gap">

            <div class="col-sm-6 col-md-3">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'company_name', array(
                        'maxlength' => 255,
                        'class'     => 'cu-fl-input',
                        'placeholder' => ' ',
                    )); ?>
                    <label class="cu-fl-label">Company Name <span style="color:#ef4444">*</span></label>
                    <span class="cu-fl-icon"><i class="fa fa-building-o"></i></span>
                </div>
                <?php echo $form->error($model, 'company_name', array('class' => 'cu-error')); ?>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'owner_person', array(
                        'maxlength' => 255,
                        'class'     => 'cu-fl-input',
                        'placeholder' => ' ',
                    )); ?>
                    <label class="cu-fl-label">Owner / Contact Person</label>
                    <span class="cu-fl-icon"><i class="fa fa-user-o"></i></span>
                </div>
                <?php echo $form->error($model, 'owner_person', array('class' => 'cu-error')); ?>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'owner_mobile_no', array(
                        'maxlength' => 255,
                        'class'     => 'cu-fl-input',
                        'placeholder' => ' ',
                    )); ?>
                    <label class="cu-fl-label">Mobile Number</label>
                    <span class="cu-fl-icon"><i class="fa fa-phone"></i></span>
                </div>
                <?php echo $form->error($model, 'owner_mobile_no', array('class' => 'cu-error')); ?>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'company_address', array(
                        'maxlength'   => 255,
                        'class'       => 'cu-fl-input',
                        'placeholder' => ' ',
                    )); ?>
                    <label class="cu-fl-label">Company Address</label>
                    <span class="cu-fl-icon"><i class="fa fa-map-marker"></i></span>
                </div>
                <?php echo $form->error($model, 'company_address', array('class' => 'cu-error')); ?>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'opening_amount', array(
                        'maxlength' => 255,
                        'class'     => 'cu-fl-input',
                        'placeholder' => ' ',
                    )); ?>
                    <label class="cu-fl-label">Opening Balance</label>
                    <span class="cu-fl-icon"><i class="fa fa-money"></i></span>
                </div>
                <?php echo $form->error($model, 'opening_amount', array('class' => 'cu-error')); ?>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'company_email', array(
                        'maxlength' => 255,
                        'class'     => 'cu-fl-input',
                        'placeholder' => ' ',
                    )); ?>
                    <label class="cu-fl-label">Email Address</label>
                    <span class="cu-fl-icon"><i class="fa fa-envelope-o"></i></span>
                </div>
                <?php echo $form->error($model, 'company_email', array('class' => 'cu-error')); ?>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'company_web', array(
                        'maxlength' => 255,
                        'class'     => 'cu-fl-input',
                        'placeholder' => ' ',
                    )); ?>
                    <label class="cu-fl-label">Website</label>
                    <span class="cu-fl-icon"><i class="fa fa-globe"></i></span>
                </div>
                <?php echo $form->error($model, 'company_web', array('class' => 'cu-error')); ?>
            </div>

            <!-- hidden fields – kept in DOM exactly as before -->
            <div class="col-sm-6 col-md-3 hidden">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'zip', array('maxlength' => 255, 'class' => 'cu-fl-input', 'placeholder' => ' ')); ?>
                    <label class="cu-fl-label">ZIP Code</label>
                    <span class="cu-fl-icon"><i class="fa fa-hashtag"></i></span>
                </div>
                <?php echo $form->error($model, 'zip', array('class' => 'cu-error')); ?>
            </div>

            <div class="col-sm-6 col-md-3 hidden">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'state', array('maxlength' => 255, 'class' => 'cu-fl-input', 'placeholder' => ' ')); ?>
                    <label class="cu-fl-label">State</label>
                    <span class="cu-fl-icon"><i class="fa fa-map-o"></i></span>
                </div>
                <?php echo $form->error($model, 'state', array('class' => 'cu-error')); ?>
            </div>

            <div class="col-sm-6 col-md-3 hidden">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'city', array('maxlength' => 255, 'class' => 'cu-fl-input', 'placeholder' => ' ')); ?>
                    <label class="cu-fl-label">City</label>
                    <span class="cu-fl-icon"><i class="fa fa-map-pin"></i></span>
                </div>
                <?php echo $form->error($model, 'city', array('class' => 'cu-error')); ?>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="cu-fl">
                    <?php echo $form->textField($model, 'trn_no', array(
                        'maxlength' => 255,
                        'class'     => 'cu-fl-input',
                        'placeholder' => ' ',
                    )); ?>
                    <label class="cu-fl-label">TRN No.</label>
                    <span class="cu-fl-icon"><i class="fa fa-id-card-o"></i></span>
                </div>
                <?php echo $form->error($model, 'trn_no', array('class' => 'cu-error')); ?>
            </div>

        </div><!-- /.row -->
    </div><!-- /.card-body -->

    <div class="card-footer">
        <?php
        echo CHtml::ajaxSubmitButton('Save Customer', CHtml::normalizeUrl(array('customers/create', 'render' => true)), array(
            'dataType' => 'json',
            'type'     => 'post',
            'success'  => 'function(data) {
                $("#ajaxLoader").hide();
                if (data.status == "success") {
                    $("#formResult").fadeIn();
                    $("#formResult").html("Data saved successfully.");
                    toastr.success("Data saved successfully.");
                    $("#customers-form")[0].reset();
                    $("#formResult").animate({opacity:1.0}, 1000).fadeOut("slow");
                    $.fn.yiiGridView.update("customers-grid", {
                        data: $(this).serialize()
                    });
                } else {
                    $.each(data, function(key, val) {
                        $("#prod-items-form #" + key + "_em_").html("" + val + "");
                        $("#prod-items-form #" + key + "_em_").show();
                    });
                }
            }',
            'beforeSend' => 'function() {
                $("#ajaxLoader").show();
            }',
        ), array('class' => 'cu-submit'));
        ?>

        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display:none;">
            <i class="fa fa-spinner fa-spin fa-2x" style="color:#6366f1;"></i>
        </span>

        <div id="formResult" class="ajaxTargetDiv"></div>
        <div id="formResultError" class="ajaxTargetDivErr"></div>
    </div><!-- /.card-footer -->
</div><!-- /.cu-card -->

<script>
(function () {
    /* Ripple effect on submit button */
    document.querySelectorAll('.cu-submit').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var rect = btn.getBoundingClientRect();
            var r = document.createElement('span');
            var d = Math.max(rect.width, rect.height);
            r.className = 'cu-ripple';
            r.style.cssText = 'width:' + d + 'px;height:' + d + 'px;left:' + (e.clientX - rect.left - d / 2) + 'px;top:' + (e.clientY - rect.top - d / 2) + 'px;';
            btn.appendChild(r);
            r.addEventListener('animationend', function () { r.remove(); });
        });
    });
})();
</script>

<?php $this->endWidget(); ?>
