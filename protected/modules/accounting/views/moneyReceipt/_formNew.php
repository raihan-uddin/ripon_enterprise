<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Collection', 'url' => array('admin')),
        array('name' => 'Create (New)'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'money-receipt-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
)); ?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>
<div class="row">
    <div class="form-group col-xs-11 col-md-3 col-lg-3">
        <a class="btn  btn-warning" type="button" id="btnReload"
           href="<?= Yii::app()->request->requestUri ?>"><i class="fa fa-refresh"></i> Reload
        </a>
<!--        <button class="btn  btn-danger" type="button" id="btnReset"><i class="fa fa-remove"></i> Reset-->
<!--        </button>-->

        <a class="btn btn-success text-right" type="button"
           href="<?= Yii::app()->baseUrl . '/index.php/accounting/moneyReceipt/admin' ?>"><i class="fa fa-home"></i>
            MR Manage
        </a>
    </div>
</div>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create MoneyReceipt' : 'Update MoneyReceipt'); ?></h3>

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

            <div class="col-md-12">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'customer_id', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="customer_id" data-target-input="nearest">
                            <?php echo $form->textField($model, 'customer_name', array('class' => 'form-control', 'readonly' => true, 'value' => $model2->company_name)); ?>
                            <?php echo $form->hiddenField($model, 'customer_id', array('class' => 'form-control', 'readonly' => true, 'value' => $model2->id)); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                        </div>
                        <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'customer_id'); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'received_by', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="customer_id" data-target-input="nearest">
                            <?php echo $form->textField($model, 'received_by', array('class' => 'form-control', 'readonly' => true, 'value' => Users::model()->nameOfThis(Yii::app()->user->getState('user_id')))); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                        </div>
                        <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'customer_id'); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'date', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="entry_date" data-target-input="nearest">
                            <?php echo $form->textField($model, 'date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'date'); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'payment_type', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="customer_id" data-target-input="nearest">
                            <?php
                            echo $form->dropDownList($model, 'payment_type', CHtml::listData(MoneyReceipt::model()->paymentTypeFilter(), 'id', 'title'), array(
                                'prompt' => 'Select',
                                'class' => 'form-control',
                            ));
                            ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa fa-credit-card"></i></div>
                            </div>
                        </div>
                        <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'payment_type'); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-12  bank online" style="display: none;" >
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'bank_id', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="bank_id" data-target-input="nearest">
                            <?php
                                echo $form->dropDownList(
                                    $model, 'bank_id', CHtml::listData(CrmBank::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                    'prompt' => 'Select Bank',
                                    'class' => 'form-control',
                                ));
                            ?>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <?php
                            echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                array(
                                    'onclick' => "{
                                            addProdItem(); 
                                            $('#dialogAddProdItem').dialog('open');
                                        }
                                    "));
                            ?>

                            <script type="text/javascript">
                                // here is the magic
                                function addProdItem() {
                                    <?php
                                    echo CHtml::ajax(array(
                                        'url' => array('/sell/crmBank/CreateBankFromOutSide'),
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
                                                 $('#MoneyReceipt_bank_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'bank_id'); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-12 bank"  style="display: none;">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'cheque_no', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="cheque_no" data-target-input="nearest">
                            <?php echo $form->textField($model, 'cheque_no', array('class' => 'form-control')); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa credit-card-alt"></i></div>
                            </div>
                        </div>
                        <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'cheque_no'); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-12 bank" style="display: none;">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'cheque_date', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="cheque_date" data-target-input="nearest">
                            <?php echo $form->textField($model, 'cheque_date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'cheque_date'); ?></span>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'current_due', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="current_due" data-target-input="nearest">
                            <?php
                            $currentDue = Customers::model()->getCurrentDue($model2->id);
                            ?>
                            <?php echo $form->textField($model, 'current_due', array('class' => 'form-control',  'oninput' => 'validatePositiveNumber(this)', 'readonly' => true, 'disabled' => true, 'value' => $currentDue)); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-money"></i></div>
                            </div>
                        </div>
                        <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'current_due'); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'amount', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="amount" data-target-input="nearest">
                            <?php echo $form->textField($model, 'amount', array('class' => 'form-control',  'oninput' => 'validatePositiveNumber(this)')); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-money"></i></div>
                            </div>
                        </div>
                        <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'amount'); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'discount', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="discount" data-target-input="nearest">
                            <?php echo $form->textField($model, 'discount', array('class' => 'form-control',  'oninput' => 'validatePositiveNumber(this)')); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-money"></i></div>
                            </div>
                        </div>
                        <span class="help-block"
                            style="color: red; width: 100%"> <?php echo $form->error($model, 'discount'); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'remarks', ['class' => ' col-md-3 col-form-label']); ?>
                    <div class=" col-md-9">
                        <div class="input-group" id="remarks" data-target-input="nearest">
                            <?php echo $form->textArea($model, 'remarks', array('class' => 'form-control')); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-commenting-o"></i></div>
                            </div>
                        </div>
                        <span class="help-block"
                            style="color: red; width: 100%"> <?php echo $form->error($model, 'remarks'); ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card-footer">
        <?php
        echo CHtml::ajaxSubmitButton('Create', CHtml::normalizeUrl(array('/accounting/moneyReceipt/createNew', 'id' => $id, 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#money-receipt-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                       
                        //$("#soReportDialogBox").dialog("open");
                        //$("#AjFlashReportSo").html(data.soReportInfo).show();
                        $("#information-modal-money-receipt").modal("show");
                        $("#information-modal-money-receipt .modal-body").html(data.soReportInfo); 
                    }else{
                        $("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#money-receipt-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#money-receipt-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){  
                    let date = $("#MoneyReceipt_date").val();  
                    let customer_id = $("#MoneyReceipt_customer_id").val();  
                    let grand_total = $("#MoneyReceipt_total_paid_amount").val();  
                    let payment_type = $("#MoneyReceipt_payment_type").val();  
                    let bank_id = $("#MoneyReceipt_bank_id").val();  
                    let cheque_no = $("#MoneyReceipt_cheque_no").val();  
                    let cheque_date = $("#MoneyReceipt_cheque_date").val();  
                    let row_amounts = 0;
                    
                  
                    if(date == ""){
                        toastr.error("Please insert date.");
                        return false;
                    }else if(payment_type == ""){
                        toastr.error("Please select payment type!");
                        return false;
                    }else if(payment_type == 2){
                        if(bank_id == ""){
                            toastr.error("Please select a bank!");
                            return false;
                        }else if(cheque_no == ""){
                            toastr.error("Please insert cheque no!");
                            return false;
                        }else if(cheque_date == ""){
                            toastr.error("Please insert cheque date!");
                            return false;
                        }
                    }else if(payment_type == 3){
                        if(bank_id == ""){
                            toastr.error("Please select a bank!");
                            return false;
                        }
                    }else if(customer_id == ""){
                        toastr.error("Customer not found! Please insert valid SO!");
                        return false;
                    }else {                
                        $("#overlay").fadeIn(300);
                        $("#ajaxLoader").show();
                    }
                 }',
            'error' => 'function(xhr, status, error) { 
                     // Code to handle errors
                    toastr.error(xhr.responseText); // Displaying error message using Toastr
                    // Optionally, you can display additional error details
                    console.error(xhr.statusText);
                    console.error(xhr.status);
                    console.error(xhr.responseText);
                
                    $("#overlay").fadeOut(300);
              }',
            'complete' => 'function() {
                    $("#overlay").fadeOut(300);
                 $("#ajaxLoaderReport").hide(); 
              }',
        ), array('class' => 'btn btn-primary btn-md'));
        ?>

        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>

        <div id="formResult" class="ajaxTargetDiv"></div>
        <div id="formResultError" class="ajaxTargetDivErr"></div>
    </div>
