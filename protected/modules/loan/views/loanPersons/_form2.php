<?php
$form = $this->beginWidget('CActiveForm', array(
        'id' => 'loan-person-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
));
?>

<style>
/* ── loanPersons form2 (compact) ── */
.lp-card{border:none;border-radius:16px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);margin-bottom:20px}

/* header */
.lp-card-header{background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);padding:16px 22px;position:relative;overflow:hidden}
.lp-card-header::before{content:'';position:absolute;inset:0;background:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);background-size:22px 22px;pointer-events:none}
.lp-card-header::after{content:'';position:absolute;top:-50px;right:-50px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.07);pointer-events:none}
.lp-header-row{display:flex;align-items:center;gap:10px;position:relative;z-index:1}
.lp-header-icon{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;flex-shrink:0}
.lp-header-title{font-size:16px;font-weight:800;color:#fff;margin:0;line-height:1.3}
.lp-header-sub{font-size:11.5px;color:rgba(255,255,255,.65);margin:0;line-height:1.3}

/* body — compact */
.lp-card-body{padding:18px 22px;background:#fff}

/* footer — compact */
.lp-card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;padding:12px 22px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
.lp-card-footer small{font-size:12px;color:#94a3b8}
.lp-card-footer small span{color:#ef4444}

/* floating-label group */
.lp-fl{position:relative;margin-bottom:14px}
.lp-fl-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#cbd5e1;font-size:13px;transition:color .2s;z-index:2;pointer-events:none}
.lp-fl-input{display:block;width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;background:#fff;outline:none;transition:border-color .2s,box-shadow .2s}
.lp-fl-input:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}
.lp-fl-label{position:absolute;left:38px;top:50%;transform:translateY(-50%);font-size:13px;color:#94a3b8;font-weight:500;pointer-events:none;transition:all .18s ease}
.lp-fl-input:focus ~ .lp-fl-label,
.lp-fl-input:not([placeholder=' ']) ~ .lp-fl-label,
.lp-fl-input:not(:placeholder-shown) ~ .lp-fl-label{top:5px;transform:translateY(0);font-size:9.5px;font-weight:700;color:#6366f1}
.lp-fl:focus-within .lp-fl-icon{color:#6366f1}

/* textarea variant */
.lp-fl .lp-fl-input[rows]{padding-top:24px;min-height:72px;resize:vertical}
.lp-fl .lp-fl-input[rows] ~ .lp-fl-label{top:16px;transform:translateY(0)}
.lp-fl .lp-fl-input[rows]:focus ~ .lp-fl-label,
.lp-fl .lp-fl-input[rows]:not(:placeholder-shown) ~ .lp-fl-label{top:5px;font-size:9.5px;font-weight:700;color:#6366f1}
.lp-fl .lp-fl-input[rows] ~ .lp-fl-icon{top:16px;transform:translateY(0)}

/* select group */
.lp-select-group{margin-bottom:14px}
.lp-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#475569;margin-bottom:6px;letter-spacing:.3px}
.lp-select{display:block;width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 36px 10px 38px;font-size:13.5px;color:#1e293b;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 12px center;-webkit-appearance:none;-moz-appearance:none;appearance:none;outline:none;transition:border-color .2s,box-shadow .2s}
.lp-select:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}
.lp-select-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#cbd5e1;font-size:13px;pointer-events:none;z-index:2}
.lp-select-wrap{position:relative}
.lp-select-wrap:focus-within .lp-select-icon{color:#6366f1}

/* error */
.lp-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block}

/* submit */
.lp-submit{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;border-radius:9px;padding:10px 26px;font-size:13.5px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);position:relative;overflow:hidden;transition:transform .15s,box-shadow .15s}
.lp-submit:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(99,102,241,.45)}
.lp-submit:active{transform:translateY(0)}
.lp-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.35);transform:scale(0);animation:lp-ripple-anim .5s ease-out}
@keyframes lp-ripple-anim{to{transform:scale(4);opacity:0}}

/* loader */
.lp-loader{display:none;color:#6366f1;font-size:16px}

/* row helper */
.lp-row{display:flex;flex-wrap:wrap;gap:0 16px}
.lp-col-half{flex:1 1 calc(50% - 8px);min-width:220px}
.lp-col-full{flex:1 1 100%}
</style>

<div class="lp-card">

    <!-- ===== HEADER ===== -->
    <div class="lp-card-header">
        <div class="lp-header-row">
            <div class="lp-header-icon">
                <i class="fa fa-user"></i>
            </div>
            <div>
                <div class="lp-header-title">
                    <?= $model->isNewRecord
                            ? 'Add Loan Person'
                            : 'Update Loan Person: ' . CHtml::encode($model->name); ?>
                </div>
                <div class="lp-header-sub">
                    <?= $model->isNewRecord ? 'Fill in person details below' : 'Edit the details and save'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== BODY ===== -->
    <div class="lp-card-body">
        <div class="lp-row">

            <!-- Name -->
            <div class="lp-col-half">
                <div class="lp-fl">
                    <i class="fa fa-user-o lp-fl-icon"></i>
                    <?= $form->textField($model, 'name', [
                            'class' => 'lp-fl-input',
                            'placeholder' => ' ',
                    ]); ?>
                    <label class="lp-fl-label" for="LoanPersons_name">Full Name</label>
                    <?= $form->error($model, 'name', array('class'=>'lp-error')); ?>
                </div>
            </div>

            <!-- Phone -->
            <div class="lp-col-half">
                <div class="lp-fl">
                    <i class="fa fa-phone lp-fl-icon"></i>
                    <?= $form->textField($model, 'phone', [
                            'class' => 'lp-fl-input',
                            'placeholder' => ' ',
                    ]); ?>
                    <label class="lp-fl-label" for="LoanPersons_phone">Phone Number</label>
                    <?= $form->error($model, 'phone', array('class'=>'lp-error')); ?>
                </div>
            </div>

            <!-- Email -->
            <div class="lp-col-half">
                <div class="lp-fl">
                    <i class="fa fa-envelope-o lp-fl-icon"></i>
                    <?= $form->textField($model, 'email', [
                            'class' => 'lp-fl-input',
                            'placeholder' => ' ',
                    ]); ?>
                    <label class="lp-fl-label" for="LoanPersons_email">Email (Optional)</label>
                    <?= $form->error($model, 'email', array('class'=>'lp-error')); ?>
                </div>
            </div>

            <!-- Status -->
            <div class="lp-col-half">
                <div class="lp-select-group">
                    <label class="lp-label">Status</label>
                    <div class="lp-select-wrap">
                        <i class="fa fa-toggle-on lp-select-icon"></i>
                        <?= $form->dropDownList(
                                $model,
                                'status',
                                [1 => 'Active', 0 => 'Inactive'],
                                ['class' => 'lp-select']
                        ); ?>
                    </div>
                    <?= $form->error($model, 'status', array('class'=>'lp-error')); ?>
                </div>
            </div>

            <!-- Note -->
            <div class="lp-col-full">
                <div class="lp-fl">
                    <i class="fa fa-sticky-note-o lp-fl-icon"></i>
                    <?= $form->textArea($model, 'note', [
                            'class' => 'lp-fl-input',
                            'rows' => 3,
                            'placeholder' => ' ',
                    ]); ?>
                    <label class="lp-fl-label" for="LoanPersons_note">Note (Optional)</label>
                    <?= $form->error($model, 'note', array('class'=>'lp-error')); ?>
                </div>
            </div>

        </div>
    </div>

    <!-- ===== FOOTER ===== -->
    <div class="lp-card-footer">

        <small>
            <span>*</span> Required fields
        </small>

        <div style="display:flex;align-items:center;gap:10px">
            <?php
            echo CHtml::submitButton(
                    $model->isNewRecord ? 'Create Person' : 'Update Person',
                    array(
                            'onclick' => 'loadingDivDisplay();',
                            'class' => 'lp-submit',
                            'id' => 'lp-submit-btn2',
                    )
            );
            ?>

            <span id="ajaxLoaderMR2" class="lp-loader">
                <i class="fa fa-spinner fa-spin"></i>
            </span>
        </div>
    </div>

</div>

<script type="text/javascript">
    function loadingDivDisplay() {
        $('#ajaxLoaderMR2').show();
    }
    (function(){
        $(document).on('click','.lp-submit',function(e){
            var btn=this,rect=btn.getBoundingClientRect(),
                x=e.clientX-rect.left,y=e.clientY-rect.top,
                r=document.createElement('span');
            r.className='lp-ripple';
            r.style.left=x+'px';r.style.top=y+'px';
            btn.appendChild(r);
            setTimeout(function(){r.remove()},600);
        });
    })();
</script>

<?php $this->endWidget(); ?>
