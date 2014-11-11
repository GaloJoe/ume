<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Deseja realmente excluir este item?')),
//    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'nome',
        'email',
        'telefone',
        array(
            'name' => 'imobiliaria0',
            'type' => 'raw',
            'value' => $model->imobiliaria0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->imobiliaria0)), array('imobiliaria/view', 'id' => GxActiveRecord::extractPkValue($model->imobiliaria0, true))) : null,
        ),
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));
?>
<br>

<?php
if ($model->id == Yii::app()->user->id) {
    ?>
    <?php
    if (!Yii::app()->user->isMaster() && !Yii::app()->user->isAdmin()) {
        ?>
        <div class="newRelated">
            <?php echo GxHtml::link('Editar dados', array('usuario/update', 'id' => $model->id), array('class' => 'linkButton')); ?>
        </div>
        <?php
    }
    ?>

    &nbsp;
    <div class="newRelated">
        <?php echo GxHtml::link('Alterar senha', array('usuario/updatePassword'), array('class' => 'linkButton')); ?>
    </div>
    <?php
}
?>