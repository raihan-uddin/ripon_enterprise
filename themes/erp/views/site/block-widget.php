<?php
/* current month */
$mS = date('Y-m-01'); $mE = date('Y-m-t');
/* last month */
$lS = date('Y-m-01', strtotime('-1 month'));
$lE = date('Y-m-t',  strtotime('-1 month'));

$db = Yii::app()->db;

/* orders */
$cOrders = new CDbCriteria();
$cOrders->addColumnCondition(['order_type'=>SellOrder::NEW_ORDER]);
$cOrders->select = "COUNT(*) as id";
$dOrders = SellOrder::model()->findByAttributes([],$cOrders);
$totalOrders = $dOrders ? (int)$dOrders->id : 0;
$lastOrders  = (int)$db->createCommand()->select('COUNT(*)')->from('sell_order')
    ->where('order_type=:t AND date BETWEEN :s AND :e',[':t'=>SellOrder::NEW_ORDER,':s'=>$lS,':e'=>$lE])->queryScalar();

/* quotations */
$cQ = new CDbCriteria();
$cQ->addColumnCondition(['order_type'=>SellOrder::REPAIR_ORDER]);
$cQ->select = "COUNT(*) as id";
$dQ = SellOrder::model()->findByAttributes([],$cQ);
$totalQuotations = $dQ ? (int)$dQ->id : 0;
$lastQuotations  = (int)$db->createCommand()->select('COUNT(*)')->from('sell_order')
    ->where('order_type=:t AND date BETWEEN :s AND :e',[':t'=>SellOrder::REPAIR_ORDER,':s'=>$lS,':e'=>$lE])->queryScalar();

/* suppliers */
$cS = new CDbCriteria(); $cS->select="COUNT(*) as id";
$dS = Suppliers::model()->findByAttributes([],$cS);
$totalSuppliers = $dS ? (int)$dS->id : 0;
$lastSuppliers  = (int)$db->createCommand()->select('COUNT(*)')->from('suppliers')
    ->where('created_datetime BETWEEN :s AND :e',[':s'=>$lS.' 00:00:00',':e'=>$lE.' 23:59:59'])->queryScalar();

/* customers */
$cC = new CDbCriteria(); $cC->select="COUNT(*) as id";
$dC = Customers::model()->findByAttributes([],$cC);
$totalCustomers = $dC ? (int)$dC->id : 0;
$lastCustomers  = (int)$db->createCommand()->select('COUNT(*)')->from('customers')
    ->where('created_datetime BETWEEN :s AND :e',[':s'=>$lS.' 00:00:00',':e'=>$lE.' 23:59:59'])->queryScalar();

function bwPct($cur,$prev){
    if($prev<=0) return $cur>0?'+100':null;
    $p=round(($cur-$prev)/$prev*100);
    return ($p>=0?'+':'').$p;
}
function bwBadge($cur,$prev){
    $p=bwPct($cur,$prev);
    if($p===null) return '';
    $pos=strpos($p,'+')===0;
    $cls=$pos?'bw-up':'bw-down';
    $ico=$pos?'fa-arrow-up':'fa-arrow-down';
    return '<span class="bw-badge '.$cls.'"><i class="fa '.$ico.'"></i>'.$p.'%</span>';
}
?>
<style>
.bw-badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:700;
border-radius:20px;padding:2px 7px;margin-left:6px;}
.bw-badge i{font-size:9px;}
.bw-up  {background:rgba(255,255,255,.22);color:#fff;}
.bw-down{background:rgba(0,0,0,.18);color:rgba(255,255,255,.9);}
</style>

<div class="row">
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="db-stat-card c-indigo db-animate db-animate-d1">
            <div class="db-stat-icon"><i class="fa fa-shopping-cart"></i></div>
            <div class="db-stat-body">
                <div class="db-stat-num" data-count="<?= $totalOrders ?>">0</div>
                <div class="db-stat-label">Total Orders <?= bwBadge($totalOrders,$lastOrders) ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="db-stat-card c-green db-animate db-animate-d2">
            <div class="db-stat-icon"><i class="fa fa-file-text-o"></i></div>
            <div class="db-stat-body">
                <div class="db-stat-num" data-count="<?= $totalQuotations ?>">0</div>
                <div class="db-stat-label">Total Quotations <?= bwBadge($totalQuotations,$lastQuotations) ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="db-stat-card c-amber db-animate db-animate-d3">
            <div class="db-stat-icon"><i class="fa fa-truck"></i></div>
            <div class="db-stat-body">
                <div class="db-stat-num" data-count="<?= $totalSuppliers ?>">0</div>
                <div class="db-stat-label">Suppliers</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="db-stat-card c-blue db-animate db-animate-d4">
            <div class="db-stat-icon"><i class="fa fa-users"></i></div>
            <div class="db-stat-body">
                <div class="db-stat-num" data-count="<?= $totalCustomers ?>">0</div>
                <div class="db-stat-label">Customers</div>
            </div>
        </div>
    </div>
</div>
