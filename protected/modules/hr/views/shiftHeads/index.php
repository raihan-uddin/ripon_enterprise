<?php
$this->breadcrumbs=array(
	'Shift Heads',
);

$this->menu=array(
	array('label'=>'Create ShiftHeads', 'url'=>array('create')),
	array('label'=>'Manage ShiftHeads', 'url'=>array('admin')),
);
?>

<h1>Shift Heads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
