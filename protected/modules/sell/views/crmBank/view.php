<?php
/* @var $this CrmBankController */
/* @var $model CrmBank */

$this->breadcrumbs = array(
    'Crm Banks' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List CrmBank', 'url' => array('index')),
    array('label' => 'Create CrmBank', 'url' => array('create')),
    array('label' => 'Update CrmBank', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete CrmBank', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage CrmBank', 'url' => array('admin')),
);
?>

<h1>View CrmBank #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ),
)); ?>
