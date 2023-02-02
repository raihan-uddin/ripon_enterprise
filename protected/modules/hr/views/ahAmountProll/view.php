<?php
$this->breadcrumbs=array(
	'Ah Amount Prolls'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AhAmountProll', 'url'=>array('index')),
	array('label'=>'Create AhAmountProll', 'url'=>array('create')),
	array('label'=>'Update AhAmountProll', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AhAmountProll', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AhAmountProll', 'url'=>array('admin')),
);
?>

<h1>View AhAmountProll #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ah_proll_id',
		'percentage_of_ah_proll_id',
		'amount_adj',
		'start_from',
		'end_to',
		'is_active',
		'create_by',
		'create_time',
		'update_by',
		'update_time',
	),
)); ?>
