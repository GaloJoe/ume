<div class="view">


    <?php echo GxHtml::link(GxHtml::image($data->logo, 'Logo', array('id' => 'logoEmpreendimento')), array('admin', 'idEmpreendimento' => $data->id)); ?>
    <?php echo GxHtml::link(GxHtml::encode($data->nome), array('admin', 'idEmpreendimento' => $data->id), array('class' => 'nomeEmpreendimento')); ?>
    

</div>