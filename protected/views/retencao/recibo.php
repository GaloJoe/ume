<div class="floatRight">
    <?php
    $now = $model->recibo0->getData();
    $this->widget('application.extensions.print.printWidget', array(
        'coverElement' => '#content',
        'printedElement' => '#recibo',
        'title' => $now . ' Recibo ' . $model->recibo0->empreiteiro0->nome,
        'htmlOptions' => array('class' => 'hidePrint')
    ));
    ?>    
</div>
<div id="recibo">
    <table class="tabelaRecibo">
        <th>Data</th>
        <th>Valor Pago</th>
        
        <tr>
            <td><?php echo Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($model->data)); ?></td>
            <td><?php echo 'R$' . number_format($model->valor, $decimals = 2, ',', '.'); ?></td>
        </tr>

    </table>

    <div class="textAlignCenter">
        <p>
            Declaro ter recebido da empresa Dall Construções a importância de R$<?php echo number_format($model->valor, $decimals = 2, ',', '.'); ?> discriminada neste recibo.
        </p>
        <table style="width:500px; margin: 10px auto;">
            <tr>
                <td style="text-align: center;">
                    ______________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
                <td style="text-align: center;">
                    ______________________________________
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <?php echo $model->recibo0->empreiteiro0->nome ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
                <td style="text-align: center;">
                    Dall Construções
                </td>
            </tr>
        </table>
    </div>
</div>