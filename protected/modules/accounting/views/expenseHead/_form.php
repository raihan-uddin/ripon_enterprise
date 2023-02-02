<?php
/* @var $this ExpenseHeadController */
/* @var $model ExpenseHead */
/* @var $form CActiveForm */
?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'expense-head-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
)); ?>

    <script>
        $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
    </script>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Expense Head' : 'Update Expense Head'); ?></h3>

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
                    <?php echo $form->labelEx($model, 'title'); ?>
                    <?php echo $form->textField($model, 'title', array('maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'title'); ?></span>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <?php
            echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('expenseHead/create', 'render' => true)), array(
                'dataType' => 'json',
                'type' => 'post',
                'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.")
                        $("#expense-head-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("expense-head-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        //$("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#expense-head-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#expense-head-form #"+key+"_em_").show();
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