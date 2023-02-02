<?php
/* @var $this ReceivePurchaseController */
/* @var $model ReceivePurchase */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'receive-purchase-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'max_sl_no'); ?>
		<?php echo $form->textField($model,'max_sl_no'); ?>
		<?php echo $form->error($model,'max_sl_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receive_no'); ?>
		<?php echo $form->textField($model,'receive_no',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'receive_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_memo_no'); ?>
		<?php echo $form->textField($model,'supplier_memo_no',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'supplier_memo_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_memo_date'); ?>
		<?php echo $form->textField($model,'supplier_memo_date'); ?>
		<?php echo $form->error($model,'supplier_memo_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_id'); ?>
		<?php echo $form->error($model,'supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'purchase_order_id'); ?>
		<?php echo $form->textField($model,'purchase_order_id'); ?>
		<?php echo $form->error($model,'purchase_order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rcv_amount'); ?>
		<?php echo $form->textField($model,'rcv_amount'); ?>
		<?php echo $form->error($model,'rcv_amount'); ?>
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
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->