<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'New payment'); ?></h1>

<?php
$this->renderPartial('_form', array(
    'model' => $model,
    'erro' => $erro,
    'valorPagar' => $valorPagar,
    'buttons' => 'create'));
?>