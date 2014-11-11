<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'recibo-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'empreiteiro'); ?>
		<?php echo $form->dropDownList($model, 'empreiteiro', GxHtml::listDataEx(Usuario::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'empreiteiro'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'data_inicial'); ?>
		<?php echo $form->textField($model, 'data_inicial'); ?>
		<?php echo $form->error($model,'data_inicial'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'data_final'); ?>
		<?php echo $form->textField($model, 'data_final'); ?>
		<?php echo $form->error($model,'data_final'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'usuario'); ?>
		<?php echo $form->dropDownList($model, 'usuario', GxHtml::listDataEx(Usuario::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'usuario'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ativo'); ?>
		<?php echo $form->textField($model, 'ativo'); ?>
		<?php echo $form->error($model,'ativo'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('historicoAtividades')); ?></label>
		<?php echo $form->checkBoxList($model, 'historicoAtividades', GxHtml::encodeEx(GxHtml::listDataEx(HistoricoAtividade::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('retencaos')); ?></label>
		<?php echo $form->checkBoxList($model, 'retencaos', GxHtml::encodeEx(GxHtml::listDataEx(Retencao::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->