<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Deseja realmente excluir este item?')),
    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'Apartamento') . ' ' . GxHtml::encode($model->apartamento0->numero); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'apartamento0',
            'type' => 'raw',
            'value' => GxHtml::encode(GxHtml::valueEx($model->apartamento0)),
        ),
        array(
            'name' => 'bloco',
            'type' => 'raw',
            'value' => GxHtml::encode(GxHtml::valueEx($model->apartamento0->bloco0)),
        ),
        array(
            'name' => 'data',
            'type' => 'raw',
            'value' => $model->formatDate($model->data),
        ),
        array(
            'name' => 'usuario0',
            'type' => 'raw',
            'value' => GxHtml::encode(GxHtml::valueEx($model->usuario0)),
            'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin(),
        ),
        array(
            'name' => 'cliente_nome',
            'type' => 'raw',
            'value' => GxHtml::valueEx($model->cliente_nome),
        ),
        array(
            'name' => 'cliente_cpf',
            'type' => 'raw',
            'value' => GxHtml::valueEx($model->cliente_cpf),
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
    if(Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) {
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
                'value' => $model->valorVenda(),
            ),
            array(
                'name' => 'valor_entrada',
                'type' => 'raw',
                'value' => $model->valorEntrada(),
            ),
            array(
                'name' => 'valor_financiado_construtora',
                'type' => 'raw',
                'value' => $model->financiadoConstrutora(),
            ),
            array(
                'name' => 'valor_financiado_caixa',
                'type' => 'raw',
                'value' => $model->financiadoCaixa(),
            ),
        ),
        'itemCssClass' => array(
            'lista',
            'listaAlt'
        )
    ));
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
                'value' => $model->valorComissaoCorretor(),
            ),
            array(
                'name' => 'valor_comissao_corretor',
                'label' => 'Status',
                'type' => 'raw',
                'value' => $model->statusCorretor(),
            ),
            array(
                'name' => 'data_pagamento_corretor',
                'label' => 'Data',
                'type' => 'raw',
                'value' => $model->formatDate($model->data_pagamento_corretor),
                'visible' => ($model->corretor_pago == 1),
            ),
            array(
                'name' => 'data_pagamento_corretor_meia',
                'label' => 'Data Pgto. Meia',
                'type' => 'raw',
                'value' => $model->formatDate($model->data_pagamento_corretor_meia),
                'visible' => ($model->corretor_pago_meia == 1),
            ),
            array(
                'name' => 'valor_pagamento_adm_vendas',
                'type' => 'raw',
                'value' => $model->valorComissaoAdmVendas(),
            ),
            array(
                'name' => 'data_pagamento_adm_vendas',
                'label' => 'Data',
                'type' => 'raw',
                'value' => $model->formatDate($model->data_pagamento_adm_vendas),
                'visible' => ($model->adm_vendas_pago == 1),
            ),
            array(
                'name' => 'valor_comissao_corretor',
                'label' => 'Status',
                'type' => 'raw',
                'value' => $model->statusAdmVendas(),
            ),
        ),
        'itemCssClass' => array(
            'lista',
            'listaAlt'
        )
    ));
}
?>