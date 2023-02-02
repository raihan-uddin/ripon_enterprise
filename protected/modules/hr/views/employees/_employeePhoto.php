<fieldset>
    <legend>Upload Members Photo</legend>
    <?php
    $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
        'id' => 'image',
        'config' => array(
            'action' => Yii::app()->createUrl('/hr/employees/upload'),
            'allowedExtensions' => array("jpg", "jpeg", "png", "gif"),
            'sizeLimit' => 2 * 1024 * 1024, // maximum file size in bytes
            'onSubmit' => "js:function(file, extension) { 
                        $('div.preview').addClass('loading');
                      }",
            'onComplete' => "js:function(file, response, responseJSON) {
                          $('#thumb').load(function(){
                            $('div.preview').removeClass('loading');
                            $('#thumb').unbind();
                            $('#Employees_photo').val(responseJSON['filename']);
                          });
                          $('#thumb').attr('src', '" . Yii::app()->request->baseUrl . "/uploads/empPhoto/'+responseJSON['filename']);
                        }",
            'messages' => array(
                'typeError' => "{file} has invalid extension. Only {extensions} are allowed.",
                'sizeError' => "{file} is too large, maximum file size is {sizeLimit}.",
                'emptyError' => "{file} is empty, please select files again without it.",
                'onLeave' => "The files are being uploaded, if you leave now the upload will be cancelled."
            ),
        )
    ));

    echo $form->hiddenField($model, 'photo');
    if ($model->photo != "") {
        echo "<img id='thumb' src='" . Yii::app()->request->baseUrl . "/uploads/empPhoto/" . $model->photo . "' alt='" . $model->photo . "'>";
    } else {
        echo "<img id='thumb' src='" . Yii::app()->theme->baseUrl . "/images/preview_img.png' alt='Employee Photo'>";
    }

    ?>
    <?php echo $form->error($model, 'photo'); ?>
</fieldset>
<style>
    #thumb {
        float: left;
        height: 250px;
        width: 280px;
    }
</style>