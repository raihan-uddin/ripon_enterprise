<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'lh-amount-proll-normal-form',
            'action' => $this->createUrl('lhAmountProllNormal/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Add New Leave to Employees</legend>
        <table cellpadding="2">   
            <tr>
                <td style="width: 35%"><?php echo $form->labelEx($model, 'employee_id'); ?></td>
                <td>
                	<input type="text" id="employee_id_text"/>
                 	<?php echo $form->hiddenField($model, 'employee_id'); ?>
                    <?php
					$empInfoArry = '';
					$empInfos = Employees::model()->findAll(array('order' => 'full_name ASC'));
					if ($empInfos) {
						$empcount = count($empInfos);
						$i = 1;
						foreach ($empInfos as $empInfo) {
							$value = $empInfo->id;
							$label = CHtml::encode($empInfo->full_name .' (' .$empInfo->emp_id_no. ')');
							
							$designation_id = $empInfo->designation_id;
							$designation_name = Designations::model()->infoOfThis($designation_id);
							$department_id = $empInfo->department_id;
							$department_name = Departments::model()->nameOfThis($department_id);
							$joinDate = $empInfo->permanent_date;
							
							$empInfoArry.='{value: ' . $value . ', label: "' . $label . '", dgname: "' . $designation_name . '", dpname: "' . $department_name . '", jdate: "' . $joinDate . '"}';
							if ($i == $empcount)
								$empInfoArry.='';
							else
								$empInfoArry.=',';
							$i++;
						}
					}
					?>
					<script>
                        var empInfoArry = [<?php echo $empInfoArry; ?>];
                        $(function () {
                            $( "#employee_id_text" ).autocomplete({
                                source: empInfoArry,
                                minLength: 2,
                                select: function(event, ui) {
                                    $("#employee_id_text").val(ui.item.label);
                                    $("#LhAmountProllNormal_employee_id").val(ui.item.value);
                                    
									$("#LhAmountProllNormal_designation_id").val(ui.item.dgname);
                                    $("#LhAmountProllNormal_department_id").val(ui.item.dpname);
                                    $("#LhAmountProllNormal_start_from").val(ui.item.jdate);
									
                                    return false;
                                }
                            });
                        });
                    </script>
                </td>
         	</tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'employee_id'); ?></td>
            </tr>
          	<tr>
                <td><?php echo $form->labelEx($model, 'designation_id'); ?></td>
                <td><?php echo $form->textField($model, 'designation_id', array('maxlength' => 255, 'readonly'=>'true')); ?></td>
         	</tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'department_id'); ?></td>
                <td><?php echo $form->textField($model, 'department_id', array('maxlength' => 255, 'readonly'=>'true')); ?></td>            
         	</tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'start_from'); ?></td>
                <td><?php echo $form->textField($model, 'start_from', array('maxlength' => 255, 'readonly'=>'true')); ?></td>           
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'lh_proll_normal_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'lh_proll_normal_id', CHtml::listData(LhProllNormal::model()->findAll(), 'id', 'title'), array(
                        'prompt' => 'Select',
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
                            'title' => 'Add Leave Head',
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
    'url' => array('lhProllNormal/createLHPRNFromOutSide'),
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
                                            $('#LhAmountProllNormal_lh_proll_normal_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
                <td><?php echo $form->error($model, 'lh_proll_normal_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'day'); ?></td>
                <td><?php echo $form->textField($model, 'day'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'day'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_active'); ?></td>
                <td><?php echo $form->dropDownList($model, 'is_active', Lookup::items('is_active')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_active'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <div id="ajaxLoader" style="display: none; float: left;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
        <?php
        echo CHtml::ajaxSubmitButton('Add', CHtml::normalizeUrl(array('lhAmountProllNormal/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                    $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#lh-amount-proll-normal-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("lh-amount-proll-normal-grid", {
                            data: $(this).serialize()
                    });
                    }else{
                        //$("#formResultError").html("Data not saved. Pleae solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#lh-amount-proll-normal-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#lh-amount-proll-normal-form #"+key+"_em_").show();
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
<script type="text/javascript">
    /*$(document).ready(function(){
        var dayOrHr;
        $('#LhAmountProllNormal_day').bind('keyup', function() {
            dayOrHr =$(this).val()*24;
            $('#LhAmountProllNormal_hour').val(dayOrHr);
        });
        $('#LhAmountProllNormal_hour').bind('keyup', function() {
            dayOrHr=$(this).val()/24;
            $('#LhAmountProllNormal_day').val(dayOrHr);
        });
    });*/
</script>
<?php $this->endWidget(); ?>
