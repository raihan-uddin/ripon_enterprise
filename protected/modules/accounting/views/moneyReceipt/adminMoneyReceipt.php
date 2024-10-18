<?php
$this->widget('application.components.BreadCrumb', array(
  'crumbs' => array(
    array('name' => 'Sales', 'url' => array('')),
    array('name' => 'Collection', 'url' => array('admin')),
    array('name' => 'MR Create'),
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
	$.fn.yiiGridView.update('customers-grid', {
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
    <h3 class="card-title">Create MR</h3>

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
                'id' => 'customers-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
                'htmlOptions' => array('class' => 'table-responsive grid-view'),
                'itemsCssClass' => 'table table-sm table-hover table-striped table-condensed table-bordered dataTable dtr-inline',
                'template' => "{pager}{summary}{items}{summary}{pager}",
                'columns' => array(
                    'company_name',
                    'customer_code',
                    'company_address',
                    'company_email',
                    'company_web',
                    'owner_person',
                    'owner_mobile_no',
                    // 'city',
                    // 'state',
                    // 'zip',
                    // 'trn_no',
					/*array(
                        'header' => 'New Collection',
                        'htmlOptions' => array('style' => 'width:100px', 'class' => 'text-center'),
                        'template' => '{createMr}',
                        // 'template' => '{view}{update}{addContactPerson}{contactPersons}{delete}',
                        //'template' => '{view}{update}{delete}{addContactPerson}{contactPersons}',
                        'class' => 'CButtonColumn',
                        'buttons' => array(
                            'createMr' => array(
                                'label' => '<i class="fa fa-usd fa-2x" style="color: green;"></i>&nbsp;&nbsp;',
                                'imageUrl' => false,
                                'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Create MR New')),
                                'url' => 'Yii::app()->controller->createUrl("/accounting/moneyReceipt/createNew",array("id"=>$data->id))',
                            ),
                        )
                    ),*/

					array(
						'header' => 'Options',
						'htmlOptions' => array('style' => 'width:100px', 'class' => 'text-center'),
						'template' => '{createMr}',
						// 'template' => '{view}{update}{addContactPerson}{contactPersons}{delete}',
						//'template' => '{view}{update}{delete}{addContactPerson}{contactPersons}',
						'class' => 'CButtonColumn',
						'buttons' => array(
							'createMr' => array(
							'label' => '<i class="fa fa-money fa-2x" style="color: green;"></i>&nbsp;&nbsp;',
							'imageUrl' => false,
							'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Create MR')),
							'url' => 'Yii::app()->controller->createUrl("/accounting/moneyReceipt/create",array("id"=>$data->id))',
							),
						)
					),
				),
    		));
    		?>
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
    src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
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
<?php $this->endWidget(); ?>

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