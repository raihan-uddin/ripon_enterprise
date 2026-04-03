<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Sales', 'url' => array('admin')),
        array('name' => 'Collection', 'url' => array('admin')),
        array('name' => 'Manage'),
    ),
));
?>

<style>
    /* ── Grid header ── */
    #money-receipt-grid th {
        background: #f0f4f8;
        color: #1a2c3d;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        white-space: nowrap;
        padding: 8px 10px;
        border: 1px solid #c8d8e8;
        border-bottom: 2px solid #2c3e50;
    }

    /* ── Filter row inputs ── */
    #money-receipt-grid .filters input,
    #money-receipt-grid .filters select {
        width: 100%;
        font-size: 12px;
        height: 28px;
        padding: 2px 6px;
        border: 1px solid #c8d8e8;
        border-radius: 4px;
        background: #fff;
        color: #212529;
    }

    #money-receipt-grid .filters input:focus,
    #money-receipt-grid .filters select:focus {
        border-color: #17a2b8;
        box-shadow: 0 0 0 2px rgba(23,162,184,0.15);
        outline: none;
    }

    /* ── Grid rows ── */
    #money-receipt-grid td {
        vertical-align: middle;
        font-size: 13px;
        padding: 7px 10px;
    }

    #money-receipt-grid tr:hover td {
        background: #f0f7ff !important;
    }

    /* ── Action buttons ── */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 6px;
        font-size: 14px;
        margin: 2px;
        text-decoration: none;
        transition: background 0.15s, transform 0.1s, box-shadow 0.1s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .action-btn:hover {
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    }

    .action-btn:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .btn-preview  { background: #e6f4ea; color: #1a7a40; border: 1px solid #a8d5b5; }
    .btn-payment  { background: #e8f4fd; color: #1a6fa3; border: 1px solid #a8cce8; }
    .btn-edit     { background: #fff8e6; color: #8a6200; border: 1px solid #e0c870; }
    .btn-delete   { background: #fdecea; color: #b71c1c; border: 1px solid #e8a8a8; }

    .btn-preview:hover  { background: #c8ecd1; color: #155a2e; }
    .btn-payment:hover  { background: #cce6f8; color: #114e7a; }
    .btn-edit:hover     { background: #ffefc0; color: #6b4a00; }
    .btn-delete:hover   { background: #fad4d0; color: #8b1111; }

    /* ── Actions cell ── */
    .actions-cell {
        white-space: nowrap;
        text-align: center;
        padding: 6px 8px !important;
    }

    /* ── Pagination ── */
    .col-xs-12 .pagination {
        float: right;
        margin: 4px 0;
    }

    .col-xs-12::after {
        content: '';
        display: table;
        clear: both;
    }

    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        font-size: 13px;
        border: 1px solid #c8d8e8;
        border-radius: 5px !important;
        margin: 2px;
        color: #1a6fa3;
        background: #fff;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }

    .pagination li a:hover {
        background: #e8f4fd;
        border-color: #1a6fa3;
        color: #1a6fa3;
    }

    .pagination li.active a,
    .pagination li.active span {
        background: #1a2c3d;
        border-color: #1a2c3d;
        color: #fff;
        font-weight: 700;
    }

    .pagination li.disabled a,
    .pagination li.disabled span {
        color: #aaa;
        border-color: #e0e0e0;
        background: #f8f9fa;
        pointer-events: none;
    }

    /* ── Go to page ── */
    .goto-page-wrap {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #6c757d;
    }

    .goto-page-wrap input {
        width: 90px;
        height: 30px;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #c8d8e8;
        border-radius: 5px;
        padding: 0 6px;
        color: #1a2c3d;
    }

    .goto-page-wrap input:focus {
        border-color: #17a2b8;
        outline: none;
        box-shadow: 0 0 0 2px rgba(23,162,184,0.15);
    }

    .goto-page-wrap button {
        height: 30px;
        padding: 0 10px;
        font-size: 12px;
        font-weight: 600;
        background: #1a2c3d;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.15s;
    }

    .goto-page-wrap button:hover {
        background: #2c3e50;
    }
</style>

<style>
    /* ── Grid header ── */
    #sell-order-grid th {
        background: #f0f4f8;
        color: #1a2c3d;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        white-space: nowrap;
        padding: 8px 10px;
        border: 1px solid #c8d8e8;
        border-bottom: 2px solid #2c3e50;
    }

    /* ── Filter row inputs ── */
    #sell-order-grid .filters input,
    #sell-order-grid .filters select {
        width: 100%;
        font-size: 12px;
        height: 28px;
        padding: 2px 6px;
        border: 1px solid #c8d8e8;
        border-radius: 4px;
        background: #fff;
        color: #212529;
    }

    #sell-order-grid .filters input:focus,
    #sell-order-grid .filters select:focus {
        border-color: #17a2b8;
        box-shadow: 0 0 0 2px rgba(23,162,184,0.15);
        outline: none;
    }

    /* ── Grid rows ── */
    #sell-order-grid td {
        vertical-align: middle;
        font-size: 13px;
        padding: 7px 10px;
    }

    #sell-order-grid tr:hover td {
        background: #f0f7ff !important;
    }

    /* ── SO number pill ── */
    .so-pill {
        display: inline-block;
        position: relative;
        background: #e8f4fd;
        color: #1a6fa3;
        font-weight: 700;
        font-size: 12px;
        font-family: monospace;
        padding: 3px 9px;
        border-radius: 12px;
        border: 1px solid #b0cfe8;
        white-space: nowrap;
        cursor: pointer;
        user-select: none;
        transition: background 0.15s;
    }

    .so-pill:hover {
        background: #d0eaf8;
    }

    .so-pill.copied {
        background: #e6f9ee;
        color: #1a7a40;
        border-color: #a8d5b5;
    }

    .so-copy-tip {
        position: fixed;
        background: #1a7a40;
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 4px;
        white-space: nowrap;
        pointer-events: none;
        z-index: 99999;
        transform: translateX(-50%);
        transition: opacity 0.3s, top 0.3s;
    }

    /* ── Grand total ── */
    .grand-cell {
        font-weight: 700;
        font-size: 13px;
        color: #1a7a40;
    }

    /* ── Zero value ── */
    .val-zero {
        color: #bbb;
        font-size: 12px;
    }

    /* ── Action buttons ── */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 6px;
        font-size: 14px;
        margin: 2px;
        text-decoration: none;
        transition: background 0.15s, transform 0.1s, box-shadow 0.1s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .action-btn:hover {
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    }

    .action-btn:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .btn-preview  { background: #e6f4ea; color: #1a7a40; border: 1px solid #a8d5b5; }
    .btn-payment  { background: #e8f4fd; color: #1a6fa3; border: 1px solid #a8cce8; }
    .btn-edit     { background: #fff8e6; color: #8a6200; border: 1px solid #e0c870; }
    .btn-delete   { background: #fdecea; color: #b71c1c; border: 1px solid #e8a8a8; }

    .btn-preview:hover  { background: #c8ecd1; color: #155a2e; }
    .btn-payment:hover  { background: #cce6f8; color: #114e7a; }
    .btn-edit:hover     { background: #ffefc0; color: #6b4a00; }
    .btn-delete:hover   { background: #fad4d0; color: #8b1111; }

    /* ── Actions cell ── */
    .actions-cell {
        white-space: nowrap;
        text-align: center;
        padding: 6px 8px !important;
    }

    /* ── Pagination ── */
    .col-xs-12 .pagination {
        float: right;
        margin: 4px 0;
    }

    .col-xs-12::after {
        content: '';
        display: table;
        clear: both;
    }

    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        font-size: 13px;
        border: 1px solid #c8d8e8;
        border-radius: 5px !important;
        margin: 2px;
        color: #1a6fa3;
        background: #fff;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }

    .pagination li a:hover {
        background: #e8f4fd;
        border-color: #1a6fa3;
        color: #1a6fa3;
    }

    .pagination li.active a,
    .pagination li.active span {
        background: #1a2c3d;
        border-color: #1a2c3d;
        color: #fff;
        font-weight: 700;
    }

    .pagination li.disabled a,
    .pagination li.disabled span {
        color: #aaa;
        border-color: #e0e0e0;
        background: #f8f9fa;
        pointer-events: none;
    }

    /* ── Go to page ── */
    .goto-page-wrap {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #6c757d;
    }

    .goto-page-wrap input {
        width: 90px;
        height: 30px;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #c8d8e8;
        border-radius: 5px;
        padding: 0 6px;
        color: #1a2c3d;
    }

    .goto-page-wrap input:focus {
        border-color: #17a2b8;
        outline: none;
        box-shadow: 0 0 0 2px rgba(23,162,184,0.15);
    }

    .goto-page-wrap button {
        height: 30px;
        padding: 0 10px;
        font-size: 12px;
        font-weight: 600;
        background: #1a2c3d;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.15s;
    }

    .goto-page-wrap button:hover {
        background: #2c3e50;
    }

    /* ── Grid footer totals ── */
    #sell-order-grid tfoot td {
        background: #f0f4f8;
        border-top: 2px solid #2c3e50;
        padding: 7px 10px;
        font-size: 12px;
    }

    .grid-footer-label {
        font-weight: 700;
        color: #4a6278;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .grid-footer-label-cell {
        text-align: right !important;
    }

    .grid-footer-cell {
        font-weight: 600;
        color: #1a2c3d;
        font-size: 12px;
    }

    .grid-footer-grand {
        font-weight: 700;
        color: #1a7a40;
        font-size: 13px;
    }

    /* ── Preview card ── */
    .preview-card-body .input-group-text {
        background: #f8f9fa;
        font-weight: 600;
        font-size: 13px;
    }
</style>
<?php
$user = Yii::app()->getUser();
foreach ($user->getFlashKeys() as $key):
    if ($user->hasFlash($key)): ?>
        <div class="alert alert-<?php echo $key; ?> alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $user->getFlash($key); ?>
        </div>
    <?php
    endif;
endforeach;
?>

<div id="statusMsg"></div>
<?php
if (Yii::app()->user->checkAccess('Accounting.MoneyReceipt.VoucherPreview')) {
    ?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Preview MR</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
                <!--<button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fa fa-times"></i>
                </button>-->
            </div>
        </div>
        <div class="card-body">

            <?php $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
            )); ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        
                            <span class="input-group-text"
                                  id="basic-addon1">MR No</span>
                        </div>
                        <?php echo $form->textField($model, 'mr_no', array('maxlength' => 255, 'class' => 'form-control', "aria-describedby" => "basic-addon1")); ?>
                    </div>
                    <span class="help-block"
                          style="color: red; width: 100%"> <?php echo $form->error($model, 'mr_no'); ?></span>

                </div>


                <div class="col-md-3">
                    <?php
                    echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('/accounting/moneyReceipt/voucherPreview'), array(
                        'type' => 'POST',
                        'beforeSend' => "function(){
                        let mr_no = $('#MoneyReceipt_mr_no').val();
                        if(mr_no == ''){
                        toastr.error('Please insert MR no!');
                            return false;
                        }
                        $('#overlay').fadeIn(300);　 
                     }",
                        'success' => "function( data ){
                        if(data.status=='error'){
                            toastr.error('No data found!');
                        } else {
                         $('#viewDialog').dialog('open');   
                         $('#AjFlash').html(data).show();    
                        }      
                        $('#overlay').fadeOut(300);　                                                         
                    }",
                        'complete' => "function(){
                        $('#overlay').fadeOut(300);　      
                    }",
                        'data' => array(
                            'mr_no' => 'js:jQuery("#MoneyReceipt_mr_no").val()',
                            'printOrPreview' => 'print',
                        )
                    ), array(
                            'class' => 'btn btn-info',
                        )
                    );
                    ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <?php
}
?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Manage Money Receipt</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php $this->widget('ext.groupgridview.GroupGridView', array(
            'id' => 'money-receipt-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
            'htmlOptions' => array('class' => 'table-responsive grid-view'),
            'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
            'mergeColumns' => array('date', 'mr_no', 'payment_type', 'invoice_id', 'customer_id'),
            'mergeType' => 'nested',
            'pager' => array(
                'class'          => 'CLinkPager',
                'cssFile'        => false,
                'header'         => '',
                'firstPageLabel' => '<i class="fa fa-angle-double-left"></i>',
                'lastPageLabel'  => '<i class="fa fa-angle-double-right"></i>',
                'prevPageLabel'  => '<i class="fa fa-angle-left"></i>',
                'nextPageLabel'  => '<i class="fa fa-angle-right"></i>',
                'maxButtonCount' => 7,
                'htmlOptions'    => array('class' => 'pagination pagination-sm', 'style' => 'float:right; margin:4px 0;'),
                'selectedPageCssClass' => 'active',
                'hiddenPageCssClass'   => 'disabled',
            ),
            'template' => "<div class='row' style='text-align:right; margin-bottom:6px;'>{pager}</div>\n{summary}{items}{summary}\n{pager}",
            'summaryText' => "
    <div style='display:inline-flex; align-items:center; gap:8px; font-size:12px; color:#6c757d; padding:4px 0; flex-wrap:wrap;'>
        <span style='background:#e8f4fd; color:#1a6fa3; font-weight:700; font-size:11px; padding:2px 10px; border-radius:10px; border:1px solid #b0cfe8; font-family:monospace;'>{start}–{end}</span>
        <span>of <strong style='color:#1a2c3d;'>{count}</strong> records</span>
        <span style='color:#dee2e6;'>|</span>
        <span style='background:#f0f4f8; color:#4a6278; font-size:11px; font-weight:600; padding:2px 8px; border-radius:8px; border:1px solid #c8d8e8;'>
            Page {page} of {pages}
        </span>
    </div>",
            'summaryCssClass' => 'col-sm-12 col-md-6',
            'pagerCssClass'   => 'col-xs-12 text-end',
            'columns' => array(
                array(
                    'name' => 'date',
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width: 100px;']
                ),
                array(
                    'name'       => 'mr_no',
                    'type'       => 'raw',
                    'value'      => 'CHtml::tag("span", ["class"=>"so-pill", "onclick"=>"copySoNo(this)", "title"=>"Click to copy"], CHtml::encode($data->mr_no))',
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width:120px;'],
                ),
                array(
                    'name' => 'payment_type',
                    'header' => 'Col. Type',
                    'value' => 'MoneyReceipt::model()->paymentTypeString($data->payment_type)',
                    'type' => 'raw',
                    'filter' => CHtml::listData(MoneyReceipt::model()->paymentTypeFilter(), 'id', 'title'),
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width: 70px;']
                ),
                array(
                    'name' => 'customer_id',
                    'value' => 'Customers::model()->nameOfThis($data->customer_id)',
                    'htmlOptions' => ['class' => '', 'style' => 'width: 250px; text-align: left;']
                ),
                array(
                    'name' => 'invoice_id',
                    'header' => 'Invoice',
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width: 80px;']
                ),
                array(
                    'name' => 'amount',
                    'value' => 'number_format($data->amount, 2)',
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width: 80px;']
                ),

                array(
                    'name' => 'discount',
                    'value' => 'number_format($data->discount, 2)',
                    'htmlOptions' => ['class' => 'text-center', 'style' => 'width: 80px;']
                ),
                array(
                    'name' => 'remarks',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'created_by',
                    'value' => 'Users::model()->nameOfThis($data->created_by)',
                ),
                'created_at',
                /*
                'updated_by',
                'updated_at',
                */
                array
                (
                    'header' => 'Options',
                    'template' => '{update} {delete}',
                    'class' => 'CButtonColumn',
                    'htmlOptions' => ['class' => 'actions-cell'],
                    'buttons' => array(
                        'update' => array(
                            'label' => '<i class="fa fa-pencil"></i>',
                            'imageUrl' => false,
                            'url' => 'Yii::app()->createUrl("/accounting/moneyReceipt/update", array("id" => $data->id))',
                            'options' => array('class' => 'action-btn btn-edit', 'rel' => 'tooltip', 'data-bs-toggle' => 'tooltip', 'title' => 'Edit'),
                        ),
                        'delete' => array(
                            'label' => '<i class="fa fa-trash"></i>',
                            'imageUrl' => false,
                            'url' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->id))',
                            'options' => array('class' => 'action-btn btn-delete', 'rel' => 'tooltip', 'data-bs-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
                            'click' => 'function(e){
                                e.preventDefault();
                                var pin = prompt("Enter PIN to delete:");
                                if(pin !== "3083"){
                                    alert("Invalid PIN!");
                                    return false;
                                }
                                if(confirm("Are you sure you want to delete this money receipt?")){
                                    $.fn.yiiGridView.update("money-receipt-grid", {
                                        type: "POST",
                                        url: $(this).attr("href"),
                                        success: function(){
                                            $.fn.yiiGridView.update("money-receipt-grid");
                                            toastr.success("Money receipt deleted successfully.");
                                        }
                                    });
                                }
                                return false;
                            }',
                        ),
                    )
                ),
            ),
        )); ?>
    </div>
    <div class="card-footer" style="background:#f8f9fa; padding:8px 16px;">
        <div class="row" style="align-items:center;">
            <div class="col-sm-12 col-md-6"></div>
            <div class="col-sm-12 col-md-6 text-end">
                <div class="goto-page-wrap" style="justify-content:flex-end;">
                    <span>Go to page</span>
                    <input type="number" id="goto-page-input" class="form-control" min="1" placeholder="Page #"/>
                    <button onclick="goToPage()"><i class="fa fa-arrow-right"></i> Go</button>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'viewDialog',
    'options' => array(
        'title' => Yii::t('user', 'Viewing Single Data'),
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable' => false,
    ),
));
?>
<div id="ajaxLoaderView" style="display: none;"><img
            src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/></div>
