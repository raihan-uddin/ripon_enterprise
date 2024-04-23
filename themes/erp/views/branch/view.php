<?php
/* @var $this BranchController */
/* @var $model Branch */

$this->breadcrumbs=array(
	'Branches'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Branch', 'url'=>array('index')),
	array('label'=>'Create Branch', 'url'=>array('create')),
	array('label'=>'Update Branch', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Branch', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Branch', 'url'=>array('admin')),
);
?>

<h1>View Branch #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'business_id',
		'slug',
		'display_name',
		'address',
		'phone_number',
		'status',
		'created_at',
		'created_by',
		'updated_at',
		'updated_by',
	),
)); ?>
