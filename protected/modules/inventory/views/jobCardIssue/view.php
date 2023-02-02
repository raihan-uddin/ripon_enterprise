<?php
/* @var $this JobCardIssueController */
/* @var $model JobCardIssue */

$this->breadcrumbs = array(
    'Job Card Issues' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List JobCardIssue', 'url' => array('index')),
    array('label' => 'Create JobCardIssue', 'url' => array('create')),
    array('label' => 'Update JobCardIssue', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete JobCardIssue', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage JobCardIssue', 'url' => array('admin')),
);
?>

<h1>View JobCardIssue #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'job_card_no',
        'order_id',
        'date',
        'max_sl_no',
        'issue_no',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ),
)); ?>
