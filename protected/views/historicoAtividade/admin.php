<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'Manage'),
);

$this->menu = array(
		array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('historico-atividade-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>

<p>
    Você pode, opcionalmente, digitar um operador de comparação (<, <=,>,> =, <> ou =) no início de cada um dos seus valores de pesquisa para especificar como a comparação deve ser feita.</p>

<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'historico-atividade-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array(
				'name'=>'atividade',
				'value'=>'GxHtml::valueEx($data->atividade0)',
				'filter'=>GxHtml::listDataEx(Atividade::model()->findAllAttributes(null, true)),
				),
		'referencia',
		'quantidade',
		'data',
		array(
				'name'=>'usuario',
				'value'=>'GxHtml::valueEx($data->usuario0)',
				'filter'=>GxHtml::listDataEx(Usuario::model()->findAllAttributes(null, true)),
				),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>