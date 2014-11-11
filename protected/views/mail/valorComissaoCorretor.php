<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="pt_br" />
    </head>

    <body>

        <div class="container" id="page">

            <?php
                $logo = $historico->apartamento0->bloco0->empreendimento0->logo;
                $empreendimento = $historico->apartamento0->bloco0->empreendimento0->nome;
                $numeroAp = $historico->apartamento0->numero;
                $bloco = $historico->apartamento0->bloco0->descricao;
                $usuario = $historico->usuario0->nome;
                $fone = $historico->usuario0->telefone;
                $email = $historico->usuario0->email;
                $imobiliaria = $historico->usuario0->imobiliaria0->nome;
                $data = $historico->formatDate($historico->data);
                
                $valorComissaoCorretor = $historico->valorComissaoCorretor();
                $valorPagoCorretor = $historico->valorPagoCorretor();
            ?>

            <h2>Empreendimento <b><?php echo $empreendimento; ?></b></h2>
            
            <p>
                O apartamento <b><?php echo $numeroAp; ?></b> do bloco <b><?php echo $bloco; ?></b> teve novo valor de comissão do Corretor pago.
            </p>
            
            <p>
                Seguem os dados do corretor: <br/>
                Nome: <b><?php echo $usuario; ?> </b><br/>
                Email: <?php echo $email; ?> <br/>
                Telefone: <?php echo $fone; ?> <br/>
                Imobiliária: <b><?php echo $imobiliaria; ?> </b><br/>
            </p>
            
            <?php
                $clienteNome = $historico->cliente_nome;
                $clienteCpf = $historico->cliente_cpf;
                $valorAPagarCorretor = $historico->valorAPagarCorretor();
                $valorTotalComissao = $historico->valorComissaoCorretor();
            ?>
            
            <p>
                Cliente: <b><?php echo $clienteNome; ?></b> <br/>
                CPF: <b><?php echo $clienteCpf; ?></b>
            </p>
            
            <p>
                Segue os valores atuais da comissão:<br/>
                Novo valor pago: <b><?php echo 'R$' . number_format($novoValor, 2, ',', '.'); ?></b><br/>
                Valor total pago: <b><?php echo $valorPagoCorretor; ?></b><br/>
                Valor total da comissão do Corretor: <b><?php echo $valorTotalComissao; ?></b><br/>
                Valor a pagar: <b><?php echo $valorAPagarCorretor; ?></b><br/>
            </p>

            <div class="clear"></div>

            <div id="footer">
                Copyright &copy; <?php echo date('Y'); ?> by Dall Sistemas.<br/>
                All Rights Reserved.<br/>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>