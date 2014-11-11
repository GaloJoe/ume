<div class="form">


    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'movimentacao-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'material'); ?>
        <?php
        $condition = '';
        if (isset($material) && $material > 0) {
            $condition = 'id = ' . $material;
        }
        ?>
        <?php echo $form->dropDownList($model, 'material', GxHtml::listDataEx(Material::model()->findAllAttributes(null, true, $condition))); ?>
        <?php echo $form->error($model, 'material'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'quantidade'); ?>
        <?php echo $form->textField($model, 'quantidade'); ?>
        <br>
        <?php echo '(Utilize um ponto para valores quebrados. Ex: 10.5)'; ?>
        <?php echo $form->error($model, 'quantidade'); ?>
    </div><!-- row -->
    
     <div class="row">
        <?php echo $form->labelEx($model, 'descricao'); ?>
        <?php echo $form->textField($model, 'descricao', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'descricao'); ?>
    </div><!-- row -->

    <?php if ($erroUsuario != '') { ?>
        <div class="textAlignCenter">
            <span class="erro displayBlock fontSize16 marginTop5"><?php echo $erroUsuario; ?></span>
        </div>
    <?php } ?>

    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->