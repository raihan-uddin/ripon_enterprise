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
<style>
    /*    on input focus change backgroudn colr*/
    input {
        background-color: #fff;
        color: #212529;
        border: 1px solid #ced4da;
        padding: 6px 10px;
        transition: background-color 0.2s ease,
        border-color 0.2s ease,
        box-shadow 0.2s ease;
    }

    /* Hover effect */
    input:hover {
        background-color: #f1f7fb; /* subtle highlight */
        border-color: #236280;
        cursor: text; /* cursor change */
    }

    /* Focus (when clicked / typing) */
    input:focus {
        background-color: #ffffff;
        border-color: #236280;
        outline: none;
        box-shadow: 0 0 0 0.15rem rgba(35, 98, 128, 0.25);
    }

    /* Disabled state (optional but standard) */
    input:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
        opacity: 0.7;
    }

    /* Compact table */
    .table-compact td,
    .table-compact th {
        padding: 4px 6px;
        font-size: 13px;
        white-space: nowrap;
    }

    /* Sticky company header */
    .company-header {
        background: #f1f5f9;
        font-weight: 600;
        position: sticky;
        top: 0;
        z-index: 3;
    }

    /* Inputs fit cells */
    .table-compact input.form-control {
        height: 28px;
        padding: 2px 6px;
        font-size: 13px;
    }

    .hidden {
        display: none;
    }

    tbody {
        padding: 0;
        margin: 0;
    }

