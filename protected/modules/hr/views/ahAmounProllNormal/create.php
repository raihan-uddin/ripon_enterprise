<?php
$this->breadcrumbs=array(
	'Ah Amoun Proll Normals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AhAmounProllNormal', 'url'=>array('index')),
	array('label'=>'Manage AhAmounProllNormal', 'url'=>array('admin')),
);
?>

<h1>Create AhAmounProllNormal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>