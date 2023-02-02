<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'lh-amount-proll-normal-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Update Leave Configuration</legend>
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
                <td><?php echo $form->labelEx($model, 'lh_proll_normal_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'lh_proll_normal_id', CHtml::listData(LhProllNormal::model()->findAll(), 'id', 'title'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'lh_proll_normal_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'day'); ?></td>
                <td><?php echo $form->textField($model, 'day', array('id'=>'LhAmountProllNormal_day2')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'day'); ?></td>
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
        var dayOrHr;
        $('#LhAmountProllNormal_day2').bind('keyup', function() {
            dayOrHr =$(this).val()*24;
            $('#LhAmountProllNormal_hour2').val(dayOrHr);
        });
        $('#LhAmountProllNormal_hour2').bind('keyup', function() {
            dayOrHr=$(this).val()/24;
            $('#LhAmountProllNormal_day2').val(dayOrHr);
        });
    });
</script>
<?php $this->endWidget(); ?>