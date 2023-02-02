<?php
/* @var $this ExpenseHeadController */
/* @var $model ExpenseHead */

$this->breadcrumbs = array(
    'Expense Heads' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => 'List ExpenseHead', 'url' => array('index')),
    array('label' => 'Create ExpenseHead', 'url' => array('create')),
    array('label' => 'Update ExpenseHead', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete ExpenseHead', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage ExpenseHead', 'url' => array('admin')),
);
?>

<h1>View ExpenseHead #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'title',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ),
)); ?>
