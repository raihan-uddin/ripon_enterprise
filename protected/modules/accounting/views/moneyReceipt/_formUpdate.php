<?php
/** @var MoneyReceipt $model */
/** @var Customers $customer */

// Customer financial summary
$criteria = new CDbCriteria();
$criteria->select = 'SUM(grand_total) AS grand_total';
$criteria->addColumnCondition(array('customer_id' => $customer->id));
$sellOrder = SellOrder::model()->findByAttributes(array(), $criteria);
$totalSellAmount = $sellOrder ? (float)$sellOrder->grand_total : 0;

$criteria = new CDbCriteria();
$criteria->select = 'SUM(return_amount) AS return_amount';
$criteria->addColumnCondition(array('customer_id' => $customer->id));
$returnOrder = SellReturn::model()->findByAttributes(array(), $criteria);
$totalReturnAmount = $returnOrder ? (float)$returnOrder->return_amount : 0;

$criteria = new CDbCriteria();
$criteria->select = 'SUM(amount) + SUM(discount) AS amount';
$criteria->addColumnCondition(array('customer_id' => $customer->id));
$mrSum = MoneyReceipt::model()->findByAttributes(array(), $criteria);
$totalMoneyReceipt = $mrSum ? (float)$mrSum->amount : 0;

$currentDueAmount = $totalSellAmount - $totalReturnAmount - $totalMoneyReceipt;

// Base due = outstanding before this receipt was applied
$oldAmount   = (float)$model->amount;
$oldDiscount = (float)$model->discount;
$baseDue     = $currentDueAmount + $oldAmount + $oldDiscount;

$form = $this->beginWidget('CActiveForm', array(
    'id'                     => 'money-receipt-update-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'clientOptions'          => array('validateOnSubmit' => true),
));
?>

