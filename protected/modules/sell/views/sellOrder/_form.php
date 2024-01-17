<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Order', 'url' => array('admin')),
        array('name' => 'Create'),
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

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Order' : 'Update Order'); ?></h3>

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
                            <?php echo $form->textField($model, 'date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
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
                            <?php echo $form->textField($model, 'exp_delivery_date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD',)); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'exp_delivery_date'); ?></span>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'customer_id', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" data-target-input="nearest">
                            <input type="text" id="customer_id_text" class="form-control">
                            <?php echo $form->hiddenField($model, 'customer_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <?php
                                    echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                        array(
//                                    'class' => '',
                                            'onclick' => "{addDistributor(); $('#dialogAddDistributor').dialog('open');}"));
                                    ?>



                                    <?php
                                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                        'id' => 'dialogAddDistributor',
                                        'options' => array(
                                            'title' => 'Add Customer',
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
                                        function addDistributor() {
                                            <?php
                                            echo CHtml::ajax(array(
                                                'url' => array('/crm/customers/createCustomerFromOutSide'),
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
                                                $('#dialogAddDistributor div.divForForm').html(data.div);
                                                      // Here is the trick: on submit-> once again this function!
                                                $('#dialogAddDistributor div.divForForm form').submit(addDistributor);
                                            }
                                            else
                                            {
                                                $('#dialogAddDistributor div.divForForm').html(data.div);
                                                setTimeout(\"$('#dialogAddDistributor').dialog('close') \",1000);
                                                $('#customer_id_text').val(data.label);
                                                $('#SellOrder_customer_id').val(data.id).change();
                                                $('#SellOrder_city').val(data.city).change();
                                                $('#SellOrder_state').val(data.state).change();
                                            }
                                        }",
                                            ))
                                            ?>
                                            return false;
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
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
                                    .append(`<a> ${item.name} <small><br>City: ${item.city}, State: ${item.state}, Zip: ${item.zip} <br> Contact:  ${item.contact_no}</small></a>`)
                                    .appendTo(ul);
                            };

                        });
                    </script>
                </div>


                <div class="form-group row" style="display: none;">
                    <?php echo $form->labelEx($model, 'city', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'city', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'qty'); ?></span>
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
                <div class="form-group row" style="display: none">
                    <?php echo $form->labelEx($model, 'item_count', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'item_count', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'item_count'); ?></span>
                </div>


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

                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'grand_total', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon4"><i class="fa fa-money"></i> </span>
                            </div>
                            <?php echo $form->textField($model, 'grand_total', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon4", 'readonly' => true)); ?>
                        </div>
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

                                            // Check if there's only one item and trigger select event
                                            if (data.length === 1 && data[0].id) {
                                                $('#model_id_text').val(data[0].label);
                                                $('#product_sl_no').val(data[0].product_sl_no);
                                                $('#SellOrderDetails_model_id').val(data[0].id);
                                                $('#SellOrderDetails_amount').val(data[0].sell_price);
                                                $('#SellOrderDetails_qty').val(1);
                                                $('#SellOrderDetails_row_total').val(data[0].sell_price);
                                                showPurchasePrice(data[0].purchasePrice);
                                            }
                                        }, "json");
                                    },
                                    minLength: 1,
                                    delay: 700,
                                    select: function (event, ui) {
                                        $('#model_id_text').val(ui.item.label);
                                        $('#product_sl_no').val(ui.item.product_sl_no);
                                        $('#SellOrderDetails_model_id').val(ui.item.id);
                                        $('#SellOrderDetails_amount').val(ui.item.sell_price);
                                        $('#SellOrderDetails_qty').val(1);
                                        $('#SellOrderDetails_row_total').val(ui.item.sell_price);
                                        // $('.product_unit_text').html($('#Inventory_unit_id option:selected').text());
                                        showPurchasePrice(ui.item.purchasePrice);

                                        // Move cursor to the next visible input field
                                        var $form = $('#product_sl_no').closest('form');
                                        var $inputs = $form.find(':input:visible:not([disabled])');
                                        var currentIndex = $inputs.index($('#product_sl_no'));
                                        $inputs.eq(currentIndex + 1).focus();
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
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'qty'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-2">
                        <?php echo $form->labelEx($model2, 'amount'); ?>
                        <?php echo $form->textField($model2, 'amount', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                        <!-- Display Costing Amount without margin and padding -->
                        <span class="help-block costing-amount" style="font-size: 12px; color: #333; margin: 0; padding: 0; width: 100%"></span>
                        <span class="help-block" style="color: red; width: 100%"> <?php echo $form->error($model2, 'amount'); ?></span>
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
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('/sell/sellOrder/create', 'render' => true)), array(
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
                    }else {                
                        $("#overlay").fadeIn(300);　   
                        $("#ajaxLoader").show();
                    }
                 }',
            'error' => 'function(xhr) { 
                    $("#overlay").fadeOut(300);
              }',
            'complete' => 'function() {
                    $("#overlay").fadeOut(300);
                 $("#ajaxLoaderReport").hide(); 
              }',
        ), array('class' => 'btn btn-primary btn-md'));
        ?>

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
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('SellOrder_date').value = date.format('YYYY-MM-DD');
        }
    });
    var picker2 = new Lightpick({
        field: document.getElementById('SellOrder_exp_delivery_date'),
        minDate: moment(),
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
            addDeliveryCharge();
            addDiscount();
        });
    });

    function addToList() {
        let model_id = $("#SellOrderDetails_model_id").val();
        let model_id_text = $("#model_id_text").val();
        let unit_price = $("#SellOrderDetails_amount").val();
        let note = $("#SellOrderDetails_note").val();
        let product_sl_no = $("#product_sl_no").val();
        let qty = $("#SellOrderDetails_qty").val();
        let row_total = $("#SellOrderDetails_row_total").val();
        let color = $("#SellOrderDetails_color").val();
        let warranty = $("#SellOrderDetails_warranty").val();
        let isproductpresent = false;
        let temp_codearray = document.getElementsByName("SellOrderDetails[temp_model_id][]");
        let temp_sl_array = document.getElementsByName("SellOrderDetails[temp_product_sl_no][]");

        /*if (temp_codearray.length > 0) {
            for (let l = 0; l < temp_codearray.length; l++) {
                var code = temp_codearray[l].value;
                if (code == model_id) {
                    isproductpresent = true;
                    break;
                }
            }
        }*/
        if (product_sl_no.length > 0) {
            // console.log("length found");
            for (let l = 0; l < temp_sl_array.length; l++) {
                let code = temp_sl_array[l].value;
                if (code === product_sl_no) {
                    isproductpresent = true;
                    break;
                }
            }
            // console.log(isproductpresent);
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
            $("#list tbody").append(`
                <tr class="item">
                    <td>${model_id_text}</td>
                    <td class="text-center">${product_sl_no}</td>
                    <td class="text-center">${warranty}</td>
                    <td class="text-center">${note}</td>
                    <td class="text-center" style="display: none;">${color}</td>
                    <td class="text-center">${unit_price}</td>
                    <td class="text-center">${qty}</td>
                    <td class="text-center">
                        ${row_total}
                        <input type="hidden" class="form-control text-center" value="${qty}" name="SellOrderDetails[temp_qty][]">
                        <input type="hidden" class="form-control text-center" value="${warranty}" name="SellOrderDetails[temp_warranty][]">
                        <input type="hidden" class="form-control text-center" value="${product_sl_no}" name="SellOrderDetails[temp_product_sl_no][]">
                        <input type="hidden" class="form-control text-center" value="${note}" name="SellOrderDetails[temp_note][]">
                        <input type="hidden" class="form-control" value="${color}" name="SellOrderDetails[temp_color][]" >
                        <input type="hidden" class="form-control" value="${model_id}" name="SellOrderDetails[temp_model_id][]" >
                        <input type="hidden" class="form-control" value="${unit_price}" name="SellOrderDetails[temp_unit_price][]" >
                        <input type="hidden" class="form-control row-total" value="${row_total}" name="SellOrderDetails[temp_row_total][]" >
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i> </button>
                    </td>
                </tr>
                `);
            calculateTotal();
            clearDynamicItem(product_sl_no);
        }
    }

    $("#list").on("click", ".dlt", function () {
        $(this).closest("tr").remove();
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
        showPurchasePrice(0);
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
        showPurchasePrice(0);
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
    }

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
    }

    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            // addToList();
            return false;
        }
    });

    function showPurchasePrice(purchasePrice = 0) {
        if (purchasePrice > 0)
            $('.costing-amount').html('<span style="color: green;">P.P: <b>' + parseFloat(purchasePrice).toFixed(2) + '</b></span>');
        else
            $('.costing-amount').html('')
    }

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

