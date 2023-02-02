<?php
$this->breadcrumbs=array(
	'Ah Proll Normals'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AhProllNormal', 'url'=>array('index')),
	array('label'=>'Create AhProllNormal', 'url'=>array('create')),
	array('label'=>'View AhProllNormal', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AhProllNormal', 'url'=>array('admin')),
);
?>

<h1>Update AhProllNormal <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>