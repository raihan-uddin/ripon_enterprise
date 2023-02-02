<?php
$this->breadcrumbs=array(
	'Shift Heads'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShiftHeads', 'url'=>array('index')),
	array('label'=>'Create ShiftHeads', 'url'=>array('create')),
	array('label'=>'View ShiftHeads', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ShiftHeads', 'url'=>array('admin')),
);
?>

<h1>Update ShiftHeads <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>