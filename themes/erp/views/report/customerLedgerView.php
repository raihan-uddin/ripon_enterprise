<style>
    .summaryTab {
        float: left;
        width: 100%;
        margin-bottom: 10px;
        font-size: 12px;
        border: none;
        border-collapse: collapse;
    }

    .summaryTab tr {
        border: 1px dotted #a6a6a6;
    }

    .summaryTab tr td,
    .summaryTab tr th {
        padding: 5px;
        font-size: 12px;
        border: 1px solid #a6a6a6;
        text-align: left;
    }

    .summaryTab tr th {
        background-color: #c0c0c0;
        font-weight: bold;
        border: 1px solid #a6a6a6;
        text-align: center;
    }


    .final-result .sticky {
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        background: white;
    }

    .final-result tbody tr:hover {
        background: #dedede;
        transition: background-color 100ms;
    }

</style>

<?php
date_default_timezone_set("Asia/Dhaka");
$yourCompanyInfo = YourCompany::model()->findByAttributes(array('is_active' => YourCompany::ACTIVE,));
if ($yourCompanyInfo) {
    $yourCompanyName = $yourCompanyInfo->company_name;
    $yourCompanyLocation = $yourCompanyInfo->location;
    $yourCompanyRoad = $yourCompanyInfo->road;
    $yourCompanyHouse = $yourCompanyInfo->house;
    $yourCompanyContact = $yourCompanyInfo->contact;
    $yourCompanyEmail = $yourCompanyInfo->email;
    $yourCompanyWeb = $yourCompanyInfo->web;
} else {
    $yourCompanyName = 'N/A';
    $yourCompanyLocation = 'N/A';
    $yourCompanyRoad = 'N/A';
    $yourCompanyHouse = 'N/A';
    $yourCompanyContact = 'N/A';
    $yourCompanyEmail = 'N/A';
    $yourCompanyWeb = 'N/A';
}

echo "<div class='printBtn' style='width: unset;'>";
echo "  <img class='exportToExcel' id='exportToExcel'  src='" . Yii::app()->theme->baseUrl . "/images/excel.png' title='EXPORT TO EXCEL'>";
$this->widget('ext.mPrint.mPrint', array(
    'title' => ' ', //the title of the document. Defaults to the HTML title
    'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
    'text' => '', //text which will appear beside the print icon. Defaults to NULL
    'element' => '.printAllTableForThisReport', //the element to be printed.
    'exceptions' => array(//the element/s which will be ignored
    ),
    'publishCss' => TRUE, //publish the CSS for the whole page?
    'visible' => !Yii::app()->user->isGuest, //should this be visible to the current user?
    'alt' => 'print', //text which will appear if image can't be loaded
    'debug' => FALSE, //enable the debugger to see what you will get
    'id' => 'print-div2'         //id of the print link
));
echo "</div>";

