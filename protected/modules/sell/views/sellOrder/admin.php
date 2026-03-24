<?php
/** @var mixed $model */
$this->widget('application.components.BreadCrumb', array(
        'crumbs' => array(
                array('name' => 'Sales', 'url' => array('admin')),
                array('name' => 'Order', 'url' => array('admin')),
                array('name' => 'Manage'),
        ),
));

?>

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

    /* ── Date subtotal row ── */
    td.extrarow {
        background: #f0f4f8;
        border-top: 1px dashed #b0c4d8;
        border-bottom: 2px solid #2c3e50;
        padding: 5px 12px;
    }

    .dst-wrap {
        display: flex;
        align-items: center;
        gap: 0;
        flex-wrap: wrap;
        font-size: 12px;
    }

    .dst-orders {
        background: #1a2c3d;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
        margin-right: 8px;
        white-space: nowrap;
    }

    .dst-sep {
        color: #c8d8e8;
        margin: 0 6px;
    }

    .dst-item {
        font-size: 11px;
        color: #4a6278;
        white-space: nowrap;
    }

    .dst-lbl {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 9px;
        letter-spacing: 0.5px;
        color: #7f8c9a;
    }

    .dst-total {
        background: #e6f9ee;
        color: #1a7a40;
        font-weight: 700;
        font-size: 12px;
        padding: 2px 10px;
        border-radius: 8px;
        border: 1px solid #a8d5b5;
        margin-left: 4px;
        white-space: nowrap;
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
        <div class="alert alert-<?php echo $key; ?> alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-<?php echo ($key === 'success') ? 'check-circle' : 'exclamation-triangle'; ?>" style="margin-right:6px;"></i>
            <?php echo $user->getFlash($key); ?>
        </div>
    <?php
    endif;
endforeach;
?>
<script>
    setTimeout(function () {
        $('.alert.fade.show').fadeOut(600, function () { $(this).remove(); });
    }, 4000);
</script>

<div id="statusMsg"></div>

<?php
if (Yii::app()->user->checkAccess('Sell.Order.VoucherPreview')) {
    ?>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-search" style="margin-right:6px;"></i>Preview Order</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body preview-card-body">
            <?php $form = $this->beginWidget('CActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
            )); ?>
            <div class="row align-items-center">
                <div class="col-md-5 col-sm-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="height:38px;">SO No</span>
                        </div>
                        <?php echo $form->textField($model, 'so_no', array(
                                'maxlength' => 255,
                                'class' => 'form-control',
                                'placeholder' => 'Enter SO number or select date range...',
                                'aria-describedby' => 'basic-addon1',
                        )); ?>
                        <div class="input-group-append">
                            <span class="input-group-text" style="height:38px; padding:0 6px;">
                            <?php echo $form->dropDownList(
                                    $model, 'print_type', [
                                    SellOrder::NORMAL_ORDER_PRINT => 'Normal Print',
                                    SellOrder::NORMAL_PAD_PRINT => 'Pad Print',
                                    SellOrder::DELIVERY_CHALLAN_PRINT => 'Challan Print',
                            ], array('class' => 'form-control', 'style' => 'border:none; height:36px;'));
                            ?>
                            </span>
                        </div>
                    </div>
                    <span class="help-block" style="color:red; width:100%;">
                        <?php echo $form->error($model, 'so_no'); ?>
                    </span>
                </div>

                <div class="col-md-2 col-sm-12">
                    <?php
                    echo CHtml::ajaxLink(
                            '<i class="fa fa-print"></i> &nbsp;Preview',
                            Yii::app()->createUrl('/sell/sellOrder/voucherPreview'), array(
                            'type' => 'POST',
                            'beforeSend' => "function(){
                                let so_no = $('#SellOrder_so_no').val();
                                let dateRange = $('#daterange-picker').val();
                                if(so_no == '' && dateRange == ''){
                                    toastr.error('Please insert SO No or select a date range!');
                                    return false;
                                }
                                $('#overlay').fadeIn(300);
                            }",
                            'success' => "function(data){
                                if(data.status=='error'){
                                    toastr.error('No data found!');
                                } else {
                                    $('#information-modal').modal('show');
                                    $('#information-modal .modal-body').html(data);
                                }
                                $('#overlay').fadeOut(300);
                            }",
                            'complete' => "function(){
                                $('#overlay').fadeOut(300);
                            }",
                            'data' => array(
                                    'so_no'          => 'js:jQuery("#SellOrder_so_no").val()',
                                    'preview_type'   => 'js:jQuery("#SellOrder_print_type").val()',
                                    'date_range'     => 'js:jQuery("#daterange-picker").val()',
                                    'printOrPreview' => 'print',
                            )
                    ), array('class' => 'btn btn-info')
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
        <h3 class="card-title"><i class="fa fa-list" style="margin-right:6px;"></i>Manage Orders</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php
        $dataProvider = $model->search();
        $pageRows = $dataProvider->getData();
        $pageTotals = array('discount_amount' => 0, 'delivery_charge' => 0, 'road_fee' => 0, 'damage_value' => 0, 'sr_commission' => 0, 'grand_total' => 0);
        $dateSubtotals = array();
        foreach ($pageRows as $_r) {
            foreach ($pageTotals as $_k => $_v) $pageTotals[$_k] += $_r->$_k;
            $_d = $_r->date;
            if (!isset($dateSubtotals[$_d])) {
                $dateSubtotals[$_d] = array('count' => 0, 'discount_amount' => 0, 'delivery_charge' => 0, 'road_fee' => 0, 'damage_value' => 0, 'sr_commission' => 0, 'grand_total' => 0);
            }
            $dateSubtotals[$_d]['count']++;
            foreach (array('discount_amount', 'delivery_charge', 'road_fee', 'damage_value', 'sr_commission', 'grand_total') as $_k) {
                $dateSubtotals[$_d][$_k] += (float)$_r->$_k;
            }
        }
        $this->widget('ext.groupgridview.GroupGridView', array(
                'id' => 'sell-order-grid',
                'dataProvider' => $dataProvider,
                'filter' => $model,
                'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
                'htmlOptions' => array('class' => 'table-responsive grid-view'),
                'itemsCssClass' => 'table table-sm table-hover table-bordered dataTable dtr-inline',
                'mergeColumns'       => array('order_type', 'date'),
                'extraRowColumns'    => array('date'),
                'extraRowPos'        => 'below',
                'extraRowExpression' => function($data, $row, $totals, $grid) use ($dateSubtotals) {
                    $d = $data->date;
                    $t = isset($dateSubtotals[$d]) ? $dateSubtotals[$d] : array('count'=>0,'discount_amount'=>0,'delivery_charge'=>0,'road_fee'=>0,'damage_value'=>0,'sr_commission'=>0,'grand_total'=>0);
                    $parts = array();
                    if ($t['discount_amount'] > 0) $parts[] = '<span class="dst-item"><span class="dst-lbl">Disc</span> ' . number_format($t['discount_amount'], 2) . '</span>';
                    if ($t['delivery_charge'] > 0) $parts[] = '<span class="dst-item"><span class="dst-lbl">Del</span> ' . number_format($t['delivery_charge'], 2) . '</span>';
                    if ($t['road_fee']        > 0) $parts[] = '<span class="dst-item"><span class="dst-lbl">Road</span> ' . number_format($t['road_fee'], 2) . '</span>';
                    if ($t['damage_value']    > 0) $parts[] = '<span class="dst-item"><span class="dst-lbl">Dmg</span> ' . number_format($t['damage_value'], 2) . '</span>';
                    if ($t['sr_commission']   > 0) $parts[] = '<span class="dst-item"><span class="dst-lbl">Comm</span> ' . number_format($t['sr_commission'], 2) . '</span>';
                    $sep = '<span class="dst-sep">·</span>';
                    $body = count($parts) ? (implode($sep, $parts) . $sep) : '';
                    return '<div class="dst-wrap">'
                        . '<span class="dst-orders">' . $t['count'] . ' order' . ($t['count'] != 1 ? 's' : '') . '</span>'
                        . $body
                        . '<span class="dst-total"><i class="fa fa-calculator" style="margin-right:4px;"></i>' . number_format($t['grand_total'], 2) . '</span>'
                        . '</div>';
                },
                'template' => "<div class='row' style='text-align:right; margin-bottom:6px;'>{pager}</div>\n{summary}{items}{summary}\n{pager}",
                'summaryText' => "
                    <div style='display:inline-flex; align-items:center; gap:8px; font-size:12px; color:#6c757d; padding:4px 0; flex-wrap:wrap;'>
                        <span style='background:#e8f4fd; color:#1a6fa3; font-weight:700; font-size:11px; padding:2px 10px; border-radius:10px; border:1px solid #b0cfe8; font-family:monospace;'>{start}–{end}</span>
                        <span>of <strong style='color:#1a2c3d;'>{count}</strong> orders</span>
                        <span style='color:#dee2e6;'>|</span>
                        <span style='background:#f0f4f8; color:#4a6278; font-size:11px; font-weight:600; padding:2px 8px; border-radius:8px; border:1px solid #c8d8e8;'>
                            Page {page} of {pages}
                        </span>
                    </div>",
                'emptyText' => "<div class='alert alert-warning text-center' role='alert'><i class='icon fa fa-exclamation-triangle'></i> No results found.</div>",
                'summaryCssClass' => 'col-sm-12 col-md-6',
                'pagerCssClass' => 'col-xs-12 text-right',
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
                        'pageSize' => 20,
                ),
                'columns' => array(
                        array(
                                'name' => 'date',
                                'footer' => '<span class="grid-footer-label">Page Total</span>',
                                'footerHtmlOptions' => ['class' => 'text-right grid-footer-label-cell'],
                                'htmlOptions' => ['class' => 'text-center', 'style' => 'width:100px;'],
                        ),
                        array(
                                'name' => 'so_no',
                                'type' => 'raw',
                                'footer' => '',
                                'value' => 'CHtml::tag("span", ["class"=>"so-pill", "onclick"=>"copySoNo(this)", "title"=>"Click to copy"], CHtml::encode($data->so_no))',
                                'htmlOptions' => ['class' => 'text-center', 'style' => 'width:120px;'],
                        ),
                        array(
                                'name' => 'customer_id',
                                'footer' => '',
                                'value' => 'Customers::model()->nameOfThis($data->customer_id)',
                                'htmlOptions' => ['class' => 'text-left'],
                        ),
                        array(
                                'name' => 'discount_amount',
                                'header' => 'Disc.',
                                'headerHtmlOptions' => ['title' => 'Discount Amount', 'style' => 'cursor:help;'],
                                'footer' => $pageTotals['discount_amount'] > 0 ? number_format($pageTotals['discount_amount'], 2) : '<span class="val-zero">—</span>',
                                'footerHtmlOptions' => ['class' => 'text-right grid-footer-cell'],
                                'type' => 'raw',
                                'value' => '$data->discount_amount > 0 ? number_format($data->discount_amount, 2) : "<span class=\"val-zero\">—</span>"',
                                'htmlOptions' => ['class' => 'text-right', 'style' => 'width:75px;'],
                        ),
                        array(
                                'name' => 'delivery_charge',
                                'header' => 'Del.',
                                'headerHtmlOptions' => ['title' => 'Delivery Charge', 'style' => 'cursor:help;'],
                                'footer' => $pageTotals['delivery_charge'] > 0 ? number_format($pageTotals['delivery_charge'], 2) : '<span class="val-zero">—</span>',
                                'footerHtmlOptions' => ['class' => 'text-right grid-footer-cell'],
                                'type' => 'raw',
                                'value' => '$data->delivery_charge > 0 ? number_format($data->delivery_charge, 2) : "<span class=\"val-zero\">—</span>"',
                                'htmlOptions' => ['class' => 'text-right', 'style' => 'width:70px;'],
                        ),
                        array(
                                'name' => 'road_fee',
                                'header' => 'Road',
                                'headerHtmlOptions' => ['title' => 'Road Fee', 'style' => 'cursor:help;'],
                                'footer' => $pageTotals['road_fee'] > 0 ? number_format($pageTotals['road_fee'], 2) : '<span class="val-zero">—</span>',
                                'footerHtmlOptions' => ['class' => 'text-right grid-footer-cell'],
                                'type' => 'raw',
                                'value' => '$data->road_fee > 0 ? number_format($data->road_fee, 2) : "<span class=\"val-zero\">—</span>"',
                                'htmlOptions' => ['class' => 'text-right', 'style' => 'width:60px;'],
                        ),
                        array(
                                'name' => 'damage_value',
                                'header' => 'Dmg.',
                                'headerHtmlOptions' => ['title' => 'Damage Value', 'style' => 'cursor:help;'],
                                'footer' => $pageTotals['damage_value'] > 0 ? number_format($pageTotals['damage_value'], 2) : '<span class="val-zero">—</span>',
                                'footerHtmlOptions' => ['class' => 'text-right grid-footer-cell'],
                                'type' => 'raw',
                                'value' => '$data->damage_value > 0 ? number_format($data->damage_value, 2) : "<span class=\"val-zero\">—</span>"',
                                'htmlOptions' => ['class' => 'text-right', 'style' => 'width:65px;'],
                        ),
                        array(
                                'name' => 'sr_commission',
                                'header' => 'Comm.',
                                'headerHtmlOptions' => ['title' => 'SR Commission', 'style' => 'cursor:help;'],
                                'footer' => $pageTotals['sr_commission'] > 0 ? number_format($pageTotals['sr_commission'], 2) : '<span class="val-zero">—</span>',
                                'footerHtmlOptions' => ['class' => 'text-right grid-footer-cell'],
                                'type' => 'raw',
                                'value' => '$data->sr_commission > 0 ? number_format($data->sr_commission, 2) : "<span class=\"val-zero\">—</span>"',
                                'htmlOptions' => ['class' => 'text-right', 'style' => 'width:70px;'],
                        ),
                        array(
                                'name' => 'grand_total',
                                'header' => 'Total',
                                'headerHtmlOptions' => ['title' => 'Grand Total', 'style' => 'cursor:help;'],
                                'footer' => number_format($pageTotals['grand_total'], 2),
                                'footerHtmlOptions' => ['class' => 'text-right grid-footer-grand'],
                                'type' => 'raw',
                                'value' => 'CHtml::tag("span", ["class"=>"grand-cell"], number_format($data->grand_total, 2))',
                                'htmlOptions' => ['class' => 'text-right', 'style' => 'width:95px;'],
                        ),
                        array(
                                'name' => 'created_by',
                                'header' => 'By',
                                'headerHtmlOptions' => ['title' => 'Created By', 'style' => 'cursor:help;'],
                                'footer' => '',
                                'filter' => false,
                                'type' => 'raw',
                                'value' => 'CHtml::tag("span", ["class"=>"badge badge-info text-capitalize"], Users::model()->nameOfThis($data->created_by))',
                                'htmlOptions' => ['class' => 'text-center', 'style' => 'width:100px;'],
                        ),
                        array(
                                'name' => 'created_at',
                                'header' => 'At',
                                'headerHtmlOptions' => ['title' => 'Created At', 'style' => 'cursor:help;'],
                                'footer' => '',
                                'htmlOptions' => ['class' => 'text-center', 'style' => 'width:130px;'],
                        ),
                        array(
                                'header' => 'Actions',
                                'template' => '{singleInvoice}{createMr}{update}{delete}',
                                'class' => 'CButtonColumn',
                                'htmlOptions' => ['style' => 'width:160px;', 'class' => 'actions-cell'],
                                'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
                                'buttons' => array(
                                        'singleInvoice' => array(
                                                'label' => '<i class="fa fa-file-pdf-o"></i>',
                                                'imageUrl' => false,
                                                'options' => array(
                                                        'class' => 'action-btn btn-preview',
                                                        'rel' => 'tooltip',
                                                        'data-toggle' => 'tooltip',
                                                        'title' => Yii::t('app', 'Preview Invoice'),
                                                ),
                                                'url' => '"#" . $data->id',
                                                'click' => "function() {
                                                    var invoiceId = $(this).attr('href').replace('#', '');
                                                    $('#overlay').fadeIn(300);
                                                    $.post('" . Yii::app()->controller->createUrl('voucherPreview') . "', { invoiceId: invoiceId })
                                                        .done(function(data) {
                                                            $('#overlay').fadeOut(300);
                                                            $('#information-modal .modal-body').html(data);
                                                            $('#information-modal').modal('show');
                                                        })
                                                        .fail(function(xhr) {
                                                            $('#overlay').fadeOut(300);
                                                            toastr.error('Error: ' + xhr.responseText);
                                                        });
                                                    return false;
                                                }",
                                        ),
                                        'createMr' => array(
                                                'label' => '<i class="fa fa-money"></i>',
                                                'imageUrl' => false,
                                                'options' => array(
                                                        'class' => 'action-btn btn-payment',
                                                        'rel' => 'tooltip',
                                                        'data-toggle' => 'tooltip',
                                                        'title' => Yii::t('app', 'Create MR'),
                                                ),
                                                'url' => 'Yii::app()->controller->createUrl("/accounting/moneyReceipt/create",array("id"=>$data->customer_id, "sell_id"=>$data->id))',
                                                'visible' => '$data->total_paid == 0 ? TRUE : FALSE',
                                        ),
                                        'update' => array(
                                                'label' => '<i class="fa fa-pencil-square-o"></i>',
                                                'imageUrl' => false,
                                                'options' => array(
                                                        'class' => 'action-btn btn-edit',
                                                        'rel' => 'tooltip',
                                                        'data-toggle' => 'tooltip',
                                                        'title' => Yii::t('app', 'Edit'),
                                                ),
                                        ),
                                        'delete' => array(
                                                'label' => '<i class="fa fa-trash"></i>',
                                                'imageUrl' => false,
                                                'options' => array(
                                                        'class' => 'action-btn btn-delete',
                                                        'rel' => 'tooltip',
                                                        'data-toggle' => 'tooltip',
                                                        'title' => Yii::t('app', 'Delete'),
                                                ),
                                                'url' => 'Yii::app()->controller->createUrl("delete", array("id"=>$data->id))',
                                                'click' => 'function(e){
                                                    e.preventDefault();
                                                    var pin = prompt("Enter PIN to delete:");
                                                    if(pin !== "3083"){
                                                        alert("Invalid PIN!");
                                                        return false;
                                                    }
                                                    if(confirm("Are you sure you want to delete?")){
                                                        $.fn.yiiGridView.update("sell-order-grid", {
                                                            type: "POST",
                                                            url: $(this).attr("href"),
                                                            success: function(){
                                                                $.fn.yiiGridView.update("sell-order-grid");
                                                            }
                                                        });
                                                    }
                                                    return false;
                                                }',
                                        ),
                                ),
                        ),
                ),
        )); ?>
    </div>

    <div class="card-footer" style="background:#f8f9fa; padding:8px 16px;">
        <div class="row" style="align-items:center;">
            <div class="col-sm-12 col-md-6"></div>
            <div class="col-sm-12 col-md-6 text-right">
                <div class="goto-page-wrap" style="justify-content:flex-end;">
                    <span>Go to page</span>
                    <input type="number" id="goto-page-input" class="form-control" min="1" placeholder="Page #"/>
                    <button onclick="goToPage()"><i class="fa fa-arrow-right"></i> Go</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<div class="modal fade" id="information-modal" tabindex="-1" data-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
<div id="ajaxLoaderView" style="display:none;">
    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" alt="Loading"/>
</div>
<div id="AjFlash" style="display:none; margin-top:20px;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    function goToPage() {
        var page = parseInt($('#goto-page-input').val(), 10);
        if (!page || page < 1) return;
        $.fn.yiiGridView.update('sell-order-grid', {
            data: { 'sell-order-grid_page': page }
        });
        $('#goto-page-input').val('');
    }

    $(document).on('keypress', '#goto-page-input', function (e) {
        if (e.which === 13) goToPage();
    });

    function copySoNo(el) {
        var text = el.innerText.trim();

        // Copy using execCommand (works on HTTP)
        var tmp = document.createElement('textarea');
        tmp.value = text;
        tmp.style.position = 'fixed';
        tmp.style.opacity = '0';
        document.body.appendChild(tmp);
        tmp.select();
        document.execCommand('copy');
        document.body.removeChild(tmp);

        // Show tip above the pill
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
