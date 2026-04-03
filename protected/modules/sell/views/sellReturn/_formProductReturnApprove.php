
<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Return', 'url' => array('admin')),
        array('name' => 'Approve'),
    ),
));

Yii::app()->clientScript->registerCoreScript("jquery.ui");
?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<style>
/* ── pr- Design System (Approve) ── */
.pr-card{border:none;border-radius:16px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);margin-bottom:24px}
.pr-card-header{background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);padding:18px 26px;position:relative;overflow:hidden}
.pr-card-header::before{content:'';position:absolute;inset:0;background:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);background-size:22px 22px}
.pr-card-header::after{content:'';position:absolute;top:-50px;right:-50px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.07)}
.pr-card-header .pr-title-row{display:flex;align-items:center;gap:12px;position:relative;z-index:1}
.pr-card-header .pr-icon-box{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;flex-shrink:0}
.pr-card-header .pr-title{font-size:16px;font-weight:800;color:#fff;margin:0;line-height:1.3}
.pr-card-header .pr-subtitle{font-size:11.5px;color:rgba(255,255,255,.65);margin:0}
.pr-card-header .pr-collapse-btn{background:rgba(255,255,255,.15);border:none;color:#fff;width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;margin-left:auto;position:relative;z-index:1}
.pr-card-body{padding:22px 26px;background:#fff}
.pr-card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;padding:14px 26px;display:flex;gap:10px;align-items:center;flex-wrap:wrap}

/* ── Info grid ── */
.pr-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
@media(max-width:768px){.pr-info-grid{grid-template-columns:1fr}}
.pr-info-row{display:flex;padding:10px 0;border-bottom:1px solid #f1f5f9}
.pr-info-row:last-child{border-bottom:none}
.pr-info-label{font-size:11.5px;font-weight:700;text-transform:uppercase;color:#64748b;letter-spacing:.3px;min-width:130px;padding-right:12px}
.pr-info-value{font-size:13.5px;color:#1e293b;font-weight:500}

/* ── Table ── */
.pr-table{width:100%;border-collapse:separate;border-spacing:0;font-size:13px;margin-top:16px}
.pr-table thead th{background:linear-gradient(135deg,#eef2ff,#e0e7ff);color:#4338ca;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:10px 12px;border-bottom:2px solid #c7d2fe}
.pr-table thead th:first-child{border-radius:8px 0 0 0}
.pr-table thead th:last-child{border-radius:0 8px 0 0}
.pr-table tbody td{padding:10px 12px;border-bottom:1px solid #f1f5f9;vertical-align:middle}
.pr-table tbody tr:hover{background:#f8fafc}
.pr-table .form-control{border:1.5px solid #e2e8f0;border-radius:6px;font-size:12px;padding:6px 8px}
.pr-table .form-control:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.1)}

/* ── Submit ── */
.pr-submit{background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;border-radius:9px;padding:10px 28px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);position:relative;overflow:hidden;transition:transform .15s,box-shadow .15s}
.pr-submit:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(99,102,241,.45)}
.pr-submit:active{transform:translateY(0)}
.pr-submit .pr-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.35);transform:scale(0);animation:pr-ripple-anim .6s linear}
@keyframes pr-ripple-anim{to{transform:scale(4);opacity:0}}

.pr-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block}
.hidden{display:none}
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
                <div class="pr-icon-box"><i class="fas fa-check-circle"></i></div>
                <div>
                    <h3 class="pr-title">Approve Return Request #<?php echo CHtml::encode($model->id); ?></h3>
                    <p class="pr-subtitle">Review and approve product return</p>
                </div>
                <button type="button" class="pr-collapse-btn" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="pr-card-body">
            <div class="pr-info-grid">
                <div style="padding-right:20px">
                    <div class="pr-info-row">
                        <span class="pr-info-label">Return Date</span>
                        <span class="pr-info-value"><?php echo CHtml::encode($model->return_date); ?></span>
                    </div>
                    <div class="pr-info-row">
                        <span class="pr-info-label">Customer</span>
                        <span class="pr-info-value"><?php echo CHtml::encode($model->customer->company_name); ?></span>
                    </div>
                    <div class="pr-info-row">
                        <span class="pr-info-label">Return Type</span>
                        <span class="pr-info-value"><?php echo $model->return_type == SellReturn::CASH_RETURN ? "CASH RETURN" : "WARRANTY/REPLACEMENT"; ?></span>
                    </div>
                </div>
                <div style="padding-left:20px">
                    <div class="pr-info-row">
                        <span class="pr-info-label">Return Amount</span>
                        <span class="pr-info-value"><?php echo CHtml::encode($model->return_amount); ?></span>
                    </div>
                    <div class="pr-info-row">
                        <span class="pr-info-label">Costing</span>
                        <span class="pr-info-value"><?php echo CHtml::encode($model->costing); ?></span>
                    </div>
                    <div class="pr-info-row">
                        <span class="pr-info-label">Remarks</span>
                        <span class="pr-info-value"><?php echo CHtml::encode($model->remarks); ?></span>
                    </div>
                </div>
            </div>

            <table class="pr-table">
                <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-center">Product SL No</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Replace Product</th>
                    <th class="text-center">Replace Product SL No</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($model->sellReturnDetails as $detail) {
                    ?>
                    <tr>
                        <td><?php echo CHtml::encode($detail->model->model_name); ?></td>
                        <td class="text-center"><?php echo CHtml::encode($detail->product_sl_no); ?></td>
                        <td class="text-center"><?php echo CHtml::encode($detail->return_qty); ?></td>
                        <td>
                            <?php
                                echo $form->hiddenField($detail, "id[]", array(
                                    'value' => $detail->id
                                ));
                                echo $form->hiddenField($detail, "replace_model_id[]", array(
                                    'id' => 'SellReturnDetails_' . $detail->id . '_replace_model_id',
                                    'value' => $detail->replace_model_id ? $detail->replace_model_id : $detail->model_id
                                ));
                            ?>
                            <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                'name' => 'replace_model_text',
                                'value' => $detail->model->model_name,
                                'source' => $this->createUrl('/prodModels/Jquery_showprodSearch'),
                                'options' => array(
                                    'minLength' => '1',
                                    'select' => 'js:function(event, ui) {
                                        $("#SellReturnDetails_' . $detail->id . '_replace_model_id").val(ui.item.id);
                                        $("#SellReturnDetails_' . $detail->id . '_replace_model_text").val(ui.item.value);
                                        $("#SellReturnDetails_' . $detail->id . '_replace_product_sl_no").val("");
                                    }'
                                ),
                                'htmlOptions' => array(
                                    'class' => 'form-control',
                                    'id' => 'SellReturnDetails_' . $detail->id . '_replace_model_text',
                                ),
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                    'name' => 'SellReturnDetails[replace_product_sl_no][]',
                                    'value' => $detail->replace_product_sl_no,
                                    'source' => 'js:function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/inventory/inventory/Jquery_showprodSlNoSearch') . '",
                                            dataType: "json",
                                            method: "POST",
                                            data: {
                                                q: request.term,
                                                model_id: $("#SellReturnDetails_' . $detail->id . '_replace_model_id").val()
                                            },
                                            success: function(data) {
                                                response(data);
                                            }
                                        });
                                    }',
                                    'options' => array(
                                        'minLength' => '1',
                                        'select' => 'js:function(event, ui) {
                                            $("#SellReturnDetails_' . $detail->id . '_replace_product_sl_no").val(ui.item.value);
                                            $("#SellReturnDetails_' . $detail->id . '_replace_model_id").val(ui.item.id);
                                            $("#SellReturnDetails_' . $detail->id . '_replace_model_text").val(ui.item.label);
                                        }',
                                        'create' => 'js:function() {
                                            var that = this;
                                            $(this).data("ui-autocomplete")._renderItem = function(ul, item) {
                                                var listItem = $("<li class=\'list-group-item p-2\'></li>")
                                                    .data("item.autocomplete", item)
                                                    .append(`
                                                        <div class="row align-items-center">
                                                            <div class="col-12">
                                                                <p class="m-1">${item.product_sl_no}</p>
                                                                <p class="mb-0" style="font-size: 10px;">
                                                                    <small><strong>Name:</strong> ${item.name}</small>, <br>
                                                                    <small><strong>Code:</strong> ${item.code}</small>,
                                                                    <small><strong>Sell Price:</strong> ${item.sell_price}</small>,
                                                                    <small><strong>Purchase Price:</strong> ${item.purchase_price}</small>,
                                                                    <small><strong>Stock:</strong> ${item.stock}</small>
                                                                </p>
                                                            </div>
                                                        </div>`
                                                    );

                                                return listItem.appendTo(ul);
                                            };
                                        }'
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'form-control',
                                        'id' => 'SellReturnDetails_' . $detail->id . '_replace_product_sl_no',
                                    ),
                                ));
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="pr-card-footer">
            <?php
                echo CHtml::ajaxSubmitButton('Approve', CHtml::normalizeUrl(array('/sell/sellReturn/approve', 'id' => $model->id, 'render' => true)),  array(
                    'dataType' => 'json',
                    'type' => 'post',
                    'success' => 'function(data) {
                        $("#ajaxLoader").hide();
                        if(data.status=="success"){
                            $("#formResult").fadeIn();
                            $("#formResult").html("Data saved successfully.");
                            toastr.success("Data saved successfully.");
                            $("#sell-return-form")[0].reset();
                            $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                            $("#list tbody").html("");
                            bootstrap.Modal.getOrCreateInstance(document.getElementById("information-modal")).show();
                            $("#information-modal .modal-body").html(data.voucherPreview);
                        }else{
                            toastr.error("Data not saved. Please solve the following errors.");
                            $.each(data, function(key, val) {
                                $("#sell-return-form #"+key+"_em_").html(""+val+"");
                                $("#sell-return-form #"+key+"_em_").show();
                            });
                        }
                    }',
                    'beforeSend' => 'function(){
                        if(!confirm("Are you sure you want to approve this return request?")){
                            return false;
                        }
                        $("#overlay").fadeIn(300);
                        $("#ajaxLoader").show();

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
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

<script>
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
</script>
