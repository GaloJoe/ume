<div class="floatRight">
    <?php
    $now = $model->getData();
    $this->widget('application.extensions.print.printWidget', array(
        'coverElement' => '#content',
        'printedElement' => '#recibo',
        'title' => $now . ' Recibo ' . $model->empreiteiro0->nome,
        'htmlOptions' => array('class' => 'hidePrint')
    ));
    ?>    
</div>
<div id="recibo">
    <div class="textAlignCenter">
        <h1><?php echo Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($model->data)); ?></h1>
        <h3><?php echo 'De ' . Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($model->data_inicial)) . ' até ' . Yii::app()->dateFormatter->format("dd/MM/yyyy", strtotime($model->data_final)); ?></h3>
    </div>
    <table class="tabelaRecibo">
        <th>Descrição</th>
        <th>Data</th>
        <th>Total</th>
        <th>Retido</th>
        <th>A Pagar</th>

        <?php
        foreach ($atividades as $atividade) {
            $valorTotal = 0;

            $valorTotalRetido = 0;
            foreach ($atividade->historicoAtividades as $historicoAtividade) {
                if ($historicoAtividade->recibo == $model->id && $historicoAtividade->ativo = 1) {
                    $valorUnitario = $atividade->valor_unitario;
                    $valorRetido = $valorUnitario * ($historicoAtividade->retencao / 100);

                    $valorTotalRetido += $valorRetido;

                    $valorTotal = $valorTotal + $valorUnitario;
                }
            }
            ?>

            <tr>
                <td><b><?php echo GxHtml::encode($atividade->descricao) . ' (' . GxHtml::encode(GxHtml::valueEx($atividade->unidadeMedida)) . ')'; ?></b></td>
                <td class="textAlignCenter"></td>
                <td><b><?php echo 'R$' . number_format($valorTotal, 2, ',', '.'); ?></b></td>
                <td><b><?php echo 'R$' . number_format($valorTotalRetido, 2, ',', '.'); ?></b></td>
                <td><b><?php echo 'R$' . number_format($valorTotal - $valorTotalRetido, 2, ',', '.'); ?></b></td>
            </tr>

            <?php
            $valorUnitario = $atividade->valor_unitario;
            foreach ($atividade->historicoAtividades as $historicoAtividade) {
                if ($historicoAtividade->recibo == $model->id) {
                    $valorRetido = $valorUnitario * ($historicoAtividade->retencao / 100);
                    echo '<tr>';
                    echo '<td style="width: 320px; margin-left: 20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo GxHtml::encode($historicoAtividade->getDescricao($historicoAtividade->referencia, $atividade->unidadeMedida));
                    echo '</td>';
                    echo '<td class="textAlignCenter" style="width: 120px;">';
                    echo GxHtml::encode($historicoAtividade->dataFormatada);
                    echo '</td>';
                    echo '<td>';
                    echo 'R$' . number_format($valorUnitario, 2, ',', '.');
                    echo '</td>';
                    echo '<td>';
                    echo 'R$' . number_format($valorRetido, 2, ',', '.');
                    echo '</td>';
                    $valorPagar = $valorUnitario - $valorRetido;
                    echo '<td>';
                    echo 'R$' . number_format($valorPagar, 2, ',', '.');
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }

        echo '<tr>';
        echo '<td colspan="4" style="text-align: right;">';
        echo 'Total:';
        echo '</td>';
        echo '<td><b>';
        echo 'R$' . number_format($total_recibo, $decimals = 2, ',', '.');
        echo '</b></td>';
        echo '</tr>';
        ?>
    </table>

    <div class="textAlignCenter">
        <p>
            Declaro ter recebido da empresa Dall Construções a importância de R$<?php echo number_format($total_recibo, $decimals = 2, ',', '.'); ?> discriminada neste recibo.
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
                    <?php echo $model->empreiteiro0->nome ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
                <td style="text-align: center;">
                    Dall Construções
                </td>
            </tr>
        </table>
    </div>
</div>