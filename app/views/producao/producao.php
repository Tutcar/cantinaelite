<script>
var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Produção para  - <?php echo databr($datap);?></div>
    <div class="base-lista">
        
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>

                        <th align="center">Nome Produto</th>
                        <th align="center">Quantidade</th>
                        <th align="center">Cliente</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $producao) { ?>
                    <tr>

                        <td align="left"><?php echo $producao->nome ?></td>
                        <td align="center"><?php echo $producao->quant  ?></td>
                        <td align="left"><?php echo $producao->cli_p ?></td>
                    </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo URL_BASE . "Producao/index"?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    <a title="Ver quandidade a produzir." href="<?php echo  (isset($producao->data_encomendas)) ?  URL_BASE . "Producao/produzir/" . $producao->data_encomendas : "" ?>">&nbsp;&nbsp;<img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "lupa.png"; ?>"></a>

</section>