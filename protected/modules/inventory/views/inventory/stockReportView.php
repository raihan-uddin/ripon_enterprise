<?php
/**
 * @var string $message
 * @var string $startDate
 * @var string $endDate
 *
 */
?>

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
        top: 0;
        background: white;
    }

    .final-result tbody tr:hover {
        background: #dedede;
        transition: background-color 100ms;
    }

    table tr {
        transition: background-color 0.3s; /* Add transition for smooth effect */
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
<!--need a radio button group for show only stock, zero stock, negative stock-->
<div class="btn-group" data-toggle="buttons">
    <label class="btn btn-secondary active">
        <input type="radio" name="stockFilter" value="all" checked> Show All
    </label>
    <label class="btn btn-secondary">
        <input type="radio" name="stockFilter" value="negative"> Negative Stock
    </label>
    <label class="btn btn-secondary">
        <input type="radio" name="stockFilter" value="zero"> Zero Stock
    </label>
    <label class="btn btn-secondary">
        <input type="radio" name="stockFilter" value="positive"> Only Stock
    </label>
</div>
<script src="<?= Yii::app()->theme->baseUrl ?>/js/jquery.table2excel.js"></script>
<div class='printAllTableForThisReport table-responsive p-0"'>
    <table class="summaryTab final-result table2excel table2excel_with_colors table table-bordered table-sm"
           id="table-1">
        <thead>
        <tr class=" negative zero positive">
            <td colspan="13" style="font-size:16px; font-weight:bold; text-align:center">
                <?php echo $message; ?></td>
        </tr>
        <tr class="titlesTr sticky negative zero positive">
            <th style="width: 2%; box-shadow: 0px 0px 0px 1px black inset;">SL</th>
<!--            <th style="width: 3%; box-shadow: 0px 0px 0px 1px black inset;">ID</th>-->
            <th style="box-shadow: 0px 0px 0px 1px black inset;">Product Name</th>
<!--            <th style="box-shadow: 0px 0px 0px 1px black inset;">Code</th>-->
            <th style="box-shadow: 0px 0px 0px 1px black inset; width: 10%; min-width: 30px;">Opening</th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 60px;">Stock In</th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 60px;">Stock Out</th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 60px;">Closing
                Stock
            </th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 50px;" title="Current Purchase Price">
                C.P.P
            </th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;">S.P</th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 60px;">
                Sell Value
            </th>

            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 60px;">
                P.P
            </th>
            <th style="box-shadow: 0px 0px 0px 1px black inset;  width: 10%; min-width: 50px;">
                Stock Value
            </th>

        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $rowFound = false;
        $groundTotal = 0;
        /** @var mixed $data */
        foreach ($data as $dmr) {
            if ($dmr->opening_stock != 0 || $dmr->stock_in != 0 || $dmr->stock_out) {
                $closing = (($dmr->opening_stock + $dmr->stock_in) - $dmr->stock_out);
                $stockValue = $closing * $dmr->sell_price;
                $cpp = $dmr->cpp;
                $rowFound = true;
                $groundTotal += $stockValue;
                $negativeStockClass = $closing < 0 ? '  negative ' : ' ';
                $zeroStockClass = $closing == 0 ? '  zero ' : ' ';
                $positiveStockClass = $closing > 0 ? ' positive ' : ' ';
                ?>
                <tr class="<?= $positiveStockClass . $zeroStockClass .  $negativeStockClass?>">
                    <td style="text-align: center;"><?php echo $sl++; ?></td>
<!--                    <td style="text-align: center;">-->
<!--                        --><?php //echo $dmr->model_id; ?>
<!--                    </td>-->
                    <td style="text-align: left;">
                        <a href="#"
                           onclick="currentStockPreview(<?= $dmr->model_id > 0 ? $dmr->model_id : 0 ?>);">
                            <?php echo $dmr->model_name; ?>
                        </a>
                    </td>
<!--                    <td style="text-align: left;">-->
<!--                        <a href="#"-->
<!--                           onclick="currentStockPreview(--><?php //= $dmr->model_id > 0 ? $dmr->model_id : 0 ?><!--);">-->
<!--                            --><?php //echo $dmr->code; ?>
<!--                        </a>-->
<!--                    </td>-->

                    <td style="text-align: center;"><?php echo $dmr->opening_stock; ?></td>
                    <td style="text-align: center;"><a href="#" onclick="currentStockInPreview(
                        <?= $dmr->model_id > 0 ? $dmr->model_id : 0 ?>,
                        <?= strtotime($startDate) ?>,
                        <?= strtotime($endDate) ?> )"
                        ><?php echo $dmr->stock_in; ?></a></td>
                    <td style="text-align: center;"><a href="#" onclick="currentStockOutPreview(
                        <?= $dmr->model_id > 0 ? $dmr->model_id : 0 ?>,
                        <?= strtotime($startDate) ?>,
                        <?= strtotime($endDate) ?> )"
                        ><?php echo $dmr->stock_out; ?></a></td>
                    <td style="text-align: center;"><?php echo $closing; ?></td>

                    <td style="text-align: right;"><?php echo is_numeric($cpp) ? number_format($cpp, 2) : ''; ?></td>
                    <td style="text-align: center;"><?php echo is_numeric($dmr->sell_price) ? number_format($dmr->sell_price, 2) : ''; ?></td>
                    <td style="text-align: right;"><?php echo is_numeric($stockValue) ? number_format($stockValue, 2) : ''; ?></td>
                    <td style="text-align: right;"><?php echo 0; ?></td>
                    <td style="text-align: right;"><?php echo 0; ?></td>
                </tr>
                <?php
            }
        }
        ?>
        <?php
        if (!$rowFound) {
            ?>
            <tr>
                <td colspan="13">
                    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> No result found !</div>
                </td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <th style="text-align: right;" colspan="8">Ground Total</th>
                <th style="text-align: right;"><?= number_format($groundTotal, 2) ?></th>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    <table class="headerTab table table-bordered " style="float: left; width: 100%;">
        <tr>
            <td style="padding-top: 40px; text-align: left;"></td>
            <td style="padding-top: 40px; text-align: right;"></td>
            <td style="padding-top: 40px; text-align: center;"></td>
            <td style="padding-top: 40px; text-align: center;"></td>
        </tr>
        <tr>
            <th style="text-decoration: overline; text-align: left;">Prepared By</th>
            <th style="text-decoration: overline;text-align: center;">Checked By</th>
            <th style="text-decoration: overline;text-align: center;">Head of Department</th>
            <th style="text-decoration: overline; text-align: right;">Approved By</th>
        </tr>
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
            console.log(table);
            if (table && table.length) {
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "STOCK_REPORT-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });

    });


    function currentStockPreview(product_id, start_date, end_date) {
        var URL = '<?php echo Yii::app()->createUrl('inventory/inventory/currentStockReportBatchWiseView'); ?>?product_id=' + product_id
        var day = new Date();
        var id = day.getTime();
        var w = 900;
        var h = 600;
        var scrl = 1;
        var winl = (screen.width - w) / 2;
        var wint = (screen.height - h) / 2;
        winprops = 'height=' + h + ',width=' + w + ',top=' + wint + ',left=' + winl + ',scrollbars=' + scrl + ',toolbar=0,location=0,statusbar=0,menubar=0,resizable=0';
        eval("page" + id + " = window.open(URL, '" + id + "', winprops);");
    }

    function currentStockOutPreview(product_id, start_date, end_date) {
        var URL = '<?php echo Yii::app()->createUrl('inventory/inventory/currentStockOutReportBatchWiseView'); ?>?product_id=' + product_id + '&start_date=' + start_date + '&end_date=' + end_date;
        var day = new Date();
        var id = day.getTime();
        var w = 900;
        var h = 600;
        var scrl = 1;
        var winl = (screen.width - w) / 2;
        var wint = (screen.height - h) / 2;
        winprops = 'height=' + h + ',width=' + w + ',top=' + wint + ',left=' + winl + ',scrollbars=' + scrl + ',toolbar=0,location=0,statusbar=0,menubar=0,resizable=0';
        eval("page" + id + " = window.open(URL, '" + id + "', winprops);");
    }

    function currentStockInPreview(product_id, start_date, end_date) {
        var URL = '<?php echo Yii::app()->createUrl('inventory/inventory/currentStockInReportBatchWiseView'); ?>?product_id=' + product_id + '&start_date=' + start_date + '&end_date=' + end_date;
        var day = new Date();
        var id = day.getTime();
        var w = 900;
        var h = 600;
        var scrl = 1;
        var winl = (screen.width - w) / 2;
        var wint = (screen.height - h) / 2;
        winprops = 'height=' + h + ',width=' + w + ',top=' + wint + ',left=' + winl + ',scrollbars=' + scrl + ',toolbar=0,location=0,statusbar=0,menubar=0,resizable=0';
        eval("page" + id + " = window.open(URL, '" + id + "', winprops);");
    }
    $(document).ready(function() {
        $('input[name="stockFilter"]').change(function() {
            var selectedValue = $(this).val();
            console.log(selectedValue);
            $('#table-1 tr').each(function() {
                if (selectedValue === "all") {
                    $(this).show();
                } else if ($(this).hasClass(selectedValue)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Initial execution to show all rows
        $('input[value="all"]').change();
    });
</script>