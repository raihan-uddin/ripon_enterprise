<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Purchase', 'url' => array('admin')),
        array('name' => 'Receive Purchase', 'url' => array('admin')),
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
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                            <span class="input-group-text"
                                  id="basic-addon1">RCV No</span>
                    </div>
                    <?php echo $form->textField($model, 'receive_no', array('maxlength' => 255, 'class' => 'form-control', "aria-describedby" => "basic-addon1")); ?>
                </div>
                <span class="help-block"
                      style="color: red; width: 100%"> <?php echo $form->error($model, 'receive_no'); ?></span>

            </div>

            <div class="col-md-3">
                <?php
                echo CHtml::ajaxLink(
                    "Print", Yii::app()->createUrl('/commercial/receivePurchase/voucherPreview'), array(
                    'type' => 'POST',
                    'beforeSend' => "function(){
                        let po_no = $('#ReceivePurchase_receive_no').val();
                        if(po_no == ''){
                        toastr.error('Please insert receive no!');
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
                        'rcv_no' => 'js:jQuery("#ReceivePurchase_receive_no").val()',
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
        <h3 class="card-title">Manage Receive</h3>

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
        <?php $this->widget('ext.groupgridview.GroupGridView', array(
            'id' => 'sell-order-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
            'htmlOptions' => array('class' => 'table-responsive grid-view'),
            'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
//            'loadingCssClass' => 'fa fa-spinner fa-spin fa-2x',
//            'pager' => array(            //  pager like twitter bootstrap
//                'htmlOptions' => array('class' => 'pagination  justify-content-end'),
////                'header'=>'',
////                'cssFile'=>false,
////                'maxButtonCount'=>24,
////                'selectedPageCssClass'=>'active',
////                'hiddenPageCssClass'=>'disabled',
////                'firstPageCssClass'=>'previous',
////                'lastPageCssClass'=>'next',
////                'firstPageLabel'=>'<<',
////                'lastPageLabel'=>'>>',
////                'prevPageLabel'=>'<',
////                'nextPageLabel'=>'>',
//            ),
//            'template' => "{pager}{summary}{items}{summary}{pager}",
            'columns' => array(
                array(
                    'name' => 'date',
                    'htmlOptions' => ['class' => 'text-center']
                ),

                array(
                    'name' => 'receive_no',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'purchase_order_id',
                    'value' => 'PurchaseOrder::model()->nameOfThis($data->purchase_order_id)',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'supplier_id',
                    'value' => 'Suppliers::model()->nameOfThis($data->supplier_id)',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'supplier_memo_no',
                    'htmlOptions' => ['class' => 'text-center']
                ),
                array(
                    'name' => 'supplier_memo_date',
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
                /*array
                (
                    'header' => 'Options',
                    'template' => '{update}{delete}', // {delete}
                    'class' => 'CButtonColumn',
                    'htmlOptions' => ['style' => 'width: 200px'],
                    'buttons' => array(
                        'update' => array(
                            'label' => '<i class="fa fa-pencil-square-o fa-2x" style="color: black;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
//                            'visible' => '$data->bom_complete == SellOrder::BOM_NOT_COMPLETE ? TRUE : FALSE',
                        ),
                        'delete' => array(
                            'label' => '<i class="fa fa-trash fa-2x" style="color: red;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
//                            'visible' => '$data->bom_complete == SellOrder::BOM_NOT_COMPLETE ? TRUE : FALSE',
                        ),
                    )
                ),*/
            ),
        )); ?>

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


<style>
    /* disable selected for merged cells */
    .grid-view td.merge {
        background: none repeat scroll 0 0 #F8F8F8;
    }
</style>

