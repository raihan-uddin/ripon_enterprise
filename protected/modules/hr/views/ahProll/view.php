<?php
$this->breadcrumbs=array(
	'Ah Prolls'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List AhProll', 'url'=>array('index')),
	array('label'=>'Create AhProll', 'url'=>array('create')),
	array('label'=>'Update AhProll', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AhProll', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AhProll', 'url'=>array('admin')),
);
?>

<h1>View AhProll #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'paygrade_id',
		'title',
		'ac_type',
	),
)); ?>
