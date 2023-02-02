<?php
/* @var $this ReceivePurchaseController */
/* @var $model ReceivePurchase */

$this->breadcrumbs=array(
	'Receive Purchases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ReceivePurchase', 'url'=>array('index')),
	array('label'=>'Create ReceivePurchase', 'url'=>array('create')),
	array('label'=>'View ReceivePurchase', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ReceivePurchase', 'url'=>array('admin')),
);
?>

<h1>Update ReceivePurchase <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>