<fieldset>
    <legend>Contact Persons Customer: <?php echo Customers::model()->customerName($company_id); ?></legend>
    <div class="grid-view">
        <table class="items">
            <thead>
                <tr class="odd">
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Contact Number1</th>
                    <th>Contact Number2</th>
                    <th>Contact Number3</th>
                    <th>E-Mail</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)) { ?>
                    <?php foreach ($data as $d): ?>
                        <tr class="even"> 
                            <td>
                                <?php echo $d->contact_person_name; ?>
                            </td>
                            <td>
                                <?php echo Designations::model()->infoOfThis($d->designation_id); ?>
                            </td>    
                            <td>
                                <?php echo $d->contact_number1; ?>
                            </td>
                            <td>
                                <?php echo $d->contact_number2; ?>
                            </td>
                            <td>
                                <?php echo $d->contact_number3; ?>
                            </td>
                            <td>
                                <?php echo $d->email; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <tr style="text-align: center;">
                        <td colspan="6"><div class="flash-error">No result found!</div></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</fieldset>
