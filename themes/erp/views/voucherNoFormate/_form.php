<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'voucher-no-formate-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Set Number Format' : 'Set Number Format'); ?></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <tr>
                    <td> <?php echo $form->labelEx($model, 'type'); ?></td>
                    <td>
                        <div class="receivedByDiv"><?php echo Lookup::item('voucher_type', $model->type); ?></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'type'); ?></td>
                </tr>
                <tr>
                    <td> <?php echo $form->labelEx($model, 'type_format'); ?></td>
                    <td><?php echo $form->textField($model, 'type_format', array('maxlength' => 255, 'class' => 'form-control')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'type_format'); ?></td>
                </tr>
            </table>
        </div>
    </div>


    <div class="card-footer">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('onclick' => 'loadingDivDisplay();', 'class' => 'btn btn-primary btn-md')); ?>
        <span id="ajaxLoaderMR2" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>
    </div>
</div>
<script type="text/javascript">
    function loadingDivDisplay() {
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
