<?php
$this->breadcrumbs=array(
	'Customer Ab Validations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CustomerAbValidation', 'url'=>array('index')),
	array('label'=>'Create CustomerAbValidation', 'url'=>array('create')),
	array('label'=>'Update CustomerAbValidation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CustomerAbValidation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CustomerAbValidation', 'url'=>array('admin')),
);
?>

<h1>View CustomerAbValidation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'validation_field',
		'is_active',
	),
)); ?>
