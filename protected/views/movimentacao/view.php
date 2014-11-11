<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
//    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
//    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
//    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
//    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Deseja realmente excluir este item?')),
//    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(GxHtml::valueEx($model->tipoMovimentacao0)) . ' de Material: ' . $model->material0 ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'material0',
            'type' => 'raw',
            'value' => $model->material0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->material0)), array('material/view', 'id' => GxActiveRecord::extractPkValue($model->material0, true))) : null,
        ),
        'quantidade',
        array(
            'name' => 'data',
            'type' => 'raw',
            'value' => $model->getDataFormatada()
        ),
        array(
            'name' => 'usuario0',
            'type' => 'raw',
            'value' => $model->usuario0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->usuario0)), array('usuario/view', 'id' => GxActiveRecord::extractPkValue($model->usuario0, true))) : null,
            'visible' => Yii::app()->user->isMaster()
        ),
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));
?>

