<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Delivery', 'url' => array('adminPendingDelivery')),
        array('name' => 'Pending Delivery'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'delivery-form',
));
?>


<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<div style="width: 100%;">
    <a class="btn btn-danger text-right mb-2" type="button"
       href="<?= Yii::app()->baseUrl . '/index.php/sell/sellDelivery/adminPendingDelivery' ?>"><i
                class="fa fa-arrow-left"></i> Back
    </a>
    <a class="btn btn-warning text-right mb-2" type="button"
       href="<?= Yii::app()->request->requestUri ?>"><i class="fa fa-refresh"></i>
        Reload
    </a>
    <a class="btn btn-success text-right mb-2" type="button"
       href="<?= Yii::app()->baseUrl . '/index.php/sell/sellDelivery/admin' ?>"><i class="fa fa-arrow-right"></i>
        Delivery Manage
    </a>
</div>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Delivery' : 'Update Order: ' . $model->item_name); ?></h3>

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
            <div class="col-sm-12 col-md-4 col-lg-4">
                <?php echo $form->labelEx($data, 'so_no'); ?>
                <?php echo $form->textField($data, 'so_no', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($data, 'so_no'); ?></span>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <?php echo $form->labelEx($data, 'customer_id'); ?>
                <input type="text" readonly value="<?= Customers::model()->nameOfThis($data->customer_id) ?>"
                       class="form-control">
                <?php echo $form->hiddenField($data, 'customer_id', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($data, 'customer_id'); ?></span>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <?php echo $form->labelEx($data, 'date'); ?>
                <?php echo $form->textField($data, 'date', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($data, 'date'); ?></span>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <?php echo $form->labelEx($model, 'date'); ?>
                <div class="input-group" id="entry_date" data-target-input="nearest">
                    <?php echo $form->textField($model, 'date', array('maxlength' => 255, 'class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'date'); ?></span>
            </div>

            <div class="col-sm-12 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'remarks'); ?>
                <?php echo $form->textField($model, 'remarks', array('maxlength' => 255, 'class' => 'form-control',)); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'remarks'); ?></span>
            </div>

        </div>
        <div class="col-lg-12 mt-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm table-striped">
                    <thead class="table-info">
                    <tr>
                        <th style="text-align: center; vertical-align: middle;  width: 5%;">#</th>
                        <th style="text-align: center; vertical-align: middle;">Product</th>
                        <th style="text-align: center; vertical-align: middle;  width: 10%;">Order Qty</th>
                        <th style="text-align: center; vertical-align: middle;  width: 10%;">Rem. Del. Qty</th>
                        <th style="text-align: center; vertical-align: middle;  width: 10%; display: none;">Store</th>
                        <th style="text-align: center; vertical-align: middle;  width: 10%; display: none;">Location
                        </th>
                        <th style="text-align: center; vertical-align: middle; width: 10%;">Stock Qty</th>
                        <th style="text-align: center; vertical-align: middle; width: 10%;">Del. Qty</th>
                    </tr>
                    </thead>
                    <tbody id="list">
                    <?php
                    $details = new CDbCriteria();
                    $details->select = "t.*, pm.model_name, pm.code, pm.unit_id";
                    $details->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
                    $details->addColumnCondition(['sell_order_id' => $data->id, 'is_delivery_done' => SellOrderDetails::DELIVERY_NOT_DONE]);
                    $detailsData = SellOrderDetails::model()->findAll($details);
                    if ($detailsData) {
                        $i = 1;
                        foreach ($detailsData as $key => $dd) {
                            $order_qty = $dd->qty;
                            $current_stock = Inventory::model()->closingStock($dd->model_id);
                            $delivery_qty = SellDeliveryDetails::model()->totalDeliveryQtyOfThisModelByOrder($dd->model_id, $data->id);
                            $rem_qty = $order_qty - $delivery_qty;
                            ?>
                            <tr class="item">
                                <td style="vertical-align: middle; text-align: center;"><?= $i++ ?></td>
                                <td style="vertical-align: middle;">
                                    <?= $dd->model_name ?>
                                    <input type="hidden" class="form-control model_id" value="<?= $dd->model_id ?>"
                                           name="SellDeliveryDetails[temp_model_id][]">
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <?= $order_qty ?>
                                    <input type="hidden" class="form-control" value="<?= $order_qty ?>"
                                           name="SellDeliveryDetails[temp_order_qty][]">
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <?= $rem_qty ?>
                                    <input type="hidden" class="form-control rem-qty" value="<?= $rem_qty ?>"
                                           name="SellDeliveryDetails[temp_rem_qty][]">
                                </td>
                                <td class="text-center" style="vertical-align: middle; display: none;">
                                    <?php
                                    echo $form->dropDownList(
                                        $model, 'store_id', CHtml::listData(Stores::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                        'prompt' => 'Select',
                                        'name' => 'SellDeliveryDetails[temp_store_id][]',
                                        'class' => 'form-control store',
                                        'id' => 'SellDelivery_store_id_' . $dd->id,
                                    ));
                                    ?>
                                </td>
                                <td class="text-center" style="vertical-align: middle; display: none;">
                                    <?php echo $form->dropDownList(
                                        $model, 'location_id', CHtml::listData(Location::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                        'prompt' => 'Select',
                                        'name' => 'SellDeliveryDetails[temp_location_id][]',
                                        'class' => 'form-control location',
                                        'id' => 'SellDelivery_location_id_' . $dd->id,
                                    ));
                                    ?>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <span class="stock-html"><?= $current_stock ?></span>
                                    <input type="hidden" class="form-control stock" value="<?= $current_stock ?>"
                                           name="SellDeliveryDetails[temp_stock_qty][]">
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <input type="text" class="form-control delivery-qty"
                                           name="SellDeliveryDetails[temp_del_qty][]">
                                    <input type="hidden" class="form-control unit-price" value="<?= $dd->amount ?>"
                                           name="SellDeliveryDetails[temp_unit_price][]">
                                </td>
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


<div class="card-footer">
    <?php
    echo CHtml::ajaxSubmitButton('Deliver', CHtml::normalizeUrl(array('/sell/sellDelivery/delivery', 'id' => $data->id, 'render' => true)), array(
        'dataType' => 'json',
        'type' => 'post',
        'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#delivery-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#list").empty();
                        $("#soReportDialogBox").dialog("open");
                        $("#AjFlashReportSo").html(data.soReportInfo).show();
                    }else{
                        //$("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#delivery-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#delivery-form #"+key+"_em_").show();
                        });
                    }       
                }',
        'beforeSend' => 'function(){  
                    let count_item =  $(".item").length; 
                    let date = $("#SellDelivery_date").val();  
                    let status = 1;
                    $(".delivery-qty").each(function () {
                        let val = parseFloat($(this).val());
                        val = isNaN(val) ? 0 : val;
                        if (val > 0){
                            status = 2;
                        }
                    });
                    if(date == ""){
                        toastr.error("Please insert date.");
                        return false;
                    }else if(count_item <= 0){
                        toastr.error("Please add materials to list.");
                        return false;
                    }else if(status == 1){
                        toastr.error("Please insert delivery Qty.");
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

<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var picker = new Lightpick({
            field: document.getElementById('entry_date'),
            minDate: moment(),
            onSelect: function (date) {
                document.getElementById('SellDelivery_date').value = date.format('YYYY-MM-DD');
            }
        });
    });

    function loadingDivDisplay(e) {
        $("#ajaxLoaderMR").show();
    }

    $(document).ready(function () {
        $(".delivery-qty").keyup(function () {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));
            let del_qty = $(this).val();
            let rem_qty = parseFloat($(this).closest("tr").find('.rem-qty').val());
            let stock = parseFloat($(this).closest("tr").find('.stock').val());
            console.log(`del_qty: ${del_qty}, rem_qty: ${rem_qty}, stock: ${stock},`);
            rem_qty = isNaN(rem_qty) ? 0 : rem_qty;
            stock = isNaN(stock) ? 0 : stock;
            if (del_qty > rem_qty) {
                toastr.error("Rem. qty exceeded!");
                $this.val('');
            } else if (del_qty > stock) {
                toastr.error("Stock qty exceeded!");
                $this.val('');
            } else {
                console.log(`del_qty: ${del_qty}, rem_qty: ${rem_qty}, stock: ${stock},`);
            }
        });
    });

    function checkDeliveryQty() {
        let status = false;
        $(".delivery-qty").each(function () {
            let val = parseFloat($(this).val());
            val = isNaN(val) ? 0 : 0;
            if (val > 0) {
                status = true;
            }
        });
        return status;
    }

    $(".store").change(function () {
        var store_id = this.value;
        var model_id = $(this).closest('tr').find('.model_id').val();
        var location_id = $(this).closest('tr').find('.location').val();
        var _location = $(this).closest('tr').find('.location');
        var _stock_html = $(this).closest('tr').find('.stock-html');
        var _stock = $(this).closest('tr').find('.stock');
        var _delivery_qty = $(this).closest('tr').find('.delivery-qty');
        $.post('<?php echo Yii::app()->baseUrl ?>/index.php/inventory/location/subCatOfThisCat', {
            store_id: store_id,
        }, function (response) {
            var data = JSON.parse(response);
            console.log(data.subCatList);
            _location.html(`'${data.subCatList}'`);
        }).fail(function (response) {
            _location.html('');
            alert('Error: ' + response.responseText);
        });

        $.post('<?php echo Yii::app()->baseUrl ?>/index.php/inventory/inventory/Jquery_getStockQty', {
            model_id: model_id,
            store_id: store_id,
            location_id: location_id,
        }, function (response) {
            console.log('stock:' + response);
            _stock_html.html(response);
            _stock.val(response);
            _delivery_qty.val('');
        }).fail(function (response) {
            _stock_html.html(0);
            _stock.val(0);
            _delivery_qty.val('');
            alert('Error: ' + response.responseText);
        });
    });

    $(".location").change(function () {
        var store_id = $(this).closest('tr').find('.store').val();
        var model_id = $(this).closest('tr').find('.model_id').val();
        var location_id = $(this).closest('tr').find('.location').val();
        var _stock_html = $(this).closest('tr').find('.stock-html');
        var _stock = $(this).closest('tr').find('.stock');
        var _delivery_qty = $(this).closest('tr').find('.delivery-qty');

        $.post('<?php echo Yii::app()->baseUrl ?>/index.php/inventory/inventory/Jquery_getStockQty', {
            model_id: model_id,
            store_id: store_id,
            location_id: location_id,
        }, function (response) {
            console.log('stock:' + response);
            _stock_html.html(response);
            _stock.val(response);
            _delivery_qty.val('');
        }).fail(function (response) {
            _stock_html.html(0);
            _stock.val(0);
            _delivery_qty.val('');
            alert('Error: ' + response.responseText);
        });
    });
</script>
<?php $this->endWidget(); ?>



<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'DELIVERY VOUCHER PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>


