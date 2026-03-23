<?php
$this->widget('application.components.BreadCrumb', array(
        'crumbs' => array(
                array('name' => 'Purchase', 'url' => array('admin')),
                array('name' => 'Order', 'url' => array('admin')),
                array('name' => 'Manage'),
        ),
//    'delimiter' => ' &rarr; ',
));
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('prod-items-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

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
        <?php $this->widget('ext.groupgridview.GroupGridView', array(
                'id' => 'sell-order-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
                'htmlOptions' => array('class' => 'table-responsive grid-view'),
                'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
                'mergeColumns' => array('date', 'supplier_id'),
                'mergeType' => 'nested',
                'pager' => array(
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
                                'name' => 'id',
                                'htmlOptions' => [
                                        'class' => 'text-center',
                                        'style' => 'width: 80px;'
                                ]
                        ),

                        array(
                                'name' => 'cash_due',
                                'type' => 'raw',
                                'value' => ' Lookup::item("cash_due", $data->cash_due)',
                                'filter' => Lookup::items('cash_due'),
                                'htmlOptions' => ['class' => 'text-center']
                        ),
                        array(
                                'name' => 'date',
                                'htmlOptions' => ['class' => 'text-center']
                        ),

                        array(
                                'name' => 'supplier_id',
                                'value' => 'Suppliers::model()->nameOfThis($data->supplier_id)',
                                'htmlOptions' => ['class' => 'text-center']
                        ),
                        array(
                                'name' => 'po_no',
                                'htmlOptions' => ['class' => 'text-center']
                        ),
                        array(
                                'name' => 'grand_total',
                                'htmlOptions' => ['class' => 'text-center']
                        ),

                        array(
                                'name' => 'created_by',
                                'value' => 'Users::model()->nameOfThis($data->created_by)',
                                'htmlOptions' => ['class' => 'text-center']
                        ),
                        array(
                                'name' => 'created_at',
                                'htmlOptions' => ['class' => 'text-center']
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
                    <input type="number" id="goto-page-input-sell-order-grid" class="form-control" min="1" placeholder="Page #"/>
                    <button onclick="goToPage('sell-order-grid')"><i class="fa fa-arrow-right"></i> Go</button>
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
function goToPage(gridId) {
    var page = parseInt($('#goto-page-input-' + gridId).val(), 10);
    if (!page || page < 1) return;
    $.fn.yiiGridView.update(gridId, { data: { [gridId + '_page']: page } });
    $('#goto-page-input-' + gridId).val('');
}
$(document).on('keypress', '[id^="goto-page-input-"]', function(e) {
    if (e.which === 13) goToPage($(this).attr('id').replace('goto-page-input-', ''));
});
</script>
