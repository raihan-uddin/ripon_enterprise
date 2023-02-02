<?php
$this->breadcrumbs=array(
	'Ah Amoun Proll Normals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AhAmounProllNormal', 'url'=>array('index')),
	array('label'=>'Create AhAmounProllNormal', 'url'=>array('create')),
	array('label'=>'View AhAmounProllNormal', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AhAmounProllNormal', 'url'=>array('admin')),
);
?>

<h1>Update AhAmounProllNormal <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>