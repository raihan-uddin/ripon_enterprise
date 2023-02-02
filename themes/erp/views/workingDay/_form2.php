<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'working-day-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Update Working Day Info</legend>
        <table> 
            <tr>
                <td><?php echo $form->labelEx($model, 'year'); ?></td>
                <td><?php echo $form->textField($model, 'year', array('maxlength' => 4)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'year'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'month_id'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'month_id', CHtml::listData(Months::model()->findAll(), "id", "month_name"), array(
                        'prompt' => 'Select',
                    )); ?>
                </td>    
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'month_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'days_of_month'); ?></td>
                <td><?php echo $form->textField($model, 'days_of_month', array('maxlength' => 2)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'days_of_month'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'working_day'); ?></td>
                <td><?php echo $form->textField($model, 'working_day'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'working_day'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'working_hour_per_day'); ?></td>
                <td><?php echo $form->textField($model, 'working_hour_per_day'); ?></td>       
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'working_hour_per_day'); ?></td>
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
</script>
<?php $this->endWidget(); ?>
