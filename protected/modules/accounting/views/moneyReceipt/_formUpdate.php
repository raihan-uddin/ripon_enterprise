<?php
/** @var MoneyReceipt $model */
/** @var Customers $customer */
$form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'money-receipt-update-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions'        => array('validateOnSubmit' => true),
));
?>

<div class="row" style="margin-bottom: 10px;">
    <div class="col-xs-12">
        <a class="btn btn-warning" href="<?= Yii::app()->request->requestUri ?>">
            <i class="fa fa-refresh"></i> Reload
        </a>
        <a class="btn btn-success" href="<?= Yii::app()->baseUrl . '/index.php/accounting/moneyReceipt/admin' ?>">
            <i class="fa fa-home"></i> MR Manage
        </a>
    </div>
</div>

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">
            Update Money Receipt &nbsp;
            <span style="font-family: monospace; background: rgba(255,255,255,0.2); padding: 2px 10px; border-radius: 10px;">
                <?= CHtml::encode($model->mr_no) ?>
            </span>
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">

            <!-- Customer (read-only) -->
            <div class="col-md-12">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'customer_id', ['class' => 'col-md-3 col-form-label']); ?>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly
                                   value="<?= CHtml::encode($customer->company_name) ?>">
                            <?php echo $form->hiddenField($model, 'customer_id'); ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MR No (read-only) -->
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">MR No</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly
                                   value="<?= CHtml::encode($model->mr_no) ?>"
                                   style="font-family: monospace; font-weight: bold;">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date -->
            <div class="col-md-12">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'date', ['class' => 'col-md-3 col-form-label']); ?>
                    <div class="col-md-9">
                        <div class="input-group" id="update_entry_date">
                            <?php echo $form->textField($model, 'date', array(
                                'class'       => 'form-control datetimepicker-input',
                                'placeholder' => 'YYYY-MM-DD',
                            )); ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <span class="help-block" style="color:red;">
                            <?php echo $form->error($model, 'date'); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment Type -->
            <div class="col-md-12">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'payment_type', ['class' => 'col-md-3 col-form-label']); ?>
                    <div class="col-md-9">
                        <div class="input-group">
                            <?php echo $form->dropDownList($model, 'payment_type',
                                CHtml::listData(MoneyReceipt::model()->paymentTypeFilter(), 'id', 'title'),
                                array('prompt' => 'Select', 'class' => 'form-control', 'id' => 'update_payment_type')
                            ); ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                            </div>
                        </div>
                        <span class="help-block" style="color:red;">
                            <?php echo $form->error($model, 'payment_type'); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Bank (cheque / online) -->
            <div class="col-md-12 update-bank update-online"
                 style="<?= $model->payment_type == MoneyReceipt::CASH ? 'display:none;' : '' ?>">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'bank_id', ['class' => 'col-md-3 col-form-label']); ?>
                    <div class="col-md-9">
                        <div class="input-group">
                            <?php echo $form->dropDownList($model, 'bank_id',
                                CHtml::listData(CrmBank::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
                                array('prompt' => 'Select Bank', 'class' => 'form-control')
                            ); ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-bank"></i></span>
                            </div>
                        </div>
                        <span class="help-block" style="color:red;">
                            <?php echo $form->error($model, 'bank_id'); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Cheque No -->
            <div class="col-md-12 update-bank"
                 style="<?= $model->payment_type != MoneyReceipt::CHECK ? 'display:none;' : '' ?>">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'cheque_no', ['class' => 'col-md-3 col-form-label']); ?>
                    <div class="col-md-9">
                        <div class="input-group">
                            <?php echo $form->textField($model, 'cheque_no', array('class' => 'form-control')); ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-credit-card-alt"></i></span>
                            </div>
                        </div>
                        <span class="help-block" style="color:red;">
                            <?php echo $form->error($model, 'cheque_no'); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Cheque Date -->
            <div class="col-md-12 update-bank"
                 style="<?= $model->payment_type != MoneyReceipt::CHECK ? 'display:none;' : '' ?>">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'cheque_date', ['class' => 'col-md-3 col-form-label']); ?>
                    <div class="col-md-9">
                        <div class="input-group" id="update_cheque_date">
                            <?php echo $form->textField($model, 'cheque_date', array(
                                'class'       => 'form-control datetimepicker-input',
                                'placeholder' => 'YYYY-MM-DD',
                            )); ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <span class="help-block" style="color:red;">
                            <?php echo $form->error($model, 'cheque_date'); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Amount -->
            <div class="col-md-12">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'amount', ['class' => 'col-md-3 col-form-label']); ?>
                    <div class="col-md-9">
                        <div class="input-group">
                            <?php echo $form->textField($model, 'amount', array(
                                'class'   => 'form-control',
                                'oninput' => 'validatePositiveNumber(this)',
                            )); ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                            </div>
                        </div>
                        <span class="help-block" style="color:red;">
                            <?php echo $form->error($model, 'amount'); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Discount -->
            <div class="col-md-12">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'discount', ['class' => 'col-md-3 col-form-label']); ?>
                    <div class="col-md-9">
                        <div class="input-group">
                            <?php echo $form->textField($model, 'discount', array(
                                'class'   => 'form-control',
                                'oninput' => 'validatePositiveNumber(this)',
                            )); ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                            </div>
                        </div>
                        <span class="help-block" style="color:red;">
                            <?php echo $form->error($model, 'discount'); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Remarks -->
            <div class="col-md-12">
                <div class="form-group row">
                    <?php echo $form->labelEx($model, 'remarks', ['class' => 'col-md-3 col-form-label']); ?>
                    <div class="col-md-9">
                        <div class="input-group">
                            <?php echo $form->textArea($model, 'remarks', array('class' => 'form-control', 'rows' => 3)); ?>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-commenting-o"></i></span>
                            </div>
                        </div>
                        <span class="help-block" style="color:red;">
                            <?php echo $form->error($model, 'remarks'); ?>
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card-footer">
        <?php echo CHtml::submitButton('Update', array('class' => 'btn btn-warning btn-md')); ?>
        <a href="<?= Yii::app()->baseUrl . '/index.php/accounting/moneyReceipt/admin' ?>"
           class="btn btn-default">Cancel</a>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    var updateDatePicker = new Lightpick({
        field: document.getElementById('update_entry_date'),
        onSelect: function(date) {
            document.getElementById('MoneyReceipt_date').value = date.format('YYYY-MM-DD');
        }
    });
    var updateChequeDatePicker = new Lightpick({
        field: document.getElementById('update_cheque_date'),
        onSelect: function(date) {
            document.getElementById('MoneyReceipt_cheque_date').value = date.format('YYYY-MM-DD');
        }
    });

    $('#update_payment_type').on('change', function () {
        var type = parseInt(this.value);
        if (type === <?= MoneyReceipt::CASH ?>) {
            $('.update-bank').hide();
        } else if (type === <?= MoneyReceipt::CHECK ?>) {
            $('.update-bank').show();
            $('.update-online').show();
        } else if (type === <?= MoneyReceipt::ONLINE ?>) {
            $('.update-bank').hide();
            $('.update-online').show();
        } else {
            $('.update-bank').hide();
            $('.update-online').hide();
        }
    });

    function validatePositiveNumber(input) {
        var value = input.value.replace(/^0+/, '').replace(/[^\d.]/g, '').replace(/(\..*)\./g, '$1');
        input.value = value;
        if (parseFloat(value) < 0 || isNaN(parseFloat(value))) {
            input.value = '';
        }
    }
</script>
