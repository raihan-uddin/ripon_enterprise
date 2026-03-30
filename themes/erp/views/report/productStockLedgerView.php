<?php
/** @var Inventory[] $data */
/** @var string $dateFrom */
/** @var string $dateTo */
/** @var integer $model_id */

/* product info — use model directly so this works even when $data is empty */
$product      = $model_id > 0 ? ProdModels::model()->findByPk($model_id) : null;
$model_name   = $product ? $product->model_name : '—';
$code         = $product ? $product->code : '';
$manufacturer = ($product && $product->manufacturer_id) ? Company::model()->findByPk($product->manufacturer_id) : null;
$category     = ($product && $product->item_id)         ? ProdItems::model()->findByPk($product->item_id)             : null;
$subCategory  = ($product && $product->brand_id)        ? ProdBrands::model()->findByPk($product->brand_id)           : null;

/* totals — use explicit loop; array_column doesn't call CActiveRecord __get */
$totalIn = 0; $totalOut = 0; $totalInValue = 0; $totalOutValue = 0;
foreach ($data as $r) {
    $totalIn       += $r->stock_in;
    $totalOut      += $r->stock_out;
    $totalInValue  += $r->stock_in  * $r->purchase_price;
    $totalOutValue += $r->stock_out * $r->sell_price;
}
$balance = $totalIn - $totalOut;

/* running balance — data is ordered desc, reverse to build map asc */
$dataAsc = array_reverse($data);
$runningMap = []; $run = 0;
foreach ($dataAsc as $r) {
    $run += $r->stock_in - $r->stock_out;
    $runningMap[$r->id] = $run;
}
?>
<style>
:root{
    --pl-accent:#0f766e;--pl-accent2:#14b8a6;
    --pl-accent-light:#f0fdfa;--pl-accent-border:#99f6e4;
    --pl-green:#15803d;--pl-red:#b91c1c;--pl-amber:#b45309;
    --pl-text:#0f172a;--pl-muted:#64748b;--pl-border:#e2e8f0;
}
.pl-wrap{font-family:'Segoe UI',system-ui,sans-serif;color:var(--pl-text);margin-bottom:24px;}

/* ─── HEADER ─── */
.pl-hdr{position:relative;border-radius:14px;overflow:hidden;
        background:linear-gradient(135deg,#134e4a 0%,#0f766e 50%,#0891b2 100%);
        padding:20px 24px;margin-bottom:18px;
        box-shadow:0 8px 32px rgba(15,118,110,.28);}
.pl-hdr::before{content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse at 85% -5%,rgba(255,255,255,.15) 0%,transparent 50%),
               radial-gradient(ellipse at 0% 115%,rgba(6,182,212,.18) 0%,transparent 50%);
    pointer-events:none;}
.pl-hdr-inner{position:relative;display:flex;align-items:center;
              justify-content:space-between;flex-wrap:wrap;gap:12px;}
.pl-hdr-left{display:flex;align-items:center;gap:14px;}
.pl-hdr-icon{width:48px;height:48px;border-radius:12px;flex-shrink:0;
             background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
             display:flex;align-items:center;justify-content:center;
             font-size:22px;color:#fff;}
.pl-hdr-title{color:#fff;font-size:17px;font-weight:700;margin:0;line-height:1.3;}
.pl-hdr-sub{color:rgba(255,255,255,.75);font-size:12.5px;margin:2px 0 0;}
.pl-hdr-right{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
.pl-pill{display:inline-flex;align-items:center;gap:6px;
         background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);
         border-radius:20px;padding:5px 13px;color:#fff;font-size:12px;}

/* ─── STATS ─── */
.pl-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));
          gap:12px;margin-bottom:18px;}
.pl-stat{border-radius:10px;padding:14px 16px;background:#fff;
         border:1px solid var(--pl-border);
         box-shadow:0 1px 6px rgba(0,0,0,.05);
         transition:transform .15s,box-shadow .15s;position:relative;overflow:hidden;}
