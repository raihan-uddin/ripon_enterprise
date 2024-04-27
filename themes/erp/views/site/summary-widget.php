<div class="row">
    <div class="margin p-2">
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="summary-daterange" placeholder="Select Date Range" value="<?= sprintf("%s - %s", date('d/m/Y'), date('d/m/Y')) ?>"
                   aria-label="Select Date Range" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="profit-loss-summary-btn">Search</button>
            </div>
        </div>
        <!--        modal-->
        <div class="modal fade" id="profit-loss-summary-modal" tabindex="-1" role="dialog"
             aria-labelledby="profit-loss-summary-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Profit & Loss Summary</h5>
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
    </div>
</div>
<script>
    var picker = new Lightpick({
        field: document.getElementById('summary-daterange'),
        singleDate: false,
        inline: false,
        numberOfMonths: 2,
        numberOfColumns: 2,
        selectForward: true,
        onSelect: function (start, end) {
            var str = '';
            str += start ? start.format('Do MMMM YYYY') + ' to ' : '';
            str += end ? end.format('Do MMMM YYYY') : '...';
            // document.getElementById('result-2').innerHTML = str;
        }
    });

    // on click of search button get the date range and send it to the server & show the response on modal
    $('#profit-loss-summary-btn').on('click', function () {
        var dateRange = $('#summary-daterange').val();
        // send the date range in yyyy-mm-dd format currently it is in dd/mm/yyyy format
        dateRange = dateRange.split(' - ').map(function (date) {
            return date.split('/').reverse().join('-');
        }).join(' - ');

        // Show spinner or loading text in the modal body & button disabled
        $('#profit-loss-summary-modal .modal-body').html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');
        $('#profit-loss-summary-modal .modal-footer button').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        $('#profit-loss-summary-btn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        $.ajax({
            url: '<?= Yii::app()->createUrl("site/profitLossSummary") ?>',
            type: 'POST',
            data: {
                dateRange: dateRange
            },

            success: function (response) {
                // Hide spinner or loading text
                $('#profit-loss-summary-modal .modal-body').html(response);
                // Enable the button
                $('#profit-loss-summary-modal .modal-footer button').prop('disabled', false).html('Submit');
                // Enable profit-loss-summary-btn
                $('#profit-loss-summary-btn').prop('disabled', false).html('Submit');
                // Show the modal
                $('#profit-loss-summary-modal').modal('show');
                // Change the modal title to the selected date range
                $('#profit-loss-summary-modal .modal-title').html(`Summary for (${dateRange})`);
            },
            error: function (xhr, status, error) {
                // Handle errors if needed
                toastr.error('An error occurred. Please try again later.');
                // Hide spinner or loading text
                $('#profit-loss-summary-modal .modal-body').html(response);
                // Enable the button
                $('#profit-loss-summary-modal .modal-footer button').prop('disabled', false).html('Submit');
                // Enable profit-loss-summary-btn
                $('#profit-loss-summary-btn').prop('disabled', false).html('Submit');
            }
        });
    });

</script>