<?php
/* @var $this ExpenseController */
/* @var $model Expense */

$this->breadcrumbs=array(
	'Expenses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Expense', 'url'=>array('index')),
	array('label'=>'Create Expense', 'url'=>array('create')),
	array('label'=>'Update Expense', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Expense', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Expense', 'url'=>array('admin')),
);
?>

<h1>View Expense #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'max_sl_no',
		'entry_no',
		'date',
		'amount',
		'remarks',
		'is_approved',
		'created_by',
		'created_at',
		'updated_by',
		'updated_at',
	),
)); ?>
