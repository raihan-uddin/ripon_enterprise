<?php
$this->widget('application.components.BreadCrumb', [
        'crumbs' => [
                ['name' => 'Purchase', 'url' => ['admin']],
                ['name' => 'Payment', 'url' => ['admin']],
                ['name' => 'Create'],
        ],
]);

$form = $this->beginWidget('CActiveForm', [
        'id' => 'payment-receipt-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => ['validateOnSubmit' => true],
]);
?>

<div class="container-fluid">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <a class="btn btn-warning mr-2" href="<?= Yii::app()->request->requestUri ?>">
                <i class="fa fa-refresh"></i> Reload
            </a>
            <a class="btn btn-success" href="<?= Yii::app()->baseUrl ?>/index.php/accounting/paymentReceipt/admin">
                <i class="fa fa-home"></i> PR Manage
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title"><?= $model->isNewRecord ? 'Create Payment Receipt' : 'Update Payment Receipt' ?></h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool text-white" data-card-widget="collapse"><i
                            class="fa fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">

                <!-- Column 1 -->
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <?= $form->labelEx($model, 'date') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'date', [
                                    'class' => 'form-control datetimepicker-input',
                                    'placeholder' => 'YYYY-MM-DD',
                                    'value' => date('Y-m-d')
                            ]) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'date', ['class' => 'text-danger']) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->labelEx($model, 'supplier_id') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'supplier_name', [
                                    'class' => 'form-control',
                                    'readonly' => true,
                                    'value' => $model2->company_name
                            ]) ?>
                            <?= $form->hiddenField($model, 'supplier_id', [
                                    'class' => 'form-control',
                                    'readonly' => true,
                                    'value' => $model2->id
                            ]) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'supplier_id', ['class' => 'text-danger']) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->labelEx($model, 'remarks') ?>
                        <?= $form->textField($model, 'remarks', ['class' => 'form-control']) ?>
                        <?= $form->error($model, 'remarks', ['class' => 'text-danger']) ?>
                    </div>

                </div>

                <!-- Column 2 -->
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>Current Due Amount</label>
                        <div class="input-group">
                            <?php
                            // get all sell order amount
                            $criteria = new CDbCriteria();
                            $criteria->select = 'SUM(total_amount) AS total_amount';
                            $criteria->addColumnCondition(['supplier_id' => $model2->id]);
                            $purchaseOrder = PurchaseOrder::model()->findByAttributes([], $criteria);
                            $totalPurchaseAmount = $purchaseOrder ? $purchaseOrder->total_amount : 0;

                            $totalReturnAmount = 0;
                            //                            // get all return amount
                            //                            $criteria = new CDbCriteria();
                            //                            $criteria->select = 'SUM(return_amount) AS return_amount';
                            //                            $criteria->addColumnCondition(['supplier_id' => $model2->id]);
                            //                            $returnOrder = SellReturn::model()->findByAttributes([], $criteria);
                            //                            $totalReturnAmount = $returnOrder ? $returnOrder->return_amount : 0;

                            // get all money receipt amount
                            $criteria = new CDbCriteria();
                            $criteria->select = 'SUM(amount) + sum(discount) AS amount';
                            $criteria->addColumnCondition(['supplier_id' => $model2->id]);
                            $moneyReceipt = PaymentReceipt::model()->findByAttributes([], $criteria);
                            $totalMoneyReceipt = $moneyReceipt ? $moneyReceipt->amount : 0;


                            $currentDueAmount = $totalPurchaseAmount - $totalReturnAmount - $totalMoneyReceipt;
                            ?>
                            <input type="text" class="form-control" id="current_due_amt" name="current_due_amt"
                                   value="<?= number_format((float)$currentDueAmount, 2) ?>" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-balance-scale"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $form->labelEx($model, 'amount') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'amount', [
                                    'class' => 'form-control',
                            ]) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'amount', ['class' => 'text-danger']) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->labelEx($model, 'discount') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'discount', [
                                    'class' => 'form-control',
                            ]) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'discount', ['class' => 'text-danger']) ?>
                    </div>

                    <div class="form-group">
                        <label>Remaining Due Amount</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="remaining_due_amt" name="remaining_due_amt"
                                   disabled>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-balance-scale"></i></span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Column 3 -->
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <?= $form->labelEx($model, 'payment_type') ?>
                        <div class="input-group">
                            <?= $form->dropDownList($model, 'payment_type', CHtml::listData(MoneyReceipt::model()->paymentTypeFilter(), 'id', 'title'), [
                                    'prompt' => 'Select',
                                    'class' => 'form-control',
                                    'id' => 'payment_type_dropdown'
                            ]) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'payment_type', ['class' => 'text-danger']) ?>
                    </div>

                    <div class="form-group bank-group d-none" id="bank_section">
                        <?= $form->labelEx($model, 'bank_id') ?>
                        <div class="input-group">
                            <?= $form->dropDownList($model, 'bank_id',
                                    CHtml::listData(ComBank::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
                                    ['prompt' => 'Select', 'class' => 'form-control']) ?>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" onclick="addProdItem()">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <?= $form->error($model, 'bank_id', ['class' => 'text-danger']) ?>
                    </div>

                    <div class="form-group cheque-group d-none" id="cheque_no_section">
                        <?= $form->labelEx($model, 'cheque_no') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'cheque_no', ['class' => 'form-control']) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'cheque_no', ['class' => 'text-danger']) ?>
                    </div>

                    <div class="form-group cheque-group d-none" id="cheque_date_section">
                        <?= $form->labelEx($model, 'cheque_date') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'cheque_date', [
                                    'class' => 'form-control datetimepicker-input',
                                    'placeholder' => 'YYYY-MM-DD'
                            ]) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'cheque_date', ['class' => 'text-danger']) ?>
                    </div>

                </div>

            </div>
        </div>

        <div class="card-footer text-right">
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
                            $("#information-modal-money-receipt").modal("show");
                            $("#information-modal-money-receipt .modal-body").html(data.soReportInfo); 
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
                        let supplier_id = $("#PaymentReceipt_supplier_id").val();  
                        let grand_total = $("#PaymentReceipt_total_paid_amount").val();  
                        let payment_type = $("#PaymentReceipt_payment_type").val();  
                        let bank_id = $("#PaymentReceipt_bank_id").val();  
                        let cheque_no = $("#PaymentReceipt_cheque_no").val();  
                        let cheque_date = $("#PaymentReceipt_cheque_date").val();  
                        let row_amounts = parseFloat($("#PaymentReceipt_amount").val());
                        let row_discount = parseFloat($("#PaymentReceipt_discount").val());
                        if(isNaN(row_amounts)){
                            row_amounts = 0;
                        }
                        if(isNaN(row_discount)){
                            row_discount = 0;
                        }
                        let total_mr = row_amounts + row_discount;
                        if (total_mr == 0){
                            $("#PaymentReceipt_amount").addClass("is-invalid");
                            $("#PaymentReceipt_discount").addClass("is-invalid");
                        }
                        else {
                            $("#PaymentReceipt_amount").removeClass("is-invalid");
                            $("#PaymentReceipt_discount").removeClass("is-invalid");
                        }
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
                        }else if(supplier_id == ""){
                            toastr.error("Customer not found! Please insert valid SO!");
                            return false;
                        }else if(total_mr == 0){
                            toastr.error("Please insert MR Amount.");
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
</div>
<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'soReportDialogBox',
        'options' => array(
                'title' => 'PR PREVIEW',
                'autoOpen' => false,
                'modal' => true,
                'width' => 1030,
                'resizable' => false,
        ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>
<script>
    $(document).ready(function () {

        /* var picker = new Lightpick({
             field: document.getElementById('PaymentReceipt_date'),
             minDate: moment(),
             onSelect: function (date) {
                 document.getElementById('PaymentReceipt_date').value = date.format('YYYY-MM-DD');
             },

         });*/

        $('#payment_type_dropdown').change(function () {
            let paymentType = $(this).val();

            $('#bank_section').addClass('d-none');
            $('#cheque_no_section').addClass('d-none');
            $('#cheque_date_section').addClass('d-none');

            if (paymentType == '<?= MoneyReceipt::CASH ?>') {
                // Do nothing
            } else if (paymentType == '<?= MoneyReceipt::CHECK ?>') {
                $('#bank_section').removeClass('d-none');
                $('#cheque_no_section').removeClass('d-none');
                $('#cheque_date_section').removeClass('d-none');
            } else if (paymentType == '<?= MoneyReceipt::ONLINE ?>') {
                $('#bank_section').removeClass('d-none');
            }
        });

        // Allow only numbers and dot
        function sanitizeNumericInput(element) {
            let sanitized = element.value.replace(/[^0-9.]/g, '');

            // Allow only one dot
            let parts = sanitized.split('.');
            if (parts.length > 2) {
                sanitized = parts[0] + '.' + parts[1];
            }
            element.value = sanitized;
        }

        // on key up in amount and discount fields, calculate remaining due amount
        $('#PaymentReceipt_amount, #PaymentReceipt_discount').on('input', function () {
            sanitizeNumericInput(this);

            let amount = parseFloat($('#PaymentReceipt_amount').val()) || 0;
            let discount = parseFloat($('#PaymentReceipt_discount').val()) || 0;
            let currentDueAmt = parseFloat(<?= $currentDueAmount ?>) || 0;

            let remainingDueAmt = currentDueAmt - (amount + discount);
            $('#remaining_due_amt').val(remainingDueAmt.toFixed(2));
        });
    });

</script>