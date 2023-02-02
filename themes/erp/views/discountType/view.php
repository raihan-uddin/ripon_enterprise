<?php
$this->breadcrumbs=array(
	'Discount Types'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List DiscountType', 'url'=>array('index')),
	array('label'=>'Create DiscountType', 'url'=>array('create')),
	array('label'=>'Update DiscountType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DiscountType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DiscountType', 'url'=>array('admin')),
);
?>

<h1>View DiscountType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'is_active',
	),
)); ?>
