<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('year')); ?>:</b>
	<?php echo CHtml::encode($data->year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('month_id')); ?>:</b>
	<?php echo CHtml::encode($data->month_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('days_of_month')); ?>:</b>
	<?php echo CHtml::encode($data->days_of_month); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('working_day')); ?>:</b>
	<?php echo CHtml::encode($data->working_day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('working_hour_per_day')); ?>:</b>
	<?php echo CHtml::encode($data->working_hour_per_day); ?>
	<br />


</div>