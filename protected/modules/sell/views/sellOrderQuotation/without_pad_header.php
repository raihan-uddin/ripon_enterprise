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
<div style="width: 100%; float: left; clear: right;">
    <div style="width: 30%; float: left; clear: right;">
        <img src="<?= Yii::app()->theme->baseUrl . "/images/voucher-logo.png" ?>"
             style="width: 160px; height: 120px;" alt="">
    </div>
    <div style="width: 70%; float: left; clear: right; text-align: right; font-size: 12px;">
        <span>QUOTATION</span> <br>
        <span><b>The Mihan Engineers (TMEBD)</b></span><br>
        <?php
        echo "$company_road<br>";
        echo "$company_house<br>";
        echo "$company_location<br>";
        echo "Phone : $company_contact<br>";
        echo "Email: $company_email<br>";
        echo "Website: $company_web<br>";
        ?>
    </div>
</div>