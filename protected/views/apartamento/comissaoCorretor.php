<div class="form">

    <?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '#valor_pago_corretor',
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
        'id' => 'historico-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="textAlignCenter">
        <div class="row">
            <?php $valorPago = '(' . $model->statusCorretor() . ')';
            $model->valor_pago_corretor = null;
            ?>
            
            <?php echo $form->labelEx($model, 'O valor será acrescido ao já pago'); ?>
            <?php echo $valorPago . '<br>'; ?>
            <?php echo $form->textField($model, 'valor_pago_corretor', array('id' => 'valor_pago_corretor')); ?>
            <?php echo $form->error($model, 'valor_pago_corretor'); ?>
        </div><!-- row -->

        <?php
        if ($erro != '')
            echo '<span class="erro displayBlock fontSize16 marginTop5">' . $erro . '</span>';

        echo GxHtml::submitButton(Yii::t('app', 'Pagar Corretor'), array('confirm' => Yii::t('app', 'Are you sure?')));
        $this->endWidget();
        ?>
    </div>
</div><!-- form -->