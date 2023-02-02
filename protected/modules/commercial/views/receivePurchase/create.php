<?php
/* @var $this ReceivePurchaseController */
/* @var $model ReceivePurchase */

$this->breadcrumbs=array(
	'Receive Purchases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ReceivePurchase', 'url'=>array('index')),
	array('label'=>'Manage ReceivePurchase', 'url'=>array('admin')),
);
?>

<h1>Create ReceivePurchase</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>