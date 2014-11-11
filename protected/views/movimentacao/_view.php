<div class="view">
    <div class="labels">
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('material')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('quantidade')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('data')); ?>:
            </label>
        </p>
        <?php if($this->user->isMaster()) { ?>
            <p>
                <label>
                    <?php echo GxHtml::encode($data->getAttributeLabel('usuario')); ?>:
                </label>
            </p>
        <?php } ?>
    </div>
    <div class="conteudo">
        <p>
            <?php echo GxHtml::link(GxHtml::encode($data->material0->descricao), array('material/view', 'id' => $data->material0->id)); ?>
        </p>
        <p>
            <?php echo GxHtml::encode($data->quantidade) ?>
        </p>
        <p>
            <?php echo GxHtml::encode($data->getDataFormatada()) ?>
        </p>
        <p>
            <?php echo GxHtml::encode($data->usuario0->nome) ?>
        </p>
    </div>
</div>