<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/report.css" type="text/css" media="screen"/>
<style>
    .reportHeader {
        text-align: center !important;
    }
</style>
<?php
$this->widget('application.components.BreadCrumb', array(
        'crumbs' => array(
                array('name' => 'Report', 'url' => array('')),
                array('name' => 'Inventory', 'url' => array('')),
                array('name' => 'Stock Report Supplier Wise', 'url' => array('')),
        ),
));
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
        'id' => 'inventory-form',
));
?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Search Conditions (STOCK REPORT SUPPLIER WISE)</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class=" form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model, 'supplier_id',); ?>
                <div class="input-group" id="manufacturer_id" data-target-input="nearest">
                    <?php
                    echo $form->dropDownList(
                            $model, 'supplier_id', CHtml::listData(Suppliers::model()->findAll(array('order' => 'company_name ASC')), 'id', 'company_name'), array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                    ));
                    ?>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'supplier_id'); ?></span>
            </div>
            <div class="form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model, 'manufacturer_id',); ?>
                <div class="input-group" id="manufacturer_id" data-target-input="nearest">
                    <?php
                    echo $form->dropDownList(
                            $model, 'manufacturer_id', CHtml::listData(Company::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                    ));
                    ?>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'manufacturer_id'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model, 'item_id'); ?>
                <div class="input-group" data-target-input="nearest"><?php
                    echo $form->dropDownList(
                            $model, 'item_id', CHtml::listData(ProdItems::model()->findAll(array('order' => 'item_name ASC')), 'id', 'item_name'), array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                            'ajax' => array(
                                    'type' => 'POST',
                                    'dataType' => 'json',
                                    'url' => CController::createUrl('/prodModels/subCatOfThisCat'),
                                    'success' => 'function(data) {
                                                $("#Inventory_brand_id").html(data.subCatList);
                                         }',
                                    'data' => array(
                                            'catId' => 'js:jQuery("#Inventory_item_id").val()',
                                    ),
                                    'beforeSend' => 'function(){
                                                    document.getElementById("Inventory_brand_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 80% 1px";   
                                         }',
                                    'complete' => 'function(){
                                            document.getElementById("Inventory_brand_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/downDrop.png) no-repeat #FFFFFF 98% 2px"; 
                                        }',
                            ),
                    ));
                    ?>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'item_id'); ?></span>
            </div>

            <div class="form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model, 'brand_id'); ?>
                <div class="input-group" data-target-input="nearest"><?php
                    echo $form->dropDownList(
                            $model, 'brand_id', CHtml::listData(ProdBrands::model()->findAll(array('order' => 'brand_name ASC')), 'id', 'brand_name'), array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                    ));
                    ?>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'brand_id'); ?></span>
            </div>


            <div class="form-group col-sm-12 col-md-2">
                <?php echo $form->labelEx($model, 'model_id'); ?>
                <div class="input-group" id="model_id" data-target-input="nearest">
                    <input type="text" id="model_id_text" class="form-control">
                    <?php echo $form->hiddenField($model, 'model_id', array('class' => 'form-control',)); ?>
                    <div class="input-group-append" onclick="clearProduct()">
                        <div class="input-group-text"><i class="fa fa-refresh"></i></div>
                    </div>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'model_id'); ?></span>
            </div>


        </div>
    </div>
    <div class="card-footer">
        <?php
        echo CHtml::submitButton('Search', array(
                        'ajax' => array(
                                'type' => 'POST',
                                'url' => CController::createUrl('/inventory/inventory/stockReportSupplierWiseView'),
                                'beforeSend' => 'function(){
                                    $(".ajaxLoaderResultView").show();
                                    $("#reportSearchButton").prop("disabled", true);
                                    $("#reportSearchButton").val("Please wait ...");
                            }',
                                'error' => 'function(XMLHttpRequest, textStatus, errorThrown){
                                $(".ajaxLoaderResultView").hide();
					           // showErrorText(XMLHttpRequest, textStatus, errorThrown);
					            $("#reportSearchButton").prop("disabled", false);
                                $("#reportSearchButton").val("Search");
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


    $("#resetBtn").click(function () {
        clearProduct();
    });

    function clearProduct() {
        $("#model_id_text").val("");
        $("#Inventory_model_id").val("");
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

