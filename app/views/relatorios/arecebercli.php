<script>
    var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Pedidos a receber -
        Vendas:<?php echo isset($vendaTotal) ? moedaBR($vendaTotal) : null; ?> -
        Custo:<?php echo isset($custoTotal) ? moedaBR($custoTotal) : null; ?> -
        Margem:<?php echo ($vendaTotal > 0 && $custoTotal > 0) ? number_format(($vendaTotal / $custoTotal), 2, '.', ',') * 100 . "%" : " - s/custo"; ?>
    </div>
    <div class="base-lista">
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="left">Nome</th>
                        <th align="left">Quant.</th>
                        <th align="left">Valor</th>
                        <th align="left">Total</th>
                        <th align="left">Tipo</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $relatorios) { ?>
                        <tr>
                            <td><?php echo $relatorios->nome ?></td>
                            <td align="center"><?php echo $relatorios->quant ?></td>
                            <td align="right"><?php echo ($relatorios->valor) ? moedaBr($relatorios->valor) : moedaBr(0) ?></td>
                            <td align="right"><?php echo ($relatorios->valor && $relatorios->quant) ?  moedaBr($relatorios->valor * $relatorios->quant) : moedaBr(0) ?></td>
                            <td align="left"><?php echo ($relatorios->encomendas == "S") ? "Encomenda" : "Caixa" ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
        <a href="<?php echo URL_BASE . "Relatorios/areceber" ?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>

    </div>
</section>