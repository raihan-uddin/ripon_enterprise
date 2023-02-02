<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ah_proll_id'); ?>
		<?php echo $form->textField($model,'ah_proll_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'percentage_of_ah_proll_id'); ?>
		<?php echo $form->textField($model,'percentage_of_ah_proll_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount_adj'); ?>
		<?php echo $form->textField($model,'amount_adj'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_from'); ?>
		<?php echo $form->textField($model,'start_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_to'); ?>
		<?php echo $form->textField($model,'end_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_active'); ?>
		<?php echo $form->textField($model,'is_active'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_by'); ?>
		<?php echo $form->textField($model,'create_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_by'); ?>
		<?php echo $form->textField($model,'update_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_time'); ?>
		<?php echo $form->textField($model,'update_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->