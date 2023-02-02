<?php
$this->breadcrumbs=array(
	'Lh Amount Proll Normals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LhAmountProllNormal', 'url'=>array('index')),
	array('label'=>'Manage LhAmountProllNormal', 'url'=>array('admin')),
);
?>

<h1>Create LhAmountProllNormal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>