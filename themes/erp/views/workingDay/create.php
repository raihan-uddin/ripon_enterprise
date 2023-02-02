<?php
$this->breadcrumbs=array(
	'Working Days'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WorkingDay', 'url'=>array('index')),
	array('label'=>'Manage WorkingDay', 'url'=>array('admin')),
);
?>

<h1>Create WorkingDay</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>