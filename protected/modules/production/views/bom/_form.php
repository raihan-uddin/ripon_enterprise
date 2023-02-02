<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'bom-form',
//    'action' => $this->createUrl('prodItems/create'),
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
            <h3 class="card-title"><?php echo($model->isNewRecord ? 'Add New BOM' : 'Update BOM'); ?></h3>

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
                <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                    <?php echo $form->labelEx($model, 'fg_model_id'); ?>
                    <input type="text" id="fg_model_id_text" class="form-control">
                    <?php echo $form->hiddenField($model, 'fg_model_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'fg_model_id'); ?></span>

                    <script>
                        $(document).ready(function () {
                            $('#fg_model_id_text').autocomplete({
                                source: function (request, response) {
                                    var search = request.term;
                                    $.post('<?php echo Yii::app()->baseUrl ?>/index.php/prodModels/Jquery_showprodSearch', {
                                            "q": search,
                                            "item_id": [<?= ProdItems::FINISHED_GOODS ?>],
                                        },
                                        function (data) {
                                            response(data);
                                        }, "json");
                                },
                                minLength: 1,
                                select: function (event, ui) {
                                    $('#fg_model_id_text').val(ui.item.value);
                                    $('#Bom_fg_model_id').val(ui.item.id);
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
                                <input type="text" class="form-control" aria-label="Materials Name" id="model_id_text">
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
                                            $('#BomDetails_model_id').val(ui.item.id);
                                            $('#BomDetails_unit_id').val(ui.item.unit_id);
                                            $('#product_unit_text').html($('#BomDetails_unit_id option:selected').text());
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
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <?php
                                        echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                            array(
//                                    'class' => '',
                                                'onclick' => "{addUnit(); $('#dialogAddUnit').dialog('open');}"));
                                        ?>
                                        <?php
                                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                            'id' => 'dialogAddUnit',
                                            'options' => array(
                                                'title' => 'Add Unit',
                                                'autoOpen' => false,
                                                'modal' => true,
                                                'width' => 550,
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
                                            function addUnit() {
                                                <?php
                                                echo CHtml::ajax(array(
                                                    'url' => array('/units/createUnitFromOutSide'),
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
                                                                    $('#dialogAddUnit div.divForForm').html(data.div);
                                                                          // Here is the trick: on submit-> once again this function!
                                                                    $('#dialogAddUnit div.divForForm form').submit(addUnit);
                                                                }
                                                                else
                                                                {
                                                                    $('#dialogAddUnit div.divForForm').html(data.div);
                                                                    setTimeout(\"$('#dialogAddUnit').dialog('close') \",1000);
                                                                    $('#BomDetails_unit_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
                                    <th>Materials Name</th>
                                    <th style="width: 15%; display: none;" class="text-center">Unit</th>
                                    <th style="width: 20%;" class="text-center">Qty</th>
                                    <th style="width: 4%;" class="text-center">Action</th>
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
            echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('/production/bom/create', 'render' => true)), array(
                'dataType' => 'json',
                'type' => 'post',
                'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#bom-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#list").empty();
                        $.fn.yiiGridView.update("bom-grid", {
                            data: $(this).serialize()
                        });
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
                      $("#overlay").fadeIn(300);　   
                        $("#ajaxLoader").show();
                    }
                 }' ,
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
    <script>
        function addToList() {
            let model_id = $("#BomDetails_model_id").val();
            let model_id_text = $("#model_id_text").val();
            let unit_id = $("#BomDetails_unit_id").val();
            let unit_name = $("#BomDetails_unit_id option:selected").text();
            let qty = $("#BomDetails_qty").val();
            let isproductpresent = false;
            let temp_codearray = document.getElementsByName("BomDetails[temp_model_id][]");
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
                return false;
            } else if (isproductpresent == true) {
                toastr.error(model_id_text + " is already on the list! Please add another!");
                return false;
            } else if (qty == "" || qty == 0) {
                toastr.error("Please enter qty");
                return false;
            } else {
                $("#list tbody").append(`
                <tr class="item">
                    <td>${model_id_text}</td>
                    <td class="text-center" style="display: none;">${unit_name}</td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control text-center" value="${qty}" name=BomDetails[temp_qty][]"">
                        <div class="input-group-append">
                                <span class="input-group-text"">${unit_name}</span>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" value="${model_id}" name="BomDetails[temp_model_id][]" >
                        <input type="hidden" class="form-control" value="${unit_id}" name="BomDetails[temp_unit_id][]" >
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
            $("#BomDetails_model_id").val('');
            $("#model_id_text").val('');
            $("#BomDetails_unit_id").val('');
            $("#BomDetails_qty").val('');
            $(".product_unit_text").html('');
        }
    </script>

<?php $this->endWidget(); ?>