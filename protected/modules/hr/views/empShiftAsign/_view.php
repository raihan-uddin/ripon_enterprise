<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_no')); ?>:</b>
	<?php echo CHtml::encode($data->card_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_time')); ?>:</b>
	<?php echo CHtml::encode($data->in_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_time')); ?>:</b>
	<?php echo CHtml::encode($data->out_time); ?>
	<br />


</div>