<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'empreendimento0',
            'type' => 'raw',
            'value' => $model->empreendimento0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->empreendimento0)), array('empreendimento/view', 'id' => GxActiveRecord::extractPkValue($model->empreendimento0, true))) : null,
        ),
        'descricao',
        array(
            'name' => 'tipoUnidadeMedida',
            'type' => 'raw',
            'value' => $model->tipoUnidadeMedida !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->tipoUnidadeMedida)), array('tipoUnidadeMedida/view', 'id' => GxActiveRecord::extractPkValue($model->tipoUnidadeMedida, true))) : null,
        ),
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));
?>

<h2><?php // echo GxHtml::encode($model->getRelationLabel('atividades')); ?></h2>
<?php
if($model->atividades != NULL && count($model->atividades) > 0) {
//    echo GxHtml::openTag('ul');
//    foreach ($model->atividades as $relatedModel) {
//        echo GxHtml::openTag('li');
//        echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('atividade/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
//        echo GxHtml::closeTag('li');
//    }
//    echo GxHtml::closeTag('ul');
}
?>