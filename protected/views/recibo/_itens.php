<?php
$valorTotal = 0;

$valorTotalRetido = 0;
foreach ($data->historicoAtividades as $historicoAtividade) {
    if ($historicoAtividade->empreiteiro0->id == $recibo->empreiteiro) {
        if (($recibo->data_inicial == null || $recibo->data_inicial == '' || strtotime($historicoAtividade->data) >= strtotime($recibo->data_inicial . ' 00:00:00')) &&
                ($recibo->data_final == null || $recibo->data_final == '' || strtotime($historicoAtividade->data) <= strtotime($recibo->data_final . ' 23:59:59'))) {
            $valorUnitario = $data->valor_unitario;
            $valorRetido = $valorUnitario * ($historicoAtividade->retencao / 100);

            $valorTotalRetido += $valorRetido;

            $valorTotal = $valorTotal + $valorUnitario;
        }
    }
}
?>

<div class="view">
    <table>
        <tr>
            <td><?php echo GxHtml::encode($data->descricao) . ' ' . GxHtml::encode(GxHtml::valueEx($data->unidadeMedida)); ?></td>
            <td></td>
            <td><?php echo 'R$' . number_format($valorTotal, 2, ',', '.'); ?></td>
            <td><?php echo 'R$' . number_format($valorTotalRetido, 2, ',', '.'); ?></td>
            <td><?php echo 'R$' . number_format($valorTotal - $valorTotalRetido, 2, ',', '.'); ?></td>
        </tr>

        <?php
        $valorUnitario = $data->valor_unitario;
        foreach ($data->historicoAtividades as $historicoAtividade) {
            if ($historicoAtividade->empreiteiro0->id == $recibo->empreiteiro) {
                if (($recibo->data_inicial == null || $recibo->data_inicial == '' || strtotime($historicoAtividade->data) >= strtotime($recibo->data_inicial . ' 00:00:00')) &&
                        ($recibo->data_final == null || $recibo->data_final == '' || strtotime($historicoAtividade->data) <= strtotime($recibo->data_final . ' 23:59:59'))) {
                    $valorRetido = $valorUnitario * ($historicoAtividade->retencao / 100);
                    echo '<tr>';
                    echo '<td style="max-width: 50px;">';
                    echo GxHtml::encode($historicoAtividade->getDescricao($historicoAtividade->referencia, $data->unidadeMedida));
                    echo '</td>';
                    echo '<td>';
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

        echo '</table></div>';
        