?>
<script src="<?= Yii::app()->theme->baseUrl ?>/js/jquery.table2excel.js"></script>
<div class='printAllTableForThisReport table-responsive p-0"'>
    <table class="summaryTab final-result table2excel table2excel_with_colors table table-bordered table-sm"
           id="table-1">
        <thead>
        <tr>
            <td colspan="10" style="font-size:16px; font-weight:bold; text-align:center"><?php echo $message; ?></td>
        </tr>
        <tr class="titlesTr sticky">
            <th style="width: 2%; box-shadow: 0px 0px 0px 1px black inset;">SL</th>
            <th style="width: 8%; box-shadow: 0px 0px 0px 1px black inset;">Trx Type</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Date</th>
            <th style="width: 5%; box-shadow: 0px 0px 0px 1px black inset;">ID</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Invoice No</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Remarks</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Debit</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Credit</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Closing</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $rowFound = false;
        $row_closing = $total_debit = $total_credit = 0;

        $debit_opening = $credit_opening = 0;
        if ($opening) {
            if ($opening >= 0) {
                $credit_opening = $opening;
                $total_credit += $credit_opening;
            } else {
                $debit_opening = abs($opening);
                $total_debit += $debit_opening;
            }
            ?>
            <tr>
                <td></td>
                <td style="text-align: center;">
                    <span>
                        Opening
                    </span>
                </td>
                <td colspan="4"></td>
                <td style="text-align: right;"><?= $debit_opening ? number_format($debit_opening, 2) : '' ?></td>
                <td style="text-align: right;"><?= $credit_opening ? number_format($credit_opening, 2) : '' ?></td>
                <td style="text-align: right;"><?= number_format($opening, 2) ?></td>
            </tr>
            <?php
        }

        $row_closing += $opening;

        if ($data) {
            foreach ($data as $dmr) {
                $trx_type = $dmr['trx_type'];
                $amount = $dmr['amount'];
                $debit = $credit = 0;
                $remarks = "";
                if ($trx_type == 'sale') {
                    $credit = $amount;
                    $row_closing += $credit;
                    $total_credit += $credit;
                    $class = "sell";
                } else if ($trx_type == 'return') {
                    $debit = $amount;
                    $row_closing -= $debit;
                    $total_debit += $debit;
                    $class = "return";
                } else {
                    $payment = $dmr['payment_type'];
                    $paymentType = MoneyReceipt::model()->paymentTypeStringWithoutBedge($payment);
                    $bankName = CrmBank::model()->nameOfThis($dmr['bank_id']);
                    $cheque = $dmr['cheque_no'];
                    $cheque_date = $dmr['cheque_date'];
                    if ($bankName){
                        $remarks .= strtoupper($bankName);
                    }
                    if ($cheque) {
                        $remarks .= " | " . strtoupper($cheque);
                    }
                    if ($cheque_date) {
                        $cheque_date = date('d-m-Y', strtotime($cheque_date));
                        $remarks .= " | " . $cheque_date;
                    }
                    $debit = $amount;
                    $row_closing -= $debit;
                    $total_debit += $debit;
                    $class = "mr";
                    $trx_type = $paymentType;
                }

                $trx_label = ucfirst($trx_type);

                $rowFound = true;
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $sl++; ?></td>
                    <td style="text-align: center;">
                    <span class="trx-badge-screen">
                        <?= $trx_label ?>
                    </span>
                    </td>

                    <td style="text-align: center;"><?php echo $dmr['date']; ?></td>
                    <td style="text-align: left;">
                        <?php
                        $idParts = explode(',', $dmr['id']);
                        if (count($idParts) > 1) {
                            echo $idParts[1] . '...';
                        } else {
                            echo $dmr['id']; // Fallback: use original
                        }
                        ?>
                    </td>
                    <td style="text-align: left;">
                        <?php
                        $idParts = explode(',', $dmr['order_no']);
                        if (count($idParts) > 1) {
                            echo $idParts[1] . '...';
                        } else {
                            echo $dmr['order_no']; // Fallback: use original
                        }
                        ?>
                    </td>
                    <td style="text-align: left;"><?= $remarks ?></td>
                    <td style="text-align: right;"><?= $debit ? number_format($debit, 2) : '' ?></td>
                    <td style="text-align: right;"><?= $credit ? number_format($credit, 2) : '' ?></td>
                    <td style="text-align: right;"><?= number_format($row_closing, 2) ?></td>
                </tr>
                <?php
            }
        }

        if (!$rowFound) {
            echo "<tr>
                    <td colspan='8' style='text-align: center; font-size: 18px; text-transform: uppercase; font-weight: bold;'>
                        <div class='alert alert-warning'><i class='fa fa-exclamation-triangle'></i> No result found!</div>
                    </td>
                </tr>";
        }
        ?>

        <!-- Footer Total Row -->
        <tr style="font-weight: bold; background: #eef;">
            <td colspan="6" style="text-align: right;">Total</td>
            <td style="text-align: right;"><?= number_format($total_debit, 2) ?></td>
            <td style="text-align: right;"><?= number_format($total_credit, 2) ?></td>
            <td style="text-align: right;"><?= number_format($row_closing, 2) ?></td>
        </tr>

        </tbody>
    </table>
</div>


<style>
    .summaryTab tr td, .summaryTab tr {
        padding: 3px 3px 3px 3px;
        margin: 5px;
        font-size: 12px;
        border: 1px solid #a6a6a6;
        text-align: left;
    }
</style>

<script>
    $(function () {
        $(".exportToExcel").click(function (e) {
            var table = $('.table2excel');

            if (table && table.length) {
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "CUSTOMER_LEDGER-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });

    });


    $('#table-1').off('click', '.sell').on('click', '.sell', function () {

        var invoiceId = $(this).text();
        var $this = $(this);
        $this.html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            url: '<?= Yii::app()->createUrl("sell/sellOrder/voucherPreview") ?>',
            type: 'POST',
            data: {
                invoiceId: invoiceId,
                show_profit: 1
            },
            success: function (response) {
                $('#information-modal').modal('show');
                $('#information-modal .modal-body').html(response);
                $this.html(invoiceId);
            },
            error: function () {
                $this.html(invoiceId);
                toastr.error('Something went wrong');
            }
        });
    });
</script>


<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
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