<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'prod-models-form',
            'enableAjaxValidation' => true,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<?php
if (Yii::app()->user->hasFlash('success')) {
    echo '<div class="flash-notice">' . Yii::app()->user->getFlash('success') . '</div>';
}
if (Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
}
?>
<div class="formDiv">
    <fieldset>
        <legend>Upload XL File for Material <font color="red">(Please upload only Excel 97-2003 Workbook(*.xls))</font></legend>
        <table>	
            <tr>
                <td><?php echo $form->labelEx($model, 'deviceFile'); ?></td>
                <td><?php echo $form->fileField($model, 'deviceFile', array('maxlength' => 255)); ?></td>
            </tr>    
            <tr>
                <td>
                    <?php echo CHtml::submitButton("Upload"); ?>            
                </td>
                <td>
                    <?php echo CHtml::link('Process', array('/prodModels/processDeviceData'), array('class'=>'additionalBtn')); ?>
                </td>
            </tr>
        </table>
    </fieldset>
</div>
<?php $this->endWidget(); ?>
