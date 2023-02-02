<?php
$this->breadcrumbs=array(
	'Lh Proll Normals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LhProllNormal', 'url'=>array('index')),
	array('label'=>'Manage LhProllNormal', 'url'=>array('admin')),
);
?>

<h1>Create LhProllNormal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>