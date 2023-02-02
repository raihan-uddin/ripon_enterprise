<?php
$this->breadcrumbs=array(
	'Customer Ab Validations',
);

$this->menu=array(
	array('label'=>'Create CustomerAbValidation', 'url'=>array('create')),
	array('label'=>'Manage CustomerAbValidation', 'url'=>array('admin')),
);
?>

<h1>Customer Ab Validations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
