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
            <td colspan="10" style="font-size:16px; font-weight:bold; text-align:center"><?php echo $message; ?>
            </td>
        </tr>
        <tr class="titlesTr sticky">
            <th style="width: 2%; box-shadow: 0px 0px 0px 1px black inset;">SL</th>
            <th style="width: 8%; box-shadow: 0px 0px 0px 1px black inset;">Customer ID</th>
            <th style="width: 15%; box-shadow: 0px 0px 0px 1px black inset;">Name</th>
            <th style="width: 10%; box-shadow: 0px 0px 0px 1px black inset;">Phone</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Sale</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Collection</th>
            <th style="width: 10%;box-shadow: 0px 0px 0px 1px black inset;">Due</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $rowFound = false;
        $total_sale = 0;
        $total_collection = 0;
        $total_due = 0;
        ?>

        <?php
        if ($data) {
            foreach ($data as $dmr) {
                $total_sale += $dmr['total_sale_amount'];
                $total_collection += $dmr['total_receipt_amount'];
                $total_due += $dmr['due_amount'];
                $rowFound = true;
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $sl++; ?></td>
                    <td style="text-align: center; "><?php echo $dmr['customer_id']; ?></td>
                    <td style="text-align: left;"><?php echo $dmr['company_name']; ?></td>
                    <td style="text-align: center;"><?php echo $dmr['company_contact_no']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr['total_sale_amount'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr['total_receipt_amount'], 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($dmr['due_amount'], 2); ?></td>
                </tr>
                <?php

            }
        }
        ?>
        <?php
        if (!$rowFound) {
            ?>
            <tr>
                <td colspan="8">
                    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> No result found !</div>
                </td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <th style="text-align: right;" colspan="4">Ground Total</th>
                <th style="text-align: right;"><?= number_format($total_sale, 2) ?></th>
                <th style="text-align: right;"><?= number_format($total_collection, 2) ?></th>
                <th style="text-align: right;"><?= number_format($total_due, 2) ?></th>
            </tr>
            <?php
        }
        ?>
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

</script>
