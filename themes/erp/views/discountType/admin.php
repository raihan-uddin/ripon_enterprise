<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('discount-type-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Select Discount Type</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'discount-type-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array( 
            'title',
            array(
                'name' => 'is_active',
                'value' => 'CreditLimit::model()->statusColor($data->is_active)',
                'filter' => Lookup::items('is_active'),
            ),
            array
                (
                'htmlOptions'=>array('style'=>'width: 80px'),
                'header' => 'Options',
                'template' => '{activate}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'activate' => array(
                        'label' => 'Activate',
                          'imageUrl' => Yii::app()->theme->baseUrl . '/images/activate.ico',
                        'url' => 'Yii::app()->controller->createUrl("changeStatus",array("id"=>$data->id))',
                        'click' => "function(){
                                            $.fn.yiiGridView.update('discount-type-grid', {
                                                type:'POST',
                                                url:$(this).attr('href'),
                                                success:function(data) {
                                                      $.fn.yiiGridView.update('discount-type-grid'); 
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
