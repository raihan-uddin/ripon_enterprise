<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'customers-form',
    'action' => $this->createUrl('customers/create'),
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

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Customer' : 'Update Customer'); ?></h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
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

            <div class="form-group  col-sm-6 col-md-3">
                <?php echo $form->labelEx($model, 'company_address'); ?>
                <?php echo $form->textField($model, 'company_address', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => 'Customer Address')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'company_address'); ?></span>
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
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('customers/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#customers-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("customers-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        //$("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#prod-items-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#prod-items-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){                        
                $("#ajaxLoader").show();
             }'
        ), array('class' => 'btn btn-primary btn-md'));
        ?>

        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>

        <div id="formResult" class="ajaxTargetDiv"></div>
        <div id="formResultError" class="ajaxTargetDivErr"></div>
    </div>
</div>

<?php $this->endWidget(); ?>
