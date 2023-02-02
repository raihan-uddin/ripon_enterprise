<?php
/* @var $this SellDeliveryController */
/* @var $model SellDelivery */

$this->breadcrumbs = array(
    'Sell Deliveries' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List SellDelivery', 'url' => array('index')),
    array('label' => 'Create SellDelivery', 'url' => array('create')),
    array('label' => 'Update SellDelivery', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete SellDelivery', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage SellDelivery', 'url' => array('admin')),
);
?>

<h1>View SellDelivery #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'sell_order_id',
        'date',
        'max_sl_no',
        'delivery_no',
        'customer_id',
        'grand_total',
        'remarks',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ),
)); ?>
