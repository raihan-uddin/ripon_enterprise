<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'customers-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<style>
    .hidden {
        display: none;
    }
</style>


<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Customer' : 'Update Customer'); ?></h3>

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

            <div class="form-group  col-sm-6 col-md-3">
                <?php echo $form->labelEx($model, 'company_name'); ?>
                <?php echo $form->textField($model, 'company_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'company_name'); ?></span>
            </div>


            <div class="form-group  col-sm-6 col-md-3">
                <?php echo $form->labelEx($model, 'owner_person'); ?>
                <?php echo $form->textField($model, 'owner_person', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'owner_person'); ?></span>
            </div>

            <div class="form-group  col-sm-6 col-md-3">
                <?php echo $form->labelEx($model, 'owner_mobile_no'); ?>
                <?php echo $form->textField($model, 'owner_mobile_no', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'owner_mobile_no'); ?></span>
            </div>

            <div class="form-group  col-sm-6 col-md-3"  title="ID example: 1, 2, 3">
                <?php echo $form->labelEx($model, 'supplier_id'); ?>
                <?php echo $form->textField($model, 'supplier_id', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '1,2,3')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'supplier_id'); ?></span>
            </div>

            <div class="form-group  col-sm-6 col-md-3">
                <?php echo $form->labelEx($model, 'opening_amount'); ?>
                <?php echo $form->textField($model, 'opening_amount', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'opening_amount'); ?></span>
            </div>

            <div class="form-group  col-sm-6 col-md-3">
                <?php echo $form->labelEx($model, 'company_email'); ?>
                <?php echo $form->textField($model, 'company_email', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'company_email'); ?></span>
            </div>

            <div class="form-group  col-sm-6 col-md-3">
                <?php echo $form->labelEx($model, 'company_web'); ?>
                <?php echo $form->textField($model, 'company_web', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'company_web'); ?></span>
            </div>

            <div class="form-group  col-sm-6 col-md-3 hidden">
                <?php echo $form->labelEx($model, 'zip'); ?>
                <?php echo $form->textField($model, 'zip', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'zip'); ?></span>
            </div>

            <div class="form-group  col-sm-6 col-md-3 hidden">
                <?php echo $form->labelEx($model, 'state'); ?>
                <?php echo $form->textField($model, 'state', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'state'); ?></span>
            </div>

            <div class="form-group  col-sm-6 col-md-3 hidden">
                <?php echo $form->labelEx($model, 'city'); ?>
                <?php echo $form->textField($model, 'city', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'city'); ?></span>
            </div>

            <div class="form-group  col-sm-6 col-md-3">
                <?php echo $form->labelEx($model, 'trn_no'); ?>
                <?php echo $form->textField($model, 'trn_no', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'trn_no'); ?></span>
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
