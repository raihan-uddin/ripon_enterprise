<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_id')); ?>:</b>
	<?php echo CHtml::encode($data->company_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_person_name')); ?>:</b>
	<?php echo CHtml::encode($data->contact_person_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('designation_id')); ?>:</b>
	<?php echo CHtml::encode($data->designation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_number1')); ?>:</b>
	<?php echo CHtml::encode($data->contact_number1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_number2')); ?>:</b>
	<?php echo CHtml::encode($data->contact_number2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_number3')); ?>:</b>
	<?php echo CHtml::encode($data->contact_number3); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	*/ ?>

</div>