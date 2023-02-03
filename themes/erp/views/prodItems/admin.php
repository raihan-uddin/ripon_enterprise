<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Software', 'url' => array('')),
        array('name' => 'Software Settings', 'url' => array('admin')),
        array('name' => 'Product Category'),
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

if (Yii::app()->user->checkAccess('ProdItems.Create')) {
    echo $this->renderPartial('_form', array('model' => $model));
}
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
            <h3 class="card-title">Manage Categories</h3>

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
                'id' => 'prod-items-grid',
                'dataProvider' => $model->search(),
//        'mergeColumns' => array('id'),
                'filter' => $model,
                'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
                'htmlOptions' => array('class' => 'table-responsive grid-view'),
                'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
//            'loadingCssClass' => 'fa fa-spinner fa-spin fa-2x',
                'pager' => array(            //  pager like twitter bootstrap
                    'htmlOptions' => array('class' => 'pagination  justify-content-end'),
                    'header' => '',
                    'cssFile' => false,
                    'maxButtonCount' => 10,
                    'selectedPageCssClass' => 'page-item active', //default "selected"
                    'nextPageCssClass' => 'page-item',//default "next"
                    'hiddenPageCssClass' => 'page-item disabled',//default "hidden"
                    'firstPageCssClass' => 'page-item previous', //default "first"\
                    'lastPageCssClass' => 'page-item last', //default "last"
                    'internalPageCssClass' => 'page-item',//default "page"
                    'previousPageCssClass' => 'page-item',//default "previours"\
                    'firstPageLabel' => '<<',
                    'lastPageLabel' => '>>',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>',
//                'footer'=>'End',//defalut empty
                ),
                'template' => "{pager}\n\n{summary}{items}{summary}\n{pager}",
                'summaryText' => "<div class='dataTables_info' role='status' aria-live='polite'><p>Displaying {start}-{end} of {page} result(s)</p></div>",
                'summaryCssClass' => 'col-sm-12 col-md-5',
                'pagerCssClass' => 'col-sm-12 col-md-7 pager',
                'emptyText' => "<div class='alert alert-warning text-center' role='alert'><i class='icon fa fa-exclamation-triangle'></i>No results found.</div>",
                'columns' => array(
                    'item_name',
                    array
                    (
                        'header' => 'Options',
                        'template' => '{update}{delete}', // {delete}
                        'class' => 'CButtonColumn',
                        'htmlOptions' => ['style' => 'width: 100px'],
                        'buttons' => array(
                            'update' => array(
                                'label' => '<i class="fa fa-pencil-square-o fa-2x" style="color: black;"></i>&nbsp;&nbsp;',
                                'imageUrl' => false,
                                'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
                                'click' => "function( e ){
                                e.preventDefault();
                                $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                                updateDialog( $( this ).attr( 'href' ) );
                                $( '#update-dialog' )
                                  .dialog( { title: 'Update Category' } )
                                  .dialog( 'open' ); 
                              }",
                            ),
                            'delete' => array(
                                'label' => '<i class="fa fa-trash fa-2x" style="color: red;"></i>&nbsp;&nbsp;',
                                'imageUrl' => false,
                                'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
//                            'visible' => '$data->account_type=="1"?TRUE:FALSE',
//                            'visible'=>'$data->account_type=="2"?TRUE:FALSE',
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