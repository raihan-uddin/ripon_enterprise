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


    .final-result thead tr.titlesTr th {
        background: #1a2c3d !important;
        color: #ffffff !important;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: 1px solid #243d54;
        border-bottom: 3px solid #17a2b8;
        text-align: center;
        padding: 7px 6px;
        white-space: nowrap;
    }

    #sticky-header-clone-cdr {
        display: none;
        position: fixed;
        z-index: 1000;
        background: #1a2c3d;
        border-collapse: collapse;
    }

    #sticky-header-clone-cdr th {
        background: #1a2c3d !important;
        color: #ffffff !important;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: 1px solid #243d54;
        border-bottom: 3px solid #17a2b8;
        text-align: center;
        padding: 7px 6px;
        white-space: nowrap;
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
<div class="aging-legend">
    <strong>Aging Indicator:</strong>
    <span class="legend-box legend-green"></span> <small>Active (Last 30 Days)</small>
    <span class="legend-box legend-yellow"></span> <small>30–59 Days Inactive</small>
    <span class="legend-box legend-orange"></span> <small>60–89 Days Inactive</small>
    <span class="legend-box legend-red"></span> <small>90+ Days Overdue</small>
</div>

<div class="aging-filter-container">
    <label><strong>Filter by Aging :</strong></label>

    <button type="button" class="aging-filter-btn" data-filter="all">All</button>
    <button type="button" class="aging-filter-btn legend-green" data-filter="green">Active</button>
    <button type="button" class="aging-filter-btn legend-yellow" data-filter="yellow">30–59 Days</button>
    <button type="button" class="aging-filter-btn legend-orange" data-filter="orange">60–89 Days</button>
    <button type="button" class="aging-filter-btn legend-red" data-filter="red">90+ Days</button>
</div>


