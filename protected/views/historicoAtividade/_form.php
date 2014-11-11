<div class="form">

    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'historico-atividade-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="row">
        <?php
        echo $form->labelEx($model, 'empreiteiro');
        $condition = 'UPPER(perfil) = ' . '"EMPREITEIRO" AND ativo = 1';
        ?>
        <?php echo $form->dropDownList($model, 'empreiteiro', GxHtml::listDataEx(Usuario::model()->findAllAttributes(null, true, $condition)), array('empty' => 'Selecionar Empreiteiro')); ?>
        <?php echo $form->error($model, 'empreiteiro'); ?>
    </div><!-- row -->
    <div class="row">
        <?php
        if ($tipoUnidadeMedida == TipoUnidadeMedidaEnum::EMPREENDIMENTO) {
            ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'empreendimento'); ?>
                <?php
                $condition = '';
                if (isset($atividade->unidadeMedida->empreendimento) && $atividade->unidadeMedida->empreendimento > 0) {
                    $condition = 'id = ' . $atividade->unidadeMedida->empreendimento;
                }
                ?>
                <?php echo $form->dropDownList($atividade->unidadeMedida, 'empreendimento', GxHtml::listDataEx(Empreendimento::model()->findAllAttributes(null, true, $condition))); ?>
                <?php echo $form->error($model, 'empreendimento'); ?>
            </div><!-- row -->
            <?php
        } else if (isset($blocos) && count($blocos) > 0) {
            if ($tipoUnidadeMedida == TipoUnidadeMedidaEnum::BLOCO) {
                foreach ($blocos as $bloco) {
                    $checked = "";
                    $disabled = "";
                    if ($model->hasSaved($bloco->id, $atividade->id)) {
                        $checked = "checked";
                        $disabled = "disabled";
                    }
                    ?>
                    <div class="row">
                        <?php echo $form->labelEx($bloco, $bloco->descricao); ?>
                        <?php echo $form->checkBox($bloco, 'descricao', array('id' => 'bloco' . $bloco->id, 'name' => 'Bloco[' . $bloco->id . ']', 'checked' => $checked, 'disabled' => $disabled)); ?>
                        <?php echo $form->error($bloco, 'referencia'); ?>
                    </div>
                    <?php
                }
            } else if ($tipoUnidadeMedida == TipoUnidadeMedidaEnum::APARTAMENTO || $tipoUnidadeMedida == TipoUnidadeMedidaEnum::ANDAR) {
                if ($tipoUnidadeMedida == TipoUnidadeMedidaEnum::APARTAMENTO) {
                    $url = 'apartamento/byBloco&atividade=' . $atividade->id;
                } else if ($tipoUnidadeMedida == TipoUnidadeMedidaEnum::ANDAR) {
                    $url = 'andar/byBloco&atividade=' . $atividade->id;
                }
                ?>
                <div class="row">
                    <?php echo $form->labelEx($model, 'bloco'); ?>
                    <?php
                    echo CHtml::dropDownList('bloco', '', CHtml::listData($blocos, 'id', 'descricao'), array(
                        'ajax' => array(
                            'type' => 'POST', //request type
                            'url' => CController::createUrl($url),
                            'update' => '#itensBloco', //selector to update
                            'data' => array('bloco' => 'js:this.value'),
                        ),
                        'empty' => 'Selecionar Bloco',
                    ));

                    echo '<div id="itensBloco">';
                    echo '</div>';
                    ?>
                    <?php echo $form->error($model, 'bloco'); ?>
                </div>
            <?php } ?>
        <?php } ?>

        <!-- RETENÇÃO -->

        <?php if ($tipoUnidadeMedida != null && $tipoUnidadeMedida != '') { ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'retencao'); ?>
                <?php
                $this->widget('system.web.widgets.CMaskedTextField', array(
                    'model' => $model,
                    'attribute' => 'retencao',
                    'mask' => '99.99%')
                );
                ?>
                <?php echo $form->error($model, 'retencao'); ?>
            </div>
        <?php } ?>

        <?php
        echo GxHtml::submitButton(Yii::t('app', 'Register'));
        $this->endWidget();
        ?>
    </div><!-- form -->