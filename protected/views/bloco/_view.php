<div class="view">
    <div class="labels">
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('descricao')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('empreendimento')); ?>:
            </label>
        </p>
    </div>
    <div class="conteudo">
        <p>
            <?php echo GxHtml::link($data->descricao, array('view', 'id' => $data->id)); ?>
        </p>
        <p>
            <?php echo GxHtml::encode(GxHtml::valueEx($data->empreendimento0)); ?>
        </p>
    </div>

</div>