<div class="wide form">

    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'atividade'); ?>
        <?php echo $form->dropDownList($model, 'atividade', GxHtml::listDataEx(Atividade::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'referencia'); ?>
        <?php echo $form->textField($model, 'referencia'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'quantidade'); ?>
        <?php echo $form->textField($model, 'quantidade'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'data'); ?>
        <?php echo $form->textField($model, 'data'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'usuario'); ?>
        <?php echo $form->dropDownList($model, 'usuario', GxHtml::listDataEx(Usuario::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
    </div>

    <div class="row buttons">
        <?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
