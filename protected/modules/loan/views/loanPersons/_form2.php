<?php
$form = $this->beginWidget('CActiveForm', array(
        'id' => 'loan-person-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
));
?>

<div class="card shadow-sm border-0">

    <!-- ===== HEADER ===== -->
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <?= $model->isNewRecord
                        ? 'Add Loan Person'
                        : 'Update Loan Person: ' . CHtml::encode($model->name); ?>
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
                        'placeholder' => 'Full name'
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
                        'placeholder' => 'Optional note'
                ]); ?>
                <div class="invalid-feedback d-block">
                    <?= $form->error($model, 'note'); ?>
                </div>
            </div>

        </div>
    </div>

    <!-- ===== FOOTER ===== -->
    <div class="card-footer bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">

        <small class="text-muted">
            <span class="text-danger">*</span> Required fields
        </small>

        <div class="d-flex align-items-center gap-2">
            <?php
            echo CHtml::submitButton(
                    $model->isNewRecord ? 'Create Person' : 'Update Person',
                    array(
                            'onclick' => 'loadingDivDisplay();',
                            'class' => 'btn btn-primary px-4'
                    )
            );
            ?>

            <span id="ajaxLoaderMR2" style="display:none">
                <i class="fa fa-spinner fa-spin"></i>
            </span>
        </div>
    </div>

</div>

<script type="text/javascript">
    function loadingDivDisplay() {
        $('#ajaxLoaderMR2').show();
    }
</script>

<?php $this->endWidget(); ?>
