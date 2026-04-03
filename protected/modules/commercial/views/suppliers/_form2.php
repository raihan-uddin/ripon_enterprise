<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'suppliers-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>

<style>
/* ── Supplier Form 2 (Update/Dialog) : Indigo Palette ── */
.su-card{border:none;border-radius:16px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);margin-bottom:20px}
.su-card-header{background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);padding:16px 22px;position:relative;overflow:hidden}
.su-card-header::before{content:'';position:absolute;inset:0;background:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);background-size:22px 22px;pointer-events:none}
.su-card-header::after{content:'';position:absolute;top:-50px;right:-50px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.07);pointer-events:none}
.su-header-row{display:flex;align-items:center;gap:12px;position:relative;z-index:1}
.su-header-icon{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;flex-shrink:0}
.su-header-text .su-title{font-size:16px;font-weight:800;color:#fff;margin:0;line-height:1.3}
.su-header-text .su-subtitle{font-size:11.5px;color:rgba(255,255,255,.65);margin:0;line-height:1.4}
.su-card-body{padding:18px 22px;background:#fff}
.su-card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;padding:12px 22px;display:flex;align-items:center;gap:10px}

/* ── Floating label fields ── */
.su-fl{position:relative;margin-bottom:16px}
.su-fl-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#cbd5e1;font-size:13px;transition:color .2s;z-index:2;pointer-events:none}
.su-fl-input,
.su-fl textarea.su-fl-input{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;background:#fff;outline:none;transition:border-color .2s,box-shadow .2s;box-sizing:border-box}
.su-fl textarea.su-fl-input{min-height:72px;resize:vertical}
.su-fl-label{position:absolute;left:38px;top:50%;transform:translateY(-50%);font-size:13px;color:#94a3b8;pointer-events:none;transition:all .2s cubic-bezier(.4,0,.2,1);background:transparent;padding:0 4px;line-height:1;z-index:1}
.su-fl--ta .su-fl-label{top:18px;transform:none}
.su-fl--ta .su-fl-icon{top:18px;transform:none}

/* Focus + filled states */
.su-fl-input:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}
.su-fl-input:focus ~ .su-fl-icon,
.su-fl:focus-within .su-fl-icon{color:#6366f1}
.su-fl-input:focus ~ .su-fl-label,
.su-fl-input:not(:placeholder-shown) ~ .su-fl-label{top:5px;transform:none;font-size:9.5px;font-weight:700;color:#6366f1;background:#fff}

/* Error */
.su-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block}

/* ── Submit button + ripple ── */
.su-submit{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;border-radius:9px;padding:10px 28px;font-size:13.5px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);position:relative;overflow:hidden;transition:transform .15s,box-shadow .15s}
.su-submit:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(99,102,241,.45)}
.su-submit:active{transform:translateY(0)}
.su-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.35);transform:scale(0);animation:su-ripple-anim .5s ease-out}
@keyframes su-ripple-anim{to{transform:scale(4);opacity:0}}

/* ── Grid helpers ── */
.su-row{display:flex;flex-wrap:wrap;gap:0 18px}
.su-col-4{flex:0 0 calc(33.333% - 12px);max-width:calc(33.333% - 12px)}
.su-col-6{flex:0 0 calc(50% - 9px);max-width:calc(50% - 9px)}
.su-col-12{flex:0 0 100%;max-width:100%}
@media(max-width:991px){.su-col-4{flex:0 0 calc(50% - 9px);max-width:calc(50% - 9px)}}
@media(max-width:575px){.su-col-4,.su-col-6{flex:0 0 100%;max-width:100%}}
</style>

