<div class="row">
    <a class="btn btn-app bg-secondary"
       href="<?= Yii::app()->createUrl("prodModels/create"/*,array("id"=>$data->primaryKey)*/) ?>">
        <span class="badge bg-success">
            <?= ProdModels::model()->count() ?>
        </span>
        <i class="fa fa-barcode"></i> Products
    </a>
    <a class="btn btn-app bg-success" href="<?= Yii::app()->createUrl("crm/customers/admin") ?>">
        <span class="badge bg-purple"><?= Customers::model()->count() ?></span>
        <i class="fa fa-users"></i> Customers
    </a>
    <a class="btn btn-app bg-danger" href="<?= Yii::app()->createUrl("/sell/sellOrder/create") ?>">
        <span class="badge bg-teal"><?= SellOrder::model()->countByAttributes(array(
                'order_type' => SellOrder::NEW_ORDER
            )); ?></span>
        <i class="fa fa-inbox"></i> Orders
    </a>
    <a class="btn btn-app bg-warning">
        <span class="badge bg-info">12</span>
        <i class="fa fa-envelope"></i> Inbox
    </a>
    <a class="btn btn-app bg-info">
        <span class="badge bg-danger">531</span>
        <i class="fa fa-heart"></i> Likes
    </a>
</div>