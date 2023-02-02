<?php
$this->breadcrumbs=array(
	'Working Days'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List WorkingDay', 'url'=>array('index')),
	array('label'=>'Create WorkingDay', 'url'=>array('create')),
	array('label'=>'Update WorkingDay', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WorkingDay', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WorkingDay', 'url'=>array('admin')),
);
?>

<h1>View WorkingDay #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'year',
		'month_id',
		'days_of_month',
		'working_day',
		'working_hour_per_day',
	),
)); ?>
