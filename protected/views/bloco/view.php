<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
//    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
//    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Deseja realmente excluir este item?')),
//    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
    array('label' => Yii::t('app', 'New Apartment'), 'url' => array('apartamento/create', 'bloco' => $model->id)),
);
?>

<h1><?php echo GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'descricao',
        array(
            'name' => 'empreendimento0',
            'type' => 'raw',
            'value' => $model->empreendimento0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->empreendimento0)), array('empreendimento/view', 'id' => GxActiveRecord::extractPkValue($model->empreendimento0, true))) : null,
        ),
        array(
            'name' => 'modulo0',
            'type' => 'raw',
            'value' => $model->modulo0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->modulo0)), array('modulo/view', 'id' => GxActiveRecord::extractPkValue($model->modulo0, true))) : null,
        ),
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));
?>

<?php
if (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) {
    ?>
    <!--    <br/>
        <div class="newRelated">-->
    <?php // echo GxHtml::link(Yii::t('app', 'New Apartment'), array('apartamento/create&bloco=' . $model->id), array('class' => 'linkButton')); ?>
    <!--    </div>
        <br/>-->
    <?php
}
?>

<div class="related">
    <h2>
        <?php
        if ($model->apartamentos != null) {
            echo GxHtml::encode($model->getRelationLabel('apartamentos'));
        }
        ?>
    </h2>
    <?php
//    echo GxHtml::openTag('ul');
//    foreach ($model->apartamentos as $relatedModel) {
//        echo GxHtml::openTag('li');
//        $status = '';
//        if ($relatedModel->isSold()) {
//            $status = ' Vendido';
//        } else if ($relatedModel->isReserved()) {
//            $status = ' Reservado';
//        }
//        echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel) . $status), array('apartamento/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
//        echo GxHtml::closeTag('li');
//    }
//    echo GxHtml::closeTag('ul');
    echo GxHtml::openTag('ul');
    echo GxHtml::openTag('li');
    echo GxHtml::openTag('ul');
    foreach($model->apartamentos as $ap) {
        if((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) || (!$ap->isSold() && !$ap->isEmContratacao())) {
            $status = $ap->getStatus();
            $status = str_replace(" ", "&nbsp;", $status);

            echo "<table cellpadding='0' cellspacing='0' class='marginBottom0'>";
            echo "<tr>";
            echo "<td style='margin-left: 50px;' width='100%'>";
            echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($ap)), array('apartamento/view', 'id' => GxActiveRecord::extractPkValue($ap, true)));
            echo "</td>";
            echo "<td>";
            echo $status;
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        }
    }
    echo GxHtml::closeTag('ul');
    echo GxHtml::closeTag('li');
    echo GxHtml::closeTag('ul');
    ?>

</div>