<div id='AjFlash' style="display:none; margin-top: 20px;">

</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
function goToPage() {
    var page = parseInt($('#goto-page-input').val(), 10);
    if (!page || page < 1) return;
    $.fn.yiiGridView.update('money-receipt-grid', { data: { 'money-receipt-grid_page': page } });
    $('#goto-page-input').val('');
}
$(document).on('keypress', '#goto-page-input', function(e) {
    if (e.which === 13) goToPage();
});

function copySoNo(el) {
    var text = el.innerText.trim();
    var tmp = document.createElement('textarea');
    tmp.value = text;
    tmp.style.position = 'fixed';
    tmp.style.opacity = '0';
    document.body.appendChild(tmp);
    tmp.select();
    document.execCommand('copy');
    document.body.removeChild(tmp);

    el.classList.add('copied');
    var rect = el.getBoundingClientRect();
    var tip = document.createElement('span');
    tip.className = 'so-copy-tip';
    tip.innerText = '✓ Copied';
    tip.style.left    = (rect.left + rect.width / 2) + 'px';
    tip.style.top     = (rect.top - 32) + 'px';
    tip.style.opacity = '1';
    document.body.appendChild(tip);

    setTimeout(function () {
        tip.style.opacity = '0';
        tip.style.top = (rect.top - 42) + 'px';
    }, 900);

    setTimeout(function () {
        el.classList.remove('copied');
        if (tip.parentNode) tip.parentNode.removeChild(tip);
    }, 1300);
}
</script>
