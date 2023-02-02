<?php
$model_name = ProdModels::model()->nameOfThis($model->fg_model_id);
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Software', 'url' => array('')),
        array('name' => 'Software Settings', 'url' => array('admin')),
        array('name' => 'FG Config (BOM)', 'url' => array('admin')),
        array('name' => 'Update: ' . $model_name),
    ),
//    'delimiter' => ' &rarr; ',
));

echo $this->renderPartial('_form2', array('model' => $model, 'modelDetails' => $modelDetails, 'model_name' => $model_name));
?>