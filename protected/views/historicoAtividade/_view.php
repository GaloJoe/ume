<div class="view">

    <?php echo '<h1>' . GxHtml::encode($data->descricao) . ' (' . GxHtml::encode(GxHtml::valueEx($data->unidadeMedida)) . ')</h1>'; ?>
    
    <?php
        $valorUnitario = $data->valor_unitario;
        $valorTotal = 0;
    ?>

    <table>
        <th>Descrição</th>
        <th>Data</th>
        <th>Valor Retido</th>
        
        <?php
        $valorTotalRetido = 0;
        foreach ($data->historicoAtividades as $historicoAtividade) {
            if($historicoAtividade->empreiteiro0->id == $recibo->empreiteiro && $historicoAtividade->ativo == 1) {
                if(($recibo->data_inicial == null || $recibo->data_inicial == '' || strtotime($historicoAtividade->data) >= strtotime($recibo->data_inicial . ' 00:00:00')) &&
                    ($recibo->data_final == null || $recibo->data_final == '' || strtotime($historicoAtividade->data) <= strtotime($recibo->data_final . ' 23:59:59'))
                        && $historicoAtividade->recibo == null){
                    $valorRetido = $valorUnitario * ($historicoAtividade->retencao / 100);
                    echo '<tr>';
                    echo '<td style="max-width: 50px;">';
                    echo GxHtml::encode($historicoAtividade->getDescricao($historicoAtividade->referencia, $data->unidadeMedida));
                    echo '</td>';
                    echo '<td>';
                    echo GxHtml::encode($historicoAtividade->dataFormatada);
                    echo '</td>';
                    echo '<td>';
                    echo 'R$' . number_format($valorRetido, 2, ',', '.');
                    echo '</td>';
                    echo '</tr>';
                    $valorTotalRetido += $valorRetido;
                    
                    $valorTotal = $valorTotal + $valorUnitario;
                }
            }
        }
        ?>
    </table>

    <div style="float: right">
        <span style='font-weight: bold; font-size: 16px;'>Valores:</span>
        <table>
            <th>Unitário</th>
            <th>Total</th>
            <th>Total Retido</th>
            <th>Total da Atividade</th>
            <tr>
                <td>
                    <?php echo 'R$' . number_format($valorUnitario, 2, ',', '.'); ?>
                </td>
                <td>
                    <?php echo 'R$' . number_format($valorTotal, 2, ',', '.'); ?>
                </td>
                <td>
                    <?php echo 'R$' . number_format($valorTotalRetido, 2, ',', '.'); ?>
                </td>
                <td>
                    <?php echo 'R$' . number_format($valorTotal - $valorTotalRetido, 2, ',', '.'); ?>
                </td>
            </tr>
        </table>
    </div>

</div>