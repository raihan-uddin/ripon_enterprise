<style>
    .summaryTab {
        float: left;
        width: 100%;
        margin-bottom: 10px;
        font-size: 12px;
        border: none;
        border-collapse: collapse;
    }

    .summaryTab tr {
        border: 1px dotted #a6a6a6;
    }

    .summaryTab tr td,
    .summaryTab tr th {
        padding: 5px;
        font-size: 12px;
        border: 1px solid #a6a6a6;
        text-align: left;
    }

    .summaryTab tr th {
        background-color: #c0c0c0;
        font-weight: bold;
        border: 1px solid #a6a6a6;
        text-align: center;
    }

    .stock-table-wrapper {
        overflow-x: auto;
    }

    .final-result thead tr.titlesTr th {
        background: #1a2c3d !important;
        color: #ffffff !important;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: 1px solid #243d54;
        border-bottom: 3px solid #17a2b8;
        text-align: center;
        padding: 7px 6px;
        white-space: nowrap;
    }

    #sticky-header-clone-pl {
        display: none;
        position: fixed;
        z-index: 1000;
        background: #1a2c3d;
        border-collapse: collapse;
    }

    #sticky-header-clone-pl th {
        background: #1a2c3d !important;
        color: #ffffff !important;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: 1px solid #243d54;
        border-bottom: 3px solid #17a2b8;
        text-align: center;
        padding: 7px 6px;
        white-space: nowrap;
    }

    .final-result tbody tr:hover {
        background: #dedede;
        transition: background-color 100ms;
    }

    /* ── Report header ── */
    .report-header-wrapper {
        border-bottom: 3px solid #0077d9;
        margin-bottom: 10px;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .report-header-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 8px;
    }

    .report-header-logo { flex: 0 0 auto; }

    .report-header-logo img {
        height: 90px;
        max-width: 200px;
        object-fit: contain;
    }

    .report-header-company {
        flex: 1 1 auto;
        text-align: center;
        line-height: 1.6;
    }

    .report-header-company .company-name {
        font-size: 22px;
        font-weight: 700;
        color: #1a2c3d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .report-header-company .company-sub {
        font-size: 12px;
        color: #555;
    }

    .report-header-meta {
        flex: 0 0 auto;
        text-align: right;
        font-size: 12px;
        line-height: 1.8;
        color: #444;
    }

    .report-header-meta .report-title {
        font-size: 15px;
        font-weight: 700;
        color: #1a2c3d;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #17a2b8;
        padding-bottom: 2px;
        margin-bottom: 4px;
    }

    .report-header-meta .meta-label {
        color: #888;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media print {
        .report-header-wrapper { width: 100%; page-break-inside: avoid; }
        .report-header-inner { display: table; width: 100%; table-layout: fixed; }
        .report-header-logo,
        .report-header-company,
        .report-header-meta { display: table-cell; vertical-align: middle; }
        .report-header-logo  { width: 20%; }
        .report-header-company { width: 50%; text-align: center; }
        .report-header-meta  { width: 30%; text-align: right; }
    }
</style>

<?php
date_default_timezone_set("Asia/Dhaka");

echo "<div class='printBtn' style='width: unset;'>";
echo "  <img class='exportToExcel' id='exportToExcel'  src='" . Yii::app()->theme->baseUrl . "/images/excel.png' title='EXPORT TO EXCEL'>";
$this->widget('ext.mPrint.mPrint', array(
    'title' => ' ',
    'tooltip' => 'Print',
    'text' => '',
    'element' => '.printAllTableForThisReport',
    'exceptions' => array(),
    'publishCss' => TRUE,
    'visible' => !Yii::app()->user->isGuest,
    'alt' => 'print',
    'debug' => FALSE,
    'id' => 'print-div2'
));
echo "</div>";
?>

<script src="<?= Yii::app()->theme->baseUrl ?>/js/jquery.table2excel.js"></script>

