<?php
$this->breadcrumbs=array(
	'Emp Attendances'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmpAttendance', 'url'=>array('index')),
	array('label'=>'Manage EmpAttendance', 'url'=>array('admin')),
);
?>

<h1>Create EmpAttendance</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>