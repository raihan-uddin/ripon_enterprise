<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'prod-brands-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Sub-Category' : 'Update Sub-Category'); ?></h3>

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
                    <td><?php echo $form->labelEx($model, 'item_id'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                            $model, 'item_id', CHtml::listData(ProdItems::model()->findAll(array('order' => 'item_name ASC')), 'id', 'item_name'), array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                         <span class="help-block"
                               style="color: red; width: 100%"> <?php echo $form->error($model, 'item_id'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'brand_name'); ?></td>
                    <td><?php echo $form->textField($model, 'brand_name', array('maxlength' => 255, 'class' => 'form-control')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                         <span class="help-block"
                               style="color: red; width: 100%"> <?php echo $form->error($model, 'brand_name'); ?></span>
                    </td>
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
