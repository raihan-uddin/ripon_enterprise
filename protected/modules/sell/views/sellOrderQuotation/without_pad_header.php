<?php
$yourCompany = YourCompany::model()->findByAttributes(['is_active' => YourCompany::ACTIVE]);
$company_name = $company_location = $company_road = $company_house = $company_contact = $company_email = $company_web = $company_trn_no = "N/A";
if ($yourCompany) {
    $company_name = $yourCompany->company_name;
    $company_location = $yourCompany->location;
    $company_road = $yourCompany->road;
    $company_house = $yourCompany->house;
    $company_contact = $yourCompany->contact;
    $company_email = $yourCompany->email;
    $company_web = $yourCompany->web;
    $company_trn_no = $yourCompany->trn_no;
}
?>
<style>
    @media print {
        @page {
            size: 8.27in 11.69in;  /* width height A4 size paper */
            margin-top: 4cm;
            margin-bottom: 4cm;
        }
    }
</style>
<div class="invoice-header-wrapper">
    <div class="header-left">
        <img
                style="width: 250px;"
                src="<?= Yii::app()->theme->baseUrl ?>/images/voucher-logo.png" alt="Logo">
    </div>

    <div class="header-center">
        <h1>QUOTATION</h1>
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