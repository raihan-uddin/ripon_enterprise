<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'HR', 'url' => array('')),
        array('name' => 'Employees', 'url' => array('')),
        array('name' => 'Create'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'employees-form',
    'action' => $this->createUrl('employees/create'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>
<?php
if (isset($errores))
    print_r($errores);
?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">INFORMATION</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            $this->widget('CTabView', array(
                'tabs' => array(
                    'tab1' => array(
                        'title' => 'Basic',
                        'view' => '_employeeBasic',
                        'data' => array(
                            'model' => $model,
                            'form' => $form,
                        ),
                    ),
                    'tab2' => array(
                        'title' => 'Official',
                        'view' => '_employeeOfficial',
                        'data' => array(
                            'model' => $model,
                            'form' => $form,
                        ),
                    ),
                    'tab7' => array(
                        'title' => 'Photo',
                        'view' => '_employeePhoto',
                        'data' => array(
                            'model' => $model,
                            'form' => $form,
                        ),
                    ),
                ),
            ));
            ?>
        </div>
        <div class="card-footer">
            <?php
            echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('employees/create', 'render' => true)), array(
                'dataType' => 'json',
                'type' => 'post',
                'success' => 'function(data) {
                    if(data.status=="success"){
                        $("#formResult").html("Data saved successfully.");
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
						location.reload();
                    }
                    else{
                        $("#formResultError").html("Data not saved. Please solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#employees-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#employees-form #"+key+"_em_").show();
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
        </div>
    </div>
    <div id="formResult" class="ajaxTargetDiv"></div>
    <div id="formResultError" class="ajaxTargetDivErr"></div>
</div>
<style>
    .yiiTab ul.tabs {
        font: 12px Verdana, sans-serif;
    }

    fieldset {
        border: none;
    }
</style>
<?php $this->endWidget(); ?>
