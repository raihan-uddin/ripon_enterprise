<?php
$this->breadcrumbs=array(
	'Lh Proll Normals',
);

$this->menu=array(
	array('label'=>'Create LhProllNormal', 'url'=>array('create')),
	array('label'=>'Manage LhProllNormal', 'url'=>array('admin')),
);
?>

<h1>Lh Proll Normals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
