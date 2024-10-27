
<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Return', 'url' => array('admin')),
        array('name' => 'Approve'),
    ),
));

Yii::app()->clientScript->registerCoreScript("jquery.ui");
?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>
<style>
    .hidden {
        display: none;
    }
</style>


<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'sell-return-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
    )); ?>


    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                Approve Return Request #<?php echo $model->id; ?> </h3>
        </div>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <?php echo $form->labelEx($model, 'return_date', array('class' => 'col-md-4')); ?>
                        <div class="col-md-8">
                            <?php echo $model->return_date; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php echo $form->labelEx($model, 'customer_id', array('class' => 'col-md-4')); ?>
                        <div class="col-md-8">
                            <?php echo $model->customer->company_name; ?>
                        </div>
                    </div>

                    <!-- return_type -->
                    <div class="form-group row">
                        <?php echo $form->labelEx($model, 'return_type', array('class' => 'col-md-4')); ?>
                        <div class="col-md-8">
                            <?php echo $model->return_type == SellReturn::CASH_RETURN ? "CASH RETURN" : "WARRANTY/REPLACEMENT"; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <?php echo $form->labelEx($model, 'return_amount', array('class' => 'col-md-4')); ?>
                        <div class="col-md-8">
                            <?php echo $model->return_amount; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php echo $form->labelEx($model, 'costing', array('class' => 'col-md-4')); ?>
                        <div class="col-md-8">
                            <?php echo $model->costing; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php echo $form->labelEx($model, 'remarks', array('class' => 'col-md-4')); ?>
                        <div class="col-md-8">
                            <?php echo $model->remarks; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Product SL No</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Replace Product</th>
                            <th class="text-center">Replace Product SL No</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($model->sellReturnDetails as $detail) {
                            ?>
                            <tr>
                                <td><?php echo $detail->model->model_name; ?></td>
                                <td class="text-center"><?php echo $detail->product_sl_no; ?></td>
                                <td class="text-center"><?php echo $detail->return_qty; ?></td>
                                <td>
                                    <?php 
                                        echo $form->hiddenField($detail, "[]replace_model_id", array(
                                            'id' => 'SellReturnDetails_' . $detail->id . '_replace_model_id',
                                            'value' => $detail->replace_model_id ? $detail->replace_model_id : $detail->model_id
                                        ));
                                    ?>
                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                        'name' => 'replace_model_text',
                                        'value' => $detail->model->model_name,  
                                        'source' => $this->createUrl('/prodModels/Jquery_showprodSearch'),
                                        'options' => array(
                                            'minLength' => '1',
                                            'select' => 'js:function(event, ui) {
                                                $("#SellReturnDetails_' . $detail->id . '_replace_model_id").val(ui.item.id);
                                                $("#SellReturnDetails_' . $detail->id . '_replace_model_text").val(ui.item.value);
                                                $("#SellReturnDetails_' . $detail->id . '_replace_product_sl_no").val("");
                                            }'
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'form-control',
                                            'id' => 'SellReturnDetails_' . $detail->id . '_replace_model_text',
                                        ),
                                    ));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                            'name' => 'SellReturnDetails[][replace_product_sl_no]',
                                            'value' => $detail->replace_product_sl_no,
                                            'source' => 'js:function(request, response) {
                                                $.ajax({
                                                    url: "' . $this->createUrl('/inventory/inventory/Jquery_showprodSlNoSearch') . '",
                                                    dataType: "json",
                                                    method: "POST",
                                                    data: {
                                                        q: request.term,
                                                        model_id: $("#SellReturnDetails_' . $detail->id . '_replace_model_id").val()
                                                    },
                                                    success: function(data) {
                                                        response(data);
                                                    }
                                                });
                                            }',
                                            'options' => array(
                                                'minLength' => '1',
                                                'select' => 'js:function(event, ui) {
                                                    $("#SellReturnDetails_' . $detail->id . '_replace_product_sl_no").val(ui.item.value);
                                                    $("#SellReturnDetails_' . $detail->id . '_replace_model_id").val(ui.item.id);
                                                    $("#SellReturnDetails_' . $detail->id . '_replace_model_text").val(ui.item.label);
                                                }',
                                                'create' => 'js:function() {
                                                    var that = this;
                                                    $(this).data("ui-autocomplete")._renderItem = function(ul, item) {
                                                        var listItem = $("<li class=\'list-group-item p-2\'></li>")
                                                            .data("item.autocomplete", item)
                                                            .append(`
                                                                <div class="row align-items-center">
                                                                    <div class="col-12">
                                                                        <p class="m-1">${item.product_sl_no}</p>
                                                                        <p class="mb-0" style="font-size: 10px;">
                                                                            <small><strong>Name:</strong> ${item.name}</small>, <br>
                                                                            <small><strong>Code:</strong> ${item.code}</small>,
                                                                            <small><strong>Sell Price:</strong> ${item.sell_price}</small>,
                                                                            <small><strong>Purchase Price:</strong> ${item.purchase_price}</small>,
                                                                            <small><strong>Stock:</strong> ${item.stock}</small>
                                                                        </p>
                                                                    </div>
                                                                </div>`
                                                            );
                                        
                                                        return listItem.appendTo(ul);
                                                    };
                                                }'
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'form-control',
                                                'id' => 'SellReturnDetails_' . $detail->id . '_replace_product_sl_no',
                                            ),
                                        ));
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-group
            <?php echo $model->hasErrors() ? 'has-error' : ''; ?>">
            <?php echo CHtml::submitButton('Approve', array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>
