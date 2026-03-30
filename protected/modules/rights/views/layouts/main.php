<?php $this->beginContent(Rights::module()->appLayout); ?>

<?php
Yii::app()->clientScript->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css');
Yii::app()->clientScript->registerScriptFile('https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js', CClientScript::POS_END);
?>

<style>
/* Rights module — standard AdminLTE/Bootstrap overrides only */

/* Grid-view table → Bootstrap bordered table */
.grid-view table{width:100%;margin-bottom:0;border-collapse:collapse}
.grid-view table th{
    background:#f8f9fa;font-size:11.5px;font-weight:600;
    text-transform:uppercase;letter-spacing:.4px;color:#6c757d;
    padding:10px 12px;border:1px solid #dee2e6;white-space:nowrap}
.grid-view table td{
    padding:9px 12px;border:1px solid #dee2e6;
    font-size:13px;vertical-align:middle;color:#212529}
.grid-view table tbody tr:hover td{background:#f5f5f5}
.grid-view table .empty{
    text-align:center;color:#6c757d;font-style:italic;
    padding:24px;border:1px solid #dee2e6}

/* Delete / remove action links */
.delete-link{color:#dc3545;font-size:12px;text-decoration:none}
.delete-link:hover{color:#a71d2a;text-decoration:underline}
.remove-link{color:#dc3545;font-size:12px;text-decoration:none}
.remove-link:hover{color:#a71d2a;text-decoration:underline}

/* Flash toasts — fixed top-right, always visible */
#rightsToastWrap{
    position:fixed!important;top:68px!important;right:20px!important;z-index:99999!important;
    display:flex!important;flex-direction:column;gap:8px;
    max-width:400px;pointer-events:none;
}
#rightsToastWrap .rights-toast{
    display:flex!important;align-items:center!important;gap:10px!important;
    padding:13px 16px!important;border-radius:10px!important;
    font-size:13px!important;font-weight:500!important;line-height:1.4!important;
    box-shadow:0 4px 20px rgba(0,0,0,.18)!important;pointer-events:all!important;
    margin:0!important;animation:rToastIn .28s cubic-bezier(.34,1.56,.64,1);
}
#rightsToastWrap .rights-toast-success{
    background:#ecfdf5!important;color:#065f46!important;border:1px solid #a7f3d0!important;
}
#rightsToastWrap .rights-toast-error{
    background:#fef2f2!important;color:#991b1b!important;border:1px solid #fecaca!important;
}
#rightsToastWrap .rights-toast i   {font-size:15px!important;flex-shrink:0;color:inherit!important}
#rightsToastWrap .rights-toast span{flex:1;color:inherit!important}
#rightsToastWrap .rights-toast-close{
    background:none!important;border:none!important;cursor:pointer!important;
    font-size:18px!important;line-height:1!important;
    padding:0 0 0 6px!important;opacity:.5;color:inherit!important;flex-shrink:0;
}
#rightsToastWrap .rights-toast-close:hover{opacity:1}
#rightsToastWrap .rights-toast-out{animation:rToastOut .3s ease forwards!important}
@keyframes rToastIn{
    from{opacity:0;transform:translateY(-10px) scale(.95)}
    to  {opacity:1;transform:none}
}
@keyframes rToastOut{
    from{opacity:1;transform:none}
    to  {opacity:0;transform:translateX(20px)}
}

/* Checkboxes (fallback) */
.chk,#chkAll{accent-color:#6366f1;cursor:pointer}

/* Info text */
p.info,small.form-text{color:#6c757d;font-size:12px}

/* (generate table styles are self-contained in generate.php) */

/* ── Select2 v4 — indigo theme overrides ── */
.select2-container--default .select2-selection--multiple,
.select2-container--default .select2-selection--single {
    border:1px solid #e2e8f0;
    border-radius:8px;
    min-height:38px;
    background:#fff;
    font-size:13px;
}
.select2-container--default .select2-selection--single {
    height:38px;
    display:flex;
    align-items:center;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height:36px;
    padding-left:12px;
    color:#374151;
    font-size:13px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height:36px;
    right:6px;
}
.select2-container--default .select2-selection--multiple {
    padding:3px 6px;
}
/* Focus ring */
.select2-container--default.select2-container--focus .select2-selection--multiple,
.select2-container--default.select2-container--open  .select2-selection--multiple,
.select2-container--default.select2-container--open  .select2-selection--single {
    border-color:#6366f1;
    box-shadow:0 0 0 3px rgba(99,102,241,.12);
    outline:none;
}
/* Tags / chips */
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background:#eef2ff;
    border:1px solid #c7d2fe;
    color:#4338ca;
    border-radius:20px;
    padding:1px 6px 1px 10px;
    font-size:12px;
    font-weight:500;
    margin:2px 3px 2px 0;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color:#6366f1;
    margin-right:5px;
    font-size:14px;
    font-weight:700;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color:#4338ca;
    background:transparent;
}
/* Placeholder */
.select2-container--default .select2-selection--multiple .select2-selection__placeholder,
.select2-container--default .select2-selection--multiple input.select2-search__field::placeholder {
    color:#9ca3af;
    font-size:13px;
}
.select2-container--default .select2-selection--multiple .select2-search__field {
    font-size:13px;
    color:#374151;
    margin-top:4px;
}
/* Dropdown */
.select2-dropdown {
    border:1px solid #e2e8f0;
    border-radius:10px;
    box-shadow:0 6px 28px rgba(0,0,0,.12);
    overflow:hidden;
    font-size:13px;
}
.select2-container--default .select2-results__option {
    padding:8px 12px;
    color:#374151;
    font-size:13px;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background:#6366f1;
    color:#fff;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background:#eef2ff;
    color:#4338ca;
    font-weight:500;
}
.select2-container--default .select2-results__option[aria-selected=true]:hover,
.select2-container--default .select2-results__option[aria-selected=true].select2-results__option--highlighted {
    background:#6366f1;
    color:#fff;
}
/* Optgroup labels */
.select2-results__group {
    padding:7px 12px 3px;
    font-size:10.5px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.6px;
    color:#9ca3af;
}
/* Search box inside dropdown */
.select2-container--default .select2-search--dropdown .select2-search__field {
    border:1px solid #e2e8f0;
    border-radius:6px;
    padding:6px 10px;
    font-size:13px;
    outline:none;
}
.select2-container--default .select2-search--dropdown .select2-search__field:focus {
    border-color:#6366f1;
    box-shadow:0 0 0 2px rgba(99,102,241,.12);
}
/* "No results" */
.select2-container--default .select2-results__option.select2-results__message {
    color:#9ca3af;
    font-style:italic;
    text-align:center;
    padding:16px;
}
/* Clear button (single select) */
.select2-container--default .select2-selection--single .select2-selection__clear {
    color:#9ca3af;
    font-size:16px;
    font-weight:400;
    margin-right:8px;
}
.select2-container--default .select2-selection--single .select2-selection__clear:hover {
    color:#374151;
}
</style>

<div id="rights" style="padding:16px 0">

    <?php if ($this->id !== 'install'): ?>
        <?php $this->renderPartial('/_menu'); ?>
    <?php endif; ?>

    <?php $this->renderPartial('/_flash'); ?>

    <?php echo $content; ?>

</div>

<script>
$(function () {
    /* Init Select2 on all rights-module selects tagged with data-rms */
    $('select[data-rms]').each(function () {
        var $el = $(this);
        $el.select2({
            placeholder:  $el.attr('data-placeholder') || 'Select…',
            allowClear:   true,
            width:        '100%',
            closeOnSelect: !this.multiple,   /* keep open for multiselect */
        });
    });
});
</script>

<?php $this->endContent(); ?>
