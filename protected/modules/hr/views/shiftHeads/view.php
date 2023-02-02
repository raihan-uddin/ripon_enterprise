<?php
$this->breadcrumbs=array(
	'Shift Heads'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List ShiftHeads', 'url'=>array('index')),
	array('label'=>'Create ShiftHeads', 'url'=>array('create')),
	array('label'=>'Update ShiftHeads', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ShiftHeads', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShiftHeads', 'url'=>array('admin')),
);
?>

<h1>View ShiftHeads #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'in_time',
		'out_time',
	),
)); ?>
