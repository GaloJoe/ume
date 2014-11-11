<div class="view">
    <?php if (Yii::app()->user->isEmpreiteiro()) {
        ?>
        <?php echo GxHtml::link(GxHtml::image($data->logo, 'Logo', array('id' => 'logoEmpreendimento')), array('retencao/admin', 'emp' => $data->id, 'usuario' => Yii::app()->user->id)); ?>
        <?php echo GxHtml::link(GxHtml::encode($data->nome), array('retencao/admin', 'emp' => $data->id, 'usuario' => Yii::app()->user->id), array('class' => 'nomeEmpreendimento')); ?>
        <?php
    } else {
        ?>
        <?php echo GxHtml::link(GxHtml::image($data->logo, 'Logo', array('id' => 'logoEmpreendimento')), array('admin', 'emp' => $data->id,)); ?>
        <?php echo GxHtml::link(GxHtml::encode($data->nome), array('admin', 'emp' => $data->id), array('class' => 'nomeEmpreendimento')); ?>
    <?php } ?>
</div>