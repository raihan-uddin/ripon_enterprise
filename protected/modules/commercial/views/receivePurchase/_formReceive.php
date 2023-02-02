<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Purchase', 'url' => array('admin')),
        array('name' => 'Receive', 'url' => array('adminPendingDelivery')),
        array('name' => 'Receive Order'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'receive-purchase-form',
));
?>


<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<div style="width: 100%;">
    <a class="btn btn-danger text-right mb-2" type="button"
       href="<?= Yii::app()->baseUrl . '/index.php/commercial/receivePurchase/adminPendingReceive' ?>"><i
                class="fa fa-arrow-left"></i> Back
    </a>
    <a class="btn btn-warning text-right mb-2" type="button"
       href="<?= Yii::app()->request->requestUri ?>"><i class="fa fa-refresh"></i>
        Reload
    </a>
    <a class="btn btn-success text-right mb-2" type="button"
       href="<?= Yii::app()->baseUrl . '/index.php/commercial/receivePurchase/admin' ?>"><i
                class="fa fa-arrow-right"></i>
        Receive Manage
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
                <?php echo $form->labelEx($data, 'po_no'); ?>
                <?php echo $form->textField($data, 'po_no', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($data, 'po_no'); ?></span>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <?php echo $form->labelEx($data, 'supplier_id'); ?>
                <input type="text" readonly value="<?= Suppliers::model()->nameOfThis($data->supplier_id) ?>"
                       class="form-control">
                <?php echo $form->hiddenField($data, 'supplier_id', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($data, 'supplier_id'); ?></span>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <?php echo $form->labelEx($data, 'date'); ?>
                <?php echo $form->textField($data, 'date', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($data, 'date'); ?></span>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
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
            <div class="col-sm-12 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'supplier_memo_no'); ?>
                <?php echo $form->textField($model, 'supplier_memo_no', array('maxlength' => 255, 'class' => 'form-control',)); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'supplier_memo_no'); ?></span>
            </div>

            <div class="col-sm-12 col-md-3 col-lg-3">
                <?php echo $form->labelEx($model, 'supplier_memo_date'); ?>
                <div class="input-group" id="supplier_memo_date" data-target-input="nearest">
                    <?php echo $form->textField($model, 'supplier_memo_date', array('maxlength' => 255, 'class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD',)); ?>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'supplier_memo_date'); ?></span>
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
                        <th style="text-align: center; vertical-align: middle;  width: 10%;">Rem. Rcv. Qty</th>
                        <th style="text-align: center; vertical-align: middle; width: 10%;">Rcv. Qty</th>
                    </tr>
                    </thead>
                    <tbody id="list">
                    <?php
                    $details = new CDbCriteria();
                    $details->select = "t.*, pm.model_name, pm.code, pm.unit_id";
                    $details->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
                    $details->addColumnCondition(['order_id' => $data->id]);
                    $detailsData = PurchaseOrderDetails::model()->findAll($details);
                    if ($detailsData) {
                        $i = 1;
                        foreach ($detailsData as $key => $dd) {
                            $order_qty = $dd->qty;
                            $delivery_qty = ReceivePurchaseDetails::model()->totalReceiveQtyOfThisModelByOrder($dd->model_id, $data->id);
                            $rem_qty = $order_qty - $delivery_qty;
                            ?>
                            <tr class="item">
                                <td style="vertical-align: middle; text-align: center;"><?= $i++ ?></td>
                                <td style="vertical-align: middle;">
                                    <?= $dd->model_name ?>
                                    <input type="hidden" class="form-control model_id" value="<?= $dd->model_id ?>"
                                           name="ReceivePurchaseDetails[temp_model_id][]">
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <?= $order_qty ?>
                                    <input type="hidden" class="form-control" value="<?= $order_qty ?>"
                                           name="ReceivePurchaseDetails[temp_order_qty][]">
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <?= $rem_qty ?>
                                    <input type="hidden" class="form-control rem-qty" value="<?= $rem_qty ?>"
                                           name="ReceivePurchaseDetails[temp_rem_qty][]">
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <input type="text" class="form-control receive_qty"
                                           name="ReceivePurchaseDetails[temp_rcv_qty][]">
                                    <input type="hidden" class="form-control unit-price" value="<?= $dd->unit_price ?>"
                                           name="ReceivePurchaseDetails[temp_unit_price][]">
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
    echo CHtml::ajaxSubmitButton('Receive', CHtml::normalizeUrl(array('/commercial/ReceivePurchase/receive', 'id' => $data->id, 'render' => true)), array(
        'dataType' => 'json',
        'type' => 'post',
        'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#receive-purchase-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#list").empty();
                        $("#soReportDialogBox").dialog("open");
                        $("#AjFlashReportSo").html(data.soReportInfo).show();
                    }else{
                        //$("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#receive-purchase-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#receive-purchase-form #"+key+"_em_").show();
                        });
                    }       
                }',
        'beforeSend' => 'function(){  
                    let count_item =  $(".item").length; 
                    let date = $("#ReceivePurchase_date").val();  
                    let status = 1;
                    $(".receive_qty").each(function () {
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
                        toastr.error("Please insert receive Qty.");
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
                document.getElementById('ReceivePurchase_date').value = date.format('YYYY-MM-DD');
            }
        });
        var picker2 = new Lightpick({
            field: document.getElementById('supplier_memo_date'),
            minDate: moment(),
            onSelect: function (date) {
                document.getElementById('ReceivePurchase_supplier_memo_date').value = date.format('YYYY-MM-DD');
            }
        });
    });

    function loadingDivDisplay(e) {
        $("#ajaxLoaderMR").show();
    }

    $(document).ready(function () {
        $(".receive_qty").keyup(function () {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));
            let del_qty = $(this).val();
            let rem_qty = parseFloat($(this).closest("tr").find('.rem-qty').val());
            rem_qty = isNaN(rem_qty) ? 0 : rem_qty;
            if (del_qty > rem_qty) {
                toastr.error("Rem. qty exceeded!");
                $this.val('');
                $(this).addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid");
            }
        });
    });

    function checkDeliveryQty() {
        let status = false;
        $(".receive_qty").each(function () {
            let val = parseFloat($(this).val());
            val = isNaN(val) ? 0 : 0;
            if (val > 0) {
                status = true;
            }
        });
        return status;
    }
</script>
<?php $this->endWidget(); ?>



<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'RECEIVE VOUCHER PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>


