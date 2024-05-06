<?php
/* @var $this SellReturnController */
/* @var $model SellReturn */

$this->breadcrumbs=array(
	'Sell Returns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SellReturn', 'url'=>array('index')),
	array('label'=>'Create SellReturn', 'url'=>array('create')),
	array('label'=>'Update SellReturn', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SellReturn', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SellReturn', 'url'=>array('admin')),
);
?>

<h1>View SellReturn #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'return_date',
		'customer_id',
		'return_amount',
		'costing',
		'return_type',
		'remarks',
		'is_deleted',
		'business_id',
		'branch_id',
		'created_by',
		'created_at',
		'updated_by',
		'updated_at',
		'is_opening',
	),
)); ?>
