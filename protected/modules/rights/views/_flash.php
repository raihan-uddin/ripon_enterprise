<?php
$hasSuccess = Yii::app()->user->hasFlash('RightsSuccess') === true;
$hasError   = Yii::app()->user->hasFlash('RightsError')   === true;
if (!$hasSuccess && !$hasError) return;
?>

<div id="rightsToastWrap">
    <?php if ($hasSuccess): ?>
        <div class="rights-toast rights-toast-success">
            <i class="fa fa-check-circle"></i>
            <span><?php echo Yii::app()->user->getFlash('RightsSuccess'); ?></span>
            <button class="rights-toast-close" type="button">&times;</button>
        </div>
    <?php endif; ?>
    <?php if ($hasError): ?>
        <div class="rights-toast rights-toast-error">
            <i class="fa fa-exclamation-circle"></i>
            <span><?php echo Yii::app()->user->getFlash('RightsError'); ?></span>
            <button class="rights-toast-close" type="button">&times;</button>
        </div>
    <?php endif; ?>
</div>

<script>
$(function () {
    $('#rightsToastWrap .rights-toast').each(function () {
        var $t = $(this);
        var timer = setTimeout(function () { dismissToast($t); }, 4500);
        $t.find('.rights-toast-close').on('click', function () {
            clearTimeout(timer);
            dismissToast($t);
        });
    });

    function dismissToast($t) {
        $t.addClass('rights-toast-out');
        setTimeout(function () {
            $t.remove();
            if (!$('#rightsToastWrap .rights-toast').length) $('#rightsToastWrap').remove();
        }, 300);
    }
});
</script>
