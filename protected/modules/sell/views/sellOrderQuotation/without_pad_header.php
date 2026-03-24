<style>
    .invoice-header-wrapper {
        border-bottom: 3px solid #0077d9;
        font-family: 'Segoe UI', sans-serif;
        margin-bottom: 4px;
    }

    .invoice-header-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding-bottom: 4px;
    }

    .invoice-header-logo {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
    }

    .invoice-header-logo img {
        height: 120px;
        max-width: 220px;
        object-fit: contain;
    }

    .invoice-header-company {
        flex: 1 1 auto;
        text-align: center;
        font-weight: bold;
    }

    .invoice-header-barcode {
        flex: 0 0 auto;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: center;
        overflow: visible;
    }

    .invoice-header-barcode svg {
        display: block;
        overflow: visible;
    }

    @media print {
        .invoice-header-wrapper {
            border-bottom: 2px solid #0077d9;
            width: 100%;
            page-break-inside: avoid;
        }

        .invoice-header-inner {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .invoice-header-logo,
        .invoice-header-company,
        .invoice-header-barcode {
            display: table-cell;
            vertical-align: middle;
        }

        .invoice-header-logo { width: 20%; }

        .invoice-header-company {
            width: 60%;
            text-align: center;
        }

        .invoice-header-barcode {
            width: 20%;
            text-align: right;
            max-width: none;
            overflow: visible;
        }

        .invoice-header-barcode svg {
            max-width: 100%;
            height: auto;
            overflow: visible;
        }

        .invoice-header-wrapper *,
        .invoice-header-company {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color: #000 !important;
        }

        .invoice-header-logo img {
            height: 150px;
            max-width: 100%;
        }
    }
</style>

<?php
$logoPath   = Yii::app()->theme->basePath . '/images/logo.svg';
$logoInline = '';
if (is_file($logoPath)) {
    $logoInline = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoPath));
}
?>

<div class="invoice-header-wrapper">
    <div class="invoice-header-inner">

        <div class="invoice-header-logo">
            <?php if ($logoInline): ?>
                <img src="<?= $logoInline ?>" alt="Logo">
            <?php endif; ?>
        </div>

        <div class="invoice-header-company">
            <b style="font-size: 25px;"><?= strtoupper(Yii::app()->params['company']['name']) ?></b>
            <br>
            <?php echo Yii::app()->params['company']['address_line_1']; ?><br>
            অফিস: <?php echo Yii::app()->params['company']['phone_1']; ?><br>
            <?php echo Yii::app()->params['company']['invoice_contact_person']; ?>: <?php echo Yii::app()->params['company']['phone_2']; ?>
        </div>

        <div class="invoice-header-barcode">
            <?php
            require_once(Yii::app()->basePath . '/vendors/html2pdf/_tcpdf_5.0.002/barcodes.php');
            $barW  = 1.0;
            $barH  = 38;
            $pad   = 4;
            $textH = 16;
            try {
                $bc    = new TCPDFBarcode($so_no, 'C128B');
                $bcArr = $bc->getBarcodeArray();
                $svgW  = round($bcArr['maxw'] * $barW) + $pad * 2;
                $svgH  = $barH + $pad + $textH;
                $textY = $barH + $pad + 12;
                $x     = $pad; $rects = '';
                foreach ($bcArr['bcode'] as $bar) {
                    $bw = $bar['w'] * $barW;
                    if ($bar['t']) {
                        $rects .= '<rect x="' . $x . '" y="0" width="' . $bw . '" height="' . $barH . '" fill="#000"/>';
                    }
                    $x += $bw;
                }
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="' . $svgW . '" height="' . $svgH . '" style="display:block; overflow:visible;">'
                   . $rects
                   . '<text x="' . ($svgW / 2) . '" y="' . $textY . '" text-anchor="middle" font-size="11" font-family="monospace" fill="#000" style="-webkit-print-color-adjust:exact; print-color-adjust:exact;">' . htmlspecialchars($so_no) . '</text>'
                   . '</svg>';
            } catch (Exception $e) {}
            ?>
        </div>

    </div>
</div>
