<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Collection', 'url' => array('admin')),
        array('name' => 'Create'),
    ),
));

// Current due calculation
$criteria = new CDbCriteria();
$criteria->select = 'SUM(grand_total) AS grand_total';
$criteria->addColumnCondition(array('customer_id' => $model2->id));
$sellOrder = SellOrder::model()->findByAttributes(array(), $criteria);
$totalSellAmount = $sellOrder ? (float)$sellOrder->grand_total : 0;

$criteria = new CDbCriteria();
$criteria->select = 'SUM(return_amount) AS return_amount';
$criteria->addColumnCondition(array('customer_id' => $model2->id));
$returnOrder = SellReturn::model()->findByAttributes(array(), $criteria);
$totalReturnAmount = $returnOrder ? (float)$returnOrder->return_amount : 0;

$criteria = new CDbCriteria();
$criteria->select = 'SUM(amount) + SUM(discount) AS amount';
$criteria->addColumnCondition(array('customer_id' => $model2->id));
$moneyReceipt = MoneyReceipt::model()->findByAttributes(array(), $criteria);
$totalMoneyReceipt = $moneyReceipt ? (float)$moneyReceipt->amount : 0;

$currentDueAmount = $totalSellAmount - $totalReturnAmount - $totalMoneyReceipt;

// MR number preview
$nextSlNo   = MoneyReceipt::maxSlNo();
$previewMrNo = 'MR' . date('y') . date('m') . str_pad($nextSlNo, 5, '0', STR_PAD_LEFT);

// Last payment for this customer
$lpCriteria = new CDbCriteria();
$lpCriteria->select = 'SUM(amount) AS amount, date, mr_no';
$lpCriteria->addColumnCondition(array('customer_id' => $model2->id));
$lpCriteria->group = 'mr_no, date';
$lpCriteria->order = 'date DESC, id DESC';
$lpCriteria->limit  = 1;
$lastPayment = MoneyReceipt::model()->find($lpCriteria);

$form = $this->beginWidget('CActiveForm', array(
    'id'                     => 'money-receipt-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true),
));
?>

