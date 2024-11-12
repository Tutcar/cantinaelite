<script>
    var coluOr = 1;
</script>
<section class="caixa">
    <div class="base-lista">
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="center">Nome Produto</th>
                        <th align="center">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $producao) { ?>
                        <tr>
                            <td align="left"><?php echo $producao->nome ?></td>
                            <td align="center"><?php echo $producao->soma  ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="<?php echo URL_BASE . "Relatorios/index" ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
</section>