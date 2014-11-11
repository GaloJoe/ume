<div class="form">

    <?php
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
            <?php echo $form->label($model, 'data_aprovacao_financiamento'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'Historico[data_aprovacao_financiamento]',
                'language' => 'pt-BR',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'dateFormat' => 'dd/mm/yy',
                    'showAnim' => 'fold',
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            ));
            ?>
        </div><!-- row -->

        <?php
        if ($erro != '')
            echo '<span class="erro displayBlock fontSize16 marginTop5">' . $erro . '</span>';

        echo GxHtml::submitButton(Yii::t('app', 'Confirmar'), array('confirm' => Yii::t('app', 'Are you sure?')));
        $this->endWidget();
        ?>
    </div>
</div><!-- form -->