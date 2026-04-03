<?php
$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Common', 'url' => array('admin')),
        array('name' => 'Expense', 'url' => array('admin')),
        array('name' => 'Create'),
    ),
//    'delimiter' => ' &rarr; ',
));
// print yii1 version
//echo Yii::getVersion();

?>

<style>
/* ── Expense Card ── */
.ex-card{border:none;border-radius:16px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);margin-bottom:24px;
    animation:ex-cardIn .5s cubic-bezier(.34,1.56,.64,1)}
@keyframes ex-cardIn{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
.ex-card-header{background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);padding:20px 26px;position:relative;overflow:hidden}
.ex-card-header::before{content:'';position:absolute;inset:0;background:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);background-size:22px 22px;pointer-events:none}
.ex-card-header::after{content:'';position:absolute;top:-50px;right:-50px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.07);pointer-events:none}
.ex-header-row{display:flex;align-items:center;gap:14px;position:relative;z-index:1}
.ex-header-icon{width:34px;height:34px;border-radius:9px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px;flex-shrink:0;
    transition:transform .3s,background .3s}
.ex-header-icon:hover{transform:rotate(-8deg) scale(1.12);background:rgba(255,255,255,.3)}
.ex-header-text .ex-title{font-size:17px;font-weight:800;color:#fff;margin:0;line-height:1.3}
.ex-header-text .ex-subtitle{font-size:11.5px;color:rgba(255,255,255,.65);margin:0;line-height:1.4}

/* ── Header progress chips ── */
.ex-hd-chips{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px;position:relative;z-index:1}
.ex-chip{display:inline-flex;align-items:center;gap:5px;
    padding:4px 10px;border-radius:99px;font-size:11px;font-weight:600;
    background:rgba(255,255,255,.15);color:rgba(255,255,255,.85);
    border:1px solid rgba(255,255,255,.2);transition:all .3s}
.ex-chip i{font-size:10px}
.ex-chip.done{background:rgba(52,211,153,.25);border-color:rgba(52,211,153,.4);color:#d1fae5}
.ex-chip.done i{color:#6ee7b7}

.ex-card-body{padding:22px 26px;background:#fff}
.ex-card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;padding:14px 26px;display:flex;gap:10px;align-items:center;flex-wrap:wrap}

/* ── Item counter badge ── */
.ex-item-count{display:inline-flex;align-items:center;gap:5px;
    padding:4px 12px;border-radius:99px;font-size:11.5px;font-weight:700;
    background:#eef2ff;color:#6366f1;border:1px solid #c7d2fe;
    margin-left:auto;transition:all .3s}
.ex-item-count.has-items{background:#ecfdf5;color:#059669;border-color:#a7f3d0;animation:ex-countPop .3s}
@keyframes ex-countPop{0%{transform:scale(1)}50%{transform:scale(1.15)}100%{transform:scale(1)}}

/* ── Floating Label Inputs ── */
.ex-fl{position:relative;margin-bottom:18px}
.ex-fl-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#cbd5e1;font-size:13px;transition:color .2s;z-index:2;pointer-events:none}
.ex-fl-input{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:18px 12px 6px 38px;font-size:13.5px;font-weight:500;color:#1e293b;background:#fff;outline:none;transition:border-color .2s,box-shadow .2s}
.ex-fl-input:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}
.ex-fl-label{position:absolute;left:38px;top:50%;transform:translateY(-50%);font-size:13px;color:#94a3b8;font-weight:500;pointer-events:none;transition:all .2s ease}
.ex-fl-input:focus~.ex-fl-label,
.ex-fl-input:not([placeholder=' '])~.ex-fl-label,
.ex-fl-input:not(:placeholder-shown)~.ex-fl-label{top:5px;transform:none;font-size:9.5px;font-weight:700;color:#6366f1}
.ex-fl:focus-within .ex-fl-icon{color:#6366f1}
.ex-fl-input[readonly]{background:#f8fafc;color:#64748b}

/* ── Fixed Label + Select ── */
.ex-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#475569;margin-bottom:6px;letter-spacing:.3px}
.ex-select{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 36px 10px 12px;font-size:13.5px;font-weight:500;color:#1e293b;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236366f1' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5l6.5 6 6.5-6'/%3E%3C/svg%3E") no-repeat right 12px center;-webkit-appearance:none;-moz-appearance:none;appearance:none;outline:none;transition:border-color .2s,box-shadow .2s}
.ex-select:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}

/* ── Error ── */
.ex-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block}

/* ── Section layout ── */
.ex-section{padding:22px 26px;border-bottom:1px solid #f1f5f9;transition:background .25s}
.ex-section:last-child{border-bottom:none}
.ex-section:hover{background:#fafbff}
.ex-sec-hd{display:flex;align-items:center;gap:12px;margin-bottom:16px}
.ex-step-badge{width:28px;height:28px;border-radius:50%;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    background:#eef2ff;color:#6366f1;font-size:12px;font-weight:800;
    border:2px solid #c7d2fe;
    transition:all .3s cubic-bezier(.34,1.56,.64,1)}
.ex-step-badge.completed{background:#6366f1;color:#fff;border-color:#6366f1;
    transform:scale(1.1);box-shadow:0 2px 8px rgba(99,102,241,.35)}
.ex-step-badge.completed::after{content:'\f00c';font-family:FontAwesome;font-size:11px}
.ex-step-badge.completed .ex-badge-num{display:none}
.ex-sec-title{font-size:13.5px;font-weight:700;color:#1e293b;line-height:1.2}
.ex-sec-sub{font-size:11px;color:#94a3b8;margin-top:1px}
.ex-sec-body{background:#f8faff;border:1px solid #eef2ff;border-radius:12px;padding:18px 16px;
    transition:border-color .3s,box-shadow .3s}
.ex-section:focus-within .ex-sec-body{border-color:#c7d2fe;box-shadow:0 0 0 3px rgba(99,102,241,.06)}

/* ── Items Sub-Card ── */
.ex-items-card{border:1.5px solid #e2e8f0;border-radius:12px;overflow:hidden;margin-top:4px}
.ex-items-header{background:linear-gradient(135deg,#f8fafc 0%,#f1f5f9 100%);padding:12px 18px;display:flex;align-items:center;gap:10px;border-bottom:1px solid #e2e8f0}
.ex-items-header-icon{width:26px;height:26px;border-radius:7px;background:rgba(99,102,241,.1);display:flex;align-items:center;justify-content:center;color:#6366f1;font-size:11px}
.ex-items-header-title{font-size:13px;font-weight:700;color:#334155;margin:0}
.ex-items-body{padding:18px}
.ex-items-row{display:flex;gap:14px;flex-wrap:wrap;align-items:flex-end;margin-bottom:14px}
.ex-items-row .ex-fl{flex:1;min-width:160px;margin-bottom:0}
.ex-add-btn{height:42px;padding:0 20px;border:none;border-radius:8px;background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;font-size:12.5px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:transform .15s,box-shadow .15s;white-space:nowrap;box-shadow:0 3px 10px rgba(99,102,241,.3)}
.ex-add-btn:hover{transform:translateY(-1px);box-shadow:0 4px 14px rgba(99,102,241,.4)}
.ex-add-btn:active{transform:translateY(0)}

/* ── Empty state ── */
.ex-table-empty{padding:24px;text-align:center;color:#94a3b8;font-size:13px;font-style:italic}

/* ── Row animations ── */
.ex-table tbody tr.item{animation:ex-rowSlide .35s cubic-bezier(.34,1.56,.64,1)}
@keyframes ex-rowSlide{from{opacity:0;transform:translateX(-16px)}to{opacity:1;transform:translateX(0)}}
.ex-table tbody tr.item.ex-removing{animation:ex-rowOut .25s ease forwards}
@keyframes ex-rowOut{to{opacity:0;transform:translateX(16px);height:0;padding:0;overflow:hidden}}

/* ── Add button pulse when ready ── */
.ex-add-btn.ex-ready{animation:ex-pulse 1.5s ease infinite}
@keyframes ex-pulse{0%,100%{box-shadow:0 3px 10px rgba(99,102,241,.3)}50%{box-shadow:0 3px 18px rgba(99,102,241,.55)}}

/* ── Table ── */
.ex-table-wrap{overflow-x:auto;margin-top:6px;border-radius:10px;overflow:hidden;border:1px solid #eef2ff}
.ex-table{width:100%;border-collapse:collapse;font-size:13px}
.ex-table thead th{background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;white-space:nowrap}
.ex-table tbody td{padding:8px 12px;border-bottom:1px solid #f1f5f9;vertical-align:middle;color:#334155}
.ex-table tbody tr:hover{background:#f8faff}
.ex-table tfoot th{padding:10px 12px;background:#f8fafc;border-top:2px solid #e2e8f0;font-size:12px;color:#475569}
.ex-table .ex-tbl-input{border:1.5px solid #e2e8f0;border-radius:6px;padding:7px 10px;font-size:13px;width:100%;outline:none;transition:border-color .2s,box-shadow .2s}
.ex-table .ex-tbl-input:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.10)}
.ex-table .ex-grand-input{border:1.5px solid #e2e8f0;border-radius:6px;padding:7px 10px;font-size:13px;font-weight:700;width:100%;text-align:right;outline:none;background:#f8fafc;color:#4f46e5}
.ex-dlt-btn{width:32px;height:32px;border:none;border-radius:7px;background:rgba(239,68,68,.08);color:#ef4444;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;transition:all .2s}
.ex-dlt-btn:hover{background:#ef4444;color:#fff;transform:scale(1.12);box-shadow:0 3px 8px rgba(239,68,68,.3)}
.ex-dlt-btn:active{transform:scale(.95)}

/* ── Grand total highlight ── */
.ex-grand-input.ex-total-flash{animation:ex-totalFlash .5s ease}
@keyframes ex-totalFlash{0%{background:#f8fafc}50%{background:#eef2ff;box-shadow:0 0 0 3px rgba(99,102,241,.15)}100%{background:#f8fafc}}

/* ── Submit Button ── */
.ex-submit{display:inline-flex;align-items:center;gap:8px;padding:10px 28px;border:none;border-radius:9px;background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;font-size:13.5px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);position:relative;overflow:hidden;transition:transform .15s,box-shadow .15s}
.ex-submit:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(99,102,241,.45)}
.ex-submit:active{transform:translateY(0)}
.ex-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.35);transform:scale(0);animation:ex-ripple-anim .6s linear}
@keyframes ex-ripple-anim{to{transform:scale(4);opacity:0}}

/* ── Overlay ── */
#overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);backdrop-filter:blur(4px);z-index:9999;justify-content:center;align-items:center}
#overlay .cv-spinner{display:flex;justify-content:center;align-items:center;height:100%}
#overlay .spinner{width:44px;height:44px;border:4px solid rgba(99,102,241,.2);border-top-color:#6366f1;border-radius:50%;animation:ex-spin .7s linear infinite}
@keyframes ex-spin{to{transform:rotate(360deg)}}

/* ── Autocomplete dropdown — compact list ── */
ul.ui-autocomplete.ui-menu{
    border:1px solid #e5e7eb!important;border-radius:8px!important;
    box-shadow:0 4px 16px rgba(0,0,0,.10)!important;
    padding:4px 0!important;margin:4px 0 0!important;
    max-height:240px;overflow-y:auto;overflow-x:hidden;
    background:#fff!important;z-index:10000!important;
    list-style:none!important;
    scrollbar-width:thin;scrollbar-color:#e2e8f0 transparent}
ul.ui-autocomplete.ui-menu::-webkit-scrollbar{width:5px}
ul.ui-autocomplete.ui-menu::-webkit-scrollbar-thumb{background:#d1d5db;border-radius:3px}
ul.ui-autocomplete li.ui-menu-item{
    margin:0!important;padding:0!important;
    border-bottom:1px solid #f1f5f9;
    list-style:none!important;float:none!important;
    display:block!important;height:auto!important;
    background:none!important;box-shadow:none!important}
ul.ui-autocomplete li.ui-menu-item:last-child{border-bottom:none}
ul.ui-autocomplete li.ui-menu-item a,
ul.ui-autocomplete li.ui-menu-item div,
ul.ui-autocomplete li.ui-menu-item .ui-menu-item-wrapper{
    display:block!important;
    padding:6px 12px!important;margin:0!important;
    font-size:14px!important;line-height:1.2!important;
    height:auto!important;min-height:0!important;max-height:36px!important;
    overflow:hidden!important;
    color:#334155!important;background:transparent!important;
    border:none!important;border-radius:0!important;box-shadow:none!important;
    cursor:pointer!important;white-space:nowrap;text-overflow:ellipsis;
    font-weight:400!important;text-decoration:none!important;
    transition:background .1s,color .1s}
ul.ui-autocomplete li.ui-menu-item a:hover,
ul.ui-autocomplete li.ui-menu-item div:hover,
ul.ui-autocomplete li.ui-menu-item .ui-menu-item-wrapper:hover,
ul.ui-autocomplete .ui-state-active,
ul.ui-autocomplete .ui-state-focus,
ul.ui-autocomplete .ui-menu-item .ui-state-active{
    background:#eef2ff!important;color:#4338ca!important;
    border:none!important;box-shadow:none!important;
    font-weight:500!important}
.ui-helper-hidden-accessible{display:none!important;position:absolute!important;clip:rect(0,0,0,0)!important}

/* ── Responsive ── */
@media(max-width:768px){
    .ex-card-body{padding:16px 14px}
    .ex-card-footer{padding:12px 14px}
    .ex-items-body{padding:14px 10px}
    .ex-items-row{flex-direction:column}
    .ex-items-row .ex-fl{min-width:100%}
}
</style>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'expense-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
));
Yii::app()->clientScript->registerCoreScript("jquery.ui");

?>

<script>
    $(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
</script>

<div class="ex-card">
    <!-- ── Header ── -->
    <div class="ex-card-header">
        <div class="ex-header-row">
            <div class="ex-header-icon"><i class="fas fa-money-bill"></i></div>
            <div class="ex-header-text">
                <p class="ex-title"><?php echo($model->isNewRecord ? 'Create Expense' : 'Update Expense'); ?></p>
                <p class="ex-subtitle">Fill in the details below to record a new expense entry</p>
            </div>
        </div>
        <div class="ex-hd-chips">
            <span class="ex-chip" id="ex-chip-date"><i class="fas fa-calendar"></i> Date</span>
            <span class="ex-chip" id="ex-chip-items"><i class="fas fa-list-ul"></i> Items <span id="ex-chip-count" style="display:none;margin-left:2px;background:rgba(255,255,255,.25);border-radius:99px;padding:0 6px;font-size:10px;">0</span></span>
            <span class="ex-chip" id="ex-chip-total"><i class="fas fa-calculator"></i> Total: <span id="ex-chip-total-val">0.00</span></span>
            <span class="ex-chip" id="ex-dirty-badge" style="display:none;background:rgba(234,179,8,.2);border-color:rgba(234,179,8,.4);color:#fef08a;">
                <i class="fas fa-circle" style="font-size:7px;color:#facc15;"></i> Unsaved draft
            </span>
        </div>
    </div>

    <!-- ── Body ── -->
    <div class="ex-card-body" style="padding:0;">

        <!-- ═══ Section 1 — Entry Info ═══ -->
        <div class="ex-section">
            <div class="ex-sec-hd">
                <div class="ex-step-badge" id="ex-badge-1"><span class="ex-badge-num">1</span></div>
                <div>
                    <div class="ex-sec-title">Entry Information</div>
                    <div class="ex-sec-sub">Date, remarks, and who is recording</div>
                </div>
            </div>
            <div class="ex-sec-body">
                <div class="row" style="align-items:flex-start;">
                    <!-- Date -->
                    <div class="col-sm-6 col-md-3" style="margin-bottom:14px;">
                        <div class="ex-fl" style="margin-bottom:0;">
                            <i class="fas fa-calendar ex-fl-icon"></i>
                            <?php echo $form->textField($model, 'date', array(
                                'class' => 'ex-fl-input datetimepicker-input',
                                'placeholder' => ' ',
                                'value' => date('Y-m-d'),
                                'id' => 'Expense_date',
                            )); ?>
                            <label class="ex-fl-label">Date <span style="color:#ef4444;">*</span></label>
                        </div>
                        <?php echo $form->error($model, 'date', array('class' => 'ex-error')); ?>
                        <div id="entry_date" data-target-input="nearest" style="display:none"></div>
                    </div>

                    <!-- Remarks -->
                    <div class="col-sm-12 col-md-5" style="margin-bottom:14px;">
                        <div class="ex-fl" style="margin-bottom:0;">
                            <i class="fas fa-comment-o ex-fl-icon"></i>
                            <?php echo $form->textField($model, 'remarks', array(
                                'class' => 'ex-fl-input',
                                'placeholder' => ' ',
                            )); ?>
                            <label class="ex-fl-label">Remarks</label>
                        </div>
                        <?php echo $form->error($model, 'remarks', array('class' => 'ex-error')); ?>
                    </div>

                    <!-- Created By -->
                    <div class="col-sm-6 col-md-4" style="margin-bottom:14px;">
                        <div class="ex-fl" style="margin-bottom:0;">
                            <i class="fas fa-user ex-fl-icon"></i>
                            <?php echo $form->textField($model, 'created_by_text', array(
                                'class' => 'ex-fl-input',
                                'placeholder' => ' ',
                                'readonly' => true,
                                'value' => Users::model()->nameOfThis(Yii::app()->user->getState('user_id')),
                            )); ?>
                            <label class="ex-fl-label">Created By</label>
                        </div>
                        <?php echo $form->error($model, 'created_by', array('class' => 'ex-error')); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ Section 2 — Expense Items ═══ -->
        <div class="ex-section">
            <div class="ex-sec-hd">
                <div class="ex-step-badge" id="ex-badge-2"><span class="ex-badge-num">2</span></div>
                <div>
                    <div class="ex-sec-title">Expense Items <span class="ex-item-count" id="ex-item-badge"><i class="fas fa-list-ul"></i> <span id="ex-item-num">0</span> items</span></div>
                    <div class="ex-sec-sub">Search an expense head, set amount, then add to the list</div>
                </div>
            </div>
            <div class="ex-sec-body">

        <div class="ex-items-card" style="border:none;box-shadow:none;">
            <div class="ex-items-body">
                <div class="ex-items-row">
                    <!-- Expense Head -->
                    <div class="ex-fl" style="flex:2;min-width:200px">
                        <i class="fas fa-tag ex-fl-icon"></i>
                        <input type="text" id="expense_head_id_text" class="ex-fl-input" placeholder=" ">
                        <?php echo $form->hiddenField($model2, 'expense_head_id', array('maxlength' => 255, 'class' => 'form-control', 'readonly' => true)); ?>
                        <label class="ex-fl-label">Expense Head</label>
                        <div style="position:absolute;right:8px;top:50%;transform:translateY(-50%);z-index:2">
                            <?php echo CHtml::link('<i class="fas fa-plus" style="color:#6366f1;font-size:13px"></i>', "", array('onclick' => "{addProdModel(); $('#dialogAddProdModel').dialog('open');}", 'style' => 'display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:7px;background:rgba(99,102,241,.08);text-decoration:none')); ?>

                            <?php
                            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                                'id' => 'dialogAddProdModel',
                                'options' => array(
                                    'title' => 'Add Expense Head',
                                    'autoOpen' => false,
                                    'modal' => true,
                                    'width' => '600px',
                                    'left' => '30px',
                                    'resizable' => false,
                                ),
                            ));
                            ?>
                            <div class="divForForm">
                                <div class="ajaxLoaderFormLoad" style="display: none;"><img
                                            src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif"/>
                                </div>

                            </div>

                            <?php $this->endWidget(); ?>

                            <script type="text/javascript">
                                // here is the magic
                                function addProdModel() {
                                    <?php
                                    echo CHtml::ajax(array(
                                        'url' => array('/accounting/expenseHead/CreateHeadFromOutSide'),
                                        'data' => "js:$(this).serialize()",
                                        'type' => 'post',
                                        'dataType' => 'json',
                                        'beforeSend' => "function(){
                                            $('.ajaxLoaderFormLoad').show();
                                        }",
                                        'complete' => "function(){
                                            $('.ajaxLoaderFormLoad').hide();
                                        }",
                                        'success' => "function(data){
                                                if (data.status == 'failure')
                                                {
                                                    $('#dialogAddProdModel div.divForForm').html(data.div);
                                                          // Here is the trick: on submit-> once again this function!
                                                    $('#dialogAddProdModel div.divForForm form').submit(addProdModel);
                                                }
                                                else
                                                {
                                                    $('#dialogAddProdModel div.divForForm').html(data.div);
                                                    setTimeout(\"$('#dialogAddProdModel').dialog('close') \",1000);
                                                    $('#ExpenseDetails_expense_head_id').val(data.value);
                                                    $('#expense_head_id_text').val(data.label);
                                                }
                                            }",
                                    ))
                                    ?>
                                    return false;
                                }
                            </script>
                        </div>
                    </div>
                    <?php echo $form->error($model, 'expense_head_id', array('class' => 'ex-error')); ?>

                    <script>
                        $(document).ready(function () {
                            $("#expense_head_id_text").on("focus keyup", function () {
                                $(this).autocomplete({
                                    source: function (request, response) {
                                        var search_prodName = request.term;
                                        $.post('<?php echo Yii::app()->baseUrl ?>/index.php/accounting/expenseHead/jquery_showExpenseHead', {
                                                "q": search_prodName,
                                            },
                                            function (data) {
                                                response(data);
                                            }, "json");
                                    },
                                    minLength: 2,
                                    delay: 700,
                                    select: function (event, ui) {
                                        $('#expense_head_id_text').val(ui.item.value);
                                        $('#ExpenseDetails_expense_head_id').val(ui.item.id);
                                        return false;
                                    }
                                });
                            });
                        });
                    </script>

                    <!-- Amount -->
                    <div class="ex-fl" style="flex:1;min-width:140px">
                        <i class="fas fa-money-bill ex-fl-icon"></i>
                        <?php echo $form->textField($model2, 'amount', array('maxlength' => 255, 'class' => 'ex-fl-input qty-amount', 'placeholder' => ' ')); ?>
                        <label class="ex-fl-label">Amount</label>
                        <?php echo $form->error($model2, 'amount', array('class' => 'ex-error')); ?>
                    </div>

                    <!-- Remarks -->
                    <div class="ex-fl" style="flex:1;min-width:140px">
                        <i class="fas fa-pencil ex-fl-icon"></i>
                        <?php echo $form->textField($model2, 'remarks', array('maxlength' => 255, 'class' => 'ex-fl-input', 'placeholder' => ' ')); ?>
                        <label class="ex-fl-label">Note</label>
                        <?php echo $form->error($model2, 'remarks', array('class' => 'ex-error')); ?>
                    </div>

                    <!-- Add Button -->
                    <div style="flex:0 0 auto">
                        <button class="ex-add-btn" onclick="addToList()" type="button">
                            <i class="fas fa-plus"></i> Add
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="ex-table-wrap">
                    <table class="ex-table" id="list">
                        <thead>
                        <tr>
                            <th class="text-center" style="width:40px">#</th>
                            <th>Expense Head</th>
                            <th class="text-center" style="width:28%">Note</th>
                            <th class="text-center" style="width:22%">Amount</th>
                            <th class="text-center" style="width:50px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr id="ex-empty-row">
                                <td colspan="5" class="ex-table-empty">
                                    <i class="fas fa-inbox" style="font-size:20px;display:block;margin-bottom:6px;color:#c7d2fe;"></i>
                                    No expense items added yet — search and add above
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3" class="text-end" style="vertical-align:middle;font-size:12px">
                                <i class="fas fa-calculator" style="color:#6366f1;margin-right:4px"></i> Grand Total
                            </th>
                            <th style="vertical-align:middle">
                                <?php echo $form->textField($model, 'amount', array('maxlength' => 255, 'class' => 'ex-grand-input grand_total', 'readonly' => true)); ?>
                                <?php echo $form->error($model, 'amount', array('class' => 'ex-error')); ?>
                            </th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            </div><!-- /ex-sec-body -->
        </div><!-- /section 2 -->

    </div><!-- /card-body -->

    <!-- ── Footer ── -->
    <div class="ex-card-footer">
        <?php
        echo CHtml::ajaxSubmitButton('Create', CHtml::normalizeUrl(array('/accounting/expense/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();
                    if(data.status=="success"){
                        clearDraft(); formDirty = false;
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        toastr.success("Data saved successfully.");
                        $("#expense-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#list tbody .item").remove();
                        $("#ex-empty-row").show();
                        if(typeof updateChips==="function") updateChips();
//                        $("#soReportDialogBox").dialog("open");
//                        $("#AjFlashReportSo").html(data.soReportInfo).show();
                        bootstrap.Modal.getOrCreateInstance(document.getElementById("information-modal")).show();
                        $("#information-modal .modal-body").html(data.soReportInfo);
                    }else{
                        $("#formResultError").html("Data not saved. Please solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#expense-form #"+key+"_em_").html(""+val+"");
                            $("#expense-form #"+key+"_em_").show();
                        });
                    }
                }',
            'beforeSend' => 'function(){
                    let count_item =  $(".item").length;
                    let date = $("#Expense_date").val();
                    let grand_total = $("#Expense_amount").val();
                    let unit_price_zero = 0;
                    $(".temp-amount").each(function () {
                        var up = parseFloat($(this).val());
                        up = isNaN(up) ? 0 : up;
                        if(up <= 0){
                            unit_price_zero++;
                            $(this).addClass("is-invalid");
                        }else{
                            $(this).removeClass("is-invalid");
                        }
                    });
                    if(date == ""){
                        toastr.error("Please insert date.");
                        return false;
                    }else if(count_item <= 0){
                        toastr.error("Please add materials to list.");
                        return false;
                    }else if(unit_price_zero > 0){
                        toastr.error("Please insert expense amount.");
                        return false;
                    }else if(grand_total == "" || grand_total <= 0){
                        toastr.error("Grand total amount is 0");
                        return false;
                    }else {
                        $("#overlay").fadeIn(300);
                        $("#ajaxLoader").show();
                    }
                 }',
            'error' => 'function(xhr, status, error) {
                    $("#overlay").fadeOut(300);
                    $("#ajaxLoader").hide();

                    // Code to handle errors
                    toastr.error(xhr.responseText); // Displaying error message using Toastr
                    // Optionally, you can display additional error details
                    console.error(xhr.statusText);
                    console.error(xhr.status);
                    console.error(xhr.responseText);
              }',
            'complete' => 'function() {
                    $("#overlay").fadeOut(300);
                     $("#ajaxLoaderReport").hide();

              }',
        ), array('class' => 'ex-submit', 'id' => 'ex-submit-btn'));
        ?>

        <span id="ajaxLoaderMR" class="ajaxLoaderMR" style="display: none;">
            <i class="fas fa-spinner fa-spin fa-2x" style="color:#6366f1"></i>
        </span>

        <div id="formResult" class="ajaxTargetDiv"></div>
        <div id="formResultError" class="ajaxTargetDivErr"></div>
    </div>
</div>
<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<?php $this->endWidget(); ?>


<script>
    // Ripple effect on submit button
    $(document).on('click', '.ex-submit', function(e){
        var btn = $(this);
        var ripple = $('<span class="ex-ripple"></span>');
        var x = e.pageX - btn.offset().left;
        var y = e.pageY - btn.offset().top;
        ripple.css({left: x+'px', top: y+'px'});
        btn.append(ripple);
        setTimeout(function(){ ripple.remove(); }, 600);
    });

    /* ── Interactive state tracking ── */
    function updateChips(){
        var dateVal = $('#Expense_date').val();
        var itemCount = $('#list tbody .item').length;
        var total = parseFloat($('#Expense_amount').val()) || 0;

        // Date chip
        if(dateVal){ $('#ex-chip-date').addClass('done'); $('#ex-badge-1').addClass('completed'); }
        else { $('#ex-chip-date').removeClass('done'); $('#ex-badge-1').removeClass('completed'); }

        // Items chip + badge
        if(itemCount > 0){
            $('#ex-chip-items').addClass('done');
            $('#ex-chip-count').text(itemCount).show();
            $('#ex-badge-2').addClass('completed');
            $('#ex-item-badge').addClass('has-items');
        } else {
            $('#ex-chip-items').removeClass('done');
            $('#ex-chip-count').hide();
            $('#ex-badge-2').removeClass('completed');
            $('#ex-item-badge').removeClass('has-items');
        }
        $('#ex-item-num').text(itemCount);

        // Total chip
        $('#ex-chip-total-val').text(total.toFixed(2));
        if(total > 0) $('#ex-chip-total').addClass('done');
        else $('#ex-chip-total').removeClass('done');
    }

    // Track date changes
    $('#Expense_date').on('change input', updateChips);

    /* ── Add button glow when head+amount are filled ── */
    function checkAddReady(){
        var head = $('#ExpenseDetails_expense_head_id').val();
        var amt = parseFloat($('#ExpenseDetails_amount').val()) || 0;
        if(head && amt > 0) $('.ex-add-btn').addClass('ex-ready');
        else $('.ex-add-btn').removeClass('ex-ready');
    }
    $(document).on('input change','#expense_head_id_text, #ExpenseDetails_amount', checkAddReady);

    let sl = 1;
    var picker = new Lightpick({
        field: document.getElementById("Expense_date"),
        defaultDate: moment(),
        onSelect: function (date) {
            document.getElementById("Expense_date").value = date.format('YYYY-MM-DD');
            updateChips();
            markDirty();
        }
    });

    $(document).keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            console.log('You pressed a "enter" key in somewhere');
            addToList();
            return false;
        }
    });

    $(document).ready(function () {

        $("#btnReset").click(function () {
            cleanAll();
        });

        $(".qty-amount").keyup(function () {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));
        });

        $("#list").on("click", ".dlt", function () {
            var $row = $(this).closest("tr");
            $row.addClass('ex-removing');
            setTimeout(function(){
                $row.remove();
                if($("#list tbody .item").length === 0) $("#ex-empty-row").show();
                calculateTotal();
                updateChips();
                markDirty();
                saveDraft();
            }, 250);
        });
    });


    function addToList() {
        let head = $("#ExpenseDetails_expense_head_id").val();
        let head_text = $("#expense_head_id_text").val();
        let amount = $("#ExpenseDetails_amount").val();
        let note = $("#ExpenseDetails_remarks").val();

        let isproductpresent = false;
        let temp_codearray = document.getElementsByName("ExpenseDetails[temp_expense_head_id][]");
        if (temp_codearray.length > 0) {
            for (let l = 0; l < temp_codearray.length; l++) {
                var code = temp_codearray[l].value;
                if (code == head) {
                    isproductpresent = true;
                    break;
                }
            }
        }


        if (head == "" || head <= 0) {
            toastr.error("Please select expense from list!");
            return false;
        } else if (isproductpresent == true) {
            toastr.error(head_text + " is already on the list! Please add another!");
            return false;
        } else if (amount <= 0 || amount == "") {
            toastr.error("Please insert amount!");
            return false;
        } else {
            $("#ex-empty-row").hide();
            $("#list tbody").append(`
                    <tr class="item">
                        <td class="text-center sl-no" style="vertical-align: middle;">${$('#list tbody tr').length + 1}</td>
                        <td class="text-start" style="vertical-align: middle;">
                            ${head_text}
                            <input type="hidden" name="ExpenseDetails[temp_expense_head_id][]"
                                   class="form-control model-id" value="${head}">
                        </td>
                        <td class="text-center" style="vertical-align: middle;  min-width: 120px;">
                            <input type="text" name="ExpenseDetails[temp_remarks][]"
                                   class="ex-tbl-input text-start" value="${note}">
                        </td>
                        <td class="text-center" style="vertical-align: middle;  min-width: 120px;">
                            <input type="text" name="ExpenseDetails[temp_amount][]"
                                   class="ex-tbl-input text-end temp-amount" value="${amount}">
                        </td>
                        <td class="text-center">
                            <button type="button" class="ex-dlt-btn dlt"><i class="fas fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                `);
            calculateTotal();
            cleanItems();
            updateChips();
            checkAddReady();
            markDirty();
            saveDraft();
            // Flash grand total
            var $gt = $('.grand_total');
            $gt.removeClass('ex-total-flash');
            void $gt[0].offsetWidth;
            $gt.addClass('ex-total-flash');
        }
    }

    $(document).on('keyup', ".temp-amount", function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
        calculateTotal();
    });

    function cleanAll() {
        $("#list tbody .item").remove();
        $("#ex-empty-row").show();
        $("#expense-form")[0].reset();
        calculateTotal();
    }


    function calculateTotal() {
        let total = 0;
        $('.temp-amount').each(function () {
            var amount = parseFloat($(this).val());
            amount = isNaN(amount) ? 0 : amount;
            total += amount;
        });
        $("#Expense_amount").val(total.toFixed(2)).change();
    }

    function cleanItems() {
        $("#ExpenseDetails_expense_head_id").val("");
        $("#expense_head_id_text").val("");
        $("#ExpenseDetails_amount").val("");
    }

    /* ══════════════════════════════════════════════════
       Unsaved-changes guard + Draft autosave
    ══════════════════════════════════════════════════ */
    var formDirty = false;
    var EX_DRAFT_KEY = 'expense_draft_create';

    window.addEventListener('beforeunload', function(e){
        if(formDirty){ e.preventDefault(); e.returnValue = ''; }
    });

    function markDirty(){
        formDirty = true;
        $('#ex-dirty-badge').fadeIn(200);
    }

    /* ── Save draft to localStorage ── */
    function saveDraft(){
        var rows = [];
        $('#list tbody tr.item').each(function(){
            rows.push({
                head_id:   $(this).find('input[name="ExpenseDetails[temp_expense_head_id][]"]').val(),
                head_text: $(this).find('td:eq(1)').text().trim(),
                note:      $(this).find('input[name="ExpenseDetails[temp_remarks][]"]').val(),
                amount:    $(this).find('input[name="ExpenseDetails[temp_amount][]"]').val()
            });
        });
        var draft = {
            date:     $('#Expense_date').val(),
            remarks:  $('#Expense_remarks').val(),
            rows:     rows,
            saved_at: new Date().toISOString()
        };
        try { localStorage.setItem(EX_DRAFT_KEY, JSON.stringify(draft)); } catch(e){}
    }

    function clearDraft(){
        localStorage.removeItem(EX_DRAFT_KEY);
        formDirty = false;
        $('#ex-dirty-badge').hide();
    }

    /* ── Auto-save on any change (debounced 600ms) ── */
    var _draftTimer = null;
    $('#expense-form').on('change keyup input', 'input, select, textarea', function(){
        markDirty();
        clearTimeout(_draftTimer);
        _draftTimer = setTimeout(saveDraft, 600);
    });

    /* ── Ctrl+Enter shortcut to submit ── */
    $(document).on('keydown', function(e){
        if((e.ctrlKey || e.metaKey) && e.key === 'Enter'){
            e.preventDefault();
            formDirty = false;
            $('#ex-submit-btn').trigger('click');
        }
    });

    /* ── Restore draft on page load ── */
    function restoreDraft(){
        try {
            var raw = localStorage.getItem(EX_DRAFT_KEY);
            if(!raw) return;
            var d = JSON.parse(raw);
            if(!d.saved_at) return;
            var hasRows = d.rows && d.rows.length > 0;
            var hasHeader = d.date || d.remarks;
            if(!hasRows && !hasHeader) return;

            // Restore header fields
            if(d.date)    $('#Expense_date').val(d.date);
            if(d.remarks) $('#Expense_remarks').val(d.remarks);

            // Restore item rows
            if(hasRows){
                $('#ex-empty-row').hide();
                $.each(d.rows, function(i, row){
                    $('#list tbody').append(
                        '<tr class="item">' +
                        '<td class="text-center sl-no" style="vertical-align:middle;">' + (i + 1) + '</td>' +
                        '<td class="text-start" style="vertical-align:middle;">' +
                            row.head_text +
                            '<input type="hidden" name="ExpenseDetails[temp_expense_head_id][]" class="form-control model-id" value="' + row.head_id + '">' +
                        '</td>' +
                        '<td class="text-center" style="vertical-align:middle;min-width:120px;">' +
                            '<input type="text" name="ExpenseDetails[temp_remarks][]" class="ex-tbl-input text-start" value="' + (row.note || '') + '">' +
                        '</td>' +
                        '<td class="text-center" style="vertical-align:middle;min-width:120px;">' +
                            '<input type="text" name="ExpenseDetails[temp_amount][]" class="ex-tbl-input text-end temp-amount" value="' + row.amount + '">' +
                        '</td>' +
                        '<td class="text-center">' +
                            '<button type="button" class="ex-dlt-btn dlt"><i class="fas fa-trash-can"></i></button>' +
                        '</td>' +
                        '</tr>'
                    );
                });
                calculateTotal();
            }

            var savedAt = d.saved_at ? new Date(d.saved_at).toLocaleString() : '';
            toastr.info(
                'Draft restored' + (savedAt ? ' — saved at ' + savedAt : '') + '.' +
                ' <button class="btn btn-xs" style="background:rgba(255,255,255,.18);color:#fff;border:1px solid rgba(255,255,255,.25);margin-left:6px;" ' +
                'onclick="clearDraft();location.reload();">Discard</button>',
                'Session Restored',
                { timeOut: 8000, closeButton: true, enableHtml: true }
            );
            markDirty();
        } catch(e){ localStorage.removeItem(EX_DRAFT_KEY); }
    }

    // Initialize on page load
    $(function(){
        restoreDraft();
        updateChips();
    });
</script>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'EXPENSE VOUCHER PREVIEW',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget(); ?>


<!--        modal-->
<div class="modal fade" id="information-modal" tabindex="-1" data-bs-backdrop="static" role="dialog"
     aria-labelledby="information-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);border:none;">
                <h5 class="modal-title" style="color:#fff;font-weight:700;font-size:15px;"><i class="fas fa-file-lines" style="margin-right:6px;"></i> Expense Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:#fff;opacity:.7;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Loading...</p> <!-- this will be replaced by the response from the server -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
