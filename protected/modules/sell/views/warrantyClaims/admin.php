<?php
/* @var $this WarrantyClaimsController */
/* @var $model WarrantyClaims */

$this->breadcrumbs=array(
	'Warranty Claims'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List WarrantyClaims', 'url'=>array('index')),
	array('label'=>'Create WarrantyClaims', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#warranty-claims-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Warranty Claims</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'warranty-claims-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'claim_type',
		'claim_date',
		'customer_id',
		'claim_description',
		'claim_status',
		/*
		'resolution_date',
		'resolution_description',
		'total_sp',
		'total_pp',
		'created_by',
		'created_at',
		'updated_by',
		'updatetd_at',
		'is_deleted',
		'business_id',
		'branch_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
