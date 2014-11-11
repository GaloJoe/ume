<div class="view">

    <?php
    if ($data->isSold()) {
        if($data->isPermutado()) {
            echo '<p>';
                echo '<div class="outter"><div class="inner120"><span class="reserved">PERMUTADO</span></div></div>';
            echo '</p>';
        } else {
            echo '<p>';
                echo '<div class="outter"><div class="inner120"><span class="reserved">VENDIDO</span></div></div>';
            echo '</p>';
        }
    }
    else if ($data->isReserved()) {
        echo '<p>';
            echo '<div class="outter"><div class="inner120"><span class="reserved">RESERVADO</span></div></div>';
        echo '</p>';
    }
    ?>
    <div class="labels">
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('numero')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('descricao')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('metragem')); ?>:

            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('valor')); ?>:
            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('bloco')); ?>:

            </label>
        </p>
        <p>
            <label>
                <?php echo GxHtml::encode($data->getAttributeLabel('box_estacionamento')); ?>:
            </label>
        </p>
    </div>
    <div class="conteudo">
        <p>
            <?php echo GxHtml::link(GxHtml::encode($data->numero), array('view', 'id' => $data->id)); ?>
        </p>
        <p>
            <?php echo GxHtml::encode($data->descricao); ?>
        </p>
        <p>
            <?php echo GxHtml::encode($data->metragem); ?>
        </p>
        <p>
            <?php
            echo 'R$' . number_format($data->valor, 2, ',', '.');
//            echo GxHtml::encode($data->valor);s
            ?>
        </p>
        <p>
            <?php echo GxHtml::encode(GxHtml::valueEx($data->bloco0)); ?>
        </p>
        <p>
            <?php echo GxHtml::encode($data->box_estacionamento); ?>
        </p>
    </div>
</div>

