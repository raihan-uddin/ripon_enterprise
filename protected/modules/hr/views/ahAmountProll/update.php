<?php
$this->breadcrumbs=array(
	'Ah Amount Prolls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AhAmountProll', 'url'=>array('index')),
	array('label'=>'Create AhAmountProll', 'url'=>array('create')),
	array('label'=>'View AhAmountProll', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AhAmountProll', 'url'=>array('admin')),
);
?>

<h1>Update AhAmountProll <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>