<div class="container-fluid">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <a class="btn btn-warning mr-2" href="<?= Yii::app()->request->requestUri ?>">
                <i class="fas fa-refresh"></i> Reload
            </a>
            <a class="btn btn-success" href="<?= Yii::app()->baseUrl ?>/index.php/accounting/moneyReceipt/admin">
                <i class="fas fa-home"></i> MR Manage
            </a>
        </div>
        <small class="text-muted">
            <i class="fas fa-keyboard-o"></i> Tip: <kbd>Ctrl</kbd>+<kbd>Enter</kbd> to save
        </small>
    </div>

    <div class="card shadow-sm mb-4" id="mr_create_card">

        <!-- Card header -->
        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0">
                <span id="header_payment_icon" class="mr-2"><i class="fas fa-money-bill"></i></span>
                Create Money Receipt
                <span id="header_mr_badge"
                      title="Click to copy MR#"
                      class="badge badge-light ml-2"
                      style="font-family:monospace; font-size:12px; cursor:pointer;"
                      data-bs-toggle="tooltip" data-placement="right">
                    <?= CHtml::encode($previewMrNo) ?>
                </span>
            </h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">

            <!-- Customer financial summary strip -->
            <div class="row mb-4">
                <div class="col-md-4 mb-2">
                    <div class="d-flex align-items-center p-3 rounded"
                         style="background:#e8f4fd; border-left:4px solid #3490dc;">
                        <i class="fas fa-shopping-cart fa-2x mr-3" style="color:#3490dc;"></i>
                        <div>
                            <div style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px;">Total Billed</div>
                            <div style="font-size:20px; font-weight:700; color:#1a3a5c;"><?= number_format($totalSellAmount, 2) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="d-flex align-items-center p-3 rounded"
                         style="background:#e8f8e8; border-left:4px solid #28a745;">
                        <i class="fas fa-check-circle fa-2x mr-3" style="color:#28a745;"></i>
                        <div>
                            <div style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px;">Total Paid</div>
                            <div style="font-size:20px; font-weight:700; color:#155724;"><?= number_format($totalMoneyReceipt, 2) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="d-flex align-items-center p-3 rounded"
                         style="background:<?= $currentDueAmount > 0 ? '#fff3cd' : '#e8f8e8' ?>;
                                border-left:4px solid <?= $currentDueAmount > 0 ? '#ffc107' : '#28a745' ?>;">
                        <i class="fas fa-<?= $currentDueAmount > 0 ? 'exclamation-circle' : 'check-circle' ?> fa-2x mr-3"
                           style="color:<?= $currentDueAmount > 0 ? '#e65100' : '#28a745' ?>;"></i>
                        <div>
                            <div style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px;">Outstanding</div>
                            <div style="font-size:20px; font-weight:700;
                                        color:<?= $currentDueAmount > 0 ? '#e65100' : '#28a745' ?>;">
                                <?= number_format($currentDueAmount, 2) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- ── Column 1: Date / Customer / Remarks ─────────────────── -->
                <div class="col-md-3 mb-3">

                    <div class="mb-3">
                        <?= $form->labelEx($model, 'date') ?>
                        <div class="input-group" id="entry_date">
                            <?= $form->textField($model, 'date', array(
                                'class'       => 'form-control datetimepicker-input',
                                'placeholder' => 'YYYY-MM-DD',
                                'value'       => date('Y-m-d'),
                                'id'          => 'MoneyReceipt_date',
                            )) ?>
                            
                                <span class="input-group-text" id="date_icon">
                                    <i class="fas fa-check-circle text-success"></i>
                                </span>
                            </div>
                        </div>
                        <?= $form->error($model, 'date', array('class' => 'text-danger')) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->labelEx($model, 'customer_id') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'customer_name', array(
                                'class'    => 'form-control',
                                'readonly' => true,
                                'value'    => $model2->company_name,
                            )) ?>
                            <?= $form->hiddenField($model, 'customer_id', array('value' => $model2->id)) ?>
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'customer_id', array('class' => 'text-danger')) ?>
                        <?php if ($lastPayment): ?>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-history"></i>
                            Last paid <strong><?= number_format((float)$lastPayment->amount, 2) ?></strong>
                            on <strong><?= date('d M Y', strtotime($lastPayment->date)) ?></strong>
                            <span class="badge bg-secondary" style="font-family:monospace; font-size:10px;">
                                <?= CHtml::encode($lastPayment->mr_no) ?>
                            </span>
                        </small>
                        <?php else: ?>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle"></i> No previous payments found.
                        </small>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->labelEx($model, 'remarks') ?>
                        <?= $form->textArea($model, 'remarks', array(
                            'class'       => 'form-control',
                            'rows'        => 4,
                            'placeholder' => 'Optional remarks...',
                            'id'          => 'MoneyReceipt_remarks',
                            'maxlength'   => 200,
                        )) ?>
                        <div class="d-flex justify-content-end">
                            <small id="remarks_counter" class="text-muted">0 / 200</small>
                        </div>
                        <?= $form->error($model, 'remarks', array('class' => 'text-danger')) ?>
                    </div>

                </div>

                <!-- ── Column 2: Amounts + quick-fill + progress ───────────── -->
                <div class="col-md-3 mb-3">

                    <div class="mb-3">
                        <label>Current Due</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-weight-bold"
                                   id="current_due_amt"
                                   value="<?= number_format((float)$currentDueAmount, 2) ?>" readonly>
                                <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick-fill -->
                    <div class="mb-3">
                        <label style="font-size:11px; color:#888; text-transform:uppercase; letter-spacing:1px;">
                            Quick Fill
                        </label>
                        <div class="btn-group btn-group-sm w-100">
                            <button type="button" class="btn btn-outline-primary" onclick="fillAmount(100)">
                                <i class="fas fa-check-circle"></i> Full Due
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="fillAmount(50)">50%</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="fillAmount(25)">25%</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $form->labelEx($model, 'amount') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'amount', array(
                                'class'       => 'form-control',
                                'placeholder' => '0.00',
                                'id'          => 'MoneyReceipt_amount',
                            )) ?>
                            
                                <span class="input-group-text" id="amount_icon">
                                    <i class="fas fa-money-bill"></i>
                                </span>
                            </div>
                        </div>
                        <small id="amount_in_words" class="text-muted font-italic" style="font-size:11px;"></small>
                        <?= $form->error($model, 'amount', array('class' => 'text-danger')) ?>
                    </div>

                    <!-- Payment progress bar -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between" style="font-size:11px; color:#888; margin-bottom:3px;">
                            <span>Payment coverage</span>
                            <span id="progress_pct">0%</span>
                        </div>
                        <div class="progress" style="height:8px; border-radius:4px;">
                            <div id="payment_progress" class="progress-bar bg-danger"
                                 role="progressbar" style="width:0%; transition:width 0.3s ease;"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $form->labelEx($model, 'discount') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'discount', array(
                                'class'       => 'form-control',
                                'placeholder' => '0.00',
                                'id'          => 'MoneyReceipt_discount',
                            )) ?>
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'discount', array('class' => 'text-danger')) ?>
                    </div>

                    <div class="mb-3">
                        <label>Remaining Due</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-weight-bold"
                                   id="remaining_due_amt"
                                   value="<?= number_format((float)$currentDueAmount, 2) ?>" disabled>
                            
                                <span class="input-group-text" id="remaining_icon">
                                    <i class="fas fa-balance-scale"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ── Column 3: Payment type + conditional bank/cheque ──── -->
                <div class="col-md-3 mb-3">

                    <div class="mb-3">
                        <?= $form->labelEx($model, 'payment_type') ?>
                        <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-money-bill" id="payment_type_icon"></i>
                                </span>
                            </div>
                            <?= $form->dropDownList($model, 'payment_type',
                                CHtml::listData(MoneyReceipt::model()->paymentTypeFilter(), 'id', 'title'),
                                array('prompt' => 'Select', 'class' => 'form-control', 'id' => 'payment_type_dropdown')
                            ) ?>
                            
                                <span class="input-group-text" id="payment_valid_icon">
                                    <i class="fas fa-circle-o text-muted"></i>
                                </span>
                            </div>
                        </div>
                        <?= $form->error($model, 'payment_type', array('class' => 'text-danger')) ?>
                    </div>

                    <div class="mb-3 d-none" id="bank_section">
                        <?= $form->labelEx($model, 'bank_id') ?>
                        <div class="input-group">
                            <?= $form->dropDownList($model, 'bank_id',
                                CHtml::listData(CrmBank::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
                                array('prompt' => 'Select Bank', 'class' => 'form-control')
                            ) ?>
                                <button type="button" class="btn btn-outline-secondary"
                                        onclick="addBankDialog()" title="Add Bank">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <?= $form->error($model, 'bank_id', array('class' => 'text-danger')) ?>
                    </div>

                    <div class="mb-3 d-none" id="cheque_no_section">
                        <?= $form->labelEx($model, 'cheque_no') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'cheque_no', array(
                                'class'       => 'form-control',
                                'placeholder' => 'Cheque number',
                            )) ?>
                                <span class="input-group-text"><i class="fas fa-credit-card-alt"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'cheque_no', array('class' => 'text-danger')) ?>
                    </div>

                    <div class="mb-3 d-none" id="cheque_date_section">
                        <?= $form->labelEx($model, 'cheque_date') ?>
                        <div class="input-group" id="cheque_date_picker">
                            <?= $form->textField($model, 'cheque_date', array(
                                'class'       => 'form-control datetimepicker-input',
                                'placeholder' => 'YYYY-MM-DD',
                            )) ?>
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'cheque_date', array('class' => 'text-danger')) ?>
                    </div>

                </div>

                <!-- ── Column 4: Live receipt preview ─────────────────────── -->
                <div class="col-md-3 mb-3">
                    <label style="font-size:11px; color:#888; text-transform:uppercase; letter-spacing:1px;">
                        <i class="fas fa-eye"></i> Live Preview
                    </label>
                    <div id="receipt_preview" class="rounded p-3"
                         style="background:#fffdf0; border:1px dashed #ccc; font-size:12px; min-height:300px;">

                        <!-- Receipt header -->
                        <div style="text-align:center; border-bottom:1px dashed #bbb; padding-bottom:8px; margin-bottom:8px;">
                            <div style="font-weight:700; font-size:13px; letter-spacing:1px;">
                                <?= strtoupper(Yii::app()->params['company']['name']) ?>
                            </div>
                            <div style="color:#888; font-size:10px; text-transform:uppercase; letter-spacing:2px;">
                                Money Receipt
                            </div>
                            <div id="prev_mr_no"
                                 style="font-family:monospace; font-size:13px; font-weight:700;
                                        background:#e8f4fd; display:inline-block;
                                        padding:2px 10px; border-radius:10px; margin-top:4px;">
                                <?= CHtml::encode($previewMrNo) ?>
                            </div>
                        </div>

                        <!-- Receipt fields -->
                        <table style="width:100%; border-collapse:collapse; font-size:11px;">
                            <tr>
                                <td style="color:#888; padding:3px 0; width:40%;">Customer</td>
                                <td id="prev_customer" style="font-weight:600; padding:3px 0;">
                                    <?= CHtml::encode($model2->company_name) ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="color:#888; padding:3px 0;">Date</td>
                                <td id="prev_date" style="padding:3px 0;"><?= date('d M Y') ?></td>
                            </tr>
                            <tr>
                                <td style="color:#888; padding:3px 0;">Payment</td>
                                <td id="prev_payment_type" style="padding:3px 0;">—</td>
                            </tr>
                        </table>

                        <!-- Receipt amounts -->
                        <div style="border-top:1px dashed #bbb; margin-top:10px; padding-top:8px;">
                            <div style="display:flex; justify-content:space-between; padding:2px 0; font-size:11px;">
                                <span style="color:#888;">Amount</span>
                                <span id="prev_amount" style="font-weight:600;">0.00</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; padding:2px 0; font-size:11px;">
                                <span style="color:#888;">Discount</span>
                                <span id="prev_discount">0.00</span>
                            </div>
                            <div style="display:flex; justify-content:space-between;
                                        padding:6px 0 2px; border-top:1px solid #333;
                                        margin-top:6px; font-weight:700; font-size:14px;">
                                <span>Total</span>
                                <span id="prev_total">0.00</span>
                            </div>
                            <div id="prev_amount_words"
                                 style="font-size:10px; color:#888; font-style:italic;
                                        margin-top:4px; line-height:1.4;"></div>
                        </div>

                        <!-- Remarks -->
                        <div id="prev_remarks_wrap" style="margin-top:8px; display:none;">
                            <div style="color:#888; font-size:10px; font-style:italic;"
                                 id="prev_remarks"></div>
                        </div>

                    </div>
                </div>

            </div><!-- /.row -->
        </div><!-- /.card-body -->

        <div class="card-footer text-end">
            <?php echo CHtml::ajaxSubmitButton('Save Receipt',
                CHtml::normalizeUrl(array('/accounting/moneyReceipt/create', 'id' => $id, 'render' => true)),
                array(
                    'dataType'   => 'json',
                    'type'       => 'post',
                    'beforeSend' => 'function(){
                        var date         = $("#MoneyReceipt_date").val();
                        var customer_id  = $("#MoneyReceipt_customer_id").val();
                        var payment_type = $("#payment_type_dropdown").val();
                        var bank_id      = $("#MoneyReceipt_bank_id").val();
                        var cheque_no    = $("#MoneyReceipt_cheque_no").val();
                        var cheque_date  = $("#MoneyReceipt_cheque_date").val();
                        var amount       = parseFloat($("#MoneyReceipt_amount").val()) || 0;
                        var discount     = parseFloat($("#MoneyReceipt_discount").val()) || 0;
                        if(!date){ toastr.error("Please insert date."); return false; }
                        if(!payment_type){ toastr.error("Please select payment type!"); return false; }
                        if(payment_type == "<?= MoneyReceipt::CHECK ?>"){
                            if(!bank_id){ toastr.error("Please select a bank!"); return false; }
                            if(!cheque_no){ toastr.error("Please insert cheque no!"); return false; }
                            if(!cheque_date){ toastr.error("Please insert cheque date!"); return false; }
                        } else if(payment_type == "<?= MoneyReceipt::ONLINE ?>"){
                            if(!bank_id){ toastr.error("Please select a bank!"); return false; }
                        }
                        if(!customer_id){ toastr.error("Customer not found!"); return false; }
                        if(amount + discount === 0){ toastr.error("Please insert an amount."); return false; }
                        $("#overlay").fadeIn(300);
                    }',
                    'success'    => 'function(data){
                        $("#overlay").fadeOut(300);
                        if(data.status === "success"){
                            clearDraft();
                            formDirty = false;
                            launchConfetti();
                            toastr.success("Money receipt saved successfully.");
                            $("#money-receipt-form")[0].reset();
                            resetAfterSave();
                            bootstrap.Modal.getOrCreateInstance(document.getElementById("information-modal-money-receipt")).show();
                            $("#information-modal-money-receipt .modal-body").html(data.soReportInfo);
                        } else {
                            $.each(data, function(key, val){
                                $("#money-receipt-form #" + key + "_em_").html(val).show();
                            });
                        }
                    }',
                    'error'      => 'function(xhr){
                        $("#overlay").fadeOut(300);
                        toastr.error(xhr.responseText);
                    }',
                    'complete'   => 'function(){ $("#overlay").fadeOut(300); }',
                ),
                array('class' => 'btn btn-primary btn-md', 'id' => 'btn_save_receipt')
            ); ?>
            <a href="<?= Yii::app()->baseUrl ?>/index.php/accounting/moneyReceipt/admin"
               class="btn btn-secondary ml-2">Cancel</a>
        </div>
    </div>
