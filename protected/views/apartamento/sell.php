<div class="form">

    <?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '#valor_entrada,#valor_financiado_construtora,#valor_financiado_caixa',
        'config' => array(
            'symbol' => 'R$',
            'showSymbol' => true,
            'symbolStay' => true,
            'decimal' => ',',
            'thousands' => '.'
        )
    ));

    //--------------------------------------------------------------
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model->apartamento0,
        'attributes' => array(
            'numero',
            'descricao',
            'metragem',
            array(
                'name' => 'Valor',
                'value' => function($data) {
            return 'R$' . number_format($data->valor, 2, ',', '.');
        },
            ),
            array(
                'name' => 'bloco0',
                'type' => 'raw',
                'value' => $model->apartamento0->bloco0 !== null ? GxHtml::encode(GxHtml::valueEx($model->apartamento0->bloco0)) : null,
            ),
            'box_estacionamento',
        ),
        'itemCssClass' => array(
            'lista',
            'listaAlt'
        )
    ));
    //--------------------------------------------------------------
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'apartamento-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>
    <div class="textAlignCenter">
        <div class="row">
            <?php echo $form->labelEx($model, 'valor_entrada'); ?>
            <?php echo $form->textField($model, 'valor_entrada', array('id' => 'valor_entrada')); ?>
            <?php echo $form->error($model, 'valor_entrada'); ?>
        </div><!-- row -->

        <div class="row">
            <?php echo $form->labelEx($model, 'valor_financiado_construtora'); ?>
            <?php echo $form->textField($model, 'valor_financiado_construtora', array('id' => 'valor_financiado_construtora')); ?>
            <?php echo $form->error($model, 'valor_financiado_construtora'); ?>
        </div><!-- row -->

        <div class="row">
            <?php echo $form->labelEx($model, 'valor_financiado_caixa'); ?>
            <?php echo $form->textField($model, 'valor_financiado_caixa', array('id' => 'valor_financiado_caixa')); ?>
            <?php echo $form->error($model, 'valor_financiado_caixa'); ?>
        </div><!-- row -->
        
        <div class="row">
            <?php echo $form->labelEx($model, 'cliente_nome'); ?>
            <?php echo $form->textField($model, 'cliente_nome', array('id' => 'cliente_nome')); ?>
            <?php echo $form->error($model, 'cliente_nome'); ?>
        </div><!-- row -->

        <div class="row">
            <?php echo $form->labelEx($model, 'cliente_cpf'); ?>
            <?php echo $form->textField($model, 'cliente_cpf', array('id' => 'cliente_cpf')); ?>
            <?php echo $form->error($model, 'cliente_cpf'); ?>
        </div><!-- row -->

        <?php
        if ($erro != '')
            echo '<span class="erro displayBlock fontSize16 marginTop5">' . $erro . '</span>';

        echo GxHtml::submitButton(Yii::t('app', 'Vender'), array('confirm' => Yii::t('app', 'Are you sure?')));
        $this->endWidget();
        ?>
    </div>
</div><!-- form -->