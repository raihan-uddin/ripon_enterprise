<?php
$this->breadcrumbs=array(
	'Shift Heads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShiftHeads', 'url'=>array('index')),
	array('label'=>'Manage ShiftHeads', 'url'=>array('admin')),
);
?>

<h1>Create ShiftHeads</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>