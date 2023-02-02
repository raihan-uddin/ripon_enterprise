<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">View Price History Of
            Product: <?php echo ProdModels::model()->nameOfThis($model_id); ?></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <!--            <button type="button" class="btn btn-tool" data-card-widget="remove">-->
            <!--                <i class="fa fa-times"></i>-->
            <!--            </button>-->
        </div>
    </div>
    <div class="card-body">

        <div class="table table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr class="odd" style="text-align: center;">
                    <th rowspan="2">Sell Price</th>
                    <th rowspan="2">Discount</th>
                    <th rowspan="2">Ideal Qty</th>
                    <th rowspan="2">Warn Qty</th>
                    <th colspan="2">Date</th>
                    <th rowspan="2">is Active</th>
                </tr>
                <tr class="odd" style="text-align: center;">
                    <th>Start</th>
                    <th>End</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data)) { ?>
                    <?php foreach ($data as $d): ?>
                        <tr class="even" style="text-align: center;">
                            <td>
                                <?php echo $d->sell_price; ?>
                            </td>
                            <td>
                                <?php echo $d->discount . "%"; ?>
                            </td>
                            <td>
                                <?php echo $d->ideal_qty; ?>
                            </td>
                            <td>
                                <?php echo $d->warn_qty; ?>
                            </td>
                            <td>
                                <?php echo $d->start_date; ?>
                            </td>
                            <td>
                                <?php echo $d->end_date; ?>
                            </td>
                            <td>
                                <?php echo SellPrice::model()->statusColor($d->is_active); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <tr style="text-align: center;">
                        <td colspan="7">
                            <div class="flash-error">No result found!</div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
