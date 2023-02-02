<?php
$this->breadcrumbs=array(
	'Lh Amount Proll Normals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LhAmountProllNormal', 'url'=>array('index')),
	array('label'=>'Create LhAmountProllNormal', 'url'=>array('create')),
	array('label'=>'View LhAmountProllNormal', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LhAmountProllNormal', 'url'=>array('admin')),
);
?>

<h1>Update LhAmountProllNormal <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>