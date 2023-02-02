<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
    'id' => 'tabsDetailsView',
    'tabs' => array(
        'Basic' => $this->renderPartial('_employeeBasicView', array('model' => $model), TRUE),
        'Official' => $this->renderPartial('_employeeOfficialView', array('model' => $model), TRUE),
        'Skills' => $this->renderPartial('_employeeSkillsView', array('model' => $model), TRUE),
        'Academic' => $this->renderPartial('_employeeAcademicView', array('model' => $model), TRUE),
        'Photo' => $this->renderPartial('_employeePhotoView', array('model' => $model), TRUE),
        'File' => $this->renderPartial('_employeeFilesView', array('model' => $model), TRUE),
    ),
    // additional javascript options for the tabs plugin
    'options' => array(
        'collapsible' => true,
    ),
));
?>
<script>
    $(function () {
        $("#tabsDetailsView").tabs();
    });
</script>
