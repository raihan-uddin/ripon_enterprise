<?php
$this->breadcrumbs=array(
	'Ah Proll Normals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AhProllNormal', 'url'=>array('index')),
	array('label'=>'Manage AhProllNormal', 'url'=>array('admin')),
);
?>

<h1>Create AhProllNormal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>