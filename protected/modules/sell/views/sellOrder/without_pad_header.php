<style>
    .invoice-header-wrapper {
        display: flex;
        align-items: center;
        border-bottom: 3px solid #0077d9;
        font-family: 'Segoe UI', sans-serif;
        margin-bottom: 8px;
    }

    .header-left {
        padding: 20px 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 180px;
        height: 120px;
    }

    .header-left img {
        max-height: 100%;
        width: auto;
    }

    .header-center {
        flex-grow: 1;
        padding: 0 20px;
        color: #333;
    }

    .header-center h1 {
        font-size: 24px;
        margin: 0;
        font-weight: bold;
    }

    .header-center p {
        margin: 3px 0 0 0;
        font-size: 12px;
        color: #777;
    }

    .header-right {
        text-align: right;
        font-size: 12px;
        color: #333;
        padding-right: 20px;
    }

    .header-right b {
        display: block;
        font-size: 14px;
        margin-bottom: 3px;
    }

    @media print {
        @page { size: A4; margin-top: 4cm; margin-bottom: 4cm; }
        .invoice-header-wrapper { border-bottom: 2px solid #0077d9; }
    }
</style>

<div class="invoice-header-wrapper">
    <div class="header-left">
        <img src="<?= Yii::app()->theme->baseUrl ?>/images/voucher-logo.png" alt="Mihan Logo">
    </div>

    <div class="header-center">
        <h1>INVOICE</h1>
    </div>

    <div class="header-right">
        <b style="font-size: 25px;"><?= strtoupper(Yii::app()->params['company']['name']) ?></b>
        <?php echo Yii::app()->params['company']['address_line_1']; ?><br>
        <?php echo Yii::app()->params['company']['address_line_2']; ?><br>
        Phone: <?php echo Yii::app()->params['company']['phone_1']; ?><br>
        Email: <?php echo Yii::app()->params['company']['email_1']; ?><br>
        Website: <?php echo Yii::app()->params['company']['web']; ?>
    </div>
</div>
