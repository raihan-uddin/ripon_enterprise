<?php
$this->breadcrumbs=array(
	'Customer Ab Validations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CustomerAbValidation', 'url'=>array('index')),
	array('label'=>'Create CustomerAbValidation', 'url'=>array('create')),
	array('label'=>'View CustomerAbValidation', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CustomerAbValidation', 'url'=>array('admin')),
);
?>

<h1>Update CustomerAbValidation <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>