</div>

<div id="overlay">
    <div class="cv-spinner"><span class="spinner"></span></div>
</div>

<!-- Voucher preview modal -->
<div class="modal fade" id="information-modal-money-receipt" tabindex="-1"
     data-bs-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Money Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info"
                        onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Bank dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'      => 'dialogAddBank',
    'options' => array('title' => 'Add Bank', 'autoOpen' => false, 'modal' => true, 'width' => 550, 'resizable' => false),
)); ?>
<div class="divForForm">
    <div class="ajaxLoaderFormLoad" style="display:none;">
        <img src="<?= Yii::app()->theme->baseUrl ?>/images/ajax-loader.gif"/>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->endWidget(); // CActiveForm ?>

<script>
// ── Constants ─────────────────────────────────────────────────────────────────
var CASH   = '<?= MoneyReceipt::CASH ?>';
var CHECK  = '<?= MoneyReceipt::CHECK ?>';
var ONLINE = '<?= MoneyReceipt::ONLINE ?>';
var currentDue  = <?= (float)$currentDueAmount ?>;
var DRAFT_KEY   = 'mr_draft_customer_<?= (int)$model2->id ?>';
var formDirty   = false;

var paymentLabels = {};
paymentLabels[CASH]   = 'Cash';
paymentLabels[CHECK]  = 'Cheque';
paymentLabels[ONLINE] = 'Online Transfer';

