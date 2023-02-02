<?php
if ($model->join_date != '') {
?>
<?php
echo "<div class='printBtn'>";
$this->widget('ext.mPrint.mPrint', array(
    'title' => ' ', //the title of the document. Defaults to the HTML title
    'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
    'text' => '', //text which will appear beside the print icon. Defaults to NULL
    'element' => '.printAllTableForThisReport', //the element to be printed.
    'exceptions' => array(//the element/s which will be ignored
    ),
    'publishCss' => FALSE, //publish the CSS for the whole page?
    'visible' => Yii::app()->user->checkAccess('print'), //should this be visible to the current user?
    'alt' => 'print', //text which will appear if image can't be loaded
    'debug' => FALSE, //enable the debugger to see what you will get
    'id' => 'print-div' //id of the print link
));
echo "</div>";
?>
<div class='printAllTableForThisReport' align="center" style="width:810px; font-size:12px">
    <table width="100%" cellpadding="2" style="padding:4px 30px; margin-top:120px;" align="center" width="805">
        <tr>
            <td style="text-align:left">
                Date: <?php echo $model->join_date; ?><br/><br/><br/><br/>
            </td>
        </tr>
        <tr>
            <td style="text-align:left">
                <b><?php echo Employees::model()->fullName($model->id); ?></b><br/>
                <?php echo Designations::model()->infoOfThis($model->designation_id); ?><br/>
                <?php echo ' S/O ' . $model->father_name; ?><br/>
                <?php echo $model->address; ?><br/><br/>
                Subject: <b>Termination Letter</b>.<br/><br/><br/>
            </td>
        </tr>
        <tr>
            <td>
                Dear <?php echo Employees::model()->fullName($model->id); ?>,<br/><br/>
            </td>
        </tr>
        <tr>
            <td style="text-align:justify">
                We regret to inform you that your employment with ABCD. shall be terminated
                from <?php echo $model->join_date; ?>
                due to your violation of our employee code of conduct. We have no choice this action is necessary.
                <br/><br/>
                Please arrange for the return of any company property in your possession. We thank you for your service
                with us and we wish it didn’t have to end this way.
                <br/><br/><br/><br/>
            </td>
        </tr>
        <tr>
            <td>
                Thanking you<br/><br/><br/><br/>

                Engr. Md. Ismail Karim Chowdhury<br/>
                Managing Director
            </td>
        </tr>
    </table>

    <?php
    } else {
        echo '<div align="center" style="background-color: #FF0000; color:#fff; border: 1px solid #000; font-weight: bold; font-size: 14px; padding: 5px;">Termination Date is Not Set. Please Set Termination Date to View.</div>';
    }
    ?>
</div>
