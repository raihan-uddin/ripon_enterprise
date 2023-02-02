<?php
$this->breadcrumbs=array(
	'Lh Prolls'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LhProll', 'url'=>array('index')),
	array('label'=>'Create LhProll', 'url'=>array('create')),
	array('label'=>'View LhProll', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LhProll', 'url'=>array('admin')),
);
?>

<h1>Update LhProll <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>