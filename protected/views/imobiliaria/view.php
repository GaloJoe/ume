<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
//    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Deseja realmente excluir este item?')),
//    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
    array('label' => Yii::t('app', 'New User'), 'url' => array('usuario/create', 'imobiliaria' => $model->id)),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'nome',
        'endereco',
        'telefone',
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));
?>

<?php
if (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) {
    ?>
    <br/>
    <div class="newRelated">
        <?php echo GxHtml::link(Yii::t('app', 'New User'), array('usuario/create&imobiliaria=' . $model->id), array('class' => 'linkButton')); ?>
    </div>
    <br/>

    <div class="related">
        <h2>
            <?php
            if ($model->usuarios != null) {
                echo GxHtml::encode($model->getRelationLabel('usuarios'));
            }
            ?>
        </h2>
        <?php
        echo GxHtml::openTag('ul');
        foreach ($model->usuarios as $relatedModel) {
            echo GxHtml::openTag('li');
            echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('usuario/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
            echo GxHtml::closeTag('li');
        }
        echo GxHtml::closeTag('ul');
        ?>

    </div>
    <?php
}
?>