<div class='printAllTableForThisReport'>
<div class="stock-table-wrapper" style="overflow-x: auto;">
    <table class="summaryTab final-result table2excel table2excel_with_colors table table-bordered table-sm"
           id="table-cdr">
        <thead>
        <tr>
            <td colspan="12" style="font-size:16px; font-weight:bold; text-align:center">
                <div class="report-header">
                    <h4>CUSTOMER DUE REPORT</h4>
                    <div class="meta">
                        <div><b>Generated:</b> <?= date("d M Y h:i A") ?></div>
                        <div><b>User:</b> <?= Yii::app()->user->name ?></div>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="titlesTr">
            <th style="width: 2%;">SL</th>
            <th style="width: 5%;">Customer ID</th>
            <th style="width: 15%;">Name</th>
            <th style="width: 10%;">Phone</th>
            <th style="width: 5%;">Last Activity Date</th>
            <th style="width: 5%;">Aging (Days)</th>
            <th style="width: 10%;">Sale</th>
            <th style="width: 10%;">Return</th>
            <th style="width: 10%;">Collection</th>
            <th style="width: 10%;">Due</th>
            <th style="width: 5%;">Status</th>
            <th style="width: 5%;">Payment Ratio</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $rowFound = false;
        $total_sale = 0;
        $total_return = 0;
        $total_collection = 0;
        $total_due = 0;
        ?>

        <?php
        if ($data) {
            foreach ($data as $dmr) {
                $total_sale += $dmr['total_sale_amount'];
                $total_return += $dmr['total_return_amount'];
                $total_collection += $dmr['total_receipt_amount'];
                $total_due += $dmr['due_amount'];
                $rowFound = true;

                $lastActivity = $dmr['last_activity_date'];
                $daysDiff = (strtotime(date('Y-m-d')) - strtotime($lastActivity)) / 86400;
                $rowClass = '';

                if ($daysDiff >= 90) {
                    $rowClass = 'legend-red';
                } elseif ($daysDiff >= 60) {
                    $rowClass = 'legend-orange';
                } elseif ($daysDiff >= 30) {
                    $rowClass = 'legend-yellow';
                } else {
                    $rowClass = 'legend-green';
                }
                ?>
                <tr class="<?= $rowClass ?>">
                    <td style="text-align: center;"><?php echo $sl++; ?></td>
                    <td style="text-align: center; "><?php echo $dmr['customer_id']; ?></td>
                    <td style="text-align: left;"><?php echo $dmr['company_name']; ?></td>
                    <td style="text-align: center;"><?php echo $dmr['company_contact_no']; ?></td>
                    <td style="text-align: center;"><?php echo $dmr['last_activity_date']; ?></td>
                    <td style="text-align:right;"><?= $dmr['aging_days'] ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr['total_sale_amount'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr['total_return_amount'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr['total_receipt_amount'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr['due_amount'], 2); ?></td>
                    <td style="text-align:right;"><?= $dmr['customer_status'] ?></td>
                    <td style="text-align:right;"><?= $dmr['payment_ratio'] ?>%</td>
                </tr>
                <?php

            }
        }
        ?>
        <?php
        if (!$rowFound) {
            ?>
            <tr>
                <td colspan="11"
                    style='text-align: center; font-size: 18px; text-transform: uppercase; font-weight: bold;'>
                    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> No result found !</div>
                </td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <th style="text-align: right;" colspan="6">Ground Total</th>
                <th style="text-align: right;"><?= number_format($total_sale, 2) ?></th>
                <th style="text-align: right;"><?= number_format($total_return, 2) ?></th>
                <th style="text-align: right;"><?= number_format($total_collection, 2) ?></th>
                <th style="text-align: right;"><?= number_format($total_due, 2) ?></th>
                <th></th>
                <th></th>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
</div>

<style>
    .summaryTab tr td, .summaryTab tr {
        padding: 3px 3px 3px 3px;
        margin: 5px;
        font-size: 12px;
        border: 1px solid #a6a6a6;
        text-align: left;
    }

    .report-header h2 {
        margin: 0;
    }
    .report-header .meta {
        font-size: 11px;
        color: #555;
    }

    .aging-filter-container {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .aging-filter-btn {
        padding: 4px 10px;
        border: 1px solid #999;
        background: #f8f8f8;
        cursor: pointer;
        font-size: 12px;
        border-radius: 4px;
    }

    .aging-filter-btn:hover {
        background: #e1e1e1;
    }

    .aging-filter-btn.active {
        border: 2px solid #000;
        background: #dcdcdc;
    }

    .aging-legend {
        margin-bottom: 10px;
        font-size: 12px;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .legend-box {
        display: inline-block;
        width: 14px;
        height: 14px;
        border-radius: 3px;
        margin-right: 4px;
        border: 1px solid #ccc;
    }

    .legend-green { background-color: #ffffff; }
    .legend-yellow { background-color: #fff3cd; }
    .legend-orange { background-color: #ffe5b4; }
    .legend-red    { background-color: #f8d7da; }

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
                    filename: "CUSTOMER_DUE_REPORT-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });

    });

    // JS sticky header
    (function () {
        var $table   = $('#table-cdr');
        var $origRow = $table.find('thead tr.titlesTr');
        var $clone   = null;

        function buildClone() {
            var $c = $('<table id="sticky-header-clone-cdr"><thead><tr></tr></thead></table>');
            $origRow.find('th').each(function () {
                var w = $(this).outerWidth();
                $c.find('tr').append(
                    $('<th>').text($(this).text()).css('width', w + 'px').css('min-width', w + 'px')
                );
            });
            $c.css('width', $table.outerWidth() + 'px');
            $('body').append($c);
            $clone = $c;
        }

        function updateClonePosition() {
            if (!$clone) return;
            var left = $table.offset().left - $(window).scrollLeft();
            $clone.css({ top: 0, left: left + 'px' });
        }

        $(window).on('scroll resize', function () {
            var tableTop    = $table.offset().top;
            var tableBottom = tableTop + $table.outerHeight();
            var scrollTop   = $(window).scrollTop();

            if (scrollTop > tableTop && scrollTop < tableBottom) {
                if (!$clone) buildClone();
                $clone.show();
                updateClonePosition();
            } else {
                if ($clone) $clone.hide();
            }
        });
    })();

    $(document).on("click", ".aging-filter-btn", function () {

        $(".aging-filter-btn").removeClass("active");
        $(this).addClass("active");

        const filter = $(this).data("filter");

        if (filter === "all") {
            $("#table-cdr tbody tr").show();
            return;
        }

        // Hide all rows
        $("#table-cdr tbody tr").hide();

        // Show rows matching selected aging class
        $("#table-1 tbody tr." + "legend-" + filter).show();
    });


</script>
