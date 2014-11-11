<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Geral'), 'url' => array('rel', 'idEmpreendimento' => $model->empreendimento)),
    array('label' => Yii::t('app', 'Disponíveis'), 'url' => array('listAvailable', 'idEmpreendimento' => $model->empreendimento)),
    array('label' => Yii::t('app', 'Reservados'), 'url' => array('listReserved', 'idEmpreendimento' => $model->empreendimento)),
    array('label' => Yii::t('app', 'Em Contratação'), 'url' => array('listHiring', 'idEmpreendimento' => $model->empreendimento)),
    array('label' => Yii::t('app', 'Permutados'), 'url' => array('listExchanged', 'idEmpreendimento' => $model->empreendimento)),
    array('label' => Yii::t('app', 'Vendidos'), 'url' => array('listSold', 'idEmpreendimento' => $model->empreendimento)),
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
        $dataAtual = $model->formatDate($model->getData());
        $this->widget('application.extensions.print.printWidget', array(
            'coverElement'=>'#content',
            'printedElement'=>'#apartamento-total-rel-grid, #apartamento-rel-grid, #apartamento-modulo-rel-grid, .showPrint',
            'title'=>'Relatório mensal (' . $dataAtual . ')',
        ));
    ?>
</div>
<br/>
<h2><?php echo Yii::t('app', 'Bloco') ?> </h2>
<br/>
<div class="floatRight showPrint">
     <span id="legenda"><b>(R)</b>: Reservado <b>(EC)</b>: Em Contratação <b>(P)</b>: Permutado <b>(V)</b>: Vendido <b>(FA)</b>: Financiamento Aprovado</span>
</div>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'apartamento-total-rel-grid',
    'summaryText' => '',
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'dataProvider' => $model->searchTotals(),
    'columns' => array(
        array(
            'header' => 'Bloco',
            'name' => 'bloco',
            'value' => 'Yii::t(\'app,\', $data->getBloco())',
            'footer' => 'Total',
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Valor Total',
            'value' => 'Yii::t(\'app\', $data->valorVendaTotal())',
            'footer' => $model->getTotal('valor_venda', $model->search()->getKeys()),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Valor entrada',
            'value' => 'Yii::t(\'app\', $data->valorEntradaTotal())',
            'footer' => $model->getTotal('valor_entrada', $model->search()->getKeys()),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Comissão corretor',
            'value' => 'Yii::t(\'app\', $data->valorComissaoCorretorTotal())',
            'footer' => $model->getTotalComissaoCorretor(),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Comissão Adm. Vendas',
            'value' => 'Yii::t(\'app\', $data->valorComissaoAdmVendasTotal())',
            'footer' => $model->getTotalComissaoAdm(),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Financiado Construtora',
            'value' => 'Yii::t(\'app\', $data->financiadoConstrutoraTotal())',
            'footer' => $model->getTotal('valor_financiado_construtora', $model->search()->getKeys()),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Financiado Caixa',
            'value' => 'Yii::t(\'app\', $data->financiadoCaixaTotal())',
            'footer' => $model->getTotal('valor_financiado_caixa', $model->search()->getKeys()),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'R',
            'value' => 'Yii::t(\'app\', $data->getTotalReservados())',
            'footer'=>$model->getTotalStatus('Reservado'),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'EC',
            'value' => 'Yii::t(\'app\', $data->getTotalEmContratacao())',
            'footer'=>$model->getTotalStatus('Em Contratação'),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'P',
            'value' => 'Yii::t(\'app\', $data->getTotalPermutados())',
            'footer'=>$model->getTotalStatus('Permutado'),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'V',
            'value' => 'Yii::t(\'app\', $data->getTotalVendidos())',
            'footer'=>$model->getTotalStatus('Vendido'),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'FA',
            'value' => 'Yii::t(\'app\', $data->getTotalFinanciamentoAprovado())',
            'footer'=>$model->getTotalStatus('Vendido', true),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
    ),
));

?>

<br/>
<h2><?php echo Yii::t('app', 'Modulo') ?> </h2>

<div class="floatRight showPrint">
     <span id="legenda"><b>(R)</b>: Reservado <b>(EC)</b>: Em Contratação <b>(P)</b>: Permutado <b>(V)</b>: Vendido <b>(FA)</b>: Financiamento Aprovado</span>
