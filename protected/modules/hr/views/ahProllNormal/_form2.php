<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'ah-proll-normal-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Earning/Deduction Heade' : 'Update Earning/Deduction Head Info'); ?></legend>
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
                <td><?php echo $form->labelEx($model, 'ac_type'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'ac_type', Lookup::items('ac_type'), array('prompt' => 'select')); ?>
                </td>    
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'ac_type'); ?></td>
            </tr>
        </table>
    </fieldset>

     <fieldset class="tblFooters">
       <span id="ajaxLoaderMRF" style="display: none; float: left;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick'=>'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
       $("#ajaxLoaderMRF").show();
    }
</script>
<?php $this->endWidget(); ?>
