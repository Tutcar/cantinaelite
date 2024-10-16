<script>
var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Abertura Caixa</div>
    <div class="base-lista">
        <div>
            <div class="text-end d-flex">
                <?php if ($idAbre > 1) : ?>
                <p><?php $this->verMsg(); ?> </p>
                <?php elseif ($idAbre == 0) : ?>
                <a href="<?php echo URL_BASE . "Caixaabre/create" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                <?php endif; ?>
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
                        <th align="center">Ação</th>
                        <th hidden align="left">ID</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $caixaabre) { ?>
                    <tr>
                        <td align="right"><?php echo databr($caixaabre->data_ab_caixa) ?></td>
                        <td align="right"><?php echo moedaBr($caixaabre->entrada) ?></td>
                        <td align="right"><?php echo moedaBr($caixaabre->retirada) ?></td>
                        <td align="right"><?php echo $caixaabre->fechado ?></td>
                        <td hidden><?php echo $caixaabre->id_caixaabre ?></td>
                        <td align="center">
                            <?php if ($caixaabre->fechado == "N") : ?>
                            <a href="<?php echo URL_BASE . "Caixaabre/edit/" . $caixaabre->id_caixaabre ?>"
                                class="btn btn-verde">Editar</a>
                            <!--<a href="javascript:;" onclick="excluir3(this)" data-entidade="caixaabre" data-id="<?php echo $caixaabre->id_caixaabre ?>" class="btn btn-vermelho">Excluir</a>-->
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
    <a href="<?php echo URL_BASE . "Painel"?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
</section>