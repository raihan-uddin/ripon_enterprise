<fieldset>
    <legend>Employee Photo</legend>
    <table class="summaryTab">
        <tr>
            <td>
                <?php
                if($model->photo!=""){
                    echo "<img id='thumb' src='" . Yii::app()->request->baseUrl . "/upload/empPhoto/" . $model->photo . "' alt='".$model->photo."'>";
                }else{
                    echo "<img id='thumb' src='" . Yii::app()->theme->baseUrl . "/images/preview_img.png' alt='Employee Photo'>";
                }
                ?>
            </td>
        </tr>
    </table>
</fieldset>
