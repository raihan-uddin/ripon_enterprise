<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'users-form-update',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
?>


<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New User' : 'Update User Info: ' . $model->username); ?></h3>

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


            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'username'); ?>
                <?php echo $form->textField($model, 'username', array('maxlength' => 20, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'username'); ?></span>
            </div>



            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php $activeStatus = array(1 => 'Active', 0 => 'Inactive'); ?>
                <?php echo $form->dropDownList($model, 'status', $activeStatus, ['class' => 'form-control']) ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'status'); ?></span>
            </div>


            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password', array('maxlength' => 20, 'value' => '', 'class' => 'form-control')); ?>
                 <span class="help-block"
                       style="color: red; width: 100%"> <?php echo $form->error($model, 'password'); ?></span>

            </div>

            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'password2'); ?>
                <?php echo $form->passwordField($model, 'password2', array('maxlength' => 20, 'value' => '', 'class' => 'form-control')); ?>
                 <span class="help-block"
                       style="color: red; width: 100%"> <?php echo $form->error($model, 'password2'); ?></span>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();', 'class' => 'btn btn-primary')); ?>

        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>
    </div>
</div>
<script type="text/javascript">
    function loadingDivDisplay() {
        $("#ajaxLoaderMR2").show();
    }
</script>
<?php $this->endWidget(); ?>


<script>

</script>