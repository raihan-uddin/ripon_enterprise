<?php
$this->breadcrumbs=array(
	'Ah Amount Prolls',
);

$this->menu=array(
	array('label'=>'Create AhAmountProll', 'url'=>array('create')),
	array('label'=>'Manage AhAmountProll', 'url'=>array('admin')),
);
?>

<h1>Ah Amount Prolls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