</div>
<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<?php $this->endWidget(); ?>


<script>
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        // minDate: moment(),
        onSelect: function (date) {
            document.getElementById('MoneyReceipt_date').value = date.format('YYYY-MM-DD');
        }
    });
    var picker = new Lightpick({
        field: document.getElementById('cheque_date'),
        // minDate: moment(),
        onSelect: function (date) {
            document.getElementById('MoneyReceipt_cheque_date').value = date.format('YYYY-MM-DD');
        }
    });

    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            // addToList();
            return false;
        }
    });


    $("#MoneyReceipt_payment_type").change(function () {
        let type = this.value;
        if (type == <?= MoneyReceipt::CASH?>) {
            $(".bank").hide();
        } else if (type == <?= MoneyReceipt::CHECK ?>) {
            $(".bank").show();
        } else if (type == <?= MoneyReceipt::ONLINE ?>) {
            $(".bank").hide();
            $(".online").show();
        } else {
            $(".bank").hide();
        }
        clearBankInfo();
    });

    function clearBankInfo() {
        $("#MoneyReceipt_bank_id").val("");
        $("#MoneyReceipt_cheque_no").val("");
        $("#MoneyReceipt_cheque_date").val("");
    }

    function validatePositiveNumber(input) {
        // Get the input value
        var value = input.value;

        // Remove leading zeros
        value = value.replace(/^0+/, '');

        // Remove non-digit characters except dot
        value = value.replace(/[^\d.]/g, '');

        // Remove extra dots
        value = value.replace(/(\..*)\./g, '$1');

        // Update the input value
        input.value = value;

        // Check if the value is a positive number
        if (parseFloat(value) < 0 || isNaN(parseFloat(value))) {
            // You can also clear the input field or take any other action as needed
            input.value = '';
        }
    }
</script>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddProdItem',
    'options' => array(
        'title' => 'Add Bank',
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



<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'MR PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>


<!--        modal-->
<div class="modal fade" id="information-modal-money-receipt" tabindex="-1" data-backdrop="static" role="dialog"
     aria-labelledby="information-modal-money-receipt" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



