<?php
/** @var mixed $model */
/** @var mixed $model2 */
/** @var mixed $model3 */
$this->widget('application.components.BreadCrumb', array(
        'crumbs' => array(
                array('name' => 'Purchase', 'url' => array('admin')),
                array('name' => 'Order', 'url' => array('admin')),
                array('name' => 'Update: ' . $model->po_no),
        ),
));
$supplier = Suppliers::model()->findByPk($model->supplier_id);
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
                    <div class="col-sm-8" style="pointer-events: none;">
                        <?php
                        echo $form->dropDownList(
                                $model, 'cash_due', Lookup::items('cash_due'), array(
                                'prompt' => 'Select',
                                'class' => 'form-control',
                                'readonly' => true,
                                'disabled' => true,
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'cash_due'); ?></span>
                </div>
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'date', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" id="entry_date" data-target-input="nearest">
                            <?php echo $form->textField($model, 'date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD',)); ?>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'date'); ?></span>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'supplier_id', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" data-target-input="nearest">
                            <label for="supplier_id_text"></label><input type="text" id="supplier_id_text"
                                                                         class="form-control"
                                                                         value="<?= $supplier->company_name ?>">
                            <?php echo $form->hiddenField($model, 'supplier_id', array('maxlength' => 255, 'class' => 'form-control',)); ?>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <?php
                                    echo CHtml::link(' <i class="fa fa-plus"></i>', "", array('onclick' => "{addSupplier(); $('#addSupplierDialog').dialog('open');}"));
                                    ?>


                                    <?php
                                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
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
                                        function addSupplier() {
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


                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'contact_no', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'contact_no', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true, 'value' => $supplier->company_contact_no)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'qty'); ?></span>
                </div>

                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'address', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'address', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true, 'value' => $supplier->company_address)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'address'); ?></span>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row" style="">
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

                <div class="form-group row" style="">
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

                <div class="form-group row" style="">
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
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped table-valign-middle" id="list">
                            <thead class="table-info">
                            <tr>
                                <th>SL</th>
                                <th>Category</th>
                                <th>Product Name</th>
                                <th>Code</th>
                                <th style="width: 10%;" class="text-center">Qty</th>
                                <th style="width: 10%;" class="text-center">Unit Price</th>
                                <th style="width: 10%;" class="text-center">Row Total</th>
