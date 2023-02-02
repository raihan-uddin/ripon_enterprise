<?php
$this->breadcrumbs=array(
	'Stuff Cats'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StuffCat', 'url'=>array('index')),
	array('label'=>'Create StuffCat', 'url'=>array('create')),
	array('label'=>'View StuffCat', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StuffCat', 'url'=>array('admin')),
);
?>

<h1>Update StuffCat <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>