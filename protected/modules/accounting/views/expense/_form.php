<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Common', 'url' => array('admin')),
        array('name' => 'Expense', 'url' => array('admin')),
        array('name' => 'Create'),
    ),
//    'delimiter' => ' &rarr; ',
));
// print yii1 version
echo Yii::getVersion();

?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'expense-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
Yii::app()->clientScript->registerCoreScript("jquery.ui");

?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>


<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Expense' : 'Update Expense'); ?></h3>

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
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group row" style="">
                        <?php echo $form->labelEx($model, 'date', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                        <div class="col-sm-12 col-md-9">
                            <div class="input-group" id="entry_date" data-target-input="nearest">
                                <?php echo $form->textField($model, 'date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model, 'date'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group row" style="">
                        <?php echo $form->labelEx($model, 'remarks', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                        <div class="col-sm-12 col-md-9">
                            <div class="input-group" id="remarks" data-target-input="nearest">
                                <?php echo $form->textField($model, 'remarks', array('class' => 'form-control',)); ?>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-list"></i></div>
                                </div>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model, 'date'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group row" style="">
                        <?php echo $form->labelEx($model, 'created_by', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                        <div class="col-sm-12 col-md-9">
                            <div class="input-group" id="customer_id" data-target-input="nearest">
                                <?php echo $form->textField($model, 'created_by_text', array('class' => 'form-control', 'readonly' => true, 'value' => Users::model()->nameOfThis(Yii::app()->user->id))); ?>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                                </div>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model, 'created_by'); ?></span>
                    </div>
                </div>
            </div>

            <div class="card card-cyan">
                <div class="card-header">
                    <h3 class="card-title">Items</h3>

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
                        <div class="form-group col-sm-12 col-md-3 col-lg-3">
                            <?php echo $form->labelEx($model2, 'expense_head_id'); ?>
                            <div class="input-group" data-target-input="nearest">
                                <input type="text" id="expense_head_id_text" class="form-control">
                                <?php echo $form->hiddenField($model2, 'expense_head_id', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <?php echo CHtml::link(' <i class="fa fa-plus"></i>', "", array('onclick' => "{addProdModel(); $('#dialogAddProdModel').dialog('open');}")); ?>

                                        <?php
                                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                            'id' => 'dialogAddProdModel',
                                            'options' => array(
                                                'title' => 'Add Expense Head',
                                                'autoOpen' => false,
                                                'modal' => true,
                                                'width' => '600px',
                                                'left' => '30px',
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
                                            function addProdModel() {
                                                <?php
                                                echo CHtml::ajax(array(
                                                    'url' => array('/accounting/expenseHead/CreateHeadFromOutSide'),
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
                                                                $('#dialogAddProdModel div.divForForm').html(data.div);
                                                                      // Here is the trick: on submit-> once again this function!
                                                                $('#dialogAddProdModel div.divForForm form').submit(addProdModel);
                                                            }
                                                            else
                                                            {
                                                                $('#dialogAddProdModel div.divForForm').html(data.div);
                                                                setTimeout(\"$('#dialogAddProdModel').dialog('close') \",1000);
                                                                $('#ExpenseDetails_expense_head_id').val(data.value);
                                                                $('#expense_head_id_text').val(data.label);
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
                                  style="color: red; width: 100%"> <?php echo $form->error($model, 'expense_head_id'); ?></span>

                            <script>
                                $(document).ready(function () {
                                    $("#expense_head_id_text").on("focus keyup", function () {
                                        $(this).autocomplete({
                                            source: function (request, response) {
                                                var search_prodName = request.term;
                                                $.post('<?php echo Yii::app()->baseUrl ?>/index.php/accounting/expenseHead/jquery_showExpenseHead', {
                                                        "q": search_prodName,
                                                    },
                                                    function (data) {
                                                        response(data);
                                                    }, "json");
                                            },
                                            minLength: 2,
                                            delay: 700,
                                            select: function (event, ui) {
                                                $('#expense_head_id_text').val(ui.item.value);
                                                $('#ExpenseDetails_expense_head_id').val(ui.item.id);
                                                return false;
                                            }
                                        });
                                    });
                                });
                            </script>
                        </div>
                        <div class="form-group col-sm-12 col-md-2 col-lg-2">
                            <?php echo $form->labelEx($model2, 'amount'); ?>
                            <?php echo $form->textField($model2, 'amount', array('maxlength' => 255, 'class' => 'form-control  qty-amount')); ?>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model2, 'amount'); ?></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-2 col-lg-2">
                            <?php echo $form->labelEx($model2, 'remarks'); ?>
                            <?php echo $form->textField($model2, 'remarks', array('maxlength' => 255, 'class' => 'form-control ')); ?>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model2, 'remarks'); ?></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-2 col-lg-2">
                            <button class="btn  btn-success mt-4" onclick="addToList()" type="button">ADD TO LIST
                            </button>
                        </div>
                    </div>
                    <div class="row">

                        <div class="table table-responsive">
                            <table class="table table-sm  table-hover table-bordered table-striped" id="list">
                                <thead>
                                <tr class="table-info">
                                    <th class="text-center" style="width: 3%;">#</th>
                                    <th>Expense</th>
                                    <th class="text-center" style="width: 30%;">Note</th>
                                    <th class="text-center" style="width: 30%;">Amount</th>
                                    <th class="text-center" style="width: 3%;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right" style="vertical-align: middle">Calculation
                                    </th>
                                    <th style="vertical-align: middle;">
                                        <?php echo $form->textField($model, 'amount', array('maxlength' => 255, 'class' => 'form-control text-right grand_total', 'readonly' => true)); ?>

                                        <span class="help-block"
                                              style="color: red; width: 100%"> <?php echo $form->error($model, 'amount'); ?></span>
                                    </th>
                                    <th style="vertical-align: middle;"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card-footer">
        <?php
        echo CHtml::ajaxSubmitButton('Create', CHtml::normalizeUrl(array('/accounting/expense/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#expense-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#list tbody").empty();
                        $("#soReportDialogBox").dialog("open");
                        $("#AjFlashReportSo").html(data.soReportInfo).show();
                    }else{
                        $("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#expense-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#expense-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){  
                    let count_item =  $(".item").length; 
                    let date = $("#Expense_date").val();  
                    let grand_total = $("#Expense_amount").val();  
                    let unit_price_zero = 0;
                    $(".temp-amount").each(function () {
                        var up = parseFloat($(this).val());
                        up = isNaN(up) ? 0 : up;
                        if(up <= 0){
                            unit_price_zero++;
                            $(this).addClass("is-invalid");
                        }else{
                            $(this).removeClass("is-invalid");
                        }
                    });
                    if(date == ""){
                        toastr.error("Please insert date.");
                        return false;
                    }else if(count_item <= 0){
                        toastr.error("Please add materials to list.");
                        return false;
                    }else if(unit_price_zero > 0){
                        toastr.error("Please insert expense amount.");
                        return false;
                    }else if(grand_total == "" || grand_total <= 0){
                        toastr.error("Grand total amount is 0");
                        return false;
                    }else {                
                        $("#overlay").fadeIn(300);　   
                        $("#ajaxLoader").show();
                    }
                 }',
            'error' => 'function(xhr) { 
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
    let sl = 1;
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('Expense_date').value = date.format('YYYY-MM-DD');
        }
    });

    $(document).ready(function () {

        $("#btnReset").click(function () {
            cleanAll();
        });

        $(".qty-amount").keyup(function () {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));
        });

        $("#list").on("click", ".dlt", function () {
            $(this).closest("tr").remove();
            calculateTotal();
        });
    });


    function addToList() {
        let head = $("#ExpenseDetails_expense_head_id").val();
        let head_text = $("#expense_head_id_text").val();
        let amount = $("#ExpenseDetails_amount").val();
        let note = $("#ExpenseDetails_remarks").val();

        let isproductpresent = false;
        let temp_codearray = document.getElementsByName("ExpenseDetails[temp_expense_head_id][]");
        if (temp_codearray.length > 0) {
            for (let l = 0; l < temp_codearray.length; l++) {
                var code = temp_codearray[l].value;
                if (code == head) {
                    isproductpresent = true;
                    break;
                }
            }
        }


        if (head == "" || head <= 0) {
            toastr.error("Please select expense from list!");
            return false;
        } else if (isproductpresent == true) {
            toastr.error(head_text + " is already on the list! Please add another!");
            return false;
        } else if (amount <= 0 || amount == "") {
            toastr.error("Please insert amount!");
            return false;
        } else {
            $("#list tbody").append(`
                    <tr class="item">
                        <td class="text-center sl-no" style="vertical-align: middle;">${$('#list tbody tr').length+1}</td>
                        <td class="text-left" style="vertical-align: middle;">
                            ${head_text}
                            <input type="hidden" name="ExpenseDetails[temp_expense_head_id][]"
                                   class="form-control model-id" value="${head}">
                        </td>
                        <td class="text-center" style="vertical-align: middle;  min-width: 120px;">
                            <input type="text" name="ExpenseDetails[temp_remarks][]"
                                   class="form-control text-left" value="${note}">
                        </td>
                        <td class="text-center" style="vertical-align: middle;  min-width: 120px;">
                            <input type="text" name="ExpenseDetails[temp_amount][]"
                                   class="form-control text-right temp-amount" value="${amount}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i>
                            </button>
                        </td>
                    </tr>
                `);
            calculateTotal();
            cleanItems();
        }
    }

    $(document).on('keyup', ".temp-amount", function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
        calculateTotal();
    });

    function cleanAll() {
        $("#list tbody").empty();
        $("#expense-form")[0].reset();
        calculateTotal();
    }


    function calculateTotal() {
        let total = 0;
        $('.temp-amount').each(function () {
            var amount = parseFloat($(this).val());
            amount = isNaN(amount) ? 0 : amount;
            total += amount;
        });
        $("#Expense_amount").val(total.toFixed(2)).change();
    }

    function cleanItems() {
        $("#ExpenseDetails_expense_head_id").val("");
        $("#expense_head_id_text").val("");
        $("#ExpenseDetails_amount").val("");
    }
</script>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'EXPENSE VOUCHER PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>


