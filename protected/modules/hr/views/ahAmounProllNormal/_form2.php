<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'ah-amoun-proll-normal-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Update Earning/Deduction Configuration</legend>
        <table> 
             <tr>
                <td><?php echo $form->labelEx($model, 'employee_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                        $model, 'employee_id', CHtml::listData(Employees::model()->findAll(array('order' => 'id DESC')), 'id', 'full_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'employee_id'); ?></td>                 
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'ah_proll_normal_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'ah_proll_normal_id', CHtml::listData(AhProllNormal::model()->findAll(), 'id', 'title', 'acTypeWithName'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'ah_proll_normal_id'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php echo $form->checkBox($model, 'isPercentAmount', array('id'=>'AhAmounProllNormal_isPercentAmount2')); ?>
                    <label>Set amount in percentage</label>
                </td>
            </tr>
            <tr class="percentageTr2">
                <td><?php echo $form->labelEx($model, 'percentage_of_ah_proll_normal_id'); ?></td>
                <td>
                    <?php
                    if($model->percentage_of_ah_proll_normal_id)
                        $model->percentAmount=AhAmounProllNormal::model()->percengateAmountOnly($model->percentage_of_ah_proll_normal_id, $model->amount_adj);
                    ?>
                    <?php echo $form->textField($model, 'percentAmount', array('style' => 'width: 100px;', 'id'=>'AhAmounProllNormal_percentAmount2')); ?>
                    <label>% of</label>
                    <?php
                    echo $form->dropDownList(
                            $model, 'percentage_of_ah_proll_normal_id', CHtml::listData(AhProllNormal::model()->findAll(), 'id', 'title', 'acTypeWithName'), array(
                        'prompt' => 'Select',
                                'id'=>'AhAmountProll_percentage_of_ah_proll_normal_id2',
                        'style' => 'width: 167px;',
                        'ajax' => array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'url' => CController::createUrl('ahAmounProllNormal/amountOfThis'),
                            'success' => 'function(data) {
                                                $("#AhAmounProllNormal_amount_adj2").val(data.adjAmount);
                                         }',
                            'data' => array(
                                'percentageAmount' => 'js:jQuery("#AhAmounProllNormal_percentAmount2").val()',
                                'percentageAmountOf' => 'js:jQuery("#AhAmounProllNormal_percentage_of_ah_proll_normal_id2").val()',
                            ),
                            'beforeSend' => 'function(){
                                            document.getElementById("AhAmounProllNormal_amount_adj2").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader-big.gif) no-repeat #343434 center"; 
                                         }',
                            'complete' => 'function(){
                                            document.getElementById("AhAmounProllNormal_amount_adj2").style.background="#FFFFFF"; 
                                        }',
                        ),
                    ));
                    ?>
                </td>            
            </tr>
            <tr class="percentageTr2">
                <td></td>
                <td><?php echo $form->error($model, 'percentage_of_ah_proll_normal_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'amount_adj'); ?></td>
                <td><?php echo $form->textField($model, 'amount_adj', array('id'=>'AhAmounProllNormal_amount_adj2')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'amount_adj'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'earn_deduct_type'); ?></td>
                <td><?php echo $form->dropDownList($model, 'earn_deduct_type', Lookup::items('earn_deduct_type'), array('prompt'=>'select')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'earn_deduct_type'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'effective_month'); ?></td>
                <td>
                    <?php
                        $this->widget('ext.EJuiMonthPicker.EJuiMonthPicker', array(                            
                            'model' => $model,
                            'attribute' => 'effective_month',
                            'options' => array(
                                'yearRange' => '-5:+15',
                                'dateFormat' => 'M-yy',
                                
                            ),
                            'htmlOptions' => array(
                            'id' => 'abc'
                        ),
                        ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'effective_month'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'start_from'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig1 = array(
                        'id'=>'idForUpdate1',
                        'model' => $model, //Model object
                        'attribute' => 'start_from', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'language' => '',
                        'options' => array(
                            'changeMonth'=>'true', 
                            'changeYear'=>'true', 
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 181px;'
                        ),
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'start_from'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'end_to'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig2 = array(
                         'id'=>'idForUpdate2',
                        'model' => $model, //Model object
                        'attribute' => 'end_to', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'language' => '',
                        'options' => array(
                            'changeMonth'=>'true', 
                            'changeYear'=>'true',
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 181px;'
                        ),
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'end_to'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_active'); ?></td>
                <td><?php echo $form->dropDownList($model, 'is_active', Lookup::items('is_active')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_active'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
       <span id="ajaxLoaderMR" style="display: none; float: left;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick'=>'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
       $("#ajaxLoaderMR").show();
    }
    $(document).ready(function(){
         <?php
            if(!$model->percentage_of_ah_proll_normal_id){
        ?>
        $(".percentageTr2").hide(); 
        <?php }else{ ?>
            $("#AhAmounProllNormal_isPercentAmount2").attr('checked','checked');
            $("#AhAmounProllNormal_amount_adj2").focus(function(){
                    $(this).blur();         
                }); 
            $("#AhAmounProllNormal_amount_adj2").css("cursor", "no-drop");
            $(".percentageTr2").show();
            $("#AhAmounProllNormal_percentAmount2").focus();
            <?php } ?>
    
        $("#AhAmounProllNormal_isPercentAmount2").change(function(){
            if($(this).is(':checked')){
                $("#AhAmounProllNormal_amount_adj2").focus(function(){
                    $(this).blur();         
                }); 
                $("#AhAmounProllNormal_amount_adj2").css("cursor", "no-drop");
                $(".percentageTr2").show();
                $("#AhAmounProllNormal_amount_adj2").val("");
                $("#AhAmounProllNormal_percentAmount2").focus();
            }else{
                $("#AhAmounProllNormal_amount_adj2").focus();
                $("#AhAmounProllNormal_amount_adj2").val("");
                $("#AhAmounProllNormal_amount_adj2").css("cursor", "default");
                $(".percentageTr2").hide();
                $("#AhAmounProllNormal_percentAmount2").val("");
                $("#AhAmounProllNormal_percentage_of_ah_proll_normal_id2").val("");
            }
        });
    });
</script>
<?php $this->endWidget(); ?>