<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
//    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('admin')),
//    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
//    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
//    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Deseja realmente excluir este item?')),
//    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
    array('label' => Yii::t('app', 'New Material'), 'url' => array('material/create', 'cat' => $model->id)),
);
?>

<h1><?php echo GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<!-- Botão para adicionar novo Material -->
<?php
echo '<div class="textAlignCenter"><p>';
echo GxHtml::link('Novo Material', array('material/create&cat=' . $model->id), array('class' => 'greyLinkButton'));
echo '</p></div>';
?>

<div class="related">
    <?php
    $now = $model->getData();
    $this->widget('application.extensions.print.printWidget', array(
        'coverElement' => '#content',
        'printedElement' => '#movimentacoes, .related',
        'title' => $now . '<br/>Relatório ' . $model->descricao,
        'htmlOptions' => array('class' => 'hidePrint')
    ));
    ?>

    <h2>
        <?php
        if ($model->materiais != null) {
            echo GxHtml::encode($model->getRelationLabel('materiais'));
        }
        ?>
    </h2>
    <?php
    echo GxHtml::openTag('ul');
    foreach ($model->materiais as $relatedModel) {
        if($relatedModel->ativo == 1) {
            echo GxHtml::openTag('li');

            echo "<table cellpadding='0' cellspacing='0' class='marginBottom0'>";
            echo "<tr>";
            echo "<td style='margin-left: 50px;' width='100%'>";
            echo GxHtml::link(GxHtml::encode($relatedModel->descricao), array('material/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
            echo "</td>";
            echo "</tr>";
            echo "</table>";

            $this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'BarChart',
                'data' => $relatedModel->getChartData(),
                'options' => array('title' => 'Consumo',
                    'legend' => array('position' => 'bottom'),
                    'hAxis' => array('minValue' => '0'),
                ),
                'htmlOptions' => array('class' => 'showPrint')
            ));

            echo GxHtml::closeTag('li');
        }
    }
    echo GxHtml::closeTag('ul');
    ?>

</div>