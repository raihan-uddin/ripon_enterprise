<?php
/* @var $this InvoiceController */
/* @var $model Invoice */

$this->breadcrumbs = array(
    'Invoices' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List Invoice', 'url' => array('index')),
    array('label' => 'Create Invoice', 'url' => array('create')),
    array('label' => 'Update Invoice', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Invoice', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Invoice', 'url' => array('admin')),
);
?>

<h1>View Invoice #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'date',
        'order_id',
        'customer_id',
        'max_sl_no',
        'invoice_no',
        'vat_percentage',
        'vat_amount',
        'discount_percentage',
        'discount_amount',
        'total_amount',
        'grand_total',
        'remarks',
        'is_paid',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ),
)); ?>
