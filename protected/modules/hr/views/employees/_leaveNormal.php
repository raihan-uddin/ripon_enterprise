<fieldset>
    <legend>Configure Leaves</legend>
    <table style="float: left; width: 415px;">
        <tr>
            <td><?php echo $form->labelEx($modelLhAmountProllNormal, 'lh_proll_normal_id'); ?></td>
            <td>
                <?php
                echo $form->dropDownList(
                    $modelLhAmountProllNormal, 'lh_proll_normal_id', CHtml::listData(LhProllNormal::model()->findAll(), 'id', 'title'), array(
                    'prompt' => 'Select',
                ));
                ?>
                <?php
                echo CHtml::link('', "", // the link for open the dialog
                    array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addCALhpn(); $('#addCADialogLhpn').dialog('open');}"));
                ?>

                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                    'id' => 'addCADialogLhpn',
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
                    <div class="ajaxLoaderFormLoad" style="display: none;"><img
                                src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/></div>

                </div>

                <?php $this->endWidget(); ?>

                <script type="text/javascript">
                    // here is the magic
                    function addCALhpn() {
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
                                            $('#addCADialogLhpn div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#addCADialogLhpn div.divForForm form').submit(addCALhpn);
                                        }
                                        else
                                        {
                                            $('#addCADialogLhpn div.divForForm').html(data.div);
                                            setTimeout(\"$('#addCADialogLhpn').dialog('close') \",1000);
                                            $('#LhAmountProllNormal_lh_proll_normal_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
            <td><?php echo $form->error($modelLhAmountProllNormal, 'lh_proll_normal_id'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($modelLhAmountProllNormal, 'day'); ?></td>
            <td><?php echo $form->textField($modelLhAmountProllNormal, 'day'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $form->error($modelLhAmountProllNormal, 'day'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($modelLhAmountProllNormal, 'hour'); ?></td>
            <td><?php echo $form->textField($modelLhAmountProllNormal, 'hour'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $form->error($modelLhAmountProllNormal, 'hour'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($modelLhAmountProllNormal, 'start_from'); ?></td>
            <td>
                <?php
                Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                $dateTimePickerConfig3 = array(
                    'model' => $modelLhAmountProllNormal, //Model object
                    'attribute' => 'start_from', //attribute name
                    'mode' => 'date', //use "time","date" or "datetime" (default)
                    'language' => 'en-AU',
                    'options' => array(
                        'changeMonth' => 'true',
                        'changeYear' => 'true',
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 181px;'
                    ),
                );
                $this->widget('CJuiDateTimePicker', $dateTimePickerConfig3);
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $form->error($modelLhAmountProllNormal, 'start_from'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($modelLhAmountProllNormal, 'is_active'); ?></td>
            <td><?php echo $form->dropDownList($modelLhAmountProllNormal, 'is_active', Lookup::items('is_active')); ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $form->error($modelLhAmountProllNormal, 'is_active'); ?></td>
        </tr>
    </table>
    <table style="float: left;">
        <tr>
            <td style="vertical-align: top;">
                <input class="addRight" style="margin-top: 0px;" title="Add" type="button" value=""
                       onclick="AddNewEmpLhNormal()"/>
            </td>
            <td style="vertical-align: top;" colspan="2">
                <div style="width: 700px; float: left; overflow: scroll; height: 236px; border: 1px solid #d2d2d2;"
                     class="someStyle">
                    <table id="tblLeave" class="prodAddedTab">
                        <tr>
                            <th style="width: 10px;">SL</th>
                            <th>HEAD</th>
                            <th style="width: 20px;">DAY</th>
                            <th style="width: 20px;">HOUR</th>
                            <th style="width: 32px;">STATUS</th>
                            <th style="width: 32px;">ACTION</th>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</fieldset>
<script type="text/javascript">
    $(document).ready(function () {
        var dayOrHr;
        $('#LhAmountProllNormal_day').bind('keyup', function () {
            dayOrHr = $(this).val() * 24;
            $('#LhAmountProllNormal_hour').val(dayOrHr);
        });
        $('#LhAmountProllNormal_hour').bind('keyup', function () {
            dayOrHr = $(this).val() / 24;
            $('#LhAmountProllNormal_day').val(dayOrHr);
        });
    });
    var slLeave = 0;
    var newArrLeave = [];

    function AddNewEmpLhNormal() {
        if ($("#LhAmountProllNormal_lh_proll_normal_id").val() == "") {
            alertify.alert("Please select a head!");
            $("#LhAmountProllNormal_lh_proll_normal_id").css("border-color", "red");
        } else if ($("#LhAmountProllNormal_day").val() == "") {
            alertify.alert("Please set day!");
            $("#LhAmountProllNormal_day").css("border-color", "red");
        } else if ($("#LhAmountProllNormal_hour").val() == "") {
            alertify.alert("Please set hour!");
            $("#LhAmountProllNormal_hour").css("border-color", "red");
        } else {
            $("#LhAmountProllNormal_lh_proll_normal_id").css("border-color", "#aaa");
            $("#LhAmountProllNormal_day").css("border-color", "#aaa");
            $("#LhAmountProllNormal_hour").css("border-color", "#aaa");
            if ($.inArray($("#LhAmountProllNormal_lh_proll_normal_id").val(), newArrLeave) > -1) {
                alertify.alert("Already added!");
            } else {
                addEmpLhNormal();
                newArrLeave[slLeave] = $("#LhAmountProllNormal_lh_proll_normal_id").val();
            }
        }
    }

    function addEmpLhNormal() {
        slLeave++;
        var slNumberLeave = $('#tblLeave tr').length;
        var appendTxtLeave = "<tr class='cartList'><td class='sno'>" +
            "<input type='hidden' name='LhAmountProllNormal[temp_lh_proll_normal_id][]' value='" + $("#LhAmountProllNormal_lh_proll_normal_id").val() + "'>" +
            "<input type='hidden' name='LhAmountProllNormal[temp_day][]' value='" + $("#LhAmountProllNormal_day").val() + "'>" +
            "<input type='hidden' name='LhAmountProllNormal[temp_hour][]' value='" + $("#LhAmountProllNormal_hour").val() + "'>" +
            "<input type='hidden' name='LhAmountProllNormal[temp_start_from][]' value='" + $("#LhAmountProllNormal_start_from").val() + "'>" +
            "<input type='hidden' name='LhAmountProllNormal[temp_end_to][]' value='" + $("#LhAmountProllNormal_end_to").val() + "'>" +
            "<input type='hidden' name='LhAmountProllNormal[temp_is_active][]' value='" + $("#LhAmountProllNormal_is_active").val() + "'>" +
            slNumberLeave +
            "</td>" +
            "<td style='text-align: left;'>" + $("#LhAmountProllNormal_lh_proll_normal_id option:selected").text() + "</td>" +
            "<td>" + $("#LhAmountProllNormal_day").val() + "</td>" +
            "<td>" + $("#LhAmountProllNormal_hour").val() + "</td>" +
            "<td>" + $("#LhAmountProllNormal_is_active option:selected").text() + "</td>" +
            "<td><input title=\"remove\" id='" + slLeave + "' type=\"button\" class=\"rdelete dltBtn\"/></td></tr>";
        $("#tblLeave tr:last").after(appendTxtLeave);

    }

    $("#tblLeave td input.dltBtn").on("click", function () {
        var idCounterLeave = $(this).attr("id");
        var srowLeave = $(this).parent().parent();
        srowLeave.remove();
        $("#tblLeave td.sno").each(function (index, element) {
            $(element).text(index + 1);
        });
        newArrLeave[idCounterLeave] = 0;
    });
</script>