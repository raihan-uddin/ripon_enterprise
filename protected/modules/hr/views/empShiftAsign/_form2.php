<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'emp-attendance-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
        ));
echo $form->hiddenField($model, 'emp_id');
?>
<div class="formDiv">
    <fieldset>
        <legend>Update Shift Asign</legend>
        <table>   
            <tr>
                <td><?php echo $form->labelEx($model, 'emp_id'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'emp_id', CHtml::listData(Employees::model()->findAll(array('order' => 'id')), 'id', 'full_name'), array('empty' => 'Select Employee')) ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'date_asign'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig1 = array(
                        'model' => $model, //Model object
                        'attribute' => 'date_asign', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'language' => '',
                        'options' => array(
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                            'dateFormat' => 'yy-mm-dd',
                        ),
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'shift_id'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'shift_id', CHtml::listData(ShiftHeads::model()->findAll(array('order' => 'id')), 'id', 'title'), array('empty' => 'Select Shift Head')) ?>
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay() {
        $("#ajaxLoaderMR").show();
    }
</script>

<?php $this->endWidget(); ?>
