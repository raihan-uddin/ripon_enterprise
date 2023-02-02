<?php
$this->breadcrumbs=array(
	'Ah Prolls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AhProll', 'url'=>array('index')),
	array('label'=>'Manage AhProll', 'url'=>array('admin')),
);
?>

<h1>Create AhProll</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>