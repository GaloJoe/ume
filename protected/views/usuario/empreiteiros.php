<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
);

?>

<h1><?php echo Yii::t('app', 'View') . ' Empreiteiros'; ?></h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'empreiteiros-grid',
    'cssFile' => Yii::app()->baseUrl . '/css/gridViewBigger.css',
    'dataProvider' => $model->getEmpreiteiros(),
    'filter' => $model,
    'selectableRows'=>1,
    'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('retencao/admin&emp=' . $empreendimento).'&usuario="+$.fn.yiiGridView.getSelection(id);}',
    'columns' => array(
        'nome',
        'email',
        array(
            'header' => 'Valor Total A Pagar',
            'value' => 'Yii::t(\'app\', $data->getValorAPagar())',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
    ),
));
?>