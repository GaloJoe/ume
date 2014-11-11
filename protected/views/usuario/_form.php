<div class="form">

    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'usuario-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'nome'); ?>
        <?php echo $form->textField($model, 'nome', array('maxlength' => 60)); ?>
        <?php echo $form->error($model, 'nome'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->emailField($model, 'email', array('maxlength' => 60)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div><!-- row -->
    <?php
    if (isset($action) && $action != 'update') {
        echo '<div class="row">';
        echo $form->labelEx($model, 'senha');
        echo $form->passwordField($model, 'senha', array('maxlength' => 256));
        echo $form->error($model, 'senha');
        echo '</div>';
    }
    ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'telefone'); ?>
        <?php
        $this->widget('system.web.widgets.CMaskedTextField', array(
            'model' => $model,
            'attribute' => 'telefone',
            'mask' => '(99)9999-9999')
        );
        ?>
        <?php echo $form->error($model, 'telefone'); ?>
    </div><!-- row -->

    <?php
    if (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) {
        ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'Empresa'); ?>
            <?php
            $condition = '';
            if (isset($imobiliaria) && $imobiliaria > 0) {
                $condition = 'id = ' . $imobiliaria;
            }
            ?>
            <?php echo $form->dropDownList($model, 'imobiliaria', GxHtml::listDataEx(Imobiliaria::model()->findAllAttributes(null, true, $condition)), array(
        'empty'=>'')); ?>
            <?php echo $form->error($model, 'imobiliaria'); ?>
        </div><!-- row -->

        <div class="row">
            <?php echo $form->labelEx($model, 'perfil'); ?>
            <?php echo CHtml::dropDownList('Usuario[perfil]', 'perfil', array('normal' => 'Corretor', 'almoxarife' => 'Almoxarife','engenheiro' => 'Engenheiro','empreiteiro' => 'Empreiteiro')); ?>
            <?php echo $form->error($model, 'perfil'); ?>
        </div><!-- row -->

        <div class="row">
            <?php echo $form->labelEx($model, 'corretor_chefe'); ?>
            <?php echo $form->checkBox($model, 'corretor_chefe'); ?>
            <?php echo $form->error($model, 'corretor_chefe'); ?>
        </div>

        <?php
    }
    ?>


    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->