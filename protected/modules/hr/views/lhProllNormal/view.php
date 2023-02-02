<?php
$this->breadcrumbs=array(
	'Lh Proll Normals'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List LhProllNormal', 'url'=>array('index')),
	array('label'=>'Create LhProllNormal', 'url'=>array('create')),
	array('label'=>'Update LhProllNormal', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LhProllNormal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LhProllNormal', 'url'=>array('admin')),
);
?>

<h1>View LhProllNormal #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
	),
)); ?>
