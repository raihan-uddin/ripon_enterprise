<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Inventory', 'url' => array('')),
        array('name' => 'Config', 'url' => array('admin')),
        array('name' => 'Manage Product', 'url' => array('admin')),
        array('name' => 'Sell Price'),
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
	$.fn.yiiGridView.update('prod-models-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php echo CHtml::link('Manage Sale Prices', array('/sellPrice/admin'), array('class' => 'btn btn-warning btn-md mb-2')); ?>


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


<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add Sale Prices</h3>

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

        <?php
        $this->widget('ext.groupgridview.GroupGridView', array(
            'id' => 'prod-models-grid',
            'dataProvider' => $model->search(),
            'mergeColumns' => array('item_id', 'brand_id'),
            'filter' => $model,
            'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
            'htmlOptions' => array('class' => 'table-responsive grid-view'),
            'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
//            'loadingCssClass' => 'fa fa-spinner fa-spin fa-2x',
//            'pager' => array(            //  pager like twitter bootstrap
//                'htmlOptions' => array('class' => 'pagination  justify-content-end'),
//                'header' => '',
//                'cssFile' => false,
//                'maxButtonCount' => 10,
//                'selectedPageCssClass' => 'page-item active', //default "selected"
//                'nextPageCssClass' => 'page-item',//default "next"
//                'hiddenPageCssClass' => 'page-item disabled',//default "hidden"
//                'firstPageCssClass' => 'page-item previous', //default "first"\
//                'lastPageCssClass' => 'page-item last', //default "last"
//                'internalPageCssClass' => 'page-item',//default "page"
//                'previousPageCssClass' => 'page-item',//default "previours"\
//                'firstPageLabel' => '<<',
//                'lastPageLabel' => '>>',
//                'prevPageLabel' => '<',
//                'nextPageLabel' => '>',
////                'footer'=>'End',//defalut empty
//            ),
            'template' => "{pager}\n\n{summary}{items}{summary}\n{pager}",
            'summaryText' => "<div class='dataTables_info' role='status' aria-live='polite'><p>Displaying {start}-{end} of {page} result(s)</p></div>",
            'summaryCssClass' => 'col-sm-12 col-md-5',
            'pagerCssClass' => 'col-sm-12 col-md-7 pager',
            'emptyText' => "<div class='alert alert-warning text-center' role='alert'><i class='icon fa fa-exclamation-triangle'></i>No results found.</div>",
            'columns' => array(
//            array(
//                    'name' => 'barcode_image',
//                    'value'=>'ProdModels::model()->findBarcodeImgOfThis($data->id)',
//                ),
                array(
                    'name' => 'item_id',
                    'value' => 'ProdItems::model()->itemName($data->item_id)',
                    'filter' => CHtml::listData(ProdItems::model()->findAll(['order' => 'item_name ASC']), 'id', 'item_name'),
                ),
                array(
                    'name' => 'brand_id',
                    'value' => 'ProdBrands::model()->brandName($data->brand_id)',
                    'filter' => CHtml::listData(ProdBrands::model()->findAll(['order' => 'brand_name ASC']), 'id', 'brand_name'),
                ),
                'model_name',
                'code',
                array(
                    'name' => 'activeSellPrice',
                    'header' => 'Active Sell Price, Discount(%), Ideal Qty, Warn Qty',
                    'value' => 'SellPrice::model()->activeSellPriceWithDiscountAndIdealWarnQty($data->id)',
                    'filter' => '',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'color: red;', 'class' => 'customClass'),
                ),
                array
                (
                    'header' => 'Options',
                    'template' => '{view}{sellPriceHistory}{addSellPrice}',
                    'class' => 'CButtonColumn',

                    'htmlOptions' => ['style' => 'width: 120px'],
                    'buttons' => array(
                        'sellPriceHistory' => array(
                            'label' => '<i class="fa fa-history fa-2x" style="color: black;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Sell Price History')),
                            'url' => 'Yii::app()->controller->createUrl("sellPrice/priceHistory",array("model_id"=>$data->id))',
                            'click' => "function(){
                                    $('#viewDialog').dialog('open');
                                    $.fn.yiiGridView.update('prod-models-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                             $('#ajaxLoaderView').hide();  
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                              $('#AjFlash').html(data).show();
                                              $.fn.yiiGridView.update('prod-models-grid');
                                        },
                                        beforeSend: function(){
                                            $('#ajaxLoaderView').show();
                                        }
                                    })
                                    return false;
                              }
                     ",
                        ),
                        'addSellPrice' => array(
                            'label' => '<i class="fa fa-plus fa-2x" style="color: green;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Add Sell Price')),
                            'url' => 'Yii::app()->controller->createUrl("sellPrice/addSellPrice",array("model_id"=>$data->id))',
                            'click' => "function( e ){
                                e.preventDefault();
                                $( '#addSellPrice-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                                addSellPriceDialog( $( this ).attr( 'href' ) );
                                $( '#addSellPrice-dialog' )
                                  .dialog( { title: 'Sell Price Form' } )
                                  .dialog( 'open' ); }",
                        ),
                        'view' => array(
                            'label' => '<i class="fa fa-eye fa-2x" style="color: black;"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Add Sell Price')),
                            'url' => 'Yii::app()->controller->createUrl("view",array("id"=>$data->id))',
                            'click' => "function(){
                                    $('#viewDialog').dialog('open');
                                    $.fn.yiiGridView.update('prod-models-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                             $('#ajaxLoaderView').hide();  
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                              $('#AjFlash').html(data).show();
                                              $.fn.yiiGridView.update('prod-models-grid');
                                        },
                                        beforeSend: function(){
                                            $('#ajaxLoaderView').show();
                                        }
                                    })
                                    return false;
                              }
                     ",
                        ),
                    )
                ),
            )
        ));
        ?>
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
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addSellPrice-dialog',
    'options' => array(
        'title' => 'ADD Sel Price',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable' => false,
    ),
));
?>
<div class="addSellPrice-dialog-content"></div>
<?php $this->endWidget(); ?>

