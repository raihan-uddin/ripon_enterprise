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
<style>
    .hidden {
        display: none;
    }
</style>


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
            <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Return' : 'Update Return'); ?></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="form-group row hidden">
                    <?php echo $form->labelEx($model, 'return_type',); ?>
                    <div class="col-sm-8">
                        <?php
                        echo $form->dropDownList(
                            $model, 'return_type', SellReturn::RETURN_TYPE_ARR, array(
                            'class' => 'form-control',
                            'options' => array(
                                SellReturn::DAMAGE_RETURN => array('selected' => 'selected'),
                                SellReturn::CASH_RETURN => array('disabled' => true),
                            ),
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                            style="color: red; width: 100%"> <?php echo $form->error($model, 'return_type'); ?></span>
                </div>
                <div class="form-group col-md-3">
                    <?php echo $form->labelEx($model, 'return_date',); ?>
                        <div class="input-group" id="entry_date" data-target-input="nearest">
                            <?php echo $form->textField($model, 'return_date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    <span class="help-block"
                            style="color: red; width: 100%"> <?php echo $form->error($model, 'return_date'); ?></span>
                </div>
                <!-- sell_id -->
                <div class="form-group col-md-2">
                    <?php echo $form->labelEx($model, 'sell_id'); ?>
                    <div class="input-group" data-target-input="nearest">
                        <input type="text" id="sell_id_text" class="form-control">
                        <?php echo $form->hiddenField($model, 'sell_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
                        <!-- autocomplete sell_id_text -->
                        <script>
                            $(document).ready(function () {
                                $('#sell_id_text').autocomplete({
                                    source: function (request, response) {
                                        var search = request.term;
                                        $.post('<?php echo Yii::app()->baseUrl ?>/index.php/sell/sellOrder/Jquery_showSellSearch', {
                                            "q": search,
                                            "customer_id": $('#SellReturn_customer_id').val(),
                                        }, function (data) {
                                            response(data);
                                            // Check if there's only one item and trigger select event
                                            if (data.length === 1 && data[0].id) {
                                                $('#sell_id_text').autocomplete('option', 'select').call($('#sell_id_text')[0], null, {
                                                    item: data[0]
                                                });
                                                // move cursor to the next input field
                                                var $form = $('#sell_id_text').closest('form');
                                                var $inputs = $form.find(':input:visible:not([disabled])');
                                                var currentIndex = $inputs.index($('#sell_id_text'));
                                                $inputs.eq(currentIndex + 1).focus();
                                            }
                                        }, "json");
                                    },
                                    minLength: 1,
                                    delay: 700,
                                    select: function (event, ui) {
                                        $('#sell_id_text').val(ui.item.value);
                                        $('#SellReturn_sell_id').val(ui.item.id).change();
                                        $('#SellReturn_customer_id').val(ui.item.customer_id).change();
                                        $('#customer_id_text').val(ui.item.name);
                                    }
                                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                    return $("<li></li>")
                                        .data("item.autocomplete", item)
                                        .append(`<a> ${item.value} <small><br>Sale ID: ${item.id}, <br> Customer:  ${item.name}</small></a>`)
                                        .appendTo(ul);
                                };
                            });
                            </script>
                    </div>
                    <span class="help-block text-danger" style="width: 100%"><?php echo $form->error($model, 'sell_id'); ?></span>
                </div>

                <div class="form-group col-md-3">
                    <?php echo $form->labelEx($model, 'customer_id',); ?>
                        <div class="input-group" data-target-input="nearest">
                            <input type="text" id="customer_id_text" class="form-control">
                            <?php echo $form->hiddenField($model, 'customer_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
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
                <!-- total return amount -->
                <div class="form-group col-md-3">
                    <?php echo $form->labelEx($model, 'return_amount',); ?>
                    <div class="input-group" data-target-input="nearest">
                        <?php echo $form->textField($model, 'return_amount', array('class' => 'form-control numeric-validation', 'readonly' => true)); ?>
                    </div>
                    <span class="help-block text-danger" style="width: 100%"><?php echo $form->error($model, 'return_amount'); ?></span>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Items</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-3">
                            <?php echo $form->labelEx($model2, 'model_id'); ?>
                            <div class="input-group" data-target-input="nearest">
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
                                            $.post('<?php echo Yii::app()->baseUrl ?>/index.php/sell/sellOrder/Jquery_showProductSearch', {
                                                "q": search,
                                                "customer_id": $('#SellReturn_customer_id').val(),
                                                "sale_id": $('#SellReturn_sell_id').val(),
                                            }, function (data) {
                                                response(data);
                                                // Check if there's only one item and trigger select event
                                                if (data.length === 1 && data[0].id) {
                                                    // Trigger select event
                                                    $('#model_id_text').autocomplete('option', 'select').call($('#model_id_text')[0], null, {
                                                        item: data[0]
                                                    });
                                                }
                                            }, "json");
                                        },
                                        minLength: 1,
                                        delay: 700,
                                        select: function (event, ui) {
                                            $('#model_id_text').val(ui.item.value);
                                            $('#SellReturnDetails_model_id').val(ui.item.id).change();
                                            $('#SellReturnDetails_qty').val(1).change();
                                            $('#SellReturnDetails_sell_price').val(ui.item.sell_price).change();

                                            // fetchProductPrice();
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
                                    <button class="btn btn-warning btn-sm hidden" type="button" onclick="verifyProductSlNo($('#product_sl_no').text())">
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
                                                    $('#SellReturnDetails_model_id').val(data[0].id);
                                                    $('#product_sl_no').val(data[0].product_sl_no);
                                                    $('#SellReturnDetails_qty').val(1).change();
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
                                            $('#SellReturnDetails_model_id').val(ui.item.id).change();
                                            $('#SellReturnDetails_qty').val(1);
                                            $('#SellReturnDetails_sell_price').val(ui.item.sell_price).change();

                                            // fetchProductPrice();

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
                            <?php echo $form->textField($model2, 'qty', array('maxlength' => 255, 'class' => 'form-control numeric-validation qty')); ?>
                            <span class="help-block current-stock"
                                style="font-size: 12px; color: #333; margin: 0; padding: 0; width: 100%"></span>
                            <span class="help-block"
                                style="color: red; width: 100%"> <?php echo $form->error($model2, 'qty'); ?></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-1">
                            <?php echo $form->labelEx($model2, 'sell_price'); ?>
                            <?php echo $form->textField($model2, 'sell_price', array('maxlength' => 255, 'class' => 'form-control numeric-validation sell-price')); ?>
                            <span class="help-block"
                                style="color: red; width: 100%"> <?php echo $form->error($model2, 'sell_price'); ?></span>
                        </div>
                        <!-- row_total -->
                        <div class="form-group col-sm-12 col-md-1">
                            <?php echo $form->labelEx($model2, 'row_total'); ?>
                            <?php echo $form->textField($model2, 'row_total', array('maxlength' => 255, 'class' => 'form-control row-total-amount')); ?>
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
                                    <th style="width: 10%;" class="text-center">Sell Price</th>
                                    <th style="width: 10%;" class="text-center">Total</th>
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
                        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('/sell/sellReturn/createProductReturn', 'render' => true)), array(
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
                                    // $("#information-modal").modal("show");
                                    // $("#information-modal .modal-body").html(data.soReportInfo);  
                                }else{
                                    //$("#formResultError").html("Data not saved. Please solve the following errors.");
                                    toastr.error("Data not saved. Please solve the following errors.");
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
                                
                                if(date == ""){
                                    toastr.error("Please insert date.");
                                    return false;
                                }else if(customer_id == ""){
                                    toastr.error("Please select customer from the list!");
                                    return false;
                                }else if(count_item <= 0){
                                    toastr.error("Please add products to list.");
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
                <p>Loading...</p>
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

    // .sell-price, .qty   on change or on key up change the value .row-total-amount,
    $(document).on('change keyup', '.sell-price, .qty', function () {
        let qty = $("#SellReturnDetails_qty").val();
        if (qty === '') {
            qty = 0;
        }
        let sell_price =  $("#SellReturnDetails_sell_price").val();
        if (sell_price === '') {
            sell_price = 0;
        }
        let row_total = calculateRowTotal(qty, sell_price);
        $("#SellReturnDetails_row_total").val(row_total);
    });

    // dynamic loaded items total calculation
    $(document).on('change keyup', '.temp_qty, .temp_sell_price', function () {
        let qty = $(this).closest('tr').find('.temp_qty').val();
        if (qty === '') {
            qty = 0;
        }
        let sell_price = $(this).closest('tr').find('.temp_sell_price').val();
        if (sell_price === '') {
            sell_price = 0;
        }
        let row_total = calculateRowTotal(qty, sell_price);
        $(this).closest('tr').find('.temp_row_total').val(row_total).change();
        changeReturnAmount();
    });

    function changeReturnAmount(){
        let return_amount = 0;
        $('.temp_row_total').each(function () {
            let row_total = $(this).val();
            if (row_total === '') {
                row_total = 0;
            }
            return_amount += parseFloat(row_total);
        });
        $('#SellReturn_return_amount').val(return_amount.toFixed(2));   
    }

    function calculateRowTotal(qty, sellPrice){
        let row_total = parseFloat(qty) * parseFloat(sellPrice);
        return row_total.toFixed(2);
    }

    // validate number only
    $(".numeric-validation").keyup(function () {
        var $this = $(this);
        $this.val($this.val().replace(/[^\d.]/g, ''));
    });
    

    // fetch product price of selected product or serial no
    function fetchProductPrice() {
        let model_id = $('#SellReturnDetails_model_id').val();
        let product_sl_no = $('#product_sl_no').val();
        let customer_id = $('#SellReturn_customer_id').val();

        console.log('model_id: ' + model_id + ', product_sl_no: ' + product_sl_no + ', customer_id: ' + customer_id);
        $('#overlay').fadeIn();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/sell/sellOrder/fetchProductPrice') ?>',
            data: {model_id: model_id, product_sl_no: product_sl_no, customer_id: customer_id},
            success: function (data) {
                console.log(data);
                // show the sell_price in 
                $('#SellReturnDetails_sell_price').val(data.sell_price);
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
        $('#product_sl_no').val('');
        $('#product_sl_no').focus();
    }

    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        singleDate: true,
        format: 'YYYY-MM-DD',
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
        $("#SellReturnDetails_model_id").val('');
        $("#SellReturnDetails_qty").val('');
        $("#SellReturnDetails_sell_price").val('');
        $("#SellReturnDetails_row_total").val('');
        resetProductSlNo();
        showPurchasePrice(0);
        tableSerial();
        changeReturnAmount();
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

    function verifyProductSlNo(product_sl) {
        console.log(product_sl);
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
        let sell_price = $('#SellReturnDetails_sell_price').val();
        let row_total = $('#SellReturnDetails_row_total').val();

        if (model_id === '' || qty === '') {
            toastr.error('Please fill all the fields');
            return;
        }

        let sl = $('#list tr').length;
        let html = `<tr class="item">
                <td class="serial"></td>
                <td>
                    <input type="hidden" name="SellReturnDetails[model_id][]" value="${model_id}">
                    ${$('#model_id_text').val()}
                    <br>
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[product_sl_no][]" class="form-control" value="${product_sl_no}">
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[qty][]" class="form-control text-center numeric-validation temp_qty" value="${qty}">
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[sell_price][]" class="form-control text-center numeric-validation temp_sell_price" value="${sell_price}">
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[row_total][]" class="form-control text-center numeric-validation temp_row_total" value="${row_total}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash"></i></button>
                </td>
            </tr>`;
        $('#list tbody').prepend(html);
        resetDataAfterAdd();
        tableSerial();
        changeReturnAmount();
    }

    function resetDataAfterAdd() {
        console.log('resetDataAfterAdd');
        resetProduct();
        resetProductSlNo();
        $('#SellReturnDetails_qty').val('');
        
    }

    function tableSerial() {
        //  get the table tbody tr length
        var i = $('#list tbody tr').length;
        $('#list tbody tr').each(function () {
            $(this).find('.serial').text(i);
            i--;
        });
    }

</script>