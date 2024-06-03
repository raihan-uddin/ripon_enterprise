
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'company_id',
		'contact_person_name',
		'designation_id',
		'contact_number1',
		'contact_number2',
		'contact_number3',
		'email',
	),
)); ?>
