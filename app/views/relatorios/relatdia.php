<script>
var coluOr = 1;
</script>

<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Lista dos Pedidos</div>
    <div class="base-lista">
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="left">Cliente</th>
                        <th align="center">Data Pedido</th>
                        <th align="left">Valor</th>
                        <th align="left">Custo</th>
                        <th align="left">Margem</th>
                        <th hidden align="left">ID</th>
                        <th align="center">Ação</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($relatDia as $relatorios) { ?>
                    <tr>
                        <td align="left"><?php echo $relatorios->cliente ?></td>
                        <td align="center"><?php echo dataBr($relatorios->data_ab_pedido) ?></td>
                        <td align="right"><?php echo ($relatorios->valor) ? moedaBr($relatorios->valor) : moedaBr(0) ?></td>
                        <td align="right"><?php echo ($relatorios->custo) ? moedaBr($relatorios->custo) : moedaBr(0) ?></td>
                        <td align="right">
                            <?php echo ($relatorios->valor && $relatorios->custo) ? number_format(($relatorios->valor / $relatorios->custo) * 100) .  "%" : '0%'  ?></td>
                        </td>
                        <td hidden><?php echo $relatorios->id_relatorios ?></td>
                        <td align="center">
                            <a href="<?php echo URL_BASE . "Relatorios/itensPedido/" . $relatorios->nr_pedido . "/" . $relatorios->cliente . "/" . $relatorios->data_ab_pedido ?>"
                                ><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "lupa.png"; ?>"></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
        <a href="<?php echo URL_BASE . "Relatorios/index"?>" ><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>

    </div>
</section>