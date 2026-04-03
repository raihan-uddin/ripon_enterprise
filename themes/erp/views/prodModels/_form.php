<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Inventory', 'url' => array('')),
        array('name' => 'Config',    'url' => array('admin')),
        array('name' => 'Product Setup', 'url' => array('admin')),
        array('name' => $model->isNewRecord ? 'Add Product' : 'Update Product'),
    ),
));
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'                    => 'prod-models-form',
    'action'                => $this->createUrl('prodModels/create'),
    'enableAjaxValidation'  => false,
    'enableClientValidation'=> true,
    'clientOptions'         => array('validateOnSubmit' => true),
    'stateful'              => true,
    'htmlOptions'           => array('enctype' => 'multipart/form-data'),
));
?>

<!-- bs-custom-file-input removed: BS5 native file input used -->

<style>
/* ══════════════════════════════════════════
   Product Form — Full Interactive Design
══════════════════════════════════════════ */

/* Card shell */
.pf-card {
    border:none; border-radius:16px; overflow:hidden;
    box-shadow:0 4px 6px rgba(0,0,0,.04), 0 12px 36px rgba(0,0,0,.1);
}

/* ── Header ── */
.pf-card > .card-header {
    background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);
    border:none; padding:22px 28px 20px; position:relative; overflow:hidden;
}
/* dot-grid overlay */
.pf-card > .card-header::before {
    content:''; position:absolute; inset:0; pointer-events:none;
    background-image:radial-gradient(rgba(255,255,255,.18) 1.2px, transparent 1.2px);
    background-size:22px 22px;
}
/* decorative circle top-right */
.pf-card > .card-header::after {
    content:''; position:absolute; top:-50px; right:-50px;
    width:160px; height:160px; border-radius:50%;
    background:rgba(255,255,255,.07); pointer-events:none;
}
.pf-hd-top { display:flex; align-items:flex-start; justify-content:space-between; position:relative; z-index:1 }
.pf-hd-title {
    font-size:17px; font-weight:800; color:#fff; letter-spacing:-.2px;
    display:flex; align-items:center; gap:9px;
}
.pf-hd-title-icon {
    width:34px; height:34px; border-radius:9px;
    background:rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center;
    font-size:14px; color:#fff; flex-shrink:0;
}
.pf-hd-sub { font-size:12px; color:rgba(255,255,255,.65); margin-top:3px; font-weight:400 }
.card-tools .btn-tool { color:rgba(255,255,255,.6); transition:color .15s }
.card-tools .btn-tool:hover { color:#fff }

/* Progress chips */
.pf-hd-chips {
    display:flex; gap:8px; flex-wrap:wrap; margin-top:14px; position:relative; z-index:1;
}
.pf-chip {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 10px; border-radius:99px; font-size:11px; font-weight:600;
    background:rgba(255,255,255,.15); color:rgba(255,255,255,.85);
    border:1px solid rgba(255,255,255,.2);
    transition:background .2s;
}
.pf-chip.done { background:rgba(255,255,255,.28); color:#fff }
.pf-chip i { font-size:10px }

/* Progress bar */
.pf-prog {
    display:flex; align-items:center; gap:10px;
    margin-top:10px; position:relative; z-index:1;
}
.pf-prog-bg {
    flex:1; height:4px; border-radius:99px;
    background:rgba(255,255,255,.2); overflow:hidden;
}
.pf-prog-fill {
    height:100%; border-radius:99px; background:#fff;
    transition:width .4s cubic-bezier(.4,0,.2,1); width:0%;
}
.pf-prog-txt { font-size:11px; color:rgba(255,255,255,.75); font-weight:600; white-space:nowrap }

/* ── Card body ── */
.pf-card > .card-body { padding:0; background:#fff }

/* ── Section ── */
.pf-section { padding:24px 28px; border-bottom:1px solid #f1f5f9; transition:background .2s }
.pf-section:last-child { border-bottom:none }
.pf-section:hover { background:#fafbff }

/* Section header row */
.pf-sec-hd {
    display:flex; align-items:center; gap:12px; margin-bottom:18px;
}
.pf-step-badge {
    width:30px; height:30px; border-radius:50%; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    background:#eef2ff; color:#6366f1;
    font-size:12px; font-weight:800;
    border:2px solid #c7d2fe;
    transition:all .3s cubic-bezier(.34,1.56,.64,1);
}
.pf-section.is-complete .pf-step-badge {
    background:#6366f1; color:#fff; border-color:#6366f1;
    box-shadow:0 0 0 4px rgba(99,102,241,.18);
}
.pf-sec-info { flex:1 }
.pf-sec-title { font-size:13.5px; font-weight:700; color:#1e293b; line-height:1.2 }
.pf-sec-sub   { font-size:11px; color:#94a3b8; margin-top:2px }

/* Section content box */
.pf-sec-body {
    background:#f8faff; border:1px solid #eef2ff;
    border-radius:12px; padding:18px 16px;
}

/* ── Floating-label text inputs ── */
.pf-fl {
    position:relative; margin-bottom:0;
}
.pf-fl-input {
    width:100%; border:1.5px solid #e2e8f0; border-radius:8px;
    padding:18px 12px 6px 38px; font-size:13.5px; color:#1e293b;
    outline:none; background:#fff; line-height:1.4;
    transition:border-color .18s, box-shadow .18s, transform .15s;
    -webkit-appearance:none;
}
.pf-fl-input:focus {
    border-color:#6366f1;
    box-shadow:0 0 0 3.5px rgba(99,102,241,.12);
    transform:translateY(-1px);
}
.pf-fl-input:hover:not(:focus) { border-color:#94a3b8 }
.pf-fl-label {
    position:absolute; left:38px; top:12px;
    font-size:13px; color:#94a3b8; font-weight:500;
    pointer-events:none;
    transition:all .18s cubic-bezier(.4,0,.2,1);
}
.pf-fl-input:focus     + .pf-fl-label,
.pf-fl-input:not(:placeholder-shown) + .pf-fl-label {
    top:5px; left:38px;
    font-size:9.5px; font-weight:700; color:#6366f1;
    letter-spacing:.5px; text-transform:uppercase;
}
.pf-fl-icon {
    position:absolute; left:12px; top:50%; transform:translateY(-50%);
    color:#cbd5e1; font-size:13px; pointer-events:none;
    transition:color .18s;
}
.pf-fl:focus-within .pf-fl-icon { color:#6366f1 }
.pf-fl-tick {
    position:absolute; right:10px; top:50%; transform:translateY(-50%);
    font-size:12px; pointer-events:none; opacity:0; transition:opacity .2s;
}
.pf-field.is-valid   .pf-fl-tick { opacity:1; color:#22c55e }
.pf-field.is-invalid .pf-fl-input { border-color:#ef4444 }

/* ── Styled selects (label above) ── */
.pf-sel-wrap { position:relative }
.pf-sel-icon {
    position:absolute; left:12px; top:50%; transform:translateY(-50%);
    color:#cbd5e1; font-size:12px; pointer-events:none; transition:color .18s;
}
.pf-sel-wrap:focus-within .pf-sel-icon { color:#6366f1 }
.pf-select {
    width:100%; border:1.5px solid #e2e8f0; border-radius:8px;
    padding:10px 28px 10px 34px; font-size:13px; color:#1e293b; background:#fff;
    outline:none; -webkit-appearance:none; cursor:pointer;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2394a3b8'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 10px center;
    transition:border-color .18s, box-shadow .18s, transform .15s;
}
.pf-select:focus {
    border-color:#6366f1; box-shadow:0 0 0 3.5px rgba(99,102,241,.12);
    transform:translateY(-1px);
}
.pf-select:hover:not(:focus) { border-color:#94a3b8 }
.pf-field.is-valid .pf-select { border-color:#22c55e }

/* ── Field label (for select fields) ── */
.pf-label {
    display:flex; align-items:center; gap:5px;
    font-size:11.5px; font-weight:700; color:#475569;
    margin-bottom:6px; text-transform:uppercase; letter-spacing:.4px;
    transition:color .15s;
}
.pf-label .req { color:#ef4444 }
.pf-field:focus-within .pf-label { color:#6366f1 }

/* ── Input + Add-new button row ── */
.pf-addon { display:flex; gap:6px }
.pf-addon .pf-sel-wrap { flex:1 }
.pf-add-btn {
    flex-shrink:0; height:40px; padding:0 12px;
    display:inline-flex; align-items:center; gap:4px;
    border-radius:8px; font-size:12px; font-weight:700;
    border:1.5px solid #6366f1; color:#6366f1; background:#fff;
    cursor:pointer; white-space:nowrap;
    transition:all .15s;
}
.pf-add-btn:hover {
    background:#6366f1; color:#fff;
    box-shadow:0 4px 12px rgba(99,102,241,.35);
    transform:translateY(-1px);
}
.pf-add-btn:active { transform:translateY(0) }

/* ── Currency prefix ── */
.pf-money { display:flex }
.pf-money-sym {
    display:inline-flex; align-items:center; justify-content:center;
    padding:0 12px; border:1.5px solid #e2e8f0; border-right:none;
    border-radius:8px 0 0 8px; background:#f1f5f9;
    font-size:13px; font-weight:800; color:#6366f1;
    transition:border-color .18s, background .18s;
}
.pf-money:focus-within .pf-money-sym {
    border-color:#6366f1; background:#eef2ff;
}
.pf-money .pf-fl { flex:1 }
.pf-money .pf-fl-input { border-radius:0 8px 8px 0 }

/* ── Toggle switch ── */
.pf-tog-row {
    display:flex; align-items:center; gap:12px;
    background:#fff; border:1.5px solid #e2e8f0; border-radius:8px;
    padding:9px 14px; cursor:pointer;
    transition:border-color .18s, box-shadow .18s;
    min-height:40px;
}
.pf-tog-row:hover { border-color:#94a3b8 }
.pf-tog-row.is-on { border-color:#c7d2fe; background:#fafbff }
.pf-toggle { position:relative; width:40px; height:22px; flex-shrink:0; cursor:pointer }
.pf-toggle input { opacity:0; width:0; height:0; position:absolute }
.pf-tog-track {
    position:absolute; inset:0; border-radius:99px;
    background:#e2e8f0; transition:background .2s;
}
.pf-toggle input:checked ~ .pf-tog-track { background:#6366f1 }
.pf-tog-thumb {
    position:absolute; top:3px; left:3px;
    width:16px; height:16px; border-radius:50%;
    background:#fff; box-shadow:0 1px 4px rgba(0,0,0,.2);
    transition:left .2s cubic-bezier(.4,0,.2,1);
}
.pf-toggle input:checked ~ .pf-tog-thumb { left:21px }
.pf-tog-info { flex:1 }
.pf-tog-title { font-size:13px; font-weight:600; color:#374151; line-height:1.2 }
.pf-tog-desc  { font-size:11px; color:#94a3b8; margin-top:1px }
.pf-tog-badge {
    font-size:11px; font-weight:700; padding:3px 9px; border-radius:99px;
    transition:all .2s; flex-shrink:0;
}
.pf-tog-badge.on  { background:#dcfce7; color:#15803d }
.pf-tog-badge.off { background:#f1f5f9; color:#94a3b8 }

/* ── Pricing card ── */
.pf-price-card {
    background:linear-gradient(135deg,#f0fdf4 0%,#eff6ff 100%);
    border:1px solid #e0f2fe; border-radius:10px; padding:14px 16px;
    margin-bottom:0;
}
.pf-price-row { display:flex; gap:14px }
.pf-price-row > div { flex:1 }
.pf-price-title {
    font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.6px;
    color:#94a3b8; margin-bottom:8px; display:flex; align-items:center; gap:5px;
}
.pf-price-title i { color:#6366f1 }

/* ── Char counter ── */
.pf-char { display:flex; justify-content:flex-end; font-size:11px; color:#94a3b8; margin-top:4px }
.pf-char.warn { color:#f59e0b }
.pf-char.full  { color:#ef4444 }

/* ── Error ── */
.pf-error { font-size:11.5px; color:#ef4444; margin-top:5px; display:block }

/* ── Field spacing ── */
.pf-field { margin-bottom:14px }
.pf-field:last-child { margin-bottom:0 }

/* ── Shake animation for invalid on submit ── */
@keyframes pfShake {
    0%,100%{ transform:translateX(0) }
    20%    { transform:translateX(-5px) }
    40%    { transform:translateX(5px) }
    60%    { transform:translateX(-4px) }
    80%    { transform:translateX(4px) }
}
.pf-shake { animation:pfShake .4s ease }

/* ── Footer ── */
.pf-card > .card-footer {
    background:#f8fafc; border-top:1px solid #f1f5f9;
    padding:16px 28px; display:flex; align-items:center; gap:10px;
}
.pf-req-note { margin-left:auto; font-size:11.5px; color:#94a3b8 }
.pf-req-note span { color:#ef4444; font-weight:700 }

/* Submit */
.pf-submit {
    position:relative; overflow:hidden;
    display:inline-flex; align-items:center; gap:8px;
    padding:11px 26px; border-radius:9px; font-size:14px; font-weight:700;
    background:linear-gradient(135deg,#6366f1,#7c3aed); color:#fff; border:none;
    cursor:pointer; letter-spacing:-.1px;
    box-shadow:0 4px 14px rgba(99,102,241,.4);
    transition:box-shadow .18s, transform .15s;
}
.pf-submit:hover {
    box-shadow:0 6px 20px rgba(99,102,241,.5);
    transform:translateY(-2px);
}
.pf-submit:active { transform:translateY(0) }
.pf-ripple {
    position:absolute; border-radius:50%;
    background:rgba(255,255,255,.38); transform:scale(0);
    animation:pfRipple .6s linear; pointer-events:none;
}
@keyframes pfRipple { to { transform:scale(4); opacity:0 } }

/* Cancel */
.pf-cancel {
    display:inline-flex; align-items:center; gap:6px;
    padding:11px 20px; border-radius:9px; font-size:13.5px; font-weight:600;
    background:#fff; color:#64748b; border:1.5px solid #e2e8f0; text-decoration:none;
    transition:all .15s;
}
.pf-cancel:hover { background:#f8fafc; color:#374151; border-color:#94a3b8; text-decoration:none }

/* Spinner */
#pf-spinner { display:none; align-items:center; gap:7px; color:#6366f1; font-size:13px }

/* ── Image upload drop zone ── */
.pf-img-zone {
    border:2px dashed #c7d2fe; border-radius:12px;
    background:#f8faff; padding:28px 20px;
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    gap:10px; cursor:pointer; transition:border-color .2s, background .2s;
    position:relative; text-align:center;
}
.pf-img-zone:hover, .pf-img-zone.drag-over {
    border-color:#6366f1; background:#eef2ff;
}
.pf-img-zone input[type=file] {
    position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%;
}
.pf-img-zone-icon {
    width:48px; height:48px; border-radius:12px;
    background:#eef2ff; display:flex; align-items:center; justify-content:center;
    font-size:20px; color:#6366f1;
}
.pf-img-zone-text { font-size:13px; font-weight:600; color:#374151 }
.pf-img-zone-sub  { font-size:11px; color:#94a3b8 }
.pf-img-preview-wrap {
    position:relative; display:inline-block;
}
.pf-img-preview {
    width:100%; max-width:220px; border-radius:10px;
    border:2px solid #c7d2fe; object-fit:cover; display:block; max-height:160px;
}
.pf-img-remove {
    position:absolute; top:-8px; right:-8px;
    width:24px; height:24px; border-radius:50%;
    background:#ef4444; color:#fff; border:none; cursor:pointer;
    display:flex; align-items:center; justify-content:center; font-size:11px;
    box-shadow:0 2px 6px rgba(239,68,68,.4); transition:background .15s;
}
.pf-img-remove:hover { background:#dc2626 }
.pf-img-fname { font-size:11px; color:#6366f1; font-weight:600; margin-top:4px; word-break:break-all }
</style>

<div class="card pf-card">

    <!-- ═══ Header ═══ -->
    <div class="card-header">
        <div class="pf-hd-top">
            <div>
                <div class="pf-hd-title">
                    <div class="pf-hd-title-icon">
                        <i class="fas fa-<?php echo $model->isNewRecord ? 'plus' : 'pencil'; ?>"></i>
                    </div>
                    <div>
                        <?php echo $model->isNewRecord ? 'Add New Product' : 'Update Product'; ?>
                        <div class="pf-hd-sub">Fill all required fields to save the product</div>
                    </div>
                </div>
            </div>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="pf-hd-chips">
            <span class="pf-chip" id="chip-id"><i class="fas fa-tag"></i> Identification</span>
            <span class="pf-chip" id="chip-price"><i class="fas fa-dollar"></i> Pricing</span>
            <span class="pf-chip" id="chip-cfg"><i class="fas fa-sliders"></i> Config</span>
            <span class="pf-chip" id="chip-desc"><i class="fas fa-align-left"></i> Description</span>
            <span class="pf-chip" id="chip-img"><i class="fas fa-image"></i> Image</span>
        </div>
        <div class="pf-prog">
            <div class="pf-prog-bg"><div class="pf-prog-fill" id="pfProg"></div></div>
            <span class="pf-prog-txt" id="pfProgTxt">0 / 5 required</span>
        </div>
    </div>

    <div class="card-body">

        <!-- ═══ ① Product Identification ═══ -->
        <div class="pf-section" id="sec-id">
            <div class="pf-sec-hd">
                <div class="pf-step-badge" id="badge-1">1</div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Product Identification</div>
                    <div class="pf-sec-sub">Category, sub-category, name and barcode</div>
                </div>
            </div>
            <div class="pf-sec-body">
                <div class="row">

                    <div class="col-md-6 col-lg-3 pf-field" data-required="1" data-sec="1">
                        <div class="pf-label">
                            <?php echo $model->getAttributeLabel('item_id'); ?> <span class="req">*</span>
                        </div>
                        <div class="pf-addon">
                            <div class="pf-sel-wrap">
                                <i class="fas fa-list pf-sel-icon"></i>
                                <?php echo $form->dropDownList($model, 'item_id',
                                    CHtml::listData(ProdItems::model()->findAll(array('order'=>'item_name ASC')), 'id', 'item_name'),
                                    array(
                                        'prompt' => 'Select category…',
                                        'class'  => 'pf-select',
                                        'ajax'   => array(
                                            'type'     => 'POST',
                                            'dataType' => 'json',
                                            'url'      => CController::createUrl('prodModels/subCatOfThisCat'),
                                            'success'  => 'function(data){ $("#ProdModels_brand_id").html(data.subCatList); }',
                                            'data'     => array('catId' => 'js:jQuery("#ProdModels_item_id").val()'),
                                        ),
                                    )
                                ); ?>
                            </div>
                            <button type="button" class="pf-add-btn"
                                    onclick="addProdItem(); $('#dialogAddProdItem').dialog('open');">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <span class="pf-error"><?php echo $form->error($model, 'item_id'); ?></span>
                    </div>

                    <div class="col-md-6 col-lg-3 pf-field" data-required="1" data-sec="1">
                        <div class="pf-label">
                            <?php echo $model->getAttributeLabel('brand_id'); ?> <span class="req">*</span>
                        </div>
                        <div class="pf-addon">
                            <div class="pf-sel-wrap">
                                <i class="fas fa-bookmark pf-sel-icon"></i>
                                <?php echo $form->dropDownList($model, 'brand_id',
                                    CHtml::listData(ProdBrands::model()->findAll(array('order'=>'brand_name ASC')), 'id', 'brand_name'),
                                    array('prompt' => 'Select sub-category…', 'class' => 'pf-select')
                                ); ?>
                            </div>
                            <button type="button" class="pf-add-btn"
                                    onclick="addProdBrand(); $('#dialogAddProdBrand').dialog('open');">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <span class="pf-error"><?php echo $form->error($model, 'brand_id'); ?></span>
                    </div>

                    <div class="col-md-6 col-lg-3 pf-field" data-required="1" data-sec="1">
                        <div class="pf-label">
                            <?php echo $model->getAttributeLabel('model_name'); ?> <span class="req">*</span>
                        </div>
                        <div class="pf-fl">
                            <i class="fas fa-cube pf-fl-icon"></i>
                            <?php echo $form->textField($model, 'model_name',
                                array('maxlength'=>255, 'class'=>'pf-fl-input', 'placeholder'=>' ')
                            ); ?>
                            <label class="pf-fl-label" for="ProdModels_model_name">Product name…</label>
                            <span class="pf-fl-tick"><i class="fas fa-check-circle"></i></span>
                        </div>
                        <span class="pf-error"><?php echo $form->error($model, 'model_name'); ?></span>
                    </div>

                    <div class="col-md-6 col-lg-3 pf-field" data-required="1" data-sec="1">
                        <div class="pf-label">
                            <?php echo $model->getAttributeLabel('code'); ?> <span class="req">*</span>
                        </div>
                        <div class="pf-fl">
                            <i class="fas fa-barcode pf-fl-icon"></i>
                            <?php echo $form->textField($model, 'code',
                                array('maxlength'=>255, 'class'=>'pf-fl-input', 'placeholder'=>' ')
                            ); ?>
                            <label class="pf-fl-label" for="ProdModels_code">Barcode / SKU…</label>
                            <span class="pf-fl-tick"><i class="fas fa-check-circle"></i></span>
                        </div>
                        <span class="pf-error"><?php echo $form->error($model, 'code'); ?></span>
                    </div>

                </div>
            </div>
        </div>

        <!-- ═══ ② Pricing & Inventory ═══ -->
        <div class="pf-section" id="sec-price">
            <div class="pf-sec-hd">
                <div class="pf-step-badge" id="badge-2">2</div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Pricing &amp; Inventory</div>
                    <div class="pf-sec-sub">Set prices, unit and stock alert threshold</div>
                </div>
            </div>
            <div class="pf-sec-body">
                <div class="row">

                    <!-- Sell price + Purchase price in a mini pricing card -->
                    <div class="col-md-8 pf-field">
                        <div class="pf-price-card">
                            <div class="pf-price-title"><i class="fas fa-dollar"></i> Pricing</div>
                            <div class="pf-price-row">
                                <div>
                                    <div class="pf-label" style="text-transform:none;letter-spacing:0;font-size:12px;margin-bottom:4px">
                                        <?php echo $model->getAttributeLabel('sell_price'); ?>
                                    </div>
                                    <div class="pf-money">
                                        <span class="pf-money-sym">৳</span>
                                        <div class="pf-fl">
                                            <?php echo $form->textField($model, 'sell_price',
                                                array('maxlength'=>255, 'class'=>'pf-fl-input', 'placeholder'=>' ',
                                                      'style'=>'border-radius:0 8px 8px 0')
                                            ); ?>
                                            <label class="pf-fl-label" for="ProdModels_sell_price">0.00</label>
                                        </div>
                                    </div>
                                    <span class="pf-error"><?php echo $form->error($model, 'sell_price'); ?></span>
                                </div>
                                <div>
                                    <div class="pf-label" style="text-transform:none;letter-spacing:0;font-size:12px;margin-bottom:4px">
                                        <?php echo $model->getAttributeLabel('purchase_price'); ?>
                                    </div>
                                    <div class="pf-money">
                                        <span class="pf-money-sym">৳</span>
                                        <div class="pf-fl">
                                            <?php echo $form->textField($model, 'purchase_price',
                                                array('maxlength'=>255, 'class'=>'pf-fl-input', 'placeholder'=>' ',
                                                      'style'=>'border-radius:0 8px 8px 0')
                                            ); ?>
                                            <label class="pf-fl-label" for="ProdModels_purchase_price">0.00</label>
                                        </div>
                                    </div>
                                    <span class="pf-error"><?php echo $form->error($model, 'purchase_price'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4"></div>

                    <div class="col-md-4 pf-field" data-required="1" data-sec="2">
                        <div class="pf-label">
                            <?php echo $model->getAttributeLabel('unit_id'); ?> <span class="req">*</span>
                        </div>
                        <div class="pf-addon">
                            <div class="pf-sel-wrap">
                                <i class="fas fa-balance-scale pf-sel-icon"></i>
                                <?php echo $form->dropDownList($model, 'unit_id',
                                    CHtml::listData(Units::model()->findAll(array('order'=>'label ASC')), 'id', 'label'),
                                    array('prompt' => 'Select unit…', 'class' => 'pf-select')
                                ); ?>
                            </div>
                            <button type="button" class="pf-add-btn"
                                    onclick="addUnit(); $('#dialogAddUnit').dialog('open');">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <span class="pf-error"><?php echo $form->error($model, 'unit_id'); ?></span>
                    </div>

                    <div class="col-md-4 pf-field" data-sec="2">
                        <div class="pf-label"><?php echo $model->getAttributeLabel('min_order_qty'); ?></div>
                        <div class="pf-fl">
                            <i class="fas fa-bell pf-fl-icon"></i>
                            <?php echo $form->textField($model, 'min_order_qty',
                                array('maxlength'=>255, 'class'=>'pf-fl-input', 'placeholder'=>' ')
                            ); ?>
                            <label class="pf-fl-label" for="ProdModels_min_order_qty">Alert at qty…</label>
                        </div>
                        <span class="pf-error"><?php echo $form->error($model, 'min_order_qty'); ?></span>
                    </div>

                </div>
            </div>
        </div>

        <!-- ═══ ③ Configuration ═══ -->
        <div class="pf-section" id="sec-cfg">
            <div class="pf-sec-hd">
                <div class="pf-step-badge" id="badge-3">3</div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Configuration</div>
                    <div class="pf-sec-sub">Manufacturer, stock tracking and product status</div>
                </div>
            </div>
            <div class="pf-sec-body">
                <div class="row">

                    <div class="col-md-5 pf-field" data-sec="3">
                        <div class="pf-label"><?php echo $model->getAttributeLabel('manufacturer_id'); ?></div>
                        <div class="pf-sel-wrap">
                            <i class="fas fa-industry pf-sel-icon"></i>
                            <?php echo $form->dropDownList($model, 'manufacturer_id',
                                CHtml::listData(Company::model()->findAll(array('order'=>'name ASC')), 'id', 'name'),
                                array('prompt' => 'Select manufacturer…', 'class' => 'pf-select')
                            ); ?>
                        </div>
                        <span class="pf-error"><?php echo $form->error($model, 'manufacturer_id'); ?></span>
                    </div>

                    <div class="col-md-7"></div>

                    <!-- Stockable toggle -->
                    <div class="col-md-5 pf-field" data-sec="3">
                        <div class="pf-label"><?php echo $model->getAttributeLabel('stockable'); ?></div>
                        <?php echo $form->dropDownList($model, 'stockable',
                            array(1 => 'YES', 0 => 'NO'),
                            array('id' => 'ProdModels_stockable', 'style' => 'display:none')
                        ); ?>
                        <div class="pf-tog-row <?php echo (isset($model->stockable) && $model->stockable == 1) ? 'is-on' : ''; ?>"
                             id="togRow-stockable" onclick="$('#toggle-stockable').trigger('click')">
                            <label class="pf-toggle" onclick="event.stopPropagation()">
                                <input type="checkbox" id="toggle-stockable"
                                       <?php echo (isset($model->stockable) && $model->stockable == 1) ? 'checked' : ''; ?>>
                                <span class="pf-tog-track"></span>
                                <span class="pf-tog-thumb"></span>
                            </label>
                            <div class="pf-tog-info">
                                <div class="pf-tog-title">Track stock levels</div>
                                <div class="pf-tog-desc">Enable inventory tracking for this product</div>
                            </div>
                            <span class="pf-tog-badge <?php echo (isset($model->stockable) && $model->stockable == 1) ? 'on' : 'off'; ?>"
                                  id="badge-stockable">
                                <?php echo (isset($model->stockable) && $model->stockable == 1) ? 'Yes' : 'No'; ?>
                            </span>
                        </div>
                    </div>

                    <!-- Status toggle -->
                    <div class="col-md-5 pf-field" data-sec="3">
                        <div class="pf-label"><?php echo $model->getAttributeLabel('status'); ?></div>
                        <?php echo $form->dropDownList($model, 'status',
                            array(1 => 'Active', 0 => 'Inactive'),
                            array('id' => 'ProdModels_status', 'style' => 'display:none')
                        ); ?>
                        <div class="pf-tog-row <?php echo (!isset($model->status) || $model->status == 1) ? 'is-on' : ''; ?>"
                             id="togRow-status" onclick="$('#toggle-status').trigger('click')">
                            <label class="pf-toggle" onclick="event.stopPropagation()">
                                <input type="checkbox" id="toggle-status"
                                       <?php echo (!isset($model->status) || $model->status == 1) ? 'checked' : ''; ?>>
                                <span class="pf-tog-track"></span>
                                <span class="pf-tog-thumb"></span>
                            </label>
                            <div class="pf-tog-info">
                                <div class="pf-tog-title">Product is active</div>
                                <div class="pf-tog-desc">Inactive products are hidden from orders</div>
                            </div>
                            <span class="pf-tog-badge <?php echo (!isset($model->status) || $model->status == 1) ? 'on' : 'off'; ?>"
                                  id="badge-status">
                                <?php echo (!isset($model->status) || $model->status == 1) ? 'Active' : 'Inactive'; ?>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ═══ ④ Description ═══ -->
        <div class="pf-section" id="sec-desc">
            <div class="pf-sec-hd">
                <div class="pf-step-badge" id="badge-4">4</div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Additional Information</div>
                    <div class="pf-sec-sub">Optional product notes or specifications</div>
                </div>
            </div>
            <div class="pf-sec-body">
                <div class="row">
                    <div class="col-md-8 pf-field" data-sec="4">
                        <div class="pf-label"><?php echo $model->getAttributeLabel('description'); ?></div>
                        <?php echo $form->textArea($model, 'description',
                            array('maxlength'=>255, 'class'=>'pf-fl-input',
                                  'style'=>'padding:12px 14px; height:90px; resize:vertical; transform:none',
                                  'placeholder'=>'Optional product description or notes…',
                                  'id'=>'ProdModels_description')
                        ); ?>
                        <div class="pf-char" id="descCounter">0 / 255</div>
                        <span class="pf-error"><?php echo $form->error($model, 'description'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden fields -->
        <div style="display:none">
            <?php echo $form->textField($model, 'warranty', array('maxlength'=>255)); ?>
        </div>

        <!-- ═══ ⑤ Product Image ═══ -->
        <div class="pf-section" id="sec-img">
            <div class="pf-sec-hd">
                <div class="pf-step-badge" id="badge-5">5</div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Product Image</div>
                    <div class="pf-sec-sub">Optional — JPG or PNG, max 2 MB</div>
                </div>
            </div>
            <div class="pf-sec-body">
                <div class="row">
                    <div class="col-md-5 pf-field" id="pf-img-field" data-sec="5">
                        <?php
                        $currentImg = (!$model->isNewRecord && !empty($model->image))
                            ? Yii::app()->baseUrl . '/uploads/products/' . $model->image
                            : null;
                        ?>
                        <!-- Drop zone (hidden when preview is shown) -->
                        <div class="pf-img-zone" id="pfImgZone" <?php echo $currentImg ? 'style="display:none"' : ''; ?>>
                            <div class="pf-img-zone-icon"><i class="fas fa-cloud-upload"></i></div>
                            <div class="pf-img-zone-text">Click or drag &amp; drop</div>
                            <div class="pf-img-zone-sub">PNG, JPG, JPEG — max 2 MB</div>
                            <?php echo $form->fileField($model, 'image2', array(
                                'id'     => 'pfImageInput',
                                'accept' => '.png,.jpg,.jpeg',
                            )); ?>
                        </div>
                        <!-- Preview (shown after file chosen or when editing) -->
                        <div id="pfImgPreviewArea" style="text-align:center;<?php echo $currentImg ? '' : 'display:none;'; ?>">
                            <div class="pf-img-preview-wrap">
                                <img src="<?php echo $currentImg ?: ''; ?>" alt="Product image" class="pf-img-preview" id="pfImgPreview">
                                <button type="button" class="pf-img-remove" id="pfImgRemove" title="Remove image">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="pf-img-fname" id="pfImgFname">
                                <?php echo $currentImg ? htmlspecialchars($model->image) : ''; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7" style="display:flex;align-items:center;">
                        <div style="color:#94a3b8;font-size:12px;line-height:1.8;padding-left:10px;">
                            <i class="fas fa-info-circle" style="color:#6366f1;margin-right:4px;"></i>
                            <strong style="color:#374151;">Tips:</strong><br>
                            Use a white or transparent background.<br>
                            Square images work best (e.g. 400×400 px).<br>
                            Supported formats: JPG, PNG.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.card-body -->

    <!-- ═══ Footer ═══ -->
    <div class="card-footer">
        <button type="submit" class="pf-submit" id="pfSubmitBtn" onclick="pfSubmit(event)">
            <i class="fas fa-<?php echo $model->isNewRecord ? 'check' : 'save'; ?>"></i>
            <?php echo $model->isNewRecord ? 'Save Product' : 'Update Product'; ?>
        </button>
        <?php echo CHtml::link('<i class="fas fa-times"></i> Cancel', array('admin'), array('class'=>'pf-cancel')); ?>
        <span id="pf-spinner">
            <i class="fas fa-spinner fa-spin"></i> Saving…
        </span>
        <span class="pf-req-note"><span>*</span> Required fields</span>
    </div>

</div><!-- /.pf-card -->

<?php $this->endWidget(); ?>

<!-- ═══════════ jQuery UI Dialogs ═══════════ -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'      => 'dialogAddProdItem',
    'options' => array('title'=>'Add Product Category','autoOpen'=>false,'modal'=>true,'width'=>520,'resizable'=>false),
)); ?>
<div class="divForForm">
    <div class="ajaxLoaderFormLoad" style="display:none;padding:24px;text-align:center;">
        <i class="fas fa-spinner fa-spin fa-2x" style="color:#6366f1;"></i>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'      => 'dialogAddProdBrand',
    'options' => array('title'=>'Add Product Type','autoOpen'=>false,'modal'=>true,'width'=>520,'resizable'=>false),
)); ?>
<div class="divForForm">
    <div class="ajaxLoaderFormLoad" style="display:none;padding:24px;text-align:center;">
        <i class="fas fa-spinner fa-spin fa-2x" style="color:#6366f1;"></i>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'      => 'dialogAddUnit',
    'options' => array('title'=>'Add Unit','autoOpen'=>false,'modal'=>true,'width'=>520,'resizable'=>false),
)); ?>
<div class="divForForm">
    <div class="ajaxLoaderFormLoad" style="display:none;padding:24px;text-align:center;">
        <i class="fas fa-spinner fa-spin fa-2x" style="color:#6366f1;"></i>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
$(function () {
    // bsCustomFileInput removed — BS5 native file input

    /* ── Toggle: stockable ── */
    $('#toggle-stockable').on('change', function () {
        var on = this.checked;
        $('#ProdModels_stockable').val(on ? 1 : 0);
        $('#badge-stockable').text(on ? 'Yes' : 'No').removeClass('on off').addClass(on ? 'on' : 'off');
        $('#togRow-stockable').toggleClass('is-on', on);
    });

    /* ── Toggle: status ── */
    $('#toggle-status').on('change', function () {
        var on = this.checked;
        $('#ProdModels_status').val(on ? 1 : 0);
        $('#badge-status').text(on ? 'Active' : 'Inactive').removeClass('on off').addClass(on ? 'on' : 'off');
        $('#togRow-status').toggleClass('is-on', on);
    });

    /* ── Validation feedback on required fields ── */
    function checkField($field) {
        var val = $field.find('.pf-fl-input, .pf-select').val();
        var isReq = $field.data('required');
        if (!isReq) return;
        if (val && String(val).trim() !== '') {
            $field.addClass('is-valid').removeClass('is-invalid');
        } else {
            $field.addClass('is-invalid').removeClass('is-valid');
        }
        pfUpdateProgress();
        pfUpdateSectionBadges();
    }

    $('.pf-field[data-required]').find('.pf-fl-input, .pf-select').on('blur change', function () {
        checkField($(this).closest('.pf-field'));
    });

    /* ── Progress bar ── */
    function pfUpdateProgress() {
        var total  = $('.pf-field[data-required]').length;
        var filled = $('.pf-field[data-required]').filter(function () {
            var v = $(this).find('.pf-fl-input, .pf-select').val();
            return v && String(v).trim() !== '';
        }).length;
        var pct = total ? Math.round(filled / total * 100) : 0;
        $('#pfProg').css('width', pct + '%');
        $('#pfProgTxt').text(filled + ' / ' + total + ' required');
    }

    /* ── Section completion badges + header chips ── */
    var secMap = {
        1: { badge: '#badge-1', chip: '#chip-id',    secEl: '#sec-id' },
        2: { badge: '#badge-2', chip: '#chip-price',  secEl: '#sec-price' },
        3: { badge: '#badge-3', chip: '#chip-cfg',   secEl: '#sec-cfg' },
        4: { badge: '#badge-4', chip: '#chip-desc',  secEl: '#sec-desc' },
        5: { badge: '#badge-5', chip: '#chip-img',   secEl: '#sec-img' },
    };

    function pfUpdateSectionBadges() {
        $.each(secMap, function (sec, map) {
            var $reqFields = $('.pf-field[data-required][data-sec="' + sec + '"]');
            if ($reqFields.length === 0) {
                /* section has no required fields — always mark complete */
                $(map.badge).html('<i class="fas fa-check"></i>');
                $(map.secEl).addClass('is-complete');
                $(map.chip).addClass('done');
                return;
            }
            var allFilled = $reqFields.filter(function () {
                var v = $(this).find('.pf-fl-input, .pf-select').val();
                return v && String(v).trim() !== '';
            }).length === $reqFields.length;

            if (allFilled) {
                $(map.badge).html('<i class="fas fa-check"></i>');
                $(map.secEl).addClass('is-complete');
                $(map.chip).addClass('done');
            } else {
                $(map.badge).text(sec);
                $(map.secEl).removeClass('is-complete');
                $(map.chip).removeClass('done');
            }
        });
    }

    /* ── Char counter ── */
    var $desc = $('#ProdModels_description');
    var descMax = parseInt($desc.attr('maxlength')) || 255;
    function updateDescCounter() {
        var len = $desc.val().length;
        var $c = $('#descCounter');
        $c.text(len + ' / ' + descMax).removeClass('warn full');
        if (len >= descMax)            $c.addClass('full');
        else if (len >= descMax * .8)  $c.addClass('warn');
    }
    $desc.on('input', updateDescCounter);
    updateDescCounter();

    /* ── Ripple on submit ── */
    $('#pfSubmitBtn').on('mousedown', function (e) {
        var $btn = $(this);
        var off  = $btn.offset();
        var size = Math.max($btn.outerWidth(), $btn.outerHeight());
        $('<span class="pf-ripple">').css({
            width:size, height:size,
            left: e.pageX - off.left - size/2,
            top:  e.pageY - off.top  - size/2,
        }).appendTo($btn);
        setTimeout(function () { $btn.find('.pf-ripple').remove(); }, 650);
    });

    /* ── Image upload: file chosen ── */
    $(document).on('change', '#pfImageInput', function () {
        var file = this.files && this.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            toastr.warning('Image exceeds 2 MB limit');
            this.value = '';
            return;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#pfImgPreview').attr('src', e.target.result);
            $('#pfImgFname').text(file.name);
            $('#pfImgZone').hide();
            $('#pfImgPreviewArea').show();
            /* mark section complete */
            $('#badge-5').html('<i class="fas fa-check"></i>');
            $('#sec-img').addClass('is-complete');
            $('#chip-img').addClass('done');
        };
        reader.readAsDataURL(file);
    });

    /* ── Image upload: remove ── */
    $('#pfImgRemove').on('click', function () {
        $('#pfImgPreview').attr('src', '');
        $('#pfImgFname').text('');
        /* reset the file input value */
        var $inp = $('#pfImageInput');
        $inp.val('').replaceWith($inp.clone(true));
        $('#pfImgPreviewArea').hide();
        $('#pfImgZone').show();
        /* revert section badge */
        $('#badge-5').text('5');
        $('#sec-img').removeClass('is-complete');
        $('#chip-img').removeClass('done');
    });

    /* ── Drag-and-drop highlight ── */
    $('#pfImgZone').on('dragover dragenter', function (e) {
        e.preventDefault(); e.stopPropagation();
        $(this).addClass('drag-over');
    }).on('dragleave drop', function (e) {
        e.preventDefault(); e.stopPropagation();
        $(this).removeClass('drag-over');
        if (e.type === 'drop') {
            var dt = e.originalEvent.dataTransfer;
            if (dt && dt.files.length) {
                $('#pfImageInput')[0].files = dt.files;
                $('#pfImageInput').trigger('change');
            }
        }
    });

    /* ── Mark image section done on load if editing with existing image ── */
    if ($('#pfImgPreviewArea').is(':visible')) {
        $('#badge-5').html('<i class="fas fa-check"></i>');
        $('#sec-img').addClass('is-complete');
        $('#chip-img').addClass('done');
    }

    /* ── Run initial state for update form ── */
    $('.pf-field[data-required]').find('.pf-select').trigger('change');
    pfUpdateProgress();
    pfUpdateSectionBadges();
});

/* ── Submit handler ── */
function pfSubmit(e) {
    /* Shake any unfilled required fields */
    var anyEmpty = false;
    $('.pf-field[data-required]').each(function () {
        var v = $(this).find('.pf-fl-input, .pf-select').val();
        if (!v || String(v).trim() === '') {
            var $el = $(this).find('.pf-fl-input, .pf-select, .pf-fl');
            $el.addClass('pf-shake');
            setTimeout(function () { $el.removeClass('pf-shake'); }, 450);
            anyEmpty = true;
        }
    });
    if (!anyEmpty) {
        setTimeout(function () {
            $('#pf-spinner').css('display','inline-flex');
        }, 140);
    }
}

/* ── AJAX: Add Category ── */
function addProdItem() {
    <?php echo CHtml::ajax(array(
        'url'        => array('prodItems/createProdItemsFromOutSide'),
        'data'       => 'js:$(this).serialize()',
        'type'       => 'post',
        'dataType'   => 'json',
        'beforeSend' => "function(){ $('.ajaxLoaderFormLoad').show(); }",
        'complete'   => "function(){ $('.ajaxLoaderFormLoad').hide(); }",
        'success'    => "function(data){
            if(data.status=='failure'){
                $('#dialogAddProdItem div.divForForm').html(data.div);
                $('#dialogAddProdItem div.divForForm form').submit(addProdItem);
            } else {
                $('#dialogAddProdItem div.divForForm').html(data.div);
                setTimeout(function(){ $('#dialogAddProdItem').dialog('close'); }, 1000);
                $('#ProdModels_item_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
            }
        }",
    )); ?>
    return false;
}

/* ── AJAX: Add Type/Brand ── */
function addProdBrand() {
    <?php echo CHtml::ajax(array(
        'url'        => array('prodBrands/createProdBrandsFromOutSide'),
        'data'       => 'js:$(this).serialize()',
        'type'       => 'post',
        'dataType'   => 'json',
        'beforeSend' => "function(){ $('.ajaxLoaderFormLoad').show(); }",
        'complete'   => "function(){ $('.ajaxLoaderFormLoad').hide(); }",
        'success'    => "function(data){
            if(data.status=='failure'){
                $('#dialogAddProdBrand div.divForForm').html(data.div);
                $('#dialogAddProdBrand div.divForForm form').submit(addProdBrand);
            } else {
                $('#dialogAddProdBrand div.divForForm').html(data.div);
                setTimeout(function(){ $('#dialogAddProdBrand').dialog('close'); }, 1000);
                $('#ProdModels_brand_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
            }
        }",
    )); ?>
    return false;
}

/* ── AJAX: Add Unit ── */
function addUnit() {
    <?php echo CHtml::ajax(array(
        'url'        => array('units/createUnitFromOutSide'),
        'data'       => 'js:$(this).serialize()',
        'type'       => 'post',
        'dataType'   => 'json',
        'beforeSend' => "function(){ $('.ajaxLoaderFormLoad').show(); }",
        'complete'   => "function(){ $('.ajaxLoaderFormLoad').hide(); }",
        'success'    => "function(data){
            if(data.status=='failure'){
                $('#dialogAddUnit div.divForForm').html(data.div);
                $('#dialogAddUnit div.divForForm form').submit(addUnit);
            } else {
                $('#dialogAddUnit div.divForForm').html(data.div);
                setTimeout(function(){ $('#dialogAddUnit').dialog('close'); }, 1000);
                $('#ProdModels_unit_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
            }
        }",
    )); ?>
    return false;
}
</script>
