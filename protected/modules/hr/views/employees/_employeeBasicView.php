<fieldset>
    <legend>Basic Informations</legend>
    <table class="summaryTab">
        <tr>
            <td class="textAlgnLeft">Employee ID</td>
            <td colspan="5"><?php echo $model->emp_id_no; ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Full Name</td>
            <td><?php echo $model->full_name; ?></td>
            <td class="textAlgnLeft">National ID Card No</td>
            <td><?php echo $model->national_id_no; ?></td>
            <td class="textAlgnLeft">Date Of Birth</td>
            <td><?php echo $model->dob; ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Personal (Contact No)</td>
            <td><?php echo $model->contact_no; ?></td>
            <td class="textAlgnLeft">Home (Contact No)</td>
            <td><?php echo $model->contact_no_home; ?></td>
            <td class="textAlgnLeft">Office (Contact No)</td>
            <td><?php echo $model->contact_no_office; ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Father Name</td>
            <td><?php echo $model->father_name; ?></td>
            <td class="textAlgnLeft">Father Occupation</td>
            <td><?php echo $model->father_occupation; ?></td>
            <td class="textAlgnLeft">Email</td>
            <td><?php echo $model->email; ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Mother Name</td>
            <td><?php echo $model->mother_name; ?></td>
            <td class="textAlgnLeft">Mother Occupation</td>
            <td><?php echo $model->mother_occopation; ?></td>
            <td class="textAlgnLeft">Blood Group</td>
            <td><?php echo Lookup::item('blood_group', $model->blood_group); ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Spouse Name</td>
            <td><?php echo $model->spouse_name; ?></td>
            <td class="textAlgnLeft">Religion</td>
            <td><?php echo Lookup::item('religion', $model->religion); ?></td>
            <td class="textAlgnLeft">Gender</td>
            <td><?php echo Lookup::item('gender', $model->gender); ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Spouse Details</td>
            <td><?php echo $model->spouse_details; ?></td>
            <td class="textAlgnLeft">Present Address</td>
            <td><pre><?php echo $model->address; ?></pre></td>
            <td class="textAlgnLeft">Permanent Address</td>
            <td><pre><?php echo $model->permanent_address; ?></pre></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Marital Status</td>
            <td><?php echo Lookup::item('marital_status', $model->marital_status); ?></td>
            <td class="textAlgnLeft">Country</td>
            <td><?php echo Countries::model()->nameOfThis($model->country_id); ?></td>
            <td class="textAlgnLeft">Is Active</td>
            <td><?php echo Lookup::item('is_active', $model->is_active); ?></td>
        </tr>
    </table>
</fieldset>