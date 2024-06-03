<?php
/* @var $this WarrantyClaimsController */
/* @var $model WarrantyClaims */

$this->breadcrumbs=array(
	'Warranty Claims'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List WarrantyClaims', 'url'=>array('index')),
	array('label'=>'Create WarrantyClaims', 'url'=>array('create')),
	array('label'=>'Update WarrantyClaims', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WarrantyClaims', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WarrantyClaims', 'url'=>array('admin')),
);
?>

<h1>View WarrantyClaims #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'claim_type',
		'claim_date',
		'customer_id',
		'claim_description',
		'claim_status',
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
	),
)); ?>
