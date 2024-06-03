<?php
/* @var $this WarrantyClaimsController */
/* @var $model WarrantyClaims */

$this->breadcrumbs=array(
	'Warranty Claims'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WarrantyClaims', 'url'=>array('index')),
	array('label'=>'Create WarrantyClaims', 'url'=>array('create')),
	array('label'=>'View WarrantyClaims', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage WarrantyClaims', 'url'=>array('admin')),
);
?>

<h1>Update WarrantyClaims <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>