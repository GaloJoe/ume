<div class="wide form">
    <h1><?php echo Yii::t('app', 'Novo') . ' ' . GxHtml::encode($model->label(1)); ?></h1>

    <?php
    $form = $this->beginWidget('GxActiveForm', array(
        'action' => Yii::app()->createUrl($this->route) . '&emp=' . $empreendimento,
        'method' => 'POST',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'empreiteiro'); ?>
        <?php
        $condition = 'UPPER(perfil) = ' . '"EMPREITEIRO"' . ' AND ativo=1';
        ?>
        <?php echo $form->dropDownList($model, 'empreiteiro', GxHtml::listDataEx(Usuario::model()->findAllAttributes( null, true, $condition))); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'data_inicial'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'Recibo[data_inicial]',
            'language' => 'pt-BR',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'dd/mm/yy',
                'showAnim' => 'fold',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'data_final'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'Recibo[data_final]',
            'language' => 'pt-BR',
            // additional javascript options for the date picker plugin
            'options' => array(
                'dateFormat' => 'dd/mm/yy',
                'showAnim' => 'fold',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        ?>
    </div>
    
    <?php
    if ($erro != '')
        echo '<div class="textAlignCenter"><span class="erro displayBlock fontSize16 marginTop5">' . $erro . '</span></div>';
    ?>

    <div class="row buttons">
        <?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->

<?php
if ($total_recibo != null && $total_recibo != 0) {
    ?>
    <div style="text-align: center;">
        <?php echo GxHtml::link(Yii::t('app', 'Generate recibo'), array('recibo/generateRecibo&emp=' . $empreendimento), array('class' => 'greyLinkButton', 'confirm' => Yii::t('app', 'Are you sure?'), 'target' => '_blank')); ?>
    </div><br/>
    <?php
}
?>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'viewData' => array('recibo' => $recibo),
    'template'=>'{items}'
));

?>

<?php
if ($total_recibo != null && $total_recibo != 0) {
    ?>
    <div style="float: right"/>
        <h1> <?php echo 'R$' . number_format($total_recibo, $decimals = 2, ',', '.') ?> </h1>
    </div>
    <?php
}
?>