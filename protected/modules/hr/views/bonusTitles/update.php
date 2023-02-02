<?php
$this->breadcrumbs=array(
	'Bonus Titles'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BonusTitles', 'url'=>array('index')),
	array('label'=>'Create BonusTitles', 'url'=>array('create')),
	array('label'=>'View BonusTitles', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BonusTitles', 'url'=>array('admin')),
);
?>

<h1>Update BonusTitles <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>