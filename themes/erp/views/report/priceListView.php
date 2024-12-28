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
<div class='printAllTableForThisReport table-responsive p-0'>
    <table class="summaryTab final-result table2excel table2excel_with_colors table table-bordered table-sm"
           id="table-1">
        <thead>
        <tr>
            <td colspan="10" style="font-size:16px; font-weight:bold; text-align:center">
                Price List
            </td>
        </tr>
        <tr class="titlesTr sticky">
            <th style="width: 2%; box-shadow: 0px 0px 0px 1px black inset;">SL</th>
            <th style="width: 7%; box-shadow: 0px 0px 0px 1px black inset;">Company</th>
            <th style="width: 7%; box-shadow: 0px 0px 0px 1px black inset;">Category</th>
            <th style="width: 7%; box-shadow: 0px 0px 0px 1px black inset;">Product Name</th>
            <!-- <th style="width: 7%; box-shadow: 0px 0px 0px 1px black inset;">Product Code</th> -->
            <th style="width: 7%; box-shadow: 0px 0px 0px 1px black inset;">Price</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $sl = 1;
        if ($products) {
            foreach ($products as $dmr) {
                ?>
                <tr>
                    <td><?php echo $sl++; ?></td>
                    <td><?php echo $dmr->company_name ?? 'N/A';?></td>
                    <td><?php echo $dmr->brand_name ?? 'N/A' ?></td>
                    <td><?php echo $dmr->model_name;?></td>
                    <!-- <td><?php //echo $dmr->code;?></td> -->
                    <td style="text-align:right;"><?php echo $dmr->sell_price > 0 ? number_format($dmr->sell_price, 2) : "N/A";?></td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>

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

<style>
    .summaryTab tr td, .summaryTab tr {
        padding: 3px 3px 3px 3px;
        margin: 5px;
        font-size: 12px;
        border: 1px solid #a6a6a6;
        text-align: left;
    }
</style>
