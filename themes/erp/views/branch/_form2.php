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
            <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Branch' : 'Update Branch'); ?></h3>

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
                <div class="form-group col-sm-12 col-md-3" style="">
                    <?php echo $form->labelEx($model, 'business_id'); ?>
                    <div class="input-group" data-target-input="nearest">
                        <?php
                        echo $form->dropDownList(
                            $model, 'business_id', CHtml::listData(Business::model()->findAll(array('order' => 'display_name ASC')), 'id', 'display_name'), array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'item_id'); ?></span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <?php echo $form->labelEx($model, 'display_name'); ?>
                    <?php echo $form->textField($model, 'display_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'display_name'); ?></span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <?php echo $form->labelEx($model, 'phone_number'); ?>
                    <?php echo $form->textField($model, 'phone_number', array('maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'phone_number'); ?></span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <?php echo $form->labelEx($model, 'status'); ?>
                    <?php
                    echo $form->dropDownList(
                        $model, 'status', CHtml::listData(Branch::model()->statusFilter(), 'id', 'title'), array(
                        'class' => 'form-control',
                    ));
                    ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'status'); ?></span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <?php echo $form->labelEx($model, 'address'); ?>
                    <?php echo $form->textArea($model, 'address', array('maxlength' => 255, 'class' => 'form-control', 'style' => 'height: 60px;')); ?>
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