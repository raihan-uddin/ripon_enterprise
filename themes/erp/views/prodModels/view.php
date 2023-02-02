<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">View Product Info</h3>

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
        <div class="table-responsive">
            <table class="table table-striped table-sm table-hover table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>Category</th>
                    <th>Sub-Category</th>
                    <th>Product</th>
                    <th>Code</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo ProdItems::model()->findByPk($model->item_id)->item_name; ?></td>
                    <td><?php echo ProdBrands::model()->findByPk($model->brand_id)->brand_name; ?></td>
                    <td><?php echo $model->model_name; ?></td>
                    <td><?php echo $model->code; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
