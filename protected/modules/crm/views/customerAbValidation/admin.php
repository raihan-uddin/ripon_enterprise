<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('customer-ab-validation-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Customer AB Validation On Sales Process (On/Off)</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'customer-ab-validation-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array( 
            'validation_field',
            array(
                'name' => 'is_active',
                'value' => 'CreditLimit::model()->statusColor($data->is_active)',
                'filter' => Lookup::items('is_active'),
            ),
            array
                (
                'htmlOptions'=>array('style'=>'width: 80px'),
                'header' => 'Options',
                'template' => '{activate}{inactivate}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'activate' => array(
                        'label' => 'Activate',
                          'imageUrl' => Yii::app()->theme->baseUrl . '/images/activate.ico',
                        'url' => 'Yii::app()->controller->createUrl("changeStatus",array("id"=>$data->id, "status"=>"activate"))',
                        'click' => "function(){
                                            $.fn.yiiGridView.update('customer-ab-validation-grid', {
                                                type:'POST',
                                                url:$(this).attr('href'),
                                                success:function(data) {
                                                      $.fn.yiiGridView.update('customer-ab-validation-grid'); 
                                                }
                                            })
                                            return false;
                                          }",
                    ),
                   'inactivate' => array(
                        'label' => 'Inactivate',
                         'imageUrl' => Yii::app()->theme->baseUrl . '/images/inactivate.ico',
                        'url' => 'Yii::app()->controller->createUrl("changeStatus",array("id"=>$data->id, "status"=>"inactivate"))',
                        'click' => "function(){
                                            $.fn.yiiGridView.update('customer-ab-validation-grid', {
                                                type:'POST',
                                                url:$(this).attr('href'),
                                                success:function(data) {
                                                      $.fn.yiiGridView.update('customer-ab-validation-grid'); 
                                                }
                                            })
                                            return false;
                                          }",
                    ),
                )
            ),
        )
    ));
    ?>
</fieldset>

<style>


    /* disable selected for merged cells */     
    .grid-view td.merge {
        background: none repeat scroll 0 0 #F8F8F8; 
    }
</style>

