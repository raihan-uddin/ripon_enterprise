<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Inventories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Inventory', 'url'=>array('index')),
	array('label'=>'Create Inventory', 'url'=>array('create')),
	array('label'=>'Update Inventory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Inventory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Inventory', 'url'=>array('admin')),
);
?>

<h1>View Inventory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sl_no',
		'date',
		'challan_no',
		'store_id',
		'location_id',
		'model_id',
		'stock_in',
		'stock_out',
		'sell_price',
		'purchase_price',
		'stock_status',
		'source_id',
		'stock_of',
		'remarks',
		'create_time',
		'create_by',
		'update_time',
		'update_by',
	),
)); ?>
