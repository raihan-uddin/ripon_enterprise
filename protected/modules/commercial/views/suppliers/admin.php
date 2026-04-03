<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Purchase', 'url' => array('')),
        array('name' => 'Config', 'url' => array('admin')),
        array('name' => 'Suppliers'),
    ),
));
?>

<style>
    /* ── Grid header ── */
    #suppliers-grid th {
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
    #suppliers-grid .filters input,
    #suppliers-grid .filters select {
        width: 100%;
        font-size: 12px;
        height: 28px;
        padding: 2px 6px;
        border: 1px solid #c8d8e8;
        border-radius: 4px;
        background: #fff;
        color: #212529;
    }

    #suppliers-grid .filters input:focus,
    #suppliers-grid .filters select:focus {
        border-color: #17a2b8;
        box-shadow: 0 0 0 2px rgba(23,162,184,0.15);
        outline: none;
    }

    /* ── Grid rows ── */
    #suppliers-grid td {
        vertical-align: middle;
        font-size: 13px;
        padding: 7px 10px;
    }

    #suppliers-grid tr:hover td {
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
echo $this->renderPartial('_form', array('model' => $model));
?>
<?php echo CHtml::link('Manage Contact Persons', array('/commercial/supplierContactPersons/admin'), array('class' => 'btn btn-warning mb-2')); ?>

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
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Manage suppliers</h3>

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

            <?php
            $this->widget('ext.groupgridview.GroupGridView', array(
                'id' => 'suppliers-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
                'htmlOptions' => array('class' => 'table-responsive grid-view'),
                'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
//            'loadingCssClass' => 'fa fa-spinner fa-spin fa-2x',
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
                'emptyText' => "<div class='alert alert-warning text-center' role='alert'><i class='icon fa fa-exclamation-triangle'></i>No results found.</div>",
                'summaryCssClass' => 'col-sm-12 col-md-6',
                'pagerCssClass'   => 'col-xs-12 text-end',
                'columns' => array(
                    'id',
                    'company_name',
                    'company_address',
                    'company_contact_no',
//                    'contact_number_2',
//                    'company_fax',
//                    'company_email',
                    'company_web',
                    'opening_amount',
                    array
                    (
                        'header' => 'Options',
                        'htmlOptions' => array('style' => 'width:120px', 'class' => 'actions-cell'),
                        //'template' => '{view}{update}{addContactPerson}{contactPersons}{delete}',
                        'template' => '{createPr}{update}{customDelete}',
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'customDelete' => array(
                                'label' => '<i class="fa fa-trash"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'action-btn btn-delete', 'rel' => 'tooltip', 'data-bs-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
                                'url' => 'Yii::app()->controller->createUrl("suppliers/delete",array("id"=>$data->id))',
                                'click' => "function(){
                                    //$('#viewDialog').dialog('open');
                                    $.fn.yiiGridView.update('suppliers-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                             $('#ajaxLoaderView').hide();  
                                              $('#statusMsg').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                              //$('#AjFlash').html(data).show();
                                              $.fn.yiiGridView.update('suppliers-grid');
                                        },
                                        beforeSend: function(){
                                            $('#ajaxLoaderView').show();
                                        }
                                    })
                                    return false;
                              }
                            ",

                            ),
                            'update' => array(
                                'label' => '<i class="fa fa-pencil-square-o"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'action-btn btn-edit', 'rel' => 'tooltip', 'data-bs-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
                                'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update Customer Info' } )
                              .dialog( 'open' ); }",
                            ),
                                'createPr' => array(
                                        'label' => '<i class="fa fa-money"></i>',
                                        'imageUrl' => false,
                                        'options' => array('class' => 'action-btn btn-payment', 'rel' => 'tooltip', 'data-bs-toggle' => 'tooltip', 'title' => Yii::t('app', 'Create PR')),
                                        'url' => 'Yii::app()->controller->createUrl("/accounting/paymentReceipt/create",array("id"=>$data->id,))',
                                ),
                        )
                    ),
                )
            ));
            ?>
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
        'title' => 'Viewing Single Data',
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

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'update-dialog',
    'options' => array(
        'title' => 'Update Customer Info',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable' => false,
    ),
));
?>
    <div class="update-dialog-content"></div>
<?php //$this->endWidget();  ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


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

<script>
function goToPage() {
    var page = parseInt($('#goto-page-input').val(), 10);
    if (!page || page < 1) return;
    $.fn.yiiGridView.update('suppliers-grid', { data: { 'suppliers-grid_page': page } });
    $('#goto-page-input').val('');
}
$(document).on('keypress', '#goto-page-input', function(e) {
    if (e.which === 13) goToPage();
});
</script>

    <!--Contact person dialog box---------------------------------------------------------------------->

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addContactPerson-dialog',
    'options' => array(
        'title' => 'ADD Contact Person',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable' => false,
    ),
));
?>
    <div class="addContactPerson-dialog-content"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


<?php
$addContactPersonJS = CHtml::ajax(array(
    'url' => "js:url",
    'data' => "js:form.serialize() + action",
    'type' => 'post',
    'dataType' => 'json',
    'success' => "function( data )
  {
    if( data.status == 'failure' )
    {
      $( '#addContactPerson-dialog div.addContactPerson-dialog-content' ).html( data.content );
      $( '#addContactPerson-dialog div.addContactPerson-dialog-content form input[type=submit]' )
        .off() // Stop from re-binding event handlers
        .on( 'click', function( e ){ // Send clicked button value
          e.preventDefault();
          addContactPersonDialog( false, $( this ).attr( 'name' ) );
      });
    }
    else
    {
      $( '#addContactPerson-dialog div.addContactPerson-dialog-content' ).html( data.content );
      if( data.status == 'success' ) // update all grid views on success
      {
        $( 'div.grid-view' ).each( function(){ // Change the selector if you use different class or element
          $.fn.yiiGridView.update( $( this ).attr( 'id' ) );
         });
      }
      setTimeout( \"$( '#addContactPerson-dialog' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
    }
  }"
));
?>

<?php Yii::app()->clientScript->registerScript('addContactPersonDialog', "
function addContactPersonDialog( url, act )
{
  var action = '';
  var form = $( '#addContactPerson-dialog div.addContactPerson-dialog-content form' );
  if( url == false )
  {
    action = '&action=' + act;
    url = form.attr( 'action' );
  }
  {$addContactPersonJS}
}"); ?>

<?php
Yii::app()->clientScript->registerScript('addContactPersonDialogCreate', "
jQuery( function($){
    $( 'a.addContactPerson-dialog-create' ).bind( 'click', function( e ){
      e.preventDefault();
      $( '#addContactPerson-dialog' ).children( ':eq(0)' ).empty();
      addContactPersonDialog( $( this ).attr( 'href' ) );
      $( '#addContactPerson-dialog' )
        .dialog( { title: 'Create' } )
        .dialog( 'open' );
    });
});
");
?>