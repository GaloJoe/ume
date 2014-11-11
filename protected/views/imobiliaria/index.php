<?php

$this->breadcrumbs = array(
	Imobiliaria::label(2),
	Yii::t('app', 'Index'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . Imobiliaria::label(), 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . Imobiliaria::label(2), 'url' => array('admin')),
);
?>

<h1><?php echo GxHtml::encode(Imobiliaria::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 