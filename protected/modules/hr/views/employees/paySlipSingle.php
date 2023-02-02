<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'employees-form',
));
?>
<fieldset>
    <legend>Generate Payslip</legend>
    <table class="summaryTab">
        <tr>
            <td><?php echo $form->labelEx($model, 'startDate'); ?></td>
            <td><?php echo $form->labelEx($model, 'endDate'); ?></td>
            <td><?php echo $form->labelEx($model, 'emp_id_no'); ?></td>
            <td><?php echo $form->labelEx($model, 'id_no'); ?></td>
            <td><?php echo $form->labelEx($model, 'id'); ?></td>
        </tr>
        <tr>
            <td>
                <?php
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                $dateTimePickerConfig1 = array(
                    'model' => $model,
                    'attribute' => 'startDate',
                    'mode' => 'date',
                    'language' => 'en-AU',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'width' => '100',
                    )
                );
                $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                ?>
            </td>
            <td>
                <?php
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                $dateTimePickerConfig2 = array(
                    'model' => $model,
                    'attribute' => 'endDate',
                    'mode' => 'date',
                    'language' => 'en-AU',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'width' => '100',
                    )
                );
                $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'emp_id_no', array('maxlength' => 255)); ?>
            </td>
            <td>
                <?php echo $form->textField($model, 'id_no', array('maxlength' => 255)); ?>
            </td>
            <td>
                <input type="text" id="id_text"/>
                <?php echo $form->hiddenField($model, 'id'); ?>
                <?php
                $empInfoArry = '';
                $empInfos = Employees::model()->findAll(array('order' => 'full_name ASC'));
                if ($empInfos) {
                    $empcount = count($empInfos);
                    $i = 1;
                    foreach ($empInfos as $empInfo) {
                        $value = $empInfo->id;
                        $label = CHtml::encode($empInfo->full_name . ' (' . $empInfo->emp_id_no . ')');

                        $empInfoArry .= '{value: ' . $value . ', label: "' . $label . '"}';
                        if ($i == $empcount)
                            $empInfoArry .= '';
                        else
                            $empInfoArry .= ',';
                        $i++;
                    }
                }
                ?>
                <script>
                    var empInfoArry = [<?php echo $empInfoArry; ?>];
                    $(function () {
                        $("#id_text").autocomplete({
                            source: empInfoArry,
                            minLength: 2,
                            select: function (event, ui) {
                                $("#id_text").val(ui.item.label);
                                $("#Employees_id").val(ui.item.value);

                                return false;
                            }
                        });
                    });
                </script>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php
                echo CHtml::submitButton('Generate', array(
                        'ajax' => array(
                            'dataType' => 'json',
                            'type' => 'POST',
                            'url' => CController::createUrl('employees/paySlipSingleView'),
                            'beforeSend' => 'function(){
                                if($("#Employees_startDate").val()=="" || $("#Employees_endDate").val()=="" || $("#Employees_id").val()==""){
                                    alertify.alert("Warning! Please select date range & employee!");
                                    return false;
                                }else{
                                    $(".ajaxLoaderResultView").show();
                                }
                            }',
                            'success' => 'function(data) {
                            $(".ajaxLoaderResultView").hide();
                            $("#resultDiv").html(data.content);
                        }',
                        ),
                        'class' => 'custom_check_button',
                    )
                );
                ?>
            </td>
            <td colspan="3">
                <div id="jsPart"></div>
                <?php
                echo CHtml::submitButton('Find Employee', array(
                        'class' => 'custom_check_button',
                        'ajax' => array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'url' => CController::createUrl('employees/empOfThis'),
                            'success' => 'function(data) {
                                                $("#jsPart").html(data.jsPart);
                                         }',
                            'data' => array(
                                'empIdNo' => 'js:jQuery("#Employees_emp_id_no").val()',
                                'empPunchCardNo' => 'js:jQuery("#Employees_id_no").val()',
                            ),
                            'beforeSend' => 'function(){
                                                    document.getElementById("Employees_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF";   
                                         }',
                            'complete' => 'function(){
                                                    document.getElementById("Employees_id").style.background="#FFFFFF"; 
                                        }',
                        ),
                    )
                );
                ?>
                <span id="resetBtn">Reset</span>
                <script>
                    $(document).ready(function () {
                        $("#resetBtn").click(function () {
                            $("#Employees_emp_id_no").val("");
                            $("#Employees_id_no").val("");
                            $("#Employees_id").val("");
                        });
                    });
                </script>
            </td>
        </tr>
    </table>
</fieldset>

<?php $this->endWidget(); ?>

<fieldset>
    <legend>Payslip
        <div class="ajaxLoaderResultView" style="display: none; float: right;"><img
                    src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/></div>
    </legend>
    <div id="resultDiv"></div>
</fieldset>
