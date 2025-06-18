<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/report.css" type="text/css" media="screen"/>
<style>
    .reportHeader {
        text-align: center !important;
    }
    .ui-autocomplete {
        max-height: 250px;
        overflow-y: auto;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 13px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        z-index: 99999 !important;
        padding: 4px 0;
    }

    .autocomplete-item {
        padding: 10px 14px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        border-bottom: 1px solid #f0f0f0;
    }

    .autocomplete-item:last-child {
        border-bottom: none;
    }

    .autocomplete-item:hover {
        background-color: #f9f9f9;
    }

    .autocomplete-box .name {
        font-weight: 600;
        font-size: 14px;
        color: #212529;
    }

    .autocomplete-box .meta {
        font-size: 12px;
        color: #666;
        margin-top: 4px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .autocomplete-box .meta i {
        color: #007bff;
        font-size: 11px;
    }


</style>
<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Report', 'url' => array('')),
        array('name' => 'Sell', 'url' => array('')),
        array('name' => 'Customer Ledger',),
    ),
//    'delimiter' => ' &rarr; ',
));
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'inventory-form',
));
?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Search Conditions (CUSTOMER LEDGER)</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-sm-12 col-md-2">
                <div class="form-group" style="">
                    <?php echo $form->labelEx($model, 'date_from', ['class' => 'col-form-label']); ?>
                    <div class="input-group" id="date_from" data-target-input="nearest">
                        <?php echo $form->textField($model, 'date_from', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'date_from'); ?></span>
                </div>
            </div>

            <div class="col-sm-12 col-md-2">
                <div class="form-group" style="">
                    <?php echo $form->labelEx($model, 'date_to', ['class' => 'col-form-label']); ?>
                    <div class="input-group" id="date_to" data-target-input="nearest">
                        <?php echo $form->textField($model, 'date_to', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'date_to'); ?></span>
                </div>
            </div>

            <div class="col-sm-12 col-md-3">
                <div class="form-group" style="">
                    <?php echo $form->labelEx($model, 'customer_id', ['class' => 'col-form-label']); ?>
                    <div class="input-group" id="customer_id" data-target-input="nearest">
                        <input type="text" id="customer_id_text" class="form-control">
                        <?php echo $form->hiddenField($model, 'customer_id', array('class' => 'form-control',)); ?>
                        <div class="input-group-append" onclick="clearProduct()">
                            <div class="input-group-text"><i class="fa fa-refresh"></i></div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'customer_id'); ?></span>
                    <script>
                        $(document).ready(function () {
                            $('#customer_id_text').autocomplete({
                                source: function (request, response) {
                                    $.post('<?php echo Yii::app()->baseUrl ?>/index.php/sell/customers/Jquery_customerSearch', {
                                        q: request.term
                                    }, function (data) {
                                        response(data);
                                    }, "json");
                                },
                                minLength: 1,
                                select: function (event, ui) {
                                    $('#customer_id_text').val(ui.item.value);
                                    $('#Inventory_customer_id').val(ui.item.id);
                                    return false; // prevent default selection
                                }
                            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                return $("<li class='autocomplete-item'></li>")
                                    .append(
                                        `<div class="autocomplete-box">
        <div class="name">${item.name}</div>
        <div class="meta">
            <span>ID: ${item.id}</span>
            <span><i class="fa fa-phone"></i> ${item.contact_no}</span>
        </div>
    </div>`
                                    )
                                    .appendTo(ul);
                            };
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <?php
        echo CHtml::submitButton('Search', array(
                'ajax' => array(
                    'type' => 'POST',
                    'url' => CController::createUrl('/report/customerLedgerView'),
                    'beforeSend' => 'function(){
                                if($("#Inventory_date_from").val()=="" || $("#Inventory_date_to").val()==""){
                                    toastr.error("Warning! Please select date range!");
                                    return false;
                                }else if($("#Inventory_customer_id").val()==""){
                                    toastr.error("Warning! Please select customer!");
                                    return false;
                                }else{
                                    $(".ajaxLoaderResultView").show();
                                    $("#reportSearchButton").prop("disabled", true);
                                    $("#reportSearchButton").val("Please wait ...");
                                }
                            }',
                    'error' => 'function(XMLHttpRequest, textStatus, errorThrown){
                                $(".ajaxLoaderResultView").hide();
					           // showErrorText(XMLHttpRequest, textStatus, errorThrown);
					            $("#reportSearchButton").prop("disabled", false);
                                $("#reportSearchButton").val("Search");
                                
                                // Code to handle errors
                                toastr.error(XMLHttpRequest.responseText); // Displaying error message using Toastr
                                // Optionally, you can display additional error details
                                console.error(XMLHttpRequest.statusText);
                                console.error(XMLHttpRequest.status);
                                console.error(XMLHttpRequest.responseText);
						    }',
                    'complete' => 'function(){
                                $(".ajaxLoaderResultView").hide();
					            $("#reportSearchButton").prop("disabled", false);
                                $("#reportSearchButton").val("Search");
                            }',
                    'done' => 'function(data){
                                $(".ajaxLoaderResultView").hide();
					            $("#reportSearchButton").prop("disabled", false);
                                $("#reportSearchButton").val("Search");
						    }',
                    'update' => '#resultDiv',
                ),
                'class' => 'btn btn-success btn-md',
                'id' => 'reportSearchButton',
            )
        );
        ?>

        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </span>
    </div>
</div>


<div class="card">
    <div class="card-header">
    </div>

    <div class="card-body">
        <div id="resultDiv"></div>
    </div>
</div>

<?php $this->endWidget(); ?>
<script>
    var startDate = moment().startOf('month').format('YYYY-MM-DD');
    var endDate = moment().format('YYYY-MM-DD');

    var picker = new Lightpick({
        field: document.getElementById('Inventory_date_from'),
        // minDate: moment(),
        onSelect: function (date) {
            document.getElementById('Inventory_date_from').value = date.format('YYYY-MM-DD');
        }
    });
    picker.setStartDate(startDate);

    var picker2 = new Lightpick({
        field: document.getElementById('Inventory_date_to'),
        // minDate: moment(),
        onSelect: function (date) {
            document.getElementById('Inventory_date_to').value = date.format('YYYY-MM-DD');
        }
    });
    picker2.setStartDate(endDate);

    $("#resetBtn").click(function () {
        $("#inventory-form")[0].reset();
        $("#Inventory_date_from").val("");
        $("#Inventory_date_to").val("");
        clearProduct();
    });

    function clearProduct() {
        $("#customer_id_text").val("");
        $("#Inventory_customer_id").val("");
    }
</script>


<style>
    .report-search {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }

    .report-search tr td {
        width: 14%;
        padding: 5px;
        border: 1px solid gray;
    }

    .report-search tr td input[type="text"], .report-search tr td select {
        width: 95%;
        text-align: center;
        height: 23px;
    }

    .resetBtn {
        height: 28px;
    }

    .ui-datepicker {
        z-index: 2 !important;
    }
</style>

