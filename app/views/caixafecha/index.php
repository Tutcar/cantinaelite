<script>
    var coluOr = 1;
</script>
<section class="caixa">
    <?php if ($_SESSION["verifCx"] > 0) : ?>
        <div class="thead">Fechar Caixa do Dia - <?php echo DateTime::createFromFormat('Y-m-d H:i:s', $dataCx->data_ab_caixa)->format('d/m/Y H:i:s'); ?></div>
    <?php endif; ?>
    <?php if ($idAbre == 0) : ?>
        <p><?php $this->verMsg(); ?> </p>
    <?php elseif ($idAbre == 1) : ?>
        <div class="thead"><i class="ico lista"></i> Valor inicial:<?php echo moedaBr($dataCx->entrada); ?> - Venda do dia:<?php echo moedaBr($dinheiro); ?> - Retirada:<?php echo moedaBr($dataCx->retirada); ?> - Caixa final:<?php echo moedaBr($idAbreValor + $dinheiro); ?></div>
    <?php endif; ?>
    <div class="base-lista">
        <div>
            <div class="text-end d-flex">
                <a title="Voltar" href="<?php echo URL_BASE . "Painel" ?>"><img style="width: 30px; height: 30px"
                        src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>&nbsp;
                &nbsp;
                &nbsp;
                &nbsp;

                <?php if ($idAbre == 0) : ?>
                    <p><?php $this->verMsg(); ?> </p>
                <?php elseif ($idAbre > 0) : ?>
                    <a title="Fechar caixa" href="<?php echo URL_BASE . "Caixafecha/create/" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                <?php endif; ?>
            </div>
        </div>
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="left">Dinheiro</th>
                        <th align="left">Cartao</th>
                        <th align="left">Pix</th>
                        <th align="left">Alunos</th>
                        <th align="left">Pedidos</th>
                        <th align="left">Créditos</th>
                        <th align="left">Saldo</th>
                        <th hidden align="left">ID</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="center"><?php echo moedaBr($dinheiro) ?></td>
                        <td align="center"><?php echo moedaBr($cartao) ?></td>
                        <td align="center"><?php echo moedaBr($pix) ?></td>
                        <td align="center"><?php echo moedaBr($outros) ?></td>
                        <td align="center"><?php echo moedaBr($pedidos_ab) ?></td>
                        <td align="center"><?php echo moedaBr($creditos) ?></td>
                        <td align="center"><?php echo moedaBr($saldo) ?></td>
                        <td hidden><?php echo $caixafecha->id_caixafecha ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="base-lista">
        <?php foreach ($cxfuncionarios as $funcionario) { ?>
            <div class="tabela-responsiva">
                <label>Caixa de: <?php echo $funcionario->login_cli; ?></label>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                    <thead>
                        <tr>
                            <th align="center">Dinheiro</th>
                            <th align="center">Cartao</th>
                            <th align="center">Pix</th>
                            <th align="center">Alunos</th>
                            <th align="center">Créditos</th>
                            <th align="center">Saldo</th>
                            <th hidden align="left">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center"><?php echo moedaBr($funcionario->total_dinheiro) ?></td>
                            <td align="center"><?php echo moedaBr($funcionario->total_cartao) ?></td>
                            <td align="center"><?php echo moedaBr($funcionario->total_pix) ?></td>
                            <td align="center"><?php echo moedaBr($funcionario->total_outros) ?></td>
                            <td align="center"><?php echo moedaBr($funcionario->total_creditos) ?></td>
                            <td align="center"><?php echo moedaBr($funcionario->total_dinheiro + $funcionario->total_cartao + $funcionario->total_pix + $funcionario->total_outros + $funcionario->total_creditos) ?></td>
                            <td hidden><?php echo $caixafecha->id_caixafecha ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-end d-flex">
                    <a title="Ver resumo" href="<?php echo URL_BASE . "Caixafecha/caixaFuncionarios/$funcionario->id_user" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>