<?php
$this->breadcrumbs=array(
	'Bonus Titles',
);

$this->menu=array(
	array('label'=>'Create BonusTitles', 'url'=>array('create')),
	array('label'=>'Manage BonusTitles', 'url'=>array('admin')),
);
?>

<h1>Bonus Titles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