<div class="container-fluid">

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <a class="btn btn-warning mr-2" href="<?= Yii::app()->request->requestUri ?>">
                <i class="fa fa-refresh"></i> Reload
            </a>
            <a class="btn btn-success" href="<?= Yii::app()->baseUrl ?>/index.php/accounting/moneyReceipt/admin">
                <i class="fa fa-home"></i> MR Manage
            </a>
        </div>
        <small class="text-muted">
            <i class="fa fa-keyboard-o"></i> Tip: <kbd>Ctrl</kbd>+<kbd>Enter</kbd> to update
        </small>
    </div>

    <div class="card shadow-sm mb-4">

        <!-- Card header -->
        <div class="card-header bg-warning d-flex align-items-center justify-content-between">
            <h5 class="mb-0 text-dark">
                <span id="header_payment_icon" class="mr-2">
                    <i class="fa fa-<?=
                        $model->payment_type == MoneyReceipt::CHECK  ? 'file-text-o' :
                        ($model->payment_type == MoneyReceipt::ONLINE ? 'university' : 'money')
                    ?>"></i>
                </span>
                Update Money Receipt
                <span id="header_mr_badge"
                      title="Click to copy MR#"
                      class="badge badge-dark ml-2"
                      style="font-family:monospace; font-size:12px; cursor:pointer;"
                      data-toggle="tooltip" data-placement="right">
                    <?= CHtml::encode($model->mr_no) ?>
                </span>
            </h5>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">

            <!-- Customer financial summary strip -->
            <div class="row mb-4">
                <div class="col-md-4 mb-2">
                    <div class="d-flex align-items-center p-3 rounded"
                         style="background:#e8f4fd; border-left:4px solid #3490dc;">
                        <i class="fa fa-shopping-cart fa-2x mr-3" style="color:#3490dc;"></i>
                        <div>
                            <div style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px;">Total Billed</div>
                            <div style="font-size:20px; font-weight:700; color:#1a3a5c;"><?= number_format($totalSellAmount, 2) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="d-flex align-items-center p-3 rounded"
                         style="background:#e8f8e8; border-left:4px solid #28a745;">
                        <i class="fa fa-check-circle fa-2x mr-3" style="color:#28a745;"></i>
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
                        <i class="fa fa-<?= $currentDueAmount > 0 ? 'exclamation-circle' : 'check-circle' ?> fa-2x mr-3"
                           style="color:<?= $currentDueAmount > 0 ? '#e65100' : '#28a745' ?>;"></i>
                        <div>
                            <div style="font-size:10px; color:#666; text-transform:uppercase; letter-spacing:1px;">Outstanding</div>
                            <div style="font-size:20px; font-weight:700; color:<?= $currentDueAmount > 0 ? '#e65100' : '#28a745' ?>;">
                                <?= number_format($currentDueAmount, 2) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- ── Column 1: MR# / Date / Customer / Remarks ─────────── -->
                <div class="col-md-3 mb-3">

                    <div class="form-group">
                        <label>MR No</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-weight-bold" readonly
                                   value="<?= CHtml::encode($model->mr_no) ?>"
                                   style="font-family:monospace;">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $form->labelEx($model, 'date') ?>
                        <div class="input-group" id="update_entry_date">
                            <?= $form->textField($model, 'date', array(
                                'class'       => 'form-control datetimepicker-input',
                                'placeholder' => 'YYYY-MM-DD',
                                'id'          => 'MoneyReceipt_date',
                            )) ?>
                            <div class="input-group-append">
                                <span class="input-group-text" id="date_icon">
                                    <i class="fa fa-check-circle text-success"></i>
                                </span>
                            </div>
                        </div>
                        <?= $form->error($model, 'date', array('class' => 'text-danger')) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->labelEx($model, 'customer_id') ?>
                        <div class="input-group">
                            <input type="text" class="form-control" readonly
                                   value="<?= CHtml::encode($customer->company_name) ?>">
                            <?= $form->hiddenField($model, 'customer_id') ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $form->labelEx($model, 'remarks') ?>
                        <?= $form->textArea($model, 'remarks', array(
                            'class'     => 'form-control',
                            'rows'      => 3,
                            'id'        => 'MoneyReceipt_remarks',
                            'maxlength' => 200,
                        )) ?>
                        <div class="d-flex justify-content-end">
                            <small id="remarks_counter" class="text-muted">0 / 200</small>
                        </div>
                        <?= $form->error($model, 'remarks', array('class' => 'text-danger')) ?>
                    </div>

                </div>

                <!-- ── Column 2: Amounts + progress + remaining ───────────── -->
                <div class="col-md-3 mb-3">

                    <div class="form-group">
                        <label>Due Before This Receipt</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-weight-bold"
                                   value="<?= number_format($baseDue, 2) ?>" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-balance-scale"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $form->labelEx($model, 'amount') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'amount', array(
                                'class'       => 'form-control',
                                'placeholder' => '0.00',
                                'id'          => 'MoneyReceipt_amount',
                            )) ?>
                            <div class="input-group-append">
                                <span class="input-group-text" id="amount_icon">
                                    <i class="fa fa-money"></i>
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

                    <div class="form-group">
                        <?= $form->labelEx($model, 'discount') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'discount', array(
                                'class'       => 'form-control',
                                'placeholder' => '0.00',
                                'id'          => 'MoneyReceipt_discount',
                            )) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-tag"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'discount', array('class' => 'text-danger')) ?>
                    </div>

                    <div class="form-group">
                        <label>Remaining After Update</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-weight-bold"
                                   id="remaining_due_amt"
                                   value="<?= number_format($currentDueAmount, 2) ?>" disabled>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-balance-scale"></i></span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ── Column 3: Payment type + conditional bank/cheque ────── -->
                <div class="col-md-3 mb-3">

                    <div class="form-group">
                        <?= $form->labelEx($model, 'payment_type') ?>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i id="payment_type_icon" class="fa fa-<?=
                                        $model->payment_type == MoneyReceipt::CHECK  ? 'file-text-o' :
                                        ($model->payment_type == MoneyReceipt::ONLINE ? 'university' : 'money')
                                    ?>"></i>
                                </span>
                            </div>
                            <?= $form->dropDownList($model, 'payment_type',
                                CHtml::listData(MoneyReceipt::model()->paymentTypeFilter(), 'id', 'title'),
                                array('prompt' => 'Select', 'class' => 'form-control', 'id' => 'update_payment_type')
                            ) ?>
                            <div class="input-group-append">
                                <span class="input-group-text" id="payment_valid_icon">
                                    <?php if ($model->payment_type): ?>
                                    <i class="fa fa-check-circle text-success"></i>
                                    <?php else: ?>
                                    <i class="fa fa-circle-o text-muted"></i>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <?= $form->error($model, 'payment_type', array('class' => 'text-danger')) ?>
                    </div>

                    <div class="form-group <?= $model->payment_type == MoneyReceipt::CASH ? 'd-none' : '' ?>"
                         id="bank_section">
                        <?= $form->labelEx($model, 'bank_id') ?>
                        <div class="input-group">
                            <?= $form->dropDownList($model, 'bank_id',
                                CHtml::listData(CrmBank::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
                                array('prompt' => 'Select Bank', 'class' => 'form-control')
                            ) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-university"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'bank_id', array('class' => 'text-danger')) ?>
                    </div>

                    <div class="form-group <?= $model->payment_type != MoneyReceipt::CHECK ? 'd-none' : '' ?>"
                         id="cheque_no_section">
                        <?= $form->labelEx($model, 'cheque_no') ?>
                        <div class="input-group">
                            <?= $form->textField($model, 'cheque_no', array(
                                'class'       => 'form-control',
                                'placeholder' => 'Cheque number',
                            )) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-credit-card-alt"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'cheque_no', array('class' => 'text-danger')) ?>
                    </div>

                    <div class="form-group <?= $model->payment_type != MoneyReceipt::CHECK ? 'd-none' : '' ?>"
                         id="cheque_date_section">
                        <?= $form->labelEx($model, 'cheque_date') ?>
                        <div class="input-group" id="update_cheque_date">
                            <?= $form->textField($model, 'cheque_date', array(
                                'class'       => 'form-control datetimepicker-input',
                                'placeholder' => 'YYYY-MM-DD',
                            )) ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <?= $form->error($model, 'cheque_date', array('class' => 'text-danger')) ?>
                    </div>

                </div>

                <!-- ── Column 4: Live receipt preview ─────────────────────── -->
                <div class="col-md-3 mb-3">
                    <label style="font-size:11px; color:#888; text-transform:uppercase; letter-spacing:1px;">
                        <i class="fa fa-eye"></i> Live Preview
                    </label>
                    <div id="receipt_preview" class="rounded p-3"
                         style="background:#fffdf0; border:1px dashed #ccc; font-size:12px; min-height:300px;">

                        <div style="text-align:center; border-bottom:1px dashed #bbb; padding-bottom:8px; margin-bottom:8px;">
                            <div style="font-weight:700; font-size:13px; letter-spacing:1px;">
                                <?= strtoupper(Yii::app()->params['company']['name']) ?>
                            </div>
                            <div style="color:#888; font-size:10px; text-transform:uppercase; letter-spacing:2px;">
                                Money Receipt
                            </div>
                            <div style="font-family:monospace; font-size:13px; font-weight:700;
                                        background:#fff3cd; display:inline-block;
                                        padding:2px 10px; border-radius:10px; margin-top:4px;">
                                <?= CHtml::encode($model->mr_no) ?>
                            </div>
                        </div>

                        <table style="width:100%; border-collapse:collapse; font-size:11px;">
                            <tr>
                                <td style="color:#888; padding:3px 0; width:40%;">Customer</td>
                                <td style="font-weight:600; padding:3px 0;">
                                    <?= CHtml::encode($customer->company_name) ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="color:#888; padding:3px 0;">Date</td>
                                <td id="prev_date" style="padding:3px 0;">
                                    <?= date('d M Y', strtotime($model->date)) ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="color:#888; padding:3px 0;">Payment</td>
                                <td id="prev_payment_type" style="padding:3px 0;">
                                    <?= $model->payment_type == MoneyReceipt::CASH ? 'Cash' :
                                        ($model->payment_type == MoneyReceipt::CHECK ? 'Cheque' :
                                        ($model->payment_type == MoneyReceipt::ONLINE ? 'Online Transfer' : '—')) ?>
                                </td>
                            </tr>
                        </table>

                        <div style="border-top:1px dashed #bbb; margin-top:10px; padding-top:8px;">
                            <div style="display:flex; justify-content:space-between; padding:2px 0; font-size:11px;">
                                <span style="color:#888;">Amount</span>
                                <span id="prev_amount" style="font-weight:600;"><?= number_format($oldAmount, 2) ?></span>
                            </div>
                            <div style="display:flex; justify-content:space-between; padding:2px 0; font-size:11px;">
                                <span style="color:#888;">Discount</span>
                                <span id="prev_discount"><?= number_format($oldDiscount, 2) ?></span>
                            </div>
                            <div style="display:flex; justify-content:space-between;
                                        padding:6px 0 2px; border-top:1px solid #333;
                                        margin-top:6px; font-weight:700; font-size:14px;">
                                <span>Total</span>
                                <span id="prev_total"><?= number_format($oldAmount + $oldDiscount, 2) ?></span>
                            </div>
                            <div id="prev_amount_words"
                                 style="font-size:10px; color:#888; font-style:italic;
                                        margin-top:4px; line-height:1.4;">
                                <?php
                                $initTotal = $oldAmount + $oldDiscount;
                                if ($initTotal > 0) {
                                    Yii::import('application.extensions.AmountInWord');
                                    // Fallback: just show the number if extension not available
                                }
                                ?>
                            </div>
                        </div>

                        <div id="prev_remarks_wrap"
                             style="margin-top:8px; <?= $model->remarks ? '' : 'display:none;' ?>">
                            <div id="prev_remarks"
                                 style="color:#888; font-size:10px; font-style:italic;">
                                <?= $model->remarks ? '"' . CHtml::encode($model->remarks) . '"' : '' ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div><!-- /.row -->
        </div><!-- /.card-body -->

        <div class="card-footer text-right">
            <?= CHtml::submitButton('Update Receipt', array(
                'class' => 'btn btn-warning btn-md',
                'id'    => 'btn_update_receipt',
            )) ?>
            <a href="<?= Yii::app()->baseUrl ?>/index.php/accounting/moneyReceipt/admin"
               class="btn btn-default ml-2">Cancel</a>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
// ── Constants ─────────────────────────────────────────────────────────────────
var CASH   = <?= MoneyReceipt::CASH ?>;
var CHECK  = <?= MoneyReceipt::CHECK ?>;
var ONLINE = <?= MoneyReceipt::ONLINE ?>;
var baseDue     = <?= (float)$baseDue ?>;
var formDirty   = false;

var paymentLabels = {};
paymentLabels[CASH]   = 'Cash';
paymentLabels[CHECK]  = 'Cheque';
paymentLabels[ONLINE] = 'Online Transfer';

var paymentIcons = {};
paymentIcons[CASH]   = 'money';
paymentIcons[CHECK]  = 'file-text-o';
paymentIcons[ONLINE] = 'university';

// ── Amount in words ───────────────────────────────────────────────────────────
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
    var result  = convert(intPart) + ' Taka';
    if (decPart > 0) result += ' and ' + convert(decPart) + ' Paisa';
    return result + ' Only';
}

