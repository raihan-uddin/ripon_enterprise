<fieldset>
    <legend>View User Info</legend>
    <table class="detail-view">
        <tbody>
            <tr class="even">
                <th>Employee Full Name</th>
                <td>
                    <?php echo Users::model()->fullNameOfThis($model->id); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/detailview/styles.css',
        'attributes' => array(
            'username',
            'create_by',
            'create_time',
            'update_by',
            'update_time',
        ),
    ));
    ?>
</fieldset>