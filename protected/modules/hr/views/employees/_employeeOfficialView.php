<fieldset>
    <legend>Official Informations</legend>
    <table class="summaryTab">
        <tr>
            <td class="textAlgnLeft">Join Date</td>
            <td><?php echo $model->join_date; ?></td>
            <td class="textAlgnLeft">Permanent Date</td>
            <td><?php echo $model->permanent_date; ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Punch Card No</td>
            <td><?php echo $model->id_no; ?></td>
            <td class="textAlgnLeft">Employee Type</td>
            <td><?php echo Lookup::item('employee_type', $model->employee_type); ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Designation</td>
            <td><?php echo Designations::model()->infoOfThis($model->designation_id); ?></td>
            <td class="textAlgnLeft">Department</td>
            <td><?php echo Departments::model()->nameOfThis($model->department_id); ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Section</td>
            <td><?php echo Sections::model()->nameOfThis($model->section_id); ?></td>
            <td class="textAlgnLeft">Sub-Department</td>
            <td><?php echo DepartmentsSub::model()->nameOfThis($model->sub_department_id); ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Team / Line</td>
            <td><?php echo Teams::model()->infoOfThis($model->team_id); ?></td>
            <td class="textAlgnLeft">Branch</td>
            <td><?php echo Branches::model()->nameOfThis($model->branch_id); ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Stuff Category</td>
            <td><?php echo StuffCat::model()->nameOfThis($model->stuff_cat_id); ?></td>
            <td class="textAlgnLeft">Stuff Sub-Category</td>
            <td><?php echo StuffSubCat::model()->nameOfThis($model->stuff_sub_cat_id); ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Bank A/C No</td>
            <td><?php echo $model->bank_ac_no; ?></td>
            <td class="textAlgnLeft">Bank</td>
            <td><?php echo $model->bank; ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Shift</td>
            <td><?php echo ShiftHeads::model()->detailsOfThis($model->shift_id); ?></td>
            <td class="textAlgnLeft">Contact End</td>
            <td><?php echo $model->contact_end; ?></td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Previous Experiences (Employment History)</td>
            <td colspan="3">
                <pre>
                    <?php echo $model->prev_info; ?>
                </pre>
            </td>
        </tr>
        <tr>
            <td class="textAlgnLeft">Reference</td>
            <td colspan="3">
                <pre>
                    <?php echo $model->reference; ?>
                </pre>
            </td>
        </tr>
    </table>
</fieldset>