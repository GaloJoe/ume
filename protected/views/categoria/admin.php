<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
//    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form').hide();
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('imobiliaria-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php
    if (Yii::app()->user->isMaster()) {
        echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2));
    } else {
        echo GxHtml::encode($model->label(2));
    }
    ?></h1>

<?php
if (Yii::app()->user->isMaster()) {
    ?>
    <p>
        Você pode, opcionalmente, digitar um operador de comparação (<, <=,>,> =, <> ou =) no início de cada um dos seus valores de pesquisa para especificar como a comparação deve ser feita.</p>

    <?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
    <div class="search-form">
        <?php
        $this->renderPartial('_search', array(
            'model' => $model,
        ));
        ?>
    </div><!-- search-form -->

    <?php
}
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'categoria-grid',
    'cssFile' => Yii::app()->baseUrl . '/css/gridViewBigger.css',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'selectableRows'=>1,
    'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('view').'&id="+$.fn.yiiGridView.getSelection(id);}',
    'columns' => array(
        array(
            'name' => 'empreendimento',
            'value' => 'GxHtml::valueEx($data->empreendimento0)',
            'filter' => '',
            'htmlOptions' => array('width'=>'175'),
        ),
        'descricao',
        array(
            'header' => Yii::t('app', 'Actions'),
            'class' => 'CButtonColumn',
            'viewButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'view.png',
            'updateButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'edit.png',
            'deleteButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'delete.png',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'update' => array(
                    'visible' => Yii::app()->user->isMaster() ? 'true' : 'false',
                ),
                'view' => array(
                    'visible' => 'true',
                ),
                'delete' => array(
                    'visible' => 'false',
                ),
            ),
        ),
    ),
));
?>