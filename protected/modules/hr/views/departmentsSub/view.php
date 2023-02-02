<?php
$this->breadcrumbs=array(
	'Sections Subs'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List SectionsSub', 'url'=>array('index')),
	array('label'=>'Create SectionsSub', 'url'=>array('create')),
	array('label'=>'Update SectionsSub', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SectionsSub', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SectionsSub', 'url'=>array('admin')),
);
?>

<h1>View SectionsSub #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'section_id',
		'title',
	),
)); ?>
