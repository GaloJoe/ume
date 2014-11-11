<div class="view">
    <div class="labels">
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('descricao')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('consumo')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('categoria')); ?>:
            </label>
        </p>
    </div>
    <div class="conteudo">
        <p>
            <?php echo GxHtml::link(GxHtml::encode($data->descricao), array('view', 'id' => $data->id)); ?>
        </p>
        <p>
            <?php echo GxHtml::encode($data->consumo) ?>
        </p>
        <p>
            <?php echo GxHtml::link(GxHtml::encode($data->categoria0->id), array('categoria/view', 'id' => $data->id)); ?>
        </p>
    </div>
</div>