<div class="form">


    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'retencao-form',
        'enableAjaxValidation' => false,
    ));

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
    ?>

    <?php echo '<p><span class="erro displayBlock fontSize16 marginTop5">Valor restante a pagar: ' . 'R$' . number_format($valorPagar, 2, ',', '') . '</span></p>'; ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'valor'); ?>
        <?php echo $form->textField($model, 'valor', array('id' => 'valor')); ?>
        <?php echo $form->error($model, 'valor'); ?>
    </div><!-- row -->

    <?php
        if ($erro != '')
            echo '<span class="erro displayBlock fontSize16 marginTop5">' . $erro . '</span>';
        
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->