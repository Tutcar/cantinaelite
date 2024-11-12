<script>
var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Lista dos Caixas -
        Vendas:<?php echo isset($vendaTotal) ? moedaBR($vendaTotal) : null; ?> -
        Custo:<?php echo isset($custoTotal) ? moedaBR($custoTotal) : null; ?> -
        Margem:<?php echo isset($vendaTotal)?$vendaTotal: number_format(($vendaTotal / $custoTotal), 2, '.', ',') * 100; ?>%</div>
    <div class="base-lista">



        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="left">Data</th>
                        <th align="left">Entrada</th>
                        <th align="left">Retirada</th>
                        <th align="left">Fechado</th>
                        <th align="left">Venda</th>
                        <th align="left">Custo</th>
                        <th align="left">Margem</th>
                        <th hidden align="left">ID</th>
                        <th align="center">Ação</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $relatorios) { ?>
                    <tr>
                        <td><?php echo dataBr($relatorios->data_ab_caixa) ?></td>
                        <td align="right"><?php echo moedaBr($relatorios->entrada) ?></td>
                        <td align="right"><?php echo moedaBr($relatorios->retirada) ?></td>
                        <td align="right"><?php echo $relatorios->fechado ?></td>
                        <td align="right"><?php echo ($relatorios->valor) ? moedaBr($relatorios->valor) : moedaBr(0) ?></td>
                        <td align="right"><?php echo ($relatorios->custo) ? moedaBr($relatorios->custo) : moedaBr(0) ?></td>
                        <td align="right">
                            <?php echo ($relatorios->valor && $relatorios->custo) ? number_format(($relatorios->valor / $relatorios->custo) * 100) .  "%" : '0%'  ?></td>
                        <td hidden><?php echo $relatorios->id_relatorios ?></td>
                        <td align="center">
                            <a href="<?php echo URL_BASE . "Relatorios/relatDia/" . $relatorios->id_caixaabre ?>">&nbsp;&nbsp;<img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "lupa.png"; ?>"></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
        <a href="<?php echo URL_BASE . "Relatorios/index"?>" ><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>

</section>            
