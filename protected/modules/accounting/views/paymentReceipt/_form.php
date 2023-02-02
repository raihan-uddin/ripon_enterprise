<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Purchase', 'url' => array('admin')),
        array('name' => 'Payment', 'url' => array('admin')),
        array('name' => 'Create'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'payment-receipt-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
)); ?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>
<div class="row">
    <div class="form-group col-xs-11 col-md-3 col-lg-3">
        <a class="btn  btn-warning" type="button" id="btnReload"
           href="<?= Yii::app()->request->requestUri ?>"><i class="fa fa-refresh"></i> Reload
        </a>
        <button class="btn  btn-danger" type="button" id="btnReset"><i class="fa fa-remove"></i> Reset
        </button>

        <a class="btn btn-success text-right" type="button"
           href="<?= Yii::app()->baseUrl . '/index.php/accounting/paymentReceipt/admin' ?>"><i class="fa fa-home"></i>
            PR Manage
        </a>
    </div>
</div>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Payment Receipt' : 'Update Payment Receipt'); ?></h3>

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
            <div class=" col-sm-12 col-md-3">
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

            <div class=" col-sm-12 col-md-3">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'payment_type', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                    <div class="col-sm-12 col-md-9">
                        <div class="input-group" id="customer_id" data-target-input="nearest">
                            <?php
                            echo $form->dropDownList($model, 'payment_type', CHtml::listData(PaymentReceipt::model()->paymentTypeFilter(), 'id', 'title'), array(
                                'prompt' => 'Select',
                                'class' => 'form-control',
                            ));
                            ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa fa-credit-card"></i></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'payment_type'); ?></span>
                </div>
            </div>

            <div class=" col-sm-12 col-md-3">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'supplier_id', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                    <div class="col-sm-12 col-md-9">
                        <div class="input-group" id="supplier_id" data-target-input="nearest">
                            <?php echo $form->textField($model, 'customer_name', array('class' => 'form-control', 'readonly' => true, 'value' => $model2->company_name)); ?>
                            <?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'form-control', 'readonly' => true, 'value' => $model2->id)); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'supplier_id'); ?></span>
                </div>
            </div>

            <div class=" col-sm-12 col-md-3">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'received_by', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                    <div class="col-sm-12 col-md-9">
                        <div class="input-group" id="customer_id" data-target-input="nearest">
                            <?php echo $form->textField($model, 'received_by', array('class' => 'form-control', 'readonly' => true, 'value' => Users::model()->nameOfThis(Yii::app()->user->id))); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'customer_id'); ?></span>
                </div>
            </div>

            <div class="form-group col-sm-12 col-md-3" style="">
                <?php echo $form->labelEx($model, 'remarks'); ?>
                <div class="input-group" data-target-input="nearest">
                    <?php echo $form->textField($model, 'remarks', array('class' => 'form-control',)); ?>
                    <div class="input-group-append ">
                        <div class="input-group-text">
                            <i class="fa fa-file-text"></i>
                        </div>
                    </div>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'remarks'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-2 bank online" style="display: none;">
                <?php echo $form->labelEx($model, 'bank_id'); ?>
                <div class="input-group" data-target-input="nearest">
                    <?php
                    echo $form->dropDownList(
                        $model, 'bank_id', CHtml::listData(ComBank::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                        'prompt' => 'Select',
                        'class' => 'form-control',
                    ));
                    ?>
                    <div class="input-group-append ">
                        <div class="input-group-text">
                            <?php
                            echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                array(
//                                    'class' => '',
                                    'onclick' => "{
                                            addProdItem(); 
                                            $('#dialogAddProdItem').dialog('open');
                                        }
                                    "));
                            ?>

                            <script type="text/javascript">
                                // here is the magic
                                function addProdItem() {
                                    <?php
                                    echo CHtml::ajax(array(
                                        'url' => array('/commercial/comBank/CreateBankFromOutSide'),
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
                                                $('#dialogAddProdItem div.divForForm').html(data.div);
                                                      // Here is the trick: on submit-> once again this function!
                                                $('#dialogAddProdItem div.divForForm form').submit(addProdItem);
                                            }
                                            else
                                            {
                                                $('#dialogAddProdItem div.divForForm').html(data.div);
                                                setTimeout(\"$('#dialogAddProdItem').dialog('close') \",1000);
                                                 $('#PaymentReceipt_bank_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'bank_id'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-2  bank " style="display: none;">
                <?php echo $form->labelEx($model, 'cheque_no'); ?>
                <div class="input-group" data-target-input="nearest">
                    <?php echo $form->textField($model, 'cheque_no', array('class' => 'form-control',)); ?>
                    <div class="input-group-append ">
                        <div class="input-group-text">
                            <i class="fa fa-credit-card"></i>
                        </div>
                    </div>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'cheque_no'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-2  bank " style="display: none;">
                <?php echo $form->labelEx($model, 'cheque_date'); ?>
                <div class="input-group" id="cheque_date" data-target-input="nearest">
                    <?php echo $form->textField($model, 'cheque_date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD',)); ?>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'cheque_date'); ?></span>
            </div>

            <div class="table table-responsive">
                <table class="table table-sm  table-hover table-bordered table-striped" id="list">
                    <thead>
                    <tr class="table-info">
                        <th class="text-center" style="width: 3%;">#</th>
                        <th class="text-center" style="width: 10%;">PO No</th>
                        <th class="text-center" style="width: 10%;">PO Date</th>
                        <th class="text-center" style="width: 10%;">PO Amount</th>
                        <th class="text-center" style="width: 10%;">Due Amount</th>
                        <th class="text-center" style="width: 10%;">Payment</th>
                        <th class="text-center" style="width: 10%;">Rem. Amount</th>
                        <th class="text-center" style="width: 3%;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <?php
                    $i = 1;
                    $invoice_total = $invoice_total_due = 0;
                    $criteriaInv = new CDbCriteria();
                    $criteriaInv->addColumnCondition(['is_paid' => PurchaseOrder::DUE]);
                    $dataInv = PurchaseOrder::model()->findAll($criteriaInv);
                    if ($dataInv) {
                        foreach ($dataInv as $inv) {
                            $invoice_amount = $inv->grand_total;
                            $paid_amount = PaymentReceipt::model()->totalPaidAmountOfThisOrder($inv->id);
                            $due = $invoice_amount - $paid_amount;
                            if ($due > 0) {
                                $invoice_total += $invoice_amount;
                                $invoice_total_due += $due;
                                ?>
                                <tr class="item">
                                    <td class="text-center sl-no" style="vertical-align: middle;"><?= $i++ ?></td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <?= $inv->po_no ?>
                                        <?php echo $form->hiddenField($model, 'order_id[]', array('class' => 'form-control', 'readonly' => true, 'value' => $inv->id)); ?>
                                    </td>
                                    <td class="text-center"
                                        style="vertical-align: middle;"><?= date('d.M.y', strtotime($inv->date)) ?></td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <?= number_format($invoice_amount, 2); ?>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <?= number_format($due, 2); ?>
                                        <?php echo $form->hiddenField($model, 'due_amount[]', array('class' => 'form-control due-amount', 'readonly' => true, 'value' => $due)); ?>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <?php echo $form->textField($model, 'amount[]', array('class' => 'form-control  text-right amount',)); ?>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="rem-span"></span>
                                        <?php echo $form->textField($model, 'rem_amount[]', array('class' => 'form-control text-right rem-amount', 'readonly' => true)); ?>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger dlt"><i
                                                    class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    } else {

                    }
                    ?>
                    <tfoot>
                    <tr>
                        <th colspan="3" class="text-right" style="vertical-align: middle">Calculation</th>
                        <th style="vertical-align: middle;">
                            <?php echo $form->textField($model, 'invoice_total[]', array('class' => 'form-control text-center', 'value' => $invoice_total, 'readonly' => true)); ?>
                        </th>
                        <th style="vertical-align: middle;">
                            <?php echo $form->textField($model, 'invoice_total_due[]', array('class' => 'form-control  text-center', 'value' => $invoice_total_due, 'readonly' => true)); ?>
                        </th>
                        <th style="vertical-align: middle;">
                            <?php echo $form->textField($model, 'total_paid_amount[]', array('class' => 'form-control  text-right', 'readonly' => true)); ?>
                        </th>
                        <th style="vertical-align: middle;">
                            <?php echo $form->textField($model, 'rem_total_amount[]', array('class' => 'form-control  text-right', 'readonly' => true)); ?>
                        </th>
                        <th style="vertical-align: middle;"></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <div class="card-footer">
        <?php
        echo CHtml::ajaxSubmitButton('Create', CHtml::normalizeUrl(array('/accounting/paymentReceipt/create', 'id' => $id, 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#payment-receipt-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#list tbody").empty();
                        $("#soReportDialogBox").dialog("open");
                        $("#AjFlashReportSo").html(data.soReportInfo).show();
                    }else{
                        $("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#payment-receipt-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#payment-receipt-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){  
                    let count_item =  $(".item").length; 
                    let date = $("#PaymentReceipt_date").val();  
                    let customer_id = $("#PaymentReceipt_customer_id").val();  
                    let grand_total = $("#PaymentReceipt_total_paid_amount").val();  
                    let payment_type = $("#PaymentReceipt_payment_type").val();  
                    let bank_id = $("#PaymentReceipt_bank_id").val();  
                    let cheque_no = $("#PaymentReceipt_cheque_no").val();  
                    let cheque_date = $("#PaymentReceipt_cheque_date").val();  
                    let row_amounts = 0;
                    $(".amount").each(function () {
                        var bill_qty_total = parseFloat($(this).val());
                        bill_qty_total = isNaN(bill_qty_total) ? 0 : bill_qty_total;
                        if(bill_qty_total <= 0){
                            $(this).addClass("is-invalid");
                        }else{
                            row_amounts++;
                            $(this).removeClass("is-invalid");
                        }
                    });
                  
                    if(date == ""){
                        toastr.error("Please insert date.");
                        return false;
                    }else if(payment_type == ""){
                        toastr.error("Please select payment type!");
                        return false;
                    }else if(payment_type == 2){
                        if(bank_id == ""){
                            toastr.error("Please select a bank!");
                            return false;
                        }else if(cheque_no == ""){
                            toastr.error("Please insert cheque no!");
                            return false;
                        }else if(cheque_date == ""){
                            toastr.error("Please insert cheque date!");
                            return false;
                        }
                    }else if(payment_type == 3){
                        if(bank_id == ""){
                            toastr.error("Please select a bank!");
                            return false;
                        }
                    }else if(customer_id == ""){
                        toastr.error("Customer not found! Please insert valid SO!");
                        return false;
                    }else if(count_item <= 0){
                        toastr.error("Due invoice not found!");
                        return false;
                    }else if(row_amounts == 0){
                        toastr.error("Please insert MR Amount.");
                        return false;
                    }else if(grand_total == "" || grand_total <= 0){
                        toastr.error("Total paid amount is 0");
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
            document.getElementById('PaymentReceipt_date').value = date.format('YYYY-MM-DD');
        }
    });
    var picker = new Lightpick({
        field: document.getElementById('cheque_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('PaymentReceipt_cheque_date').value = date.format('YYYY-MM-DD');
        }
    });

    $("#PaymentReceipt_payment_type").change(function () {
        let type = this.value;
        if (type == <?= PaymentReceipt::CASH?>) {
            $(".bank").hide();
        } else if (type == <?= PaymentReceipt::CHECK ?>) {
            $(".bank").show();
        } else if (type == <?= PaymentReceipt::ONLINE ?>) {
            $(".bank").hide();
            $(".online").show();
        } else {
            $(".bank").hide();
        }
        clearBankInfo();
    });

    $(document).on('keyup', ".amount", function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
        let due_amount = parseFloat($(this).closest('tr').find('.due-amount').val());
        let amount = parseFloat($(this).closest('tr').find('.amount').val());
        let _row_remaining = $(this).closest('tr').find('.rem-amount');
        due_amount = isNaN(due_amount) ? 0 : due_amount;
        amount = isNaN(amount) ? 0 : amount;
        let rem = due_amount - amount;
        if (rem >= 0) {
            _row_remaining.val(rem);
            $(this).removeClass("is-invalid");
        } else {
            this.value = '';
            _row_remaining.val('');
            $(this).addClass("is-invalid");
        }
        calculateTotal();
    });

    function calculateTotal() {
        let amount_total = 0;
        $(".amount").each(function () {
            var amount = parseFloat($(this).val());
            amount = isNaN(amount) ? 0 : amount;
            amount_total += amount;
        });
        $('#PaymentReceipt_total_paid_amount').val(amount_total);

        let rem_amount = 0;
        $(".rem-amount").each(function () {
            var rem_qty_total = parseFloat($(this).val());
            rem_qty_total = isNaN(rem_qty_total) ? 0 : rem_qty_total;
            rem_amount += rem_qty_total;
        });
        $('#PaymentReceipt_rem_total_amount').val(rem_amount);
    }

    $("#list").on("click", ".dlt", function () {
        $(this).closest("tr").remove();
        $("#list td.sl-no").each(function (index, element) {
            $(element).text(index + 1);
        });
        calculateTotal();
    });

    function clearBankInfo() {
        $("#PaymentReceipt_bank_id").val("");
        $("#PaymentReceipt_cheque_no").val("");
        $("#PaymentReceipt_cheque_date").val("");
    }
</script>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddProdItem',
    'options' => array(
        'title' => 'Add Bank',
        'autoOpen' => false,
        'modal' => true,
        'width' => 550,
        'resizable' => false,
    ),
));
?>

<div class="divForForm">
    <div class="ajaxLoaderFormLoad" style="display: none;"><img
                src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/></div>
</div>
<?php $this->endWidget(); ?>



<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'MR PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>


