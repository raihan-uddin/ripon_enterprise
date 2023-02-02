<?php
/* @var $this PaymentReceiptController */
/* @var $model PaymentReceipt */

$this->breadcrumbs=array(
	'Payment Receipts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PaymentReceipt', 'url'=>array('index')),
	array('label'=>'Create PaymentReceipt', 'url'=>array('create')),
	array('label'=>'View PaymentReceipt', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PaymentReceipt', 'url'=>array('admin')),
);
?>

<h1>Update PaymentReceipt <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>