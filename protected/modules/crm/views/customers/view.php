<fieldset>
    <legend>View Customer Info</legend>
    <div class="grid-view">
        <table class="items">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>E-mail</th>
                    <th>Fax</th>  
                    <th>Web</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd">
                    <td><?php echo $model->company_name; ?></td>
                    <td><?php echo $model->company_address; ?></td>
                    <td><?php echo $model->company_contact_no; ?></td>
                    <td><?php echo $model->company_email; ?></td>
                    <td><?php echo $model->company_fax; ?></td>  
                    <td><?php echo $model->company_web; ?></td>  
                </tr>
            </tbody>
        </table>
    </div>
</fieldset>


<fieldset>
    <legend>View Supplier's Contact Persons Info</legend>
    <div class="grid-view">
        <table class="items">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Contact No1</th>
                    <th>Contact No2</th>
                    <th>Contact No3</th>
                    <th>E-mail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $condition = 'company_id=' . $model->id;
                $data = CustomerContactPersons::model()->findAll(array('condition' => $condition,), 'id');
                if ($data) {
                    $i=1;
                    foreach ($data as $d):
                        ?>
                        <tr class="<?php if($i%2==0){ echo 'odd'; }else{ echo 'even'; } ?>">
                            <td><?php echo $d->contact_person_name; ?></td>
                            <td><?php echo Designations::model()->infoOfThis($d->designation_id); ?></td>
                            <td><?php echo $d->contact_number1; ?></td>
                            <td><?php echo $d->contact_number2; ?></td>
                            <td><?php echo $d->contact_number3; ?></td>
                            <td><?php echo $d->email; ?></td>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                }else {
                    ?>
                    <tr class="even">
                        <td colspan="6"><div class="flash-error">No result found!</div></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</fieldset>



