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
		<?php echo $form->label($model,'year'); ?>
		<?php echo $form->textField($model,'year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'month_id'); ?>
		<?php echo $form->textField($model,'month_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'days_of_month'); ?>
		<?php echo $form->textField($model,'days_of_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'working_day'); ?>
		<?php echo $form->textField($model,'working_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'working_hour_per_day'); ?>
		<?php echo $form->textField($model,'working_hour_per_day'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->