<fieldset>
    <legend>Configure Salary (Without Pay Grades)</legend>
    <table style="float: left; width: 415px;"> 
        <tr>
            <td><?php echo $form->labelEx($modelAhAmountProllNormal, 'ah_proll_normal_id'); ?></td>
            <td>
                <?php
                echo $form->dropDownList(
                        $modelAhAmountProllNormal, 'ah_proll_normal_id', CHtml::listData(AhProllNormal::model()->findAll(), 'id', 'title', 'acTypeWithName'), array(
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
                        'title' => 'Add Earning/Deduction Head',
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
    'url' => array('ahProllNormal/createAHPRNFromOutSide'),
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
                                        $('#AhAmounProllNormal_ah_proll_normal_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        $('#AhAmounProllNormal_percentage_of_ah_proll_normal_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
            <td><?php echo $form->error($modelAhAmountProllNormal, 'ah_proll_normal_id'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <?php echo $form->checkBox($modelAhAmountProllNormal, 'isPercentAmount'); ?>
                <label>Set amount in percentage</label>
            </td>
        </tr>
        <tr class="percentageTr">
            <td><?php echo $form->labelEx($modelAhAmountProllNormal, 'percentage_of_ah_proll_normal_id'); ?></td>
            <td>
                <?php echo $form->textField($modelAhAmountProllNormal, 'percentAmount', array('style' => 'width: 45px;')); ?>
                <label>% of</label>
                <?php
                echo $form->dropDownList(
                        $modelAhAmountProllNormal, 'percentage_of_ah_proll_normal_id', CHtml::listData(AhProllNormal::model()->findAll(), 'id', 'title', 'acTypeWithName'), array(
                    'prompt' => 'Select',
                ));
                ?>
                <?php
                echo CHtml::link('', "", // the link for open the dialog
                        array(
                    'id' => 'percentage_of_ah_proll_id_addBtn',
                    'class' => 'add-additional-btn',
                    'onclick' => "{addCA2(); $('#addCADialog2').dialog('open');}"));
                ?>

                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                    'id' => 'addCADialog2',
                    'options' => array(
                        'title' => 'Add Earning/Deduction Head',
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
                    function addCA2(){
<?php
echo CHtml::ajax(array(
    'url' => array('ahProllNormal/createAHPRNFromOutSide'),
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
                                        $('#addCADialog2 div.divForForm').html(data.div);
                                              // Here is the trick: on submit-> once again this function!
                                        $('#addCADialog2 div.divForForm form').submit(addCA2);
                                    }
                                    else
                                    {
                                        $('#addCADialog2 div.divForForm').html(data.div);
                                        setTimeout(\"$('#addCADialog2').dialog('close') \",1000);
                                        $('#AhAmounProllNormal_percentage_of_ah_proll_normal_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        $('#AhAmounProllNormal_ah_proll_normal_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                    }
                                                            }",
))
?>;
        return false; 
    } 
                </script> 
            </td>            
        </tr>
        <tr class="percentageTr">
            <td></td>
            <td><?php echo $form->error($modelAhAmountProllNormal, 'percentage_of_ah_proll_normal_id'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($modelAhAmountProllNormal, 'amount_adj'); ?></td>
            <td><?php echo $form->textField($modelAhAmountProllNormal, 'amount_adj'); ?></td>            
        </tr>
        <tr>
            <td></td>
            <td><?php echo $form->error($modelAhAmountProllNormal, 'amount_adj'); ?></td>
        </tr>
        <tr>
                <td><?php echo $form->labelEx($modelAhAmountProllNormal, 'earn_deduct_type'); ?></td>
                <td><?php echo $form->dropDownList($modelAhAmountProllNormal, 'earn_deduct_type', Lookup::items('earn_deduct_type'), array('prompt'=>'select')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($modelAhAmountProllNormal, 'earn_deduct_type'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><span id="tooltipmsg" style="display: none; color: limegreen;">Amount of daily basis will be multiplied by 30</span></td>
            </tr>
        <tr>
                <td><?php echo $form->labelEx($modelAhAmountProllNormal, 'start_from'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig1 = array(
                        'model' => $modelAhAmountProllNormal, //Model object
                        'attribute' => 'start_from', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'language' => 'en-AU',
                        'options' => array(
                            'changeMonth'=>'true', 
                            'changeYear'=>'true', 
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 181px;'
                        ),
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($modelAhAmountProllNormal, 'start_from'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($modelAhAmountProllNormal, 'end_to'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig2 = array(
                        'model' => $modelAhAmountProllNormal, //Model object
                        'attribute' => 'end_to', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'language' => 'en-AU',
                        'options' => array(
                            'changeMonth'=>'true', 
                            'changeYear'=>'true', 
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 181px;'
                        ),
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($modelAhAmountProllNormal, 'end_to'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($modelAhAmountProllNormal, 'is_active'); ?></td>
                <td><?php echo $form->dropDownList($modelAhAmountProllNormal, 'is_active', Lookup::items('is_active')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($modelAhAmountProllNormal, 'is_active'); ?></td>
            </tr>
    </table>
    <table style="float: left;">
        <tr>
            <td style="vertical-align: top;">
                <input class="addRight" style="margin-top: 0px;" title="Add" type="button" value="" onclick="AddNew()" />
            </td>
            <td style="vertical-align: top;">
                <div style="width: 700px; float: left; overflow: scroll; height: 236px; border: 1px solid #d2d2d2;" class="someStyle">
                    <table id="tbl" class="prodAddedTab">
                        <tr>
                            <th style="width: 10px;">SL</th>
                            <th style="width: 45px;">TYPE</th>
                            <th>HEAD</th>
                            <th style="width: 20px;">AMOUNT</th>
                            <th style="width: 52px;">BASIS</th>
                            <th style="width: 52px;">STATUS</th>
                            <th style="width: 32px;">ACTION</th>
                        </tr>
                    </table>
                </div>
            </td> 
        </tr>
        <tr>
            <td><span class="calculateTotal" title="Click to calculate...">Total</span></td>
            <td><input placeholder="Click total to calculate..." type="text" id="earnDeductTotal" class="grandTotal"/></td>
        </tr>
    </table>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".calculateTotal").click(function(){
                var totalSalary=0;
               
                $( "input.earnDeductAmountAdj" ).each(function( index ) {
                    
                    if($( this ).attr("optnGroup")=="Earn"){ // earnings
                        if($( this ).attr("basis")==79){ // monthly basis
                            totalSalary=totalSalary+parseFloat($( this ).val());
                        }else{ // daily basis
                            totalSalary=totalSalary+(parseFloat($( this ).val())*30);
                        }
                    }else{ // deductions
                        if($( this ).attr("basis")==79){ // monthly basis
                            totalSalary=totalSalary-parseFloat($( this ).val());
                        }else{ // daily basis
                            totalSalary=totalSalary-(parseFloat($( this ).val())*30);
                        }
                    }
                });
                $("#earnDeductTotal").val(totalSalary);
            });
            
            $("#AhAmounProllNormal_earn_deduct_type").change(function(){
                if($(this).val()==80){ // daily basis
                    $('#tooltipmsg').show();
                }else{ // daily basis
                    $('#tooltipmsg').hide();
                }
            })
            
            $(".percentageTr").hide(); 
    
            $("#AhAmounProllNormal_isPercentAmount").change(function(){
                if($(this).is(':checked')){
                    $("#AhAmounProllNormal_amount_adj").focus(function(){
                        $(this).blur();         
                    }); 
                    $("#AhAmounProllNormal_amount_adj").css("cursor", "no-drop");
                    $(".percentageTr").show();
                    $("#AhAmounProllNormal_amount_adj").val("");
                    $("#AhAmounProllNormal_percentAmount").focus();
                }else{
                    $("#AhAmounProllNormal_amount_adj").focus();
                    $("#AhAmounProllNormal_amount_adj").val("");
                    $("#AhAmounProllNormal_amount_adj").css("cursor", "default");
                    $(".percentageTr").hide();
                    $("#AhAmounProllNormal_percentAmount").val("");
                    $("#AhAmounProllNormal_percentage_of_ah_proll_normal_id").val("");
                }
            });
            var forPercentage;
            var forPercentage2;
            var forPercentage3;
            var forPercentage4;
            $("#AhAmounProllNormal_percentage_of_ah_proll_normal_id").change(function(){
                forPercentage=$(this).val();
                forPercentage2=$("#forPercentage_"+forPercentage).attr("attrValu");
                forPercentage3=$("#AhAmounProllNormal_percentAmount").val();
                
                forPercentage4=(parseFloat(forPercentage2)*(parseFloat(forPercentage3)/100));
                $("#AhAmounProllNormal_amount_adj").val(forPercentage4);
            });
        });
        
        // =================================
        var sl=0;
        var newArr=new Array();
        
        function calFnc(count){ 
       
        $('#earnDeductAmountAdj'+count).bind('keyup', function() {
            $("#earnDeductTotal").val(0);
        }); 
    }
        
        function AddNew() {
            $("#earnDeductTotal").val(0);
            if($("#AhAmounProllNormal_ah_proll_normal_id").val()==""){
                alertify.alert("Please select a head!");
                $("#AhAmounProllNormal_ah_proll_normal_id").css("border-color", "red");
            }else if($("#AhAmounProllNormal_amount_adj").val()==""){
                alertify.alert("Please set amount adjust!");
                $("#AhAmounProllNormal_amount_adj").css("border-color", "red");
            }else if($("#AhAmounProllNormal_earn_deduct_type").val()==""){
                alertify.alert("Please select basis!");
                $("#AhAmounProllNormal_earn_deduct_type").css("border-color", "red");
            }else{
                $("#AhAmounProllNormal_ah_proll_normal_id").css("border-color", "#aaa");
                $("#AhAmounProllNormal_amount_adj").css("border-color", "#aaa");
                $("#AhAmounProllNormal_earn_deduct_type").css("border-color", "#aaa");
                if($.inArray($("#AhAmounProllNormal_ah_proll_normal_id").val(), newArr) > -1){
                    alertify.alert("Already added!");
                }else{
                    add();
                    newArr[sl]=$("#AhAmounProllNormal_ah_proll_normal_id").val();
                }  
            }        
        } 
        
        function add(){
            sl++;
            var slNumber=$('#tbl tr').length;
            var appendTxt = "<tr class='cartList'><td class='sno'>"+
                "<input type='hidden' name='AhAmounProllNormal[temp_percentage_of_ah_proll_normal_id][]' value='"+$("#AhAmounProllNormal_percentage_of_ah_proll_normal_id").val()+"'>"+
                "<input type='hidden' name='AhAmounProllNormal[temp_ah_proll_normal_id][]' value='"+$("#AhAmounProllNormal_ah_proll_normal_id").val()+"'>"+
                "<input type='hidden' name='AhAmounProllNormal[temp_amount_adj][]' value='"+$("#AhAmounProllNormal_amount_adj").val()+"'>"+
                "<input type='hidden' name='AhAmounProllNormal[temp_start_from][]' value='"+$("#AhAmounProllNormal_start_from").val()+"'>"+
                "<input type='hidden' name='AhAmounProllNormal[temp_end_to][]' value='"+$("#AhAmounProllNormal_end_to").val()+"'>"+
                "<input type='hidden' name='AhAmounProllNormal[temp_is_active][]' value='"+$("#AhAmounProllNormal_is_active").val()+"'>"+
                "<input type='hidden' name='AhAmounProllNormal[temp_earn_deduct_type][]' value='"+$("#AhAmounProllNormal_earn_deduct_type").val()+"'>"+
                "<span id='forPercentage_"+$("#AhAmounProllNormal_ah_proll_normal_id option:selected").val()+"' attrValu='"+$("#AhAmounProllNormal_amount_adj").val()+"'></span>"+
                slNumber +
                "</td>" + 
                "<td style='text-align: left;'>"+$("#AhAmounProllNormal_ah_proll_normal_id option:selected").closest('optgroup').prop('label')+"</td>"+
                "<td style='text-align: left;'>"+$("#AhAmounProllNormal_ah_proll_normal_id option:selected").text()+"</td>"+
                "<td style='text-align: left;'><input class='earnDeductAmountAdj' basis='"+$("#AhAmounProllNormal_earn_deduct_type").val()+"' optnGroup='"+$("#AhAmounProllNormal_ah_proll_normal_id option:selected").closest('optgroup').prop('label')+"' id='earnDeductAmountAdj"+sl+"' type='text' name='AhAmounProllNormal[temp_amount_adj]' value='"+$("#AhAmounProllNormal_amount_adj").val()+"'></td>"+
                "<td>"+$("#AhAmounProllNormal_earn_deduct_type option:selected").text()+"</td>"+
                "<td>"+$("#AhAmounProllNormal_is_active option:selected").text()+"</td>"+
                "<td><input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/></td></tr>";
            $("#tbl tr:last").after(appendTxt);
            calFnc(sl);
        }
    
        $("#tbl td input.dltBtn").on("click", function () {
            $("#earnDeductTotal").val(0);
            var idCounter=$(this).attr("id");
            var srow = $(this).parent().parent();
            srow.remove();
            $("#tbl td.sno").each(function(index, element){                 
                $(element).text(index + 1); 
            });
            newArr[idCounter]=0;
        });
    </script>
    <style>
        span.calculateTotal{
            float: left;
            padding: 12px;
            border: 2px solid #3a60af;
            border-radius: 2px;
            color: #FFFFFF;
            background-color: #3499ff;
        }
        span.calculateTotal:active{
            position:relative;
            top:1px;
        }
    </style>
</fieldset>