<?php
$this->breadcrumbs=array(
	'Emp Attendances'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmpAttendance', 'url'=>array('index')),
	array('label'=>'Create EmpAttendance', 'url'=>array('create')),
	array('label'=>'View EmpAttendance', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmpAttendance', 'url'=>array('admin')),
);
?>

<h1>Update EmpAttendance <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>