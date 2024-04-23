<?php
/* @var $this BusinessController */
/* @var $model Business */

$this->breadcrumbs=array(
	'Businesses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Business', 'url'=>array('index')),
	array('label'=>'Create Business', 'url'=>array('create')),
	array('label'=>'View Business', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Business', 'url'=>array('admin')),
);
?>

<h1>Update Business <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>