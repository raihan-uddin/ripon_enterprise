<?php
$this->breadcrumbs=array(
	'Lh Amount Prolls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LhAmountProll', 'url'=>array('index')),
	array('label'=>'Manage LhAmountProll', 'url'=>array('admin')),
);
?>

<h1>Create LhAmountProll</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>