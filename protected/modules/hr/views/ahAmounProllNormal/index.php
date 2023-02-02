<?php
$this->breadcrumbs=array(
	'Ah Amoun Proll Normals',
);

$this->menu=array(
	array('label'=>'Create AhAmounProllNormal', 'url'=>array('create')),
	array('label'=>'Manage AhAmounProllNormal', 'url'=>array('admin')),
);
?>

<h1>Ah Amoun Proll Normals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
