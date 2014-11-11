<div class="form">

    <?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '#valor',
        'config' => array(
            'symbol' => 'R$',
            'showSymbol' => true,
            'symbolStay' => true,
            'decimal' => ',',
            'thousands' => '.'
        )
    ));

    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'historico-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'numero'); ?>
        <?php echo $form->textField($model, 'numero'); ?>
        <?php echo $form->error($model, 'numero'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'descricao'); ?>
        <?php echo $form->textField($model, 'descricao', array('maxlength' => 100)); ?>
        <?php echo $form->error($model, 'descricao'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'metragem'); ?>
        <?php echo $form->textField($model, 'metragem', array('maxlength' => 20)); ?>
        <?php echo $form->error($model, 'metragem'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'valor'); ?>
        <?php echo $form->textField($model, 'valor', array('id' => 'valor')); ?>
        <?php echo $form->error($model, 'valor'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'bloco'); ?>
        <?php
        $condition = '';
        if (isset($bloco) && $bloco > 0) {
            $condition = 'id = ' . $bloco;
        }
        ?>
        <?php echo $form->dropDownList($model, 'bloco', GxHtml::listDataEx(Bloco::model()->findAllAttributes(null, true, $condition))); ?>
        <?php echo $form->error($model, 'bloco'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'andar'); ?>
        <?php
        $condition = '';
        if (isset($bloco) && $bloco > 0) {
            $condition = 'bloco = ' . $bloco;
        }
        ?>
        <?php echo $form->dropDownList($model, 'andar', GxHtml::listDataEx(Andar::model()->findAllAttributes(null, true, $condition))); ?>
        <?php echo $form->error($model, 'andar'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'box_estacionamento'); ?>
        <?php echo $form->textField($model, 'box_estacionamento'); ?>
        <?php echo $form->error($model, 'box_estacionamento'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'disponivel'); ?>
        <?php echo $form->checkBox($model, 'disponivel'); ?>
        <?php echo $form->error($model, 'disponivel'); ?>
    </div>

    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->