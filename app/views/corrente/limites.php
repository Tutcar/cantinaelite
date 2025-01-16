<script>
    var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Limites <?php echo moedaBr($saldo_total->saldo_total); ?></div>
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
                        <th align="left">Limite</th>
                        <th align="left">Crédito</th>
                        <th align="left">Débito</th>
                        <th align="left">Saldo</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista as $limite) { ?>
                        <tr>

                            <td align="left"><?php echo $limite->nome ?></td>
                            <td align="right"><?php echo moedaBr($limite->limite) ?></td>
                            <td align="right"><?php echo moedaBr($limite->valor_credito) ?></td>
                            <td align="right"><?php echo moedaBr($limite->valor_debito) ?></td>
                            <td align="right"><?php echo moedaBr($limite->saldo) ?></td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>
        </div>
    </div>
</section>