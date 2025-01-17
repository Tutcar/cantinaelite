<script>
    var coluOr = 0;
</script>

<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Quantidade Marmitex: <?php echo $marmitexsContar["total_registros"]; ?> Valor: <?php echo moedaBr($marmitexsContar["soma_total"]); ?></div>
    <div class="base-lista">
        <div class="rows">
            <div class="text-end d-flex col-12">
                <a title="Voltar" href="<?php echo URL_BASE . "painel" ?>"><img style="width: 30px; height: 30px"
                        src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>&nbsp;
                <a title="Imprimir relatorio" href="<?php echo URL_BASE . "Pedidos/marmitexImp" ?>" class="d-inline-block mb-2"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . 'imprimirped.png'; ?>"></a>
            </div>

        </div>
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="left">Pedido</th>
                        <th align="left">Data</th>
                        <th align="center">Cliente</th>
                        <th align="center">Prato</th>
                        <th align="center">Observação</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($marmitexs as $marmitex) { ?>
                        <tr>
                            <td align="left"><?php echo $marmitex->id_pedidos ?></td>
                            <td align="center"><?php echo databr($marmitex->data_ab_pedido) ?></td>
                            <td align="left"><?php echo $marmitex->cli_p ?></td>
                            <td align="left"><?php echo $marmitex->nome ?></td>
                            <td align="left"><?php echo $marmitex->obs_cardapio ?></td>
                        </tr>
                    <?php } ?>

                </tbody>



            </table>
        </div>

    </div>

</section>