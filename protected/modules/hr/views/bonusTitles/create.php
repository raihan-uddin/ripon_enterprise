<?php
$this->breadcrumbs=array(
	'Bonus Titles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BonusTitles', 'url'=>array('index')),
	array('label'=>'Manage BonusTitles', 'url'=>array('admin')),
);
?>

<h1>Create BonusTitles</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>