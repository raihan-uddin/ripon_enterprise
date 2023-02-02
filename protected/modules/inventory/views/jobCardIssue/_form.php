<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Inventory', 'url' => array('admin')),
        array('name' => 'Job Card Issue', 'url' => array('admin')),
        array('name' => 'Create'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'job-card-issue-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>


<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Job Card Issue' : 'Update Job Card Issue'); ?></h3>

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
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'job_card_no', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                    <div class="col-sm-12 col-md-9">
                        <?php echo $form->textField($model, 'job_card_no', array('maxlength' => 255, 'class' => 'form-control ',)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'job_card_no'); ?></span>
                </div>
            </div>
            <div class="form-group col-xs-11 col-md-3 col-lg-3">
                <button class="btn  btn-info loading" type="button" id="btnFetch"><i class="fa fa-search"></i> Search
                </button>
                <a class="btn  btn-warning" type="button" id="btnReload"
                   href="<?= Yii::app()->request->requestUri ?>"><i class="fa fa-refresh"></i> Reload
                </a>
                <button class="btn  btn-danger" type="button" id="btnReset"><i class="fa fa-remove"></i> Reset
                </button>

                <a class="btn btn-success text-right" type="button"
                   href="<?= Yii::app()->baseUrl . '/index.php/inventory/jobCardIssue/admin' ?>"><i
                            class="fa fa-home"></i>
                    Issue Manage
                </a>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Job Card Info</h3>

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
                            <?php echo $form->labelEx($model, 'customer_id', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                            <div class="col-sm-12 col-md-9">
                                <div class="input-group" id="customer_id" data-target-input="nearest">
                                    <?php echo $form->textField($model, 'customer_name', array('class' => 'form-control', 'readonly' => true)); ?>
                                    <?php echo $form->hiddenField($model, 'customer_id', array('class' => 'form-control', 'readonly' => true)); ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                                    </div>
                                </div>
                            </div>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model, 'customer_id'); ?></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group row" style="">
                            <?php echo $form->labelEx($model, 'order_id', ['class' => 'col-sm-12 col-md-3 col-form-label']); ?>
                            <div class="col-sm-12 col-md-9">
                                <div class="input-group" id="customer_id" data-target-input="nearest">
                                    <?php echo $form->textField($model, 'so_no', array('class' => 'form-control so-no', 'readonly' => true)); ?>
                                    <?php echo $form->hiddenField($model, 'order_id', array('class' => 'form-control', 'readonly' => true)); ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-first-order"></i></div>
                                    </div>
                                </div>
                            </div>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model, 'order_id'); ?></span>
                        </div>
                    </div>

                    <div class="table table-responsive">
                        <table class="table table-sm  table-hover table-bordered table-striped" id="list">
                            <thead>
                            <tr class="table-info">
                                <th class="text-center" style="width: 3%;">#</th>
                                <th>Materials</th>
                                <th class="text-center" style="width: 10%;">Bom. Qty</th>
                                <th class="text-center" style="width: 10%;">Rem. Qty</th>
                                <th class="text-center" style="width: 10%;">Stock</th>
                                <th class="text-center" style="width: 10%;">Issue. Qty</th>
                                <th class="text-center" style="width: 3%;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <?php
        echo CHtml::ajaxSubmitButton('Create', CHtml::normalizeUrl(array('/inventory/jobCardIssue/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#job-card-issue-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#list tbody").empty();
                        $("#soReportDialogBox").dialog("open");
                        $("#AjFlashReportSo").html(data.soReportInfo).show();
                    }else{
                        $("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#job-card-issue-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#job-card-issue-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){  
                    let count_item =  $(".item").length; 
                    let date = $("#JobCardIssue_date").val();  
                    let order_id = $("#JobCardIssue_order_id").val();  
                    let customer_id = $("#JobCardIssue_customer_id").val();  
                    let grand_total = $("#JobCardIssue_grand_total").val();  
                    let bill_qty_zero = 0;
                    $(".issue-qty").each(function () {
                        var bill_qty_total = parseFloat($(this).val());
                        bill_qty_total = isNaN(bill_qty_total) ? 0 : bill_qty_total;
                        if(bill_qty_total <= 0){
                            bill_qty_zero++;
                            $(this).addClass("is-invalid");
                        }else{
                            $(this).removeClass("is-invalid");
                        }
                    });
                  
                    if(date == ""){
                        toastr.error("Please insert date.");
                        return false;
                    }else if(customer_id == ""){
                        toastr.error("Customer not found! Please insert valid Job Card No!");
                        return false;
                    }else if(order_id == ""){
                        toastr.error("Please insert valid  Job Card No!");
                        return false;
                    }else if(count_item <= 0){
                        toastr.error("Please add materials to list.");
                        return false;
                    }else if(bill_qty_zero > 0){
                        toastr.error("Please insert issue qty.");
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
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('JobCardIssue_date').value = date.format('YYYY-MM-DD');
        }
    });

    $(document).ready(function () {
        $("#btnReset").click(function () {
            cleanAll();
        });
        $("#btnFetch").click(function () {
            let job_no = $("#JobCardIssue_job_card_no").val();
            let button = $(this);
            $.ajax({
                type: "post",
                url: "<?php echo Yii::app()->baseUrl ?>/index.php/sell/sellOrder/jobCardDetails",
                dataType: "json",
                data: jQuery.param({job_no: job_no}),
                cache: false,
                async: false,
                beforeSend: function () {
                    console.log('beforesend called');
                    button.prop("disabled", true);
                    // add spinner to button
                    button.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`);
                    $("#list tbody").append(`<tr><td colspan="10" class="text-center"><span class="spinner-border spinner-border text-success" role="status" aria-hidden="true"></span> Please wait...</td></tr>`);
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === 404) {
                        toastr.error(response.message);
                        // do something with response.message or whatever other data on error
                        cleanAll();
                    } else if (response.order_item_status === 405) {
                        toastr.error(response.message);
                        // do something with response.message or whatever other data on error
                        cleanAll();
                    } else if (response.status === 200) {
                        $("#JobCardIssue_customer_name").val(response.order_info.customer_name);
                        $("#JobCardIssue_customer_id").val(response.order_info.customer_id);
                        $("#JobCardIssue_order_id").val(response.order_info.order_id);
                        $(".so-no").val(response.order_info.so_no);
                        $("#list tbody").empty();
                        for (var i = 0; i < response.order_items.length; i++) {
                            // console.log(response.order_items[i]);
                            addToLlist(response.order_items[i], i);
                        }
                    }
                },
                error: function (xhr) { // if error occurred
                    alert("Error occurred.please try again");
                    // $(placeholder).append(xhr.statusText + xhr.responseText);
                    button.prop("disabled", false);
                    cleanAll();
                },
                complete: function () {
                    button.prop("disabled", false);
                    button.html(`<i class="fa fa-search"></i> Search`);
                },
            });
        });


        $("#list").on("click", ".dlt", function () {
            $(this).closest("tr").remove();
        });


        function addToLlist(item, sl) {
            $("#list tbody").append(`
                <tr class="item">
                    <td class="text-center sl-no" style="vertical-align: middle;">${++sl}</td>
                    <td class="text-left" style="vertical-align: middle;">
                        ${item.model_name}
                        <input type="hidden" name="JobCardIssueDetails[temp_model_id][]"
                               class="form-control model-id" value="${item.model_id}">
                    </td>

                    <td class="text-center" style="vertical-align: middle; min-width: 125px;">
                        <span class="bom-qty-span">${item.qty}</span>
                        <input type="hidden" name="JobCardIssueDetails[temp_bom_qty][]"
                               class="form-control bom-qty" value="${item.qty}">
                    </td>
                    <td class="text-center" style="vertical-align: middle;  min-width: 125px;">
                        <span class="rem-qty-span">${item.rem_qty}</span>
                        <input type="hidden" name="JobCardIssueDetails[temp_rem_qty][]"
                               class="form-control rem-qty " value="${item.rem_qty}">
                    </td>
                    <td class="text-center" style="vertical-align: middle;  min-width: 125px;">
                        <span class="rem-qty-span">${item.stock}</span>
                        <input type="hidden" name="JobCardIssueDetails[temp_stock_qty][]"
                               class="form-control stock-qty " value="${item.stock}">
                    </td>
                    <td class="text-center" style="vertical-align: middle;  min-width: 120px;">
                        <input type="text" name="JobCardIssueDetails[temp_issue_qty][]"
                               class="form-control text-center issue-qty">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
            `);
        }
    });

    $(document).on('keyup', ".issue-qty", function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
        let issue_qty = parseFloat($(this).closest('tr').find('.issue-qty').val());
        let rem_qty = parseFloat($(this).closest('tr').find('.rem-qty').val());
        let stock_qty = parseFloat($(this).closest('tr').find('.stock-qty').val());
        issue_qty = isNaN(issue_qty) ? 0 : issue_qty;
        rem_qty = isNaN(rem_qty) ? 0 : rem_qty;
        stock_qty = isNaN(stock_qty) ? 0 : stock_qty;
        console.log(`(rem_qty >= issue_qty) && (stock_qty >= issue_qty): (${rem_qty} >= ${issue_qty}) && ${stock_qty} >= ${issue_qty})`);

        if ((rem_qty >= issue_qty) && (stock_qty >= issue_qty)) {
            $(this).removeClass("is-invalid");
        } else {
            this.value = '';
            $(this).addClass("is-invalid");
            if (issue_qty > stock_qty)
                toastr.error("Stock qty exceeded!");
            else
                toastr.error("Issue qty exceeded!");
        }
    });


    function cleanAll() {
        $("#list tbody").empty();
        $("#job-card-issue-form")[0].reset();
    }

</script>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'ISSUE PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>


