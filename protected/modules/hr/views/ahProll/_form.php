<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'ah-proll-form',
            'action' => $this->createUrl('ahProll/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Add New Earning/Deduction Head</legend>
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
                <td><?php echo $form->labelEx($model, 'paygrade_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'paygrade_id', CHtml::listData(PayGrades::model()->findAll(), 'id', 'title'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 167px;'
                    ));
                    ?>
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addCA(); $('#addCADialog').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'addCADialog',
                        'options' => array(
                            'title' => 'Add Pay Grade',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 'auto',
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">                         
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>

                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addCA(){
<?php
echo CHtml::ajax(array(
    'url' => array('payGrades/createPGFromOutSide'),
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
                                            $('#addCADialog div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#addCADialog div.divForForm form').submit(addCA);
                                        }
                                        else
                                        {
                                            $('#addCADialog div.divForForm').html(data.div);
                                            setTimeout(\"$('#addCADialog').dialog('close') \",1000);
                                            $('#AhProll_paygrade_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script> 
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'paygrade_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'ac_type'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'ac_type', Lookup::items('ac_type'), array('prompt' => 'select')); ?>
                </td>    
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'ac_type'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <div id="ajaxLoader" style="display: none; float: left;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
        <?php
        echo CHtml::ajaxSubmitButton('Add', CHtml::normalizeUrl(array('ahProll/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                    $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#ah-proll-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("ah-proll-grid", {
		data: $(this).serialize()
	});
                    }else{
                        //$("#formResultError").html("Data not saved. Pleae solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#ah-proll-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#ah-proll-form #"+key+"_em_").show();
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