var paymentIcons = {};
paymentIcons[CASH]   = 'fa-money-bill';
paymentIcons[CHECK]  = 'fa-file-lines';
paymentIcons[ONLINE] = 'fa-university';

// ── Amount in words (Bangladeshi style) ───────────────────────────────────────
function numberToWords(num) {
    var ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
                'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
                'Seventeen', 'Eighteen', 'Nineteen'];
    var tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty',
                'Sixty', 'Seventy', 'Eighty', 'Ninety'];
    function convert(n) {
        n = Math.floor(n);
        if (n === 0)       return '';
        if (n < 20)        return ones[n];
        if (n < 100)       return tens[Math.floor(n/10)] + (n%10 ? ' '+ones[n%10] : '');
        if (n < 1000)      return ones[Math.floor(n/100)] + ' Hundred' + (n%100 ? ' '+convert(n%100) : '');
        if (n < 100000)    return convert(Math.floor(n/1000)) + ' Thousand' + (n%1000 ? ' '+convert(n%1000) : '');
        if (n < 10000000)  return convert(Math.floor(n/100000)) + ' Lac' + (n%100000 ? ' '+convert(n%100000) : '');
        return convert(Math.floor(n/10000000)) + ' Crore' + (n%10000000 ? ' '+convert(n%10000000) : '');
    }
    if (!num || num <= 0) return '';
    var intPart = Math.floor(num);
    var decPart = Math.round((num - intPart) * 100);
    var result = convert(intPart) + ' Taka';
    if (decPart > 0) result += ' and ' + convert(decPart) + ' Paisa';
    return result + ' Only';
}

