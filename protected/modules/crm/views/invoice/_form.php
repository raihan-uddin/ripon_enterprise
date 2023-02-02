<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Invoice', 'url' => array('admin')),
        array('name' => 'Create'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'invoice-form',
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
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Invoice' : 'Update Invoice'); ?></h3>

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
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'so_no', ['class' => 'col-sm-2 col-form-label']); ?>
                    <div class="col-sm-10">
                        <?php echo $form->textField($model, 'so_no', array('maxlength' => 255, 'class' => 'form-control ',)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'so_no'); ?></span>
                </div>
            </div>
            <div class="form-group col-xs-11 col-md-3 col-lg-3">
                <button class="btn  btn-info loading" type="button" id="btnFetch"><i class="fa fa-search"></i> Search
                </button>
                <a class="btn  btn-warning" type="button" id="btnReload"
                   href="<?= Yii::app()->request->requestUri ?>"><i class="fa fa-refresh"></i> Reload
                </a>
                <button class="btn  btn-danger" type="button" id="btnReset"><i class="fa fa-remove"></i> Reset
                </button>

                <a class="btn btn-success text-right" type="button"
                   href="<?= Yii::app()->baseUrl . '/index.php/crm/invoice/admin' ?>"><i class="fa fa-home"></i>
                    Invoice Manage
                </a>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Invoice Info</h3>

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
                    <div class="col-md-2">
                        <div class="form-group row" style="">
                            <?php echo $form->labelEx($model, 'date', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                            <div class="col-sm-12 col-md-9">
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
                    </div>

                    <div class="col-md-3">
                        <div class="form-group row" style="">
                            <?php echo $form->labelEx($model, 'customer_id', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                            <div class="col-sm-12 col-md-9">
                                <div class="input-group" id="customer_id" data-target-input="nearest">
                                    <?php echo $form->textField($model, 'customer_name', array('class' => 'form-control', 'readonly' => true)); ?>
                                    <?php echo $form->hiddenField($model, 'customer_id', array('class' => 'form-control', 'readonly' => true)); ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                                    </div>
                                </div>
                            </div>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model, 'customer_id'); ?></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group row" style="">
                            <?php echo $form->labelEx($model, 'order_id', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                            <div class="col-sm-12 col-md-9">
                                <div class="input-group" id="customer_id" data-target-input="nearest">
                                    <?php echo $form->textField($model, 'so_no', array('class' => 'form-control so-no', 'readonly' => true)); ?>
                                    <?php echo $form->hiddenField($model, 'order_id', array('class' => 'form-control', 'readonly' => true)); ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-first-order"></i></div>
                                    </div>
                                </div>
                            </div>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model, 'order_id'); ?></span>
                        </div>
                    </div>

                    <div class="table table-responsive">
                        <table class="table table-sm  table-hover table-bordered table-striped" id="list">
                            <thead>
                            <tr class="table-info">
                                <th class="text-center" style="width: 3%;">#</th>
                                <th>Materials</th>
                                <th class="text-center" style="width: 15%;">Color</th>
                                <th class="text-center" style="width: 15%;">Note</th>
                                <th class="text-center" style="width: 7%;">Ord. Qty</th>
                                <th class="text-center" style="width: 7%;">Rem. Qty</th>
                                <th class="text-center" style="width: 7%;">Bill. Qty</th>
                                <th class="text-center" style="width: 8%;">Unit Price</th>
                                <th class="text-center" style="width: 10%;">Row Total</th>
                                <th class="text-center" style="width: 3%;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4" class="text-right" style="vertical-align: middle">Calculation</th>
                                <th style="vertical-align: middle;">
                                    <input type="text" name="Invoice[temp_total_order_qty][]"
                                           class="form-control text-center total_order_qty" readonly>
                                </th>
                                <th style="vertical-align: middle;">
                                    <input type="text" name="Invoice[temp_rem_bill_qty][]"
                                           class="form-control text-center rem_bill_qty" readonly>
                                </th>
                                <th style="vertical-align: middle;">
                                    <input type="text" name="Invoice[temp_bill_qty][]"
                                           class="form-control text-center bill_qty" readonly>
                                </th>
                                <th style="vertical-align: middle;"></th>
                                <th style="vertical-align: middle;">
                                    <?php echo $form->textField($model, 'total_amount', array('class' => 'form-control  text-right total_amount', 'readonly' => true)); ?>
                                </th>
                                <th style="vertical-align: middle;"></th>
                            </tr>
                            <tr>
                                <th style="vertical-align: middle;" class="text-right" colspan="7">Vat</th>
                                <th style="vertical-align: middle;">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                        <?php echo $form->textField($model, 'vat_percentage', array('maxlength' => 255, 'class' => 'form-control text-center', 'placeholder' => '%', "aria-label" => "%", "aria-describedby" => "basic-addon1")); ?>
                                    </div>
                                </th>
                                <th style="vertical-align: middle;">
                                    <?php echo $form->textField($model, 'vat_amount', array('maxlength' => 255, 'class' => 'form-control text-right', 'placeholder' => '%', "aria-label" => "%", "aria-describedby" => "basic-addon2", 'readonly' => true)); ?>
                                </th>
                                <th style="vertical-align: middle;"></th>
                            </tr>

                            <tr>
                                <th style="vertical-align: middle;" class="text-right" colspan="7">Grand Total</th>
                                <th style="vertical-align: middle;" colspan="2">
                                    <?php echo $form->textField($model, 'grand_total', array('maxlength' => 255, 'class' => 'form-control text-right', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon4", 'readonly' => true)); ?>
                                </th>

                                <th style="vertical-align: middle;"></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <?php
        echo CHtml::ajaxSubmitButton('Create', CHtml::normalizeUrl(array('/crm/invoice/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#invoice-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#list tbody").empty();
                        $("#soReportDialogBox").dialog("open");
                        $("#AjFlashReportSo").html(data.soReportInfo).show();
                    }else{
                        $("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#invoice-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#invoice-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){  
                    let count_item =  $(".item").length; 
                    let date = $("#Invoice_date").val();  
                    let order_id = $("#Invoice_order_id").val();  
                    let customer_id = $("#Invoice_customer_id").val();  
                    let grand_total = $("#Invoice_grand_total").val();  
                    let bill_qty_zero = 0;
                    $(".bill-qty").each(function () {
                        var bill_qty_total = parseFloat($(this).val());
                        bill_qty_total = isNaN(bill_qty_total) ? 0 : bill_qty_total;
                        if(bill_qty_total <= 0){
                            bill_qty_zero++;
                            $(this).addClass("is-invalid");
                        }else{
                            $(this).removeClass("is-invalid");
                        }
                    });
                    let unit_price_zero = 0;
                    $(".unit-price").each(function () {
                        var up = parseFloat($(this).val());
                        up = isNaN(up) ? 0 : up;
                        if(up <= 0){
                            unit_price_zero++;
                            $(this).addClass("is-invalid");
                        }else{
                            $(this).removeClass("is-invalid");
                        }
                    });
                    if(date == ""){
                        toastr.error("Please insert date.");
                        return false;
                    }else if(customer_id == ""){
                        toastr.error("Customer not found! Please insert valid SO!");
                        return false;
                    }else if(order_id == ""){
                        toastr.error("Please insert valid SO!");
                        return false;
                    }else if(count_item <= 0){
                        toastr.error("Please add materials to list.");
                        return false;
                    }else if(bill_qty_zero > 0){
                        toastr.error("Please insert Bill qty.");
                        return false;
                    }else if(unit_price_zero > 0){
                        toastr.error("Please insert Unit Price.");
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

<?php $this->endWidget(); ?>


<script>
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('Invoice_date').value = date.format('YYYY-MM-DD');
        }
    });

    $(document).ready(function () {
        $("#btnReset").click(function () {
            cleanAll();
        });
        $("#btnFetch").click(function () {
            let so_no = $("#Invoice_so_no").val();
            let button = $(this);
            $.ajax({
                type: "post",
                url: "<?php echo Yii::app()->baseUrl ?>/index.php/sell/sellOrder/SoDetails",
                dataType: "json",
                data: jQuery.param({so_no: so_no}),
                cache: false,
                async: false,
                beforeSend: function () {
                    console.log('beforesend called');
                    button.prop("disabled", true);
                    // add spinner to button
                    button.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`);
                    $("#list tbody").append(`<tr><td colspan="10" class="text-center"><span class="spinner-border spinner-border text-success" role="status" aria-hidden="true"></span> Please wait...</td></tr>`);
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === 404) {
                        toastr.error(response.message);
                        // do something with response.message or whatever other data on error
                        cleanAll();
                    } else if (response.order_item_status === 405) {
                        toastr.error(response.message);
                        // do something with response.message or whatever other data on error
                        cleanAll();
                    } else if (response.status === 200) {
                        $("#Invoice_customer_name").val(response.order_info.customer_name);
                        $("#Invoice_customer_id").val(response.order_info.customer_id);
                        $("#Invoice_order_id").val(response.order_info.order_id);
                        $(".so-no").val(response.order_info.so_no);
                        $("#list tbody").empty();
                        for (var i = 0; i < response.order_items.length; i++) {
                            console.log(response.order_items[i]);
                            addToLlist(response.order_items[i], i);
                        }
                        calculateTotal();
                    }
                },
                error: function (xhr) { // if error occurred
                    alert("Error occurred.please try again");
                    // $(placeholder).append(xhr.statusText + xhr.responseText);
                    button.prop("disabled", false);
                    cleanAll();
                },
                complete: function () {
                    button.prop("disabled", false);
                    button.html(`<i class="fa fa-search"></i> Search`);
                },
            });
        });


        $("#list").on("click", ".dlt", function () {
            $(this).closest("tr").remove();
            calculateTotal();
        });


        function addToLlist(item, sl) {
            $("#list tbody").append(`
                <tr class="item">
                    <td class="text-center sl-no" style="vertical-align: middle;">${++sl}</td>
                    <td class="text-left" style="vertical-align: middle;">
                        ${item.model_name}
                        <input type="hidden" name="InvoiceDetails[temp_model_id][]"
                               class="form-control model-id" value="${item.model_id}">
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        ${item.color}
                        <input type="hidden" name="InvoiceDetails[temp_color][]" class="form-control color" value="${item.color}">
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        ${item.note}
                        <input type="hidden" name="InvoiceDetails[temp_note][]" class="form-control note" value="${item.note}">
                    </td>
                    <td class="text-center" style="vertical-align: middle; min-width: 125px;">
                        <span class="order-qty-span">${item.qty}</span>
                        <input type="hidden" name="InvoiceDetails[temp_order_qty][]"
                               class="form-control order-qty" value="${item.qty}">
                    </td>
                    <td class="text-center" style="vertical-align: middle;  min-width: 125px;">
                        <span class="rem-qty-span">${item.rem_qty}</span>
                        <input type="hidden" name="InvoiceDetails[temp_rem_qty][]"
                               class="form-control rem-qty " value="${item.rem_qty}">
                    </td>
                    <td class="text-center" style="vertical-align: middle;  min-width: 120px;">
                        <input type="text" name="InvoiceDetails[temp_bill_qty][]"
                               class="form-control text-center bill-qty">
                    </td>
                    <td class="text-center" style="vertical-align: middle;  min-width: 135px;">
                    <input type="text" name="InvoiceDetails[temp_unit_price][]"
                           class="form-control text-right unit-price" value="${item.unit_price}">
                    </td>
                    <td class="text-center" style="vertical-align: middle;  min-width: 180px;">
                    <input type="text" name="InvoiceDetails[temp_row_total][]"
                           class="form-control text-right row-total" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
            `);
        }
    });

    $(document).on('keyup', ".bill-qty, .unit-price", function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
        let bill_qty = parseFloat($(this).closest('tr').find('.bill-qty').val());
        console.log("Bill Qty: " + bill_qty);

        let rem_qty = parseFloat($(this).closest('tr').find('.rem-qty').val());
        let unit_price = parseFloat($(this).closest('tr').find('.unit-price').val());
        let _row_total = $(this).closest('tr').find('.row-total');
        bill_qty = isNaN(bill_qty) ? 0 : bill_qty;
        rem_qty = isNaN(rem_qty) ? 0 : rem_qty;
        unit_price = isNaN(unit_price) ? 0 : unit_price;
        if (rem_qty >= bill_qty) {
            let row_total = unit_price * bill_qty;
            _row_total.val(row_total);
            console.log("unit_price: " + unit_price);
        } else {
            this.value = '';
            _row_total.val('');
        }
        calculateTotal();
    });
    $("#Invoice_vat_percentage").on("keydown keyup", function () {
        calculateTotal();
    });

    function calculateTotal() {
        let order_qty = 0;
        $(".order-qty").each(function () {
            var order_qty_total = parseFloat($(this).val());
            order_qty_total = isNaN(order_qty_total) ? 0 : order_qty_total;
            order_qty += order_qty_total;
        });
        $('.total_order_qty').val(order_qty);

        let rem_qty = 0;
        $(".rem-qty").each(function () {
            var rem_qty_total = parseFloat($(this).val());
            rem_qty_total = isNaN(rem_qty_total) ? 0 : rem_qty_total;
            rem_qty += rem_qty_total;
        });
        $('.rem_bill_qty').val(rem_qty);

        let bill_qty = 0;
        $(".bill-qty").each(function () {
            var bill_qty_total = parseFloat($(this).val());
            bill_qty_total = isNaN(bill_qty_total) ? 0 : bill_qty_total;
            bill_qty += bill_qty_total;
        });
        $('.bill_qty').val(bill_qty);

        let row_total = 0;
        $(".row-total").each(function () {
            var unit_row_total = parseFloat($(this).val());
            unit_row_total = isNaN(unit_row_total) ? 0 : unit_row_total;
            row_total += unit_row_total;
        });
        $('.total_amount').val(row_total);

        let vat_p = parseFloat($("#Invoice_vat_percentage").val());

        vat_p = vat_p > 0 ? vat_p : 0;

        let vat = parseFloat(((vat_p / 100) * row_total));
        let grand_total = parseFloat(row_total + vat);
        $("#Invoice_vat_amount").val(vat.toFixed(2));
        $("#Invoice_grand_total").val(grand_total.toFixed(2));

    }

    function cleanAll() {
        $("#list tbody").empty();
        $("#invoice-form")[0].reset();
    }

    $(document).on('keyup', "#Invoice_vat_percentage", function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });
</script>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'INVOICE PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>


