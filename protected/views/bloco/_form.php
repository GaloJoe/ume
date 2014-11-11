<div class="form">


    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'bloco-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'descricao'); ?>
        <?php echo $form->textField($model, 'descricao', array('maxlength' => 100)); ?>
        <?php echo $form->error($model, 'descricao'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'empreendimento'); ?>
        <?php echo $form->dropDownList($model, 'empreendimento', GxHtml::listDataEx(Empreendimento::model()->findAllAttributes(null, true))); ?>
        <?php echo $form->error($model, 'empreendimento'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'disponivel'); ?>
        <?php echo $form->checkBox($model, 'disponivel'); ?>
        <?php echo $form->error($model, 'disponivel'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'modulo'); ?>
        <?php echo $form->dropDownList($model, 'modulo', GxHtml::listDataEx(Modulo::model()->findAllAttributes(null, true)), array('prompt'=>'')); ?>
        <?php echo $form->error($model, 'modulo'); ?>
    </div><!-- row -->

    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->