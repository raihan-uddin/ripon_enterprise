<?php
/* @var $this CrmBankController */
/* @var $model CrmBank */

$this->breadcrumbs = array(
    'Crm Banks' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List CrmBank', 'url' => array('index')),
    array('label' => 'Create CrmBank', 'url' => array('create')),
    array('label' => 'View CrmBank', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage CrmBank', 'url' => array('admin')),
);
?>

    <h1>Update CrmBank <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>