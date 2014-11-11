<div class="view">
    <div class="labels">
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('nome')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('endereco')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('telefone')); ?>:
            </label>
        </p>
    </div>
    <div class="conteudo">
        <p>
            <?php echo GxHtml::link(GxHtml::encode($data->nome), array('view', 'id' => $data->id)); ?>
        </p>
        <p>
            <?php echo GxHtml::encode($data->endereco); ?>
        </p>
        <p>
            <?php echo GxHtml::encode($data->telefone); ?>
        </p>
    </div>

</div>