<div class='printAllTableForThisReport'>

<?php
$logoPath   = Yii::app()->theme->basePath . '/images/logo.svg';
$logoInline = '';
if (is_file($logoPath)) {
    $logoInline = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoPath));
}
?>

<div class="report-header-wrapper">
    <div class="report-header-inner">

        <div class="report-header-logo">
            <?php if ($logoInline): ?>
                <img src="<?= $logoInline ?>" alt="Logo">
            <?php endif; ?>
        </div>

        <div class="report-header-company">
            <div class="company-name"><?= htmlspecialchars(Yii::app()->params['company']['name']) ?></div>
            <div class="company-sub"><?= htmlspecialchars(Yii::app()->params['company']['address_line_1']) ?></div>
            <div class="company-sub">Tel: <?= htmlspecialchars(Yii::app()->params['company']['phone_1']) ?></div>
        </div>

        <div class="report-header-meta">
            <div class="report-title">Price List</div>
            <div><span class="meta-label">Generated:</span> <?= date('d M Y, h:i A') ?></div>
            <div><span class="meta-label">Printed by:</span> <?= htmlspecialchars(Yii::app()->user->name) ?></div>
        </div>

    </div>
</div>

<div class="stock-table-wrapper">
    <table class="summaryTab final-result table2excel table2excel_with_colors table table-bordered table-sm"
           id="table-pl">
        <thead>
        <tr class="titlesTr">
            <th style="width: 2%;">SL</th>
            <th style="width: 7%;">Company</th>
            <th style="width: 7%;">Category</th>
            <th style="width: 7%;">Product Name</th>
            <th style="width: 7%;">Price</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $sl = 1;
        if ($products) {
            foreach ($products as $dmr) {
                ?>
                <tr>
                    <td><?php echo $sl++; ?></td>
                    <td><?php echo $dmr->company_name ?? 'N/A'; ?></td>
                    <td><?php echo $dmr->brand_name ?? 'N/A'; ?></td>
                    <td><?php echo $dmr->model_name; ?></td>
                    <td style="text-align:right;"><?php echo $dmr->sell_price > 0 ? number_format($dmr->sell_price, 2) : "N/A"; ?></td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>
</div>

<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-bs-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .summaryTab tr td, .summaryTab tr {
        padding: 3px 3px 3px 3px;
        margin: 5px;
        font-size: 12px;
        border: 1px solid #a6a6a6;
        text-align: left;
    }
</style>

<script>
    $(function () {
        $(".exportToExcel").click(function (e) {
            var table = $('.table2excel');
            if (table && table.length) {
                var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "PRICE_LIST-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: preserveColors
                });
            }
        });
    });

    // JS sticky header
    (function () {
        var $table   = $('#table-pl');
        var $origRow = $table.find('thead tr.titlesTr');
        var $clone   = null;

        function buildClone() {
            var $c = $('<table id="sticky-header-clone-pl"><thead><tr></tr></thead></table>');
            $origRow.find('th').each(function () {
                var w = $(this).outerWidth();
                $c.find('tr').append(
                    $('<th>').text($(this).text()).css('width', w + 'px').css('min-width', w + 'px')
                );
            });
            $c.css('width', $table.outerWidth() + 'px');
            $('body').append($c);
            $clone = $c;
        }

        function updateClonePosition() {
            if (!$clone) return;
            var left = $table.offset().left - $(window).scrollLeft();
            $clone.css({ top: 0, left: left + 'px' });
        }

        $(window).on('scroll resize', function () {
            var tableTop    = $table.offset().top;
            var tableBottom = tableTop + $table.outerHeight();
            var scrollTop   = $(window).scrollTop();

            if (scrollTop > tableTop && scrollTop < tableBottom) {
                if (!$clone) buildClone();
                $clone.show();
                updateClonePosition();
            } else {
                if ($clone) $clone.hide();
            }
        });
    })();
</script>
