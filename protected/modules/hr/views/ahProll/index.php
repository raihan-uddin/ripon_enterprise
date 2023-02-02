<?php
$this->breadcrumbs=array(
	'Ah Prolls',
);

$this->menu=array(
	array('label'=>'Create AhProll', 'url'=>array('create')),
	array('label'=>'Manage AhProll', 'url'=>array('admin')),
);
?>

<h1>Ah Prolls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
