<?php
$this->breadcrumbs=array(
	'Ah Proll Normals'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List AhProllNormal', 'url'=>array('index')),
	array('label'=>'Create AhProllNormal', 'url'=>array('create')),
	array('label'=>'Update AhProllNormal', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AhProllNormal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AhProllNormal', 'url'=>array('admin')),
);
?>

<h1>View AhProllNormal #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'ac_type',
	),
)); ?>
