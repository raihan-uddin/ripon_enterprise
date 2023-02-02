<?php
$this->breadcrumbs=array(
	'Emp Attendances',
);

$this->menu=array(
	array('label'=>'Create EmpAttendance', 'url'=>array('create')),
	array('label'=>'Manage EmpAttendance', 'url'=>array('admin')),
);
?>

<h1>Emp Attendances</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
