<script>
    var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Créditos <?php echo moedaBr($total_credito); ?> Debitos <?php echo moedaBr($total_debito); ?> Saldo <?php echo moedaBr($saldo_geral); ?></div>
    <div class="base-lista">

        <div>
            <div class="text-end d-flex">
                <a href="<?php echo URL_BASE . "painel" ?>"><img style="width: 40px; height: 40px"
                        src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
            </div>
        </div>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="center">Nome</th>
                        <th align="left">Créditos</th>
                        <th align="left">Debitos</th>
                        <th align="left">Saldo</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($creditosSaldos as $creditos) { ?>
                        <tr>
                            <td align="left"><?php echo $creditos["descricao"] ?></td>
                            <td align="right"><?php echo moedaBr($creditos["total_credito"]) ?></td>
                            <td align="right"><?php echo moedaBr($creditos["total_debito"]) ?></td>
                            <td align="right"><?php echo moedaBr($creditos["total_credito"] - $creditos["total_debito"]) ?></td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>
        </div>
    </div>
</section>