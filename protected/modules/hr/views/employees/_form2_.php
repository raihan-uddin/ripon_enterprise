<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'employees-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo($model->isNewRecord ? 'Add New Employee Info' : 'Update Employee Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'emp_id_no'); ?></td>
                <td><?php echo $form->textField($model, 'emp_id_no', array('maxlength' => 255)); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'full_name'); ?></td>
                <td><?php echo $form->textField($model, 'full_name', array('maxlength' => 255)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'full_name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'designation_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                        $model, 'designation_id', CHtml::listData(Designations::model()->allInfos(), 'id', 'designation'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'designation_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'department_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                        $model, 'department_id', CHtml::listData(Departments::model()->findAll(), 'id', 'department_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'department_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'id_no'); ?></td>
                <td><?php echo $form->textField($model, 'id_no', array('maxlength' => 20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'id_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_no'); ?></td>
                <td><?php echo $form->textField($model, 'contact_no', array('maxlength' => 20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'email'); ?></td>
                <td><?php echo $form->textField($model, 'email', array('maxlength' => 50)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'email'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'address'); ?></td>
                <td><?php echo $form->textArea($model, 'address', array('rows' => 4, 'cols' => 20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'address'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'join_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfigJoin = array(
                        'model' => $model, //Model object
                        'attribute' => 'join_date', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'language' => '',
                        'options' => array(
//                        'ampm' => true,
                            'dateFormat' => 'yy-mm-dd',
                            'width' => '100',
                        ) // jquery plugin options
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfigJoin);
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'join_date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'permanent_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfigPermanent = array(
                        'model' => $model, //Model object
                        'attribute' => 'permanent_date', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'language' => '',
                        'options' => array(
//                        'ampm' => true,
                            'dateFormat' => 'yy-mm-dd',
                            'width' => '100',
                        ) // jquery plugin options
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfigPermanent);
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'permanent_date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'team_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                        $model, 'team_id', CHtml::listData(Teams::model()->findAll(), 'id', 'title'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'team_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_active'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList($model, 'is_active', Lookup::items('is_active'));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_active'); ?></td>
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
