<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'prod-brands-form',
            'action' => $this->createUrl('prodBrands/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>


<div id="formResult" class="ajaxTargetDiv">

</div>
<div id="formResultError" class="ajaxTargetDivErr">

</div>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Sub-Category' : 'Update Sub-Category'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'item_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'item_id', CHtml::listData(ProdItems::model()->findAll(array('order' => 'item_name ASC')), 'id', 'item_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                     <?php
                        echo CHtml::link('', "", // the link for open the dialog
                                array(
                            'class' => 'add-additional-btn',
                            'onclick' => "{addProdItem(); $('#dialogAddProdItem').dialog('open');}"));
                        ?>

                        <?php
                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                            'id' => 'dialogAddProdItem',
                            'options' => array(
                                'title' => 'Add Category',
                                'autoOpen' => false,
                                'modal' => true,
                                'width' => 550,
                                'resizable' => false,
                            ),
                        ));
                        ?>
                        <div class="divForForm">

                        </div>

                        <?php $this->endWidget(); ?>

                        <script type="text/javascript">
                            // here is the magic
                            function addProdItem(){
<?php
echo CHtml::ajax(array(
    'url' => array('prodItems/createProdItemsFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
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
                                                $('#ProdBrands_item_id').append('<option value='+data.value+'>'+data.label+'</option>');
                                            }
                                                                    }",
))
                                ?>
                                return false;
                            }
                        </script>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'item_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'brand_name'); ?></td>
                <td><?php echo $form->textField($model, 'brand_name', array('maxlength' => 255)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'brand_name'); ?></td>
            </tr>
        </table>
        <div id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
    </fieldset>

    <fieldset class="tblFooters">
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('prodBrands/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#prod-brands-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("prod-brands-grid", {
		data: $(this).serialize()
	});
                    }else{
                        //$("#formResultError").html("Data not saved. Pleae solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#prod-brands-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#prod-brands-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){                        
                $("#ajaxLoader").show();
             }'
        ));
        ?>
    </fieldset>
</div>

<?php $this->endWidget(); ?>
