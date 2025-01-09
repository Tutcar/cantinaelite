<script>
    var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Abertura Caixa</div>
    <div class="base-lista">
        <div>
            <div class="text-end d-flex">
                <div class="text-end d-flex">
                    <?php if ($idAbre > 1) : ?>
                        <p><?php $this->verMsg(); ?> </p>
                    <?php elseif ($idAbre == 0) : ?>
                        <a href="<?php echo URL_BASE . "Caixaabre/create" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                        <?php endif; ?>&nbsp;
                        &nbsp;
                        &nbsp;
                </div>
                <div class="text-end d-flex">
                    <a title="Voltar" href="<?php echo URL_BASE . "Painel" ?>"><img style="width: 30px; height: 30px"
                            src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
                </div>&nbsp;
                &nbsp;
                &nbsp;

            </div>
        </div>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="center">Data</th>
                        <th align="center">Entrada</th>
                        <th align="center">Retirada</th>
                        <th align="center">Caixa Fechado</th>
                        <?php if ($idAbre > 0) : ?>
                            <th align="center">Ação</th>
                        <?php endif; ?>
                        <th hidden align="left">ID</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $caixaabre) { ?>
                        <tr>
                            <td align="center"><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $caixaabre->data_ab_caixa)->format('d/m/Y H:i:s'); ?></td>
                            <td align="right"><?php echo moedaBr($caixaabre->entrada) ?></td>
                            <td align="right"><?php echo moedaBr($caixaabre->retirada) ?></td>
                            <td align="center"><?php echo $caixaabre->fechado ?></td>
                            <td hidden><?php echo $caixaabre->id_caixaabre ?></td>
                            <?php if ($caixaabre->fechado == "N") : ?>
                                <td align="center">

                                    <a title="Editar" href="<?php echo URL_BASE . "Caixaabre/edit/" . $caixaabre->id_caixaabre ?>"><img
                                            style="width: 25px; height: 25px"
                                            src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a>
                                    <!--<a href="javascript:;" onclick="excluir3(this)" data-entidade="caixaabre" data-id="<?php echo $caixaabre->id_caixaabre ?>" class="btn btn-vermelho">Excluir</a>-->
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>

</section>