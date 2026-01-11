<?php
$this->widget('application.components.BreadCrumb', array(
        'crumbs' => array(
                array('name' => 'Sales', 'url' => array('admin')),
                array('name' => 'Order', 'url' => array('admin')),
                array('name' => 'Update Order: ' . $model->so_no),
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
<style>

    /* Ultra compact table */
    .table-compact {
        margin-bottom: 0;
        font-size: 12px;
    }

    .table-compact th,
    .table-compact td {
        padding: 4px 6px !important;
        vertical-align: middle;
    }

    .table-compact input.form-control {
        height: 24px;
        padding: 2px 4px;
        font-size: 12px;
    }

    .table-compact .form-control {
        border-radius: 2px;
    }

    /* Compact header */
    .table-compact thead th {
        padding: 6px !important;
        font-weight: 600;
    }

    /* Reduce row height further */
    .table-compact tr {
        line-height: 1.2;
    }
    .table-compact input.form-control {
        border-color: #ccc;
    }
</style>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Order' : 'Update Order:' . $model->so_no); ?></h3>

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
                            <?php echo $form->textField($model, 'date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => $model->date)); ?>
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
                                'prompt' => 'Select',
                                'class' => 'form-control',
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'cash_due'); ?></span>
                </div>
            </div>

            <?php
            $customer = Customers::model()->findByPk($model->customer_id);
            ?>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row">
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
                                    $.post('<?php echo Yii::app()->baseUrl ?>/index.php/sell/customers/Jquery_customerSearch', {
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
                    <div class="table table-responsive">
                        <table class="table table-bordered  table-sm table-valign-middle table-compact" id="list">
                            <tbody>
                            <?php
                            $criteria = new CDbCriteria();
                            $criteria->select = "
                                t.id, t.model_name, t.code, t.sell_price, t.purchase_price,
                                companies.name AS company_name,
                                (SUM(inventory.stock_in) - SUM(inventory.stock_out)) AS current_stock
                            ";
                            $criteria->addColumnCondition(['t.status' => 1]);
                            $criteria->join = "
                                LEFT JOIN companies ON companies.id = t.manufacturer_id
                                LEFT JOIN inventory ON inventory.model_id = t.id
                            ";
                            $criteria->group = "t.id";
                            $criteria->order = "companies.name ASC, t.model_name ASC";
                            $dataProducts = ProdModels::model()->findAll($criteria);


                            $saleDetailsCriteria = new CDbCriteria();
                            $saleDetailsCriteria->addCondition('sell_order_id=' . $model->id);
                            $modelDetails = SellOrderDetails::model()->findAll($saleDetailsCriteria);
                            $totalCosting = 0;
                            $currentCompany = '';
                            $groupIndex = 0;

                            foreach ($dataProducts as $product) {

                                // find sold qty from $modelDetails
                                $soldQty = 0;
                                $salePrice = 0;
                                $purchasePrice = 0;
                                $rowTotal = 0;
                                $rowCosting = 0;
                                foreach ($modelDetails as $detail) {
                                    if ($detail->model_id == $product->id) {
                                        $soldQty = $detail->qty;
                                        $salePrice = $detail->amount;
                                        $purchasePrice = $detail->purchase_price;
                                        $rowTotal = $detail->row_total;
                                        $rowCosting = $detail->costing;
                                        break;
                                    }
                                }
                                if ($purchasePrice <= 0) {
                                    $purchasePrice = $product->purchase_price;
                                }
                                if ($rowCosting <= 0) {
                                    $rowCosting = $purchasePrice * $soldQty;
                                }
                                $totalCosting += $rowCosting;
                                if ($currentCompany !== $product->company_name) {
                                    $groupIndex++;
                                    $currentCompany = $product->company_name;
                                    ?>

                                    <!-- Company Header -->
                                    <tr class="company-header"
                                        data-target="company-<?= $groupIndex ?>"
                                        style="cursor:pointer">
                                        <td colspan="8">
                                            🏭 <?= CHtml::encode($currentCompany) ?>
                                            <span class="toggle-icon">▼</span>
                                        </td>
                                    </tr>
                                    <tr class="company-<?= $groupIndex ?>" style="display:none;">
                                        <th>SL</th>
                                        <th>Product Name</th>
                                        <th>Code</th>
                                        <th>Stock</th>
                                        <th style="width: 10%;" class="text-center">Qty</th>
                                        <th style="width: 10%;" class="text-center">Unit Price</th>
                                        <th style="width: 10%;" class="text-center">Row Total</th>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr class="company-<?= $groupIndex ?> item" style="display:none;">
                                    <td class="serial"></td>
                                    <td><?= $product->company_name ?></td>
                                    <td>
                                        <?= $product->model_name ?>
                                        <input type="hidden" class="form-control temp_model_id"
                                               value="<?= $product->id ?>"
                                               name="SellOrderDetails[temp_model_id][]">
                                    </td>
                                    <td><?= $product->code ?></td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control text-center temp_qty"
                                                   value="<?= $soldQty != 0 ? $soldQty : '' ?>"
                                                   name=SellOrderDetails[temp_qty][]">
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control temp_unit_price text-right"
                                                   value="<?= $soldQty != 0 ? $salePrice : $product->sell_price ?>"
                                                   name="SellOrderDetails[temp_unit_price][]">
                                        </label>

                                        <input type="hidden" class="form-control text-center temp-costing"
                                               value="<?= $purchasePrice ?>"
                                               name=SellOrderDetails[temp_pp][]">
                                    </td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control row-total text-right" readonly
                                                   value="<?= $soldQty != 0 ? $rowTotal : '' ?>"
                                                   name="SellOrderDetails[temp_row_total][]">
                                        </label>
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
                $mr_count = $totalMrData['mr_count'];
                if ($totalMr > 0) {
                    ?>
                    <div class="alert alert-info font-weight-bold">
                        You've already collect <strong><?= number_format($totalMr, 2) ?></strong> from this invoice.
                        <br>
                        Total discount: <?= number_format($totalMrDiscount, 2) ?>
                        <br>
                        Total number of MR: <strong class="mr-count"><?= $mr_count ?></strong>
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
//                            $("#bom-form")[0].reset();
                            $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
//                            $("#list").empty();
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
                        let cash_due = $("#SellOrder_cash_due").val();  
                        let date = $("#SellOrder_date").val();  
                        let customer_id = $("#SellOrder_customer_id").val();  
                        let grand_total = $("#SellOrder_grand_total").val();  
                        let collectedAmount = safeNumber($("#collectedAmount").val()); 
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
                            toastr.error("Please add product to list.");
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
    $(function () {

        $('.company-header').on('click', function () {
            const target = $(this).data('target');
            const rows = $('.' + target);
            const icon = $(this).find('.toggle-icon');

            const isOpen = rows.first().is(':visible');

            rows.toggle(!isOpen);
            $(this).toggleClass('open', !isOpen);
            icon.html(isOpen ? '▼' : '▲');
        });

    });
    let prev_product_id = 0;
    let prev_sell_price = 0;
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        // minDate: moment(),
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
        });
    });


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
            console.log($(this).closest("tr").find(".temp_model_id").val());
            console.log(model_id);
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

    function calculateTotalCosting() {
        let total_costing = 0;
        if ($(".temp-costing").length > 0) {
            $(".temp-costing").each(function () {
                total_costing += safeNumber($(this).val());
            });
        }
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
            toastr.clear(); // Clear existing toasts to prevent duplicates
            toastr.error("You are going to loss " + safeNumber(loss).toFixed(2) + " BDT from this invoice!");
        } else {
            toastr.clear(); // Clear existing toasts to prevent duplicates
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        $(".current-costing-amount").html('<span style="color: green;">Costing: <b>' + <?= $totalCosting  ?> + '</b></span>');
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