<!--                                <th style="width: 4%;" class="text-center">Action</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $currentProduct = [];
                            foreach ($model3 as $key => $m3) {
                                $currentProduct[] = $m3->model_id;
                                ?>
                                <tr class="item">
                                    <td class="serial"></td>
                                    <td>
                                        <?= $m3->item_name ?>
                                    </td>
                                    <td>
                                        <?= $m3->model_name ?>
                                        <input type="hidden" class="form-control tmep_model_id"
                                               value="<?= $m3->model_id ?>"
                                               name="PurchaseOrderDetails[temp_model_id][]">
                                    </td>
                                    <td>
                                        <?= $m3->code ?>
                                    </td>

                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control text-center temp_qty"
                                                   value="<?= $m3->qty ?>"
                                                   name=PurchaseOrderDetails[temp_qty][]"">
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" class="form-control temp_unit_price"
                                                   value="<?= $m3->unit_price ?>"
                                                   name="PurchaseOrderDetails[temp_unit_price][]">
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label>
                                            <input type="text" readonly class="form-control row-total"
                                                   value="<?= $m3->row_total ?>"
                                                   name="PurchaseOrderDetails[temp_row_total][]">
                                        </label>
                                    </td>
                                    <!--<td>
                                        <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>-->
                                </tr>
                                <?php
                            }
                            if (count($currentProduct) > 0) {
                                $criteraia = new CDbCriteria();
                                $criteraia->addNotInCondition('t.id', $currentProduct);
                                $criteraia->addCondition('manufacturer_id=' . $baseCompanyId);
                                $criteraia->order = "t.item_id, t.brand_id, t.model_name asc";
                                $criteraia->join = " INNER JOIN prod_items pi ON pi.id = t.item_id ";
                                $criteraia->join .= " INNER JOIN prod_brands pb ON pb.id = t.brand_id ";
                                $criteraia->join .= "  LEFT JOIN (
                                    SELECT 
                                        model_id,
                                        SUM(stock_in) - SUM(stock_out) AS closing_stock
                                    FROM inventory
                                    GROUP BY model_id
                                ) inv ON inv.model_id = t.id ";
                                $criteraia->select = "t.id, t.model_name, t.code, pi.item_name, pb.brand_name, t.purchase_price, t.sell_price,  IFNULL(inv.closing_stock, 0) AS closing_stock";

                                $newProducts = ProdModels::model()->findAll($criteraia);
                                foreach ($newProducts

                                         as $singleProduct) {
                                    ?>
                                    <tr class="item">
                                        <td class="serial"></td>
                                        <td>
                                            <?= $singleProduct->item_name ?>
                                        </td>
                                        <td>
                                            <?= $singleProduct->model_name ?>
                                            <input type="hidden" class="form-control tmep_model_id"
                                                   value="<?= $singleProduct->id ?>"
                                                   name="PurchaseOrderDetails[temp_model_id][]">
                                        </td>
                                        <td>
                                            <?= $singleProduct->code ?>
                                        </td>
                                        <td class="text-center">
                                            <label>
                                                <input type="text" class="form-control text-center temp_qty"
                                                       name=PurchaseOrderDetails[temp_qty][]"">
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <label>
                                                <input type="text" class="form-control temp_unit_price"
                                                       value="<?= $singleProduct->purchase_price ?>"
                                                       name="PurchaseOrderDetails[temp_unit_price][]">
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <label>
                                                <input type="text" readonly class="form-control row-total" value="0"
                                                       name="PurchaseOrderDetails[temp_row_total][]">
                                            </label>
                                        </td>
                                        <!--<td>
                                            <button type="button" class="btn btn-danger dlt"><i
                                                        class="fa fa-trash-o"></i>
                                            </button>
                                        </td>-->
                                    </tr>
                                    <?php
                                }
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
                <div id="formResult" class="ajaxTargetDiv"></div>
                <div id="formResultError" class="ajaxTargetDivErr alert alert-danger  d-none" role="alert">
                </div>
            </div>
            <div class="col-md-12">
                <?php
                echo CHtml::ajaxSubmitButton('Update', CHtml::normalizeUrl(array('/commercial/purchaseOrder/update/id/' . $model->id, 'render' => true)), array(
                        'dataType' => 'json',
                        'type' => 'post',
                        'success' => 'function(data) {
                        $("#ajaxLoader").hide();  
                        if(data.status=="success"){
                            $("#formResult").fadeIn();
                            $("#formResult").html("Data saved successfully.");
                            toastr.success("Data saved successfully.");
                            //$("#bom-form")[0].reset();
                            $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                            //$("#list").empty();
                            //$("#soReportDialogBox").dialog("open");
                            //$("#AjFlashReportSo").html(data.soReportInfo).show();
                            $("#information-modal").modal("show");
                            $("#information-modal .modal-body").html(data.soReportInfo);
                        }else{
                            $("#formResultError").html(data.message).removeClass("d-none");
                            $.each(data, function(key, val) {
                                $("#bom-form #"+key+"_em_").html(""+val+"");                                                    
                                $("#bom-form #"+key+"_em_").show();
                            });
                        }       
                    }',
                        'beforeSend' => 'function(){  
                         $("#formResultError").addClass("d-none");

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
                            toastr.error("Please add material to list.");
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

            </div>
        </div>
    </div>
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
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
            let amount = safeNumber($("#PurchaseOrderDetails_amount").val());
            let qty = safeNumber($("#PurchaseOrderDetails_qty").val());
            amount = amount > 0 ? amount : 0;
            qty = qty > 0 ? qty : 0;

            $("#PurchaseOrderDetails_row_total").val((amount * qty).toFixed(2));
        });
        $("#PurchaseOrder_vat_percentage").on("keydown keyup", function () {
            calculateVat();
        });
    });


    $("#list").on("click", ".dlt", function () {
        $(this).closest("tr").remove();
        calculateTotal();
    });


    function calculateVat() {
        let total_amount = safeNumber($("#PurchaseOrder_total_amount").val());
        let vat_p = safeNumber($("#PurchaseOrder_vat_percentage").val());
        total_amount = total_amount > 0 ? total_amount : 0;
        vat_p = vat_p > 0 ? vat_p : 0;
        let vat = safeNumber(((vat_p / 100) * total_amount));
        let grand_total = safeNumber(total_amount + vat);
        $("#PurchaseOrder_vat_amount").val(vat.toFixed(2));
        $("#PurchaseOrder_grand_total").val(grand_total.toFixed(2));
    }

    function resetDynamicItem() {
        $("#PurchaseOrderDetails_model_id").val('');
        $("#model_id_text").val('');
        $("#PurchaseOrderDetails_product_sl_no").val('');
        $("#PurchaseOrderDetails_amount").val('');
        $("#PurchaseOrderDetails_row_total").val('');
        $("#PurchaseOrderDetails_qty").val('');
    }

    // on temp_qty change/keyup event calculate row total
    $(document).on("change keyup", ".temp_qty", function () {
        let qty = safeNumber($(this).val());
        let unit_price = safeNumber($(this).closest("tr").find(".temp_unit_price").val());
        let row_total = safeNumber(qty * unit_price);
        $(this).closest("tr").find(".row-total").val(row_total.toFixed(2));
        calculateTotal();
    });


    // on temp_unit_price change/keyup event calculate row total
    $(document).on("change keyup", ".temp_unit_price", function () {
        let unit_price = safeNumber($(this).val());
        let qty = safeNumber($(this).closest("tr").find(".temp_qty").val());
        let row_total = safeNumber(qty * unit_price);
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
                    let qty = safeNumber($(this).closest("tr").find(".temp_qty").val());
                    let row_total = safeNumber(qty * price);
                    $(this).closest("tr").find(".row-total").val(row_total.toFixed(2));
                }
            }
        });
    }


    function calculateTotal() {
        let item_count = $(".item").length;

        let total = 0;
        $('.row-total').each(function () {
            total += safeNumber($(this).val());
        });

        $("#PurchaseOrder_total_amount").val(total.toFixed(2)).change();
        $("#PurchaseOrder_item_count").val(item_count);
        calculateVat();
        tableSerial();
    }

    $("#PurchaseOrderDetails_product_sl_no").keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            return false;
        }
    });
    $("#PurchaseOrderDetails_amount").keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            return false;
        }
    });

    function tableSerial() {
        //  get the table tbody tr length
        var i = $('#list tbody tr').length;
        $('#list tbody tr').each(function () {
            $(this).find('.serial').text(i);
            i--;
        });
    }

    tableSerial();


    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
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

