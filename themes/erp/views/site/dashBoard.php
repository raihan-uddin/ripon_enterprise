<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Dashboard'),
    ),
));
$this->renderPartial('shortcut-link');

$this->renderPartial('report-shortcut');

// only show this widget if the user is admin
if (Yii::app()->user->checkAccess('admin')) {
    $this->renderPartial('summary-widget');
    $this->renderPartial('_graph');
//    $this->renderPartial('_graphInventory');
}

?>

<script>
    $(document).keydown(function(e) {
    // Check if 'Ctrl' key (e.ctrlKey) and 'S' key (e.keyCode === 83) are pressed
    if (e.ctrlKey && e.keyCode === 83) {
        e.preventDefault(); // Prevent the default action (saving the page)
        // Custom code to handle Ctrl+S action
        // go to sale order page
        window.location.href = "<?php echo Yii::app()->createUrl('sell/sellOrder/create'); ?>";
    }

    // Check if 'Ctrl' key (e.ctrlKey) and 'P' key (e.keyCode === 80) are pressed
    if (e.ctrlKey && e.keyCode === 80) {
        e.preventDefault(); // Prevent the default action (printing the page)
        // Custom code to handle Ctrl+P action
        // go to purchase order page
        window.location.href = "<?php echo Yii::app()->createUrl('commercial/purchaseOrder/create'); ?>";
    }

    // Check if 'Ctrl' key (e.ctrlKey) and 'E' key (e.keyCode === 69) are pressed
    if (e.ctrlKey && e.keyCode === 69) {
        e.preventDefault(); // Prevent the default action (printing the page)
        // Custom code to handle Ctrl+E action
        // go to expense page
        window.location.href = "<?php echo Yii::app()->createUrl('accounting/expense/create '); ?>";
    }
});
</script>