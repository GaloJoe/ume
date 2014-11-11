<div class="view">
    <div class="labels">
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('descricao')); ?>:
            </label>
        </p>
    </div>
    <div class="conteudo">
        <p>
            <?php echo GxHtml::link(GxHtml::encode($data->descricao), array('view', 'id' => $data->id)); ?>
        </p>
    </div>
</div>