<div class="view">
    <div class="labels">
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('nome')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('email')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('telefone')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('imobiliaria')); ?>:
            </label>
        </p>
    </div>
    <div class="conteudo">
        <p>
            <?php echo GxHtml::link(GxHtml::encode($data->nome), array('view', 'id' => $data->id)); ?>
        </p>
        <p>
            <?php echo GxHtml::encode($data->email); ?>
        </p>
        <p>    
            <?php echo GxHtml::encode($data->telefone); ?>
        </p>
        <p>

            <?php echo GxHtml::encode(GxHtml::valueEx($data->imobiliaria0)); ?>
        </p>
    </div>

</div>