<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'units-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo($model->isNewRecord ? 'Add New Unit Info' : 'Update Unit Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'unit_type'); ?></td>
                <td>
                    <?php
                    $model->unit_type = Units::CURR_UNIT;

                    echo $form->dropDownList($model, 'unit_type', Lookup::items('unit_type'), array(
                            'prompt' => 'select'
                        )
                    );
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'unit_type'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'label'); ?></td>
                <td><?php echo $form->textField($model, 'label'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'label'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'value'); ?></td>
                <td><?php echo $form->textField($model, 'value'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'value'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'remarks'); ?></td>
                <td><?php echo $form->textArea($model, 'remarks', array('rows' => '4', 'cols' => '20')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'remarks'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img
                    src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/></span>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay() {
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
