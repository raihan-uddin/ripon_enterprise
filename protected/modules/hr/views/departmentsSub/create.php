<?php
$this->breadcrumbs=array(
	'Sections Subs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SectionsSub', 'url'=>array('index')),
	array('label'=>'Manage SectionsSub', 'url'=>array('admin')),
);
?>

<h1>Create SectionsSub</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>