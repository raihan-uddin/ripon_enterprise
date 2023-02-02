<fieldset>
    <legend>Basic Information's</legend>
    <table>
        <tr>
            <td><?php echo $form->labelEx($model, 'emp_id_no'); ?></td>
            <td colspan="2"><?php echo $form->textField($model, 'emp_id_no', array('maxlength' => 255, 'style' => 'width: 99%;', 'class' => 'form-control')); ?></td>
            <td><span class="heighlightSpan">Keep Members ID blank to auto generate!</span></td>
            <td><?php //echo $form->labelEx($model, 'device_id');   ?></td>
            <td><?php //echo $form->textField($model, 'device_id');   ?></td>
            <?php echo $form->error($model, 'emp_id_no'); ?>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'full_name'); ?></td>
            <td>
                <?php echo $form->textField($model, 'full_name', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'full_name'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'dob'); ?></td>
            <td>
                <div class="input-group" id="dob" data-target-input="nearest">
                    <?php echo $form->textField($model, 'dob', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', )); ?>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <?php echo $form->error($model, 'dob'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'email'); ?></td>
            <td>
                <?php echo $form->textField($model, 'email', ['class' => 'form-control' ]); ?>
                <?php echo $form->error($model, 'email'); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'gender'); ?></td>
            <td>
                <?php echo $form->dropDownList($model, 'gender', Lookup::items('gender'), array('prompt' => 'Select', 'class' => 'form-control')); ?>
                <?php echo $form->error($model, 'gender'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'is_active'); ?></td>
            <td>
                <?php echo $form->dropDownList($model, 'is_active', Lookup::items('is_active'), ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'is_active'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'marital_status'); ?></td>
            <td>
                <?php echo $form->dropDownList($model, 'marital_status', Lookup::items('marital_status'), array('prompt' => 'Select', 'class' => 'form-control')); ?>
                <?php echo $form->error($model, 'marital_status'); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'father_name'); ?></td>
            <td>
                <?php echo $form->textField($model, 'father_name', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'father_name'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'national_id_no'); ?></td>
            <td>
                <?php echo $form->textField($model, 'national_id_no', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'national_id_no'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'tin'); ?></td>
            <td>
                <?php echo $form->textField($model, 'tin', array('maxlength' => 255, 'class' => 'form-control')); ?>
                <?php echo $form->error($model, 'tin'); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'mother_name'); ?></td>
            <td>
                <?php echo $form->textField($model, 'mother_name', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'mother_name'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'p_email'); ?></td>
            <td>
                <?php echo $form->textField($model, 'p_email', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'p_email'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'religion'); ?></td>
            <td>
                <?php echo $form->dropDownList($model, 'religion', Lookup::items('religion'), array('prompt' => 'Select', 'class' => 'form-control')); ?>
                <?php echo $form->error($model, 'religion'); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'address'); ?></td>
            <td>
                <?php echo $form->textArea($model, 'address', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'address'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'permanent_address'); ?></td>
            <td>
                <?php echo $form->textArea($model, 'permanent_address', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'permanent_address'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'blood_group'); ?></td>
            <td>
                <?php echo $form->dropDownList($model, 'blood_group', Lookup::items('blood_group'), array('prompt' => 'Select', 'class' => 'form-control')); ?>
                <?php echo $form->error($model, 'blood_group'); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'contact_no'); ?></td>
            <td>
                <?php echo $form->textField($model, 'contact_no', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'contact_no'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'contact_no_home'); ?></td>
            <td>
                <?php echo $form->textField($model, 'contact_no_home', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'contact_no_home'); ?>
            </td>
            <td><?php echo $form->labelEx($model, 'contact_no_office'); ?></td>
            <td>
                <?php echo $form->textField($model, 'contact_no_office', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'contact_no_office'); ?>
            </td>
        </tr>
    </table>
</fieldset>
<script>
    var picker = new Lightpick({
        field: document.getElementById('dob'),
        onSelect: function (date) {
            document.getElementById('Employees_dob').value = date.format('YYYY-MM-DD');
        }
    });
</script>