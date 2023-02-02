<fieldset>
    <legend>View Designation Info</legend>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/detailview/styles.css',
        'attributes' => array(
            'id',
            'designation',
        ),
    ));
    ?>
</fieldset>
