<script>
    var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Todos as Compras Deste Cliente</div>
    <div class="base-lista">
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="left">Nome</th>
                        <th align="center">Data Pedido</th>
                        <th align="left">Nr. Pedido</th>
                        <th align="left">Cliente</th>
                        <th align="left">Valor</th>
                        <th align="left">Custo</th>
                        <th align="left">Margem</th>
                        <th hidden align="left">ID</th>
                        <th align="center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todosItens as $relatorios) { ?>
                        <tr>
                            <td align="left"><?php echo $relatorios->nome ?></td>
                            <td align="center"><?php echo dataBr($relatorios->data_ab_pedido) ?></td>
                            <td align="right"><?php echo $relatorios->nr_pedido ?></td>
                            <td align="left"><?php echo $relatorios->cliente ?></td>
                            <td align="right"><?php echo ($relatorios->valor) ? moedaBr($relatorios->valor) : moedaBr(0) ?></td>
                            <td align="right"><?php echo ($relatorios->custo) ? moedaBr($relatorios->custo) : moedaBr(0) ?></td>
                            <td align="right">
                                <?php echo ($relatorios->valor && $relatorios->custo) ? number_format(($relatorios->valor / $relatorios->custo) * 100) .  "%" : '0%'  ?></td>
                            </td>
                            <td hidden><?php echo $relatorios->id_pedidos ?></td>
                            <td align="center">
                                <a href="<?php echo URL_BASE . "Relatorios/index" ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="<?php echo URL_BASE . "Relatorios/index" ?>"><img style="width: 40px; height: 40px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>

</section>