<style>
    .invoice-header-wrapper {
        border-bottom: 3px solid #0077d9;
        font-family: 'Segoe UI', sans-serif;
        margin-bottom: 8px;
        text-align: center;
    }

    @media print {
        @page {
            size: A4;
            /*margin-top: 4cm;
            margin-bottom: 4cm;*/
        }

        .invoice-header-wrapper {
            border-bottom: 2px solid #0077d9;
        }
    }
</style>

<div class="invoice-header-wrapper">
    <b style="font-size: 25px;"><?= strtoupper(Yii::app()->params['company']['name']) ?></b>
    <br>
    <?php echo Yii::app()->params['company']['address_line_1']; ?><br>
    ফোন: <?php echo Yii::app()->params['company']['phone_1']; ?>,
    <?php echo Yii::app()->params['company']['phone_2']; ?>
    (<?php echo Yii::app()->params['company']['invoice_contact_person']; ?>)
</div>
