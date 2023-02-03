<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Purchase', 'url' => array('')),
        array('name' => 'Config', 'url' => array('admin')),
        array('name' => 'Suppliers'),
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
	$.fn.yiiGridView.update('suppliers-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
echo $this->renderPartial('_form', array('model' => $model));
?>
<?php echo CHtml::link('Manage Contact Persons', array('/commercial/supplierContactPersons/admin'), array('class' => 'btn btn-warning mb-2')); ?>

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
                'emptyText' => "<div class='alert alert-warning text-center' role='alert'><i class='icon fa fa-exclamation-triangle'></i>No results found.</div>",
                'summaryCssClass' => 'col-sm-12 col-md-5',
                'pagerCssClass' => 'col-sm-12 col-md-7 pager',
                'columns' => array(
                    'company_name',
                    'company_address',
                    'company_contact_no',
                    'contact_number_2',
                    'company_fax',
                    'company_email',
                    'company_web',
//                    'opening_amount',
                    array
                    (
                        'header' => 'Options',
                        'htmlOptions' => array('style' => 'width:120px'),
                        //'template' => '{view}{update}{addContactPerson}{contactPersons}{delete}',
                        'template' => '{update}{customDelete}',
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'customDelete' => array(
                                'label' => '<i class="fa fa-trash fa-2x" style="color: red;"></i>&nbsp;&nbsp;',
                                'imageUrl' => false,
                                'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
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
                                'label' => '<i class="fa fa-pencil-square-o fa-2x" style="color: black;"></i>&nbsp;&nbsp;',
                                'imageUrl' => false,
                                'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
                                'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update Customer Info' } )
                              .dialog( 'open' ); }",
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

    <style>


        /* disable selected for merged cells */
        .grid-view td.merge {
            background: none repeat scroll 0 0 #F8F8F8;
        }
    </style>

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