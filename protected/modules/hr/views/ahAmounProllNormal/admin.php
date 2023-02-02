
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ah-amoun-proll-normal-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if ($model->isNewRecord) { ?>
    <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
<?php } else { ?>
    <?php echo $this->renderPartial('_form2', array('model' => $model)); ?>
<?php } ?>
<div id="statusMsg"></div>
<fieldset style="float: left; width: 98%;">
    <legend>Manage Earning/Deduction Configurations</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'ah-amoun-proll-normal-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'mergeColumns' => array('full_name', 'emp_id_no', 'branch_name', 'department_name'),
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            array(
                'name' => 'full_name',
                'htmlOptions' => array('style' => 'text-align: left;'),
            ),
            array(
                'name' => 'emp_id_no',
                'htmlOptions' => array('style' => 'text-align: left;'),
            ),
            array(
                'name' => 'branch_name',
                'filter' => CHtml::listData(Branches::model()->findAll(), "id", "title"),
                'htmlOptions' => array('style' => 'text-align: left;'),
            ),
            'department_name',
            array(
                'name' => 'ah_proll_normal_id',
                'value' => 'AhProllNormal::model()->nameOfThis($data->ah_proll_normal_id)',
                'filter' => CHtml::listData(AhProllNormal::model()->findAll(), "id", "title"),
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'percentage_of_ah_proll_normal_id',
                'value' => 'CHtml::encode(AhAmounProllNormal::model()->percengateAmount($data->percentage_of_ah_proll_normal_id, $data->amount_adj))',
                'filter' => '',
                'htmlOptions' => array('style' => 'text-align: left;'),
            ),
            'amount_adj',
            array(
                'name' => 'earn_deduct_type',
                'value' => 'Lookup::item("earn_deduct_type", $data->earn_deduct_type)',
                'filter' => Lookup::items('earn_deduct_type'),
            ),
            'start_from',
            'end_to',
            array(
                'name' => 'is_active',
                'value' => 'AhAmounProllNormal::model()->statusColor($data->is_active)',
                'filter' => Lookup::items('is_active'),
            ),
            array(
                'name' => 'create_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->create_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(), "id", "full_name"),
            ),
            'create_time',
            array(
                'name' => 'update_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->update_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(), "id", "full_name"),
            ),
            'update_time',
            array
                (
                'header' => 'Options',
                'template' => '{update}{delete}',
                'afterDelete' => 'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'update' => array(
                        'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update Info' } )
                              .dialog( 'open' ); }",
                    ),
                )
            ),
        )
    ));
    ?>
</fieldset>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'update-dialog',
    'options' => array(
        'title' => 'Update Info',
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
