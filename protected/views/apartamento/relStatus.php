<?php

$this->menu = array(
    array('label' => Yii::t('app', 'Geral'), 'url' => array('rel', 'idEmpreendimento' => $idEmpreendimento)),
    array('label' => Yii::t('app', 'Disponíveis'), 'url' => array('listAvailable', 'idEmpreendimento' => $idEmpreendimento)),
    array('label' => Yii::t('app', 'Reservados'), 'url' => array('listReserved', 'idEmpreendimento' => $idEmpreendimento)),
    array('label' => Yii::t('app', 'Em Contratação'), 'url' => array('listHiring', 'idEmpreendimento' => $idEmpreendimento)),
    array('label' => Yii::t('app', 'Permutados'), 'url' => array('listExchanged', 'idEmpreendimento' => $idEmpreendimento)),
    array('label' => Yii::t('app', 'Vendidos'), 'url' => array('listSold', 'idEmpreendimento' => $idEmpreendimento)),
);
?>
<h1><?php // echo GxHtml::encode($model->label(2)); ?></h1>

<?php
if(isset($apartamentosAprovados) && $apartamentosAprovados != null) {
?>
<div>
    <?php
        $this->widget('application.extensions.print.printWidget', array(
            'coverElement'=>'#content',
            'printedElement'=>'#apartamento-aprovados-rel-grid, #tituloCaixa, #tituloVendidos, #apartamento-total-rel-grid',
        ));
    ?>
</div>

<h2 id="tituloCaixa">Apartamentos com financiamento aprovado pela CAIXA</h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'apartamento-aprovados-rel-grid',
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'dataProvider' => $apartamentosAprovados,
    'columns' => array(
        array(
            'header' => 'Bloco',
            'name' => 'bloco',
            'value' => 'Yii::t(\'app,\', $data->getBloco())',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Apartamento',
            'name' => 'apartamento',
            'value' => 'Yii::t(\'app,\', $data->getApartamento())',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Cliente',
            'name' => 'cliente_nome',
            'value' => '$data->cliente_nome',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Corretor',
            'name' => 'corretor',
            'value' => 'Yii::t(\'app,\', $data->getCorretor())',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Data',
            'value' => '$data->getDataEfetivaSemHoras()',
            'htmlOptions'=>array('style' => 'text-align: center;'),
        ),
        array(
            'header' => 'Status',
            'value' => 'Yii::t(\'app\', $data->status)',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
    ))
);
?>

<?php
}
?>    

<h2 id="tituloVendidos">Geral de apartamentos vendidos</h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'apartamento-total-rel-grid',
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'dataProvider' => $apartamentos,
    'columns' => array(
        array(
            'header' => 'Bloco',
            'name' => 'bloco',
            'value' => 'Yii::t(\'app,\', $data->getBloco())',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Apartamento',
            'name' => 'apartamento',
            'value' => 'Yii::t(\'app,\', $data->getApartamento())',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Cliente',
            'name' => 'cliente_nome',
            'value' => '$data->cliente_nome',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Corretor',
            'name' => 'corretor',
            'value' => 'Yii::t(\'app,\', $data->getCorretor())',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Data',
            'value' => '$data->getDataEfetivaSemHoras()',
            'htmlOptions'=>array('style' => 'text-align: center;'),
        ),
        array(
            'header' => 'Status',
            'value' => 'Yii::t(\'app\', $data->status)',
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
    ))
);
?>