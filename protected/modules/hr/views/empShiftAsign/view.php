<?php
$this->breadcrumbs=array(
	'Emp Attendances'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmpAttendance', 'url'=>array('index')),
	array('label'=>'Create EmpAttendance', 'url'=>array('create')),
	array('label'=>'Update EmpAttendance', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmpAttendance', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmpAttendance', 'url'=>array('admin')),
);
?>

<h1>View EmpAttendance #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'card_no',
		'date',
		'in_time',
		'out_time',
	),
)); ?>
