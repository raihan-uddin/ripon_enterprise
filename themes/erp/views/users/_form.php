<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'users-form',
    'action' => $this->createUrl('users/create'),
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
                <?php echo $form->textField($model, 'username', array('maxlength' => 20, 'class' => 'form-control', 'autocomplete' => 'off')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'username'); ?></span>
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password', array('maxlength' => 20, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'password'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'password2'); ?>
                <?php echo $form->passwordField($model, 'password2', array('maxlength' => 20, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'password2'); ?></span>
            </div>

            <?php
            if (Yii::app()->user->isSuperuser) {
            ?>
            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'roles'); ?>
                <?php
                //'type' => 2, //only roles
                $all_roles = new RAuthItemDataProvider('roles', array('type' => 2,));
                $data = $all_roles->fetchData();
                ?>
                <div>
                    <?php
                    $this->widget('ext.select2.ESelect2', array(
                        'name' => 'roles',
                        'data' => CHtml::listData($data, 'name', 'name'),
                        'htmlOptions' => array(
                            'multiple' => 'multiple',
                            'width' => '100%',
                            'allowClear' => true,
                        ),
                        'options' => [
                            'placeholder' => 'Select Roles',
                            'width' => '100%',
                            'allowClear' => true,
                        ],
                    ));
                    ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'roles'); ?></span>
                </div>
                <?php
                }
                ?>

            </div>
        </div>
    </div>

    <div class="card-footer">

        <fieldset class="tblFooters">
            <?php
            echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('users/create', 'render' => true)), array(
                'dataType' => 'json',
                'type' => 'post',
                'success' => 'function(data) {
                    $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        afterSaveClearSelect2();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");                        
                        toastr.success("Data saved successfully.")
                        $("#users-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("users-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        //$("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#users-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#users-form #"+key+"_em_").show();
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

<script>
    function showStore() {
        $(".store-row").show();
    }

    function hideAll() {
        $(".store-row").hide();
    }

    function afterSaveClearSelect2() {
        $("#Users_employee_id").select2("val", "");
        $('#roles').val(null).trigger('change');
    }
    $(document).ready(function(){
        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });
    });
</script>