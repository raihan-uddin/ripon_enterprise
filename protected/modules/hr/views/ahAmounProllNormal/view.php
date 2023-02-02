<?php
$this->breadcrumbs=array(
	'Ah Amoun Proll Normals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AhAmounProllNormal', 'url'=>array('index')),
	array('label'=>'Create AhAmounProllNormal', 'url'=>array('create')),
	array('label'=>'Update AhAmounProllNormal', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AhAmounProllNormal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AhAmounProllNormal', 'url'=>array('admin')),
);
?>

<h1>View AhAmounProllNormal #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'employee_id',
		'ah_proll_normal_id',
		'percentage_of_ah_proll_normal_id',
		'amount_adj',
		'create_by',
		'create_time',
		'update_by',
		'update_time',
	),
)); ?>
