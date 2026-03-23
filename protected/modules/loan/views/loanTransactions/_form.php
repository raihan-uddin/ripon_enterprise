<?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'loan-transaction-form',
        'enableClientValidation' => true,
        'clientOptions' => ['validateOnSubmit' => true],
]); ?>

<div class="row g-3">

    <div class="col-12 col-md-6">
        <?= $form->labelEx($model, 'person_id'); ?>
        <?= $form->dropDownList(
                $model, 'person_id',
                CHtml::listData(LoanPersons::model()->findAll(['order' => 'name ASC']), 'id', 'name'),
                ['class' => 'form-control', 'prompt' => 'Select Person']
        ); ?>
        <div id="person-balance-box" class="alert mt-2 d-none">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <strong id="balance-title"></strong>
                    <div id="balance-text" class="small mt-1"></div>
                </div>

                <div id="balance-spinner" class="spinner-border spinner-border-sm text-secondary d-none"
                     role="status" aria-hidden="true"></div>
            </div>
        </div>
        <span class="field-error text-danger small" id="err_person_id" style="display:none;"></span>
    </div>

    <div class="col-12 col-md-6">
        <?= $form->labelEx($model, 'transaction_type'); ?>
        <?= $form->dropDownList(
                $model, 'transaction_type',
                [
                        'lend' => 'Gave money — I paid out (দিলাম)',
                        'borrow' => 'Took / Received money — I got money (নিলাম / পেলাম)',
                ],
                ['class' => 'form-control']
        ); ?>
        <small id="txn-hint" class="text-muted mt-1 d-block"></small>
        <span class="field-error text-danger small" id="err_transaction_type" style="display:none;"></span>
    </div>

    <div class="col-12 col-md-6">
        <?= $form->labelEx($model, 'amount'); ?>
        <?= $form->textField($model, 'amount', ['class' => 'form-control', 'placeholder' => '0.00']); ?>
        <span class="field-error text-danger small" id="err_amount" style="display:none;"></span>
    </div>

    <div class="col-12 col-md-6">
        <?= $form->labelEx($model, 'transaction_date'); ?>
        <div class="input-group" id="entry_date" data-target-input="nearest">
            <?php echo $form->textField($model, 'transaction_date', array('class' => 'form-control datetimepicker-input', 'placeholder' => 'YYYY-MM-DD', 'value' => date('Y-m-d'))); ?>
        </div>
        <span class="field-error text-danger small" id="err_transaction_date" style="display:none;"></span>
    </div>

    <div class="col-12">
        <?= $form->label($model, 'note'); ?>
        <?= $form->textArea($model, 'note', ['class' => 'form-control', 'rows' => 2]); ?>
        <span class="field-error text-danger small" id="err_note" style="display:none;"></span>
    </div>

</div>

<div class="text-right mt-3">
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
                    $("#loan-transaction-form .form-control").removeClass("is-invalid");
                    $("#loan-transaction-form .field-error").html("").hide();
                }

                // hide balance box
                $("#person-balance-box").addClass("d-none");

                // refresh grid if exists
                if($.fn.yiiGridView){
                    $.fn.yiiGridView.update("loan-transactions-grid");
                }
            } else if(data.status === "error" && data.errors){
                // clear previous errors
                $("#loan-transaction-form .field-error").html("").hide();
                $("#loan-transaction-form .form-control").removeClass("is-invalid");

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
                ['class' => 'btn btn-primary px-4']
        );
    } else {
        echo CHtml::submitButton(
                $model->isNewRecord ? 'Create' : 'Update',
                array(
                        'onclick' => 'loadingDivDisplay();',
                        'class' => 'btn btn-primary px-4'
                )
        );
    }
    ?>
</div>


<?php $this->endWidget(); ?>
<script>
    var picker = new Lightpick({
        field: document.getElementById('entry_date'),
        minDate: moment(),
        onSelect: function (date) {
            document.getElementById('LoanTransactions_transaction_date').value = date.format('YYYY-MM-DD');
        }
    });

    $(function () {

        let lastRequest = null;

        function showLoading() {
            const box = $('#person-balance-box');
            box
                .removeClass('d-none alert-success alert-danger alert-secondary')
                .addClass('alert-secondary');

            $('#balance-title').text('Checking balance...');
            $('#balance-text').text('দেনা / পাওনা যাচাই করা হচ্ছে');
            $('#balance-spinner').removeClass('d-none');
        }

        function renderBalance(balance) {
            const box = $('#person-balance-box');
            $('#balance-spinner').addClass('d-none');

            box.removeClass('alert-success alert-danger alert-secondary');

            if (balance > 0) {
                box.addClass('alert-danger');
                $('#balance-title').text('You will receive money');
                $('#balance-text').html(`পাবেন: <b>৳ ${balance.toFixed(2)}</b>`);
            }
            else if (balance < 0) {
                box.addClass('alert-success');
                $('#balance-title').text('You need to pay money');
                $('#balance-text').html(`দিতে হবে: <b>৳ ${Math.abs(balance).toFixed(2)}</b>`);
            }
            else {
                box.addClass('alert-secondary');
                $('#balance-title').text('Balance settled');
                $('#balance-text').text('কোন দেনা / পাওনা নেই');
            }
        }

        $('#LoanTransactions_person_id').on('change', function () {
            const personId = $(this).val();

            if (!personId) {
                $('#person-balance-box').addClass('d-none');
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
                        $('#balance-spinner').addClass('d-none');
                        toastr.error('Failed to load balance');
                    }
                }
            });
        });

    });

    $(function () {

        function updateTxnHint(val) {
            if (val === 'lend') {
                $('#txn-hint').text('আপনি টাকা দিচ্ছেন (আপনার হাত থেকে যাচ্ছে)');
            } else if (val === 'borrow') {
                $('#txn-hint').text('আপনি টাকা নিচ্ছেন / পাচ্ছেন (আপনার হাতে আসছে)');
            } else {
                $('#txn-hint').text('');
            }
        }

        // On change
        $('#LoanTransactions_transaction_type').on('change', function () {
            updateTxnHint($(this).val());
        });

        // 🔥 Initial load
        updateTxnHint($('#LoanTransactions_transaction_type').val());

    });
</script>