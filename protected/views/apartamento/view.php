<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

if ($model->isSold()) {
    if ($model->isPermutado())
        echo '<div class="textAlignCenter"><span class="reserved">PERMUTADO</span></div>';
    else
        echo '<div class="textAlignCenter"><span class="reserved">VENDIDO</span></div>';
    $usuario = $model->getUsuarioHistorico($model->getSell())->nome;
    $comprador = $model->getCompradorHistorico($model->getSell());
    $imobiliaria = $model->getImobiliariaHistorico($model->getSell())->nome;
    $data = $model->getLeftDays($model->getSell());

    if ((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && !$model->isPermutado()) {
        $historicoVenda = $model->getSellModel($model->getSell());
        echo '<div class="info textAlignCenter">';
        echo '<div class="marginTop5"><span class="hint">Data da venda: <b>' . $data . '</b></span></div>';
        echo '<div class="marginTop5"><span class="hint">Vendido para <b>' . $comprador . '</b></span></div>';
        echo '<div class="marginTop5"><span class="hint">Imobiliária <b>' . $imobiliaria . '</b></span></div>';
        echo '<div class="marginTop5"><span class="hint">Corretor <b>' . $usuario . '</b></span></div>';
        if ($historicoVenda->data_aprovacao_financiamento != null) {
            echo '<div class="marginTop5"><span class="hint">Data de Aprovação do Financiamento <b>' . Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($historicoVenda->data_aprovacao_financiamento)) . '</b></span></div>';
        } else {
            echo '<div class="marginTop5"><span class="hint"><b>Não aprovado pela CAIXA</b></span></div>';
        }
        echo '</div>';

        echo '<div class="textAlignCenter">';
        
        if ($historicoVenda->data_aprovacao_financiamento == null) {
            echo GxHtml::link('Aprovar Financiamento', array('apartamento/aprovarFinanciamento&res=' . $model->getSell() . '&ap=' . $model->id), array('class' => 'greyLinkButton'));
            echo '&nbsp;&nbsp;';
        }
        
        if (!$model->corretorIsPaid($model->getSell())) {
            if (!$model->corretorIsHalfPaid($model->getSell())) {
                //Se for MASTER habilita opção p/ digitar valor pago ao corretor
                if (Yii::app()->user->isMaster() && $model->getSellModel()->valor_pago_corretor != $model->getSellModel()->valor_comissao_corretor) {
                    echo GxHtml::link('Pagar Corretor', array('apartamento/pagarComissaoCorretor&res=' . $model->getSell() . '&ap=' . $model->id), array('class' => 'greyLinkButton'));
                    echo '&nbsp;';
                } else if (Yii::app()->user->isMaster() && $model->getSellModel()->valor_pago_corretor == $model->getSellModel()->valor_comissao_corretor) {
                    echo GxHtml::link('Cancelar Pagamento Corretor', array('apartamento/cancelarComissaoCorretor&res=' . $model->getSell() . '&ap=' . $model->id), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
                    echo '&nbsp;';
                }
                
                if($model->getSellModel()->valor_pago_corretor == null) {
                    echo GxHtml::link('Pagar Corretor Inteira', array('apartamento/confirmarComissaoCorretor&res=' . $model->getSell() . '&ap=' . $model->id), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
                    echo '&nbsp;';
                    echo GxHtml::link('Pagar Corretor Meia', array('apartamento/confirmarComissaoCorretorMeia&res=' . $model->getSell() . '&ap=' . $model->id), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
                }
            } else {
                echo GxHtml::link('Pagar Corretor Restante', array('apartamento/confirmarComissaoCorretor&res=' . $model->getSell() . '&ap=' . $model->id), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
            }
        } else if (Yii::app()->user->isMaster()) {
            echo GxHtml::link('Cancelar Pagamento Corretor', array('apartamento/cancelarComissaoCorretor&res=' . $model->getSell() . '&ap=' . $model->id), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
        }
        echo '&nbsp;';
        if (!$model->admIsPaid($model->getSell())) {
            echo GxHtml::link('Pagar Adm. de Vendas', array('apartamento/confirmarComissaoAdm&res=' . $model->getSell() . '&ap=' . $model->id), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
        } else if (Yii::app()->user->isMaster()) {
            echo GxHtml::link('Cancelar Pagamento Adm. de Vendas', array('apartamento/cancelarComissaoAdm&res=' . $model->getSell() . '&ap=' . $model->id), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
        }

        echo '</div>';
    }
} else if($model->isEmContratacao()) {
    $status = "EM CONTRATAÇÃO";
    echo '<div class="textAlignCenter"><span class="reserved">' . $status . '</span></div>';
    $usuario = $model->getEmContratacaoModel()->usuario0->nome;
    $imobiliaria = $model->getEmContratacaoModel()->usuario0->imobiliaria0->nome;
    
    echo '<div class="info">';
        if (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) {
            echo '<div class="marginTop5"><span class="hint">Em contratação por <b>' . $usuario . '</b></span></div>';
            echo '<div class="marginTop5"><span class="hint">Imobiliária <b>' . $imobiliaria . '</b></span></div>';
        }
    echo '</div>';
} else if ($model->isReserved()) {
    $status = "RESERVADO";
    echo '<div class="textAlignCenter"><span class="reserved">' . $status . '</span></div>';
    $usuario = $model->getUsuarioHistorico($model->getReserve())->nome;
    $imobiliaria = $model->getImobiliariaHistorico($model->getReserve())->nome;
    $leftDays = $model->getLeftDaysOfReserve($model->getReserve());
    $data = $model->getLeftDays($model->getReserve());
    
    echo '<div class="info">';
        echo '<div class="marginTop5"><span class="hint">Data da reserva: <b>' . $data . '</b></span></div>';
        echo '<div class="marginTop5"><span class="hint">Reserva expira em <b>' . $leftDays . ' dia(s)</b></span></div>';
        if (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) {
            echo '<div class="marginTop5"><span class="hint">Reservado para <b>' . $usuario . '</b></span></div>';
            echo '<div class="marginTop5"><span class="hint">Imobiliária <b>' . $imobiliaria . '</b></span></div>';
        }
    echo '</div>';
}

if (!$model->isSold()) {
    Yii::app()->clientScript->registerScript('search', "
$('.sell-form').hide();
$('.sell-button').click(function(){
 $('.sell-form').toggle();
 return false;
});
$('.sell-form form').submit(function(){
 $.fn.yiiGridView.update('apartamento-grid', {
  data: $(this).serialize()
 });
 return false;
});
");
}


$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
    //    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
        //    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Deseja realmente excluir este item?')),
        //    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<div class="marginTop20">
    <h1><?php echo GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>
</div>

<?php if ($erroUsuario != '') { ?>
<div class="textAlignCenter">
    <span class="erro displayBlock fontSize16 marginTop5"><?php echo $erroUsuario; ?></span>
</div>
<?php } ?>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'numero',
        'descricao',
        'metragem',
        array(
            'name' => 'Valor',
            'value' => function($data) {
                return 'R$' . number_format($data->valor, 2, ',', '.');
            },
        ),
        array(
            'name' => 'Valor de Venda',
            'value' => function($data) {
                if($data->isSold())
                    return $data->getValorVenda();
                else
                    return '';
            },
            'visible' => (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && $model->isSold(),
        ),
        array(
            'name' => 'Valor Pago ao Corretor',
            'value' => function($data) {
                if($data->isSold())
                    return $data->getStatusComissaoCorretor();
                else
                    return '';
            },
            'visible' => (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && $model->isSold(),
        ),
        array(
            'name' => 'Valor Total Comissão Corretor',
            'value' => function($data) {
                if($data->isSold())
                    return $data->valorComissaoCorretor() . ' (' . $data->valorAPagarCorretor() . ' a pagar)';
                else
                    return '';
            },
            'visible' => (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && $model->isSold(),
        ),
        array(
            'name' => 'Valor Pago ao Adm de Vendas',
            'value' => function($data) {
                if($data->isSold())
                    return $data->getStatusComissaoAdm();
                else
                    return '';
            },
            'visible' => (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && $model->isSold(),
        ),
        array(
            'name' => 'bloco0',
            'type' => 'raw',
            'value' => $model->bloco0 !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->bloco0)), array('bloco/view', 'id' => GxActiveRecord::extractPkValue($model->bloco0, true))) : null,
        ),
        'box_estacionamento',
    ),
    'itemCssClass' => array(
        'lista',
        'listaAlt'
    )
));

if (!$model->isSold() && !$model->isReserved() && !$model->isEmContratacao()) {
    if (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) {
        echo '<div class="textAlignCenter marginTop10">';
        echo CHtml::dropDownList('imobiliaria', '', CHtml::listData(Imobiliaria::model()->findAll(), 'id', 'nome'), array(
            'ajax' => array(
                'type' => 'POST', //request type
                'url' => CController::createUrl('apartamento/usuariosByImobiliaria'),
                'update' => '#usuario', //selector to update
                'data' => array('imobiliaria' => 'js:this.value'),
            ),
            'empty' => 'Selecionar Imobiliária',
            
        ));
        echo '</div>';
        echo '<div class="textAlignCenter marginTop10">';
        echo CHtml::dropDownList('usuario', '', array(), array(
            'ajax' => array(
                'type' => 'POST', //request type
                'url' => CController::createUrl('apartamento/setUsuario'),
                'data' => array('usuario' => 'js:this.value'),
            ),
            'empty' => 'Selecionar corretor',
            )
        );
        if ($erro != '')
            echo '<span class="erro displayBlock fontSize16 marginTop5">' . $erro . '</span>';
        echo '</div>';

        echo '<div class="textAlignCenter marginTop20">';
        echo GxHtml::link('Efetuar Reserva', array('apartamento/reserva&ap=' . $model->id), array('class' => 'greyLinkButton'));
        echo '&nbsp;';
        echo GxHtml::link('Efetuar Venda', array('apartamento/sell&ap=' . $model->id), array('class' => 'greyLinkButton'));
        echo '&nbsp;';
        echo GxHtml::link('Permutar', array('apartamento/permuta&ap=' . $model->id), array('class' => 'greyLinkButton'));
        echo '</div>';
    } else
        echo GxHtml::link('Efetuar Reserva', array('apartamento/reserva&ap=' . $model->id), array('class' => 'linkButtonFloatRight'));
}
else if (!$model->isSold() && (Yii::app()->user->isMaster() || Yii::app()->user->isAdmin())) {
    echo '<div class="textAlignCenter marginTop20">';
    if(!$model->isEmContratacao()) {
        echo GxHtml::link('Cancelar Reserva', array('apartamento/cancel&ap=' . $model->id . '&res=' . $model->getReserve()), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
        echo '&nbsp;';
        echo GxHtml::link('Em Contratação', array('apartamento/contratacao&ap=' . $model->id . '&res=' . $model->getReserve()), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
        echo '&nbsp;';
        echo GxHtml::link('Marcar como Vendido', array('apartamento/sell&ap=' . $model->id . '&res=' . $model->getReserve()), array('class' => 'greyLinkButton'));
    }
    else {
        echo GxHtml::link('Cancelar', array('apartamento/cancel&ap=' . $model->id . '&res=' . $model->getEmContratacao()), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
        echo '&nbsp;';
        echo GxHtml::link('Marcar como Vendido', array('apartamento/sell&ap=' . $model->id . '&res=' . $model->getEmContratacao()), array('class' => 'greyLinkButton'));
    }
    
    echo '&nbsp;';
    echo GxHtml::link('Permutar', array('apartamento/permuta&ap=' . $model->id . '&res=' . $model->getReserve()), array('class' => 'greyLinkButton'));
    echo '</div>';
}

if ($model->isSold() && Yii::app()->user->isMaster()) {
    $label = 'Cancelar venda';
    if($model->isPermutado())
        $label = 'Cancelar permuta';
    
    echo '<div class="textAlignCenter marginTop20">';
    echo GxHtml::link($label, array('apartamento/cancel&ap=' . $model->id . '&sell=' . $model->getSell()), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?')));
    echo '</div>';
}
?>

<!--<br/>
<div class="textAlignCenter">
<?php // echo GxHtml::link(Yii::t('app', 'Sell options'), '#', array('class' => 'sell-button')); ?>
<div class="sell-form">
    <?php
//    $this->renderPartial('sell', array(
//        'model' => $historico,
//    ));
    ?>
</div></div>-->