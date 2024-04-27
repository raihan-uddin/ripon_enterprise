<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'prod-items-form',
    'action' => $this->createUrl('business/create'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Business' : 'Update Business'); ?></h3>

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

            <div class="form-group col-sm-12 col-md-3">
                <?php echo $form->labelEx($model, 'display_name'); ?>
                <?php echo $form->textField($model, 'display_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'display_name'); ?></span>
            </div>
            <div class="form-group col-sm-12 col-md-3">
                <?php echo $form->labelEx($model, 'owner_name'); ?>
                <?php echo $form->textField($model, 'owner_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'owner_name'); ?></span>
            </div>
            <div class="form-group col-sm-12 col-md-3">
                <?php echo $form->labelEx($model, 'phone_number'); ?>
                <?php echo $form->textField($model, 'phone_number', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'phone_number'); ?></span>
            </div>
            <div class="form-group col-sm-12 col-md-3">
                <?php echo $form->labelEx($model, 'email'); ?>
                <?php echo $form->textField($model, 'email', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'email'); ?></span>
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
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('business/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.")
                        $("#prod-items-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("business-grid", {
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
