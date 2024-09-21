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
        array('name' => 'Return', 'url' => array('admin')),
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
                    <div class="form-group row" style="display: none">
                        <?php echo $form->labelEx($model, 'return_type', ['class' => 'col-sm-4 col-form-label']); ?>
                        <div class="col-sm-8">
                            <?php
                            echo $form->dropDownList(
                                $model, 'return_type', SellReturn::RETURN_TYPE_ARR, array(
//                                'prompt' => 'Select',
                                'class' => 'form-control',
                                'options' => array(
                                    '' => array('selected' => 'selected'),
                                    SellReturn::DAMAGE_RETURN => array('disabled' => true),
                                ),
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
                        <div class="form-group col-sm-12 col-md-3">
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
                                <div class="input-group-append">
                                    <button class="btn btn-warning btn-sm" type="button" onclick="verifyProductSlNo()">
                                        Verify
                                    </button>
                                    <span class="input-group-text" onclick="resetProductSlNo()">
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
                                            $.post('<?php echo Yii::app()->baseUrl ?>/index.php/sell/sellOrder/Jquery_showSoldProdSlNoSearch', {
                                                "q": search,
                                                "model_id": $('#SellReturnDetails_model_id').val(),
                                                'show_all': <?php echo Inventory::SHOW_ALL_PRODUCT_SL_NO; ?>
                                            }, function (data) {
                                                response(data);
                                                // Check if there's only one item and trigger select event
                                                if (data.length === 1 && data[0].id) {
                                                    $('#model_id_text').val(data[0].label);
                                                    $('#replace_model_id_text').val(data[0].label);
                                                    $('#product_sl_no').val(data[0].product_sl_no);
                                                    $('#SellReturnDetails_model_id').val(data[0].sell_price);
                                                    $('#SellReturnDetails_amount').val(data[0].sell_price).change();
                                                    $('#SellReturnDetails_qty').val(1).change();
                                                    // $('#SellReturnDetails_row_total').val(sp);
                                                    showPurchasePrice(data[0].purchasePrice);

                                                    // Trigger select event
                                                    $('#product_sl_no').autocomplete('option', 'select').call($('#product_sl_no')[0], null, {
                                                        item: data[0]
                                                    });

                                                    addToList();
                                                }
                                            }, "json");
                                        },
                                        minLength: 1,
                                        delay: 700,
                                        select: function (event, ui) {
                                            $('#model_id_text').val(ui.item.label);
                                            $('#product_sl_no').val(ui.item.product_sl_no);
                                            $('#SellReturnDetails_model_id').val(ui.item.id);
                                            $('#SellReturnDetails_amount').val(ui.item.sell_price);
                                            $('#SellReturnDetails_qty').val(1);
                                            // $('#SellReturnDetails_row_total').val(sp);
                                            showPurchasePrice(ui.item.purchasePrice);

                                            // Move cursor to the next visible input field
                                            var $form = $('#product_sl_no').closest('form');
                                            var $inputs = $form.find(':input:visible:not([disabled])');
                                            var currentIndex = $inputs.index($('#product_sl_no'));
                                            $inputs.eq(currentIndex + 1).focus();

                                            addToList();
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
                        <div class="form-group col-sm-12 col-md-1">
                            <?php echo $form->labelEx($model2, 'qty'); ?>
                            <?php echo $form->textField($model2, 'qty', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                            <!-- Display Stock without margin and padding -->
                            <span class="help-block current-stock"
                                  style="font-size: 12px; color: #333; margin: 0; padding: 0; width: 100%"></span>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model2, 'qty'); ?></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-1 cash-return">
                            <?php echo $form->labelEx($model2, 'amount'); ?>
                            <?php echo $form->textField($model2, 'amount', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                            <!-- Display Costing Amount without margin and padding -->
                            <?php echo $form->hiddenField($model2, 'pp', array('maxlength' => 255, 'class' => 'form-control pp')); ?>
                            <span class="help-block costing-amount"
                                  style="font-size: 12px; color: #333; margin: 0; padding: 0; width: 100%"></span>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model2, 'amount'); ?></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-1 cash-return">
                            <?php echo $form->labelEx($model2, 'row_total'); ?>
                            <?php echo $form->textField($model2, 'row_total', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model2, 'row_total'); ?></span>
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
                            <table class="table table-bordered table-striped table-valign-middle table-sm" id="list">
                                <thead class="table-info">
                                <tr>
                                    <th style="width: 2%;">SL</th>
                                    <th>Product Name</th>
                                    <th style="width: 20%;" class="text-center">Product Sl No</th>
                                    <th style="width: 10%;" class="text-center">Qty</th>
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

                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $form->textArea($model, 'remarks', array('class' => 'form-control', 'placeholder' => 'Return Note')); ?>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model, 'remarks'); ?></span>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="col-md-12">
                        <?php
                        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('/sell/sellReturn/create', 'render' => true)), array(
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
                                    // $("#soReportDialogBox").dialog("open");
                                    //$("#AjFlashReportSo").html(data.soReportInfo).show();
                                    $("#information-modal").modal("show");
                                    $("#information-modal .modal-body").html(data.soReportInfo);  
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
                                let date = $("#SellReturn_return_date").val();  
                                let customer_id = $("#SellReturn_customer_id").val();  
                                let grand_total = $("#SellReturn_return_amount").val();  
                                if(date == ""){
                                    toastr.error("Please insert date.");
                                    return false;
                                }else if(customer_id == ""){
                                    toastr.error("Please select customer from the list!");
                                    return false;
                                }else if(count_item <= 0){
                                    toastr.error("Please add products to list.");
                                    return false;
                                }else if(grand_total == "" || grand_total <= 0){
                                    toastr.error("Total return amount is 0");
                                    return false;
                                }else {                
                                    $("#overlay").fadeIn(300);　   
                                    $("#ajaxLoader").show();
                                }
                             }',
                            'error' => 'function(xhr, status, error) { 
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
                    <div class="col-md-12 mt-1">
                        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                        </span>
                        <div id="formResult" class="ajaxTargetDiv"></div>
                        <div id="formResultError" class="ajaxTargetDivErr alert alert-danger  d-none" role="alert">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>

