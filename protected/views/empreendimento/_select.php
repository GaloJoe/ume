<div class="view">
    <?php echo GxHtml::link(GxHtml::image($data->logo, 'Logo', array('id' => 'logoEmpreendimento')), array('select', 'id' => $data->id)); ?>
    <?php echo GxHtml::link(GxHtml::encode($data->nome), array('select', 'id' => $data->id), array('class' => 'nomeEmpreendimento')); ?>
    
    <div class="conteudo floatRight">
        <label>
            <?php echo GxHtml::encode($data->getAttributeLabel('dias_reserva')); ?>
        </label>
        <p class="diasReserva">
            <?php echo GxHtml::encode($data->dias_reserva); ?>
        </p>
    </div>
</div>