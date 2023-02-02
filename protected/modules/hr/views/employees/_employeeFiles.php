<fieldset>
    <legend>Upload Employee Files</legend>
    <?php
    $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
        'id' => 'text',
        'config' => array(
            'action' => Yii::app()->createUrl('/employees/uploadFiles'),
            'allowedExtensions' => array("jpg", "jpeg", "png", "gif", "pdf"),
            'sizeLimit' => 10 * 1024 * 1024, // maximum file size in bytes
            'onSubmit' => "js:function(file, extension) { 
                        $('div.preview').addClass('loading');
                      }",
            'onComplete' => "js:function(file, response, responseJSON) {
               	$('#Employees_files').val(responseJSON['filename']);
           	}",
            'messages' => array(
                'typeError' => "{file} has invalid extension. Only {extensions} are allowed.",
                'sizeError' => "{file} is too large, maximum file size is {sizeLimit}.",
                'emptyError' => "{file} is empty, please select files again without it.",
                'onLeave' => "The files are being uploaded, if you leave now the upload will be cancelled."
            ),
        )
    ));

    echo $form->hiddenField($model, 'files');
    if ($model->files != "") {
        echo '<a id="filename" target="_blank" href="' . Yii::app()->request->baseUrl . '/upload/empFiles/' . $model->files . '" alt="' . $model->files . '">View File</a>';
    }

    ?>
    <?php echo $form->error($model, 'files'); ?>
</fieldset>
<style>
    #thumb {
        float: left;
        height: 250px;
        width: 280px;
    }
</style>