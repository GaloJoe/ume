<h1><?php echo Yii::t('app', 'Alterar Senha') ?></h1>

<div class="form">

    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'usuario-update-password',
        'enableAjaxValidation' => true,
    ));
    ?>

    <?php 
        echo '<div class="row">';
            echo $form->labelEx($model, 'novaSenha');
            echo $form->passwordField($model, 'novaSenha', array('maxlength' => 256));
            echo $form->error($model, 'senha');
        echo '</div>';
    ?>
    
    <?php 
        echo '<div class="row">';
            echo $form->labelEx($model, 'confirmarSenha');
            echo $form->passwordField($model, 'confirmarSenha', array('maxlength' => 256));
            echo $form->error($model, 'senha');
        echo '</div>';
    ?>
    <?php
    if ($erro != '')
        echo '<span class="erro">' . $erro . '</span><br>';
    ?>
    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->

