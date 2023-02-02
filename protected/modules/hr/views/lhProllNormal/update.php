<?php
$this->breadcrumbs=array(
	'Lh Proll Normals'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LhProllNormal', 'url'=>array('index')),
	array('label'=>'Create LhProllNormal', 'url'=>array('create')),
	array('label'=>'View LhProllNormal', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LhProllNormal', 'url'=>array('admin')),
);
?>

<h1>Update LhProllNormal <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>