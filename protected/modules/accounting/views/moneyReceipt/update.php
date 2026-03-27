<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Collection', 'url' => array('admin')),
        array('name' => 'Update #' . $model->mr_no),
    ),
));
$this->renderPartial('_formUpdate', array(
    'model'    => $model,
    'customer' => $customer,
));
