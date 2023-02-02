<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'shift-heads-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Shift Heade' : 'Update Shift Head Info'); ?></legend>
        <table>   
            <tr>
                <td><?php echo $form->labelEx($model, 'title'); ?></td>
                <td><?php echo $form->textField($model, 'title', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'title'); ?></td>
            </tr>
             <tr>
                <td><?php echo $form->labelEx($model, 'in_time'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig3 = array(
                        'id'=>'in_time2',
                        'model' => $model, //Model object
                        'attribute' => 'in_time', //attribute name
                        'mode' => 'time', //use "time","date" or "datetime" (default)
                        'language' => 'en-AU',
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig3);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'in_time'); ?></td>
            </tr>
             <tr>
                <td><?php echo $form->labelEx($model, 'out_time'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig4 = array(
                        'id'=>'out_time2',
                        'model' => $model, //Model object
                        'attribute' => 'out_time', //attribute name
                        'mode' => 'time', //use "time","date" or "datetime" (default)
                        'language' => 'en-AU',
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig4);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'out_time'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none; float: left;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
