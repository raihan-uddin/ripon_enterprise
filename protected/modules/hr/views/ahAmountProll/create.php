<?php
$this->breadcrumbs=array(
	'Ah Amount Prolls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AhAmountProll', 'url'=>array('index')),
	array('label'=>'Manage AhAmountProll', 'url'=>array('admin')),
);
?>

<h1>Create AhAmountProll</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>