<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'departments-sub-form',
    'action' => $this->createUrl('departmentsSub/create'),
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
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Sub-Department' : 'Update Sub-Department'); ?></h3>

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
            <div class="form-group col-sm-6 col-md-4" style="">
                <?php echo $form->labelEx($model, 'department_id'); ?>
                <div class="input-group" data-target-input="nearest">
                    <?php
                    echo $form->dropDownList(
                        $model, 'department_id', CHtml::listData(Departments::model()->findAll(array('order' => 'department_name ASC')), 'id', 'department_name'), array(
                        'prompt' => 'Select',
                        'class' => 'form-control',
                    ));
                    ?>
                    <div class="input-group-append ">
                        <div class="input-group-text">
                            <?php echo CHtml::link(' <i class="fa fa-plus"></i>', "", array('onclick' => "{  addSection(); $('#dialogAddSection').dialog('open'); } ")); ?>
                            <?php
                            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                'id' => 'dialogAddSection',
                                'options' => array(
                                    'title' => 'Add Sub Department',
                                    'autoOpen' => false,
                                    'modal' => true,
                                    'width' => 550,
                                    'resizable' => false,
                                ),
                            ));
                            ?>
                            <div class="divForForm">
                                <div class="ajaxLoaderFormLoad" style="display: none;"><img
                                            src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/>
                                </div>
                            </div>

                            <?php $this->endWidget(); ?>

                            <script type="text/javascript">
                                // here is the magic
                                function addSection() {
                                    <?php
                                        echo CHtml::ajax(array(
                                            'url' => array('/hr/departments/createDepartmentFromOutSide'),
                                            'data' => "js:$(this).serialize()",
                                            'type' => 'post',
                                            'dataType' => 'json',
                                            'beforeSend' => "function(){
                                                $('.ajaxLoaderFormLoad').show();
                                            }",
                                            'complete' => "function(){
                                                $('.ajaxLoaderFormLoad').hide();
                                            }",
                                            'success' => "function(data){
                                                    if (data.status == 'failure')
                                                    {
                                                        $('#dialogAddSection div.divForForm').html(data.div);
                                                              // Here is the trick: on submit-> once again this function!
                                                        $('#dialogAddSection div.divForForm form').submit(addSection);
                                                    }
                                                    else
                                                    {
                                                        $('#dialogAddSection div.divForForm').html(data.div);
                                                        setTimeout(\"$('#dialogAddSection').dialog('close') \",1000);
                                                        $('#DepartmentsSub_department_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                                    }
                                            }",
                                        ))
                                        ?>
                                    return false;
                                }
                            </script>
                        </div>
                    </div>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'department_id'); ?></span>
            </div>
            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'title'); ?></span>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('/hr/departmentsSub/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.")
                        $("#departments-sub-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("departments-sub-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        //$("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#departments-sub-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#departments-sub-form #"+key+"_em_").show();
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


