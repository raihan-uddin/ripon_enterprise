<?php
$yourCompany = YourCompany::model()->findByAttributes(['is_active' => YourCompany::ACTIVE]);
$company_name = $yourCompany->company_name ?? 'Company Name';
$company_road = $yourCompany->road ?? '';
$company_house = $yourCompany->house ?? '';
$company_location = $yourCompany->location ?? '';
$company_contact = $yourCompany->contact ?? '';
$company_email = $yourCompany->email ?? '';
$company_web = $yourCompany->web ?? '';
?>

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
        <b><?= strtoupper($company_name) ?></b>
        <?= $company_road ?><br>
        <?= $company_house ?>, 
        <?= $company_location ?><br>
        Phone: <?= $company_contact ?><br>
        Email: <?= $company_email ?><br>
        Website: <?= $company_web ?>
    </div>
</div>
