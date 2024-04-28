<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Order', 'url' => array('admin')),
        array('name' => 'Update Order:' . $model->so_no),
    ),
//    'delimiter' => ' &rarr; ',
));
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'bom-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
Yii::app()->clientScript->registerCoreScript("jquery.ui");

?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<!--<div style="width: 100%;">
    <a class="btn btn-danger text-right mb-2" type="button"
       href="<?php /*= Yii::app()->baseUrl . '/index.php/sell/sellOrder/admin' */ ?>"><i class="fa fa-arrow-left"></i> Back
    </a>
</div>-->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Order' : 'Update Order:' . $model->so_no); ?></h3>

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
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'date', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" id="entry_date" data-target-input="nearest">
                            <?php echo $form->textField($model, 'date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => $model->date)); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'date'); ?></span>
                </div>
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'order_type', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php
                        echo $form->dropDownList(
                            $model, 'order_type', [SellOrder::NEW_ORDER => 'NEW', SellOrder::REPAIR_ORDER => 'QUOTATION'], array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'order_type'); ?></span>
                </div>
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'cash_due', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php
                        echo $form->dropDownList(
                            $model, 'cash_due', Lookup::items('cash_due'), array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'cash_due'); ?></span>
                </div>
                <div class="form-group row" style="display: none;">
                    <?php echo $form->labelEx($model, 'exp_delivery_date', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" id="exp_delivery_date" data-target-input="nearest">
                            <?php echo $form->textField($model, 'exp_delivery_date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => $model->exp_delivery_date)); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'exp_delivery_date'); ?></span>
                </div>
            </div>

            <?php
            $customer = Customers::model()->findByPk($model->customer_id);

            ?>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'customer_id', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <input type="text" id="customer_id_text" class="form-control" readonly
                               value="<?= $customer->company_name ?>">
                        <?php echo $form->hiddenField($model, 'customer_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'customer_id'); ?></span>

                    <script>
                        $(document).ready(function () {
                            $('#customer_id_text').autocomplete({
                                source: function (request, response) {
                                    var search = request.term;
                                    $.post('<?php echo Yii::app()->baseUrl ?>/index.php/crm/customers/Jquery_customerSearch', {
                                            "q": search,
                                        },
                                        function (data) {
                                            response(data);
                                        }, "json");
                                },
                                minLength: 1,
                                delay: 700,
                                autoFocus: true,
                                select: function (event, ui) {
                                    $('#customer_id_text').val(ui.item.value);
                                    $('#SellOrder_customer_id').val(ui.item.id);
                                    $('#SellOrder_city').val(ui.item.city);
                                    $('#SellOrder_state').val(ui.item.state);
                                }
                            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                return $("<li></li>")
                                    .data("item.autocomplete", item)
                                    .append(`<a> ${item.name} <small><br>ID: ${item.id} <br> Contact:  ${item.contact_no}</small></a>`)
                                    .appendTo(ul);
                            };

                        });
                    </script>
                </div>


                <div class="form-group row" style="display: none;">
                    <?php echo $form->labelEx($model, 'city', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'city', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true, 'value' => $customer->city)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'qty'); ?></span>
                </div>

                <div class="form-group row" style="display: none;">
                    <?php echo $form->labelEx($model, 'state', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'state', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true, 'value' => $customer->state)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'state'); ?></span>
                </div>

                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'total_amount', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3"><i class="fa fa-money"></i> </span>
                            </div>
                            <?php echo $form->textField($model, 'total_amount', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon3", 'readonly' => true)); ?>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'total_amount'); ?></span>
                </div>

                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'vat', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                            <?php echo $form->textField($model, 'vat_percentage', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '%', "aria-label" => "%", "aria-describedby" => "basic-addon1")); ?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-money"></i> </span>
                            </div>
                            <?php echo $form->textField($model, 'vat_amount', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '%', "aria-label" => "%", "aria-describedby" => "basic-addon2", 'readonly' => true)); ?>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'vat_percentage'); ?></span>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'delivery_charge', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'delivery_charge', array('maxlength' => 255, 'class' => 'form-control', 'onkeyup' => 'addDeliveryCharge();')); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'delivery_charge'); ?></span>
                </div>

                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'discount_amount', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'discount_amount', array('maxlength' => 255, 'class' => 'form-control', 'onkeyup' => 'addDiscount();')); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'discount_amount'); ?></span>
                </div>

                <div class="form-group row" style="display: none">
                    <?php echo $form->labelEx($model, 'item_count', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'item_count', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true, 'value' => count($model3))); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'item_count'); ?></span>
                </div>


                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'grand_total', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon4"><i class="fa fa-money"></i> </span>
                            </div>
                            <?php echo $form->textField($model, 'grand_total', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon4", 'readonly' => true)); ?>
                        </div>
                        <span class="help-block current-costing-amount"
                              style="font-size: 12px; color: #333; margin: 0; padding: 0; width: 100%"></span>
                        <i class="fa fa-eye eye-icon" style="cursor: pointer;"></i>
                    </div>

                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'grand_total'); ?></span>
                </div>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Items</h3>

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
                <div class="row">
                    <div class="form-group col-xs-12 col-md-3">
                        <?php echo $form->labelEx($model2, 'model_id'); ?>
                        <div class="input-group" data-target-input="nearest">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <?php
                                    echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                        array(
//                                    'class' => '',
                                            'onclick' => "{addProdModel(); $('#dialogAddProdModel').dialog('open');}"));
                                    ?>

                                    <?php
                                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                        'id' => 'dialogAddProdModel',
                                        'options' => array(
                                            'title' => 'Add Product',
                                            'autoOpen' => false,
                                            'modal' => true,
                                            'width' => '1288px',
                                            'left' => '30px',
                                            'resizable' => false,
                                        ),
                                    ));
                                    ?>
                                    <div class="divForForm">
                                        <div class="ajaxLoaderFormLoad" style="display: none;"><img
                                                    src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/>
                                        </div>

                                    </div>

                                    <?php $this->endWidget(); ?>

                                    <script type="text/javascript">
                                        // here is the magic
                                        function addProdModel() {
                                            <?php
                                            echo CHtml::ajax(array(
                                                'url' => array('/prodModels/createProdModelsFromOutSide'),
                                                'data' => "js:$(this).serialize()",
                                                'type' => 'post',
                                                'dataType' => 'json',
                                                'beforeSend' => "function(){
                                                        $('.ajaxLoaderFormLoad').show();
                                                    }",
                                                'complete' => "function(){
                                                        $('.ajaxLoaderFormLoad').hide();
                                                    }",
                                                'success' => "function(data){
                                                            if (data.status == 'failure')
                                                            {
                                                                $('#dialogAddProdModel div.divForForm').html(data.div);
                                                                      // Here is the trick: on submit-> once again this function!
                                                                $('#dialogAddProdModel div.divForForm form').submit(addProdModel);
                                                            }
                                                            else
                                                            {
                                                                $('#dialogAddProdModel div.divForForm').html(data.div);
                                                                setTimeout(\"$('#dialogAddProdModel').dialog('close') \",1000);
                                                                $('#SellOrderDetails_model_id').val(data.value);
                                                                $('#model_id_text').val(data.label);
//                                                                $('#SellOrderDetails_unit_id').val(data.unit_id);
//                                                                $('#product_unit_text').html($('#SellOrderDetails_unit_id option:selected').text());
                                                            }
                                                        }",
                                            ))
                                            ?>
                                            return false;
                                        }
                                    </script>
                                </div>
                            </div>
                            <input type="text" id="model_id_text" class="form-control">
                            <?php echo $form->hiddenField($model2, 'model_id', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                            <div class="input-group-append" onclick="resetProduct()">
                                <span class="input-group-text">
                                 <i class="fa fa-refresh"></i>
                                </span>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model, 'model_id'); ?></span>

                        <script>
                            $(document).ready(function () {
                                $('#model_id_text').autocomplete({
                                    source: function (request, response) {
                                        var search = request.term;
                                        $.post('<?php echo Yii::app()->baseUrl ?>/index.php/prodModels/Jquery_showprodSearch', {
                                            "q": search,
                                        }, function (data) {
                                            response(data);

                                            // Check if there's only one item and trigger select event
                                            if (data.length === 1 && data[0].id) {
                                                $('#model_id_text').val(data[0].value);
                                                $('#SellOrderDetails_model_id').val(data[0].id);
                                                $('#SellOrderDetails_amount').val(data[0].sell_price);
                                                // Trigger select event
                                                $('#model_id_text').autocomplete('option', 'select').call($('#model_id_text')[0], null, {
                                                    item: data[0]
                                                });
                                                showPurchasePrice(data[0].purchasePrice);
                                                showCurrentStock(data[0].stock);
                                            }
                                        }, "json");
                                    },
                                    minLength: 1,
                                    delay: 700,
                                    select: function (event, ui) {
                                        $('#model_id_text').val(ui.item.value);
                                        $('#SellOrderDetails_model_id').val(ui.item.id);
                                        $('#SellOrderDetails_amount').val(ui.item.sell_price);
                                        showPurchasePrice(ui.item.purchasePrice);
                                        showCurrentStock(ui.item.stock);

                                        // Move cursor to the next visible input field
                                        var $form = $('#model_id_text').closest('form');
                                        var $inputs = $form.find(':input:visible:not([disabled])');
                                        var currentIndex = $inputs.index($('#model_id_text'));
                                        $inputs.eq(currentIndex + 1).focus();
                                    }
                                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                    // Use Bootstrap styling for the autocomplete results
                                    var listItem = $("<li class='list-group-item p-2'></li>")
                                        .data("item.autocomplete", item)
                                        .append(`
                                        <div class="row align-items-center">
                                            <div class="col-10 0">
                                                <p class="m-1">${item.name}</p>
                                                <p class="m-1">
                                                    <small><strong>Code:</strong> ${item.code}</small>,
                                                    <small><strong>Purchase Price:</strong> ${item.purchasePrice}</small>,
                                                    <small><strong>Selling Price:</strong> ${item.sell_price}</small>
                                                    <small><strong>Stock:</strong> ${item.stock}</small>
                                                </p>
                                            </div>
                                        </div>`);

                                    return listItem.appendTo(ul);
                                };
                            });


                        </script>
                    </div>
                    <div class="form-group col-sm-12 col-md-3">
                        <?php echo $form->labelEx($model, 'product_sl_no'); ?>

                        <div class="input-group" data-target-input="nearest">
                            <input type="text" id="product_sl_no" class="form-control">
                            <div class="input-group-append" onclick="resetProductSlNo()">
                                <span class="input-group-text">
                                 <i class="fa fa-refresh"></i>
                                </span>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model, 'product_sl_no'); ?></span>

                        <script>
                            $(document).ready(function () {
                                $('#product_sl_no').autocomplete({
                                    source: function (request, response) {
                                        var search = request.term;
                                        $.post('<?php echo Yii::app()->baseUrl ?>/index.php/inventory/inventory/Jquery_showprodSlNoSearch', {
                                            "q": search,
                                            "model_id": $('#SellOrderDetails_model_id').val(),
                                        }, function (data) {
                                            response(data);
                                            // console.log(`length: ${data.length}, data: ${JSON.stringify(data)}`);

                                            // Check if there's only one item and trigger select event
                                            if (data.length === 1 && data[0].id) {
                                                $('#model_id_text').val(data[0].label);
                                                $('#product_sl_no').val(data[0].product_sl_no);
                                                if (data[0].id == prev_product_id)
                                                    sp = prev_sell_price
                                                else
                                                    sp = data[0].sell_price
                                                $('#SellOrderDetails_model_id').val(sp);
                                                $('#SellOrderDetails_amount').val(data[0].sell_price);
                                                $('#SellOrderDetails_qty').val(1);
                                                $('#SellOrderDetails_row_total').val(sp);
                                                showPurchasePrice(data[0].purchasePrice);
                                                showCurrentStock(data[0].stock);
                                                // trigger select event
                                                $('#product_sl_no').autocomplete('option', 'select').call($('#product_sl_no')[0], null, {
                                                    item: data[0]
                                                });
                                            }
                                        }, "json");
                                    },
                                    minLength: 1,
                                    delay: 700,
                                    select: function (event, ui) {
                                        $('#model_id_text').val(ui.item.label);
                                        $('#product_sl_no').val(ui.item.product_sl_no);
                                        $('#SellOrderDetails_model_id').val(ui.item.id);
                                        if (ui.item.id == prev_product_id)
                                            sp = prev_sell_price
                                        else
                                            sp = ui.item.sell_price
                                        $('#SellOrderDetails_amount').val(sp);
                                        $('#SellOrderDetails_qty').val(1);
                                        $('#SellOrderDetails_row_total').val(sp);
                                        // $('.product_unit_text').html($('#Inventory_unit_id option:selected').text());
                                        showPurchasePrice(ui.item.purchasePrice);
                                        showCurrentStock(ui.item.stock);

                                        // Move cursor to the next visible input field
                                        var $form = $('#product_sl_no').closest('form');
                                        var $inputs = $form.find(':input:visible:not([disabled])');
                                        var currentIndex = $inputs.index($('#product_sl_no'));
                                        $inputs.eq(currentIndex + 1).focus();

                                        // addToList();
                                    }
                                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                    var listItem = $("<li class='list-group-item p-2'></li>")
                                        .data("item.autocomplete", item)
                                        .append(`
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <p class="m-1">${item.product_sl_no}</p>
                                                <p class="mb-0" style="font-size: 10px;">
                                                    <small><strong>Name:</strong> ${item.name}</small>, <br>
                                                    <small><strong>Code:</strong> ${item.code}</small>,
                                                    <small><strong>Sell Price:</strong> ${item.sell_price}</small>,
                                                    <small><strong>Purchase Price:</strong> ${item.purchasePrice}</small>,
                                                    <small><strong>Stock:</strong> ${item.stock}</small>
                                                </p>
                                            </div>
                                        </div>`);

                                    return listItem.appendTo(ul);
                                };
                            });

                        </script>
                    </div>
                    <div class="form-group col-xs-12 col-md-2">
                        <?php echo $form->labelEx($model2, 'qty'); ?>
                        <?php echo $form->textField($model2, 'qty', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                        <!-- Display Stock without margin and padding -->
                        <span class="help-block current-stock"
                              style="font-size: 12px; color: #333; margin: 0; padding: 0; width: 100%"></span>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'qty'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-2">
                        <?php echo $form->labelEx($model2, 'amount'); ?>
                        <?php echo $form->textField($model2, 'amount', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                        <!-- Display Costing Amount without margin and padding -->
                        <?php echo $form->hiddenField($model2, 'pp', array('maxlength' => 255, 'class' => 'form-control pp')); ?>
                        <span class="help-block costing-amount"
                              style="font-size: 12px; color: #333; margin: 0; padding: 0; width: 100%"></span>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'amount'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-2">
                        <?php echo $form->labelEx($model2, 'row_total'); ?>
                        <?php echo $form->textField($model2, 'row_total', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'row_total'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-2">
                        <?php echo $form->labelEx($model2, 'warranty'); ?>
                        <?php echo $form->textField($model2, 'warranty', array('maxlength' => 255, 'class' => 'form-control warranty')); ?>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'warranty'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-2" style="display: none;">
                        <?php echo $form->labelEx($model2, 'color'); ?>
                        <?php echo $form->textField($model2, 'color', array('maxlength' => 255, 'class' => 'form-control')); ?>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'color'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-2">
                        <?php echo $form->labelEx($model2, 'note'); ?>
                        <?php echo $form->textArea($model2, 'note', array('maxlength' => 255, 'class' => 'form-control', 'style' => 'height: 36px;')); ?>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'note'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-1">
                        <button class="btn  btn-success mt-4" onclick="addToList()" type="button" title="ADD TO LIST"><i
                                    class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        </button>
                        <button class="btn  btn-danger mt-4" onclick="resetDynamicItem()" type="button" title="RESET">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped table-valign-middle" id="list">
                            <thead class="table-info">
                            <tr>
                                <th>SL</th>
                                <th>Product Name</th>
                                <th style="width: 20%;" class="text-center">Product Sl No</th>
                                <th style="width: 10%;" class="text-center">Warranty(Mon.)</th>
                                <th style="width: 10%;" class="text-center">Product Note</th>
                                <th style="width: 10%; display: none;" class="text-center">Color</th>
                                <th style="width: 10%;" class="text-center">Qty</th>
                                <th style="width: 10%;" class="text-center">Unit Price</th>
                                <th style="width: 10%;" class="text-center">Row Total</th>
                                <th style="width: 4%;" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($model3 as $key => $m3) {
                                ?>
                                <tr class="item">
                                    <td class="serial"></td>
                                    <td>
                                        <?= $m3->model_name ?>
                                        <input type="hidden" class="form-control" value="<?= $m3->model_id ?>"
                                               name="SellOrderDetails[temp_model_id][]">
                                    </td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control text-center"
                                                   value="<?= $m3->product_sl_no ?>"
                                                   name=SellOrderDetails[temp_product_sl_no][]">
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control" value="<?= $m3->warranty ?>"
                                                   name="SellOrderDetails[temp_warranty][]">
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control" value="<?= $m3->note ?>"
                                                   name="SellOrderDetails[temp_note][]">
                                        </label>
                                    </td>
                                    <td class="text-center" style="display: none;"><?= $m3->color ?></td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control text-center temp_qty"
                                                   value="<?= $m3->qty ?>"
                                                   name=SellOrderDetails[temp_qty][]">
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control temp_unit_price"
                                                   value="<?= $m3->amount ?>"
                                                   name="SellOrderDetails[temp_unit_price][]">
                                        </label>
                                        <input type="hidden" class="form-control text-center temp-costing"
                                               value="<?= round(($m3->costing / $m3->qty), 2) ?>"
                                               name=SellOrderDetails[temp_pp][]">
                                    </td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control row-total"
                                                   value="<?= $m3->row_total ?>"
                                                   name="SellOrderDetails[temp_row_total][]">
                                        </label>

                                        <input type="hidden" class="form-control" value="<?= $m3->color ?>"
                                               name="SellOrderDetails[temp_color][]">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i>
                                        </button>
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
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php echo $form->textArea($model, 'order_note', array('class' => 'form-control', 'placeholder' => 'Order Note')); ?>
            </div>
            <span class="help-block"
                  style="color: red; width: 100%"> <?php echo $form->error($model, 'order_note'); ?></span>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-md-12">
                <?php
                $totalMrData = MoneyReceipt::model()->totalPaidAmountAndDiscountOfThisInvoice($model->id);
                $totalMr = $totalMrData['collection_amt'];
                $totalMrDiscount = $totalMrData['collection_disc'];
                if ($totalMr > 0) {
                    ?>
                    <div class="alert alert-danger">
                        You've already collect <?= number_format($totalMr, 2) ?> from this invoice.
                        <input type="hidden" id="collectedAmount" value="<?= $totalMr ?>">
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-12">
                <?php
                echo CHtml::ajaxSubmitButton('Update ', CHtml::normalizeUrl(array('/sell/sellOrder/update/id/' . $model->id, 'render' => true)), array(
                    'dataType' => 'json',
                    'type' => 'post',
                    'success' => 'function(data) {
                        $("#ajaxLoader").hide();  
                        if(data.status=="success"){
                            $("#formResult").fadeIn();
                            $("#formResult").html("Data saved successfully.");
                            toastr.success("Data saved successfully.");
                            $("#bom-form")[0].reset();
                            $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                            $("#list").empty();
                            $("#soReportDialogBox").dialog("open");
                            $("#AjFlashReportSo").html(data.soReportInfo).show();
                        }else{
                            //$("#formResultError").html("Data not saved. Please solve the following errors.");
                            $.each(data, function(key, val) {
                                $("#bom-form #"+key+"_em_").html(""+val+"");                                                    
                                $("#bom-form #"+key+"_em_").show();
                            });
                        }       
                    }',
                    'beforeSend' => 'function(){  
                        let count_item =  $(".item").length; 
                        let cash_due = $("#SellOrder_cash_due").val();  
                        let date = $("#SellOrder_date").val();  
                        let customer_id = $("#SellOrder_customer_id").val();  
                        let grand_total = $("#SellOrder_grand_total").val();  
                        let collectedAmount = parseFloat($("#collectedAmount").val()); 
                        collectedAmount = !isNaN(collectedAmount) ? collectedAmount : 0; 
                        if(cash_due == ""){
                            toastr.error("Please select Cash/Due.");
                            return false;
                        }else if(date == ""){
                            toastr.error("Please insert date.");
                            return false;
                        }else if(customer_id == ""){
                            toastr.error("Please select customer from the list!");
                            return false;
                        }else if(count_item <= 0){
                            toastr.error("Please add materials to list.");
                            return false;
                        }else if(grand_total == "" || grand_total <= 0){
                            toastr.error("Grand total amount is 0");
                            return false;
                        }else if(collectedAmount > grand_total){
                            toastr.error("Please delete the collection of this invoice to continue!");
                            return false;
                        }else {                
                            $("#overlay").fadeIn(300);　   
                            $("#ajaxLoader").show();
                        }
                     }',
                    'error' => 'function(xhr) { 
                        // Code to handle errors
                        toastr.error(xhr.responseText); // Displaying error message using Toastr
                        // Optionally, you can display additional error details
                        console.error(xhr.statusText);
                        console.error(xhr.status);
                        console.error(xhr.responseText);
                        $("#overlay").fadeOut(300);
                    }',
                    'complete' => 'function() {
                         $("#overlay").fadeOut(300);
                         $("#ajaxLoaderReport").hide(); 
                    }',
                ), array('class' => 'btn btn-primary btn-md'));
                ?>
            </div>
        </div>

        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>

        <div id="formResult" class="ajaxTargetDiv"></div>
        <div id="formResultError" class="ajaxTargetDivErr"></div>
    </div>
</div>
<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<script>

    let prev_product_id = 0;
    let prev_sell_price = 0;
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        // minDate: moment(),
        onSelect: function (date) {
            document.getElementById('SellOrder_date').value = date.format('YYYY-MM-DD');
        }
    });
    var picker2 = new Lightpick({
        field: document.getElementById('exp_delivery_date'),
        // minDate: moment(),
        onSelect: function (date) {
            document.getElementById('SellOrder_exp_delivery_date').value = date.format('YYYY-MM-DD');
        }
    });

    $(document).ready(function () {
        $(".qty-amount").keyup(function () {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));
        });

        $(".qty-amount").on("keydown keyup", function () {
            let amount = parseFloat($("#SellOrderDetails_amount").val());
            let qty = parseFloat($("#SellOrderDetails_qty").val());
            amount = amount > 0 ? amount : 0;
            qty = qty > 0 ? qty : 0;

            $("#SellOrderDetails_row_total").val((amount * qty).toFixed(2));
        });
        $("#SellOrder_vat_percentage").on("keydown keyup", function () {
            calculateVat();
        });
    });

    function addToList() {
        let model_id = $("#SellOrderDetails_model_id").val();
        let model_id_text = $("#model_id_text").val();
        let unit_price = $("#SellOrderDetails_amount").val();
        unit_price = unit_price > 0 ? unit_price : 0;
        let note = $("#SellOrderDetails_note").val();
        let product_sl_no = $("#product_sl_no").val();
        let qty = $("#SellOrderDetails_qty").val();
        let row_total = $("#SellOrderDetails_row_total").val();
        let color = $("#SellOrderDetails_color").val();
        let warranty = $("#SellOrderDetails_warranty").val();
        let pp = parseFloat($("#SellOrderDetails_pp").val());
        pp = pp > 0 ? pp : 0;
        let isproductpresent = false;
        let temp_codearray = document.getElementsByName("SellOrderDetails[temp_model_id][]");
        let temp_sl_array = document.getElementsByName("SellOrderDetails[temp_product_sl_no][]");


        if (product_sl_no.length > 0) {
            for (let l = 0; l < temp_sl_array.length; l++) {
                let code = temp_sl_array[l].value;
                if (code === product_sl_no) {
                    isproductpresent = true;
                    break;
                }
            }
        }


        if (model_id == "" || model_id_text == "") {
            toastr.error("Please select materials");
            return false;
        } else if (isproductpresent == true) {
            toastr.error(model_id_text + " is already on the list! Please add another!");
            return false;
        } else if (unit_price == "") {
            toastr.error("Please insert unit price");
            return false;
        } else if (qty == "" || qty == 0) {
            toastr.error("Please enter qty");
            return false;
        } else if (row_total == "" || row_total == 0) {
            toastr.error("Please enter qty & amount!");
            return false;
        } else {
            $("#list tbody").prepend(`
                <tr class="item">
                    <td class="serial"></td>
                    <td>
                        ${model_id_text}
                        <input type="hidden" class="form-control" value="${model_id}" name="SellOrderDetails[temp_model_id][]" >
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-center" value="${product_sl_no}" name="SellOrderDetails[temp_product_sl_no][]">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-center" value="${warranty}" name="SellOrderDetails[temp_warranty][]">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-center" value="${note}" name="SellOrderDetails[temp_note][]">
                    </td>
                    <td class="text-center" style="display: none;">
                        <input type="text" class="form-control" value="${color}" name="SellOrderDetails[temp_color][]" >
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-center temp_qty" value="${qty}" name="SellOrderDetails[temp_qty][]">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control temp_unit_price" value="${unit_price}" name="SellOrderDetails[temp_unit_price][]" >
                        <input type="hidden" class="form-control text-center temp-costing" value="${pp}" name="SellOrderDetails[temp_pp][]">
                    </td>
                    <td class="text-center">
                       <input type="text" readonly class="form-control row-total" value="${row_total}" name="SellOrderDetails[temp_row_total][]" >
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i> </button>
                    </td>
                </tr>
                `);
            calculateTotal();
            clearDynamicItem(product_sl_no);

            prev_sell_price = unit_price;
            prev_product_id = model_id;
        }
    }

    $("#list").on("click", ".dlt", function () {
        $(this).closest("tr").remove();
        calculateTotal();
    });

    // on temp_qty change or keyup event calculate row total
    $("#list").on("keyup", ".temp_qty", function () {
        let qty = parseFloat($(this).val());
        let unit_price = parseFloat($(this).closest("tr").find(".temp_unit_price").val());
        qty = qty > 0 ? qty : 0;
        unit_price = unit_price > 0 ? unit_price : 0;
        $(this).closest("tr").find(".row-total").val((qty * unit_price).toFixed(2));
        calculateTotal();
    });


    // on temp_unit_price change or keyup event calculate row total
    $("#list").on("keyup", ".temp_unit_price", function () {
        let unit_price = parseFloat($(this).val());
        let qty = parseFloat($(this).closest("tr").find(".temp_qty").val());
        qty = qty > 0 ? qty : 0;
        unit_price = unit_price > 0 ? unit_price : 0;
        $(this).closest("tr").find(".row-total").val((qty * unit_price).toFixed(2));
        calculateTotal();
    });


    function calculateVat() {
        let total_amount = parseFloat($("#SellOrder_total_amount").val());
        let vat_p = parseFloat($("#SellOrder_vat_percentage").val());
        total_amount = total_amount > 0 ? total_amount : 0;
        vat_p = vat_p > 0 ? vat_p : 0;
        let vat = parseFloat(((vat_p / 100) * total_amount));
        let grand_total = parseFloat(total_amount + vat);
        $("#SellOrder_vat_amount").val(vat.toFixed(2));
        $("#SellOrder_grand_total").val(grand_total.toFixed(2));
    }


    function resetProduct() {
        $("#model_id_text").val('');
        $("#SellOrderDetails_model_id").val('');
        $("#SellOrderDetails_warranty").val('');
        resetProductSlNo();
    }

    function resetProductSlNo() {
        $("#product_sl_no").val('');
    }

    function clearDynamicItem(product_sl_no) {
        if (product_sl_no.length > 0) {
            $("#product_sl_no").val('');
            $("#product_sl_no").focus();
        } else {
            $("#SellOrderDetails_model_id").val('');
            $("#product_sl_no").val('');
            $("#model_id_text").val('');
            $("#product_sl_no").val('');
            $("#SellOrderDetails_amount").val('');
            $("#SellOrderDetails_row_total").val('');
            $("#SellOrderDetails_qty").val('');
            $("#SellOrderDetails_color").val('');
            $("#SellOrderDetails_note").val('');
        }
    }

    function resetDynamicItem() {
        $("#SellOrderDetails_model_id").val('');
        $("#model_id_text").val('');
        $("#product_sl_no").val('');
        $("#SellOrderDetails_amount").val('');
        $("#SellOrderDetails_row_total").val('');
        $("#SellOrderDetails_qty").val('');
        $("#SellOrderDetails_color").val('');
        $("#SellOrderDetails_note").val('');
        $("#SellOrderDetails_warranty").val('');
    }

    function calculateTotal() {
        let item_count = $(".item").length;

        let total = 0;
        $('.row-total').each(function () {
            total += parseFloat($(this).val());
        });


        $("#SellOrder_total_amount").val(total.toFixed(2)).change();
        $("#SellOrder_item_count").val(item_count);

        calculateVat();
        addDeliveryCharge();

        tableSerial();
    }


    function tableSerial() {
        //  get the table tbody tr length
        var i = $('#list tbody tr').length;
        $('#list tbody tr').each(function () {
            $(this).find('.serial').text(i);
            i--;
        });
    }

    tableSerial();

    function addDeliveryCharge() {
        let delivery_charge = parseFloat($("#SellOrder_delivery_charge").val());
        let total_amount = parseFloat($("#SellOrder_total_amount").val());
        let vat_amount = parseFloat($("#SellOrder_vat_amount").val());

        delivery_charge = isNaN(delivery_charge) ? 0 : delivery_charge;
        vat_amount = isNaN(vat_amount) ? 0 : vat_amount;
        total_amount = isNaN(total_amount) ? 0 : total_amount;

        $("#SellOrder_grand_total").val((delivery_charge + total_amount + vat_amount).toFixed(2));
        addDiscount();
    }

    function addDiscount() {
        let delivery_charge = parseFloat($("#SellOrder_delivery_charge").val());
        let total_amount = parseFloat($("#SellOrder_total_amount").val());
        let vat_amount = parseFloat($("#SellOrder_vat_amount").val());
        let discount_amount = parseFloat($("#SellOrder_discount_amount").val());

        delivery_charge = isNaN(delivery_charge) ? 0 : delivery_charge;
        vat_amount = isNaN(vat_amount) ? 0 : vat_amount;
        total_amount = isNaN(total_amount) ? 0 : total_amount;
        discount_amount = isNaN(discount_amount) ? 0 : discount_amount;

        let grand_total = (delivery_charge + total_amount + vat_amount) - discount_amount;

        $("#SellOrder_grand_total").val((grand_total).toFixed(2));

        lossAlert();
    }

    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            addToList();
            return false;
        }
    });


    function showPurchasePrice(purchasePrice = 0) {
        if (purchasePrice > 0)
            $('.costing-amount').html('<span style="color: green;">P.P: <b>' + parseFloat(purchasePrice).toFixed(2) + '</b></span>');
        else
            $('.costing-amount').html('');
        $("#SellOrderDetails_pp").val(purchasePrice);
    }

    function showCurrentStock(stock = 0) {
        if (stock >= 0)
            $('.current-stock').html('<span style="color: green;">Stock: <b>' + parseFloat(stock).toFixed(2) + '</b></span>');
        else
            $('.current-stock').html('<span style="color: red;">Stock: <b>' + parseFloat(stock).toFixed(2) + '</b></span>');
    }

    function calculateTotalCosting() {
        let total_costing = 0;
        if ($(".temp-costing").length > 0) {
            $(".temp-costing").each(function () {
                total_costing += parseFloat($(this).val());
            });
        }
        $(".current-costing-amount").html('<span style="color: green;">Costing: <b>' + parseFloat(total_costing).toFixed(2) + '</b></span>');
        return total_costing;
    }


    function lossAlert() {
        calculateTotalCosting();
        let total_costing = calculateTotalCosting();
        let grand_total = parseFloat($("#SellOrder_grand_total").val());
        grand_total = grand_total > 0 ? grand_total : 0;

        let loss = parseFloat(grand_total - total_costing);
        if (loss < 0) {
            toastr.error("You are going to loss " + parseFloat(loss).toFixed(2) + " BDT from this invoice!");
        }

    }

    document.addEventListener('DOMContentLoaded', function () {
        var eyeIcon = document.querySelector('.eye-icon');
        var helpBlock = document.querySelector('.current-costing-amount');

        // Initially hide the help block
        helpBlock.style.display = 'none';

        eyeIcon.addEventListener('click', function () {
            if (helpBlock.style.display === 'none') {
                helpBlock.style.display = 'block';
            } else {
                helpBlock.style.display = 'none';
            }
        });
    });
</script>

<?php $this->endWidget(); ?>



<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'ORDER VOUCHER PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>

