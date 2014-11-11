<div class="view">


    <?php echo GxHtml::link(GxHtml::image($data->logo, 'Logo', array('id' => 'logoEmpreendimento')), array('rel', 'idEmpreendimento' => $data->id)); ?>
    <?php echo GxHtml::link(GxHtml::encode($data->nome), array('rel', 'idEmpreendimento' => $data->id), array('class' => 'nomeEmpreendimento')); ?>
   

</div>