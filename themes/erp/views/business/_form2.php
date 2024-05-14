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
            <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Branch' : 'Update Branch: ' . $model->display_name); ?></h3>

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

                <div class="col-md-12">
                    <?php echo $form->labelEx($model, 'display_name'); ?>
                    <?php echo $form->textField($model, 'display_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'display_name'); ?></span>
                </div>
                <div class="form-group col-sm-12 col-md-12">
                    <?php echo $form->labelEx($model, 'owner_name'); ?>
                    <?php echo $form->textField($model, 'owner_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'owner_name'); ?></span>
                </div>
                <div class="form-group col-md-12">
                    <?php echo $form->labelEx($model, 'phone_number'); ?>
                    <?php echo $form->textField($model, 'phone_number', array('maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'phone_number'); ?></span>
                </div>
                <div class="form-group col-md-12">
                    <?php echo $form->labelEx($model, 'email'); ?>
                    <?php echo $form->textField($model, 'email', array('maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'email'); ?></span>
                </div>
                <div class="form-group col-md-12">
                    <?php echo $form->labelEx($model, 'address'); ?>
                    <?php echo $form->textArea($model, 'address', array('maxlength' => 255, 'class' => 'form-control', 'style' => 'height: 60px;')); ?>

                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'address'); ?></span>
                </div>
                <div class="form-group col-md-12">
                    <?php echo $form->labelEx($model, 'status'); ?>
                    <?php
                    echo $form->dropDownList(
                        $model, 'status', CHtml::listData(Business::model()->statusFilter(), 'id', 'title'), array(
                        'class' => 'form-control',
                    ));
                    ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'status'); ?></span>
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