<?php
$this->widget('application.components.BreadCrumb', array(
        'crumbs' => array(
                array('name' => 'Loan', 'url' => array('')),
                array('name' => 'Loan Transactions', 'url' => array('')),
        ),
));

if (Yii::app()->user->checkAccess('LoanTransactions.Create')) {
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
<div class="card card-primary mt-3">
    <div class="card-header">
        <h3 class="card-title">Manage Loan Transaction</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body table-responsive">

        <?php
        $this->widget('ext.groupgridview.GroupGridView', array(
                'id' => 'loan-transactions-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,

                'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
                'htmlOptions' => array('class' => 'grid-view table-responsive'),

                'itemsCssClass' => 'table table-sm table-hover table-striped table-bordered align-middle',

                'template' => "{summary}{items}{pager}",

                'summaryText' => "
        <div class='dataTables_info small text-muted'>
            Showing {start}–{end} of {total} transactions
        </div>
    ",

                'emptyText' => "
        <div class='alert alert-warning text-center'>
            <i class='fa fa-exclamation-triangle'></i>
            No loan transactions found
        </div>
    ",

                'columns' => array(

                        [
                                'name' => 'person_id',
                                'value' => 'LoanPersons::model()->findByPk($data->person_id)->name',
                                'filter' => CHtml::listData(
                                        LoanPersons::model()->findAll(['order' => 'name ASC']),
                                        'id',
                                        'name'
                                ),
                                'htmlOptions' => ['class' => 'fw-bold'],
                        ],

                        [
                                'name' => 'transaction_type',
                                'type' => 'raw',
                                'filter' => [
                                        'lend' => 'Gave money (দিলাম)',
                                        'borrow' => 'Received money (নিলাম)',
                                ],
                                'value' => 'CHtml::tag(
                                    "span",
                                    [
                                        "class" => "badge " . 
                                        ($data->transaction_type === "lend" ? "badge-danger" : "badge-success")
                                    ],
                                    $data->transaction_type === "lend"
                                        ? "Gave (দিলাম)"
                                        : "Received (নিলাম)"
                                )',
                                'htmlOptions' => ['class' => 'text-center'],
                        ],

                        [
                                'name' => 'amount',
                                'type' => 'raw',
                                'value' => 'CHtml::tag(
                                    "span",
                                    [
                                        "class" => $data->transaction_type === "lend"
                                            ? "text-danger fw-bold"
                                            : "text-success fw-bold"
                                    ],
                                    "৳ " . number_format($data->amount, 2)
                                )',
                                'htmlOptions' => ['class' => 'text-right'],
                        ],

                        [
                                'name' => 'transaction_date',
                                'htmlOptions' => ['class' => 'text-center'],
                        ],

                        [
                                'name' => 'note',
                                'value' => 'strlen($data->note) > 40 
                                    ? substr($data->note, 0, 40) . "…" 
                                    : $data->note',
                                'htmlOptions' => ['style' => 'max-width:220px'],
                        ],

                        [
                                'header' => 'Options',
                                'class' => 'CButtonColumn',
                                'template' => '{update}{delete}',
                                'buttons' => [
                                        'update' => [
                                                'label' => '<i class="fa fa-pencil-square-o fa-2x"></i>',
                                                'imageUrl' => false,
                                                'click' => "function(e){
                                        e.preventDefault();
                                        $('#update-dialog').children(':eq(0)').empty();
                                        updateDialog($(this).attr('href'));
                                        $('#update-dialog').dialog('open');
                                    }",
                                        ],
                                        'delete' => [
                                                'label' => '<i class="fa fa-trash fa-2x text-danger"></i>',
                                                'imageUrl' => false,
                                        ],
                                ]
                        ]
                ),
        ));
        ?>

    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'update-dialog',
        'options' => array(
                'title' => 'Update Loan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 700,
                'resizable' => false,
                'height' => 'auto',
                'draggable' => true,
                'closeOnEscape' => true,
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