// ── Draft: save / restore / clear ────────────────────────────────────────────
function saveDraft() {
    var d = {
        date:          $('#MoneyReceipt_date').val(),
        customer_name: <?= json_encode($model2->company_name) ?>,
        amount:        $('#MoneyReceipt_amount').val(),
        discount:      $('#MoneyReceipt_discount').val(),
        payment_type:  $('#payment_type_dropdown').val(),
        bank_id:       $('#MoneyReceipt_bank_id').val(),
        cheque_no:     $('#MoneyReceipt_cheque_no').val(),
        cheque_date:   $('#MoneyReceipt_cheque_date').val(),
        remarks:       $('#MoneyReceipt_remarks').val(),
        saved_at:      new Date().toISOString(),
    };
    localStorage.setItem(DRAFT_KEY, JSON.stringify(d));
}

function restoreDraft() {
    var raw = localStorage.getItem(DRAFT_KEY);
    if (!raw) return;
    try {
        var d = JSON.parse(raw);
        if (!d.amount && !d.discount && !d.remarks) return;
        if (d.date)         $('#MoneyReceipt_date').val(d.date);
        if (d.amount)       $('#MoneyReceipt_amount').val(d.amount);
        if (d.discount)     $('#MoneyReceipt_discount').val(d.discount);
        if (d.remarks)      { $('#MoneyReceipt_remarks').val(d.remarks); updateRemarksCounter(); }
        if (d.payment_type) {
            $('#payment_type_dropdown').val(d.payment_type).trigger('change');
            setTimeout(function(){
                if (d.bank_id)     $('#MoneyReceipt_bank_id').val(d.bank_id);
                if (d.cheque_no)   $('#MoneyReceipt_cheque_no').val(d.cheque_no);
                if (d.cheque_date) $('#MoneyReceipt_cheque_date').val(d.cheque_date);
            }, 100);
        }
        $('#MoneyReceipt_amount').trigger('input');
        toastr.info(
            'Draft restored from your last session. <button class="btn btn-xs btn-light ml-2" onclick="clearDraft();location.reload();">Discard</button>',
            '', {timeOut: 8000, closeButton: true, enableHtml: true}
        );
    } catch(e) { localStorage.removeItem(DRAFT_KEY); }
}

