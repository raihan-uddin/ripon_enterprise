<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'your-company-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Company' : 'Update Company: ' . $model->company_name); ?></h3>

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

            <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                <?php echo $form->labelEx($model, 'company_name'); ?>
                <?php echo $form->textField($model, 'company_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'company_name'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                <?php echo $form->labelEx($model, 'location'); ?>
                <?php echo $form->textField($model, 'location', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'location'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                <?php echo $form->labelEx($model, 'road'); ?>
                <?php echo $form->textField($model, 'road', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'road'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                <?php echo $form->labelEx($model, 'house'); ?>
                <?php echo $form->textField($model, 'house', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'house'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                <?php echo $form->labelEx($model, 'contact'); ?>
                <?php echo $form->textField($model, 'contact', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'contact'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                <?php echo $form->labelEx($model, 'email'); ?>
                <?php echo $form->textField($model, 'email', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'email'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                <?php echo $form->labelEx($model, 'web'); ?>
                <?php echo $form->textField($model, 'web', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'web'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                <?php echo $form->labelEx($model, 'trn_no'); ?>
                <?php echo $form->textField($model, 'trn_no', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'trn_no'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                <?php echo $form->labelEx($model, 'is_active'); ?>
                <?php echo $form->dropDownList($model, 'is_active', Lookup::items('is_active'), ['class' => 'form-control']); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'is_active'); ?></span>
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
