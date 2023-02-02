<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('full_name')); ?>:</b>
    <?php echo CHtml::encode($data->full_name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('designation_id')); ?>:</b>
    <?php echo CHtml::encode($data->designation_id); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('department_id')); ?>:</b>
    <?php echo CHtml::encode($data->department_id); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('contact_no')); ?>:</b>
    <?php echo CHtml::encode($data->contact_no); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
    <?php echo CHtml::encode($data->address); ?>
    <br/>


</div>