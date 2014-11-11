<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'andar-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'descricao'); ?>
		<?php echo $form->textField($model, 'descricao', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'descricao'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'bloco'); ?>
		<?php echo $form->dropDownList($model, 'bloco', GxHtml::listDataEx(Bloco::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'bloco'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'posicao'); ?>
		<?php echo $form->textField($model, 'posicao'); ?>
		<?php echo $form->error($model,'posicao'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'ativo'); ?>
		<?php echo $form->textField($model, 'ativo'); ?>
		<?php echo $form->error($model,'ativo'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('apartamentos')); ?></label>
		<?php echo $form->checkBoxList($model, 'apartamentos', GxHtml::encodeEx(GxHtml::listDataEx(Apartamento::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->