<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'working-day-form',
            'action' => $this->createUrl('workingDay/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Add New Working Day Info</legend>
        <table> 
            <tr>
                <td><?php echo $form->labelEx($model, 'year'); ?></td>
                <td><?php echo $form->textField($model, 'year', array('maxlength' => 4)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'year'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'month_id'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'month_id', CHtml::listData(Months::model()->findAll(), "id", "month_name"), array(
                        'prompt' => 'Select',
                    )); ?>
                </td>    
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'month_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'days_of_month'); ?></td>
                <td><?php echo $form->textField($model, 'days_of_month', array('maxlength' => 2)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'days_of_month'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'working_day'); ?></td>
                <td><?php echo $form->textField($model, 'working_day'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'working_day'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'working_hour_per_day'); ?></td>
                <td><?php echo $form->textField($model, 'working_hour_per_day'); ?></td>       
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'working_hour_per_day'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <div id="ajaxLoader" style="display: none; float: left;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
        <?php
        echo CHtml::ajaxSubmitButton('Add', CHtml::normalizeUrl(array('workingDay/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                    $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#working-day-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("working-day-grid", {
		data: $(this).serialize()
	});
                    }else{
                        //$("#formResultError").html("Data not saved. Pleae solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#working-day-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#working-day-form #"+key+"_em_").show();
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
