<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Purchase', 'url' => array('admin')),
        array('name' => 'Order', 'url' => array('admin')),
        array('name' => 'Create'),
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

<div class="row">
    <div class="form-group col-xs-11 col-md-3 col-lg-3">
        <a class="btn  btn-warning" type="button" id="btnReload"
           href="<?= Yii::app()->request->requestUri ?>"><i class="fa fa-refresh"></i> Reload
        </a>
        <a class="btn btn-success text-right" type="button"
           href="<?= Yii::app()->baseUrl . '/index.php/commercial/purchaseOrder/admin' ?>"><i class="fa fa-home"></i>
            Purchase Order Manage
        </a>
    </div>
</div>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo($model->isNewRecord ? 'Create Order' : 'Update Order'); ?></h3>

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
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'order_type', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php
                        echo $form->dropDownList(
                            $model, 'order_type', [PurchaseOrder::PURCHASE => 'PURCHASE', PurchaseOrder::PURCHASE_RECEIVE => 'PURCHASE & RECEIVE'], array(
//                            'prompt' => 'Select',
                            'class' => 'form-control',
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'order_type'); ?></span>
                </div>
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'cash_due', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php
                        echo $form->dropDownList(
                            $model, 'cash_due', Lookup::items('cash_due'), array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'cash_due'); ?></span>
                </div>
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'date', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
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
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'exp_receive_date', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" id="exp_receive_date" data-target-input="nearest">
                            <?php echo $form->textField($model, 'exp_receive_date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD',)); ?>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'exp_receive_date'); ?></span>
                </div>
                <div class="form-group row" style="display: none;">
                    <?php echo $form->labelEx($model, 'store_id', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->dropDownList(
                            $model, 'store_id', CHtml::listData(Stores::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                            'ajax' => array(
                                'type' => 'POST',
                                'dataType' => 'json',
                                'url' => CController::createUrl('/inventory/location/subCatOfThisCat'),
                                'success' => 'function(data) {
                                    $("#PurchaseOrder_location_id").html(data.subCatList);
                                 }',
                                'data' => array(
                                    'store_id' => 'js:jQuery("#PurchaseOrder_store_id").val()',
                                ),
                                'beforeSend' => 'function(){
                                document.getElementById("PurchaseOrder_location_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 80% 1px";   
                         }',
                                'complete' => 'function(){
                            document.getElementById("PurchaseOrder_location_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/downDrop.png) no-repeat #FFFFFF 98% 2px"; 
                        }',
                            ),
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'store_id'); ?></span>
                </div>
                <div class="form-group row" style="display: none;">
                    <?php echo $form->labelEx($model, 'location_id', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->dropDownList(
                            $model, 'location_id', CHtml::listData(Location::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                            'prompt' => 'Select',
                            'class' => 'form-control',
                        ));
                        ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'location_id'); ?></span>
                </div>


                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'bill_to', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'bill_to', array('maxlength' => 255, 'class' => 'form-control',)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'bill_to'); ?></span>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'supplier_id', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group" data-target-input="nearest">
                            <input type="text" id="supplier_id_text" class="form-control">
                            <?php echo $form->hiddenField($model, 'supplier_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <?php
                                    echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                        array(
//                                    'class' => '',
                                            'onclick' => "{addSupplier(); $('#addSupplierDialog').dialog('open');}"));
                                    ?>


                                    <?php
                                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                        'id' => 'addSupplierDialog',
                                        'options' => array(
                                            'title' => 'Add Supplier',
                                            'autoOpen' => false,
                                            'modal' => true,
                                            'width' => 984,
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
                                        function addSupplier() {

                                            return false;
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'customer_id'); ?></span>

                    <script>
                        $(document).ready(function () {
                            $('#supplier_id_text').autocomplete({
                                source: function (request, response) {
                                    var search = request.term;
                                    $.post('<?php echo Yii::app()->baseUrl ?>/index.php/commercial/suppliers/jquery_supplierSearch', {
                                            "q": search,
                                        },
                                        function (data) {
                                            response(data);
                                        }, "json");
                                },
                                minLength: 1,
                                autoFocus: true,
                                select: function (event, ui) {
                                    $('#supplier_id_text').val(ui.item.value);
                                    $('#PurchaseOrder_supplier_id').val(ui.item.id);
                                    $('#PurchaseOrder_contact_no').val(ui.item.contact_no);
                                    $('#PurchaseOrder_address').val(ui.item.address);
                                }
                            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                return $("<li></li>")
                                    .data("item.autocomplete", item)
                                    .append(`<a> ${item.value} <small><br>Contact: ${item.contact_no}, Web: ${item.web}<br> Address:  ${item.address}</small></a>`)
                                    .appendTo(ul);
                            };

                        });
                    </script>
                </div>


                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'contact_no', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'contact_no', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'contact_no'); ?></span>
                </div>

                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'address', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'address', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'address'); ?></span>
                </div>

                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'ship_by', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">

                        <div class="input-group" data-target-input="nearest">
                            <?php
                            echo $form->dropDownList(
                                $model, 'ship_by', CHtml::listData(ShipBy::model()->findAll(array('order' => 'ship_by ASC')), 'id', 'ship_by'), array(
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
                                            'onclick' => "{addShipBy(); $('#addShipByDialog').dialog('open');}"));
                                    ?>

                                    <?php
                                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                        'id' => 'addShipByDialog',
                                        'options' => array(
                                            'title' => 'Add Ship By',
                                            'autoOpen' => false,
                                            'modal' => true,
                                            'width' => 'auto',
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
                                        function addShipBy() {

                                            return false;
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'ship_by'); ?></span>
                </div>

                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'ship_to', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'ship_to', array('maxlength' => 255, 'class' => 'form-control',)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'ship_to'); ?></span>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group row" style="display: none">
                    <?php echo $form->labelEx($model, 'item_count', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <?php echo $form->textField($model, 'item_count', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true, 'disabled' => true)); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'item_count'); ?></span>
                </div>
                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'total_amount', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3"><i class="fa fa-money"></i> </span>
                            </div>
                            <?php echo $form->textField($model, 'total_amount', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon3", 'readonly' => true)); ?>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'total_amount'); ?></span>
                </div>

                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'vat', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                            <?php echo $form->textField($model, 'vat_percentage', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '%', "aria-label" => "%", "aria-describedby" => "basic-addon1")); ?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-money"></i> </span>
                            </div>
                            <?php echo $form->textField($model, 'vat_amount', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '%', "aria-label" => "%", "aria-describedby" => "basic-addon2", 'readonly' => true)); ?>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'vat_percentage'); ?></span>
                </div>

                <div class="form-group row" style="">
                    <?php echo $form->labelEx($model, 'grand_total', ['class' => 'col-sm-4 col-form-label']); ?>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon4"><i class="fa fa-money"></i> </span>
                            </div>
                            <?php echo $form->textField($model, 'grand_total', array('maxlength' => 255, 'class' => 'form-control', 'placeholder' => '0', "aria-label" => "0", "aria-describedby" => "basic-addon4", 'readonly' => true)); ?>
                        </div>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'grand_total'); ?></span>
                </div>
            </div>
        </div>

        <div class="card card-info">
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
                    <div class="form-group col-xs-12 col-md-3 col-lg-2">
                        <?php echo $form->labelEx($model2, 'model_id'); ?>

                        <div class="input-group" data-target-input="nearest">
                            <input type="text" id="model_id_text" class="form-control">
                            <?php echo $form->hiddenField($model2, 'model_id', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <?php
                                    echo CHtml::link(' <i class="fa fa-plus"></i>', "", // the link for open the dialog
                                        array(
//                                    'class' => '',
                                            'onclick' => "{addProdModel(); $('#dialogAddProdModel').dialog('open');}"));
                                    ?>

                                    <?php
                                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                        'id' => 'dialogAddProdModel',
                                        'options' => array(
                                            'title' => 'Add Product',
                                            'autoOpen' => false,
                                            'modal' => true,
                                            'width' => '1288px',
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

                                            return false;
                                        }
                                    </script>
                                </div>
                            </div>
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
                                            },
                                            function (data) {
                                                response(data);
                                            }, "json");
                                    },
                                    minLength: 1,
                                    select: function (event, ui) {
                                        $('#model_id_text').val(ui.item.value);
                                        $('#PurchaseOrderDetails_model_id').val(ui.item.id);
                                        // $('#PurchaseOrderDetails_amount').val(ui.item.sell_price);
                                        $('#PurchaseOrderDetails_unit_id').val(ui.item.unit_id);
                                        $('#product_unit_text').html($('#PurchaseOrderDetails_unit_id option:selected').text());
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

                    <div class="form-group col-xs-12 col-md-2 col-lg-2">
                        <?php echo $form->labelEx($model2, 'product_sl_no'); ?>
                        <?php echo $form->textField($model2, 'product_sl_no', array('maxlength' => 255, 'class' => 'form-control')); ?>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'product_sl_no'); ?></span>
                    </div>

                    <div class="form-group col-xs-12 col-md-2 col-lg-2">
                        <?php echo $form->labelEx($model2, 'note'); ?>
                        <?php echo $form->textField($model2, 'note', array('maxlength' => 255, 'class' => 'form-control')); ?>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'note'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-1 col-lg-1">
                        <?php echo $form->labelEx($model2, 'qty'); ?>

                        <div class="input-group">
                            <?php echo $form->textField($model2, 'qty', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                            <div class="input-group-append">
                                <span class="input-group-text" id="product_unit_text"></span>
                                <?php
                                echo $form->dropDownList(
                                    $model2, 'unit_id', CHtml::listData(Units::model()->findAll(array('order' => 'label ASC')), 'id', 'label'), array(
                                    'prompt' => 'Select',
                                    'class' => 'form-control',
                                    'style' => 'display: none;',
                                ));
                                ?>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'qty'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-2 col-lg-2">
                        <?php echo $form->labelEx($model2, 'amount'); ?>

                        <div class="input-group">
                            <?php echo $form->textField($model2, 'amount', array('maxlength' => 255, 'class' => 'form-control qty-amount')); ?>
                            <div class="input-group-append">
                                <span class="input-group-text" id="amount"><i class="fa fa-money"></i> </span>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'amount'); ?></span>
                    </div>
                    <div class="form-group col-xs-12 col-md-2 col-lg-2">
                        <?php echo $form->labelEx($model2, 'row_total'); ?>
                        <div class="input-group">
                            <?php echo $form->textField($model2, 'row_total', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                            <div class="input-group-append">
                                <span class="input-group-text" id="amount"><i class="fa fa-money"></i> </span>
                            </div>
                        </div>
                        <span class="help-block"
                              style="color: red; width: 100%"> <?php echo $form->error($model2, 'row_total'); ?></span>
                    </div>

                    <div class="form-group col-xs-12 col-md-1 col-lg-1">
                        <button class="btn  btn-success mt-4" onclick="addToList()" type="button" title="ADD TO LIST">
                            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                        </button>
                        <button class="btn  btn-danger mt-4" onclick="resetDynamicItem()" type="button" title="RESET">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped table-valign-middle" id="list">
                            <thead class="table-info">
                            <tr>
                                <th>Product Name</th>
                                <th style="width: 20%;" class="text-center">Product SL No</th>
                                <th style="width: 20%;" class="text-center">Product Note</th>
                                <th style="width: 10%;" class="text-center">Qty</th>
                                <th style="width: 10%;" class="text-center">Unit Price</th>
                                <th style="width: 10%;" class="text-center">Row Total</th>
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

        <div class="row">
            <div class="col-md-12">
                <?php echo $form->textArea($model, 'order_note', array('class' => 'form-control', 'placeholder' => 'Order Note')); ?>
            </div>
            <span class="help-block"
                  style="color: red; width: 100%"> <?php echo $form->error($model, 'order_note'); ?></span>
        </div>
    </div>

    <div class="card-footer">
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('/commercial/purchaseOrder/create', 'render' => true)), array(
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
                    let cash_due = $("#PurchaseOrder_cash_due").val();  
                    let date = $("#PurchaseOrder_date").val();  
                    let customer_id = $("#PurchaseOrder_supplier_id").val();  
                    let grand_total = $("#PurchaseOrder_grand_total").val();  
                    if(cash_due == ""){
                        toastr.error("Please select Cash/Due.");
                        return false;
                    }else if(date == ""){
                        toastr.error("Please insert date.");
                        return false;
                    }else if(customer_id == ""){
                        toastr.error("Please select supplier from the list!");
                        return false;
                    }else if(count_item <= 0){
                        toastr.error("Please add product to list.");
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
<script>
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('PurchaseOrder_date').value = date.format('YYYY-MM-DD');
        }
    });
    var picker2 = new Lightpick({
        field: document.getElementById('PurchaseOrder_exp_receive_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('PurchaseOrder_exp_receive_date').value = date.format('YYYY-MM-DD');
            document.getElementById('PurchaseOrder_exp_receive_date').value = date.format('YYYY-MM-DD');
        }
    });

    $(document).ready(function () {
        $("#PurchaseOrderDetails_product_sl_no").keyup(function () {
            let sl_wise_purchase = $(this);
            if (sl_wise_purchase.length > 0) {
                $("#PurchaseOrderDetails_qty").val(1).change();
            } else {
                $("#PurchaseOrderDetails_qty").val('').change();
            }
        });
        $(".qty-amount").keyup(function () {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));
        });

        $(".qty-amount").on("keydown keyup", function () {
            let amount = parseFloat($("#PurchaseOrderDetails_amount").val());
            let qty = parseFloat($("#PurchaseOrderDetails_qty").val());
            amount = amount > 0 ? amount : 0;
            qty = qty > 0 ? qty : 0;

            $("#PurchaseOrderDetails_row_total").val((amount * qty).toFixed(2));
        });
        $("#PurchaseOrder_vat_percentage").on("keydown keyup", function () {
            calculateVat();
        });
    });

    function addToList() {
        let model_id = $("#PurchaseOrderDetails_model_id").val();
        let model_id_text = $("#model_id_text").val();
        let unit_price = $("#PurchaseOrderDetails_amount").val();
        let product_sl_no = $("#PurchaseOrderDetails_product_sl_no").val();
        let note = $("#PurchaseOrderDetails_note").val();
        let qty = $("#PurchaseOrderDetails_qty").val();
        let row_total = $("#PurchaseOrderDetails_row_total").val();
        let isproductpresent = false;
        let temp_codearray = document.getElementsByName("PurchaseOrderDetails[temp_model_id][]");
        let temp_sl_array = document.getElementsByName("PurchaseOrderDetails[temp_product_sl_no][]");
        // console.log(temp_sl_array);
        /* if (temp_codearray.length > 0) {
             for (let l = 0; l < temp_codearray.length; l++) {
                 var code = temp_codearray[l].value;
                 if (code == model_id) {
                     isproductpresent = true;
                     break;
                 }
             }
         }*/
        if (product_sl_no.length > 0) {
            // console.log("length found");
            for (let l = 0; l < temp_sl_array.length; l++) {
                let code = temp_sl_array[l].value;
                if (code === product_sl_no) {
                    isproductpresent = true;
                    break;
                }
            }
            // console.log(isproductpresent);
        }


        if (model_id == "" || model_id_text == "") {
            toastr.error("Please select materials");
            return false;
        } else if (isproductpresent == true) {
            toastr.error(model_id_text + " is already on the list! Please add another!");
            return false;
        } else if (unit_price == "") {
            toastr.error("Please insert unit price");
            return false;
        } else if (qty == "" || qty == 0) {
            toastr.error("Please enter qty");
            return false;
        } else if (row_total == "" || row_total == 0) {
            toastr.error("Please enter qty & amount!");
            return false;
        } else {
            $("#list tbody").append(`
                <tr class="item">
                    <td>${model_id_text}</td>
                    <td class="text-center">${product_sl_no}</td>
                    <td class="text-center">${note}</td>
                    <td class="text-center">${unit_price}</td>
                    <td class="text-center">${qty}</td>
                    <td class="text-center">
                        ${row_total}
                        <input type="hidden" class="form-control text-center" value="${qty}" name="PurchaseOrderDetails[temp_qty][]">
                        <input type="hidden" class="form-control text-center" value="${product_sl_no}" name="PurchaseOrderDetails[temp_product_sl_no][]">
                        <input type="hidden" class="form-control text-center" value="${note}" name="PurchaseOrderDetails[temp_note][]">
                        <input type="hidden" class="form-control" value="${model_id}" name="PurchaseOrderDetails[temp_model_id][]" >
                        <input type="hidden" class="form-control" value="${unit_price}" name="PurchaseOrderDetails[temp_unit_price][]" >
                        <input type="hidden" class="form-control row-total" value="${row_total}" name="PurchaseOrderDetails[temp_row_total][]" >
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger dlt"><i class="fa fa-trash-o"></i> </button>
                    </td>
                </tr>
                `);
            calculateTotal();
            clearDynamicItem(product_sl_no);
        }
    }

    $("#list").on("click", ".dlt", function () {
        $(this).closest("tr").remove();
        calculateTotal();
    });


    function calculateVat() {
        let total_amount = parseFloat($("#PurchaseOrder_total_amount").val());
        let vat_p = parseFloat($("#PurchaseOrder_vat_percentage").val());
        total_amount = total_amount > 0 ? total_amount : 0;
        vat_p = vat_p > 0 ? vat_p : 0;
        let vat = parseFloat(((vat_p / 100) * total_amount));
        let grand_total = parseFloat(total_amount + vat);
        $("#PurchaseOrder_vat_amount").val(vat.toFixed(2));
        $("#PurchaseOrder_grand_total").val(grand_total.toFixed(2));
    }

    function resetDynamicItem() {
        $("#PurchaseOrderDetails_model_id").val('');
        $("#model_id_text").val('');
        $("#PurchaseOrderDetails_product_sl_no").val('');
        $("#PurchaseOrderDetails_amount").val('');
        $("#PurchaseOrderDetails_row_total").val('');
        $("#PurchaseOrderDetails_qty").val('');
        $("#PurchaseOrderDetails_color").val('');
        $("#PurchaseOrderDetails_note").val('');
    }

    function clearDynamicItem(product_sl_no) {
        if (product_sl_no.length > 0) {
            $("#PurchaseOrderDetails_product_sl_no").val('');
            $("#PurchaseOrderDetails_product_sl_no").focus();
        } else {
            $("#PurchaseOrderDetails_model_id").val('');
            $("#model_id_text").val('');
            $("#PurchaseOrderDetails_product_sl_no").val('');
            $("#PurchaseOrderDetails_amount").val('');
            $("#PurchaseOrderDetails_row_total").val('');
            $("#PurchaseOrderDetails_qty").val('');
            $("#PurchaseOrderDetails_color").val('');
            $("#PurchaseOrderDetails_note").val('');
        }
    }

    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            // addToList();
            return false;
        }
    });

    function calculateTotal() {
        let item_count = $(".item").length;

        let total = 0;
        $('.row-total').each(function () {
            total += parseFloat($(this).val());
        });

        $("#PurchaseOrder_total_amount").val(total.toFixed(2)).change();
        $("#PurchaseOrder_item_count").val(item_count);
        calculateVat();
    }
</script>

<?php $this->endWidget(); ?>



<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'ORDER VOUCHER PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>

