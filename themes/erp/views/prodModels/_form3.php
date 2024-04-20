<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'prod-models-form',
));
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New Material Info' : 'Update Material Info'); ?></h3>

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

            <div class="form-group col-xs-12 col-sm-6 col-lg-4" style="">
                <?php echo $form->labelEx($model, 'item_id'); ?>
                <?php
                echo $form->dropDownList(
                    $model, 'item_id', CHtml::listData(ProdItems::model()->findAll(array('order' => 'item_name ASC')), 'id', 'item_name'), array(
                    'prompt' => 'Select',
                    'class' => 'form-control',
                    'ajax' => array(
                        'type' => 'POST',
                        'dataType' => 'json',
                        'url' => CController::createUrl('prodModels/subCatOfThisCat'),
                        'success' => 'function(data) {
                                    $("#ProdModels_brand_id").html(data.subCatList);
                             }',
                        'data' => array(
                            'catId' => 'js:jQuery("#ProdModels_item_id").val()',
                        ),
                        'beforeSend' => 'function(){
                                    document.getElementById("ProdModels_brand_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 80% 1px";   
                         }',
                        'complete' => 'function(){
                            document.getElementById("ProdModels_brand_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/downDrop.png) no-repeat #FFFFFF 98% 2px"; 
                        }',
                    ),
                ));
                ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'item_id'); ?></span>
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-lg-4" style="">
                <?php echo $form->labelEx($model, 'brand_id'); ?>
                <?php
                echo $form->dropDownList(
                    $model, 'brand_id', CHtml::listData(ProdBrands::model()->findAll(array('order' => 'brand_name ASC')), 'id', 'brand_name'), array(
                    'prompt' => 'Select',
                    'class' => 'form-control',
                ));
                ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'brand_id'); ?></span>
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'model_name'); ?>
                <?php echo $form->textField($model, 'model_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'model_name'); ?></span>
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'code'); ?>
                <?php echo $form->textField($model, 'code', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'code'); ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-6 col-lg-4" style="">
                <?php echo $form->labelEx($model, 'unit_id'); ?>
                <?php
                echo $form->dropDownList(
                    $model, 'unit_id', CHtml::listData(Units::model()->findAll(array('order' => 'label ASC')), 'id', 'label'), array(
                    'prompt' => 'Select',
                    'class' => 'form-control',
                ));
                ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'unit_id'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'manufacturer_id'); ?>
                <?php
                echo $form->dropDownList(
                    $model, 'manufacturer_id', CHtml::listData(Company::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                    'prompt' => 'Select',
                    'class' => 'form-control',
                ));
                ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'stockable'); ?></span>
            </div>


            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php
                echo $form->dropDownList(
                    $model, 'status', [1 => 'ACTIVE', 0 => 'INACTIVE'], array(
                    'class' => 'form-control',
                ));
                ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'status'); ?></span>
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'min_order_qty'); ?>
                <?php echo $form->textField($model, 'min_order_qty', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'min_order_qty'); ?></span>
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php echo $form->textArea($model, 'description', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'description'); ?></span>
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
