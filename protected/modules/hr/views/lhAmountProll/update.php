<?php
$this->breadcrumbs=array(
	'Lh Amount Prolls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LhAmountProll', 'url'=>array('index')),
	array('label'=>'Create LhAmountProll', 'url'=>array('create')),
	array('label'=>'View LhAmountProll', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LhAmountProll', 'url'=>array('admin')),
);
?>

<h1>Update LhAmountProll <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>