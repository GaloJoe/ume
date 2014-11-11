<?php

$this->breadcrumbs = array(
	Empreendimento::label(2),
	Yii::t('app', 'Index'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . Empreendimento::label(), 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . Empreendimento::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(Empreendimento::label(2)); ?></h1>

<?php echo Yii::app()->user->getState('perfil'); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 