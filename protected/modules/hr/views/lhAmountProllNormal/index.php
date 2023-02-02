<?php
$this->breadcrumbs=array(
	'Lh Amount Proll Normals',
);

$this->menu=array(
	array('label'=>'Create LhAmountProllNormal', 'url'=>array('create')),
	array('label'=>'Manage LhAmountProllNormal', 'url'=>array('admin')),
);
?>

<h1>Lh Amount Proll Normals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
