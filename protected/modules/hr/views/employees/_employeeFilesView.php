<fieldset>
    <legend>Employee Photo</legend>
    <table class="summaryTab">
        <tr>
            <td>
                <?php
                if($model->files !=""){
					echo '<a id="filename" target="_blank" href="'. Yii::app()->request->baseUrl . '/upload/empFiles/' . $model->files . '" alt="'.$model->files.'">Download File</a>';
				}
				else{
                    echo "No file upload";
                }
                ?>
            </td>
        </tr>
    </table>
</fieldset>
