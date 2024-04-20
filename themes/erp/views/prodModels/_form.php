<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Inventory', 'url' => array('')),
        array('name' => 'Config', 'url' => array('admin')),
        array('name' => 'Product Setup', 'url' => array('admin')),
        array('name' => 'Add Product'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'prod-models-form',
    'action' => $this->createUrl('prodModels/create'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
    'stateful' => true,
    'htmlOptions' => ['enctype' => 'multipart/form-data'],
));
?>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<div id="formResult" class="ajaxTargetDiv">
</div>
<div id="formResultError" class="ajaxTargetDivErr">
</div>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>


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

            <div class="form-group col-sm-12 col-md-6 col-lg-4" style="">
                <?php echo $form->labelEx($model, 'item_id'); ?>
                <div class="input-group" data-target-input="nearest"><?php
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
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <?php
                            echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                array(
//                                    'class' => '',
                                    'onclick' => "{addProdItem(); $('#dialogAddProdItem').dialog('open');}"));
                            ?>

                            <?php
                            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                'id' => 'dialogAddProdItem',
                                'options' => array(
                                    'title' => 'Add Product Category',
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
                                function addProdItem() {
                                    <?php
                                    echo CHtml::ajax(array(
                                        'url' => array('prodItems/createProdItemsFromOutSide'),
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
                                            $('#dialogAddProdItem div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogAddProdItem div.divForForm form').submit(addProdItem);
                                        }
                                        else
                                        {
                                            $('#dialogAddProdItem div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogAddProdItem').dialog('close') \",1000);
                                            $('#ProdModels_item_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'item_id'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-6 col-lg-4" style="">
                <?php echo $form->labelEx($model, 'brand_id'); ?>
                <div class="input-group" data-target-input="nearest"><?php
                    echo $form->dropDownList(
                        $model, 'brand_id', CHtml::listData(ProdBrands::model()->findAll(array('order' => 'brand_name ASC')), 'id', 'brand_name'), array(
                        'prompt' => 'Select',
                        'class' => 'form-control',
                    ));
                    ?>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <?php
                            echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                array(
//                                    'class' => '',
                                    'onclick' => "{addProdBrand(); $('#dialogAddProdBrand').dialog('open');}"));
                            ?>

                            <?php
                            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                'id' => 'dialogAddProdBrand',
                                'options' => array(
                                    'title' => 'Add Product Type',
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
                                function addProdBrand() {
                                    <?php
                                    echo CHtml::ajax(array(
                                        'url' => array('prodBrands/createProdBrandsFromOutSide'),
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
                                            $('#dialogAddProdBrand div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogAddProdBrand div.divForForm form').submit(addProdBrand);
                                        }
                                        else
                                        {
                                            $('#dialogAddProdBrand div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogAddProdBrand').dialog('close') \",1000);
                                            $('#ProdModels_brand_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'brand_id'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'model_name'); ?>
                <?php echo $form->textField($model, 'model_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'model_name'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'code'); ?>
                <?php echo $form->textField($model, 'code', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'code'); ?></span>
            </div>
            <div class="form-group col-sm-12 col-md-6 col-lg-4" style="">
                <?php echo $form->labelEx($model, 'unit_id'); ?>
                <div class="input-group" data-target-input="nearest">
                    <?php
                    echo $form->dropDownList(
                        $model, 'unit_id', CHtml::listData(Units::model()->findAll(array('order' => 'label ASC')), 'id', 'label'), array(
                        'prompt' => 'Select',
                        'class' => 'form-control',
                    ));
                    ?>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <?php
                            echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                array(
//                                    'class' => '',
                                    'onclick' => "{addUnit(); $('#dialogAddUnit').dialog('open');}"));
                            ?>
                            <?php
                            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                'id' => 'dialogAddUnit',
                                'options' => array(
                                    'title' => 'Add Unit',
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
                                function addUnit() {
                                    <?php
                                    echo CHtml::ajax(array(
                                        'url' => array('units/createUnitFromOutSide'),
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
                                            $('#dialogAddUnit div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogAddUnit div.divForForm form').submit(addUnit);
                                        }
                                        else
                                        {
                                            $('#dialogAddUnit div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogAddUnit').dialog('close') \",1000);
                                            $('#ProdModels_unit_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'unit_id'); ?></span>
            </div>


            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'min_order_qty'); ?>
                <?php echo $form->textField($model, 'min_order_qty', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'min_order_qty'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'sell_price'); ?>
                <?php echo $form->textField($model, 'sell_price', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'sell_price'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'purchase_price'); ?>
                <?php echo $form->textField($model, 'purchase_price', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'purchase_price'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'image'); ?>
                <div class="custom-file">
                    <?= $form->fileField($model, 'image2', ['id' => 'customFile', 'accept' => '.png, .jpg, .jpeg', 'class' => 'custom-file-input']); ?>
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'image2'); ?></span>
            </div>


            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php echo $form->textArea($model, 'description', array('maxlength' => 255, 'class' => 'form-control', 'style' => 'height: 200px;')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'description'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?php echo $form->labelEx($model, 'stockable'); ?>
                <?php
                echo $form->dropDownList(
                    $model, 'stockable', [1 => 'YES', 0 => 'NO'], array(
                    'prompt' => 'Select',
                    'class' => 'form-control',
                ));
                ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'stockable'); ?></span>
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
        </div>
    </div>
    <div class="card-footer">
        <div id="ajaxLoader" style="display: none; float: left;"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
        <?php
        /*
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('prodModels/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        toastr.success("Data saved successfully.")
                        $("#prod-models-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                    }else{
                        toastr.error("Please fix following errors.")
                        $.each(data, function(key, val) {
                            $("#prod-models-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#prod-models-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){                        
                $("#ajaxLoader").show();
             }'
        ), array('class' => 'btn btn-primary btn-md'));
        */
        ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();', 'class' => 'btn btn-primary btn-md')); ?>
        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>

    </div>
</div>

<?php $this->endWidget(); ?>
<script>
    $(function () {
        bsCustomFileInput.init();
    });


    function loadingDivDisplay() {
        $("#ajaxLoaderMRProd").show();
    }
</script>