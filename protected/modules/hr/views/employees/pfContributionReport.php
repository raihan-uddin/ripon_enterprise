<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'employees-form',
        ));
?>
<fieldset>
    <legend>Generate Salary Sheet</legend>
    <table class="summaryTab">
        <tr>
            <td width="20%"><?php echo $form->labelEx($model, 'startDate'); ?></td>
            <td width="20%"><?php echo $form->labelEx($model, 'endDate'); ?></td>
            <td width="20%"><?php echo $form->labelEx($model, 'department_id'); ?></td>
            <td><?php echo $form->labelEx($model, 'id'); ?></td>
            <td width="15%" rowspan="2" valign="middle">
				<?php
                echo CHtml::submitButton('Generate', array(
                    'ajax' => array(
                        'dataType' => 'json',
                        'type' => 'POST',
                        'url' => CController::createUrl('employees/pfContributionReportView'),
                        'beforeSend' => 'function(){
                                if($("#Employees_startDate").val()=="" || $("#Employees_endDate").val()==""){
                                    alertify.alert("Warning! Please select date range");
                                    return false;
                                }else if($("#Employees_id").val()=="" && $("#Employees_department_id").val()==""){
                                    alertify.alert("Warning! Please select a department OR an employee");
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
        </tr>
        <tr>
            <td>
                <?php
				Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
				$dateTimePickerConfig2 = array(
					'model' => $model,
					'attribute' => 'startDate',
					'mode' => 'date',
					'language' => 'en-AU',
					'options' => array(
						'changeMonth' => 'true',
						'changeYear' => 'true',
						'dateFormat' => 'yy-mm-dd',
						'width' => '100',
					)
				);
				$this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
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
						'changeMonth' => 'true',
						'changeYear' => 'true',
						'dateFormat' => 'yy-mm-dd',
						'width' => '100',
					)
				);
				$this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
				?>
            </td>
            <td>
                <?php
                echo $form->dropDownList(
                        $model, 'department_id', CHtml::listData(Departments::model()->findAll(), 'id', 'department_name'), array(
                    'prompt' => 'Select',
                ));
                ?>
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
                        $label = CHtml::encode($empInfo->full_name .' (' .$empInfo->emp_id_no. ')');
                        
                        $empInfoArry.='{value: ' . $value . ', label: "' . $label . '"}';
                        if ($i == $empcount)
                            $empInfoArry.='';
                        else
                            $empInfoArry.=',';
                        $i++;
                    }
                }
                ?>
                <script>
                    var empInfoArry = [<?php echo $empInfoArry; ?>];
                    $(function () {
                        $( "#id_text" ).autocomplete({
                            source: empInfoArry,
                            minLength: 2,
                            select: function(event, ui) {
                                $("#id_text").val(ui.item.label);
                                $("#Employees_id").val(ui.item.value);
                                
                                return false;
                            }
                        });
                    });
                </script>
            </td>
        </tr>
        
    </table>
</fieldset>

<?php $this->endWidget(); ?>

<fieldset>
    <legend>Salary Sheet <div class="ajaxLoaderResultView" style="display: none; float: right;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div></legend>
    <div id="resultDiv"></div>
</fieldset>
