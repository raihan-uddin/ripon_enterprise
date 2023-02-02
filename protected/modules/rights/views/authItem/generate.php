<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Generate items'),
); ?>

<div id="generator">

	<h2><?php echo Rights::t('core', 'Generate items'); ?></h2>

	<p><?php echo Rights::t('core', 'Please select which items you wish to generate.'); ?></p>
    <div>
        <input type='text' id='search' placeholder='Search Text' class="text-field form-control" style="width: 30%;">
    </div>
	<div class="form">

		<?php $form=$this->beginWidget('CActiveForm'); ?>

			<div class="row">
                <div class="table table-responsive">
				<table class="items generate-item-table table table-bordered table-hover table-borderless table-striped" border="0" cellpadding="0" cellspacing="0">

					<tbody>

						<tr class="application-heading-row">
							<th colspan="3"><?php echo Rights::t('core', 'Application'); ?></th>
						</tr>

						<?php $this->renderPartial('_generateItems', array(
							'model'=>$model,
							'form'=>$form,
							'items'=>$items,
							'existingItems'=>$existingItems,
							'displayModuleHeadingRow'=>true,
							'basePathLength'=>strlen(Yii::app()->basePath),
						)); ?>

					</tbody>

				</table>
            </div>

			</div>

			<div class="row">

   				<?php echo CHtml::link(Rights::t('core', 'Select all'), '#', array(
   					'onclick'=>"jQuery('.generate-item-table').find(':checkbox').attr('checked', 'checked'); return false;",
   					'class'=>'selectAllLink')); ?>
   				/
				<?php echo CHtml::link(Rights::t('core', 'Select none'), '#', array(
					'onclick'=>"jQuery('.generate-item-table').find(':checkbox').removeAttr('checked'); return false;",
					'class'=>'selectNoneLink')); ?>

			</div>

   			<div class="row">

				<?php echo CHtml::submitButton(Rights::t('core', 'Generate'), ['class' => 'btn btn-success']); ?>

			</div>

		<?php $this->endWidget(); ?>

	</div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#search').keyup(function(){
                // Search text
                var text = $(this).val();

                text = text.replace(/\//g, '.');

                // Hide all content class element
                $('.items tbody tr').hide();

                // Search
                $('.items tbody tr:contains("'+text+'")').closest('tr').show();
            });
        });

        $.expr[":"].contains = $.expr.createPseudo(function(arg) {
            return function( elem ) {
                return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });

    </script>


</div>