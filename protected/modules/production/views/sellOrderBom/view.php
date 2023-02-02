<?php
/* @var $this SellOrderBomController */
/* @var $model SellOrderBom */

$this->breadcrumbs=array(
	'Sell Order Boms'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SellOrderBom', 'url'=>array('index')),
	array('label'=>'Create SellOrderBom', 'url'=>array('create')),
	array('label'=>'Update SellOrderBom', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SellOrderBom', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SellOrderBom', 'url'=>array('admin')),
);
?>

<h1>View SellOrderBom #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'sell_order_id',
		'max_sl_no',
		'bom_no',
		'model_id',
		'qty',
		'created_by',
		'created_at',
		'updated_by',
		'updated_at',
	),
)); ?>
