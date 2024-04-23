<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'prod-brands-form',
    'action' => $this->createUrl('prodBrands/create'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
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
            <div class="form-group col-sm-12 col-md-3" style="">
                <?php echo $form->labelEx($model, 'business_id'); ?>
                <div class="input-group" data-target-input="nearest">
                    <?php
                    echo $form->dropDownList(
                        $model, 'business_id', CHtml::listData(Business::model()->findAll(array('order' => 'display_name ASC')), 'id', 'display_name'), array(
                        'prompt' => 'Select',
                        'class' => 'form-control',
                    ));
                    ?>
                    <div class="input-group-append ">
                        <div class="input-group-text">
                            <?php
                            echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                array(
//                                    'class' => '',
                                    'onclick' => "{
                                            addProdItem(); 
                                            $('#dialogAddProdItem').dialog('open');
                                        }
                                    "));
                            ?>
                            <!--                            </i>-->
                        </div>
                    </div>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'item_id'); ?></span>
            </div>
            <div class="form-group col-sm-12 col-md-3">
                <?php echo $form->labelEx($model, 'display_name'); ?>
                <?php echo $form->textField($model, 'display_name', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'display_name'); ?></span>
            </div>
            <div class="form-group col-sm-12 col-md-3">
                <?php echo $form->labelEx($model, 'phone_number'); ?>
                <?php echo $form->textField($model, 'phone_number', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'phone_number'); ?></span>
            </div>
            <div class="form-group col-sm-12 col-md-3">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php
                echo $form->dropDownList(
                    $model, 'status', CHtml::listData(Branch::model()->statusFilter(), 'id', 'title'), array(
                    'class' => 'form-control',
                ));
                ?>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'status'); ?></span>
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
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('branch/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#prod-brands-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("prod-brands-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                         toastr.error("Data not saved. Please solve the following errors.")
                        $.each(data, function(key, val) {
                            $("#prod-brands-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#prod-brands-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){                        
                $("#ajaxLoader").show();
             }'
        ), array('class' => 'btn btn-primary btn-md'));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddProdItem',
    'options' => array(
        'title' => 'Add Business',
        'autoOpen' => false,
        'modal' => true,
        'width' => 550,
        'resizable' => false,
    ),
));
?>

<div class="divForForm">
    <div class="ajaxLoaderFormLoad" style="display: none;"><img
                src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/></div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    // here is the magic
    function addProdItem() {
        <?php
        echo CHtml::ajax(array(
            'url' => array('business/createBusinessFromOutSide'),
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
                             $('#ProdBrands_item_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
                        }
                }",
        ))
        ?>
        return false;
    }
</script>