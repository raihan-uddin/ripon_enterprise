<?php
/*
 *  help topics:
 * ----------------
 * 
 * 1. Product's sale price, discount, warn quantity, ideal quantity -> Setup -> Products
 * 
 * 2. Customer's money receipt, credit limit -> Setup -> Customers
 * 
 * 3. Create Stores And Assign Stores To An User -> Setup -> Stores & Assign Stores To Users
 * 
 * 4. Number format for Quick Sale, Sale Order AND Purchase -> Setup -> Number Format
 * 
 * 5. Manually ADD Product to The Inventory (Product's Sale Price AND Discount Should be added before) -> Setup -> Inventory Stock
 * 
 * 6. Choose The Options Which Will be Shown as Product Description in Sales & Purchase Vouchers -> Setup -> Chooce Options to Display ...
 * 
 * 7. Set Time Range for DELETE & UPDATE for Sales, Purchase, Quick Sales -> Setup -> Set Time Range For Update & Delete
*/
?>
<div class="grid-view">
    <table class="items">
        <tr>
            <th>---------INSTRUCTIONS---------</th>
        </tr> 
        <tr>
            <td>
                <ul class="helpUl">
                    <li>Product's sale price, discount, warn quantity, ideal quantity <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Setup <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Products</li>
                    <li>Turn ON/OFF Product's Sale Price Editable On Sales Order & Quick Sales Validation In Sales Order (If <font style="color: green;">ACTIVE</font>, sales price will not be editable and Vice Versa) <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Setup <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Some Validation Settings</li>
                    <li>Customer's money receipt, credit limit <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Setup <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Customers</li>
                    <li>Set Customer's Available Balance Validation In Sales Order (If <font style="color: green;">ACTIVE</font>, sales order will not be created IF customer's Available Balance Is ZERO and Vice Versa) <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Setup <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Some Validation Settings</li>
                    <li>Create Stores And Assign Stores To An User <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Setup <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Stores & Assign Stores To Users</li>
                    <li>Number format for Quick Sale, Sale Order AND Purchase <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Setup <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Number Format</li>
                    <li>Manually ADD Product to The Inventory (Product's Sale Price AND Discount Should be added before) <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Setup <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Inventory Stock</li>
                    <li>Choose The Options Which Will be Shown as Product Description in Sales & Purchase Vouchers <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Setup <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Chooce Options to Display ...</li>
                    <li>Set Time Range for DELETE & UPDATE for Sales, Purchase, Quick Sales <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Setup <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/this.ico"/> Set Time Range For Update & Delete</li>
                </ul>
            </td>
        </tr>
    </table>
</div>

<style>
    .grid-view table.items tr td{
        background-color: #EEFEFE;
    }
    ul.helpUl li{
        list-style-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/list-ico.ico);
        list-style-position: inside;
        line-height: 30px;
        font-size: 14px;
        font-family: -moz-fixed;
    }
</style>