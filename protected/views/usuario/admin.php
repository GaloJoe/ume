<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Manage'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create'), 'visible' => true),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form').hide();
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('usuario-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<p>
    <?php echo Yii::t('app', 'SearchHelp') ?>
</p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'usuario-grid',
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'nome',
        'email',
        array(
            'name' => 'imobiliaria',
            'value' => 'GxHtml::valueEx($data->imobiliaria0)',
            'filter' => GxHtml::listDataEx(Imobiliaria::model()->findAllAttributes(null, true)),
        ),
        'ativo' => array(
            'header' => 'Perfil',
            'name' => 'perfil',
            'filter' => false,
            'value' => '$data->perfilFormatado',
        ),
        'corretor_chefe' => array(
            'header' => 'Corretor Chefe',
            'name' => 'corretor_chefe',
            'filter' => false,
            'value' => '($data->corretor_chefe == 0) ? "Não" : "Sim"'
        ),
        array(
            'header' => Yii::t('app', 'Actions'),
            'class' => 'CButtonColumn',
            'viewButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'view.png',
            'updateButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'edit.png',
            'deleteButtonImageUrl' => Yii::app()->baseUrl . '/css/' . 'delete.png',
        ),
    ),
));
?>