<?php
$addSellPriceJS = CHtml::ajax(array(
    'url' => "js:url",
    'data' => "js:form.serialize() + action",
    'type' => 'post',
    'dataType' => 'json',
    'success' => "function( data )
  {
    if( data.status == 'failure' )
    {
      $( '#addSellPrice-dialog div.addSellPrice-dialog-content' ).html( data.content );
      $( '#addSellPrice-dialog div.addSellPrice-dialog-content form input[type=submit]' )
        .off() // Stop from re-binding event handlers
        .on( 'click', function( e ){ // Send clicked button value
          e.preventDefault();
          addSellPriceDialog( false, $( this ).attr( 'name' ) );
      });
    }
    else
    {
      $( '#addSellPrice-dialog div.addSellPrice-dialog-content' ).html( data.content );
      if( data.status == 'success' ) // update all grid views on success
      {
        $( 'div.grid-view' ).each( function(){ // Change the selector if you use different class or element
          $.fn.yiiGridView.update( $( this ).attr( 'id' ) );
         });
      }
      setTimeout( \"$( '#addSellPrice-dialog' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
    }
  }"
));
?>

<?php Yii::app()->clientScript->registerScript('addSellPriceDialog', "
function addSellPriceDialog( url, act )
{
  var action = '';
  var form = $( '#addSellPrice-dialog div.addSellPrice-dialog-content form' );
  if( url == false )
  {
    action = '&action=' + act;
    url = form.attr( 'action' );
  }
  {$addSellPriceJS}
}"); ?>

<?php
Yii::app()->clientScript->registerScript('addSellPriceDialogCreate', "
jQuery( function($){
    $( 'a.addSellPrice-dialog-create' ).bind( 'click', function( e ){
      e.preventDefault();
      $( '#addSellPrice-dialog' ).children( ':eq(0)' ).empty();
      addSellPriceDialog( $( this ).attr( 'href' ) );
      $( '#addSellPrice-dialog' )
        .dialog( { title: 'Create' } )
        .dialog( 'open' );
    });
});
");
?>

