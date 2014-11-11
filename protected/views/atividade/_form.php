<div class="form">

    <?php
    
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '#valor_unitario',
        'config' => array(
            'symbol' => 'R$',
            'showSymbol' => true,
            'symbolStay' => true,
            'decimal' => ',',
            'thousands' => '.'
        )
    ));
    
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'atividade-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'unidade_medida'); ?>
        <?php
            $condition = 'empreendimento = ' . $empreendimento;
        ?>
        <?php echo $form->dropDownList($model, 'unidade_medida', GxHtml::listDataEx(UnidadeMedida::model()->findAllAttributes(null, true, $condition))); ?>
        <?php echo $form->error($model, 'unidade_medida'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'descricao'); ?>
        <?php echo $form->textField($model, 'descricao', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'descricao'); ?>
    </div><!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'valor_unitario'); ?>
        <?php echo $form->textField($model, 'valor_unitario', array('id' => 'valor_unitario')); ?>
        <?php echo $form->error($model, 'valor_unitario'); ?>
    </div><!-- row -->

    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->