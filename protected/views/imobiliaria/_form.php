<div class="form">


    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'imobiliaria-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'nome'); ?>
        <?php echo $form->textField($model, 'nome', array('maxlength' => 50)); ?>
        <?php echo $form->error($model, 'nome'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'endereco'); ?>
        <?php echo $form->textField($model, 'endereco', array('maxlength' => 200)); ?>
        <?php echo $form->error($model, 'endereco'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'telefone'); ?>
        <?php
        $this->widget('system.web.widgets.CMaskedTextField', array(
            'model' => $model,
            'attribute' => 'telefone',
            'mask' => '(99)9999-9999')
        );
        ?>
        <?php echo $form->error($model, 'telefone'); ?>
    </div><!-- row -->

    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->