.pl-stat:hover{transform:translateY(-2px);box-shadow:0 4px 16px rgba(0,0,0,.08);}
.pl-stat::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:3px 3px 0 0;}
.pl-stat.teal::before{background:linear-gradient(90deg,#0f766e,#14b8a6);}
.pl-stat.green::before{background:linear-gradient(90deg,#15803d,#22c55e);}
.pl-stat.red::before{background:linear-gradient(90deg,#991b1b,#ef4444);}
.pl-stat.blue::before{background:linear-gradient(90deg,#1d4ed8,#60a5fa);}
.pl-stat.amber::before{background:linear-gradient(90deg,#b45309,#fbbf24);}
.pl-stat-val{font-size:22px;font-weight:800;line-height:1;color:var(--pl-text);font-variant-numeric:tabular-nums;}
.pl-stat-lbl{font-size:10.5px;color:var(--pl-muted);margin-top:5px;text-transform:uppercase;letter-spacing:.6px;font-weight:600;}
.pl-stat-icon{position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:28px;opacity:.07;}

/* ─── TABLE ─── */
.pl-tbl-wrap{border-radius:10px;overflow:hidden;border:1px solid var(--pl-border);box-shadow:0 2px 12px rgba(0,0,0,.06);}
.pl-tbl{width:100%;border-collapse:collapse;font-size:12.5px;}
.pl-tbl thead{background:#0f172a;}
.pl-tbl thead th{color:rgba(255,255,255,.80);font-weight:600;font-size:10.5px;
                 text-transform:uppercase;letter-spacing:.7px;padding:11px 12px;border:none;white-space:nowrap;}
.pl-tbl tbody tr{border-bottom:1px solid #f1f5f9;transition:background .12s,border-left-color .12s;}
.pl-tbl tbody tr:nth-child(odd){background:#fff;}
.pl-tbl tbody tr:nth-child(even){background:#f8fafc;}
.pl-tbl tbody tr:last-child{border-bottom:none;}
.pl-tbl tbody tr:hover{background:var(--pl-accent-light);border-left:3px solid var(--pl-accent2);}
.pl-tbl tbody tr:not(:hover){border-left:3px solid transparent;}
.pl-tbl td{padding:9px 12px;vertical-align:middle;}
.pl-tbl tfoot{background:#f0fdfa;border-top:2px solid var(--pl-accent-border);}
.pl-tbl tfoot th{padding:10px 12px;border:none;font-size:12.5px;}

/* cells */
.pc-date .pc-date-main{color:var(--pl-text);font-weight:600;font-size:12px;white-space:nowrap;}
.pc-date .pc-date-created{color:var(--pl-muted);font-size:10px;margin-top:2px;white-space:nowrap;}
.pc-ref{font-family:'SFMono-Regular',Consolas,monospace;font-size:11.5px;}
.pc-ref-main{font-weight:700;font-size:12px;}
.pc-ref-sub{font-size:10px;color:var(--pl-muted);margin-top:2px;}
.pc-ref-in{color:#1d4ed8;}
.pc-ref-out{color:#b91c1c;}
.pc-party-name{color:var(--pl-text);font-weight:600;font-size:12.5px;}
.pc-party-contact{color:var(--pl-muted);font-size:10.5px;margin-top:2px;}
.pc-party-code{font-family:monospace;font-size:10px;color:#94a3b8;margin-top:1px;}
.pc-price{text-align:right;font-family:'SFMono-Regular',Consolas,monospace;
          font-size:12px;color:#374151;font-variant-numeric:tabular-nums;}
.pc-in{text-align:center;font-weight:800;font-size:14px;color:var(--pl-green);font-variant-numeric:tabular-nums;}
.pc-out{text-align:center;font-weight:800;font-size:14px;color:var(--pl-red);font-variant-numeric:tabular-nums;}
.pc-balance{text-align:center;font-family:'SFMono-Regular',Consolas,monospace;font-weight:700;font-size:13px;font-variant-numeric:tabular-nums;}
.pc-balance-pos{color:var(--pl-green);}
.pc-balance-neg{color:var(--pl-red);}
.pc-balance-zero{color:var(--pl-muted);}
.pl-badge{display:inline-flex;align-items:center;gap:4px;
          font-size:10px;font-weight:700;padding:3px 9px;
          border-radius:20px;white-space:nowrap;letter-spacing:.3px;}
.pl-badge-in{background:#dbeafe;color:#1d4ed8;}
.pl-badge-out{background:#fee2e2;color:#991b1b;}
.pl-badge-manual{background:#f0fdf4;color:#166534;}
.pl-badge-warranty{background:#fdf4ff;color:#7e22ce;}
.pl-badge-replace{background:#fff7ed;color:#c2410c;}
.pl-badge-return{background:#ecfdf5;color:#065f46;}
.pl-badge-default{background:#f1f5f9;color:#475569;}
.pc-foot-lbl{text-align:right;color:var(--pl-muted);font-size:10.5px;text-transform:uppercase;letter-spacing:.5px;}
.pc-foot-in{text-align:center;font-weight:800;color:var(--pl-green);font-size:14px;}
.pc-foot-out{text-align:center;font-weight:800;color:var(--pl-red);font-size:14px;}
.pc-foot-bal{text-align:center;font-weight:800;font-size:15px;}
.pc-foot-bal-pos{color:var(--pl-green);}
.pc-foot-bal-neg{color:var(--pl-red);}
.pl-empty{border-radius:12px;border:2px dashed var(--pl-border);
          padding:52px 24px;text-align:center;margin-top:4px;}
.pl-empty-icon{width:64px;height:64px;border-radius:16px;
               background:#f1f5f9;border:1px solid var(--pl-border);
               display:inline-flex;align-items:center;justify-content:center;
               font-size:26px;color:#94a3b8;margin-bottom:14px;}
.pl-empty-title{font-size:15px;font-weight:700;color:var(--pl-text);margin:0 0 6px;}
.pl-empty-sub{font-size:13px;color:var(--pl-muted);margin:0 0 16px;}
.pl-empty-params{display:inline-flex;flex-wrap:wrap;gap:8px;justify-content:center;}
.pl-empty-param{background:#f8fafc;border:1px solid var(--pl-border);
                border-radius:6px;padding:4px 12px;font-size:12px;
                color:var(--pl-muted);font-family:'SFMono-Regular',Consolas,monospace;}

/* party icon chip */
.pc-type-chip{display:inline-flex;align-items:center;justify-content:center;
              width:20px;height:20px;border-radius:50%;font-size:9px;margin-right:5px;flex-shrink:0;}
.pc-type-chip-s{background:#dbeafe;color:#1d4ed8;}
.pc-type-chip-c{background:#fce7f3;color:#be185d;}

/* ─── PRODUCT META STRIP ─── */
.pl-meta{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:18px;}
.pl-meta-item{background:#fff;border:1px solid var(--pl-border);border-radius:8px;
              padding:8px 14px;display:flex;flex-direction:column;gap:2px;min-width:110px;
              box-shadow:0 1px 4px rgba(0,0,0,.04);}
.pl-meta-lbl{font-size:9.5px;color:var(--pl-muted);text-transform:uppercase;
             letter-spacing:.6px;font-weight:600;}
.pl-meta-val{font-size:13px;font-weight:700;color:var(--pl-text);}
.pl-meta-pp{color:#1d4ed8;}
.pl-meta-sp{color:var(--pl-green);}
@media print{
    .pl-hdr,.pl-tbl thead{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
    .pl-stat::before{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
}
</style>

<div class="pl-wrap">

<!-- Header -->
<div class="pl-hdr">
  <div class="pl-hdr-inner">
    <div class="pl-hdr-left">
      <div class="pl-hdr-icon"><i class="fa fa-book"></i></div>
      <div>
        <p class="pl-hdr-title"><?= CHtml::encode($model_name) ?></p>
        <p class="pl-hdr-sub">Product Stock Ledger</p>
      </div>
    </div>
    <div class="pl-hdr-right">
      <?php if ($code): ?><div class="pl-pill"><i class="fa fa-tag"></i><?= CHtml::encode($code) ?></div><?php endif; ?>
      <div class="pl-pill">
        <i class="fa fa-calendar"></i>
        <?php if ($dateFrom && $dateTo): ?>
          <?= date('d M Y', strtotime($dateFrom)) ?> – <?= date('d M Y', strtotime($dateTo)) ?>
        <?php else: ?>
          All Time
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php if (empty($data)): ?>
<!-- Empty state -->
<div class="pl-empty">
  <div class="pl-empty-icon"><i class="fa fa-search"></i></div>
  <p class="pl-empty-title">No Records Found</p>
  <p class="pl-empty-sub">No stock ledger entries match your search criteria.</p>
  <div class="pl-empty-params">
    <span class="pl-empty-param"><i class="fa fa-cube" style="margin-right:5px;"></i>Product ID: <?= (int)$model_id ?></span>
    <?php if ($dateFrom): ?><span class="pl-empty-param"><i class="fa fa-calendar" style="margin-right:5px;"></i>From: <?= CHtml::encode($dateFrom) ?></span><?php endif; ?>
    <?php if ($dateTo): ?><span class="pl-empty-param"><i class="fa fa-calendar" style="margin-right:5px;"></i>To: <?= CHtml::encode($dateTo) ?></span><?php endif; ?>
  </div>
</div>
<?php else: ?>
<!-- Product meta -->
<div class="pl-meta">
  <?php if ($manufacturer): ?>
  <div class="pl-meta-item">
    <span class="pl-meta-lbl"><i class="fa fa-building-o"></i> Company</span>
    <span class="pl-meta-val"><?= CHtml::encode($manufacturer->name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($category): ?>
  <div class="pl-meta-item">
    <span class="pl-meta-lbl"><i class="fa fa-folder-o"></i> Category</span>
    <span class="pl-meta-val"><?= CHtml::encode($category->item_name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($subCategory): ?>
  <div class="pl-meta-item">
    <span class="pl-meta-lbl"><i class="fa fa-tag"></i> Sub-Category</span>
    <span class="pl-meta-val"><?= CHtml::encode($subCategory->brand_name) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($product && $product->purchase_price > 0): ?>
  <div class="pl-meta-item">
    <span class="pl-meta-lbl"><i class="fa fa-shopping-cart"></i> Purchase Price</span>
    <span class="pl-meta-val pl-meta-pp"><?= number_format($product->purchase_price, 2) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($product && $product->sell_price > 0): ?>
  <div class="pl-meta-item">
    <span class="pl-meta-lbl"><i class="fa fa-money"></i> Sale Price</span>
    <span class="pl-meta-val pl-meta-sp"><?= number_format($product->sell_price, 2) ?></span>
  </div>
  <?php endif; ?>
</div>

<!-- Stats -->
<div class="pl-stats">
  <div class="pl-stat teal">
    <div class="pl-stat-val"><?= count($data) ?></div>
    <div class="pl-stat-lbl">Transactions</div>
    <i class="fa fa-list pl-stat-icon"></i>
  </div>
  <div class="pl-stat green">
    <div class="pl-stat-val"><?= number_format($totalIn) ?></div>
    <div class="pl-stat-lbl">Total Stock In</div>
    <i class="fa fa-arrow-down pl-stat-icon"></i>
  </div>
  <div class="pl-stat red">
    <div class="pl-stat-val"><?= number_format($totalOut) ?></div>
    <div class="pl-stat-lbl">Total Stock Out</div>
    <i class="fa fa-arrow-up pl-stat-icon"></i>
  </div>
  <div class="pl-stat blue">
    <div class="pl-stat-val" style="color:<?= $balance >= 0 ? 'var(--pl-green)' : 'var(--pl-red)' ?>"><?= number_format($balance) ?></div>
    <div class="pl-stat-lbl">Balance</div>
    <i class="fa fa-balance-scale pl-stat-icon"></i>
  </div>
  <div class="pl-stat green">
    <div class="pl-stat-val" style="font-size:16px;"><?= number_format($totalInValue, 0) ?></div>
    <div class="pl-stat-lbl">In Value</div>
    <i class="fa fa-money pl-stat-icon"></i>
  </div>
  <div class="pl-stat amber">
    <div class="pl-stat-val" style="font-size:16px;"><?= number_format($totalOutValue, 0) ?></div>
    <div class="pl-stat-lbl">Out Value</div>
    <i class="fa fa-money pl-stat-icon"></i>
  </div>
</div>

<!-- Table -->
<div class="pl-tbl-wrap">
<table class="pl-tbl">
  <thead>
    <tr>
      <th>Date</th>
      <th>Reference</th>
      <th>Party</th>
      <th>Type</th>
      <th style="text-align:right;">P.Price</th>
      <th style="text-align:right;">S.Price</th>
      <th style="text-align:center;">Stock In</th>
      <th style="text-align:center;">Stock Out</th>
      <th style="text-align:center;">Balance</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($data as $d):
      $runBalance   = isset($runningMap[$d->id]) ? $runningMap[$d->id] : 0;
      $balClass     = $runBalance > 0 ? 'pc-balance-pos' : ($runBalance < 0 ? 'pc-balance-neg' : 'pc-balance-zero');

      /* reference */
      $refMain = '—'; $refSub = '';
      if (!empty($d->po_no))       { $refMain = $d->po_no;       $refSub = 'Purchase Order'; }
      elseif (!empty($d->invoice_no)) { $refMain = $d->invoice_no; $refSub = 'Sales Order'; }
      elseif ($d->master_id > 0)   { $refMain = '#'.$d->master_id; }
      $refClass = ($d->stock_in > 0) ? 'pc-ref-in' : 'pc-ref-out';

      /* type badge */
      $statusLabel = strip_tags(Inventory::model()->getStatus($d->stock_status));
      switch ($d->stock_status) {
          case Inventory::PURCHASE_RECEIVE:    $badgeClass='pl-badge-in';      break;
          case Inventory::SALES_DELIVERY:      $badgeClass='pl-badge-out';     break;
          case Inventory::MANUAL_ENTRY:        $badgeClass='pl-badge-manual';  break;
          case Inventory::WARRANTY_RETURN:     $badgeClass='pl-badge-warranty';break;
          case Inventory::PRODUCT_REPLACEMENT: $badgeClass='pl-badge-replace'; break;
          case Inventory::CASH_SALE_RETURN:    $badgeClass='pl-badge-return';  break;
          default:                             $badgeClass='pl-badge-default';
      }
  ?>
    <tr>
      <td><div class="pc-date">
        <div class="pc-date-main"><?= date('d M Y', strtotime($d->date)) ?></div>
        <?php if ($d->create_time): ?><div class="pc-date-created"><?= date('d/m/y h:i A', strtotime($d->create_time)) ?></div><?php endif; ?>
      </div></td>
      <td><div class="pc-ref">
        <div class="pc-ref-main <?= $refClass ?>"><?= CHtml::encode($refMain) ?></div>
        <?php if ($refSub): ?><div class="pc-ref-sub"><?= $refSub ?></div><?php endif; ?>
      </div></td>
      <td>
        <?php if ($d->supplier_id > 0): ?>
          <div style="display:flex;align-items:flex-start;">
            <span class="pc-type-chip pc-type-chip-s"><i class="fa fa-truck"></i></span>
            <div>
              <div class="pc-party-name supplier_ledger" data-id="<?= $d->supplier_id ?>" style="cursor:pointer;">
                <?= CHtml::encode($d->supplier_name) ?>
              </div>
              <?php if ($d->supplier_contact_no): ?><div class="pc-party-contact"><i class="fa fa-phone" style="font-size:9px;margin-right:3px;"></i><?= CHtml::encode($d->supplier_contact_no) ?></div><?php endif; ?>
            </div>
          </div>
        <?php elseif ($d->customer_id > 0): ?>
          <div style="display:flex;align-items:flex-start;">
            <span class="pc-type-chip pc-type-chip-c"><i class="fa fa-user"></i></span>
            <div>
              <div class="pc-party-name customer_ledger" data-id="<?= $d->customer_id ?>" style="cursor:pointer;">
                <?= CHtml::encode($d->customer_name) ?>
              </div>
              <?php if ($d->customer_contact_no): ?><div class="pc-party-contact"><i class="fa fa-phone" style="font-size:9px;margin-right:3px;"></i><?= CHtml::encode($d->customer_contact_no) ?></div><?php endif; ?>
            </div>
          </div>
        <?php else: ?>
          <span style="color:#cbd5e1;font-style:italic;font-size:12px;">—</span>
        <?php endif; ?>
      </td>
      <td><span class="pl-badge <?= $badgeClass ?>"><?= CHtml::encode($statusLabel ?: 'Entry') ?></span></td>
      <td class="pc-price"><?= $d->purchase_price > 0 ? number_format($d->purchase_price, 2) : '—' ?></td>
      <td class="pc-price"><?= $d->sell_price > 0 ? number_format($d->sell_price, 2) : '—' ?></td>
      <td class="pc-in"><?= $d->stock_in > 0 ? number_format($d->stock_in) : '' ?></td>
      <td class="pc-out"><?= $d->stock_out > 0 ? number_format($d->stock_out) : '' ?></td>
      <td class="pc-balance <?= $balClass ?>"><?= number_format($runBalance) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
  <?php if (!empty($data)): ?>
  <tfoot>
    <tr>
      <th colspan="6" class="pc-foot-lbl">Totals</th>
      <th class="pc-foot-in"><?= number_format($totalIn) ?></th>
      <th class="pc-foot-out"><?= number_format($totalOut) ?></th>
      <th class="pc-foot-bal <?= $balance >= 0 ? 'pc-foot-bal-pos' : 'pc-foot-bal-neg' ?>"><?= number_format($balance) ?></th>
    </tr>
  </tfoot>
  <?php endif; ?>
</table>
</div>
<?php endif; ?>
</div>
