<?php
$this->breadcrumbs=array(
	'Lh Amount Proll Normals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LhAmountProllNormal', 'url'=>array('index')),
	array('label'=>'Create LhAmountProllNormal', 'url'=>array('create')),
	array('label'=>'Update LhAmountProllNormal', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LhAmountProllNormal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LhAmountProllNormal', 'url'=>array('admin')),
);
?>

<h1>View LhAmountProllNormal #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'lh_proll_normal_id',
		'day',
		'hour',
		'create_by',
		'create_time',
		'update_by',
		'update_time',
	),
)); ?>
