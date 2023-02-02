<?php
$this->breadcrumbs=array(
	'Ah Prolls'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AhProll', 'url'=>array('index')),
	array('label'=>'Create AhProll', 'url'=>array('create')),
	array('label'=>'View AhProll', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AhProll', 'url'=>array('admin')),
);
?>

<h1>Update AhProll <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>