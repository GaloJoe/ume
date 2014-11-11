<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
//    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
//    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Deseja realmente excluir este item?')),
//    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
    array('label' => Yii::t('app', 'New Block'), 'url' => array('bloco/create', 'empreendimento' => $model->id)),
    array('label' => Yii::t('app', 'New Module'), 'url' => array('modulo/create', 'empreendimento' => $model->id)),
);
?>

<h1><?php echo GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<div class="form">
    <div class="row">
        <p class="hint floatRight displayBlock">
            Clique na imagem para ampliar
        </p>
    </div>
</div>
<div class="displayNone">
    <div id="implantacaoFull">
        <?php echo GxHtml::image($model->implantacao, 'Implantação', array('width' => '100%', 'height' => '100%')); ?>
    </div>
</div>
<?php
echo GxHtml::link(GxHtml::image($model->implantacao, 'Implantação', array('width' => '100%', 'height' => '100%')), "#implantacaoFull", array('id' => 'implantacao', 'title' => 'Implantação ' . $model->nome));
?>

<?php
$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => 'a#implantacao',
    'config' => array(
        'titlePosition' => 'outside',
        'titleShow' => true,
    ),
        )
);
?>

<?php
//if (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) {
//    ?>
<!--    <br/><br/>
    <div class="newRelated">
        <?php // echo GxHtml::link(Yii::t('app', 'New Block'), array('bloco/create', 'empreendimento' => $model->id), array('class' => 'linkButton')); ?>
    </div>
    <br/>-->
    <?php
//}
?>

<div class="related">

    <h2>
        <?php
        if ($model->blocos != null) {
            echo GxHtml::encode($model->getRelationLabel('blocos'));
        }
        ?>
    </h2>
    <?php
    echo GxHtml::openTag('ul');
    foreach ($model->blocos as $relatedModel) {
        if((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) || $relatedModel->disponivel) {
            echo GxHtml::openTag('li');
            echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('bloco/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
            echo GxHtml::openTag('ul');
            foreach ($relatedModel->apartamentos as $ap) {
                if((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) || (!$ap->isSold() && !$ap->isEmContratacao() && $ap->disponivel)) {
                    $status = $ap->getStatus();
                    $status = str_replace(" ", "&nbsp;", $status);
                    $desc = $ap->descricao;

                    echo "<table cellpadding='0' cellspacing='0' class='marginBottom0'>";
                    echo "<tr>";
                    echo "<td style='margin-left: 50px;' width='100%'>";
                    echo GxHtml::link(GxHtml::encode($desc), array('apartamento/view', 'id' => GxActiveRecord::extractPkValue($ap, true)));
                    echo "</td>";
                    echo "<td>";
                    echo $status;
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                }
            }
            echo GxHtml::closeTag('ul');
            echo GxHtml::closeTag('li');
        }
    }
    echo GxHtml::closeTag('ul');
    ?>

</div>