function clearDraft() {
    localStorage.removeItem(DRAFT_KEY);
}

// ── Unsaved changes warning ───────────────────────────────────────────────────
window.addEventListener('beforeunload', function(e) {
    if (formDirty) { e.preventDefault(); e.returnValue = ''; }
});

// ── Confetti ─────────────────────────────────────────────────────────────────
function launchConfetti() {
    var canvas = document.createElement('canvas');
    canvas.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:99999;';
    document.body.appendChild(canvas);
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
    var ctx    = canvas.getContext('2d');
    var colors = ['#007bff','#28a745','#ffc107','#dc3545','#17a2b8','#6f42c1','#fd7e14'];
    var pieces = [];
    for (var i = 0; i < 160; i++) {
        pieces.push({
            x:     Math.random() * canvas.width,
            y:     -Math.random() * canvas.height * 0.5,
            r:     Math.random() * 7 + 4,
            color: colors[Math.floor(Math.random() * colors.length)],
            speed: Math.random() * 3 + 2,
            angle: Math.random() * Math.PI * 2,
            spin:  (Math.random() - 0.5) * 0.15,
            drift: (Math.random() - 0.5) * 1.5,
        });
    }
    var frame = 0;
    function animate() {
        frame++;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        pieces.forEach(function(p) {
            p.y     += p.speed;
            p.x     += p.drift;
            p.angle += p.spin;
            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.angle);
            ctx.fillStyle = p.color;
            ctx.fillRect(-p.r / 2, -p.r / 2, p.r, p.r * 0.55);
            ctx.restore();
        });
        if (frame < 220) requestAnimationFrame(animate);
        else if (canvas.parentNode) document.body.removeChild(canvas);
    }
    animate();
}

// ── Remarks counter ───────────────────────────────────────────────────────────
function updateRemarksCounter() {
    var len = $('#MoneyReceipt_remarks').val().length;
    $('#remarks_counter')
        .text(len + ' / 200')
        .toggleClass('text-danger', len > 180)
        .toggleClass('text-muted',  len <= 180);
}

// ── Field validation feedback ─────────────────────────────────────────────────
function validateAmountField() {
    var a = parseFloat($('#MoneyReceipt_amount').val()) || 0;
    var d = parseFloat($('#MoneyReceipt_discount').val()) || 0;
    var valid = (a + d) > 0;
    $('#MoneyReceipt_amount')
        .toggleClass('is-valid',   valid)
        .toggleClass('is-invalid', !valid && a !== 0);
    $('#amount_icon i')
        .attr('class', valid ? 'fas fa-check-circle text-success' : 'fas fa-money-bill');
}

