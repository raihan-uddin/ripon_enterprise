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

        $.ajax({
            url: '<?= Yii::app()->createUrl("site/profitLossSummary") ?>',
            type: 'POST',
            data: {
                dateRange: dateRange
            },
            success: function (response) {
                $('#profit-loss-summary-modal').modal('show');
                $('#profit-loss-summary-modal .modal-body').html(response);
                // also change the modal title to the selected date range
                // like Summary for 19/Apr/24 - 19/Apr/24
                $('#profit-loss-summary-modal .modal-title').html(`Summary for  (${dateRange}) `);
                }
        });
    });

</script>