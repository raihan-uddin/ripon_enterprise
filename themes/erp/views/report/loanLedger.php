<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Report', 'url' => array('')),
        array('name' => 'Loan'),
        array('name' => 'Person Ledger'),
    ),
));
?>
<style>
    .loan-filter-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #4a6278;
        margin-bottom: 4px;
        display: block;
    }
</style>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-book" style="margin-right:6px;"></i>Loan Person Ledger</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-2">
                <div class="mb-3">
                    <label class="loan-filter-label">From Date <span style="color:red;">*</span></label>
                    <input type="text" id="loan_date_from" class="form-control datetimepicker-input"
                           placeholder="YYYY-MM-DD" value="<?= date('Y-m-01') ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="mb-3">
                    <label class="loan-filter-label">To Date <span style="color:red;">*</span></label>
                    <input type="text" id="loan_date_to" class="form-control datetimepicker-input"
                           placeholder="YYYY-MM-DD" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="mb-3">
                    <label class="loan-filter-label">Person <span style="color:#aaa; font-weight:400;">(optional — সকলের জন্য ফাঁকা রাখুন)</span></label>
                    <select id="loan_person_id" class="form-control">
                        <option value="0">— সকল ব্যক্তি (All) —</option>
                        <?php foreach ($persons as $p): ?>
                            <option value="<?= $p->id ?>"><?= htmlspecialchars($p->name) ?>
                                <?= $p->phone ? ' — ' . htmlspecialchars($p->phone) : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-2" style="display:flex; align-items:flex-end;">
                <div class="mb-3" style="width:100%;">
                    <button id="loanLedgerSearchBtn" class="btn btn-success w-100" onclick="loadLoanLedger()">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
            <div class="col-sm-12 col-md-2" style="display:flex; align-items:flex-end;">
                <div class="mb-3" style="width:100%; display:none;" id="loanPrintBtnWrapper">
                    <?php
                    $this->widget('ext.mPrint.mPrint', array(
                        'title'      => ' ',
                        'tooltip'    => 'Print Report',
                        'text'       => '<i class="fas fa-print"></i> Print',
                        'showIcon'   => false,
                        'element'    => '.loan-ledger-print-area',
                        'exceptions' => array(),
                        'publishCss' => false,
                        'visible'    => !Yii::app()->user->isGuest,
                        'debug'      => true,
                        'id'         => 'loan-ledger-print-btn',
                        'htmlOptions'=> array('class' => 'btn btn-secondary w-100'),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div id="loanLedgerResult">
            <div class="text-center text-muted" style="padding:40px 0; font-size:13px;">
                <i class="fas fa-arrow-up fa-2x" style="display:block; margin-bottom:8px; opacity:0.3;"></i>
                তারিখ সিলেক্ট করুন এবং Search চাপুন
            </div>
        </div>
    </div>
</div>

<script>
function loadLoanLedger() {
    var dateFrom = $('#loan_date_from').val();
    var dateTo   = $('#loan_date_to').val();
    var personId = $('#loan_person_id').val();

    if (!dateFrom || !dateTo) {
        toastr.error('তারিখ সিলেক্ট করুন! (Date range is required)');
        return;
    }

    var btn = $('#loanLedgerSearchBtn');
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');
    $('#loanPrintBtnWrapper').hide();

    $.post('<?= CController::createUrl('/report/loanLedgerView') ?>', {
        date_from: dateFrom,
        date_to:   dateTo,
        person_id: personId
    }, function (data) {
        $('#loanLedgerResult').html(data);
        $('#loanPrintBtnWrapper').show();
    }).fail(function (xhr) {
        toastr.error('Error: ' + xhr.responseText);
    }).always(function () {
        btn.prop('disabled', false).html('<i class="fas fa-search"></i> Search');
    });
}

$(document).on('keypress', '#loan_date_from, #loan_date_to', function (e) {
    if (e.which === 13) loadLoanLedger();
});

$(document).ready(function () {
    var picker1 = new Lightpick({
        field: document.getElementById('loan_date_from'),
        onSelect: function (date) {
            document.getElementById('loan_date_from').value = date.format('YYYY-MM-DD');
        }
    });
    picker1.setStartDate(moment().startOf('month'));

    var picker2 = new Lightpick({
        field: document.getElementById('loan_date_to'),
        onSelect: function (date) {
            document.getElementById('loan_date_to').value = date.format('YYYY-MM-DD');
        }
    });
    picker2.setStartDate(moment());
});
</script>
