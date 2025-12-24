<?php
$this->widget('application.components.BreadCrumb', array(
        'crumbs' => array(
                array('name' => 'Purchase', 'url' => array('admin')),
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

<div class="row">
    <div class="form-group col-xs-11 col-md-3 col-lg-3">
        <a class="btn  btn-warning" type="button" id="btnReload"
           href="<?= Yii::app()->request->requestUri ?>"><i class="fa fa-refresh"></i> Reload
        </a>
        <a class="btn btn-success text-right" type="button"
           href="<?= Yii::app()->baseUrl . '/index.php/commercial/purchaseOrder/admin' ?>"><i class="fa fa-home"></i>
            Purchase Order Manage
        </a>
    </div>
</div>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Order' : 'Update Order'); ?></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'cash_due', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php
                        echo $form->dropDownList(
                                $model, 'cash_due', Lookup::items('cash_due'), array(
                                'class' => 'form-control',
                                'options' => array(
                                        Lookup::DUE => array('selected' => 'selected')
                                ),
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'cash_due'); ?></span>
                </div>
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'date', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" id="entry_date" data-target-input="nearest">
                            <?php echo $form->textField($model, 'date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'date'); ?></span>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'supplier_id', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" data-target-input="nearest">
                            <input type="text" id="supplier_id_text" class="form-control">
                            <?php echo $form->hiddenField($model, 'supplier_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <?php
                                    echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                            array(
                                                    'onclick' => "{addSupplier(); $('#addSupplierDialog').dialog('open');}"));
                                    ?>
                                    <?php
                                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                            'id' => 'addSupplierDialog',
                                            'options' => array(
                                                    'title' => 'Add Supplier',
                                                    'autoOpen' => false,
                                                    'modal' => true,
                                                    'width' => 984,
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
                                        function addSupplier() {
                                            <?php
                                            echo CHtml::ajax(array(
                                                    'url' => array('/commercial/suppliers/createSupplierFromOutSide'),
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
                                                        $('#addSupplierDialog div.divForForm').html(data.div);
                                                              // Here is the trick: on submit-> once again this function!
                                                        $('#addSupplierDialog div.divForForm form').submit(addSupplier);
                                                    }
                                                    else
                                                    {
                                                        $('#addSupplierDialog div.divForForm').html(data.div);
                                                        setTimeout(\"$('#addSupplierDialog').dialog('close') \",1000);
                                                        $('#supplier_id_text').val(data.label);
                                                        $('#PurchaseOrder_supplier_id').val(data.id).change();
                                                        $('#PurchaseOrder_contact_no').val(data.contact_no).change();
                                                        $('#PurchaseOrder_address').val(data.address    ).change();
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
                            $('#supplier_id_text').autocomplete({
                                source: function (request, response) {
                                    var search = request.term;
                                    $.post('<?php echo Yii::app()->baseUrl ?>/index.php/commercial/suppliers/jquery_supplierSearch', {
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
                                    $('#supplier_id_text').val(ui.item.value);
                                    $('#PurchaseOrder_supplier_id').val(ui.item.id);
                                    $('#PurchaseOrder_contact_no').val(ui.item.contact_no);
                                    $('#PurchaseOrder_address').val(ui.item.address);
                                }
                            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                return $("<li></li>")
                                    .data("item.autocomplete", item)
                                    .append(`<a> ${item.value} <small><br>Contact: ${item.contact_no}, Web: ${item.web}<br> Address:  ${item.address}</small></a>`)
                                    .appendTo(ul);
                            };

                        });
                    </script>
                </div>


                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'contact_no', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'contact_no', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'contact_no'); ?></span>
                </div>

                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'address', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'address', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'address'); ?></span>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row">
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

                <div class="form-group row">
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

                <div class="form-group row">
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
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-xs-12 col-md-3">
                        <?php echo $form->labelEx($model2, 'model_id'); ?>

                        <div class="input-group" data-target-input="nearest">
                            <input type="text" id="model_id_text" class="form-control">
                            <?php echo $form->hiddenField($model2, 'model_id', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <?php
                                    echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                            array(
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

                                            return false;
                                        }
                                    </script>
                                </div>
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
                                                "item_id_excluded": 1,
                                                "item_id": [<?= ProdItems::SERVICES_ITEM ?>]
                                            },
                                            function (data) {
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
                                        $('#PurchaseOrderDetails_model_id').val(ui.item.id);
                                        $('#PurchaseOrderDetails_amount').val(ui.item.purchasePrice);
                                        $('.current-pp').html("P.P:" + ui.item.purchasePrice);
                                        // $('#PurchaseOrderDetails_amount').val(ui.item.sell_price);
                                        $('#PurchaseOrderDetails_unit_id').val(ui.item.unit_id);
                                        $('#product_unit_text').html($('#PurchaseOrderDetails_unit_id option:selected').text());

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

                    <div class="form-group col-xs-12 col-md-2">
                        <?php echo $form->labelEx($model2, 'product_sl_no'); ?>
                        <div class="input-group" data-target-input="nearest">
                            <!-- Single / Multiple dropdown -->
                            <div class="input-group-prepend">
                                <label for="product_sl_mode"></label>
                                <select id="product_sl_mode" class="form-control" style="max-width: 110px;">
                                    <option value="single" selected title="Single">S</option>
                                    <option value="multiple" title="Multiple">M</option>
                                </select>
                            </div>
                            <!-- Single mode (text input) -->
                            <?php echo $form->textField(
                                    $model2,
                                    'product_sl_no',
                                    array(
                                            'maxlength' => 255,
                                            'class' => 'form-control',
                                            'id' => 'product_sl_text'
                                    )
                            ); ?>

                            <!-- Multiple mode (textarea) -->
                            <?php echo $form->textArea(
                                    $model2,
                                    'product_sl_no',
                                    array(
                                            'rows' => 4,
                                            'class' => 'form-control',
                                            'id' => 'product_sl_textarea',
                                            'style' => 'display:none;',
                                            'placeholder' => 'Enter serial numbers (space, comma or new line separated)'
                                    )
                            ); ?>
                        </div>
                        <!-- Serial counter -->
                        <small id="serialCount"
                               style="display:none;color:#555;font-weight:600;">
                            Total Serial: <span id="serialCountValue">0</span>
                        </small>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'product_sl_no'); ?></span>
                    </div>

                    <div class="form-group col-xs-12 col-md-2 ">
                        <?php echo $form->labelEx($model2, 'qty'); ?>

                        <div class="input-group">
                            <?php echo $form->textField($model2, 'qty', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                            <div class="input-group-append">
                                <span class="input-group-text" id="product_unit_text"></span>
                                <?php
                                echo $form->dropDownList(
                                        $model2, 'unit_id', CHtml::listData(Units::model()->findAll(array('order' => 'label ASC')), 'id', 'label'), array(
                                        'prompt' => 'Select',
                                        'class' => 'form-control',
                                        'style' => 'display: none;',
                                ));
                                ?>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'qty'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-2">
                        <?php echo $form->labelEx($model2, 'amount'); ?>

                        <div class="input-group">
                            <?php echo $form->textField($model2, 'amount', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                            <div class="input-group-append">
                                <span class="input-group-text" id="amount"><i class="fa fa-money"></i> </span>
                            </div>
                        </div>
                        <span class="help-block current-pp"
                              style="color: green; width: 100%; font-size: 12px;"> </span>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'amount'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-2">
                        <?php echo $form->labelEx($model2, 'row_total'); ?>
                        <div class="input-group">
                            <?php echo $form->textField($model2, 'row_total', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                            <div class="input-group-append">
                                <span class="input-group-text" id="amount"><i class="fa fa-money"></i> </span>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'row_total'); ?></span>
                    </div>

                    <div class="form-group col-xs-12 col-md-1 ">
                        <button class="btn  btn-success mt-4" onclick="addToList()" type="button" title="ADD TO LIST">
                            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
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
                                <th style="width: 5%;">SL</th>
                                <th>Product Name</th>
                                <th style="width: 20%;" class="text-center">Product SL No</th>
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
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('/commercial/purchaseOrder/create', 'render' => true)), array(
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
                        //$("#soReportDialogBox").dialog("open");
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
                    let cash_due = $("#PurchaseOrder_cash_due").val();  
                    let date = $("#PurchaseOrder_date").val();  
                    let customer_id = $("#PurchaseOrder_supplier_id").val();  
                    let grand_total = $("#PurchaseOrder_grand_total").val();  
                    if(cash_due == ""){
                        toastr.error("Please select Cash/Due.");
                        return false;
                    }else if(date == ""){
                        toastr.error("Please insert date.");
                        return false;
                    }else if(customer_id == ""){
                        toastr.error("Please select supplier from the list!");
                        return false;
                    }else if(count_item <= 0){
                        toastr.error("Please add product to list.");
                        return false;
                    }else if(grand_total == "" || grand_total <= 0){
                        toastr.error("Grand total amount is 0");
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

    let prev_model_id = 0;
    let prev_pp = 0;

    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('PurchaseOrder_date').value = date.format('YYYY-MM-DD');
        }
    });


    $(document).ready(function () {
        $("#PurchaseOrderDetails_product_sl_no").keyup(function () {
            let sl_wise_purchase = $(this);
            if (sl_wise_purchase.length > 0) {
                $("#PurchaseOrderDetails_qty").val(1).change();
            } else {
                $("#PurchaseOrderDetails_qty").val('').change();
            }
        });
        $(".qty-amount").keyup(function () {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));
        });

        $(".qty-amount").on("keydown keyup", function () {
            let amount = parseFloat($("#PurchaseOrderDetails_amount").val());
            let qty = parseFloat($("#PurchaseOrderDetails_qty").val());
            amount = amount > 0 ? amount : 0;
            qty = qty > 0 ? qty : 0;

            $("#PurchaseOrderDetails_row_total").val((amount * qty).toFixed(2));
        });
        $("#PurchaseOrder_vat_percentage").on("keydown keyup", function () {
            calculateVat();
        });
    });


    $(function () {

        $('#product_sl_mode').on('change', function () {
            const isMultiple = $(this).val() === 'multiple';

            $('#product_sl_text').toggle(!isMultiple).val('');
            $('#product_sl_textarea').toggle(isMultiple).val('');
            $('#serialCount').toggle(isMultiple);
            $('#serialCountValue').text(0);

            $("#PurchaseOrderDetails_qty").val(1);
            $("#PurchaseOrderDetails_row_total").val(1 * $("#PurchaseOrderDetails_amount").val());
        });

        $('#product_sl_textarea').on('input', function () {
            const count = $(this).val()
                .trim()
                .split(/[\s,]+/)
                .filter(Boolean).length;

            $('#serialCountValue').text(count || 0);

            $("#PurchaseOrderDetails_qty").val(count);
            $("#PurchaseOrderDetails_row_total").val(count * $("#PurchaseOrderDetails_amount").val());
        });
    });

    function addToList() {

        let checkIsMultipleSl = $('#product_sl_mode').val() === 'multiple';

        let model_id = $("#PurchaseOrderDetails_model_id").val();
        let model_id_text = $("#model_id_text").val();
        let unit_price = $("#PurchaseOrderDetails_amount").val();
        let product_sl_no = $("#product_sl_text").val();
        let product_sl_no_multiple = $("#product_sl_textarea").val();
        let qty = checkIsMultipleSl ? 1 : $("#PurchaseOrderDetails_qty").val();
        let row_total = $("#PurchaseOrderDetails_row_total").val();
        let isproductpresent = false;
        let temp_sl_array = document.getElementsByName("PurchaseOrderDetails[temp_product_sl_no][]");

        if (!checkIsMultipleSl) {
            isproductpresent = checkDuplicateSerialNoForSingleSel(product_sl_no);
        }


        if (model_id === "" || model_id_text === "") {
            toastr.error("Please select product");
            return false;
        } else if (isproductpresent === true) {
            toastr.error(model_id_text + " is already on the list! Please add another!");
            return false;
        } else if (unit_price === "") {
            toastr.error("Please insert unit price");
            return false;
        } else if (qty === "" || qty === 0) {
            toastr.error("Please enter qty");
            return false;
        } else if (row_total === "" || row_total === 0) {
            toastr.error("Please enter qty & amount!");
            return false;
        } else {
            let rows = '';
            let serials = checkIsMultipleSl
                ? splitMultipleSlNumberToArray(product_sl_no_multiple)
                : [product_sl_no];

            serials.forEach(sl => {
                rows += buildRow({
                    model_id,
                    model_id_text,
                    product_sl_no: sl,
                    qty: checkIsMultipleSl ? 1 : qty,
                    unit_price,
                    row_total: checkIsMultipleSl ? unit_price : row_total
                });
            });

            $("#list tbody").prepend(rows);
            calculateTotal();
            clearDynamicItem(product_sl_no);
            prev_model_id = model_id;
            prev_pp = unit_price;
        }
    }


    function checkDuplicateSerialNoForSingleSel(product_sl_no) {
        let temp_sl_array = document.getElementsByName("PurchaseOrderDetails[temp_product_sl_no][]");

        let isproductpresent = false;
        if (product_sl_no.length > 0) {
            for (let l = 0; l < temp_sl_array.length; l++) {
                let code = temp_sl_array[l].value;
                if (code === product_sl_no) {
                    isproductpresent = true;
                    break;
                }
            }
        }
        return isproductpresent;
    }

    function buildRow({
                          model_id,
                          model_id_text,
                          product_sl_no,
                          qty,
                          unit_price,
                          row_total
                      }) {
        return `
        <tr class="item">
            <td class="serial"></td>
            <td>
                ${model_id_text}
                <input type="hidden" value="${model_id}"
                       name="PurchaseOrderDetails[temp_model_id][]">
            </td>
            <td class="text-center">
                <input type="text" class="form-control text-center"
                       value="${product_sl_no}"
                       name="PurchaseOrderDetails[temp_product_sl_no][]">
            </td>
            <td class="text-center">
                <input type="text" class="form-control text-center temp_qty"
                       value="${qty}"
                       name="PurchaseOrderDetails[temp_qty][]">
            </td>
            <td class="text-center">
                <input type="text" class="form-control temp_unit_price"
                       value="${unit_price}"
                       name="PurchaseOrderDetails[temp_unit_price][]">
            </td>
            <td class="text-center">
                <input type="text" readonly class="form-control row-total"
                       value="${row_total}"
                       name="PurchaseOrderDetails[temp_row_total][]">
            </td>
            <td>
                <button type="button" class="btn btn-danger dlt">
                    <i class="fa fa-trash-o"></i>
                </button>
            </td>
        </tr>`;
    }

    /**
     * Split multiple serial numbers into an array by space, comma, or new line
     * @param sl_numbers
     * @returns {*}
     */
    function splitMultipleSlNumberToArray(sl_numbers) {
        return sl_numbers
            .trim()
            .split(/[\s,]+/)
            .filter(Boolean);
    }

    $("#list").on("click", ".dlt", function () {
        $(this).closest("tr").remove();
        calculateTotal();
    });


    function calculateVat() {
        let total_amount = parseFloat($("#PurchaseOrder_total_amount").val());
        let vat_p = parseFloat($("#PurchaseOrder_vat_percentage").val());
        total_amount = total_amount > 0 ? total_amount : 0;
        vat_p = vat_p > 0 ? vat_p : 0;
        let vat = parseFloat(((vat_p / 100) * total_amount));
        let grand_total = parseFloat(total_amount + vat);
        $("#PurchaseOrder_vat_amount").val(vat.toFixed(2));
        $("#PurchaseOrder_grand_total").val(grand_total.toFixed(2));
    }

    function resetDynamicItem() {
        $("#PurchaseOrderDetails_model_id").val('');
        $("#model_id_text").val('');
        $("#product_sl_text").val('');
        $("#PurchaseOrderDetails_amount").val('');
        $("#PurchaseOrderDetails_row_total").val('');
        $("#PurchaseOrderDetails_qty").val('');
        $("#PurchaseOrderDetails_color").val('');
    }

    // on temp_qty change/keyup event calculate row total
    $(document).on("change keyup", ".temp_qty", function () {
        let qty = parseFloat($(this).val());
        let unit_price = parseFloat($(this).closest("tr").find(".temp_unit_price").val());
        let row_total = parseFloat(qty * unit_price);
        $(this).closest("tr").find(".row-total").val(row_total.toFixed(2));
        calculateTotal();
    });
    // on temp_unit_price change/keyup event calculate row total
    $(document).on("change keyup", ".temp_unit_price", function () {
        let unit_price = parseFloat($(this).val());
        let qty = parseFloat($(this).closest("tr").find(".temp_qty").val());
        let row_total = parseFloat(qty * unit_price);
        $(this).closest("tr").find(".row-total").val(row_total.toFixed(2));
        changeUnitPriceForSameModel($(this).closest("tr").find(".tmep_model_id").val(), unit_price);
        calculateTotal();
    });

    function changeUnitPriceForSameModel(model_id, price) {
        // find all same model id and change the price except the current row
        $(".tmep_model_id").each(function () {
            if ($(this).val() == model_id) {
                if ($(this).closest("tr").find(".temp_unit_price").val() != price) {
                    $(this).closest("tr").find(".temp_unit_price").val(price);
                    let qty = parseFloat($(this).closest("tr").find(".temp_qty").val());
                    let row_total = parseFloat(qty * price);
                    $(this).closest("tr").find(".row-total").val(row_total.toFixed(2));
                }
            }
        });
    }

    function clearDynamicItem(product_sl_no) {
        let pp = '';
        if (prev_model_id == $("#PurchaseOrderDetails_model_id").val()) {
            pp = prev_pp;
        }
        let isMultiple = $('#product_sl_mode').val() === 'multiple';

        // MULTIPLE MODE
        if (isMultiple) {
            $("#product_sl_textarea").val('').focus();
            return;
        }

        if (product_sl_no.length > 0) {
            $("#product_sl_text").val('');
            $("#product_sl_text").focus();
        } else {
            $("#PurchaseOrderDetails_model_id").val('');
            $("#model_id_text").val('');
            $("#product_sl_text").val('');
            $("#PurchaseOrderDetails_amount").val('');
            $("#PurchaseOrderDetails_row_total").val(pp);
            $("#PurchaseOrderDetails_qty").val('');
            $("#PurchaseOrderDetails_color").val('');
            $("#serialCountValue").val('');
        }
        $("#serialCountValue").html('');
    }

    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            // focus to next input field

            addToList();
            return false;
        }
    });

    function calculateTotal() {
        let item_count = $(".item").length;

        let total = 0;
        $('.row-total').each(function () {
            total += parseFloat($(this).val());
        });

        $("#PurchaseOrder_total_amount").val(total.toFixed(2)).change();
        $("#PurchaseOrder_item_count").val(item_count);
        calculateVat();

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

    // on product_sl_text , PurchaseOrderDetails_amount enter press add to list
    $("#product_sl_text").keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            addToList();
            return false;
        }
    });
    $("#PurchaseOrderDetails_amount").keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            addToList();
            return false;
        }
    });

    tableSerial();


    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            addToList();
            return false;
        }
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