<div class="su-card">
    <!-- Header -->
    <div class="su-card-header">
        <div class="su-header-row">
            <div class="su-header-icon"><i class="fas fa-truck"></i></div>
            <div class="su-header-text">
                <p class="su-title"><?php echo($model->isNewRecord ? 'Add New Supplier' : 'Update Supplier'); ?></p>
                <p class="su-subtitle">Modify the supplier information below</p>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="su-card-body">
        <div class="su-row">

            <!-- Company Name -->
            <div class="su-col-4">
                <div class="su-fl">
                    <i class="fas fa-building su-fl-icon"></i>
                    <?php echo $form->textField($model, 'company_name', array('maxlength' => 255, 'class' => 'su-fl-input', 'placeholder' => ' ')); ?>
                    <label class="su-fl-label">Company Name <span style="color:#ef4444">*</span></label>
                    <?php echo $form->error($model, 'company_name', array('class' => 'su-error')); ?>
                </div>
            </div>

            <!-- Contact No -->
            <div class="su-col-4">
                <div class="su-fl">
                    <i class="fas fa-phone su-fl-icon"></i>
                    <?php echo $form->textField($model, 'company_contact_no', array('maxlength' => 255, 'class' => 'su-fl-input', 'placeholder' => ' ')); ?>
                    <label class="su-fl-label">Contact Number</label>
                    <?php echo $form->error($model, 'company_contact_no', array('class' => 'su-error')); ?>
                </div>
            </div>

            <!-- Opening Amount -->
            <div class="su-col-4">
                <div class="su-fl">
                    <i class="fas fa-money-bill su-fl-icon"></i>
                    <?php echo $form->textField($model, 'opening_amount', array('maxlength' => 255, 'class' => 'su-fl-input', 'placeholder' => ' ')); ?>
                    <label class="su-fl-label">Opening Amount</label>
                    <?php echo $form->error($model, 'contact_number_2', array('class' => 'su-error')); ?>
                </div>
            </div>

            <!-- Fax -->
            <div class="su-col-4">
                <div class="su-fl">
                    <i class="fas fa-fax su-fl-icon"></i>
                    <?php echo $form->textField($model, 'company_fax', array('maxlength' => 255, 'class' => 'su-fl-input', 'placeholder' => ' ')); ?>
                    <label class="su-fl-label">Fax Number</label>
                    <?php echo $form->error($model, 'company_fax', array('class' => 'su-error')); ?>
                </div>
            </div>

            <!-- Email -->
            <div class="su-col-4">
                <div class="su-fl">
                    <i class="fas fa-envelope su-fl-icon"></i>
                    <?php echo $form->textField($model, 'company_email', array('maxlength' => 255, 'class' => 'su-fl-input', 'placeholder' => ' ')); ?>
                    <label class="su-fl-label">Email Address</label>
                    <?php echo $form->error($model, 'company_email', array('class' => 'su-error')); ?>
                </div>
            </div>

            <!-- Website -->
            <div class="su-col-4">
                <div class="su-fl">
                    <i class="fas fa-globe su-fl-icon"></i>
                    <?php echo $form->textField($model, 'company_web', array('maxlength' => 255, 'class' => 'su-fl-input', 'placeholder' => ' ')); ?>
                    <label class="su-fl-label">Website</label>
                    <?php echo $form->error($model, 'company_web', array('class' => 'su-error')); ?>
                </div>
            </div>

            <!-- Address -->
            <div class="su-col-12">
                <div class="su-fl su-fl--ta">
                    <i class="fas fa-map-marker su-fl-icon"></i>
                    <?php echo $form->textArea($model, 'company_address', array('class' => 'su-fl-input', 'placeholder' => ' ')); ?>
                    <label class="su-fl-label">Company Address</label>
                    <?php echo $form->error($model, 'company_address', array('class' => 'su-error')); ?>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="su-card-footer">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('onclick' => 'loadingDivDisplay();', 'class' => 'su-submit')); ?>
        <span id="ajaxLoaderMR2" class="ajaxLoaderMR" style="display: none;">
            <i class="fas fa-spinner fa-spin fa-2x" style="color:#6366f1"></i>
        </span>
    </div>
    <script type="text/javascript">
        function loadingDivDisplay() {
            $("#ajaxLoaderMR2").show();
        }

    </script>
</div>

<script>
document.addEventListener('click',function(e){
    var btn=e.target.closest('.su-submit');
    if(!btn)return;
    var r=document.createElement('span');
    r.className='su-ripple';
    var rect=btn.getBoundingClientRect();
    var sz=Math.max(rect.width,rect.height);
    r.style.width=r.style.height=sz+'px';
    r.style.left=(e.clientX-rect.left-sz/2)+'px';
    r.style.top=(e.clientY-rect.top-sz/2)+'px';
    btn.appendChild(r);
    r.addEventListener('animationend',function(){r.remove()});
});
</script>

<?php $this->endWidget(); ?>
