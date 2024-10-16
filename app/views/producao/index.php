<script>
    var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Lista de Produção- Valor:R$ <?php echo ($valorProdTot) ? moedaBr($valorProdTot) : moedaBr(0); ?></div>

    <div class="base-lista">
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="center">Data para produção</th>
                        <th align="center">Ação</th>
                        <th hidden align="center">Id</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $producao) { ?>
                        <tr>
                            <td align="left"><?php echo $producao->data_encomendas ?></td>
                            <td align="center">
                            <a href="<?php echo URL_BASE . "Producao/ver/" . $producao->data_encomendas ?>" title="Ver Produção Dia">&nbsp;&nbsp;<img
                                    style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "lupa.png"; ?>"></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
        <a href="<?php echo URL_BASE . "Painel" ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>
</section>