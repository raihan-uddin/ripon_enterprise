<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'supplier-contact-persons-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Contact Person Info' : 'Update Contact Person Info'); ?></h3>

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
                <?php echo $form->labelEx($model, 'company_id'); ?>
                <?php echo $form->dropDownList($model, 'company_id', CHtml::listData(Suppliers::model()->findAll(array('order' => 'company_name ASC')), 'id', 'company_name'), array('prompt' => 'Select', 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'company_id'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'contact_person_name'); ?>
                <?php echo $form->textField($model, 'contact_person_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'contact_person_name'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'contact_number1'); ?>
                <?php echo $form->textField($model, 'contact_number1', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'contact_number1'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'contact_number2'); ?>
                <?php echo $form->textField($model, 'contact_number2', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'contact_number2'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'contact_number3'); ?>
                <?php echo $form->textField($model, 'contact_number3', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'contact_number3'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'email'); ?>
                <?php echo $form->textField($model, 'email', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'email'); ?></span>
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
