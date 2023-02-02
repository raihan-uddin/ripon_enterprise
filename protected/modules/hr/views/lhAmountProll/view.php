<?php
$this->breadcrumbs=array(
	'Lh Amount Prolls'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LhAmountProll', 'url'=>array('index')),
	array('label'=>'Create LhAmountProll', 'url'=>array('create')),
	array('label'=>'Update LhAmountProll', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LhAmountProll', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LhAmountProll', 'url'=>array('admin')),
);
?>

<h1>View LhAmountProll #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'lh_proll_id',
		'day',
		'hour',
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
