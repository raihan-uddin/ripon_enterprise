<?php
$this->breadcrumbs=array(
	'Sections Subs'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SectionsSub', 'url'=>array('index')),
	array('label'=>'Create SectionsSub', 'url'=>array('create')),
	array('label'=>'View SectionsSub', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SectionsSub', 'url'=>array('admin')),
);
?>

<h1>Update SectionsSub <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>