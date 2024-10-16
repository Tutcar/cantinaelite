<script>
    var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Lista de bancos</div>
    <div class="base-lista">

        <div>
            <div class="text-end d-flex">
                <a href="<?php echo URL_BASE . "corretora/index" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "atualizar.png"; ?>">&nbsp;&nbsp;</a>
                <a href="<?php echo URL_BASE . "corretora/create" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                <a data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i aria-hidden="true"></i> <img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
            </div>
        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "corretora/filtro"; ?>" method="post">
                <div class="rows">
                    <div class="col-4">
                        <select name="campo">
                            <option value="nome">Corretora</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="text" required="required" name="valorfiltro" placeholder="Valor da pesquisar...">
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn" value="pesquisar">
                    </div>
                </div>
            </form>
        </div>
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="left">Nome</th>
                        <th align="left">Nr. Banco</th>
                        <th align="left">Nr. Agencia</th>
                        <th align="left">Nr.Conta.</th>
                        <th align="center">Ação</th>
                        <th hidden align="center">id_corretora</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista as $corretora) { ?>
                        <tr>

                            <td align="center"><?php echo $corretora->nome ?></td>
                            <td align="center"><?php echo $corretora->nr_banco ?></td>
                            <td align="center"><?php echo $corretora->nr_agencia ?></td>
                            <td align="center"><?php echo $corretora->nr_conta ?></td>
                            <td align="center">
                                <a href="<?php echo URL_BASE . "corrente" . "/index/?id_corretora=" . $corretora->id_corretora ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "banco.png"; ?>"></a>
                            </td>
                            <td style="color:white" hidden><?php echo $corretora->id_corretora ?></td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>
        </div>
        <a href="<?php echo URL_BASE . "painel" ?>"><img style="width: 40px; height: 40px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>
</section>