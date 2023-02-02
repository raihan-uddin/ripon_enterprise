<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'bonus-titles-form',
            'action' => $this->createUrl('bonusTitles/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Add New Bonus Head</legend>
        <table>   
            <tr>
                <td><?php echo $form->labelEx($model, 'title'); ?></td>
                <td><?php echo $form->textField($model, 'title', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'title'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'details'); ?></td>
                <td><?php echo $form->textArea($model,'details',array('rows'=>10, 'cols'=>100)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'details'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <div id="ajaxLoader" style="display: none; float: left;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
        <?php
        echo CHtml::ajaxSubmitButton('Add', CHtml::normalizeUrl(array('bonusTitles/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                    $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#bonus-titles-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("bonus-titles-grid", {
		data: $(this).serialize()
	});
                    }else{
                        //$("#formResultError").html("Data not saved. Pleae solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#bonus-titles-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#bonus-titles-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){                        
                $("#ajaxLoader").show();
             }'
        ));
        ?>
    </fieldset>
    <div id="formResult" class="ajaxTargetDiv"></div>
    <div id="formResultError" class="ajaxTargetDivErr"></div>
</div>

<?php $this->endWidget(); ?>
