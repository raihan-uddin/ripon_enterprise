<?php
/* @var $this ExpenseHeadController */
/* @var $model ExpenseHead */
/* @var $form CActiveForm */
?>

<style>
/* ── Expense Head Card ── */
.eh-card{border:none;border-radius:16px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);margin-bottom:24px}
.eh-card-header{background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);padding:20px 26px;position:relative;overflow:hidden}
.eh-card-header::before{content:'';position:absolute;inset:0;background:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);background-size:22px 22px;pointer-events:none}
.eh-card-header::after{content:'';position:absolute;top:-50px;right:-50px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.07);pointer-events:none}
.eh-header-row{display:flex;align-items:center;gap:14px;position:relative;z-index:1}
.eh-icon-box{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.eh-icon-box i{color:#fff;font-size:14px}
.eh-header-text .eh-title{font-size:16px;font-weight:800;color:#fff;margin:0;line-height:1.3}
.eh-header-text .eh-subtitle{font-size:11.5px;color:rgba(255,255,255,.65);margin:0;line-height:1.4}
.eh-card-body{padding:22px 26px;background:#fff}
.eh-card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;padding:14px 26px;display:flex;align-items:center;gap:10px}

/* ── Floating Label ── */
.eh-fl{position:relative;margin-bottom:0}
.eh-fl .eh-fl-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#cbd5e1;font-size:13px;transition:color .2s;pointer-events:none;z-index:2}
.eh-fl .eh-fl-input{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;background:#fff;outline:none;transition:border-color .2s,box-shadow .2s}
.eh-fl .eh-fl-input:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}
.eh-fl .eh-fl-label{position:absolute;left:38px;top:50%;transform:translateY(-50%);font-size:13.5px;color:#94a3b8;font-weight:500;pointer-events:none;transition:all .2s ease}
.eh-fl .eh-fl-input:focus~.eh-fl-label,
.eh-fl .eh-fl-input:not([placeholder=' '])~.eh-fl-label,
.eh-fl .eh-fl-input:not(:placeholder-shown)~.eh-fl-label{top:5px;transform:none;font-size:9.5px;font-weight:700;color:#6366f1}
.eh-fl:focus-within .eh-fl-icon{color:#6366f1}
.eh-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block}

/* ── Submit Button ── */
.eh-submit{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;border-radius:9px;padding:10px 22px;font-size:13.5px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);position:relative;overflow:hidden;transition:transform .15s,box-shadow .15s}
.eh-submit:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(99,102,241,.45)}
.eh-submit:active{transform:translateY(0)}
.eh-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.35);transform:scale(0);animation:eh-ripple-anim .5s ease-out}
@keyframes eh-ripple-anim{to{transform:scale(4);opacity:0}}
</style>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'expense-head-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
)); ?>

    <script>
        $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
    </script>

    <div class="eh-card">
        <!-- Header -->
        <div class="eh-card-header">
            <div class="eh-header-row">
                <div class="eh-icon-box">
                    <i class="fa fa-sitemap"></i>
                </div>
                <div class="eh-header-text">
                    <h3 class="eh-title"><?php echo($model->isNewRecord ? 'Add New Expense Head' : 'Update Expense Head'); ?></h3>
                    <p class="eh-subtitle"><?php echo($model->isNewRecord ? 'Create a new expense category' : 'Edit existing expense category'); ?></p>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="eh-card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class="eh-fl">
                        <i class="fa fa-tag eh-fl-icon"></i>
                        <?php echo $form->textField($model, 'title', array('maxlength' => 255, 'class' => 'eh-fl-input', 'placeholder' => ' ')); ?>
                        <label class="eh-fl-label">Title</label>
                    </div>
                    <?php echo $form->error($model, 'title', array('class' => 'eh-error')); ?>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="eh-card-footer">
            <?php
            echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('expenseHead/create', 'render' => true)), array(
                'dataType' => 'json',
                'type' => 'post',
                'success' => 'function(data) {
                $("#ajaxLoader").hide();
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.")
                        $("#expense-head-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("expense-head-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        //$("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#expense-head-form #"+key+"_em_").html(""+val+"");
                            $("#expense-head-form #"+key+"_em_").show();
                        });
                    }
                }',
                'beforeSend' => 'function(){
                $("#ajaxLoader").show();
             }'
            ), array('class' => 'eh-submit', 'onclick' => 'ehRipple(event)'));
            ?>

            <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
                <i class="fa fa-spinner fa-spin fa-2x" style="color:#6366f1"></i>
            </span>

            <div id="formResult" class="ajaxTargetDiv"></div>
            <div id="formResultError" class="ajaxTargetDivErr"></div>
        </div>
    </div>

    <script>
    function ehRipple(e){
        var btn=e.currentTarget,r=document.createElement('span');
        r.className='eh-ripple';
        var rect=btn.getBoundingClientRect();
        r.style.left=(e.clientX-rect.left)+'px';
        r.style.top=(e.clientY-rect.top)+'px';
        r.style.width=r.style.height=Math.max(rect.width,rect.height)+'px';
        btn.appendChild(r);
        setTimeout(function(){r.remove()},600);
    }
    </script>

<?php $this->endWidget(); ?>
