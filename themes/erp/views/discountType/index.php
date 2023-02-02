<?php
$this->breadcrumbs=array(
	'Discount Types',
);

$this->menu=array(
	array('label'=>'Create DiscountType', 'url'=>array('create')),
	array('label'=>'Manage DiscountType', 'url'=>array('admin')),
);
?>

<h1>Discount Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
