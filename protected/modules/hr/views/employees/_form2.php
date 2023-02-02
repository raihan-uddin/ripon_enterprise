<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'HR', 'url' => array('')),
        array('name' => 'Employees', 'url' => array('')),
        array('name' => 'Update'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'employees-form',
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
                    /*
                   'tab3' => array(
                       'title' => 'Skills',
                       'view' => '_employeeSkills',
                       'data' => array(
                           'model' => $model,
                           'form' => $form,
                       ),
                   ),
                   'tab4' => array(
                       'title' => 'Academic',
                       'view' => '_employeeAcademic',
                       'data' => array(
                           'model' => $model,
                           'form' => $form,
                       ),
                   ),
                   /*'tab5' => array(
                       'title' => 'Earn & Deduct',
                       'view' => '_earnDeductNormal',
                       'data' => array(
                           'modelAhAmountProllNormal' => $modelAhAmountProllNormal,
                           'form' => $form,
                       ),
                   ),
                   'tab6' => array(
                       'title' => 'Leaves',
                       'view' => '_leaveNormal',
                       'data' => array(
                           'modelLhAmountProllNormal'=>$modelLhAmountProllNormal,
                           'form' => $form,
                       ),
                   ),*/
                    'tab7' => array(
                        'title' => 'Photo',
                        'view' => '_employeePhoto',
                        'data' => array(
                            'model' => $model,
                            'form' => $form,
                        ),
                    ),
                    /*
                    'tab8' => array(
                        'title' => 'Files',
                        'view' => '_employeeFiles',
                        'data' => array(
                            'model'=>$model,
                            'form' => $form,
                        ),
                    ),*/
                ),
            ));
            echo $form->errorSummary($model);
            ?>

        </div>
        <div class="card-footer">
        <span id="ajaxLoaderMR" style="display: none;"><img
                    src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/></span>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();', 'class' => 'btn btn-success')); ?>
            <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>
        </div>
    </div>
    <div id="formResult" class="ajaxTargetDiv"></div>
    <div id="formResultError" class="ajaxTargetDivErr"></div>
</div>
<script type="text/javascript">
    function loadingDivDisplay() {
        $("#ajaxLoaderMR").show();
    }
</script>
<style>
    span.heighlightSpan {
        padding: 0px;
    }
</style>
<?php $this->endWidget(); ?>
