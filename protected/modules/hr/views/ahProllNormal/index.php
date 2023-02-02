<?php
$this->breadcrumbs=array(
	'Ah Proll Normals',
);

$this->menu=array(
	array('label'=>'Create AhProllNormal', 'url'=>array('create')),
	array('label'=>'Manage AhProllNormal', 'url'=>array('admin')),
);
?>

<h1>Ah Proll Normals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
