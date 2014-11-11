<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
//    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
//    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Deseja realmente excluir este item?')),
//    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
//    array('label' => Yii::t('app', 'Registrar entrada'), 'url' => array('movimentacao/create&tm=1'), 'visible' => !$model->isFully()),
//    array('label' => Yii::t('app', 'Registrar saída'), 'url' => array('movimentacao/create&tm=2'), 'visible' => !$model->isUtilized()),
);
?>

<h1><?php echo GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<!-- Botoes para registrar entrada/consumo do material -->
<?php
if (!$model->isFully() || !$model->isUtilized()) {
    echo '<div class="textAlignCenter"><p>';
    if (!$model->isFully()) {
        echo GxHtml::link('Registrar compra', array('movimentacao/create&tm=1&mat=' . $model->id), array('class' => 'greyLinkButton'));
    }
    echo '&nbsp;';
    if (!$model->isUtilized()) {
        echo GxHtml::link('Registrar utilização', array('movimentacao/create&tm=2&mat=' . $model->id), array('class' => 'greyLinkButton'));
    }
    echo '</p></div>';
}
?>
<!-- Fim botoes -->

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'descricao',
        'consumo',
        array(
            'name' => 'categoria0',
            'type' => 'raw',
            'value' => $model->categoria0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->categoria0)), array('categoria/view', 'id' => GxActiveRecord::extractPkValue($model->categoria0, true))) : null,
        ),
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));

$now = $model->getData();

echo '<div class="textAlignRight">';
$this->widget('application.extensions.print.printWidget', array(
    'coverElement' => '#content',
    'printedElement' => '#movimentacoes, .showPrint',
    'title' => $now . '<br/>Relatório ' . $model->descricao,
));
echo '</div>';

$this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'BarChart',
    'data' => $chartData,
    'options' => array('title' => 'Consumo',
        'legend' => array('position' => 'bottom', 'textStyle' => array('fontSize' => '40'))
    ),
    'htmlOptions' => array('class' => 'showPrint')
));

if ($model->movimentacoes != null) {
    echo '<div id="movimentacoes">';
    echo '<hr><h3>Movimentações</h3>';
    echo '<table width="100%">';
    echo '<tr>';
    echo '<th class="headerBorder">Data</td>';
    echo '<th class="headerBorder">Tipo Movimentação</th>';
    echo '<th class="headerBorder">Quantidade</th>';
    echo '<th class="headerBorder">Descrição</th>';
    echo '<th class="headerBorder">Usuário</th>';
    if (Yii::app()->user->isMaster()) {
        echo '<th class="headerBorder hidePrint">Ações</th>';
    }
    echo '</tr>';
    foreach ($model->movimentacoes as $movimentacao) {
        if ($movimentacao->ativo == 1) {
            $tipoMovimentacao = $movimentacao->tipo_movimentacao == TipoMovimentacaoEnum::ENTRADA ? 'Compra' : 'Utilização';
            echo '<tr>';
            echo '<td class="insideBorder">' . $movimentacao->getDataFormatada() . '</td>';
            echo '<td class="insideBorder">' . $tipoMovimentacao . '</td>';
            echo '<td class="insideBorder">' . $movimentacao->quantidade . '</td>';
            echo '<td class="insideBorder">' . $movimentacao->descricao . '</td>';
            echo '<td class="insideBorder">' . $movimentacao->usuario0->nome . '</td>';
            if (Yii::app()->user->isMaster()) {
                echo '<td class="insideBorder textAlignCenter hidePrint">' .
                CHtml::link('<img src="css/delete.png" alt="Remover" />', array('movimentacao/delete', 'id' => $movimentacao->id, 'mat' => $model->id), array('confirm' => Yii::t('app', 'Are you sure?')))
                . '</td>';
            }
            echo '</tr>';
        }
    }
    echo '</table>';
    echo '</div>';
}
?>
