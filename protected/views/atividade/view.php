<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin', 'emp' => $empreendimento)),
);
?>

<h1><?php echo GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<!-- Botoes para registrar atividade -->
<?php
echo '<div class="textAlignCenter"><p>';
    $historicoAtividade = HistoricoAtividade::model();
    if ($historicoAtividade->hasSaved($model->unidadeMedida->empreendimento0->id, $model->id) && $model->unidadeMedida->tipoUnidadeMedida == TipoUnidadeMedidaEnum::EMPREENDIMENTO) {
        echo '<span class="reserved">Atividade já registrada</span>';
    } else {
        echo GxHtml::link('Registrar atividade', array('historicoAtividade/create&a=' . $model->id), array('class' => 'greyLinkButton'));
    }
    
echo '</p></div>';
?>
<!-- Fim botoes -->

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'unidadeMedida',
            'type' => 'raw',
            'value' => $model->unidadeMedida !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->unidadeMedida)), array('unidadeMedida/view', 'id' => GxActiveRecord::extractPkValue($model->unidadeMedida, true))) : null,
        ),
        'descricao',
        array(
            'name' => 'Valor Unitário',
            'value' => function($data) {
        return 'R$' . number_format($data->valor_unitario, 2, ',', '.');
    },
        ),
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));
?>

<h2><?php // echo GxHtml::encode($model->getRelationLabel('historicoAtividades'));  ?></h2>
<?php
//echo GxHtml::openTag('ul');
//foreach ($model->historicoAtividades as $relatedModel) {
//    echo GxHtml::openTag('li');
//    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('historicoAtividade/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
//    echo GxHtml::closeTag('li');
//}
//echo GxHtml::closeTag('ul');

if ($model->historicoAtividades != null) {
    echo '<div id="movimentacoes">';
    echo '<hr><h3>Registros</h3>';
    echo '<table width="100%">';
    echo '<tr>';
    echo '<th class="headerBorder">Data</td>';
    echo '<th class="headerBorder">Referência</th>';
    echo '<th class="headerBorder">Empreiteiro</th>';
    echo '<th class="headerBorder">Recibo</th>';
    if (Yii::app()->user->isMaster()) {
        echo '<th class="headerBorder">Usuário</th>';
        echo '<th class="headerBorder hidePrint">Ações</th>';
    }
    echo '</tr>';
    foreach ($model->historicoAtividades as $historico) {
        if ($historico->ativo == 1) {
            echo '<tr>';
            echo '<td class="insideBorder">' . Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($historico->data)) . '</td>';
            echo '<td class="insideBorder">' . $historico->getDescricao($historico->referencia, $historico->atividade0->unidadeMedida) . '</td>';
            echo '<td class="insideBorder">' . $historico->empreiteiro0->nome . '</td>';
            if($historico->recibo != null) {
                echo '<td class="insideBorder textAlignCenter" style="width: 50px;">' . CHtml::link('<img src="css/view.png" alt="Ver Recibo" />', array('recibo/view', 'id' => $historico->recibo), array('target' => '_blank')) . '</td>';
            } else {
                echo '<td class="insideBorder textAlignCenter" style="width: 50px;">-</td>';
            }
            if (Yii::app()->user->isMaster()) {
                echo '<td class="insideBorder">' . $historico->usuario0->nome . '</td>';
                echo '<td class="insideBorder textAlignCenter hidePrint">' .
                CHtml::link('<img src="css/delete.png" alt="Remover" />', array('historicoAtividade/delete', 'id' => $historico->id, 'at' => $model->id), array('confirm' => Yii::t('app', 'Are you sure?')))
                . '</td>';
            }
            echo '</tr>';
        }
    }
    echo '</table>';
    echo '</div>';
}
?>