<?php
/* @var $this SellReturnController */
/* @var $model SellReturn */

$this->breadcrumbs=array(
	'Sell Returns'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SellReturn', 'url'=>array('index')),
	array('label'=>'Create SellReturn', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sell-return-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sell-return-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'return_date',
		'customer_id',
		'return_amount',
		'costing',
		'return_type',
		/*
		'remarks',
		'is_deleted',
		'business_id',
		'branch_id',
		'created_by',
		'created_at',
		'updated_by',
		'updated_at',
		'is_opening',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
