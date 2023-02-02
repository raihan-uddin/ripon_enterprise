<?php
$this->breadcrumbs=array(
	'Lh Prolls',
);

$this->menu=array(
	array('label'=>'Create LhProll', 'url'=>array('create')),
	array('label'=>'Manage LhProll', 'url'=>array('admin')),
);
?>

<h1>Lh Prolls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
