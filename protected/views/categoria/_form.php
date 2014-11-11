<div class="form">

    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'categoria-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="row">
        <?php echo $form->labelEx($model, 'empreendimento'); ?>
        <?php echo $form->dropDownList($model, 'empreendimento', GxHtml::listDataEx(Empreendimento::model()->findAllAttributes(null, true))); ?>
        <?php echo $form->error($model, 'empreendimento'); ?>
    </div><!-- row -->

    <div class="row">
        <?php echo $form->labelEx($model, 'descricao'); ?>
        <?php echo $form->textField($model, 'descricao', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'descricao'); ?>
    </div><!-- row -->
    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->