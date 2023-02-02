<?php
$this->breadcrumbs=array(
	'Working Days',
);

$this->menu=array(
	array('label'=>'Create WorkingDay', 'url'=>array('create')),
	array('label'=>'Manage WorkingDay', 'url'=>array('admin')),
);
?>

<h1>Working Days</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
