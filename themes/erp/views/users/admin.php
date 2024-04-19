<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Common', 'url' => array('')),
        array('name' => 'User', 'url' => array('admin')),
        array('name' => 'Admin'),
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
	$.fn.yiiGridView.update('users-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

if (Yii::app()->user->checkAccess('Users.Create')) {
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
        <h3 class="card-title">Manage Users</h3>

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
            'id' => 'users-grid',
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
            'summaryCssClass' => 'col-sm-12 col-md-5',
            'pagerCssClass' => 'col-sm-12 col-md-7 pager',
            'emptyText' => "<div class='alert alert-warning text-center' role='alert'><i class='icon fa fa-exclamation-triangle'></i>No results found.</div>",

            'columns' => array(

                array(
                    'name' => 'username',
                    'type' => 'raw',
//                'filter' => CHtml::listData($model->findAll(), "username", "username"),
                    'value' => 'CHtml::link($data->username,array("/rights/assignment/user/","id"=>$data->id))',
//                    'filterHtmlOptions'=>array('class'=>'filterBoxRight'),
                    'filterHtmlOptions' => [
                        'class' => 'form-control',
                    ]
                ),

                array(
                    'name' => 'roles',
                    'type' => 'raw',
                    'value' => 'Users::model()->roleOfThisUser($data->id)',
                ),

                array(
                    'name' => 'status',
                    'value' => '$data->status==1?"Active":"Inactive"',
                    'filter' => array(0 => "Inactive", 1 => 'Active'),
                ),
                array
                (
                    'header' => 'Options',
                    'template' => '{makeSuperAdmin}{revokeSuperAdmin}', //{delete}
                    'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
                    'class' => 'CButtonColumn',
                    'visible' => Users::superuserStatus(Yii::app()->user->id) == true,
                    'buttons' => array(
                        'makeSuperAdmin' => array(
                            'label' => '<span class="badge badge-danger">Make SuperAdmin</span>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Make Superadmin')),
                            'visible' => 'Users::superuserStatus($data->id) == false',
                            'url' => 'Yii::app()->controller->createUrl("makeSuperAdmin",array("id"=>$data->id))',
                            'click' => "function(){
                            if (confirm('Are you sure you want to make this user as superadmin?')) {
                                $.fn.yiiGridView.update('users-grid', {
                                    type:'POST',
                                    url:$(this).attr('href'),
                                    success:function(data) {
                                          $('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                          $.fn.yiiGridView.update('users-grid');
                                    }
                                })
                            }
                                return false;
                          }
                        ",
                        ),

                        'revokeSuperAdmin' => array(
                            'label' => '<span class="badge badge-success">Revoke SuperAdmin</span>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Revoke Superadmin')),
                            'visible' => 'Users::superuserStatus($data->id) == true',
                            'url' => 'Yii::app()->controller->createUrl("revokeSuperAdmin",array("id"=>$data->id))',
                            'click' => "function(){
                            if (confirm('Are you sure you want to revoke this user from superadmin ?')) {
                                $.fn.yiiGridView.update('users-grid', {
                                    type:'POST',
                                    url:$(this).attr('href'),
                                    success:function(data) {
                                          $('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                          $.fn.yiiGridView.update('users-grid');
                                    }
                                })
                            }
                                return false;
                          }
                        ",
                        ),

                    )
                ),
                array
                (
                    'header' => 'Options',
                    'template' => '{update}', //{delete}
                    'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'update' => array(
                            'label' => '<i class="fa fa-pencil-square-o fa-3x"></i>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
//                            'visible' => '$data->id !=1',
                            'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update User Info' } )
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
    'id' => 'update-dialog',
    'options' => array(
        'title' => 'Update User Info',
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
    /* grid border */
    .grid-view table.items th, .grid-view table.items td {
        border: 1px solid gray !important;
        text-align: center;
    }

    /* disable selected for merged cells */
    .grid-view td.merge {
        background: none repeat scroll 0 0 #F8F8F8;
    }
</style>