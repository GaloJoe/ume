<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Generate new') . ' ' . $model->label(), 'url' => array('historicoAtividade/pesquisaRegistros&emp=' . $empreendimento)),
);
?>

<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<?php echo GxHtml::link(Yii::t('app', 'Generate new'), array('historicoAtividade/pesquisaRegistros&emp=' . $empreendimento), array('class' => 'greyLinkButton')); ?>

<?php
$condition = 'UPPER(perfil) = ' . '"EMPREITEIRO"';
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'recibo-grid',
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'empreiteiro',
            'value' => 'GxHtml::valueEx($data->empreiteiro0)',
            'filter' => GxHtml::listDataEx(Usuario::model()->findAllAttributes(null, true, $condition)),
        ),
        array(
            'name' => 'data',
            'header' => 'Data',
            'value' => 'Yii::app()->dateFormatter->format("dd/MM/yyyy",strtotime($data->data))'
        ),
        array(
            'header' => Yii::t('app', 'Actions'),
            'class' => 'CButtonColumn',
            'viewButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'view.png',
            'updateButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'edit.png',
            'deleteButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'delete.png',
            'template' => '{view}{delete}',
            'buttons' => array(
                'view' => array(
                    'visible' => 'true',
                    'options' => array('target' => '_blank'),
                ),
                'delete' => array(
                    'visible' => 'true',
                ),
            ),
        ),
    ),
));
?>