<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Quotation', 'url' => array('admin')),
        array('name' => 'Create'),
    ),
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

<style>
    /* Company card */
    .company-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8f9fb;
        padding: 10px 14px;
        border-radius: 6px;
        border-left: 4px solid #4c6ef5;
    }

    .company-name {
        font-weight: 600;
        font-size: 14px;
        color: #212529;
    }

    .toggle {
        cursor: pointer;
        font-size: 14px;
        margin-right: 8px;
    }

    .company-meta {
        display: flex;
        gap: 16px;
        font-size: 13px;
        color: #495057;
    }

    .company-subtotal {
        font-weight: 600;
        color: #2b8a3e;
    }

    /* Product rows */
    .product-row td {
        background: #ffffff;
    }

    .indent {
        color: #adb5bd;
        text-align: center;
    }

    .product-row:hover td {
        background: #f8f9fa;
    }
</style>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Draft Order' : 'Update Order'); ?></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model, 'entry_date'); ?>
                <div class="input-group" id="entry_date" data-target-input="nearest">
                    <?php echo $form->textField($model, 'date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <span class="help-block"
                        style="color: red; width: 100%"> <?php echo $form->error($model, 'entry_date'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model, 'customer_id'); ?>
                <div class="input-group" id="customer_id" data-target-input="nearest">
                    <input type="text" id="customer_id_text" class="form-control">
                    <?php echo $form->hiddenField($model, 'customer_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <?php
                            echo CHtml::link(' <i class="fa fa-plus"></i>', "",
                                array(
                                    'onclick' => "{addDistributor(); $('#dialogAddDistributor').dialog('open');}"));
                            ?>
                            <?php
                            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
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
                                        $('#SellOrderQuotation_customer_id').val(data.id).change();
                                    }
                                }",
                                    ))
                                    ?>
                                    return false;
                                }
                            </script>
                        </div>
                    </div>
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
                                    $('#SellOrderQuotation_customer_id').val(ui.item.id);
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
                <span class="help-block"
                        style="color: red; width: 100%"> <?php echo $form->error($model, 'customer_id'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model2, 'total_amount'); ?>
                <div class="input-group" id="total_amount" data-target-input="nearest">
                    <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3"><i class="fa fa-money"></i> </span>
                    </div>
                    <?php echo $form->textField($model, 'total_amount', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon3", 'readonly' => true)); ?>
                </div>
                <span class="help-block"
                        style="color: red; width: 100%"> <?php echo $form->error($model, 'total_amount'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model2, 'delivery_charge'); ?>
                <div class="input-group" id="delivery_charge" data-target-input="nearest">
                    <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3"><i class="fa fa-money"></i> </span>
                    </div>
                    <?php echo $form->textField($model, 'delivery_charge', array('maxlength' => 255, 'class' => 'form-control', 'onkeyup' => 'addDeliveryCharge();')); ?>
                </div>
                <span class="help-block"
                        style="color: red; width: 100%"> <?php echo $form->error($model, 'delivery_charge'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model2, 'discount_amount'); ?>
                <div class="input-group" id="discount_amount" data-target-input="nearest">
                    <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3"><i class="fa fa-money"></i> </span>
                    </div>
                    <?php echo $form->textField($model, 'discount_amount', array('maxlength' => 255, 'class' => 'form-control', 'onkeyup' => 'addDiscount();')); ?>
                </div>
                <span class="help-block"
                        style="color: red; width: 100%"> <?php echo $form->error($model, 'discount_amount'); ?></span>
            </div>
            
            <div class="form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model2, 'grand_total'); ?>
                <div class="input-group" id="grand_total" data-target-input="nearest">
                    <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3"><i class="fa fa-money"></i> </span>
                    </div>
                    <?php echo $form->textField($model, 'grand_total', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon4", 'readonly' => true)); ?>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-eye eye-icon" style="cursor: pointer;"></i>
                        </span>
                    </div>
                </div>
                <span class="current-costing-amount" style="display: none;"></span>
                <span class="help-block"
                        style="color: red; width: 100%"> <?php echo $form->error($model, 'grand_total'); ?></span>
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
                        <table class="table table-bordered table-sm table-striped table-valign-middle" id="list">
                            <thead class="table-info">
                            <tr>
                                <th style="width: 2%;">SL</th>
                                <th style="width: 2%;"></th>
                                <th>Product Name</th>
                                <th>Code</th>
                                <th>Stock</th>
                                <th style="width: 10%;" class="text-center">Qty</th>
                                <th style="width: 10%;" class="text-center">Unit Price</th>
                                <th style="width: 10%;" class="text-center">Row Total</th>
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
            echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('/sell/sellOrderQuotation/create', 'render' => true)), array(
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
                    let date = $("#SellOrderQuotation_date").val();  
                    let customer_id = $("#SellOrderQuotation_customer_id").val();  
                    let grand_total = $("#SellOrderQuotation_grand_total").val();  
                    if(date == ""){
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
    let prev_product_id = 0;
    let prev_sell_price = 0;
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('SellOrderQuotation_date').value = date.format('YYYY-MM-DD');
        }
    });

    function safeNumber(val) {
        val = parseFloat(val);
        return isNaN(val) ? 0 : val;
    }

    $(function () {

        let xhrCompanyProducts = null;

        $('#SellOrderQuotation_manufacturer_id').on('change', function () {

            const companyId = $(this).val();
            const companyName = $("#SellOrderQuotation_manufacturer_id option:selected").text();
            console.log('Selected Company ID:', companyId, 'Name:', companyName);
            if (!companyId) return;

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
                    // console.log('Products:', res);

                    res.forEach(row => {
                        row.company_name = companyName;
                    });

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
        const company = data.company_name;
        const model_id = data.id;
        const name = data.name;
        const code = data.code;
        const price = data.sell_price ?? 0;
        const pp = data.purchasePrice ?? 0;
        const stock = data.current_stock ?? 0;

        // Prevent duplicate
        if ($(`#list tbody .temp_model_id[value="${model_id}"]`).length) return;

        const tbody = $("#list tbody");

        // Find / create company card
        let companyRow = tbody.find(`.company-row[data-company="${company}"]`);

        if (!companyRow.length) {
            tbody.prepend(`
            <tr class="company-row" data-company="${company}">
                <td colspan="8">
                    <div class="company-card">
                        <span class="toggle">▾</span>
                        <span class="company-name">${company}</span>
                        <span class="company-meta">
                            <span class="item-count">0 items</span>
                            <span class="company-subtotal">৳ 0.00</span>
                        </span>
                    </div>
                </td>
            </tr>
        `);
            companyRow = tbody.find(`.company-row[data-company="${company}"]`);
        }

        companyRow.after(`
        <tr class="item product-row" data-company="${company}">
            <td class="serial"></td>
            <td class="indent">•</td>
            <td>
                ${name}
                <input type="hidden" class="temp_model_id"
                       value="${model_id}"
                       name="SellOrderQuotationDetails[temp_model_id][]">
            </td>
            <td>${code}</td>
            <td class="text-center">${stock}</td>
            <td><input class="form-control temp_qty" value=""  name="SellOrderQuotationDetails[temp_qty][]"></td>
            <td>
                <input class="form-control temp_unit_price" name="SellOrderQuotationDetails[temp_unit_price][]" value="${price}">
                <input type="hidden" class="form-control temp_pp" name="SellOrderQuotationDetails[temp_pp][]" value="${pp}">
            </td>
            <td><input class="form-control row-total" name="SellOrderQuotationDetails[temp_row_total][]" readonly value="0"></td>
        </tr>
    `);

        updateCompanySummary(company);
        calculateTotal();
    }
    function updateCompanySummary(company) {
        let totalAmount = 0;
        let totalQty = 0;
        let itemCount = 0;

        $(`.product-row[data-company="${company}"]`).each(function () {
            const qty = parseFloat($(this).find('.temp_qty').val()) || 0;
            const rowTotal = parseFloat($(this).find('.row-total').val()) || 0;

            if (qty > 0) {
                itemCount++;
                totalQty += qty;
                totalAmount += rowTotal;
            }
        });

        const header = $(`.company-row[data-company="${company}"]`);

        header.find('.item-count').text(`${itemCount} items`);
        header.find('.qty-count').text(`Qty: ${totalQty}`);
        header.find('.company-subtotal').text(`৳ ${totalAmount.toFixed(2)}`);
    }

    $(document).on('click', '.toggle', function () {
        const company = $(this).closest('.company-row').data('company');
        const rows = $(`.product-row[data-company="${company}"]`);

        rows.toggle();
        $(this).text(rows.is(':visible') ? '▾' : '▸');
    });

    $(document).ready(function () {
        $(".qty-amount").keyup(function () {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));
        });

        $(".qty-amount").on("keydown keyup", function () {
            let amount = parseFloat($("#SellOrderQuotationDetails_amount").val());
            let qty = parseFloat($("#SellOrderQuotationDetails_qty").val());
            amount = amount > 0 ? amount : 0;
            qty = qty > 0 ? qty : 0;

            $("#SellOrderQuotationDetails_row_total").val((amount * qty).toFixed(2));
        });
    });

    function addToList() {
        let model_id = $("#SellOrderQuotationDetails_model_id").val();
        let model_id_text = $("#model_id_text").val();
        let unit_price = parseFloat($("#SellOrderQuotationDetails_amount").val());
        unit_price = unit_price > 0 ? unit_price : 0;

        let qty = $("#SellOrderQuotationDetails_qty").val();
        let row_total = $("#SellOrderQuotationDetails_row_total").val();
        let pp = parseFloat($("#SellOrderQuotationDetails_pp").val());
        pp = pp > 0 ? pp : 0;
        let isproductpresent = false;
        let temp_codearray = document.getElementsByName("SellOrderQuotationDetails[temp_model_id][]");

        if (temp_codearray.length > 0) {
            for (let i = 0; i < temp_codearray.length; i++) {
                if (temp_codearray[i].value == model_id) {
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
                        <input type="hidden" class="form-control temp_model_id" value="${model_id}" name="SellOrderQuotationDetails[temp_model_id][]" >
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control text-center temp_qty" value="${qty}" name="SellOrderQuotationDetails[temp_qty][]">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control temp_unit_price text-right" value="${unit_price}" name="SellOrderQuotationDetails[temp_unit_price][]" >
                        <input type="hidden" class="form-control text-center temp-costing" value="${pp}" name="SellOrderQuotationDetails[temp_pp][]">
                    </td>
                    <td class="text-center">
                       <input type="text" readonly class="form-control row-total text-right" value="${row_total}" name="SellOrderQuotationDetails[temp_row_total][]" >
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i> </button>
                    </td>
                </tr>
                `);
            calculateTotal();
            resetDynamicItem();
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
        const row = $(this).closest('tr');
        let qty = parseFloat($(this).val());
        // ❌ Invalid qty handling
        if (isNaN(qty) || qty <= 0) {
            qty = 1;
            $(this).val(qty);
        }

        let unit_price = parseFloat($(this).closest("tr").find(".temp_unit_price").val());
        qty = qty > 0 ? qty : 0;
        unit_price = unit_price > 0 ? unit_price : 0;
        $(this).closest("tr").find(".row-total").val((qty * unit_price).toFixed(2));

        const company = row.data('company');
        updateCompanySummary(company);
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

    function resetProduct() {
        $("#model_id_text").val('');
        $("#SellOrderQuotationDetails_model_id").val('');
        resetProductSlNo();
        showPurchasePrice(0);
    }

    function resetDynamicItem() {
        $("#SellOrderQuotationDetails_model_id").val('');
        $("#model_id_text").val('');
        $("#SellOrderQuotationDetails_amount").val('');
        $("#SellOrderQuotationDetails_row_total").val('');
        $("#SellOrderQuotationDetails_qty").val('');
        showPurchasePrice(0);
    }

    function calculateTotal() {
        let item_count = $(".item").length;

        let total = 0;
        $('.row-total').each(function () {
            total += parseFloat($(this).val());
        });


        $("#SellOrderQuotation_total_amount").val(total.toFixed(2)).change();
        $("#SellOrderQuotation_item_count").val(item_count);

        addDeliveryCharge();

        tableSerial();
    }

    function addDeliveryCharge() {
        let delivery_charge = parseFloat($("#SellOrderQuotation_delivery_charge").val());
        let total_amount = parseFloat($("#SellOrderQuotation_total_amount").val());

        delivery_charge = isNaN(delivery_charge) ? 0 : delivery_charge;
        total_amount = isNaN(total_amount) ? 0 : total_amount;

        $("#SellOrderQuotation_grand_total").val((delivery_charge + total_amount).toFixed(2));
        addDiscount();
    }

    function addDiscount() {
        let delivery_charge = parseFloat($("#SellOrderQuotation_delivery_charge").val());
        let total_amount = parseFloat($("#SellOrderQuotation_total_amount").val());
        let discount_amount = parseFloat($("#SellOrderQuotation_discount_amount").val());

        delivery_charge = isNaN(delivery_charge) ? 0 : delivery_charge;
        total_amount = isNaN(total_amount) ? 0 : total_amount;
        discount_amount = isNaN(discount_amount) ? 0 : discount_amount;

        let grand_total = (delivery_charge + total_amount) - discount_amount;

        $("#SellOrderQuotation_grand_total").val((grand_total).toFixed(2));

    }

    function calculateTotalCosting() {
        let total_costing = 0;
        if ($(".temp-costing").length > 0) {
            $(".temp-costing").each(function () {
                let qty = parseFloat($(this).closest("tr").find(".temp_qty").val());
                let pp = parseFloat($(this).val());
                qty = isNaN(qty) ? 0 : qty;
                pp = isNaN(pp) ? 0 : pp;

                total_costing += qty * pp;
            });
        }
        // console.log(total_costing);
        $(".current-costing-amount").html('<span style="color: green;">Costing: <b>' + parseFloat(total_costing).toFixed(2) + '</b></span>');
        return total_costing;
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
            addToList();
            return false;
        }
    });

    function showPurchasePrice(purchasePrice = 0) {
        if (purchasePrice > 0)
            $('.costing-amount').html('<span style="color: green;">P.P: <b>' + parseFloat(purchasePrice).toFixed(2) + '</b></span>');
        else
            $('.costing-amount').html('');
        $("#SellOrderQuotationDetails_pp").val(purchasePrice);
    }

    function showCurrentStock(stock = 0) {
        if (stock >= 0)
            $('.current-stock').html('<span style="color: green;">Stock: <b>' + parseFloat(stock).toFixed(2) + '</b></span>');
        else
            $('.current-stock').html('<span style="color: red;">Stock: <b>' + parseFloat(stock).toFixed(2) + '</b></span>');
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
        'title' => 'ORDER QUOTATION PREVIEW',
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
                <h5 class="modal-title" id="exampleModalLabel">Quotation</h5>
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
