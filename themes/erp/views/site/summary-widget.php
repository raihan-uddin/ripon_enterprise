<div class="db-pl-card">
    <div class="db-pl-icon"><i class="fa fa-line-chart"></i></div>
    <div>
        <div class="db-pl-label">Profit &amp; Loss Summary</div>
        <small class="text-muted" style="font-size:11px;">Select a date range to analyse P&amp;L</small>
    </div>
    <div class="input-group">
        <input type="text" class="form-control" id="summary-daterange"
               placeholder="Select Date Range"
               value="<?= sprintf("%s - %s", date('d/m/Y'), date('d/m/Y')) ?>"
               aria-label="Select Date Range">
        <div class="input-group-append">
            <button class="btn btn-primary" type="button" id="profit-loss-summary-btn">
                <i class="fa fa-search"></i> Search
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="profit-loss-summary-modal" tabindex="-1"
     data-bs-backdrop="static" role="dialog" aria-labelledby="profit-loss-summary-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="border-radius:14px; overflow:hidden;">
            <div class="modal-header" style="background:#6366f1; color:#fff; border:none;">
                <h5 class="modal-title" id="exampleModalLabel" style="font-size:15px; font-weight:600;">
                    <i class="fa fa-line-chart mr-2"></i> Profit &amp; Loss Summary
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        style="color:#fff; opacity:0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p>
            </div>
            <div class="modal-footer" style="border:none; padding-top:0;">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"
                        style="border-radius:8px;">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
var picker = new Lightpick({
    field: document.getElementById('summary-daterange'),
    singleDate: false, inline: false,
    numberOfMonths: 2, numberOfColumns: 2, selectForward: true,
    onSelect: function (start, end) {}
});

$('#profit-loss-summary-btn').on('click', function () {
    var dateRange = $('#summary-daterange').val();
    dateRange = dateRange.split(' - ').map(function (d) {
        return d.split('/').reverse().join('-');
    }).join(' - ');

    $('#profit-loss-summary-modal .modal-body').html(
        '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>'
    );
    $('#profit-loss-summary-btn').prop('disabled', true)
        .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

    $.ajax({
        url: '<?= Yii::app()->createUrl("site/profitLossSummary") ?>',
        type: 'POST',
        data: { dateRange: dateRange },
        success: function (response) {
            $('#profit-loss-summary-modal .modal-body').html(response);
            $('#profit-loss-summary-btn').prop('disabled', false)
                .html('<i class="fa fa-search"></i> Search');
            $('#profit-loss-summary-modal').modal('show');
            $('#profit-loss-summary-modal .modal-title').html(
                '<i class="fa fa-line-chart mr-2"></i> Summary for (' + dateRange + ')'
            );
        },
        error: function () {
            toastr.error('An error occurred. Please try again later.');
            $('#profit-loss-summary-btn').prop('disabled', false)
                .html('<i class="fa fa-search"></i> Search');
        }
    });
});
</script>
