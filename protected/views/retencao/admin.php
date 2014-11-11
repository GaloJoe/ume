<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
);

?>

<h1><?php echo Yii::t('app', 'Manage retention payments'); ?></h1>

<?php
$condition = 'UPPER(perfil) = ' . '"EMPREITEIRO"';
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'recibo-grid',
    'cssFile' => Yii::app()->baseUrl . '/css/gridViewBigger.css',
    'dataProvider' => $model->search(),
    'selectableRows'=>1,
    'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('view').'&id="+$.fn.yiiGridView.getSelection(id);}',
    'columns' => array(
        array(
            'name' => 'empreiteiro',
            'value' => 'GxHtml::valueEx($data->empreiteiro0)',
            'filter' => '',
            'htmlOptions' => array('style' => 'width: 200px'),
            'visible' => Yii::app()->user->isMaster(),
        ),
        array(
            'name' => 'data',
            'header' => 'Data do Recibo',
            'value' => 'Yii::app()->dateFormatter->format("dd/MM/yyyy",strtotime($data->data))',
            'filter' => '',
        ),
        array(
            'name' => 'valor_recibo',
            'header' => 'Valor do Recibo',
            'value' => function($data) {
                return 'R$' . number_format($data->getValorTotal(), 2, ',', '');
            },
            'filter' => '',
        ),
        array(
            'name' => 'valor_retido',
            'header' => 'Valor Retido',
            'value' => function($data) {
                return 'R$' . number_format($data->getValorRetido(), 2, ',', '');
            },
            'filter' => '',
        ),
        array(
            'name' => 'valor_a_pagar',
            'header' => Yii::app()->user->isEmpreiteiro() ? 'Valor A Receber' : 'Valor A Pagar',
            'value' => function($data) {
                return 'R$' . number_format($data->getValorAPagar(), 2, ',', '');
            },
            'filter' => '',
        ),
        array(
            'header' => Yii::t('app', 'Actions'),
            'class' => 'CButtonColumn',
            'viewButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'view.png',
            'updateButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'edit.png',
            'template' => '{new}{view}',
            'buttons' => array(
                'view' => array(
                    'visible' => 'true',
                ),
                'delete' => array(
                    'visible' => 'true',
                ),
                'new' => array(
                    'label' => 'New payment',
                    'imageUrl' => Yii::app()->baseUrl . '/css/' . 'cifrao.png', //Image URL of the button.
                    'url' => '$this->grid->controller->createUrl("/retencao/create&rec=" . $data->id)',
                    'click' => 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
                    'visible' => 'true',
                ),
            ),
            'visible' => Yii::app()->user->isMaster(),
        ),
    ),
));
?>