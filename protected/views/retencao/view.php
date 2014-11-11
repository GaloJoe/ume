<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Valores retidos'), 'url' => array('admin', 'emp' => $model->empreendimento)),
);
?>

<h1><?php echo Yii::t('app', 'View'); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'empreiteiro0',
            'type' => 'raw',
            'value' => $model->empreiteiro0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->empreiteiro0)), array('usuario/view', 'id' => GxActiveRecord::extractPkValue($model->empreiteiro0, true))) : null,
        ),
        array(
            'name' => 'data',
            'type' => 'raw',
            'value' => Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($model->data)),
        ),
        array(
            'name' => 'data_inicial',
            'type' => 'raw',
            'value' => Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($model->data_inicial)),
        ),
        array(
            'name' => 'data_final',
            'type' => 'raw',
            'value' => Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($model->data_final)),
        ),
        array(
            'name' => 'valor_total',
            'type' => 'raw',
            'value' => 'R$' . number_format($model->getValorTotal(), 2, ',', ''),
        ),
        array(
            'name' => 'valor_retido',
            'type' => 'raw',
            'value' => 'R$' . number_format($model->getValorRetido(), 2, ',', ''),
        ),
        array(
            'name' => 'valor_a_pagar',
            'type' => 'raw',
            'value' => 'R$' . number_format($model->getValorAPagar(), 2, ',', ''),
        ),
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));
?>

<?php
if ($model->retencaos != null && count($model->retencaos) > 0) {
    ?>
    <br/>
    <div>

        <h2>
            <?php
            if ($model->retencaos != null) {
                echo GxHtml::encode('Pagamentos');
            }
            ?>
        </h2>
        <?php
        echo '<div float="right"><table width="200px">';
        echo '<th class="headerBorder">Data</th>';
        echo '<th class="headerBorder">Valor</th>';
        echo '<th class="headerBorder" width="16px">Ações</th>';
        foreach ($model->retencaos as $retencao) {
            if ($retencao->ativo == 1) {
                echo '<tr>';
                echo '<td class="insideBorder" width="140px">';
                echo Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($retencao->data));
                echo '</td>';
                echo '<td class="insideBorder">';
                echo 'R$' . number_format($retencao->valor, 2, ',', '');
                echo '</td>';
                echo '<td class="insideBorder">';
                echo GxHtml::link('<img src="css/view.png" alt="Visualizar" />', array('retencao/generateRecibo', 'id' => $retencao->id), array('target'=>'_blank'));
                if(Yii::app()->user->isMaster()) {
                    echo GxHtml::link('<img src="css/delete.png" alt="Remover" />', array('retencao/delete', 'id' => $retencao->id, 'rec' => $model->id));
                }
                echo '</td>';
                echo '</tr>';
            }
        }
        echo '</table>';
        echo '</div>';
    }
    ?>