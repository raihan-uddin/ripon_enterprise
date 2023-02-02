<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'prod-items-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Location' : 'Update Location: ' . $model->name); ?></h3>

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
        <div class="row">

            <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                <?php echo $form->labelEx($model, 'store_id'); ?>
                <?php echo $form->dropDownList(
                    $model, 'store_id', CHtml::listData(Stores::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                    'prompt' => 'Select',
                    'class' => 'form-control',
                ));
                ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'store_id'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'name'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                <?php echo $form->labelEx($model, 'address'); ?>
                <?php echo $form->textArea($model, 'address', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'address'); ?></span>
            </div>
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
