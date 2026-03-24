<?php
$this->widget('application.components.BreadCrumb', array(
        'crumbs' => array(
                array('name' => 'Purchase', 'url' => array('admin')),
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

    /* ── Date subtotal row ── */
    td.extrarow {
        background: #f0f4f8;
        border-top: 1px dashed #b0c4d8;
        border-bottom: 2px solid #2c3e50;
        padding: 5px 12px;
    }
    .dst-wrap    { display:flex; align-items:center; gap:0; flex-wrap:wrap; font-size:12px; }
    .dst-orders  { background:#1a2c3d; color:#fff; font-size:10px; font-weight:700; padding:2px 8px; border-radius:10px; margin-right:8px; }
    .dst-total   { background:#e6f9ee; color:#1a7a40; font-weight:700; font-size:12px; padding:2px 10px; border-radius:8px; border:1px solid #a8d5b5; margin-left:4px; }
</style>

<?php
$user = Yii::app()->getUser();
foreach ($user->getFlashKeys() as $key):
    if ($user->hasFlash($key)): ?>
        <div class="alert alert-<?php echo $key; ?> alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $user->getFlash($key); ?>
        </div>
    <?php
    endif;
endforeach;
?>

<div id="statusMsg"></div>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Preview Order</h3>

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
            <div class="col-md-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="basic-addon1">PO No</span>
                    </div>
                    <?php echo $form->textField($model, 'po_no', array('maxlength' => 255, 'class' => 'form-control', "aria-describedby" => "basic-addon1")); ?>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'po_no'); ?></span>

            </div>

            <div class="col-md-3">
                <?php
                echo CHtml::ajaxLink(
                        "Print", Yii::app()->createUrl('/commercial/purchaseOrder/voucherPreview'), array(
                        'type' => 'POST',
                        'beforeSend' => "function(){
                        let po_no = $('#PurchaseOrder_po_no').val();
                        if(po_no == ''){
                        toastr.error('Please insert po no!');
                            return false;
                        }
                        $('#overlay').fadeIn(300);　 
                     }",
                        'success' => "function( data ){
                        if(data.status=='error'){
                            toastr.error('No data found!');
                        } else {
                             //$('#viewDialog').dialog('open');   
                             //$('#AjFlash').html(data).show();    
                             $('#information-modal').modal('show');
                             $('#information-modal .modal-body').html(data);   
                        }      
                        $('#overlay').fadeOut(300);　                                                         
                    }",
                        'complete' => "function(){
                        $('#overlay').fadeOut(300);　      
                    }",
                        'data' => array(
                                'po_no' => 'js:jQuery("#PurchaseOrder_po_no").val()',
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
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Manage Order</h3>

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
        $pageTotals = array('grand_total' => 0);
        $dateSubtotals = array();
        foreach ($pageRows as $_r) {
            $pageTotals['grand_total'] += (float)$_r->grand_total;
            $_d = $_r->date;
            if (!isset($dateSubtotals[$_d])) {
                $dateSubtotals[$_d] = array('count' => 0, 'grand_total' => 0);
            }
            $dateSubtotals[$_d]['count']++;
            $dateSubtotals[$_d]['grand_total'] += (float)$_r->grand_total;
        }
        ?>
        <?php $this->widget('ext.groupgridview.GroupGridView', array(
                'id' => 'sell-order-grid',
                'dataProvider' => $dataProvider,
                'filter' => $model,
                'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
                'htmlOptions' => array('class' => 'table-responsive grid-view'),
                'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
                'mergeColumns'       => array('date', 'supplier_id'),
                'mergeType'          => 'nested',
                'extraRowColumns'    => array('date'),
                'extraRowPos'        => 'below',
                'extraRowExpression' => function($data, $row, $totals, $grid) use ($dateSubtotals) {
                    $d = $data->date;
                    $t = isset($dateSubtotals[$d]) ? $dateSubtotals[$d] : array('count' => 0, 'grand_total' => 0);
                    return '<div class="dst-wrap">'
                        . '<span class="dst-orders">' . $t['count'] . ' order' . ($t['count'] != 1 ? 's' : '') . '</span>'
                        . '<span class="dst-total"><i class="fa fa-calculator" style="margin-right:4px;"></i>' . number_format($t['grand_total'], 2) . '</span>'
                        . '</div>';
                },
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
                'pagerCssClass'   => 'col-xs-12 text-right',
                'columns' => array(
                        array(
                                'name'              => 'id',
                                'footer'            => '',
                                'htmlOptions'       => ['class' => 'text-center', 'style' => 'width:80px;'],
                        ),
                        array(
                                'name'              => 'cash_due',
                                'type'              => 'raw',
                                'value'             => 'Lookup::item("cash_due", $data->cash_due)',
                                'filter'            => Lookup::items('cash_due'),
                                'footer'            => '',
                                'htmlOptions'       => ['class' => 'text-center'],
                        ),
                        array(
                                'name'              => 'date',
                                'footer'            => '<span class="grid-footer-label">Page Total</span>',
                                'footerHtmlOptions' => ['class' => 'text-right grid-footer-label-cell'],
                                'htmlOptions'       => ['class' => 'text-center', 'style' => 'width:100px;'],
                        ),
                        array(
                                'name'              => 'supplier_id',
                                'value'             => 'Suppliers::model()->nameOfThis($data->supplier_id)',
                                'footer'            => '',
                                'htmlOptions'       => ['class' => 'text-left'],
                        ),
                        array(
                                'name'              => 'po_no',
                                'footer'            => '',
                                'htmlOptions'       => ['class' => 'text-center'],
                        ),
                        array(
                                'name'              => 'grand_total',
                                'header'            => 'Total',
                                'headerHtmlOptions' => ['title' => 'Grand Total', 'style' => 'cursor:help;'],
                                'footer'            => number_format($pageTotals['grand_total'], 2),
                                'footerHtmlOptions' => ['class' => 'text-right grid-footer-grand'],
                                'type'              => 'raw',
                                'value'             => 'CHtml::tag("span", ["class"=>"grand-cell"], number_format($data->grand_total, 2))',
                                'htmlOptions'       => ['class' => 'text-right', 'style' => 'width:95px;'],
                        ),
                        array(
                                'name'              => 'created_by',
                                'header'            => 'By',
                                'headerHtmlOptions' => ['title' => 'Created By', 'style' => 'cursor:help;'],
                                'footer'            => '',
                                'value'             => 'CHtml::tag("span", ["class"=>"badge badge-info text-capitalize"], Users::model()->nameOfThis($data->created_by))',
                                'type'              => 'raw',
                                'htmlOptions'       => ['class' => 'text-center', 'style' => 'width:100px;'],
                        ),
                        array(
                                'name'              => 'created_at',
                                'header'            => 'At',
                                'headerHtmlOptions' => ['title' => 'Created At', 'style' => 'cursor:help;'],
                                'footer'            => '',
                                'htmlOptions'       => ['class' => 'text-center', 'style' => 'width:130px;'],
                        ),
                        array
                        (
                                'header' => 'Options',
                                'template' => '{createPr}{update}{delete}', // {delete}
                                'class' => 'CButtonColumn',
                                'htmlOptions' => ['style' => 'width: 120px;', 'class' => 'actions-cell'],
                                'buttons' => array(
                                        'createPr' => array(
                                                'label' => '<i class="fa fa-money"></i>',
                                                'imageUrl' => false,
                                                'options' => array('class' => 'action-btn btn-payment', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Create PR')),
                                                'url' => 'Yii::app()->controller->createUrl("/accounting/paymentReceipt/create",array("id"=>$data->supplier_id,))',
                                        ),
                                        'update' => array(
                                                'label' => '<i class="fa fa-pencil-square-o"></i>',
                                                'imageUrl' => false,
                                                'options' => array('class' => 'action-btn btn-edit', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
                                        ),
                                        'delete' => array(
                                                'label' => '<i class="fa fa-trash"></i>',
                                                'imageUrl' => false,
                                                'options' => array('class' => 'action-btn btn-delete', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
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
                                                            type:"POST",
                                                            url:$(this).attr("href"),
                                                            success:function(){
                                                                $.fn.yiiGridView.update("sell-order-grid");
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
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'update-dialog',
        'options' => array(
                'title' => 'Update Category',
                'autoOpen' => false,
                'modal' => true,
                'width' => 'auto',
                'resizable' => false,
        ),
));
?>
<div class="update-dialog-content"></div>
<?php $this->endWidget(); ?>

<?php
$updateJS = CHtml::ajax(array(
        'url' => "js:url",
        'data' => "js:form.serialize() + action",
        'type' => 'post',
        'dataType' => 'json',
        'success' => "function( data )
  {
    if( data.status == 'failure' )
    {
      $( '#update-dialog div.update-dialog-content' ).html( data.content );
      $( '#update-dialog div.update-dialog-content form input[type=submit]' )
        .off() // Stop from re-binding event handlers
        .on( 'click', function( e ){ // Send clicked button value
          e.preventDefault();
          updateDialog( false, $( this ).attr( 'name' ) );
      });
    }
    else
    {
      $( '#update-dialog div.update-dialog-content' ).html( data.content );
      if( data.status == 'success' ) // Update all grid views on success
      {
        $( 'div.grid-view' ).each( function(){ // Change the selector if you use different class or element
          $.fn.yiiGridView.update( $( this ).attr( 'id' ) );
        });
      }
      setTimeout( \"$( '#update-dialog' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
    }
  }"
));
?>

<?php Yii::app()->clientScript->registerScript('updateDialog', "
function updateDialog( url, act )
{
  var action = '';
  var form = $( '#update-dialog div.update-dialog-content form' );
  if( url == false )
  {
    action = '&action=' + act;
    url = form.attr( 'action' );
  }
  {$updateJS}
}"); ?>

<?php
Yii::app()->clientScript->registerScript('updateDialogCreate', "
jQuery( function($){
    $( 'a.update-dialog-create' ).bind( 'click', function( e ){
      e.preventDefault();
      $( '#update-dialog' ).children( ':eq(0)' ).empty();
      updateDialog( $( this ).attr( 'href' ) );
      $( '#update-dialog' )
        .dialog( { title: 'Create' } )
        .dialog( 'open' );
    });
});
");
?>

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


<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function goToPage() {
    var page = parseInt($('#goto-page-input').val(), 10);
    if (!page || page < 1) return;
    $.fn.yiiGridView.update('sell-order-grid', { data: { 'sell-order-grid_page': page } });
    $('#goto-page-input').val('');
}
$(document).on('keypress', '#goto-page-input', function(e) {
    if (e.which === 13) goToPage();
});
</script>
