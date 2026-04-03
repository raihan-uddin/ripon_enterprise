/**
 * report-filters.js — Shared logic for report filter forms
 * Load only on report pages (not globally)
 */
$(function () {
    // ── Print button handler ──
    $(document).on('click', '.btn-print, #btn-print, [data-action="print"]', function (e) {
        e.preventDefault();
        var targetId = $(this).data('print-target') || '.final-result';
        var $target = $(targetId);
        if ($target.length) {
            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('body{font-family:Arial,sans-serif;font-size:10pt;margin:20px;}');
            printWindow.document.write('table{width:100%;border-collapse:collapse;}');
            printWindow.document.write('th,td{border:1px solid #000;padding:4px 6px;text-align:left;font-size:10pt;}');
            printWindow.document.write('th{background:#eee;font-weight:bold;}');
            printWindow.document.write('.no-print{display:none;}');
            printWindow.document.write('</style></head><body>');
            printWindow.document.write($target.html());
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    });

    // ── Excel export handler ──
    $(document).on('click', '.btn-excel, #btn-excel, [data-action="excel"]', function (e) {
        e.preventDefault();
        var tableId = $(this).data('table-id') || 'summaryTable';
        var filename = $(this).data('filename') || 'report_' + new Date().toISOString().slice(0, 10);
        if (typeof $.fn.table2excel !== 'undefined') {
            $('#' + tableId).table2excel({
                filename: filename,
                fileext: '.xls',
                exclude: '.no-export'
            });
        }
    });
});
