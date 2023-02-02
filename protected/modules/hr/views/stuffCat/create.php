<?php
$this->breadcrumbs=array(
	'Stuff Cats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StuffCat', 'url'=>array('index')),
	array('label'=>'Manage StuffCat', 'url'=>array('admin')),
);
?>

<h1>Create StuffCat</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>