</div>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'apartamento-modulo-rel-grid',
    'summaryText' => '',
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'dataProvider' => $model->searchTotalsByModulo(),
    'columns' => array(
        array(
            'header' => 'Modulo',
            'name' => 'modulo',
            'value' => 'Yii::t(\'app,\', $data->getModulo())',
            'footer' => 'Total',
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Valor Total',
            'value' => 'Yii::t(\'app\', $data->valorVendaTotal())',
            'footer' => $model->getTotal('valor_venda', $model->search()->getKeys()),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Valor entrada',
            'value' => 'Yii::t(\'app\', $data->valorEntradaTotal())',
            'footer' => $model->getTotal('valor_entrada', $model->search()->getKeys()),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Comissão corretor',
            'value' => 'Yii::t(\'app\', $data->valorComissaoCorretorTotal())',
            'footer' => $model->getTotalComissaoCorretor(),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Comissão Adm. Vendas',
            'value' => 'Yii::t(\'app\', $data->valorComissaoAdmVendasTotal())',
            'footer' => $model->getTotalComissaoAdm(),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Financiado Construtora',
            'value' => 'Yii::t(\'app\', $data->financiadoConstrutoraTotal())',
            'footer' => $model->getTotal('valor_financiado_construtora', $model->search()->getKeys()),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Financiado Caixa',
            'value' => 'Yii::t(\'app\', $data->financiadoCaixaTotal())',
            'footer' => $model->getTotal('valor_financiado_caixa', $model->search()->getKeys()),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'R',
            'value' => 'Yii::t(\'app\', $data->getTotalReservados())',
            'footer'=>$model->getTotalStatus('Reservado'),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'EC',
            'value' => 'Yii::t(\'app\', $data->getTotalEmContratacao())',
            'footer'=>$model->getTotalStatus('Em Contratação'),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'P',
            'value' => 'Yii::t(\'app\', $data->getTotalPermutados())',
            'footer'=>$model->getTotalStatus('Permutado'),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'V',
            'value' => 'Yii::t(\'app\', $data->getTotalVendidos())',
            'footer'=>$model->getTotalStatus('Vendido'),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'FA',
            'value' => 'Yii::t(\'app\', $data->getTotalFinanciamentoAprovado())',
            'footer'=>$model->getTotalStatus('Vendido', true),
            'footerHtmlOptions' => array('style' => 'text-align: center;'),
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
    ),
));

?>

<br/>
<h2><?php echo Yii::t('app', 'Apartamento') ?> </h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'apartamento-rel-grid',
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
//        array(
//            'header' => 'Empreendimento',
//            'name' => 'empreendimento',
//            'value' => 'GxHtml::valueEx($data->apartamento0->bloco0->empreendimento0)',
//            'filter' => GxHtml::listDataEx(Empreendimento::model()->findAllAttributes(null, true)),
//        ),
        array(
            'header' => 'Bloco',
            'name' => 'bloco',
            'value' => 'Yii::t(\'app\', $data->getBloco())',
            'filter' => GxHtml::listDataEx(Bloco::model()->findAllAttributes(null, true)),
            'htmlOptions'=>array('style' => 'text-align: center;')
        ),
        array(
            'name' => 'numero',
            'htmlOptions'=>array('style' => 'text-align: center;'),
        ),
        array(
            'header' => 'Data (venda/reserva)',
            'value' => '$data->getDataEfetivaSemHoras()',
            'htmlOptions'=>array('style' => 'text-align: center;'),
        ),
        array(
            'header' => 'Cliente',
            'value' => 'Yii::t(\'app\', $data->getCliente())',
        ),
        array(
            'header' => 'Valor Total',
            'value' => 'Yii::t(\'app\', $data->getValorVenda())',
        ),
        array(
            'header' => 'Valor entrada',
            'value' => 'Yii::t(\'app\', $data->getValorEntrada())',
        ),
        array(
            'header' => 'Comissão corretor',
            'value' => 'Yii::t(\'app\', $data->getStatusComissaoCorretor())',
        ),
        array(
            'header' => 'Comissão Adm. Vendas',
            'value' => 'Yii::t(\'app\', $data->getStatusComissaoAdm())',
        ),
        array(
            'header' => 'Financiado Construtora',
            'value' => 'Yii::t(\'app\', $data->getValorConstrutora())',
        ),
        array(
            'header' => 'Financiado Caixa',
            'value' => 'Yii::t(\'app\', $data->getValorCaixa())',
        ),
        array(
            'header' => 'Status',
            'value' => '$data->getStatus()',
        ),
        array(
            'header' => Yii::t('app', 'Detail'),
            'class' => 'CButtonColumn',
            'viewButtonUrl' => 'Yii::app()->createUrl("/apartamento/detail", array("id"=>$data["id"]))',
            'viewButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'view.png',
            'template' => '{view}',
        ),
    ),
));

?>