function validateDateField() {
    var v = $('#MoneyReceipt_date').val();
    var valid = /^\d{4}-\d{2}-\d{2}$/.test(v);
    $('#MoneyReceipt_date').toggleClass('is-valid', valid);
    $('#date_icon i').attr('class', valid ? 'fas fa-check-circle text-success' : 'fas fa-calendar');
}

// ── Update live preview ───────────────────────────────────────────────────────
function updatePreview() {
    var date     = $('#MoneyReceipt_date').val() || '—';
    var amount   = parseFloat($('#MoneyReceipt_amount').val())  || 0;
    var discount = parseFloat($('#MoneyReceipt_discount').val()) || 0;
    var total    = amount + discount;
    var ptVal    = $('#payment_type_dropdown').val();
    var ptLabel  = paymentLabels[ptVal] || '—';
    var remarks  = $('#MoneyReceipt_remarks').val();

    $('#prev_date').text(date);
    $('#prev_payment_type').text(ptLabel);
    $('#prev_amount').text(amount.toFixed(2));
    $('#prev_discount').text(discount.toFixed(2));
    $('#prev_total').text(total.toFixed(2));

    var words = numberToWords(total);
    $('#prev_amount_words').text(words ? '(' + words + ')' : '');

    if (remarks) {
        $('#prev_remarks').text('"' + remarks + '"');
        $('#prev_remarks_wrap').show();
    } else {
        $('#prev_remarks_wrap').hide();
    }
}

// ── Quick-fill buttons ────────────────────────────────────────────────────────
function fillAmount(pct) {
    if (currentDue <= 0) { toastr.warning('No outstanding due for this customer.'); return; }
    $('#MoneyReceipt_amount').val(((currentDue * pct) / 100).toFixed(2)).trigger('input').focus();
}

// ── Reset after successful save ───────────────────────────────────────────────
function resetAfterSave() {
    $('#remaining_due_amt').val(currentDue.toFixed(2)).css('border-color', '').removeClass('text-success text-primary text-danger');
    $('#bank_section, #cheque_no_section, #cheque_date_section').addClass('d-none');
    $('#payment_progress').css('width', '0%').attr('class', 'progress-bar bg-danger');
    $('#progress_pct').text('0%');
    $('#amount_in_words').text('');
    $('#prev_amount_words').text('');
    $('#header_payment_icon i').attr('class', 'fas fa-money-bill');
    $('#payment_type_icon').attr('class', 'fas fa-money-bill');
    $('#payment_valid_icon i').attr('class', 'fas fa-circle-o text-muted');
    $('#remarks_counter').text('0 / 200');
    updatePreview();
}

// ── Add Bank dialog ───────────────────────────────────────────────────────────
function addBankDialog() {
    <?= CHtml::ajax(array(
        'url'        => array('/sell/crmBank/CreateBankFromOutSide'),
        'data'       => 'js:$(this).serialize()',
        'type'       => 'post',
        'dataType'   => 'json',
        'beforeSend' => 'function(){ $(".ajaxLoaderFormLoad").show(); }',
        'complete'   => 'function(){ $(".ajaxLoaderFormLoad").hide(); }',
        'success'    => 'function(data){
            if(data.status=="failure"){
                $("#dialogAddBank .divForForm").html(data.div);
                $("#dialogAddBank .divForForm form").submit(addBankDialog);
            } else {
                $("#dialogAddBank .divForForm").html(data.div);
                setTimeout(function(){ $("#dialogAddBank").dialog("close"); }, 1000);
                $("#MoneyReceipt_bank_id").append(\'<option selected value="\'+data.value+\'">\'+data.label+\'</option>\');
            }
        }',
    )) ?>
    return false;
}

