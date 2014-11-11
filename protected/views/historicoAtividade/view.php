<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id)),
        array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Deseja realmente excluir este item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
array(
			'name' => 'atividade0',
			'type' => 'raw',
			'value' => $model->atividade0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->atividade0)), array('atividade/view', 'id' => GxActiveRecord::extractPkValue($model->atividade0, true))) : null,
			),
'referencia',
'quantidade',
'data',
array(
			'name' => 'usuario0',
			'type' => 'raw',
			'value' => $model->usuario0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->usuario0)), array('usuario/view', 'id' => GxActiveRecord::extractPkValue($model->usuario0, true))) : null,
			),
	),
)); ?>

