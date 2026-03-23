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
                    'htmlOptions' => ['class' => 'actions-cell'],
                    'visible' => Users::superuserStatus(Yii::app()->user->getState('user_id')) == true,
                    'buttons' => array(
                        'makeSuperAdmin' => array(
                            'label' => '<span class="badge badge-danger">Make SuperAdmin</span>&nbsp;&nbsp;',
                            'imageUrl' => false,
                            'options' => array('class' => 'action-btn btn-create', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Make Superadmin')),
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
                            'options' => array('class' => 'action-btn btn-delete', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Revoke Superadmin')),
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
                    'htmlOptions' => ['class' => 'actions-cell'],
                    'buttons' => array(
                        'update' => array(
                            'label' => '<i class="fa fa-pencil-square-o"></i>',
                            'imageUrl' => false,
                            'options' => array('class' => 'action-btn btn-edit', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
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

<script>
function goToPage() {
    var page = parseInt($('#goto-page-input').val(), 10);
    if (!page || page < 1) return;
    $.fn.yiiGridView.update('users-grid', { data: { 'users-grid_page': page } });
    $('#goto-page-input').val('');
}
$(document).on('keypress', '#goto-page-input', function(e) {
    if (e.which === 13) goToPage();
});
</script>

<style>
    /* grid border */
    .grid-view table.items th, .grid-view table.items td {
        border: 1px solid gray !important;
        text-align: center;
    }
</style>