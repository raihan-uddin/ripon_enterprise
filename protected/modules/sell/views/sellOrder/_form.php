<?php
$this->widget('application.components.BreadCrumb', array(
        'crumbs' => array(
                array('name' => 'Sales', 'url' => array('admin')),
                array('name' => 'Order', 'url' => array('admin')),
                array('name' => 'Create'),
        ),
));
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
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row">
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
                                $model, 'order_type', [SellOrder::NEW_ORDER => 'NEW',], array(
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
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row">
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
                                    $('#SellOrder_customer_id').val(ui.item.id);
                                    $('#SellOrder_city').val(ui.item.city);
                                    $('#SellOrder_state').val(ui.item.state);
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

                <div class="form-group row" style="display: none;">
                    <?php echo $form->labelEx($model, 'city', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'city', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'qty'); ?></span>
                </div>

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


                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'delivery_charge', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'delivery_charge', array('maxlength' => 255, 'class' => 'form-control', 'onkeyup' => 'addDeliveryCharge();')); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'delivery_charge'); ?></span>
                </div>

                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'discount_amount', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'discount_amount', array('maxlength' => 255, 'class' => 'form-control', 'onkeyup' => 'addDiscount();')); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'discount_amount'); ?></span>
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
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-xs-12 col-md-4">
                        <?php echo $form->labelEx($model, 'manufacturer_id'); ?>
                        <?php
                        echo $form->dropDownList(
                                $model, 'manufacturer_id', CHtml::listData(Company::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'prompt' => 'Select',
                                'class' => 'form-control',
                        ));
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped table-valign-middle" id="list">
                            <thead class="table-info">
                            <tr>
                                <th>SL</th>
                                <th>Category</th>
                                <th>Product Name</th>
                                <th>Code</th>
                                <th>Stock</th>
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
        <div class="col-md-12">
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
                            $("#list tbody").empty();
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
<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<script>
    let company_products = [];
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('SellOrder_date').value = date.format('YYYY-MM-DD');
        }
    });

    function safeNumber(val) {
        val = parseFloat(val);
        return isNaN(val) ? 0 : val;
    }
    
    $(document).ready(function () {
        $(".qty-amount").keyup(function () {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));
        });

        $(".qty-amount").on("keydown keyup", function () {
            let amount = safeNumber($("#SellOrderDetails_amount").val());
            let qty = safeNumber($("#SellOrderDetails_qty").val());
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

    $(function () {

        let xhrCompanyProducts = null;

        $('#SellOrder_manufacturer_id').on('change', function () {

            const companyId = $(this).val();
            if (!companyId) return;

            const $tbody = $('#list tbody');

            // 1️⃣ If tbody has rows → confirm
            if ($tbody.children('tr').length > 0) {
                const confirmed = confirm(
                    'Changing manufacturer will remove all existing items.\nDo you want to continue?'
                );

                if (!confirmed) {
                    // revert dropdown selection
                    $(this).val($(this).data('prev'));
                    return;
                }

                // user confirmed → clear table
                $tbody.empty();
            }

            // save current selection (for revert)
            $(this).data('prev', companyId);

            // Abort previous request if still running
            if (xhrCompanyProducts !== null) {
                xhrCompanyProducts.abort();
            }

            // Disable dropdown while loading
            const $ddl = $('#SellOrder_manufacturer_id');
            $ddl.prop('disabled', true).addClass('loading');

            xhrCompanyProducts = $.ajax({
                url: '<?php echo Yii::app()->createUrl("prodModels/Jquery_getCompanyProducts"); ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    company_id: companyId
                },
                success: function (res) {
                    console.log('Products:', res);

                    $.each(res, function (i, row) {
                        prependSellOrderRow(row);
                    });
                },
                error: function (xhr, status) {
                    if (status !== 'abort') {
                        alert('Failed to load products');
                    }
                },
                complete: function () {
                    $ddl.prop('disabled', false).removeClass('loading');
                }
            });

        });

    });


    function prependSellOrderRow(data) {
        const item_name = data.item_name;
        const model_id = data.id;
        const model_id_text = data.name;
        const code = data.code;
        const unit_price = data.sell_price ?? 0;
        const pp = data.purchasePrice ?? 0;
        const stock = data.current_stock ?? 0;
        const qty = '';
        const row_total = qty * unit_price;
        // console.log('Adding product:', data);

        $("#list tbody").prepend(`
            <tr class="item">
                <td class="serial text-center"></td>
                <td>
                    ${item_name}
                </td>
                <td>
                    ${model_id_text}
                    <input type="hidden" class="form-control temp_model_id"
                           value="${model_id}"
                           name="SellOrderDetails[temp_model_id][]">
                </td>
                <td>
                    ${code}
                </td>
                <td class="text-center">
                    ${stock}
                </td>

                <td class="text-center">
                    <input type="text"
                           class="form-control text-center temp_qty"
                           value="${qty}"
                           name="SellOrderDetails[temp_qty][]">
                </td>

                <td class="text-center">
                    <input type="text"
                           class="form-control temp_unit_price text-right"
                           value="${unit_price}"
                           name="SellOrderDetails[temp_unit_price][]">
                    <input type="hidden"
                           class="form-control temp-costing"
                           value="${pp}"
                           name="SellOrderDetails[temp_pp][]">
                </td>

                <td class="text-center">
                    <input type="text"
                           readonly
                           class="form-control row-total text-right"
                           value="${row_total}"
                           name="SellOrderDetails[temp_row_total][]">
                </td>

                <td>
                    <button type="button" class="btn btn-danger dlt">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
        `);

        calculateTotal();
    }


    $("#list").on("click", ".dlt", function () {
        $(this).closest("tr").remove();
        calculateTotal();
    });

    // on temp_qty change or keyup event calculate row total
    $("#list").on("keyup", ".temp_qty", function () {
        let qty = safeNumber($(this).val());
        let unit_price = safeNumber($(this).closest("tr").find(".temp_unit_price").val());
        qty = qty > 0 ? qty : 0;
        unit_price = unit_price > 0 ? unit_price : 0;
        $(this).closest("tr").find(".row-total").val((qty * unit_price).toFixed(2));
        calculateTotal();
    });


    // on temp_unit_price change or keyup event calculate row total
    $("#list").on("keyup", ".temp_unit_price", function () {
        let unit_price = safeNumber($(this).val());
        let qty = safeNumber($(this).closest("tr").find(".temp_qty").val());
        qty = qty > 0 ? qty : 0;
        unit_price = unit_price > 0 ? unit_price : 0;
        $(this).closest("tr").find(".row-total").val((qty * unit_price).toFixed(2));
        changeUnitPriceForSameModel($(this).closest("tr").find(".temp_model_id").val(), unit_price);
        calculateTotal();
    });

    function changeUnitPriceForSameModel(model_id, price) {
        // find all same model id and change the price except the current row
        $(".temp_qty").each(function () {
            if ($(this).closest("tr").find(".temp_model_id").val() == model_id) {
                if ($(this).closest("tr").find(".temp_unit_price").val() != price) {
                    $(this).closest("tr").find(".temp_unit_price").val(price);
                    let qty = safeNumber($(this).val());
                    qty = qty > 0 ? qty : 0;
                    $(this).closest("tr").find(".row-total").val((qty * price).toFixed(2));
                }
            }
        });
    }


    function calculateVat() {
        let total_amount = safeNumber($("#SellOrder_total_amount").val());
        let vat_p = safeNumber($("#SellOrder_vat_percentage").val());
        total_amount = total_amount > 0 ? total_amount : 0;
        vat_p = vat_p > 0 ? vat_p : 0;
        let vat = safeNumber(((vat_p / 100) * total_amount));
        let grand_total = safeNumber(total_amount + vat);
        $("#SellOrder_vat_amount").val(vat.toFixed(2));
        $("#SellOrder_grand_total").val(grand_total.toFixed(2));
    }


    function resetProduct() {
        $("#model_id_text").val('');
        $("#SellOrderDetails_model_id").val('');
        resetProductSlNo();
        showPurchasePrice(0);
    }

    function resetProductSlNo() {
        $("#product_sl_no").val('');
    }

    function clearDynamicItem() {
        $("#SellOrderDetails_model_id").val('');
        $("#product_sl_no").val('');
        $("#model_id_text").val('');
        $("#SellOrderDetails_amount").val('');
        $("#SellOrderDetails_row_total").val('');
        $("#SellOrderDetails_qty").val('');
    }

    function resetDynamicItem() {
        $("#SellOrderDetails_model_id").val('');
        $("#model_id_text").val('');
        $("#SellOrderDetails_amount").val('');
        $("#SellOrderDetails_row_total").val('');
        $("#SellOrderDetails_qty").val('');
        showPurchasePrice(0);
    }

    function calculateTotal() {
        let item_count = $(".item").length;

        let total = 0;
        $('.row-total').each(function () {
            total += safeNumber($(this).val());
        });


        $("#SellOrder_total_amount").val(total.toFixed(2)).change();
        $("#SellOrder_item_count").val(item_count);

        calculateVat();
        addDeliveryCharge();

        tableSerial();
    }

    function addDeliveryCharge() {
        let delivery_charge = safeNumber($("#SellOrder_delivery_charge").val());
        let total_amount = safeNumber($("#SellOrder_total_amount").val());
        let vat_amount = safeNumber($("#SellOrder_vat_amount").val());

        delivery_charge = isNaN(delivery_charge) ? 0 : delivery_charge;
        vat_amount = isNaN(vat_amount) ? 0 : vat_amount;
        total_amount = isNaN(total_amount) ? 0 : total_amount;

        $("#SellOrder_grand_total").val((delivery_charge + total_amount + vat_amount).toFixed(2));
        addDiscount();
    }

    function addDiscount() {
        let delivery_charge = safeNumber($("#SellOrder_delivery_charge").val());
        let total_amount = safeNumber($("#SellOrder_total_amount").val());
        let vat_amount = safeNumber($("#SellOrder_vat_amount").val());
        let discount_amount = safeNumber($("#SellOrder_discount_amount").val());

        delivery_charge = isNaN(delivery_charge) ? 0 : delivery_charge;
        vat_amount = isNaN(vat_amount) ? 0 : vat_amount;
        total_amount = isNaN(total_amount) ? 0 : total_amount;
        discount_amount = isNaN(discount_amount) ? 0 : discount_amount;

        let grand_total = (delivery_charge + total_amount + vat_amount) - discount_amount;

        $("#SellOrder_grand_total").val((grand_total).toFixed(2));

        lossAlert();
    }

    function calculateTotalCosting() {
        let total_costing = 0;
        if ($(".temp-costing").length > 0) {
            $(".temp-costing").each(function () {
                let qty = safeNumber($(this).closest("tr").find(".temp_qty").val());
                let pp = safeNumber($(this).val());
                qty = isNaN(qty) ? 0 : qty;
                pp = isNaN(pp) ? 0 : pp;

                // console.log(`Qty: ${qty}, PP: ${pp}`);
                total_costing += qty * pp;
            });
        }
        // console.log(total_costing);
        $(".current-costing-amount").html('<span style="color: green;">Costing: <b>' + safeNumber(total_costing).toFixed(2) + '</b></span>');
        return total_costing;
    }


    function lossAlert() {
        calculateTotalCosting();
        let total_costing = calculateTotalCosting();
        let grand_total = safeNumber($("#SellOrder_grand_total").val());
        grand_total = grand_total > 0 ? grand_total : 0;

        let loss = safeNumber(grand_total - total_costing);
        if (loss < 0) {
            // let message =   "You are going to loss " + safeNumber(loss).toFixed(2) + " BDT from this invoice!";
            let message = `You are going to loss ${safeNumber(loss).toFixed(2)} BDT from this invoice!`;
            toastr.error(message);
            $("#formResultError").html(message).removeClass("d-none");
        } else {
            $("#formResultError").html("").addClass("d-none");
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

    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            return false;
        }
    });

    function showPurchasePrice(purchasePrice = 0) {
        if (purchasePrice > 0)
            $('.costing-amount').html('<span style="color: green;">P.P: <b>' + safeNumber(purchasePrice).toFixed(2) + '</b></span>');
        else
            $('.costing-amount').html('');
        $("#SellOrderDetails_pp").val(purchasePrice);
    }

    function showCurrentStock(stock = 0) {
        if (stock >= 0)
            $('.current-stock').html('<span style="color: green;">Stock: <b>' + safeNumber(stock).toFixed(2) + '</b></span>');
        else
            $('.current-stock').html('<span style="color: red;">Stock: <b>' + safeNumber(stock).toFixed(2) + '</b></span>');
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
