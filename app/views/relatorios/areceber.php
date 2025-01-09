<script>
    var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Pedidos a receber -
        Vendas:<?php echo isset($vendaTotal) ? moedaBR($vendaTotal) : null; ?> -
        Custo:<?php echo isset($custoTotal) ? moedaBR($custoTotal) : null; ?> -
        Margem:<?php echo ($vendaTotal > 0 && $custoTotal > 0) ? number_format(($vendaTotal / $custoTotal), 2, '.', ',') * 100 . "%" : " - s/custo"; ?>
    </div>&nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    <div class="text-end d-flex">
        <a title="Voltar" href="<?php echo URL_BASE . "painel" ?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>&nbsp;
        &nbsp;
        &nbsp;
        &nbsp;
    </div>

    <div class="base-lista">



        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="left">Data</th>
                        <th align="left">Cliente</th>
                        <th align="left">Tipo</th>
                        <th hidden align="left">ID</th>
                        <th align="center">Ação</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $relatorios) { ?>
                        <tr>
                            <td><?php echo dataBr($relatorios->data_ab_pedido) ?></td>
                            <td align="left"><?php echo $relatorios->cliente ?></td>
                            <td align="left"><?php echo ($relatorios->encomendas == "S") ? "Encomenda" : "Caixa" ?></td>
                            <td hidden><?php echo $relatorios->nr_pedido ?></td>
                            <td align="center">
                                <a title="Verificar" href="<?php echo URL_BASE . "Relatorios/areceberCli/" . $relatorios->nr_pedido ?>">&nbsp;&nbsp;<img
                                        style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "lupa.png"; ?>"></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</section>