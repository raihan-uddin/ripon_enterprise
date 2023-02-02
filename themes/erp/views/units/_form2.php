<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'units-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Unit Info' : 'Update Unit: ' . $model->label); ?></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <!--            <button type="button" class="btn btn-tool" data-card-widget="remove">-->
            <!--                <i class="fa fa-times"></i>-->
            <!--            </button>-->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <tr>
                    <td><?php echo $form->labelEx($model, 'label'); ?></td>
                    <td><?php echo $form->textField($model, 'label', array('maxlength' => 255, 'class' => 'form-control')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                     <span class="help-block"
                           style="color: red; width: 100%"> <?php echo $form->error($model, 'label'); ?></span></td>
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
    <script type="text/javascript">
        function loadingDivDisplay() {
            $("#ajaxLoaderMR2").show();
        }

    </script>

</div>
<?php $this->endWidget(); ?>
