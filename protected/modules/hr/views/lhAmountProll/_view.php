<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lh_proll_id')); ?>:</b>
	<?php echo CHtml::encode($data->lh_proll_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('day')); ?>:</b>
	<?php echo CHtml::encode($data->day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hour')); ?>:</b>
	<?php echo CHtml::encode($data->hour); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('percentage_of_ah_proll_id')); ?>:</b>
	<?php echo CHtml::encode($data->percentage_of_ah_proll_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_adj')); ?>:</b>
	<?php echo CHtml::encode($data->amount_adj); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_from')); ?>:</b>
	<?php echo CHtml::encode($data->start_from); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('end_to')); ?>:</b>
	<?php echo CHtml::encode($data->end_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_by')); ?>:</b>
	<?php echo CHtml::encode($data->create_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_by')); ?>:</b>
	<?php echo CHtml::encode($data->update_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	*/ ?>

</div>