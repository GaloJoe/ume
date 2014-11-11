<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
//    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
//    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form').hide();
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('empreendimento-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo GxHtml::encode($model->label(2)); ?></h1>

<div>
    <?php
    $this->widget('application.extensions.print.printWidget', array(
        'coverElement' => '#content',
        'printedElement' => '#historico-grid, .showPrint',
        'title' => 'Históricos',
    ));
    ?>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'historico-grid',
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'dataProvider' => $model->search(),
    'filter' => (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) ? $model : null,
    'columns' => array(
        array(
            'header' => 'Bloco',
            'name' => 'bloco',
            'value' => 'Yii::t(\'app\', $data->getBloco())',
            'filter' => GxHtml::listDataEx(Bloco::model()->findAllAttributes(null, true)),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Apartamento',
            'name' => 'apartamento',
            'value' => '$data->apartamento0->numero',
            'filter' => '',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Data efetiva',
            'name' => 'data',
            'value' => '$data->formatDate($data->data)',
            'htmlOptions'=>array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Cliente',
            'name' => 'cliente_nome',
            'value' => '$data->cliente_nome',
        ),
        array(
            'header' => 'CPF',
            'name' => 'cliente_cpf',
            'value' => '$data->cliente_cpf',
            'visible' => !Yii::app()->user->isMaster() && !Yii::app()->user->isAdmin(),
        ),
        array(
            'header' => 'Corretor',
            'name' => 'usuario',
            'value' => 'GxHtml::valueEx($data->usuario0)',
            'filter' => GxHtml::listDataEx(Usuario::model()->findAllAttributes(null, true)),
            'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin() || Yii::app()->user->isChefe(),
        ),
        'status',
        array(
            'header' => 'Corretor',
            'name' => 'corretor_pago',
            'value' => 'Yii::t(\'app\', $data->statusCorretor())',
            'filter' => '',
            'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin(),
        ),
        array(
            'header' => 'Imobiliária',
            'name' => 'imobiliaria',
            'value' => 'Yii::t(\'app\', $data->getImobiliaria())',
            'filter' => GxHtml::listDataEx(Imobiliaria::model()->findAllAttributes(null, true)),
            'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin(),
        ),
        array(
            'header' => 'Adm. de Vendas',
            'name' => 'adm_vendas_pago',
            'value' => 'Yii::t(\'app\', $data->statusAdmVendas())',
            'filter' => '',
            'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin(),
        ),
        array(
            'header' => 'Valor entrada',
            'name' => 'valor_entrada',
            'value' => '$data->valorEntrada()',
            'filter' => '',
            'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin(),
        ),
        array(
            'header' => 'Financiado Construtora',
            'name' => 'valor_financiado_construtora',
            'value' => '$data->financiadoConstrutora()',
            'filter' => '',
            'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin(),
        ),
        array(
            'header' => 'Financiado Caixa',
            'name' => 'valor_financiado_caixa',
            'value' => '$data->financiadoCaixa()',
            'filter' => '',
            'visible' => Yii::app()->user->isMaster() || Yii::app()->user->isAdmin(),
        ),
        array(
            'header' => Yii::t('app', 'Detail'),
            'class' => 'CButtonColumn',
            'viewButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'view.png',
            'template' => '{view}',
        ),
    ),
));
?>