<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).ready(function () {
        $("input:text").focus(function () {
            $(this).select();
        });
    });

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
    }

    function resetProduct() {
        $("#model_id_text").val('');
        $("#replace_model_id").val('');
        $("#SellReturnDetails_model_id").val('');
        resetProductSlNo();
        showPurchasePrice(0);
        tableSerial();
    }


    function resetProductSlNo() {
        $("#product_sl_no").val('');
        $("#SellReturnDetails_model_id").val('');
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
            $('.current-stock').html('<span style="color: green;">Stock: <b>' + parseFloat(stock).toFixed(2) + '</b></span>');
        } else
            $('.current-stock').html('<span style="color: green;">Stock: <b>' + parseFloat(stock).toFixed(2) + '</b></span>');
    }

    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            addToList();
            return false;
        }
    });


    function verifyProductSlNo() {
        // clear the error message

        let product_sl = $('#product_sl_no').val();
        if (product_sl.length === 0) {
            toastr.error('Please enter a valid Product SL No.');
            return;
        }
        $('#overlay').fadeIn();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/inventory/inventory/verifyProduct') ?>',
            data: {product_sl: product_sl},
            success: function (data) {
                // open modal & show the data

                $('#information-modal').modal('show');
                $('#information-modal .modal-body').html(data);

                $('#overlay').fadeOut();
            },
            error: function (data) {
                // add bootstrap alert to the div with id formResultError
                $('#formResultError').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' +
                    '  <strong>Error!</strong> ' + data.responseText +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>');
                $('#overlay').fadeOut();
            }
        });
        // clear the input field & focus on it
        // $('#product_sl_no_text').val('');
        $('#product_sl_no_text').focus();
    }

    $("#list").on("click", ".dlt", function () {
        $(this).closest("tr").remove();
        tableSerial();
        // calculateTotal();
    });

    function addToList() {
        let model_id = $('#SellReturnDetails_model_id').val();
        let product_sl_no = $('#product_sl_no').val();
        let qty = $('#SellReturnDetails_qty').val();
        let amount = $('#SellReturnDetails_amount').val();
        let row_total = $('#SellReturnDetails_row_total').val();
        let pp = $('#SellReturnDetails_pp').val();

        if (model_id === '' || qty === '' || amount === '' || row_total === '') {
            toastr.error('Please fill all the fields');
            return;
        }

        let sl = $('#list tr').length;
        let html = `<tr class="item">
                <td class="serial"></td>
                <td>
                     <input type="hidden" name="SellReturnDetails[model_id][]" value="${model_id}">
                    ${$('#model_id_text').val()}
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[product_sl_no][]" class="form-control" value="${product_sl_no}">
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[qty][]" class="form-control text-center temp_qty" value="${qty}">
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[amount][]" class="form-control temp_unit_price text-right" value="${amount}">
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[row_total][]" class="form-control row-total text-right" value="${row_total}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash"></i></button>
                </td>
            </tr>`;
        $('#list tbody').prepend(html);
        resetDataAfterAdd();
        tableSerial();
    }

    function resetDataAfterAdd() {
        console.log('resetDataAfterAdd');
        $("#product_sl_no").val();
        $("#SellReturnDetails_qty").val();
        $("#SellReturnDetails_amount").val();
        $("#SellReturnDetails_row_total").val();
    }

    function tableSerial() {
        //  get the table tbody tr length
        var i = $('#list tbody tr').length;
        $('#list tbody tr').each(function () {
            $(this).find('.serial').text(i);
            i--;
        });
    }

    $("#SellReturnDetails_qty").on('change keyup', function () {
        let qty = $(this).val();
        let price = $("#SellReturnDetails_amount").val();
        let row_total = calculateRowTotal(qty, price);
        $("#SellReturnDetails_row_total").val(row_total);
        console.log('amount row total: ' + row_total + ', price: ' + price + ', qty: ' + qty);
    });

    $("#SellReturnDetails_amount").on('change keyup', function () {
        let price = $(this).val();
        let qty = $("#SellReturnDetails_qty").val();

        let row_total = calculateRowTotal(qty, price);
        $("#SellReturnDetails_row_total").val(row_total);
        console.log('amount row total: ' + row_total + ', price: ' + price + ', qty: ' + qty);
    });


    function calculateRowTotal(qty, price) {
        let unitQty = parseFloat(qty);
        unitQty = isNaN(unitQty) ? 0 : unitQty;

        let unitPrice = parseFloat(price);
        unitPrice = isNaN(unitPrice) ? 0 : unitPrice;

        return (unitQty * unitPrice).toFixed(2);
    }

</script>