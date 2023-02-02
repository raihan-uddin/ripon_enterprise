<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Order', 'url' => array('admin')),
        array('name' => $sellItemsData->so_no, 'url' => array('admin')),
        array('name' => 'Bom'),
    ),
//    'delimiter' => ' &rarr; ',
));
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'bom-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
Yii::app()->clientScript->registerCoreScript("jquery.ui");

?>

    <script>
        $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
    </script>
    <div style="width: 100%;">
        <a class="btn btn-danger text-right mb-2" type="button"
           href="<?= Yii::app()->baseUrl . '/index.php/production/bom/admin' ?>"><i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create  BOM' : 'Update BOM'); ?></h3>

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
                <div class="form-group col-xs-12 col-sm-2 col-lg-2">
                    <?php echo $form->labelEx($sellItemsData, 'so_no'); ?>
                    <?php echo $form->textField($sellItemsData, 'so_no', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($sellItemsData, 'so_no'); ?></span>
                </div>
                <div class="form-group col-xs-12 col-sm-2 col-lg-2">
                    <?php echo $form->labelEx($sellItemsData, 'customer_id'); ?>
                    <input type="text" class="form-control"
                           value="<?= Customers::model()->nameOfThis($sellItemsData->customer_id) ?>" readonly>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($sellItemsData, 'customer_id'); ?></span>
                </div>

                <div class="form-group col-xs-12 col-sm-2 col-lg-2">
                    <?php echo $form->labelEx($sellItemsData, 'date'); ?>
                    <?php echo $form->textField($sellItemsData, 'date', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($sellItemsData, 'date'); ?></span>
                </div>
                <div class="form-group col-xs-12 col-sm-2 col-lg-2">
                    <?php echo $form->labelEx($sellItemsData, 'exp_delivery_date'); ?>
                    <?php echo $form->textField($sellItemsData, 'exp_delivery_date', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($sellItemsData, 'exp_delivery_date'); ?></span>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Materials</h3>

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
                        <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                            <?php echo $form->labelEx($modelDetails, 'model_id'); ?>

                            <div class="input-group">
                                <input type="text" class="form-control" aria-label="Product Name" id="model_id_text">
                                <?php echo $form->hiddenField($modelDetails, 'model_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
                            </div>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($model, 'model_id'); ?></span>

                            <script>
                                $(document).ready(function () {
                                    $('#model_id_text').autocomplete({
                                        source: function (request, response) {
                                            var search = request.term;
                                            $.post('<?php echo Yii::app()->baseUrl ?>/index.php/prodModels/Jquery_showprodSearch', {
                                                    "q": search,
                                                    "item_id": [<?= ProdItems::FINISHED_GOODS ?>],
                                                    "item_id_excluded": true,
                                                },
                                                function (data) {
                                                    response(data);
                                                }, "json");
                                        },
                                        minLength: 1,
                                        select: function (event, ui) {
                                            $('#model_id_text').val(ui.item.value);
                                            $('#SellOrderBom_model_id').val(ui.item.id);
                                            $('#SellOrderBom_unit_id').val(ui.item.unit_id);
                                            $('#product_unit_text').html($('#SellOrderBom_unit_id option:selected').text());
                                        }
                                    }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                        return $("<li></li>")
                                            .data("item.autocomplete", item)
                                            .append(`<a><img style="height: 50px; width: 50px;" src="${item.img}"> ${item.name} <br><i><small>${item.code}</small></i> </a>`)
                                            .appendTo(ul);
                                    };

                                });
                            </script>
                        </div>
                        <div class="form-group col-xs-12 col-sm-3 col-lg-3" style="display: none;">
                            <?php echo $form->labelEx($modelDetails, 'unit_id'); ?>
                            <div class="input-group" data-target-input="nearest">
                                <?php
                                echo $form->dropDownList(
                                    $modelDetails, 'unit_id', CHtml::listData(Units::model()->findAll(array('order' => 'label ASC')), 'id', 'label'), array(
                                    'prompt' => 'Select',
                                    'class' => 'form-control',
                                ));
                                ?>
                            </div>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($modelDetails, 'unit_id'); ?></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                            <?php echo $form->labelEx($modelDetails, 'qty'); ?>

                            <div class="input-group">
                                <?php echo $form->textField($modelDetails, 'qty', array('maxlength' => 255, 'class' => 'form-control')); ?>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="product_unit_text"></span>
                                </div>
                            </div>
                            <span class="help-block"
                                  style="color: red; width: 100%"> <?php echo $form->error($modelDetails, 'qty'); ?></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-3 col-lg-3">
                            <button class="btn  btn-success  mt-4" onclick="addToList()" type="button">ADD TO LIST
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped" id="list">
                                <thead class="table-info">
                                <tr>
                                    <th>Product Name</th>
                                    <th style="width: 20%;" class="text-center">Qty</th>
                                    <th style="width: 4%;" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sl = 1;
                                foreach ($item_arr as $key => $item) {
                                    $prodModel = ProdModels::model()->findByPk($key);
                                    ?>
                                    <tr class="item">
                                        <td><?= $prodModel->model_name ?></td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control text-center"
                                                       value="<?= $item ?>"
                                                       name=SellOrderBom[temp_qty][]"">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><?= Units::model()->nameOfThis($prodModel->unit_id) ?></span>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" value="<?= $key ?>"
                                                   name="SellOrderBom[temp_model_id][]">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger dlt"><i
                                                        class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <?php
            echo CHtml::ajaxSubmitButton('Create', CHtml::normalizeUrl(array('/production/sellOrderBom/create/id/' . $sellItemsData->id, 'render' => true)), array(
                'dataType' => 'json',
                'type' => 'post',
                'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data updated successfully.");
                        toastr.success("BOM Created Successfully!");
                        //$("#bom-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        //$("#list").empty();
//                    window.history.back()
                        $("#soReportDialogBox").dialog("open");
                        $("#AjFlashReportSo").html(data.soReportInfo).show();

                    }else{
                        //$("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#bom-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#bom-form #"+key+"_em_").show();
                        });
                    }       
                }',
                'beforeSend' => 'function(){  
                    let count_item =  $(".item").length; 
                    let fg_id = $("#Bom_fg_model_id").val();  
                    if(fg_id == ""){
                        toastr.error("Please select finished materials.");
                        return false;
                    }else if(count_item <= 0){
                        toastr.error("Please add materials to list.");
                        return false;
                    }else {                   
                        $("#ajaxLoader").show();
                    }
                 }'
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
<script>
    function addToList() {
        let model_id = $("#SellOrderBom_model_id").val();
        let model_id_text = $("#model_id_text").val();
        let unit_id = $("#SellOrderBom_unit_id").val();
        let unit_name = $("#SellOrderBom_unit_id option:selected").text();
        let qty = $("#SellOrderBom_qty").val();
        let isproductpresent = false;
        let temp_codearray = document.getElementsByName("SellOrderBom[temp_model_id][]");
        if (temp_codearray.length > 0) {
                for (let l = 0; l < temp_codearray.length; l++) {
                    var code = temp_codearray[l].value;
                    if (code == model_id) {
                        isproductpresent = true;
                        break;
                    }
                }
            }


            if (model_id == "" || model_id_text == "") {
                toastr.error("Please select materials");
            } else if (isproductpresent == true) {
                toastr.error(model_id_text + " is already on the list! Please add another!");
            } else if (qty == "" || qty == 0) {
                toastr.error("Please enter qty");
            } else {
                $("#list tbody").append(`
                <tr class="item">
                    <td>${model_id_text}</td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control text-center" value="${qty}" name=SellOrderBom[temp_qty][]"">
                            <div class="input-group-append">
                                <span class="input-group-text">${unit_name}</span>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" value="${model_id}" name="SellOrderBom[temp_model_id][]" >
                        <input type="hidden" class="form-control" value="${unit_id}" name="SellOrderBom[temp_unit_id][]" >
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i> </button>
                    </td>
                </tr>
                `);
                clearDynamicItem();
            }
        }

        $("#list").on("click", ".dlt", function () {
            $(this).closest("tr").remove();
        });


    function clearDynamicItem() {
        $("#SellOrderBom_model_id").val('');
        $("#model_id_text").val('');
        $("#SellOrderBom_unit_id").val('');
        $("#SellOrderBom_qty").val('');
    }
</script>

<?php $this->endWidget(); ?>




<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'BOM VOUCHER PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>

