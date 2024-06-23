<?php
/* @var $this SellReturnController */
/* @var $model SellReturn */
/* @var $model2 SellReturnDetails */
/* @var $form CActiveForm */
?>

<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Return-Replacement', 'url' => array('admin')),
        array('name' => 'Create'),
    ),
//    'delimiter' => ' &rarr; ',
));
Yii::app()->clientScript->registerCoreScript("jquery.ui");
?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>


<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'sell-return-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
    )); ?>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Return/Replacement' : 'Update Return/Replacement'); ?></h3>

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
                <div class="col-sm-12 col-md-3">
                    <div class="form-group row">
                        <?php echo $form->labelEx($model, 'return_type', ['class' => 'col-sm-4 col-form-label']); ?>
                        <div class="col-sm-8">
                            <?php
                            echo $form->dropDownList(
                                $model, 'return_type', SellReturn::RETURN_TYPE_ARR, array(
//                                'prompt' => 'Select',
                                'class' => 'form-control',
                                /* 'options' => array(
                                     '' => array('selected' => 'selected')
                                 ),*/
                            ));
                            ?>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model, 'return_type'); ?></span>
                    </div>

                    <div class="form-group row" style="">
                        <?php echo $form->labelEx($model, 'return_date', ['class' => 'col-sm-4 col-form-label']); ?>
                        <div class="col-sm-8">
                            <div class="input-group" id="entry_date" data-target-input="nearest">
                                <?php echo $form->textField($model, 'return_date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model, 'return_date'); ?></span>
                    </div>

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
                                                    'url' => array('/sell/customers/createCustomerFromOutSide'),
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
                                                        $('#SellReturn_customer_id').val(data.id).change();
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
                                        $.post('<?php echo Yii::app()->baseUrl ?>/index.php/sell/customers/Jquery_customerSearch', {
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
                                        $('#SellReturn_customer_id').val(ui.item.id);
                                        $('#SellReturn_city').val(ui.item.city);
                                        $('#SellReturn_state').val(ui.item.state);
                                    }
                                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                    return $("<li></li>")
                                        .data("item.autocomplete", item)
                                        .append(`<a> ${item.name} <small><br>ID: ${item.id}, <br> Contact:  ${item.contact_no}</small></a>`)
                                        .appendTo(ul);
                                };

                            });
                        </script>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 cash-return">
                    <div class="form-group row" style="">
                        <?php echo $form->labelEx($model, 'discount', ['class' => 'col-sm-4 col-form-label']); ?>
                        <div class="col-sm-8">
                            <?php echo $form->textField($model, 'discount', array('maxlength' => 255, 'class' => 'form-control', 'onkeyup' => 'addDiscount();')); ?>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model, 'discount'); ?></span>
                    </div>


                    <div class="form-group row cash-return" style="">
                        <?php echo $form->labelEx($model, 'return_amount', ['class' => 'col-sm-4 col-form-label']); ?>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3"><i class="fa fa-money"></i> </span>
                                </div>
                                <?php echo $form->textField($model, 'return_amount', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon3", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model, 'return_amount'); ?></span>
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
                        <div class="form-group col-sm-12 col-md-2">
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
                                                                $('#SellReturnDetails_model_id').val(data.value);
                                                                $('#model_id_text').val(data.label);
//                                                                $('#SellReturnDetails_unit_id').val(data.unit_id);
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
                                                    $('#SellReturnDetails_model_id').val(data[0].id);
                                                    $('#SellReturnDetails_amount').val(data[0].sell_price);
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
                                            $('#SellReturnDetails_model_id').val(ui.item.id);
                                            $('#SellReturnDetails_amount').val(ui.item.sell_price);
                                            showPurchasePrice(ui.item.purchasePrice);
                                            showCurrentStock(ui.item.stock);

                                            // Move cursor to the next visible input field
                                            var $form = $('#model_id_text').closest('form');
                                            var $inputs = $form.find(':input:visible:not([disabled])');
                                            var currentIndex = $inputs.index($('#model_id_text'));
                                            $inputs.eq(currentIndex + 1).focus();
                                            ifDamageReturnOnProductAdd();
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
                        <div class="form-group col-sm-12 col-md-2">
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
                                                "model_id": $('#SellReturnDetails_model_id').val(),
                                            }, function (data) {
                                                response(data);
                                                // console.log(`length: ${data.length}, data: ${JSON.stringify(data)}`);
                                                // Check if there's only one item and trigger select event
                                                if (data.length === 1 && data[0].id) {
                                                    $('#model_id_text').val(data[0].label);
                                                    $('#product_sl_no').val(data[0].product_sl_no);
                                                    $('#SellReturnDetails_model_id').val(data[0].id);
                                                    if (data[0].id == prev_product_id)
                                                        sp = prev_sell_price
                                                    else
                                                        sp = data[0].sell_price
                                                    $('#SellReturnDetails_amount').val(sp);
                                                    $('#SellReturnDetails_qty').val(1);
                                                    $('#SellReturnDetails_row_total').val(sp);
                                                    showPurchasePrice(data[0].purchasePrice);
                                                    showCurrentStock(data[0].stock);

                                                    // Trigger select event
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
                                            $('#SellReturnDetails_model_id').val(ui.item.id);
                                            if (ui.item.id == prev_product_id)
                                                sp = prev_sell_price
                                            else
                                                sp = ui.item.sell_price
                                            console.log(`Prev Product ID: ${prev_product_id}, Prev Sell Price: ${prev_sell_price}, Current Product ID: ${ui.item.id}, Current Sell Price: ${ui.item.sell_price}`);
                                            $('#SellReturnDetails_amount').val(sp);
                                            $('#SellReturnDetails_qty').val(1);
                                            $('#SellReturnDetails_row_total').val(sp);
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
                        <div class="form-group col-sm-12 col-md-2">
                            <?php echo $form->labelEx($model2, 'qty'); ?>
                            <?php echo $form->textField($model2, 'qty', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                            <!-- Display Stock without margin and padding -->
                            <span class="help-block current-stock"
                                  style="font-size: 12px; color: #333; margin: 0; padding: 0; width: 100%"></span>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model2, 'qty'); ?></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-2 cash-return">
                            <?php echo $form->labelEx($model2, 'amount'); ?>
                            <?php echo $form->textField($model2, 'amount', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                            <!-- Display Costing Amount without margin and padding -->
                            <?php echo $form->hiddenField($model2, 'pp', array('maxlength' => 255, 'class' => 'form-control pp')); ?>
                            <span class="help-block costing-amount"
                                  style="font-size: 12px; color: #333; margin: 0; padding: 0; width: 100%"></span>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model2, 'amount'); ?></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-2 cash-return">
                            <?php echo $form->labelEx($model2, 'row_total'); ?>
                            <?php echo $form->textField($model2, 'row_total', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model2, 'row_total'); ?></span>
                        </div>

                        <div class="card card-danger col-md-12 replace-product" style="display: none;">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-2 replace-product">
                                    <?php echo $form->labelEx($model2, 'replace_model_id'); ?>
                                    <div class="input-group" data-target-input="nearest">
                                        <input type="text" id="replace_model_id_text" class="form-control">
                                        <?php echo $form->hiddenField($model2, 'model_id', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                                        <div class="input-group-append" onclick="resetReplaceProduct()">
                                <span class="input-group-text">
                                 <i class="fa fa-refresh"></i>
                                </span>
                                        </div>
                                    </div>
                                    <span class="help-block"
                                          style="color: red; width: 100%"> <?php echo $form->error($model, 'model_id'); ?></span>

                                    <script>
                                        $(document).ready(function () {
                                            $('#replace_model_id_text').autocomplete({
                                                source: function (request, response) {
                                                    var search = request.term;
                                                    $.post('<?php echo Yii::app()->baseUrl ?>/index.php/prodModels/Jquery_showprodSearch', {
                                                        "q": search,
                                                    }, function (data) {
                                                        response(data);

                                                        // Check if there's only one item and trigger select event
                                                        if (data.length === 1 && data[0].id) {
                                                            $('#replace_model_id_text').val(data[0].value);
                                                            $('#SellReturnDetails_model_id').val(data[0].id);
                                                            $('#SellReturnDetails_amount').val(data[0].sell_price);
                                                            // Trigger select event
                                                            $('#replace_model_id_text').autocomplete('option', 'select').call($('#replace_model_id_text')[0], null, {
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
                                                    $('#replace_model_id_text').val(ui.item.value);
                                                    $('#SellReturnDetails_model_id').val(ui.item.id);
                                                    $('#SellReturnDetails_amount').val(ui.item.sell_price);
                                                    showPurchasePrice(ui.item.purchasePrice);
                                                    showCurrentStock(ui.item.stock);

                                                    // Move cursor to the next visible input field
                                                    var $form = $('#replace_model_id_text').closest('form');
                                                    var $inputs = $form.find(':input:visible:not([disabled])');
                                                    var currentIndex = $inputs.index($('#replace_model_id_text'));
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
                                <div class="form-group col-sm-12 col-md-2 replace-product">
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
                                                        "model_id": $('#SellReturnDetails_model_id').val(),
                                                    }, function (data) {
                                                        response(data);
                                                        // console.log(`length: ${data.length}, data: ${JSON.stringify(data)}`);
                                                        // Check if there's only one item and trigger select event
                                                        if (data.length === 1 && data[0].id) {
                                                            $('#replace_model_id_text').val(data[0].label);
                                                            $('#product_sl_no').val(data[0].product_sl_no);
                                                            $('#SellReturnDetails_model_id').val(data[0].id);
                                                            if (data[0].id == prev_product_id)
                                                                sp = prev_sell_price
                                                            else
                                                                sp = data[0].sell_price
                                                            $('#SellReturnDetails_amount').val(sp);
                                                            $('#SellReturnDetails_qty').val(1);
                                                            $('#SellReturnDetails_row_total').val(sp);
                                                            showPurchasePrice(data[0].purchasePrice);
                                                            showCurrentStock(data[0].stock);

                                                            // Trigger select event
                                                            $('#product_sl_no').autocomplete('option', 'select').call($('#product_sl_no')[0], null, {
                                                                item: data[0]
                                                            });
                                                        }
                                                    }, "json");
                                                },
                                                minLength: 1,
                                                delay: 700,
                                                select: function (event, ui) {
                                                    $('#replace_model_id_text').val(ui.item.label);
                                                    $('#product_sl_no').val(ui.item.product_sl_no);
                                                    $('#SellReturnDetails_model_id').val(ui.item.id);
                                                    if (ui.item.id == prev_product_id)
                                                        sp = prev_sell_price
                                                    else
                                                        sp = ui.item.sell_price
                                                    console.log(`Prev Product ID: ${prev_product_id}, Prev Sell Price: ${prev_sell_price}, Current Product ID: ${ui.item.id}, Current Sell Price: ${ui.item.sell_price}`);
                                                    $('#SellReturnDetails_amount').val(sp);
                                                    $('#SellReturnDetails_qty').val(1);
                                                    $('#SellReturnDetails_row_total').val(sp);
                                                    showPurchasePrice(ui.item.purchasePrice);
                                                    showCurrentStock(ui.item.stock, 'replace-current-stock');

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
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-1">
                            <button class="btn  btn-success mt-4" onclick="addToList()" type="button"
                                    title="ADD TO LIST"><i
                                        class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                            </button>
                            <button class="btn  btn-danger mt-4" onclick="resetDynamicItem()" type="button"
                                    title="RESET">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped table-valign-middle" id="list">
                                <thead class="table-info">
                                <tr>
                                    <th style="width: 2%;">SL</th>
                                    <th>Product Name</th>
                                    <th style="width: 20%;" class="text-center">Product Sl No</th>
                                    <th style="width: 10%;" class="text-center">Qty</th>
                                    <th style="width: 20%; display: none;" class="text-center replace-product">Replace
                                        Product
                                    </th>
                                    <th style="width: 10%; display: none;" class="text-center replace-product">SL No
                                    </th>
                                    <th style="width: 10%; display: none;" class="text-center replace-product">Qty</th>
                                    <th style="width: 10%;" class="text-center cash-return">Unit Price</th>
                                    <th style="width: 10%;" class="text-center cash-return">Row Total</th>
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
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>
<script>

    let prev_product_id = 0;
    let prev_sell_price = 0;

    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('SellReturn_return_date').value = date.format('YYYY-MM-DD');
        }
    });

    function resetDynamicItem() {
        resetProduct();
        resetProductSlNo();
        resetReplaceProduct();
        showPurchasePrice(0);
    }

    function resetProduct() {
        $("#model_id_text").val('');
        $("#replace_model_id").val('');
        $("#SellReturnDetails_model_id").val('');
        resetReplaceProduct();
        resetProductSlNo();
        showPurchasePrice(0);
    }

    function resetReplaceProduct() {
        $("#model_id_text").val('');
        $("#SellReturnDetails_model_id").val('');
        resetProductSlNo();
        showPurchasePrice(0);
    }

    function resetProductSlNo() {
        $("#product_sl_no").val('');
        $("#SellReturnDetails_model_id").val('');
        resetReplaceProductSlNo();
    }

    function resetReplaceProductSlNo() {
        $("#replace_product_sl_no").val('');
    }

    function showPurchasePrice(purchasePrice = 0) {
        if (purchasePrice > 0)
            $('.costing-amount').html('<span style="color: green;">P.P: <b>' + parseFloat(purchasePrice).toFixed(2) + '</b></span>');
        else
            $('.costing-amount').html('');
        $("#SellOrderDetails_pp").val(purchasePrice);
    }

    function showCurrentStock(stock = 0, className = 'current-stock') {
        if (stock >= 0) {
            $('.' + className).html('<span style="color: green;">Stock: <b>' + parseFloat(stock).toFixed(2) + '</b></span>');
        } else
            $('.' + className).html('<span style="color: green;">Stock: <b>' + parseFloat(stock).toFixed(2) + '</b></span>');
    }

    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            addToList();
            return false;
        }
    });

    $("#SellReturn_return_type").change(function () {
        if ($(this).val() == 1) {
            $(".cash-return").show();
            $(".replace-product").hide();
        } else {
            $(".cash-return").hide();
            $(".replace-product").show();
        }
    });

    function isDamageReturn() {
        console.log('isDamageReturn val: ' + $("#SellReturn_return_type").val());
        console.log('isDamageReturn' + $("#SellReturn_return_type").val() === 2);
        return $("#SellReturn_return_type").val() === 2;

    }

    function ifDamageReturnOnProductAdd() {
        console.log('ifDamageReturnOnProductAdd');
        console.log('isDamageReturn: ' + isDamageReturn());
        if (isDamageReturn()) {
            $("#replace_model_id_text").text($("#model_id_text").val());
            $("#replace_model_id").val($("#SellReturnDetails_model_id").val());
        }
    }
</script>