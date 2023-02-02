<?php
$this->breadcrumbs=array(
	'Lh Amount Prolls',
);

$this->menu=array(
	array('label'=>'Create LhAmountProll', 'url'=>array('create')),
	array('label'=>'Manage LhAmountProll', 'url'=>array('admin')),
);
?>

<h1>Lh Amount Prolls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