// ── Document ready ────────────────────────────────────────────────────────────
$(document).ready(function() {

    // Date pickers
    new Lightpick({
        field: document.getElementById("entry_date"),
        onSelect: function(d) {
            document.getElementById("MoneyReceipt_date").value = d.format('YYYY-MM-DD');
            validateDateField();
            updatePreview();
            saveDraft();
        }
    });
    new Lightpick({
        field: document.getElementById("cheque_date_picker"),
        onSelect: function(d) {
            document.getElementById("MoneyReceipt_cheque_date").value = d.format('YYYY-MM-DD');
            saveDraft();
        }
    });

    // Auto-focus amount on load
    setTimeout(function() { $('#MoneyReceipt_amount').focus(); }, 300);

    // Restore draft
    restoreDraft();

    // Validate date on initial load (pre-filled with today)
    validateDateField();

    // Payment type change
    $('#payment_type_dropdown').on('change', function() {
        var t = this.value;
        $('#bank_section').addClass('d-none');
        $('#cheque_no_section').addClass('d-none');
        $('#cheque_date_section').addClass('d-none');
        $('#MoneyReceipt_bank_id').val('');
        $('#MoneyReceipt_cheque_no').val('');
        $('#MoneyReceipt_cheque_date').val('');

        if (t == CHECK) {
            $('#bank_section').removeClass('d-none');
            $('#cheque_no_section').removeClass('d-none');
            $('#cheque_date_section').removeClass('d-none');
        } else if (t == ONLINE) {
            $('#bank_section').removeClass('d-none');
        }

        // Update icons
        var icon = paymentIcons[t] || 'fa-money-bill';
        $('#header_payment_icon i').attr('class', 'fa ' + icon);
        $('#payment_type_icon').attr('class', 'fa ' + icon);

        // Validation checkmark
        if (t) {
            $('#payment_valid_icon i').attr('class', 'fas fa-check-circle text-success');
        } else {
            $('#payment_valid_icon i').attr('class', 'fas fa-circle-o text-muted');
        }

        formDirty = true;
        saveDraft();
        updatePreview();
    });

    // Amount / discount input
    $('#MoneyReceipt_amount, #MoneyReceipt_discount').on('input', function() {
        this.value = this.value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1');

        var a         = parseFloat($('#MoneyReceipt_amount').val())  || 0;
        var d         = parseFloat($('#MoneyReceipt_discount').val()) || 0;
        var remaining = currentDue - a - d;
        var total     = a + d;

        // Remaining due color
        var $rem = $('#remaining_due_amt');
        $rem.val(remaining.toFixed(2));
        $rem.removeClass('text-success text-primary text-danger').css('border-color', '');
        if (remaining > 0.005) {
            $rem.addClass('text-success').css('border-color', '#28a745');
        } else if (remaining >= -0.005) {
            $rem.addClass('text-primary').css('border-color', '#007bff');
        } else {
            $rem.addClass('text-danger').css('border-color', '#dc3545');
        }

        // Progress bar
        var rawPct  = currentDue > 0 ? (total / currentDue) * 100 : 0;
        var dispPct = Math.min(rawPct, 100);
        var barCls  = rawPct < 50 ? 'bg-danger' : (rawPct < 100 ? 'bg-warning' : 'bg-success');
        $('#payment_progress').css('width', dispPct + '%').attr('class', 'progress-bar ' + barCls);
        $('#progress_pct').text(Math.round(rawPct) + '%');

        // Amount in words below amount field
        $('#amount_in_words').text(total > 0 ? numberToWords(total) : '');

        validateAmountField();
        formDirty = true;
        saveDraft();
        updatePreview();
    });

    // Date field input
    $('#MoneyReceipt_date').on('input change', function() {
        validateDateField();
        formDirty = true;
        saveDraft();
        updatePreview();
    });

    // Remarks counter + preview
    $('#MoneyReceipt_remarks').on('input', function() {
        updateRemarksCounter();
        formDirty = true;
        saveDraft();
        updatePreview();
    });

    // Copy MR# to clipboard on badge click
    $('#header_mr_badge').on('click', function() {
        var mrNo = $(this).text().trim();
        if (navigator.clipboard) {
            navigator.clipboard.writeText(mrNo).then(function() {
                toastr.info('<i class="fas fa-copy"></i> <strong>' + mrNo + '</strong> copied to clipboard!', '', {enableHtml: true, timeOut: 2000});
            });
        } else {
            // Fallback
            var $tmp = $('<input>').val(mrNo).appendTo('body').select();
            document.execCommand('copy');
            $tmp.remove();
            toastr.info(mrNo + ' copied!', '', {timeOut: 2000});
        }
    });

    // Keyboard shortcut: Ctrl+Enter to save
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            $('#btn_save_receipt').trigger('click');
        }
    });

    // Prevent accidental Enter-key submit
    $(document).on('keypress', function(e) {
        if (e.which === 13 && !$(e.target).is('textarea')) return false;
    });

    // Mark dirty on any form change
    $('#money-receipt-form').on('change input', function() { formDirty = true; });

    // Tooltip on MR badge
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el){new bootstrap.Tooltip(el)});
});
</script>
