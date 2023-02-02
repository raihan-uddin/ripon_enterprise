<?php
/* @var $this MoneyReceiptController */
/* @var $model MoneyReceipt */

$this->breadcrumbs=array(
	'Money Receipts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MoneyReceipt', 'url'=>array('index')),
	array('label'=>'Create MoneyReceipt', 'url'=>array('create')),
	array('label'=>'View MoneyReceipt', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MoneyReceipt', 'url'=>array('admin')),
);
?>

<h1>Update MoneyReceipt <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>