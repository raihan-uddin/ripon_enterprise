<?php
/* @var $this WarrantyClaimsController */
/* @var $model WarrantyClaims */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'warranty-claims-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'claim_type'); ?>
		<?php echo $form->textField($model,'claim_type'); ?>
		<?php echo $form->error($model,'claim_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'claim_date'); ?>
		<?php echo $form->textField($model,'claim_date'); ?>
		<?php echo $form->error($model,'claim_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
		<?php echo $form->error($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'claim_description'); ?>
		<?php echo $form->textArea($model,'claim_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'claim_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'claim_status'); ?>
		<?php echo $form->textField($model,'claim_status'); ?>
		<?php echo $form->error($model,'claim_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'resolution_date'); ?>
		<?php echo $form->textField($model,'resolution_date'); ?>
		<?php echo $form->error($model,'resolution_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'resolution_description'); ?>
		<?php echo $form->textArea($model,'resolution_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'resolution_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_sp'); ?>
		<?php echo $form->textField($model,'total_sp',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'total_sp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_pp'); ?>
		<?php echo $form->textField($model,'total_pp',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'total_pp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_by'); ?>
		<?php echo $form->textField($model,'updated_by'); ?>
		<?php echo $form->error($model,'updated_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updatetd_at'); ?>
		<?php echo $form->textField($model,'updatetd_at'); ?>
		<?php echo $form->error($model,'updatetd_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted'); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'business_id'); ?>
		<?php echo $form->textField($model,'business_id'); ?>
		<?php echo $form->error($model,'business_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'branch_id'); ?>
		<?php echo $form->textField($model,'branch_id'); ?>
		<?php echo $form->error($model,'branch_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->