<fieldset>
    <legend>View Ship By</legend>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/detailview/styles.css',
        'attributes' => array(
            'ship_by',
        ),
    ));
    ?> 
</fieldset>