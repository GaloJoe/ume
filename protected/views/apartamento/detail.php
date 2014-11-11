<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

?>

<h1><?php echo GxHtml::encode($model->bloco0->descricao) . ' - ' . Yii::t('app', 'Apartamento') . ' ' . GxHtml::encode($model->numero); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'apartamento',
            'type' => 'raw',
            'value' => $model->numero,
        ),
        array(
            'name' => 'bloco',
            'type' => 'raw',
            'value' => $model->bloco0->descricao,
        ),
        array(
            'name' => 'data',
            'type' => 'raw',
            'value' => $model->dataEfetiva,
            'visible' => $model->isSold() || $model->isReserved(),
        ),
        array(
            'name' => 'corretor',
            'type' => 'raw',
            'value' => $model->corretor,
            'visible' => $model->isSold() || $model->isReserved(),
        ),
        'status',
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));
?>

<?php
if($model->isSold() || $model->isReserved()) {
?>

<p>
    <h1><?php echo Yii::t('app', 'Cliente') ?></h1>
</p>

<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'name' => 'cliente_nome',
                'label' => 'Nome',
                'type' => 'raw',
                'value' => $model->cliente,
            ),
            array(
                'name' => 'cliente_cpf',
                'label' => 'CPF',
                'type' => 'raw',
                'value' => $model->clienteCpf,
            ),
        ),
        'itemCssClass' => array(
            'lista',
            'listaAlt'
        )
    ));
}
?>
<p>
    <h1><?php echo Yii::t('app', 'Values') ?></h1>
</p>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'valor',
            'type' => 'raw',
            'value' => 'R$' . number_format($model->valor, 2, ',', '.'),
        ),
        array(
            'name' => 'valor_entrada',
            'type' => 'raw',
            'value' => $model->valorEntrada,
            'visible' => $model->isSold(),
        ),
        array(
            'name' => 'valor_financiado_construtora',
            'type' => 'raw',
            'value' => $model->valorConstrutora,
            'visible' => $model->isSold(),
        ),
        array(
            'name' => 'valor_financiado_caixa',
            'type' => 'raw',
            'value' => $model->valorCaixa,
            'visible' => $model->isSold(),
        ),
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));
?>

<?php
if($model->isSold()) {
?>

<p>
    <h1><?php echo Yii::t('app', 'Comissions') ?></h1>
</p>

<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'name' => 'valor_comissao_corretor',
                'type' => 'raw',
                'value' => $model->valorCorretor,
            ),
            array(
                'name' => 'valor_comissao_corretor',
                'label' => 'Status',
                'type' => 'raw',
                'value' => $model->statusComissaoCorretor,
            ),
            array(
                'name' => 'data_pagamento_corretor',
                'label' => 'Data',
                'type' => 'raw',
                'value' => $model->dataPagamentoCorretor,
    //            'visible' => ($model->corretor_pago == 1),
            ),
            array(
                'name' => 'data_pagamento_corretor_meia',
                'label' => 'Data Pgto. Meia',
                'type' => 'raw',
                'value' => $model->dataPagamentoCorretorMeia,
    //            'visible' => ($model->corretor_pago_meia == 1),
            ),
            array(
                'name' => 'valor_pagamento_adm_vendas',
                'type' => 'raw',
                'value' => $model->valorAdmVendas,
            ),
            array(
                'name' => 'data_pagamento_adm_vendas',
                'label' => 'Data',
                'type' => 'raw',
                'value' => $model->dataPagamentoAdm,
    //            'visible' => ($model->adm_vendas_pago == 1),
            ),
            array(
                'name' => 'valor_comissao_corretor',
                'label' => 'Status',
                'type' => 'raw',
                'value' => $model->statusComissaoAdm,
            ),
        ),
        'itemCssClass' => array(
            'lista',
            'listaAlt'
        )
    ));
}
?>