<?php
$this->breadcrumbs=array(
	'Working Days'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WorkingDay', 'url'=>array('index')),
	array('label'=>'Create WorkingDay', 'url'=>array('create')),
	array('label'=>'View WorkingDay', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage WorkingDay', 'url'=>array('admin')),
);
?>

<h1>Update WorkingDay <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>