</style>

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
            </div>

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-4">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'customer_id', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" data-target-input="nearest">
                            <input type="text" id="customer_id_text" class="form-control">
                            <?php echo $form->hiddenField($model, 'customer_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <?php echo CHtml::link(' <i class="fa fa-plus"></i>', "", array('onclick' => "{addDistributor(); $('#dialogAddDistributor').dialog('open');}")); ?>
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
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-valign-middle table-sticky table-compact"
                               id="list">
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
                            $data = ProdModels::model()->findAll($criteria);

                            $sl = 1;
                            $currentCompany = '';
                            $groupIndex = 0;

                            foreach ($data as $item) {
                                if ($currentCompany !== $item->company_name) {
                                    $groupIndex++;
                                    $currentCompany = $item->company_name;
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
                                    <tr class="company-<?= $groupIndex ?> hidden">
                                        <th style="width: 5px;">SL</th>
                                        <th style="max-width: 150px;">Product Name</th>
                                        <th style="width: 10px;">Stock</th>
                                        <th style="width: 10%;" class="text-center">Qty</th>
                                        <th style="width: 10%;" class="text-center">Unit Price</th>
                                        <th style="width: 10%;" class="text-center">Row Total</th>
                                    </tr>
                                    <?php
                                }
                                ?>

                                <!-- Product Row (collapsed by default) -->
                                <tr class="company-<?= $groupIndex ?> item hidden">
                                    <td class="serial text-center"><?= $sl++ ?></td>
                                    <td data-label="Product">
                                        <?php echo $item->model_name; ?>
                                        <br>
                                        <small>
                                            <i><?php echo $item->code; ?></i>
                                        </small>
                                        <input type="hidden" class="form-control temp_model_id"
                                               value="<?php echo $item->id; ?>"
                                               name="SellOrderDetails[temp_model_id][]">
                                    </td>
                                    <td class="text-center" data-label="Stock">
                                        <?php echo $item->current_stock; ?>
                                    </td>

                                    <td class="text-center" data-label="Qty">
                                        <label>
                                            <input type="text"
                                                   class="form-control text-center temp_qty"
                                                   value=""
                                                   name="SellOrderDetails[temp_qty][]">
                                        </label>
                                    </td>

                                    <td class="text-center" data-label="Unit Price">
                                        <label>
                                            <input type="text"
                                                   class="form-control temp_unit_price text-right"
                                                   autocomplete="off"
                                                   inputmode="decimal"
                                                   value="<?php echo $item->sell_price; ?>"
                                                   name="SellOrderDetails[temp_unit_price][]">
                                        </label>
                                        <input type="hidden"
                                               class="form-control temp-costing"
                                               value="<?php echo $item->purchase_price; ?>"
                                               name="SellOrderDetails[temp_pp][]">
                                    </td>

                                    <td class="text-center" data-label="Row Total">
                                        <label>
                                            <input type="text"
                                                   class="form-control row-total text-right"
                                                   value=""
                                                   inputmode="decimal"
                                                   name="SellOrderDetails[temp_row_total][]">
                                        </label>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot style="text-align: right;">
                            <tr>
                                <td colspan="3"><?php echo $form->labelEx($model, 'total_amount', ['value' => '']); ?></td>
                                <td><?php echo $form->textField($model, 'total_qty', array('maxlength' => 255, 'class' => 'form-control text-center', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon3", 'readonly' => true)); ?></td>
                                <td><?php echo $form->textField($model, 'avg_sp', array('maxlength' => 255, 'class' => 'form-control text-center', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon3", 'readonly' => true)); ?></td>
                                <td>
                                    <?php echo $form->textField($model, 'total_amount', array('maxlength' => 255, 'class' => 'form-control text-center', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon3", 'readonly' => true)); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <?php echo $form->labelEx($model, 'vat', ['class' => '']); ?> (+)
                                </td>
                                <td>
                                    <?php echo $form->textField($model, 'vat_percentage', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '%', "aria-label" => "%", "aria-describedby" => "basic-addon1", 'value' => '0')); ?>
                                </td>
                                <td colspan="2">
                                    <?php echo $form->textField($model, 'vat_amount', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '%', "aria-label" => "%", "aria-describedby" => "basic-addon2", 'readonly' => true, 'value' => 0)); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <?php echo $form->labelEx($model, 'delivery_charge', ['class' => '']); ?> (+)
                                </td>
                                <td colspan="3">
                                    <?php echo $form->textField($model, 'delivery_charge', array('maxlength' => 255, 'class' => 'form-control', 'onkeyup' => 'addDeliveryCharge();', 'value' => '0', 'placeholder' => '0.00')); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <?php echo $form->labelEx($model, 'discount_amount', ['class' => '']); ?> (-)
                                </td>
                                <td colspan="3">
                                    <?php echo $form->textField($model, 'discount_amount', array('maxlength' => 255, 'class' => 'form-control', 'onkeyup' => 'addDiscount();', 'value' => '0', 'placeholder' => '0.00')); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <?php echo $form->labelEx($model, 'road_fee', ['class' => '']); ?> (-)
                                </td>
                                <td colspan="3">
                                    <?php echo $form->textField($model, 'road_fee', array('maxlength' => 255, 'class' => 'form-control', 'value' => '0', 'placeholder' => '0.00')); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <?php echo $form->labelEx($model, 'damage_value', ['class' => '']); ?> (-)
                                </td>
                                <td colspan="3">
                                    <?php echo $form->textField($model, 'damage_value', array('maxlength' => 255, 'class' => 'form-control', 'value' => '0', 'placeholder' => '0.00')); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <?php echo $form->labelEx($model, 'sr_commission', ['class' => '']); ?> (-)
                                </td>
                                <td colspan="3">
                                    <?php echo $form->textField($model, 'sr_commission', array('maxlength' => 255, 'class' => 'form-control', 'value' => '0', 'placeholder' => '0.00')); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <?php echo $form->labelEx($model, 'grand_total', ['class' => '']); ?>
                                </td>
                                <td colspan="3">
                                    <?php echo $form->textField($model, 'grand_total', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon4", 'readonly' => true)); ?>
                                </td>
                            </tr>
                            </tfoot>
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
                        let date = $("#SellOrder_date").val();  
                        let customer_id = $("#SellOrder_customer_id").val();  
                        let grand_total = $("#SellOrder_grand_total").val();  
                        if(date == ""){
                            toastr.error("Please insert date.");
                            return false;
                        }else if(customer_id == ""){
                            toastr.error("Please select customer from the list!");
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
    $('input').on('click', function () {
        $(this).select();
    });

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

    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('SellOrder_date').value = date.format('YYYY-MM-DD');
        }
    });

    $(document).ready(function () {
        $("#SellOrder_vat_percentage, #SellOrder_delivery_charge, #SellOrder_discount_amount")
            .on("input", function () {
                sanitizeDecimalInput(this, 4);
            });

        $(".qty-amount").on("keydown keyup", function () {
            sanitizeDecimalInput(this, 4);

            let amount = safeNumber($("#SellOrderDetails_amount").val());
            let qty = safeNumber($("#SellOrderDetails_qty").val());
            amount = amount > 0 ? amount : 0;
            qty = qty > 0 ? qty : 0;

            $("#SellOrderDetails_row_total").val((amount * qty).toFixed(2));
        });

        // on temp_qty change or keyup event calculate row total
        $("#list").on("keyup", ".temp_qty", function () {

            sanitizeDecimalInput(this, 4);

            let qty = safeNumber($(this).val());
            let unit_price = safeNumber($(this).closest("tr").find(".temp_unit_price").val());
            qty = qty > 0 ? qty : 0;
            unit_price = unit_price > 0 ? unit_price : 0;
            $(this).closest("tr").find(".row-total").val((qty * unit_price).toFixed(2));
            calculateTotal();
        });


        // on temp_unit_price change or keyup event calculate row total
        $("#list").on("keyup", ".temp_unit_price", function () {
            sanitizeDecimalInput(this, 4);
            let unit_price = safeNumber($(this).val());
            let qty = safeNumber($(this).closest("tr").find(".temp_qty").val());
            qty = qty > 0 ? qty : 0;
            unit_price = unit_price > 0 ? unit_price : 0;
            $(this).closest("tr").find(".row-total").val((qty * unit_price).toFixed(2));
            calculateTotal();
        });

        $(".row-total").on("keydown keyup", function () {

            sanitizeDecimalInput(this, 4);

            let qty = safeNumber($(this).closest("tr").find(".temp_qty").val());
            // calculate unit price row total / qty
            let row_total = safeNumber($(this).val());
            qty = qty > 0 ? qty : 0;
            let unit_price = qty > 0 ? (row_total / qty) : 0;
            $(this).closest("tr").find(".temp_unit_price").val(unit_price.toFixed(4));

            calculateTotal();
        });


        $("#SellOrder_vat_percentage").on("keydown keyup", function () {
            calculateVat();
            calculateTotal();
        });

        $("#SellOrder_road_fee").on("keydown keyup", function () {
            calculateTotal();
        });

        $("#SellOrder_damage_value").on("keydown keyup", function () {
            calculateTotal();
        });

        $("#SellOrder_sr_commission").on("keydown keyup", function () {
            calculateTotal();
        });
    });


    function safeNumber(val) {
        val = parseFloat(val);
        return isNaN(val) ? 0 : val;
    }

    function sanitizeDecimalInput(el, decimals = null) {
        if (!el) return; // guard: undefined / null

        const $el = $(el);

        // ensure it's an input or textarea
        if (!$el.is('input, textarea')) return;

        let value = $el.val();

        if (typeof value !== 'string') return;

        value = value
            .replace(/[^0-9.]/g, '')
            .replace(/(\..*)\./g, '$1');

        if (decimals !== null) {
            const regex = new RegExp(`(\\.\\d{${decimals}}).+`);
            value = value.replace(regex, '$1');
        }

        $el.val(value);
    }

    function calculateVat() {
        let total_amount = safeNumber($("#SellOrder_total_amount").val());
        let vat_p = safeNumber($("#SellOrder_vat_percentage").val());
        total_amount = total_amount > 0 ? total_amount : 0;
        vat_p = vat_p > 0 ? vat_p : 0;
        let vat = safeNumber(((vat_p / 100) * total_amount));
        $("#SellOrder_vat_amount").val(vat.toFixed(2));

        calculateTotal();
    }


    function addDeliveryCharge() {
        sanitizeDecimalInput(this, 4);
        calculateTotal();
    }

    function addDiscount() {
        sanitizeDecimalInput(this, 4);
        calculateTotal();
    }

    function calculateTotal() {

        let qtyTotal = 0;
        let rowTotal = 0;
        $('.temp_qty').each(function () {
            let qty = safeNumber($(this).val());
            let row_total = safeNumber($(this).closest("tr").find(".row-total").val());
            qtyTotal += qty;
            rowTotal += row_total;
        });
        $("#SellOrder_total_qty").val(qtyTotal);
        $("#SellOrder_total_amount").val(rowTotal.toFixed(4)).change();


        let road_fee = safeNumber($("#SellOrder_road_fee").val());
        let damage_value = safeNumber($("#SellOrder_damage_value").val());
        let vat_amount = safeNumber($("#SellOrder_vat_amount").val());
        let discount_amount = safeNumber($("#SellOrder_discount_amount").val());
        let total_amount = safeNumber($("#SellOrder_total_amount").val());
        let delivery_charge = safeNumber($("#SellOrder_delivery_charge").val());
        let sr_commission = safeNumber($("#SellOrder_sr_commission").val());

        let grand_total = (total_amount + vat_amount + delivery_charge) - (discount_amount + road_fee + damage_value + sr_commission);
        $("#SellOrder_grand_total").val(grand_total.toFixed(2));
        let avg_sp = qtyTotal > 0
            ? total_amount / qtyTotal
            : 0;
        $("#SellOrder_avg_sp").val(avg_sp.toFixed(4));
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
            console.log(message);
            $("#formResultError").html(message).removeClass("d-none");
        } else {
            $("#formResultError").html("").addClass("d-none");
        }

    }

    /*document.addEventListener('DOMContentLoaded', function () {
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
    });*/

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
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
