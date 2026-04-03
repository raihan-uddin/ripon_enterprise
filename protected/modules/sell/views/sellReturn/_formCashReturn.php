<?php
/* @var $this SellReturnController */
/* @var $model SellReturn */
/* @var $model2 SellReturnDetails */
/* @var $form CActiveForm */
?>

<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Return', 'url' => array('admin')),
        array('name' => 'Create'),
    ),
));
Yii::app()->clientScript->registerCoreScript("jquery.ui");
?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<style>
/* ── pr- Design System (Cash Return - compact) ── */
.pr-card{border:none;border-radius:16px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);margin-bottom:24px}
.pr-card-header{background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);padding:16px 22px;position:relative;overflow:hidden}
.pr-card-header::before{content:'';position:absolute;inset:0;background:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);background-size:22px 22px}
.pr-card-header::after{content:'';position:absolute;top:-50px;right:-50px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.07)}
.pr-card-header .pr-title-row{display:flex;align-items:center;gap:12px;position:relative;z-index:1}
.pr-card-header .pr-icon-box{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;flex-shrink:0}
.pr-card-header .pr-title{font-size:16px;font-weight:800;color:#fff;margin:0;line-height:1.3}
.pr-card-header .pr-subtitle{font-size:11.5px;color:rgba(255,255,255,.65);margin:0}
.pr-card-header .pr-collapse-btn{background:rgba(255,255,255,.15);border:none;color:#fff;width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;margin-left:auto;position:relative;z-index:1}
.pr-card-body{padding:20px 22px;background:#fff}
.pr-card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;padding:12px 22px;display:flex;gap:10px;align-items:center;flex-wrap:wrap}

/* ── Floating-label inputs ── */
.pr-fl{position:relative;margin-bottom:14px}
.pr-fl .pr-fl-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#cbd5e1;font-size:13px;z-index:2;transition:color .2s}
.pr-fl .pr-fl-input{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:18px 12px 6px 38px;font-size:13px;color:#1e293b;background:#fff;outline:none;transition:border-color .2s,box-shadow .2s}
.pr-fl .pr-fl-input:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}
.pr-fl .pr-fl-label{position:absolute;left:38px;top:50%;transform:translateY(-50%);font-size:13px;color:#94a3b8;pointer-events:none;transition:all .2s}
.pr-fl .pr-fl-input:focus~.pr-fl-label,
.pr-fl .pr-fl-input:not([value=""])~.pr-fl-label,
.pr-fl .pr-fl-input:not(:placeholder-shown)~.pr-fl-label{top:5px;transform:none;font-size:9.5px;font-weight:700;color:#6366f1}
.pr-fl:focus-within .pr-fl-icon{color:#6366f1}

/* No-icon variant */
.pr-fl-no-icon .pr-fl-input{padding-left:12px}
.pr-fl-no-icon .pr-fl-label{left:12px}

/* ── Select fields ── */
.pr-select-group{margin-bottom:14px}
.pr-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#475569;margin-bottom:5px;letter-spacing:.3px}
.pr-select{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 36px 10px 12px;font-size:13px;color:#1e293b;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236366f1' d='M2 4l4 4 4-4'/%3E%3C/svg%3E") no-repeat right 12px center;-webkit-appearance:none;-moz-appearance:none;appearance:none;outline:none;transition:border-color .2s,box-shadow .2s}
.pr-select:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}

/* ── Input group addons ── */
.pr-fl .input-group-append,.pr-fl .input-group-prepend{position:absolute;right:0;top:0;height:100%;z-index:3;display:flex;align-items:center}
.pr-fl .input-group-append .input-group-text,.pr-fl .input-group-prepend .input-group-text{background:transparent;border:none;color:#94a3b8;font-size:13px;cursor:pointer;padding:0 10px}
.pr-fl .input-group-append .input-group-text:hover{color:#6366f1}

/* ── Error ── */
.pr-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block}

/* ── Buttons ── */
.pr-submit{background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;border-radius:9px;padding:10px 28px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);position:relative;overflow:hidden;transition:transform .15s,box-shadow .15s}
.pr-submit:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(99,102,241,.45)}
.pr-submit:active{transform:translateY(0)}
.pr-submit .pr-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.35);transform:scale(0);animation:pr-ripple-anim .6s linear}
@keyframes pr-ripple-anim{to{transform:scale(4);opacity:0}}

.pr-btn-success{background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;border-radius:8px;padding:8px 12px;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 2px 8px rgba(16,185,129,.3);transition:transform .15s}
.pr-btn-success:hover{transform:translateY(-1px);color:#fff}
.pr-btn-danger{background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border:none;border-radius:8px;padding:8px 12px;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 2px 8px rgba(239,68,68,.3);transition:transform .15s}
.pr-btn-danger:hover{transform:translateY(-1px);color:#fff}

/* ── Table ── */
.pr-table{width:100%;border-collapse:separate;border-spacing:0;font-size:13px}
.pr-table thead th{background:linear-gradient(135deg,#eef2ff,#e0e7ff);color:#4338ca;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:9px 10px;border-bottom:2px solid #c7d2fe}
.pr-table thead th:first-child{border-radius:8px 0 0 0}
.pr-table thead th:last-child{border-radius:0 8px 0 0}
.pr-table tbody td{padding:7px 10px;border-bottom:1px solid #f1f5f9;vertical-align:middle}
.pr-table tbody tr:hover{background:#f8fafc}
.pr-table .form-control{border:1.5px solid #e2e8f0;border-radius:6px;font-size:12px;padding:5px 7px}
.pr-table .form-control:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.1)}

/* ── Grid layout ── */
.pr-grid{display:grid;gap:14px}
.pr-grid-3{grid-template-columns:1fr 1fr 1fr}
.pr-grid-items{grid-template-columns:3fr 3fr 1fr 1fr 1fr 1fr}
@media(max-width:992px){.pr-grid-3,.pr-grid-items{grid-template-columns:1fr 1fr}.pr-action-col{grid-column:span 2}}
@media(max-width:576px){.pr-grid-3,.pr-grid-items{grid-template-columns:1fr}}

/* ── Misc ── */
.pr-remarks{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:10px;font-size:13px;color:#1e293b;outline:none;resize:vertical;min-height:50px;transition:border-color .2s,box-shadow .2s}
.pr-remarks:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}
.pr-loader{display:none}
.pr-result{margin-top:8px}

/* ── Inner card (Items) ── */
.pr-inner-card{border:1.5px solid #e0e7ff;border-radius:12px;overflow:hidden;margin-top:8px}
.pr-inner-header{background:linear-gradient(135deg,#eef2ff,#e0e7ff);padding:10px 18px;display:flex;align-items:center;justify-content:space-between}
.pr-inner-header .pr-inner-title{font-size:13px;font-weight:700;color:#4338ca;margin:0}
.pr-inner-header .pr-collapse-btn{background:rgba(99,102,241,.12);border:none;color:#6366f1;width:26px;height:26px;border-radius:6px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:11px}
.pr-inner-body{padding:16px 18px;background:#fff}
</style>


<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'sell-return-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
    )); ?>

    <div class="pr-card">
        <div class="pr-card-header">
            <div class="pr-title-row">
                <div class="pr-icon-box"><i class="fa fa-money"></i></div>
                <div>
                    <h3 class="pr-title"><?php echo($model->isNewRecord ? 'Create Return/Replacement' : 'Update Return/Replacement'); ?></h3>
                    <p class="pr-subtitle">Cash return or replacement processing</p>
                </div>
                <button type="button" class="pr-collapse-btn" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="pr-card-body">

            <div class="pr-grid pr-grid-3">
                <!-- Return Type (hidden) -->
                <div style="display:none">
                    <div class="pr-select-group">
                        <?php echo $form->labelEx($model, 'return_type', array('class' => 'pr-label')); ?>
                        <?php
                        echo $form->dropDownList(
                            $model, 'return_type', SellReturn::RETURN_TYPE_ARR, array(
                            'class' => 'pr-select',
                            'options' => array(
                                '' => array('selected' => 'selected'),
                                SellReturn::DAMAGE_RETURN => array('disabled' => true),
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'return_type', array('class' => 'pr-error')); ?>
                    </div>
                </div>

                <!-- Return Date -->
                <div>
                    <div class="pr-fl">
                        <i class="fa fa-calendar pr-fl-icon"></i>
                        <?php echo $form->textField($model, 'return_date', array('class' => 'pr-fl-input datetimepicker-input', 'placeholder' => ' ', 'value' => date('Y-m-d'), 'id' => 'SellReturn_return_date')); ?>
                        <label class="pr-fl-label">Return Date</label>
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        <?php echo $form->error($model, 'return_date', array('class' => 'pr-error')); ?>
                    </div>

                    <!-- Customer -->
                    <div class="pr-fl">
                        <i class="fa fa-user pr-fl-icon"></i>
                        <input type="text" id="customer_id_text" class="pr-fl-input" placeholder=" ">
                        <?php echo $form->hiddenField($model, 'customer_id', array('maxlength' => 255, 'class' => 'form-control')); ?>
                        <label class="pr-fl-label">Customer</label>
                            <div class="input-group-text">
                                <?php
                                echo CHtml::link(' <i class="fa fa-plus"></i>', "",
                                    array(
                                        'onclick' => "{addDistributor(); $('#dialogAddDistributor').dialog('open');}"));
                                ?>

                                <?php
                                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'dialogAddDistributor',
                                    'options' => array(
                                        'title' => 'Add Customer',
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
                                    function addDistributor() {
                                        <?php
                                        echo CHtml::ajax(array(
                                            'url' => array('/sell/customers/createCustomerFromOutSide'),
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
                                                $('#dialogAddDistributor div.divForForm').html(data.div);
                                                      // Here is the trick: on submit-> once again this function!
                                                $('#dialogAddDistributor div.divForForm form').submit(addDistributor);
                                            }
                                            else
                                            {
                                                $('#dialogAddDistributor div.divForForm').html(data.div);
                                                setTimeout(\"$('#dialogAddDistributor').dialog('close') \",1000);
                                                $('#customer_id_text').val(data.label);
                                                $('#SellReturn_customer_id').val(data.id).change();
                                            }
                                        }",
                                        ))
                                        ?>
                                        return false;
                                    }
                                </script>
                            </div>
                        </div>
                        <?php echo $form->error($model, 'customer_id', array('class' => 'pr-error')); ?>

                        <script>
                            $(document).ready(function () {
                                $('#customer_id_text').autocomplete({
                                    source: function (request, response) {
                                        var search = request.term;
                                        $.post('<?php echo Yii::app()->baseUrl ?>/index.php/sell/customers/Jquery_customerSearch', {
                                                "q": search,
                                            },
                                            function (data) {
                                                response(data);
                                            }, "json");
                                    },
                                    minLength: 1,
                                    autoFocus: true,
                                    select: function (event, ui) {
                                        $('#customer_id_text').val(ui.item.value);
                                        $('#SellReturn_customer_id').val(ui.item.id);
                                        $('#SellReturn_city').val(ui.item.city);
                                        $('#SellReturn_state').val(ui.item.state);
                                    }
                                }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                    return $("<li></li>")
                                        .data("item.autocomplete", item)
                                        .append(`<a> ${item.name} <small><br>ID: ${item.id}, <br> Contact:  ${item.contact_no}</small></a>`)
                                        .appendTo(ul);
                                };

                            });
                        </script>
                    </div>
                </div>

                <div></div><!-- spacer for grid -->

                <div>
                    <!-- Discount -->
                    <div class="pr-fl">
                        <i class="fa fa-percent pr-fl-icon"></i>
                        <?php echo $form->textField($model, 'discount', array('maxlength' => 255, 'class' => 'pr-fl-input', 'onkeyup' => 'addDiscount();', 'placeholder' => ' ')); ?>
                        <label class="pr-fl-label">Discount</label>
                        <?php echo $form->error($model, 'discount', array('class' => 'pr-error')); ?>
                    </div>

                    <!-- Return Amount -->
                    <div class="pr-fl cash-return">
                        <i class="fa fa-money pr-fl-icon"></i>
                        <?php echo $form->textField($model, 'return_amount', array('maxlength' => 255, 'class' => 'pr-fl-input', 'placeholder' => ' ', 'readonly' => true)); ?>
                        <label class="pr-fl-label">Return Amount</label>
                        <?php echo $form->error($model, 'return_amount', array('class' => 'pr-error')); ?>
                    </div>
                </div>
            </div>

            <!-- Items Card -->
            <div class="pr-inner-card">
                <div class="pr-inner-header">
                    <h4 class="pr-inner-title"><i class="fa fa-cubes" style="margin-right:6px"></i>Items</h4>
                    <button type="button" class="pr-collapse-btn" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
                <div class="pr-inner-body">
                    <div class="pr-grid pr-grid-items" style="align-items:end">
                        <!-- Product -->
                        <div class="pr-fl" style="margin-bottom:0">
                            <i class="fa fa-cube pr-fl-icon"></i>
                            <input type="text" id="model_id_text" class="pr-fl-input" placeholder=" ">
                            <?php echo $form->hiddenField($model2, 'model_id', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                            <label class="pr-fl-label">Product</label>
                            
                                <div class="input-group-text" style="display:flex;gap:2px">
                                    <?php
                                    echo CHtml::link(' <i class="fa fa-plus"></i>', "",
                                        array(
                                            'onclick' => "{addProdModel(); $('#dialogAddProdModel').dialog('open');}"));
                                    ?>

                                    <?php
                                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
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
                                            <?php
                                            echo CHtml::ajax(array(
                                                'url' => array('/prodModels/createProdModelsFromOutSide'),
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
                                                            $('#SellReturnDetails_model_id').val(data.value);
                                                            $('#model_id_text').val(data.label);
                                                        }
                                                    }",
                                            ))
                                            ?>
                                            return false;
                                        }
                                    </script>
                                </div>
                                <span class="input-group-text" onclick="resetProduct()"><i class="fa fa-refresh"></i></span>
                            </div>
                            <?php echo $form->error($model, 'model_id', array('class' => 'pr-error')); ?>

                            <script>
                                $(document).ready(function () {
                                    $('#model_id_text').autocomplete({
                                        source: function (request, response) {
                                            var search = request.term;
                                            $.post('<?php echo Yii::app()->baseUrl ?>/index.php/prodModels/Jquery_showprodSearch', {
                                                "q": search,
                                            }, function (data) {
                                                response(data);

                                                if (data.length === 1 && data[0].id) {
                                                    $('#model_id_text').val(data[0].value);
                                                    $('#SellReturnDetails_model_id').val(data[0].id);
                                                    $('#SellReturnDetails_amount').val(data[0].sell_price);
                                                    $('#model_id_text').autocomplete('option', 'select').call($('#model_id_text')[0], null, {
                                                        item: data[0]
                                                    });
                                                    showPurchasePrice(data[0].purchasePrice);
                                                    showCurrentStock(data[0].stock);
                                                }
                                            }, "json");
                                        },
                                        minLength: 1,
                                        delay: 700,
                                        select: function (event, ui) {
                                            $('#model_id_text').val(ui.item.value);
                                            $('#SellReturnDetails_model_id').val(ui.item.id);
                                            $('#SellReturnDetails_amount').val(ui.item.sell_price);
                                            showPurchasePrice(ui.item.purchasePrice);
                                            showCurrentStock(ui.item.stock);

                                            var $form = $('#model_id_text').closest('form');
                                            var $inputs = $form.find(':input:visible:not([disabled])');
                                            var currentIndex = $inputs.index($('#model_id_text'));
                                            $inputs.eq(currentIndex + 1).focus();
                                        }
                                    }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                        var listItem = $("<li class='list-group-item p-2'></li>")
                                            .data("item.autocomplete", item)
                                            .append(`
                                        <div class="row align-items-center">
                                            <div class="col-10 0">
                                                <p class="m-1">${item.name}</p>
                                                <p class="m-1">
                                                    <small><strong>Code:</strong> ${item.code}</small>,
                                                    <small><strong>Purchase Price:</strong> ${item.purchasePrice}</small>,
                                                    <small><strong>Selling Price:</strong> ${item.sell_price}</small>
                                                    <small><strong>Stock:</strong> ${item.stock}</small>
                                                </p>
                                            </div>
                                        </div>`);

                                        return listItem.appendTo(ul);
                                    };
                                });


                            </script>
                        </div>

                        <!-- Product SL No -->
                        <div class="pr-fl" style="margin-bottom:0">
                            <i class="fa fa-barcode pr-fl-icon"></i>
                            <input type="text" id="product_sl_no" class="pr-fl-input" placeholder=" ">
                            <label class="pr-fl-label">Product SL No</label>
                                <button class="btn btn-warning btn-sm" type="button" onclick="verifyProductSlNo()" style="position:absolute;right:36px;top:50%;transform:translateY(-50%);padding:2px 8px;font-size:11px;border-radius:5px">Verify</button>
                                <span class="input-group-text" onclick="resetProductSlNo()"><i class="fa fa-refresh"></i></span>
                            </div>
                            <?php echo $form->error($model, 'product_sl_no', array('class' => 'pr-error')); ?>

                            <script>
                                $(document).ready(function () {
                                    $('#product_sl_no').autocomplete({
                                        source: function (request, response) {
                                            var search = request.term;
                                            $.post('<?php echo Yii::app()->baseUrl ?>/index.php/sell/sellOrder/Jquery_showSoldProdSlNoSearch', {
                                                "q": search,
                                                "model_id": $('#SellReturnDetails_model_id').val(),
                                                'show_all': <?php echo Inventory::SHOW_ALL_PRODUCT_SL_NO; ?>
                                            }, function (data) {
                                                response(data);
                                                if (data.length === 1 && data[0].id) {
                                                    $('#model_id_text').val(data[0].label);
                                                    $('#replace_model_id_text').val(data[0].label);
                                                    $('#product_sl_no').val(data[0].product_sl_no);
                                                    $('#SellReturnDetails_model_id').val(data[0].sell_price);
                                                    $('#SellReturnDetails_amount').val(data[0].sell_price).change();
                                                    $('#SellReturnDetails_qty').val(1).change();
                                                    showPurchasePrice(data[0].purchasePrice);

                                                    $('#product_sl_no').autocomplete('option', 'select').call($('#product_sl_no')[0], null, {
                                                        item: data[0]
                                                    });

                                                    addToList();
                                                }
                                            }, "json");
                                        },
                                        minLength: 1,
                                        delay: 700,
                                        select: function (event, ui) {
                                            $('#model_id_text').val(ui.item.label);
                                            $('#product_sl_no').val(ui.item.product_sl_no);
                                            $('#SellReturnDetails_model_id').val(ui.item.id);
                                            $('#SellReturnDetails_amount').val(ui.item.sell_price);
                                            $('#SellReturnDetails_qty').val(1);
                                            showPurchasePrice(ui.item.purchasePrice);

                                            var $form = $('#product_sl_no').closest('form');
                                            var $inputs = $form.find(':input:visible:not([disabled])');
                                            var currentIndex = $inputs.index($('#product_sl_no'));
                                            $inputs.eq(currentIndex + 1).focus();

                                            addToList();
                                        }
                                    }).data("ui-autocomplete")._renderItem = function (ul, item) {
                                        var listItem = $("<li class='list-group-item p-2'></li>")
                                            .data("item.autocomplete", item)
                                            .append(`
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <p class="m-1">${item.product_sl_no}</p>
                                                <p class="mb-0" style="font-size: 10px;">
                                                    <small><strong>Name:</strong> ${item.name}</small>, <br>
                                                    <small><strong>Code:</strong> ${item.code}</small>,
                                                    <small><strong>Sell Price:</strong> ${item.sell_price}</small>,
                                                    <small><strong>Purchase Price:</strong> ${item.purchasePrice}</small>,
                                                    <small><strong>Stock:</strong> ${item.stock}</small>
                                                </p>
                                            </div>
                                        </div>`);

                                        return listItem.appendTo(ul);
                                    };
                                });

                            </script>
                        </div>

                        <!-- Qty -->
                        <div class="pr-fl pr-fl-no-icon" style="margin-bottom:0">
                            <?php echo $form->textField($model2, 'qty', array('maxlength' => 255, 'class' => 'pr-fl-input qty-amount', 'placeholder' => ' ')); ?>
                            <label class="pr-fl-label">Qty</label>
                            <span class="help-block current-stock" style="font-size:11px;color:#10b981;margin:2px 0 0;padding:0"></span>
                            <?php echo $form->error($model2, 'qty', array('class' => 'pr-error')); ?>
                        </div>

                        <!-- Unit Price -->
                        <div class="pr-fl pr-fl-no-icon cash-return" style="margin-bottom:0">
                            <?php echo $form->textField($model2, 'amount', array('maxlength' => 255, 'class' => 'pr-fl-input qty-amount', 'placeholder' => ' ')); ?>
                            <?php echo $form->hiddenField($model2, 'pp', array('maxlength' => 255, 'class' => 'form-control pp')); ?>
                            <label class="pr-fl-label">Price</label>
                            <span class="help-block costing-amount" style="font-size:11px;color:#10b981;margin:2px 0 0;padding:0"></span>
                            <?php echo $form->error($model2, 'amount', array('class' => 'pr-error')); ?>
                        </div>

                        <!-- Row Total -->
                        <div class="pr-fl pr-fl-no-icon cash-return" style="margin-bottom:0">
                            <?php echo $form->textField($model2, 'row_total', array('maxlength' => 255, 'class' => 'pr-fl-input', 'readonly' => true, 'placeholder' => ' ')); ?>
                            <label class="pr-fl-label">Total</label>
                            <?php echo $form->error($model2, 'row_total', array('class' => 'pr-error')); ?>
                        </div>

                        <!-- Action buttons -->
                        <div class="pr-action-col" style="display:flex;gap:8px;padding-bottom:14px;align-items:flex-start;padding-top:4px">
                            <button class="pr-btn-success" onclick="addToList()" type="button" title="ADD TO LIST">
                                <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                            </button>
                            <button class="pr-btn-danger" onclick="resetDynamicItem()" type="button" title="RESET">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div style="overflow-x:auto;margin-top:14px">
                        <table class="pr-table" id="list">
                            <thead>
                            <tr>
                                <th style="width:2%">SL</th>
                                <th>Product Name</th>
                                <th style="width:20%" class="text-center">Product Sl No</th>
                                <th style="width:10%" class="text-center">Qty</th>
                                <th style="width:10%" class="text-center cash-return">Unit Price</th>
                                <th style="width:10%" class="text-center cash-return">Row Total</th>
                                <th style="width:4%" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <!-- Remarks -->
                    <div style="margin-top:14px">
                        <?php echo $form->textArea($model, 'remarks', array('class' => 'pr-remarks', 'placeholder' => 'Return Note')); ?>
                        <?php echo $form->error($model, 'remarks', array('class' => 'pr-error')); ?>
                    </div>
                </div>

                <div class="pr-card-footer">
                    <?php
                    echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('/sell/sellReturn/create', 'render' => true)), array(
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
                                bootstrap.Modal.getOrCreateInstance(document.getElementById('information-modal')).show();
                                $("#information-modal .modal-body").html(data.soReportInfo);
                            }else{
                                $.each(data, function(key, val) {
                                    $("#bom-form #"+key+"_em_").html(""+val+"");
                                    $("#bom-form #"+key+"_em_").show();
                                });
                            }
                        }',
                        'beforeSend' => 'function(){
                            let count_item =  $(".item").length;
                            let date = $("#SellReturn_return_date").val();
                            let customer_id = $("#SellReturn_customer_id").val();
                            let grand_total = $("#SellReturn_return_amount").val();
                            if(date == ""){
                                toastr.error("Please insert date.");
                                return false;
                            }else if(customer_id == ""){
                                toastr.error("Please select customer from the list!");
                                return false;
                            }else if(count_item <= 0){
                                toastr.error("Please add products to list.");
                                return false;
                            }else if(grand_total == "" || grand_total <= 0){
                                toastr.error("Total return amount is 0");
                                return false;
                            }else {
                                $("#overlay").fadeIn(300);
                                $("#ajaxLoader").show();
                            }
                         }',
                        'error' => 'function(xhr, status, error) {
                            toastr.error(xhr.responseText);
                            console.error(xhr.statusText);
                            console.error(xhr.status);
                            console.error(xhr.responseText);

                            $("#overlay").fadeOut(300);
                      }',
                        'complete' => 'function() {
                                $("#overlay").fadeOut(300);
                             $("#ajaxLoaderReport").hide();
                          }',
                    ), array('class' => 'pr-submit', 'onclick' => 'prRipple(event,this)'));
                    ?>
                    <span id="ajaxLoaderMR" class="pr-loader">
                        <i class="fa fa-spinner fa-spin fa-2x" style="color:#6366f1"></i>
                    </span>
                    <div id="formResult" class="pr-result"></div>
                    <div id="formResultError" class="pr-result alert alert-danger d-none" role="alert"></div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>

<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-bs-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

    /* Ripple effect for submit */
    function prRipple(e, btn) {
        var r = document.createElement('span');
        r.className = 'pr-ripple';
        var rect = btn.getBoundingClientRect();
        r.style.left = (e.clientX - rect.left) + 'px';
        r.style.top = (e.clientY - rect.top) + 'px';
        r.style.width = r.style.height = Math.max(rect.width, rect.height) + 'px';
        btn.appendChild(r);
        setTimeout(function(){ r.remove(); }, 600);
    }

    $(document).ready(function () {
        $("input:text").focus(function () {
            $(this).select();
        });
    });

    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('SellReturn_return_date').value = date.format('YYYY-MM-DD');
        }
    });

    function resetDynamicItem() {
        resetProduct();
        resetProductSlNo();
    }

    function resetProduct() {
        $("#model_id_text").val('');
        $("#replace_model_id").val('');
        $("#SellReturnDetails_model_id").val('');
        resetProductSlNo();
        showPurchasePrice(0);
        tableSerial();
    }


    function resetProductSlNo() {
        $("#product_sl_no").val('');
        $("#SellReturnDetails_model_id").val('');
    }


    function showPurchasePrice(purchasePrice = 0) {
        if (purchasePrice > 0)
            $('.costing-amount').html('<span style="color: green;">P.P: <b>' + parseFloat(purchasePrice).toFixed(2) + '</b></span>');
        else
            $('.costing-amount').html('');
        $("#SellOrderDetails_pp").val(purchasePrice);
    }

    function showCurrentStock(stock = 0, className = 'current-stock') {
        if (stock >= 0) {
            $('.current-stock').html('<span style="color: green;">Stock: <b>' + parseFloat(stock).toFixed(2) + '</b></span>');
        } else
            $('.current-stock').html('<span style="color: green;">Stock: <b>' + parseFloat(stock).toFixed(2) + '</b></span>');
    }

    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            addToList();
            return false;
        }
    });


    function verifyProductSlNo() {
        let product_sl = $('#product_sl_no').val();
        if (product_sl.length === 0) {
            toastr.error('Please enter a valid Product SL No.');
            return;
        }
        $('#overlay').fadeIn();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/inventory/inventory/verifyProduct') ?>',
            data: {product_sl: product_sl},
            success: function (data) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('information-modal')).show();
                $('#information-modal .modal-body').html(data);

                $('#overlay').fadeOut();
            },
            error: function (data) {
                $('#formResultError').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' +
                    '  <strong>Error!</strong> ' + data.responseText +
                    '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>');
                $('#overlay').fadeOut();
            }
        });
        $('#product_sl_no_text').focus();
    }

    $("#list").on("click", ".dlt", function () {
        $(this).closest("tr").remove();
        tableSerial();
        // calculateTotal();
    });

    function addToList() {
        let model_id = $('#SellReturnDetails_model_id').val();
        let product_sl_no = $('#product_sl_no').val();
        let qty = $('#SellReturnDetails_qty').val();
        let amount = $('#SellReturnDetails_amount').val();
        let row_total = $('#SellReturnDetails_row_total').val();
        let pp = $('#SellReturnDetails_pp').val();

        if (model_id === '' || qty === '' || amount === '' || row_total === '') {
            toastr.error('Please fill all the fields');
            return;
        }

        let sl = $('#list tr').length;
        let html = `<tr class="item">
                <td class="serial"></td>
                <td>
                     <input type="hidden" name="SellReturnDetails[model_id][]" value="${model_id}">
                    ${$('#model_id_text').val()}
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[product_sl_no][]" class="form-control" value="${product_sl_no}">
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[qty][]" class="form-control text-center temp_qty" value="${qty}">
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[amount][]" class="form-control temp_unit_price text-end" value="${amount}">
                </td>
                <td>
                    <input type="text" name="SellReturnDetails[row_total][]" class="form-control row-total text-end" value="${row_total}">
                </td>
                <td>
                    <button type="button" class="pr-btn-danger dlt" style="padding:5px 9px"><i class="fa fa-trash"></i></button>
                </td>
            </tr>`;
        $('#list tbody').prepend(html);
        resetDataAfterAdd();
        tableSerial();
    }

    function resetDataAfterAdd() {
        console.log('resetDataAfterAdd');
        $("#product_sl_no").val();
        $("#SellReturnDetails_qty").val();
        $("#SellReturnDetails_amount").val();
        $("#SellReturnDetails_row_total").val();
    }

    function tableSerial() {
        var i = $('#list tbody tr').length;
        $('#list tbody tr').each(function () {
            $(this).find('.serial').text(i);
            i--;
        });
    }

    $("#SellReturnDetails_qty").on('change keyup', function () {
        let qty = $(this).val();
        let price = $("#SellReturnDetails_amount").val();
        let row_total = calculateRowTotal(qty, price);
        $("#SellReturnDetails_row_total").val(row_total);
        console.log('amount row total: ' + row_total + ', price: ' + price + ', qty: ' + qty);
    });

    $("#SellReturnDetails_amount").on('change keyup', function () {
        let price = $(this).val();
        let qty = $("#SellReturnDetails_qty").val();

        let row_total = calculateRowTotal(qty, price);
        $("#SellReturnDetails_row_total").val(row_total);
        console.log('amount row total: ' + row_total + ', price: ' + price + ', qty: ' + qty);
    });


    function calculateRowTotal(qty, price) {
        let unitQty = parseFloat(qty);
        unitQty = isNaN(unitQty) ? 0 : unitQty;

        let unitPrice = parseFloat(price);
        unitPrice = isNaN(unitPrice) ? 0 : unitPrice;

        return (unitQty * unitPrice).toFixed(2);
    }

</script>
