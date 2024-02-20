<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'prod-items-form',
    'action' => $this->createUrl('inventory/create'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Entry' : 'Update Entry'); ?></h3>

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
            <div class="col-sm-12 col-md-2">

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
                    <?php echo $form->labelEx($model, 't_type', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php
                        echo $form->dropDownList(
                            $model, 't_type', [Inventory::STOCK_IN => 'STOCK IN', Inventory::STOCK_OUT => 'STOCK OUT',], array(
                            'class' => 'form-control',
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 't_type'); ?></span>
                </div>

                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'remarks', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textArea($model, 'remarks', array('class' => 'form-control',)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'remarks'); ?></span>
                </div>
            </div>
            <div class="col-sm-12 col-md-10">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Product</h3>

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
                            <div class="form-group col-sm-12 col-md-3 col-lg-2">
                                <?php echo $form->labelEx($model, 'model_id'); ?>
                                <input type="text" id="model_id_text" class="form-control">
                                <?php echo $form->hiddenField($model, 'model_id', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($model, 'sell_price', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                                <div style="display: none;">
                                    <?php echo $form->dropDownList($model, 'unit_id', CHtml::listData(Units::model()->findAll(array('order' => 'label ASC')), 'id', 'label'), array('prompt' => 'Select', 'class' => 'form-control',)); ?>
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
                                                    },
                                                    function (data) {
                                                        response(data);
                                                    }, "json");
                                            },
                                            minLength: 1,
                                            delay: 700,
                                            select: function (event, ui) {
                                                $('#model_id_text').val(ui.item.value);
                                                $('#product_code').val(ui.item.code);
                                                $('#Inventory_model_id').val(ui.item.id);
                                                $('#Inventory_unit_id').val(ui.item.unit_id);
                                                $('#Inventory_sell_price').val(ui.item.sell_price);
                                                $('.product_unit_text').html($('#Inventory_unit_id option:selected').text());
                                                if ($("#Inventory_t_type").val() == <?=  Inventory::STOCK_OUT ?>) {
                                                    $.post('<?php echo Yii::app()->baseUrl ?>/index.php/inventory/inventory/Jquery_getStockQty', {
                                                        model_id: ui.item.id,
                                                    }, function (response) {
                                                        $("#Inventory_closing_stock").val(response);
                                                    });
                                                }
                                            }
                                        }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                            return $("<li></li>")
                                                .data("item.autocomplete", item)
                                                .append(`<a><img style="height: 50px; width: 50px;" src="${item.img}"> ${item.name} <br><i><small>${item.code}</small></i> </a>`)
                                                .appendTo(ul);
                                        };

                                    });
                                </script>
                            </div>
                            <div class="form-group col-sm-12 col-md-3 col-lg-2">
                                <?php echo $form->labelEx($model, 'code'); ?>
                                <input type="text" id="product_code" class="form-control">

                                <span class="help-block"
                                      style="color: red; width: 100%"> <?php echo $form->error($model, 'code'); ?></span>

                                <script>
                                    $(document).ready(function () {
                                        $('#product_code').autocomplete({
                                            source: function (request, response) {
                                                var search = request.term;
                                                $.post('<?php echo Yii::app()->baseUrl ?>/index.php/prodModels/Jquery_showprodCodeSearch', {
                                                        "q": search,
                                                    },
                                                    function (data) {
                                                        response(data);
                                                    }, "json");
                                            },
                                            minLength: 1,
                                            delay: 700,
                                            select: function (event, ui) {
                                                $('#model_id_text').val(ui.item.value);
                                                $('#product_code').val(ui.item.code);
                                                $('#Inventory_model_id').val(ui.item.id);
                                                $('#Inventory_unit_id').val(ui.item.unit_id);
                                                $('#Inventory_sell_price').val(ui.item.sell_price);
                                                $('.product_unit_text').html($('#Inventory_unit_id option:selected').text());
                                                if ($("#Inventory_t_type").val() == <?=  Inventory::STOCK_OUT ?>) {
                                                    $.post('<?php echo Yii::app()->baseUrl ?>/index.php/inventory/inventory/Jquery_getStockQty', {
                                                        model_id: ui.item.id,
                                                    }, function (response) {
                                                        $("#Inventory_closing_stock").val(response);
                                                    });
                                                }
                                            }
                                        }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                            return $("<li></li>")
                                                .data("item.autocomplete", item)
                                                .append(`<a><img style="height: 50px; width: 50px;" src="${item.img}"> ${item.name} <br><i><small>${item.code}</small></i> </a>`)
                                                .appendTo(ul);
                                        };
                                    });
                                </script>
                            </div>
                            <div class="form-group col-sm-12 col-md-3 col-lg-2">
                                <?php echo $form->labelEx($model, 'product_sl_no'); ?>
                                <input type="text" id="product_sl_no" class="form-control">

                                <span class="help-block"
                                      style="color: red; width: 100%"> <?php echo $form->error($model, 'product_sl_no'); ?></span>

                                <script>
                                    $(document).ready(function () {
                                        $('#product_sl_no').autocomplete({
                                            source: function (request, response) {
                                                var search = request.term;
                                                $.post('<?php echo Yii::app()->baseUrl ?>/index.php/inventory/inventory/Jquery_showprodSlNoSearch', {
                                                        "q": search,
                                                    },
                                                    function (data) {
                                                        response(data);
                                                    }, "json");
                                            },
                                            minLength: 1,
                                            delay: 700,
                                            select: function (event, ui) {
                                                $('#model_id_text').val(ui.item.label);
                                                $('#product_code').val(ui.item.code);
                                                $('#Inventory_model_id').val(ui.item.id);
                                                $('#Inventory_unit_id').val(ui.item.unit_id);
                                                $('#Inventory_sell_price').val(ui.item.sell_price);
                                                $('.product_unit_text').html($('#Inventory_unit_id option:selected').text());
                                                if ($("#Inventory_t_type").val() == <?=  Inventory::STOCK_OUT ?>) {
                                                    $.post('<?php echo Yii::app()->baseUrl ?>/index.php/inventory/inventory/Jquery_getStockQty', {
                                                        model_id: ui.item.id,
                                                    }, function (response) {
                                                        $("#Inventory_closing_stock").val(response);
                                                    });
                                                }
                                            }
                                        }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                            return $("<li></li>")
                                                .data("item.autocomplete", item)
                                                .append(`<a><img style="height: 50px; width: 50px;" src="${item.img}"> ${item.name} <br><i><small>${item.code}</small></i> </a>`)
                                                .appendTo(ul);
                                        };

                                    });
                                </script>
                            </div>
                            <div class="form-group col-sm-12 col-md-2 col-lg-2 stock-in">
                                <?php echo $form->labelEx($model, 'stock_in'); ?>
                                <div class="input-group">
                                    <?php echo $form->textField($model, 'stock_in', array('maxlength' => 255, 'class' => 'form-control', 'value' => 1)); ?>
                                    <div class="input-group-append">
                                        <span class="input-group-text product_unit_text" id="product_unit_text"></span>
                                    </div>
                                </div>
                                <span class="help-block"
                                      style="color: red; width: 100%"> <?php echo $form->error($model, 'model_id'); ?></span>
                            </div>
                            <div class="form-group col-sm-12 col-md-2 col-lg-2 stock-out" style="display: none;">
                                <?php echo $form->labelEx($model, 'stock_out'); ?>
                                <div class="input-group">
                                    <?php echo $form->textField($model, 'stock_out', array('maxlength' => 255, 'class' => 'form-control')); ?>
                                    <div class="input-group-append">
                                        <span class="input-group-text product_unit_text" id="product_unit_text2"></span>
                                    </div>
                                </div>
                                <span class="help-block"
                                      style="color: red; width: 100%"> <?php echo $form->error($model, 'model_id'); ?></span>
                            </div>
                            <div class="form-group col-sm-12 col-md-2 col-lg-2 stock-out" style="display: none;">
                                <?php echo $form->labelEx($model, 'closing_stock'); ?>
                                <div class="input-group">
                                    <?php echo $form->textField($model, 'closing_stock', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                                    <div class="input-group-append">
                                        <span class="input-group-text product_unit_text" id="product_unit_text3"></span>
                                    </div>
                                </div>
                                <span class="help-block"
                                      style="color: red; width: 100%"> <?php echo $form->error($model, 'closing_stock'); ?></span>
                            </div>
                            <div class="form-group col-sm-12 col-md-3 col-lg-2">
                                <button class="btn  btn-success mt-4" onclick="addToList()" type="button">ADD TO LIST
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped table-valign-middle" id="list">
                                    <thead class="table-info">
                                    <tr>
                                        <th>Product Name</th>
                                        <th style="width: 15%;" class="text-center">SL NO</th>
                                        <th style="width: 15%;" class="text-center">Stock In</th>
                                        <th style="width: 15%;" class="text-center">Stock Out</th>
                                        <th style="width: 5%;" class="text-center">Action</th>
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
    </div>

    <div class="card-footer">
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('inventory/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.")
                        $("#prod-items-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#list tbody").empty();
                        $.fn.yiiGridView.update("inventory-grid", {
                            data: $(this).serialize()
                        });
                        
//                        $("#soReportDialogBox").dialog("open");
//                        $("#AjFlashReportSo").html(data.soReportInfo).show();
                    }else{
                        //$("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#prod-items-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#prod-items-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){    
                  let count_item =  $(".item").length;                     
                if(count_item <= 0){
                        toastr.error("Please add Product to list.");
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
<?php $this->endWidget(); ?>

<script>


    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            // addToList();
            return false;
        }
    });


    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('SellOrder_date').value = date.format('YYYY-MM-DD');
        }
    });

    $("#Inventory_t_type").change(function () {
        let t_type = this.value;
        if (t_type == <?= Inventory::STOCK_OUT?>) {
            $(".stock-in").hide();
            $(".stock-out").show();
            $("#Inventory_stock_in").val("");
        } else {
            $(".stock-in").show();
            $(".stock-out").hide();
            $("#Inventory_stock_out").val("");
        }
    });

    function addToList() {
        let t_type = parseInt($("#Inventory_t_type").val());
        let model_id = $("#Inventory_model_id").val();
        let model_id_text = $("#model_id_text").val();
        let unit_price = $("#Inventory_sell_price").val();
        let product_sl_no = $("#product_sl_no").val();
        let stock_in = parseFloat($("#Inventory_stock_in").val());
        let stock_out = parseFloat($("#Inventory_stock_out").val());
        let closing_stock = parseFloat($("#Inventory_closing_stock").val());
        stock_in = isNaN(stock_in) ? 0 : stock_in;
        stock_out = isNaN(stock_out) ? 0 : stock_out;
        closing_stock = isNaN(closing_stock) ? 0 : closing_stock;

        let unit_id = $("#Inventory_unit_id").val();
        let unit_name = $("#Inventory_unit_id option:selected").text();
        let isproductpresent = false;
        let temp_codearray = document.getElementsByName("Inventory[temp_model_id][]");
        /*if (temp_codearray.length > 0) {
            for (let l = 0; l < temp_codearray.length; l++) {
                var code = temp_codearray[l].value;
                if (code == model_id) {
                    isproductpresent = true;
                    break;
                }
            }
        }*/

        if (model_id == "" || model_id_text == "") {
            toastr.error("Please select a product");
            return false;
        } else if (isproductpresent == true) {
            toastr.error(model_id_text + " is already on the list! Please add another!");
            return false;
        } else if ((stock_in == "" || stock_in == 0) && (stock_out == "" || stock_out == 0)) {
            toastr.error("Please enter qty");
            return false;
        } else if ((t_type == <?= Inventory::STOCK_OUT ?>) && (closing_stock <= 0 || closing_stock == "")) {
            toastr.error("Insufficient stock qty!");
            return false;
        } else if ((t_type == <?= Inventory::STOCK_OUT ?>) && (stock_out > closing_stock)) {
            toastr.error("Insufficient stock qty!");
            return false;
        } else {
            $("#list tbody").append(`
                <tr class="item">
                    <td>${model_id_text}</td>
                    <td class="text-center">
                            <input type="text" class="form-control text-center" value="${product_sl_no}" name="Inventory[temp_product_sl_no][] readonly">
                    </td>
                    <td class="text-center">
                        <div class="input-group">
                            <input type="text" class="form-control text-center" value="${stock_in}" name="Inventory[temp_stock_in][]" ${t_type == <?=Inventory::STOCK_OUT ?> ? "readonly" : ""}>
                                <div class="input-group-append">
                                <span class="input-group-text"">${unit_name}</span>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="input-group">
                            <input type="text" class="form-control text-center" value="${stock_out}" name="Inventory[temp_stock_out][]"  ${t_type == <?=Inventory::STOCK_IN ?> ? "readonly" : ""}>
                                <div class="input-group-append">
                                <span class="input-group-text"">${unit_name}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i> </button>
                        <input type="hidden" class="form-control" value="${model_id}" name="Inventory[temp_model_id][]" >
                        <input type="hidden" class="form-control" value="${unit_price}" name="Inventory[temp_sell_price][]" >
                    </td>
                </tr>
                `);
            clearDynamicItem();
        }
    }


    function clearDynamicItem() {
        // $("#Inventory_model_id").val('');
        // $("#model_id_text").val('');
        // $("#product_code").val('');
        $("#product_sl_no").val('');
        $("#Inventory_unit_id").val('');
        // $("#Inventory_stock_in").val('');
        // $("#Inventory_stock_out").val('');
        $("#Inventory_closing_stock").val('');
    }

    $("#list").on("click", ".dlt", function () {
        $(this).closest("tr").remove();
    });
</script>
