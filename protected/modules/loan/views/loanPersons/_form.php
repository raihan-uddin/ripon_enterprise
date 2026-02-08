<?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'loan-person-form',
        'enableClientValidation' => true,
        'clientOptions' => ['validateOnSubmit' => true],
]); ?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<div class="card shadow-sm border-0">

    <!-- ===== HEADER ===== -->
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <?= $model->isNewRecord ? 'Add Loan Person' : 'Update Loan Person'; ?>
            </h5>

            <button type="button" class="btn btn-sm btn-light" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>

    <!-- ===== BODY ===== -->
    <div class="card-body">

        <div class="row g-3">

            <!-- Name -->
            <div class="col-12 col-md-6">
                <?= $form->labelEx($model, 'name', ['class'=>'form-label']); ?>
                <?= $form->textField($model, 'name', [
                        'class' => 'form-control',
                        'placeholder' => 'Full name (e.g. Rahim Uddin)'
                ]); ?>
                <div class="invalid-feedback d-block">
                    <?= $form->error($model, 'name'); ?>
                </div>
            </div>

            <!-- Phone -->
            <div class="col-12 col-md-6">
                <?= $form->label($model, 'phone', ['class'=>'form-label']); ?>
                <?= $form->textField($model, 'phone', [
                        'class' => 'form-control',
                        'placeholder' => 'Mobile number'
                ]); ?>
                <div class="invalid-feedback d-block">
                    <?= $form->error($model, 'phone'); ?>
                </div>
            </div>

            <!-- Email -->
            <div class="col-12 col-md-6">
                <?= $form->label($model, 'email', ['class'=>'form-label']); ?>
                <?= $form->textField($model, 'email', [
                        'class' => 'form-control',
                        'placeholder' => 'Email (optional)'
                ]); ?>
                <div class="invalid-feedback d-block">
                    <?= $form->error($model, 'email'); ?>
                </div>
            </div>

            <!-- Status -->
            <div class="col-12 col-md-6">
                <?= $form->label($model, 'status', ['class'=>'form-label']); ?>
                <?= $form->dropDownList(
                        $model,
                        'status',
                        [1 => 'Active', 0 => 'Inactive'],
                        ['class' => 'form-control']
                ); ?>
                <div class="invalid-feedback d-block">
                    <?= $form->error($model, 'status'); ?>
                </div>
            </div>

            <!-- Note -->
            <div class="col-12">
                <?= $form->label($model, 'note', ['class'=>'form-label']); ?>
                <?= $form->textArea($model, 'note', [
                        'class' => 'form-control',
                        'rows' => 3,
                        'placeholder' => 'Optional note (relationship, purpose, etc.)'
                ]); ?>
                <div class="invalid-feedback d-block">
                    <?= $form->error($model, 'note'); ?>
                </div>
            </div>

        </div>
    </div>

    <!-- ===== FOOTER (STICKY ACTION) ===== -->
    <div class="card-footer bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">

        <small class="text-muted">
            Fields marked with <span class="text-danger">*</span> are required
        </small>

        <?php
        echo CHtml::ajaxSubmitButton(
                $model->isNewRecord ? 'Save Person' : 'Update Person',
                CHtml::normalizeUrl(['/loan/loanPersons/create', 'render' => true]),
                [
                        'dataType' => 'json',
                        'type' => 'post',
                        'beforeSend' => 'function(){
                    $("#ajaxLoader").show();
                }',
                        'success' => 'function(data){
                    $("#ajaxLoader").hide();
                    if(data.status=="success"){
                        toastr.success("Saved successfully");
                        $("#loan-person-form")[0].reset();
                        $.fn.yiiGridView.update("loan-person-grid");
                    }else{
                        $.each(data, function(key,val){
                            $("#loan-person-form #"+key+"_em_").html(val).show();
                        });
                    }
                }'
                ],
                ['class' => 'btn btn-primary px-4']
        );
        ?>

        <span id="ajaxLoader" style="display:none">
            <i class="fa fa-spinner fa-spin"></i>
        </span>

    </div>
</div>

<?php $this->endWidget(); ?>
