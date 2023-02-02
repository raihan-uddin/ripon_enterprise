<?php
$this->breadcrumbs=array(
	'Lh Prolls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LhProll', 'url'=>array('index')),
	array('label'=>'Manage LhProll', 'url'=>array('admin')),
);
?>

<h1>Create LhProll</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>