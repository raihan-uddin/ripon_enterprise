<style>
/* ── lt- card shell ─────────────────────────────────── */
.lt-card{border:none;border-radius:16px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,.04),0 12px 36px rgba(0,0,0,.10);margin-bottom:24px}

/* header */
.lt-card-header{background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);padding:20px 26px;position:relative;overflow:hidden}
.lt-card-header::before{content:'';position:absolute;inset:0;background:radial-gradient(rgba(255,255,255,.18) 1.2px,transparent 1.2px);background-size:22px 22px;pointer-events:none}
.lt-card-header::after{content:'';position:absolute;top:-50px;right:-50px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.07);pointer-events:none}
.lt-header-row{display:flex;align-items:center;gap:14px;position:relative;z-index:1}
.lt-header-icon{width:32px;height:32px;border-radius:9px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px;flex-shrink:0}
.lt-header-title{font-size:16px;font-weight:800;color:#fff;line-height:1.25;margin:0}
.lt-header-sub{font-size:11.5px;color:rgba(255,255,255,.65);margin-top:2px}

/* body */
.lt-card-body{padding:22px 26px;background:#fff}

/* footer */
.lt-card-footer{background:#f8fafc;border-top:1px solid #f1f5f9;padding:14px 26px;display:flex;gap:10px;justify-content:flex-end}

/* ── floating-label group ───────────────────────────── */
.lt-fl{position:relative;margin-bottom:0}
.lt-fl-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#cbd5e1;font-size:14px;transition:color .2s;z-index:2;pointer-events:none}
.lt-fl:focus-within .lt-fl-icon{color:#6366f1}

.lt-fl-input{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;background:#fff;outline:none;transition:border-color .2s,box-shadow .2s;-webkit-appearance:none}
.lt-fl-input:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}
.lt-fl-input.is-invalid{border-color:#ef4444}
.lt-fl-input.is-invalid:focus{box-shadow:0 0 0 3.5px rgba(239,68,68,.10)}

.lt-fl-label{position:absolute;left:38px;top:50%;transform:translateY(-50%);font-size:13.5px;color:#94a3b8;pointer-events:none;transition:all .18s ease;background:#fff;padding:0 4px;z-index:1}
.lt-fl-input:focus ~ .lt-fl-label,
.lt-fl-input:not(:placeholder-shown) ~ .lt-fl-label{top:5px;transform:translateY(0);font-size:9.5px;font-weight:700;color:#6366f1}

/* ── select group ───────────────────────────────────── */
.lt-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;color:#475569;margin-bottom:6px;letter-spacing:.4px}
.lt-sel-wrap{position:relative}
.lt-select{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 36px 10px 38px;font-size:13.5px;color:#1e293b;background:#fff;outline:none;-webkit-appearance:none;-moz-appearance:none;appearance:none;cursor:pointer;transition:border-color .2s,box-shadow .2s}
.lt-select:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}
.lt-select.is-invalid{border-color:#ef4444}
.lt-sel-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#cbd5e1;font-size:14px;pointer-events:none;transition:color .2s}
.lt-sel-wrap:focus-within .lt-sel-icon{color:#6366f1}
.lt-sel-chevron{position:absolute;right:12px;top:50%;transform:translateY(-50%);pointer-events:none;color:#94a3b8}

/* ── textarea ───────────────────────────────────────── */
.lt-fl-textarea{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:18px 12px 6px 38px;font-size:13.5px;color:#1e293b;background:#fff;outline:none;resize:vertical;transition:border-color .2s,box-shadow .2s;min-height:68px}
.lt-fl-textarea:focus{border-color:#6366f1;box-shadow:0 0 0 3.5px rgba(99,102,241,.12)}
.lt-fl-textarea:focus ~ .lt-fl-label,
.lt-fl-textarea:not(:placeholder-shown) ~ .lt-fl-label{top:5px;transform:translateY(0);font-size:9.5px;font-weight:700;color:#6366f1}
.lt-fl-textarea ~ .lt-fl-label{top:18px;transform:translateY(0)}
.lt-fl-textarea:focus ~ .lt-fl-label,
.lt-fl-textarea:not(:placeholder-shown) ~ .lt-fl-label{top:5px}

/* ── balance box ────────────────────────────────────── */
.lt-balance-box{border-radius:10px;padding:12px 14px;margin-top:10px;font-size:13px;display:none;border:1px solid transparent;transition:all .25s}
.lt-balance-box.lt-bal-loading{display:block;background:#f8fafc;border-color:#e2e8f0;color:#64748b}
.lt-balance-box.lt-bal-positive{display:block;background:#fef2f2;border-color:#fecaca;color:#dc2626}
.lt-balance-box.lt-bal-negative{display:block;background:#f0fdf4;border-color:#bbf7d0;color:#16a34a}
.lt-balance-box.lt-bal-zero{display:block;background:#f8fafc;border-color:#e2e8f0;color:#64748b}
.lt-bal-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
.lt-bal-title{font-weight:700;font-size:13px}
.lt-bal-text{font-size:12px;margin-top:3px}
.lt-bal-spinner{display:none;width:16px;height:16px;border:2px solid #cbd5e1;border-top-color:#6366f1;border-radius:50%;animation:lt-spin .6s linear infinite}
.lt-bal-loading .lt-bal-spinner{display:inline-block}
@keyframes lt-spin{to{transform:rotate(360deg)}}

/* ── txn hint ───────────────────────────────────────── */
.lt-txn-hint{font-size:11.5px;color:#6b7280;margin-top:6px;min-height:16px}

/* ── error ──────────────────────────────────────────── */
.lt-error{font-size:11.5px;color:#ef4444;margin-top:5px;display:block}

/* ── submit button ──────────────────────────────────── */
.lt-submit{display:inline-flex;align-items:center;gap:8px;padding:10px 28px;border:none;border-radius:9px;background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;font-size:13.5px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.4);position:relative;overflow:hidden;transition:transform .15s,box-shadow .15s}
.lt-submit:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(99,102,241,.45)}
.lt-submit:active{transform:translateY(0);box-shadow:0 2px 8px rgba(99,102,241,.3)}

/* ripple */
.lt-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.35);transform:scale(0);animation:lt-ripple-anim .5s ease-out forwards;pointer-events:none}
@keyframes lt-ripple-anim{to{transform:scale(4);opacity:0}}

/* ── grid row gap ───────────────────────────────────── */
.lt-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.lt-grid .lt-col-full{grid-column:1/-1}
@media(max-width:767px){.lt-grid{grid-template-columns:1fr}}
</style>

<?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'loan-transaction-form',
        'enableClientValidation' => true,
        'clientOptions' => ['validateOnSubmit' => true],
]); ?>

<div class="lt-card">

    <!-- ── Header ────────────────────────────────── -->
    <div class="lt-card-header">
        <div class="lt-header-row">
            <div class="lt-header-icon"><i class="fas fa-right-left"></i></div>
            <div>
                <div class="lt-header-title"><?= $model->isNewRecord ? 'New Transaction' : 'Update Transaction'; ?></div>
                <div class="lt-header-sub">Record a loan give / receive entry</div>
            </div>
        </div>
    </div>

    <!-- ── Body ──────────────────────────────────── -->
    <div class="lt-card-body">
        <div class="lt-grid">

            <!-- Person -->
            <div>
                <label class="lt-label" for="LoanTransactions_person_id">
                    <i class="fas fa-user" style="margin-right:4px;font-size:10px;color:#6366f1"></i> Person
                </label>
                <div class="lt-sel-wrap">
                    <i class="fas fa-user lt-sel-icon"></i>
                    <?= $form->dropDownList(
                            $model, 'person_id',
                            CHtml::listData(LoanPersons::model()->findAll(['order' => 'name ASC']), 'id', 'name'),
                            ['class' => 'lt-select', 'prompt' => 'Select Person']
                    ); ?>
                    <svg class="lt-sel-chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2.5 4.5L6 8l3.5-3.5" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>

                <div id="person-balance-box" class="lt-balance-box">
                    <div class="lt-bal-row">
                        <div>
                            <div class="lt-bal-title" id="balance-title"></div>
                            <div class="lt-bal-text" id="balance-text"></div>
                        </div>
                        <div class="lt-bal-spinner" id="balance-spinner"></div>
                    </div>
                </div>
                <?= $form->error($model, 'person_id', array('class' => 'lt-error')); ?>
            </div>

            <!-- Transaction Type -->
            <div>
                <label class="lt-label" for="LoanTransactions_transaction_type">
                    <i class="fas fa-random" style="margin-right:4px;font-size:10px;color:#6366f1"></i> Transaction Type
                </label>
                <div class="lt-sel-wrap">
                    <i class="fas fa-random lt-sel-icon"></i>
                    <?= $form->dropDownList(
                            $model, 'transaction_type',
                            [
                                    'lend' => 'Gave money — I paid out (দিলাম)',
                                    'borrow' => 'Took / Received money — I got money (নিলাম / পেলাম)',
                            ],
                            ['class' => 'lt-select']
                    ); ?>
                    <svg class="lt-sel-chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2.5 4.5L6 8l3.5-3.5" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="lt-txn-hint" id="txn-hint"></div>
                <?= $form->error($model, 'transaction_type', array('class' => 'lt-error')); ?>
            </div>

            <!-- Amount -->
            <div class="lt-fl">
                <i class="fas fa-money-bill lt-fl-icon"></i>
                <?= $form->textField($model, 'amount', ['class' => 'lt-fl-input', 'placeholder' => ' ', 'autocomplete' => 'off']); ?>
                <label class="lt-fl-label" for="LoanTransactions_amount">Amount</label>
                <?= $form->error($model, 'amount', array('class' => 'lt-error')); ?>
            </div>

            <!-- Transaction Date -->
            <div class="lt-fl">
                <i class="fas fa-calendar lt-fl-icon"></i>
                <?php echo $form->textField($model, 'transaction_date', array('class' => 'lt-fl-input datetimepicker-input', 'placeholder' => ' ', 'value' => $model->isNewRecord ? date('Y-m-d') : $model->transaction_date, 'id' => 'LoanTransactions_transaction_date')); ?>
                <label class="lt-fl-label" for="LoanTransactions_transaction_date">Transaction Date</label>
                <div id="entry_date" data-target-input="nearest"></div>
                <?= $form->error($model, 'transaction_date', array('class' => 'lt-error')); ?>
            </div>

            <!-- Note -->
            <div class="lt-fl lt-col-full">
                <i class="fas fa-pencil lt-fl-icon" style="top:18px;transform:none"></i>
                <?= $form->textArea($model, 'note', ['class' => 'lt-fl-textarea', 'rows' => 2, 'placeholder' => ' ']); ?>
                <label class="lt-fl-label" for="LoanTransactions_note">Note (optional)</label>
                <?= $form->error($model, 'note', array('class' => 'lt-error')); ?>
            </div>

        </div>
    </div>

    <!-- ── Footer ────────────────────────────────── -->
    <div class="lt-card-footer">
        <?php
        if ($model->isNewRecord) {
            echo CHtml::ajaxSubmitButton(
                    $model->isNewRecord ? 'Save Transaction' : 'Update Transaction',
                    CHtml::normalizeUrl(['/loan/loanTransactions/create', 'render' => true]),
                    [
                            'dataType' => 'json',
                            'type' => 'post',

                            'beforeSend' => 'function(){
                $("#ajaxLoader").show();
            }',

                            'success' => 'function(data){
                $("#ajaxLoader").hide();

                if(data.status === "success"){
                    toastr.success("Transaction saved successfully");

                    // reset form only on create
                    if($("#loan-transaction-form").length){
                        $("#loan-transaction-form")[0].reset();
                        $("#loan-transaction-form .lt-fl-input, #loan-transaction-form .lt-select").removeClass("is-invalid");
                        $("#loan-transaction-form .lt-error").html("");
                    }

                    // hide balance box
                    $("#person-balance-box").removeClass("lt-bal-loading lt-bal-positive lt-bal-negative lt-bal-zero");

                    // refresh grid if exists
                    if($.fn.yiiGridView){
                        $.fn.yiiGridView.update("loan-transactions-grid");
                    }
                } else if(data.status === "error" && data.errors){
                    // clear previous errors
                    $("#loan-transaction-form .lt-error").html("");
                    $("#loan-transaction-form .lt-fl-input, #loan-transaction-form .lt-select").removeClass("is-invalid");

                    $.each(data.errors, function(attr, messages){
                        var msg = $.isArray(messages) ? messages[0] : messages;
                        var $err   = $("#err_" + attr);
                        var $field = $("#LoanTransactions_" + attr);
                        if($err.length){
                            $err.html(msg).show();
                        }
                        if($field.length){
                            $field.addClass("is-invalid");
                            $field.one("change input", function(){
                                $(this).removeClass("is-invalid");
                                $err.html("").hide();
                            });
                        }
                    });
                } else {
                    toastr.error("Something went wrong. Please try again.");
                }
            }',

                            'error' => 'function(){
                $("#ajaxLoader").hide();
                toastr.error("Something went wrong. Please try again.");
            }'
                    ],
                    ['class' => 'lt-submit']
            );
        } else {
            echo CHtml::submitButton(
                    $model->isNewRecord ? 'Create' : 'Update',
                    array(
                            'onclick' => 'loadingDivDisplay();',
                            'class' => 'lt-submit'
                    )
            );
        }
        ?>
    </div>

</div>

<?php $this->endWidget(); ?>

<script>
    var picker = new Lightpick({
        field: document.getElementById('LoanTransactions_transaction_date'),
        onSelect: function (date) {
            document.getElementById('LoanTransactions_transaction_date').value = date.format('YYYY-MM-DD');
        }
    });
    var savedDate = '<?php echo CHtml::encode($model->isNewRecord ? date("Y-m-d") : $model->transaction_date); ?>';
    if(savedDate){ picker.setStartDate(moment(savedDate)); }

    $(function () {

        let lastRequest = null;

        function showLoading() {
            const box = $('#person-balance-box');
            box.removeClass('lt-bal-positive lt-bal-negative lt-bal-zero')
               .addClass('lt-bal-loading');

            $('#balance-title').text('Checking balance...');
            $('#balance-text').text('\u09a6\u09c7\u09a8\u09be / \u09aa\u09be\u0993\u09a8\u09be \u09af\u09be\u099a\u09be\u0987 \u0995\u09b0\u09be \u09b9\u099a\u09cd\u099b\u09c7');
        }

        function renderBalance(balance) {
            const box = $('#person-balance-box');
            box.removeClass('lt-bal-loading lt-bal-positive lt-bal-negative lt-bal-zero');

            if (balance > 0) {
                box.addClass('lt-bal-positive');
                $('#balance-title').text('You will receive money');
                $('#balance-text').html('\u09aa\u09be\u09ac\u09c7\u09a8: <b>\u09f3 ' + balance.toFixed(2) + '</b>');
            }
            else if (balance < 0) {
                box.addClass('lt-bal-negative');
                $('#balance-title').text('You need to pay money');
                $('#balance-text').html('\u09a6\u09bf\u09a4\u09c7 \u09b9\u09ac\u09c7: <b>\u09f3 ' + Math.abs(balance).toFixed(2) + '</b>');
            }
            else {
                box.addClass('lt-bal-zero');
                $('#balance-title').text('Balance settled');
                $('#balance-text').text('\u0995\u09cb\u09a8 \u09a6\u09c7\u09a8\u09be / \u09aa\u09be\u0993\u09a8\u09be \u09a8\u09c7\u0987');
            }
        }

        $('#LoanTransactions_person_id').on('change', function () {
            const personId = $(this).val();

            if (!personId) {
                $('#person-balance-box').removeClass('lt-bal-loading lt-bal-positive lt-bal-negative lt-bal-zero');
                return;
            }

            // Cancel previous request if fast switching
            if (lastRequest) {
                lastRequest.abort();
            }

            showLoading();

            lastRequest = $.ajax({
                url: '<?= Yii::app()->createUrl("/loan/loanTransactions/getPersonBalance") ?>',
                type: 'POST',
                dataType: 'json',
                data: { person_id: personId },
                success: function (res) {
                    const balance = parseFloat(res.balance || 0);
                    renderBalance(balance);
                },
                error: function (xhr, status) {
                    if (status !== 'abort') {
                        box.removeClass('lt-bal-loading');
                        toastr.error('Failed to load balance');
                    }
                }
            });
        });

    });

    $(function () {

        function updateTxnHint(val) {
            if (val === 'lend') {
                $('#txn-hint').text('\u0986\u09aa\u09a8\u09bf \u099f\u09be\u0995\u09be \u09a6\u09bf\u099a\u09cd\u099b\u09c7\u09a8 (\u0986\u09aa\u09a8\u09be\u09b0 \u09b9\u09be\u09a4 \u09a5\u09c7\u0995\u09c7 \u09af\u09be\u099a\u09cd\u099b\u09c7)');
            } else if (val === 'borrow') {
                $('#txn-hint').text('\u0986\u09aa\u09a8\u09bf \u099f\u09be\u0995\u09be \u09a8\u09bf\u099a\u09cd\u099b\u09c7\u09a8 / \u09aa\u09be\u099a\u09cd\u099b\u09c7\u09a8 (\u0986\u09aa\u09a8\u09be\u09b0 \u09b9\u09be\u09a4\u09c7 \u0986\u09b8\u099b\u09c7)');
            } else {
                $('#txn-hint').text('');
            }
        }

        // On change
        $('#LoanTransactions_transaction_type').on('change', function () {
            updateTxnHint($(this).val());
        });

        // Initial load
        updateTxnHint($('#LoanTransactions_transaction_type').val());

    });

    // Ripple effect on submit button
    $(document).on('mousedown', '.lt-submit', function(e){
        var $btn = $(this), d = Math.max($btn.outerWidth(), $btn.outerHeight());
        var $r = $('<span class="lt-ripple"></span>').css({width:d,height:d,left:e.pageX-$btn.offset().left-d/2,top:e.pageY-$btn.offset().top-d/2});
        $btn.append($r);
        setTimeout(function(){ $r.remove(); }, 600);
    });
</script>
