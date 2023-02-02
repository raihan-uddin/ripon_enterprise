<fieldset>
    <legend>Academic / Educational Informations</legend>
    <table>
        <tr>
            <td style="text-align: center;"><?php echo $form->labelEx($model, 'edu_info'); ?></td>
        </tr>
        <tr>
            <td>
                <?php
                $this->widget('ext.editMe.widgets.ExtEditMe', array(
                    'model' => $model,
                    'attribute' => 'edu_info',
                    'width' => '1200',
                    'height' => '426',
                    'resizeMode' => false,
                    'toolbar' => array(
                        array(
                            'PasteFromWord'
                        ),
                        array(
                            'Bold', 'Italic', 'Underline'
                        ),
                        array(
                            'NumberedList', 'BulletedList'
                        ),
                        array(
                            'Table',
                        ),
                    ),
                ));
                ?>
            </td>
        </tr>
    </table>
</fieldset>