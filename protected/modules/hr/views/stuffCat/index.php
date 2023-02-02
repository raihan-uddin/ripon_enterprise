<?php
$this->breadcrumbs=array(
	'Stuff Cats',
);

$this->menu=array(
	array('label'=>'Create StuffCat', 'url'=>array('create')),
	array('label'=>'Manage StuffCat', 'url'=>array('admin')),
);
?>

<h1>Stuff Cats</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
