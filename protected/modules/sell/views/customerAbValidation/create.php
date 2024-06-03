<?php
$this->breadcrumbs=array(
	'Customer Ab Validations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CustomerAbValidation', 'url'=>array('index')),
	array('label'=>'Manage CustomerAbValidation', 'url'=>array('admin')),
);
?>

<h1>Create CustomerAbValidation</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>