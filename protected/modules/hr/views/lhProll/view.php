<?php
$this->breadcrumbs=array(
	'Lh Prolls'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List LhProll', 'url'=>array('index')),
	array('label'=>'Create LhProll', 'url'=>array('create')),
	array('label'=>'Update LhProll', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LhProll', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LhProll', 'url'=>array('admin')),
);
?>

<h1>View LhProll #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'paygrade_id',
		'title',
	),
)); ?>