// ── Unsaved changes warning ───────────────────────────────────────────────────
window.addEventListener('beforeunload', function(e) {
    if (formDirty) { e.preventDefault(); e.returnValue = ''; }
});

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
    var a     = parseFloat($('#MoneyReceipt_amount').val())  || 0;
    var d     = parseFloat($('#MoneyReceipt_discount').val()) || 0;
    var valid = (a + d) > 0;
    $('#MoneyReceipt_amount').toggleClass('is-valid', valid).toggleClass('is-invalid', !valid && a !== 0);
    $('#amount_icon i').attr('class', valid ? 'fa fa-check-circle text-success' : 'fa fa-money');
}

function validateDateField() {
    var valid = /^\d{4}-\d{2}-\d{2}$/.test($('#MoneyReceipt_date').val());
    $('#MoneyReceipt_date').toggleClass('is-valid', valid);
    $('#date_icon i').attr('class', valid ? 'fa fa-check-circle text-success' : 'fa fa-calendar');
}

// ── Update live preview ───────────────────────────────────────────────────────
function updatePreview() {
    var date     = $('#MoneyReceipt_date').val() || '—';
    var amount   = parseFloat($('#MoneyReceipt_amount').val())  || 0;
    var discount = parseFloat($('#MoneyReceipt_discount').val()) || 0;
    var total    = amount + discount;
    var ptVal    = parseInt($('#update_payment_type').val());
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

// ── Recalculate remaining + progress ─────────────────────────────────────────
function recalculate() {
    var a         = parseFloat($('#MoneyReceipt_amount').val())  || 0;
    var d         = parseFloat($('#MoneyReceipt_discount').val()) || 0;
    var total     = a + d;
    var remaining = baseDue - total;

    // Remaining color
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
    var rawPct  = baseDue > 0 ? (total / baseDue) * 100 : 0;
    var dispPct = Math.min(rawPct, 100);
    var barCls  = rawPct < 50 ? 'bg-danger' : (rawPct < 100 ? 'bg-warning' : 'bg-success');
    $('#payment_progress').css('width', dispPct + '%').attr('class', 'progress-bar ' + barCls);
    $('#progress_pct').text(Math.round(rawPct) + '%');

    // Amount in words
    $('#amount_in_words').text(total > 0 ? numberToWords(total) : '');

    validateAmountField();
    updatePreview();
}

// ── Document ready ────────────────────────────────────────────────────────────
$(document).ready(function() {

    // Date pickers
    new Lightpick({
        field: document.getElementById('update_entry_date'),
        onSelect: function(d) {
            document.getElementById('MoneyReceipt_date').value = d.format('YYYY-MM-DD');
            validateDateField();
            updatePreview();
            formDirty = true;
        }
    });
    new Lightpick({
        field: document.getElementById('update_cheque_date'),
        onSelect: function(d) {
            document.getElementById('MoneyReceipt_cheque_date').value = d.format('YYYY-MM-DD');
            formDirty = true;
        }
    });

    // Init on load
    validateDateField();
    updateRemarksCounter();
    recalculate();

    // Auto-focus amount
    setTimeout(function() { $('#MoneyReceipt_amount').focus(); }, 300);

    // Payment type change
    $('#update_payment_type').on('change', function() {
        var t = parseInt(this.value);
        $('#bank_section').addClass('d-none');
        $('#cheque_no_section').addClass('d-none');
        $('#cheque_date_section').addClass('d-none');
        $('#MoneyReceipt_bank_id').val('');
        $('#MoneyReceipt_cheque_no').val('');
        $('#MoneyReceipt_cheque_date').val('');

        if (t === CHECK) {
            $('#bank_section').removeClass('d-none');
            $('#cheque_no_section').removeClass('d-none');
            $('#cheque_date_section').removeClass('d-none');
        } else if (t === ONLINE) {
            $('#bank_section').removeClass('d-none');
        }

        // Update icons
        var icon = paymentIcons[t] || 'money';
        $('#header_payment_icon i').attr('class', 'fa fa-' + icon);
        $('#payment_type_icon').attr('class', 'fa fa-' + icon);

        if (this.value) {
            $('#payment_valid_icon i').attr('class', 'fa fa-check-circle text-success');
        } else {
            $('#payment_valid_icon i').attr('class', 'fa fa-circle-o text-muted');
        }

        formDirty = true;
        updatePreview();
    });

    // Amount / discount input
    $('#MoneyReceipt_amount, #MoneyReceipt_discount').on('input', function() {
        this.value = this.value.replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1');
        formDirty  = true;
        recalculate();
    });

    // Date input
    $('#MoneyReceipt_date').on('input change', function() {
        validateDateField();
        formDirty = true;
        updatePreview();
    });

    // Remarks
    $('#MoneyReceipt_remarks').on('input', function() {
        updateRemarksCounter();
        formDirty = true;
        updatePreview();
    });

    // Copy MR# to clipboard
    $('#header_mr_badge').on('click', function() {
        var mrNo = $(this).text().trim();
        if (navigator.clipboard) {
            navigator.clipboard.writeText(mrNo).then(function() {
                toastr.info('<i class="fa fa-copy"></i> <strong>' + mrNo + '</strong> copied!',
                    '', {enableHtml: true, timeOut: 2000});
            });
        } else {
            var $tmp = $('<input>').val(mrNo).appendTo('body').select();
            document.execCommand('copy');
            $tmp.remove();
            toastr.info(mrNo + ' copied!', '', {timeOut: 2000});
        }
    });

    // Keyboard shortcut: Ctrl+Enter to submit
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            formDirty = false; // allow navigation after submit
            $('#btn_update_receipt').trigger('click');
        }
    });

    // Prevent Enter on non-textarea
    $(document).on('keypress', function(e) {
        if (e.which === 13 && !$(e.target).is('textarea')) return false;
    });

    // Mark dirty on any change
    $('#money-receipt-update-form').on('change input', function() { formDirty = true; });

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
