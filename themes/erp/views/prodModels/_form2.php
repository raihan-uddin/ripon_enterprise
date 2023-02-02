<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Software', 'url' => array('')),
        array('name' => 'Software Settings', 'url' => array('admin')),
        array('name' => 'Add Product', 'url' => array('admin')),
        array('name' => 'Update: ' . $model->model_name),
    ),
//    'delimiter' => ' &rarr; ',
));
?>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'prod-models-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>


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
            <div class="col-xs-12 col-sm-10 col-lg-10">
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-lg-4" style="">
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

                    <div class="form-group col-xs-12 col-sm-6 col-lg-4" style="">
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
                        <div class="input-group" data-target-input="nearest"><?php
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
            <div class="col-xs-12 col-sm-2 col-lg-2">
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <?= $form->fileField($model, 'image2', ['id' => 'imageUpload', 'accept' => '.png, .jpg, .jpeg']); ?>
                                <label for="imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                <?php
                                $imageUrl = $model->image != "" ? Yii::app()->baseUrl . "/uploads/products/$model->image" : Yii::app()->theme->baseUrl . "/images/no-image.jpg";
                                ?>
                                <div id="imagePreview" style="background-image: url(<?php echo $imageUrl; ?>);">
                                </div>
                            </div>
                            <style>
                                .avatar-upload {
                                    position: relative;
                                    max-width: 205px;
                                    margin: 50px auto;
                                }

                                .avatar-upload .avatar-edit {
                                    position: absolute;
                                    right: 12px;
                                    z-index: 1;
                                    top: 10px;
                                }

                                .avatar-upload .avatar-edit input {
                                    display: none;
                                }

                                .avatar-upload .avatar-edit input + label {
                                    display: inline-block;
                                    width: 34px;
                                    height: 34px;
                                    margin-bottom: 0;
                                    border-radius: 100%;
                                    background: #ffffff;
                                    border: 1px solid transparent;
                                    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                                    cursor: pointer;
                                    font-weight: normal;
                                    transition: all 0.2s ease-in-out;
                                }

                                .avatar-upload .avatar-edit input + label:hover {
                                    background: #f1f1f1;
                                    border-color: #d6d6d6;
                                }

                                .avatar-upload .avatar-edit input + label:after {
                                    content: "\f040";
                                    font-family: "FontAwesome";
                                    color: #757575;
                                    position: absolute;
                                    top: 10px;
                                    left: 0;
                                    right: 0;
                                    text-align: center;
                                    margin: auto;
                                }

                                .avatar-upload .avatar-preview {
                                    width: 192px;
                                    height: 192px;
                                    position: relative;
                                    border-radius: 100%;
                                    border: 6px solid #f8f8f8;
                                    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
                                }

                                .avatar-upload .avatar-preview > div {
                                    width: 100%;
                                    height: 100%;
                                    border-radius: 100%;
                                    background-size: cover;
                                    background-repeat: no-repeat;
                                    background-position: center;
                                }
                            </style>
                            <script>
                                function readURL(input) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();
                                        reader.onload = function (e) {
                                            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                                            $('#imagePreview').hide();
                                            $('#imagePreview').fadeIn(650);
                                        }
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }

                                $("#imageUpload").change(function () {
                                    readURL(this);
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();', 'class' => 'btn btn-primary btn-md')); ?>
        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>

    </div>
</div>
<script type="text/javascript">
    function loadingDivDisplay() {
        $("#ajaxLoaderMRProd").show();
    }
</script>
<?php $this->endWidget(); ?>
