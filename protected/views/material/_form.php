<div class="form">


    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'material-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'descricao'); ?>
        <?php echo $form->textField($model, 'descricao', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'descricao'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'consumo'); ?>
        <?php echo $form->textField($model, 'consumo'); ?>
        <br>
        <?php echo '(Utilize um ponto para valores quebrados. Ex: 10.5)'; ?>
        <?php echo $form->error($model, 'consumo'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'categoria'); ?>
        <?php
        $condition = '';
        if (isset($categoria) && $categoria > 0) {
            $condition = 'id = ' . $categoria;
        }
        ?>
        <?php echo $form->dropDownList($model, 'categoria', GxHtml::listDataEx(Categoria::model()->findAllAttributes(null, true, $condition))); ?>
        <?php echo $form->error($model, 'categoria'); ?>
    </div><!-- row -->

    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->