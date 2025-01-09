<script>
    var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Itens Deste Pedido</div>
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
                        <th hidden align="left">ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($relatItem as $relatorios) { ?>
                        <tr>
                            <td align="left"><?php echo $relatorios->nome ?></td>
                            <td align="center"><?php echo dataBr($relatorios->data_ab_pedido) ?></td>
                            <td align="right"><?php echo $relatorios->nr_pedido ?></td>
                            <td align="left"><?php echo $relatorios->cliente ?></td>
                            <td align="right"><?php echo ($relatorios->valor) ? moedaBr($relatorios->valor) : moedaBr(0) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <a title="Voltar" href="<?php echo URL_BASE . "Corrente/obterCorrentesSjson/" . $relatorios->cliente ?>"><img style="width: 40px; height: 40px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>

    </div>
</section>