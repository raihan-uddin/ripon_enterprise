<div class="row">
    <div class="col-lg-3 col-6">

        <div class="small-box bg-info">
            <div class="inner">
                <?php
                $criteria = new CDbCriteria();
                $criteria->addColumnCondition(['order_type' => SellOrder::NEW_ORDER]);
                $criteria->select = "COUNT(*) as id";
                $data = SellOrder::model()->findByAttributes([], $criteria);
                ?>
                <h3><?= $data ? $data->id : 0 ?></h3>
                <p>Total Orders</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box bg-success">
            <div class="inner">
                <?php
                $criteria = new CDbCriteria();
                $criteria->addColumnCondition(['order_type' => SellOrder::REPAIR_ORDER]);
                $criteria->select = "COUNT(*) as id";
                $data = SellOrder::model()->findByAttributes([], $criteria);
                ?>
                <h3><?= $data ? $data->id : 0 ?><!--<sup style="font-size: 20px">%</sup>--></h3>
                <p>Total Quotation</p>
            </div>
            <div class="icon">
                <i class="fa fa-star"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <?php
                $criteria = new CDbCriteria();
                $criteria->select = "COUNT(*) as id";
                $data = Customers::model()->findByAttributes([], $criteria);
                ?>
                <h3><?= $data ? $data->id : 0 ?></h3>
                <p>Customer</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box bg-danger">
            <div class="inner">
                <h3>65</h3>
                <p>Unique Visitors</p>
            </div>
            <div class="icon">
                <i class="fa fa-pie-chart"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

</div>