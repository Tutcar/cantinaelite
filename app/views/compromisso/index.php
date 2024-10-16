<script>
    var coluOr = 1;
</script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script src="<?php echo URL_BASE ?>assets/js/componentes/js_data_table2.js"></script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Compromissos</div>
    <div class="base-lista">

        <div>
            <div class="text-end d-flex">
                <a href="<?php echo URL_BASE . "compromisso/index" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "atualizar.png"; ?>"></a>
                <a href="<?php echo URL_BASE . "compromisso/create" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                <a data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i  aria-hidden="true"></i> <img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
            </div>
        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "compromisso/filtro"; ?>" method="post">
                <div class="rows">
                    <div class="col-4">
                        <select onchange="mudarType(this.value)" name="campo">
                            <option value="descricao">Descrição</option>
                            <option value="data_comp">Data Compromisso</option>
                            <option value="data_compM">Compromisso a realizar</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input id="confData" type="text" required="required" name="valorfiltro" placeholder="Valor da pesquisar...">
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
                        <th align="left">Data Compromisso.</th>
                        <th align="left">Descrição</th>
                        <th hidden align="center">id_compromisso</th>
                        <th align="center">Ação</th>
                        <th hidden align="left">Data Compromisso.</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista as $compromisso) { ?>
                        <tr>
                            <td align="center"><?php echo dataBr($compromisso->data_comp) ?></td>
                            <td align="left"><?php echo substr($compromisso->descricao, 0, 60) ?></td>
                            <td hidden><?php echo $compromisso->id_compromisso ?></td>
                            <td align="center">
                                <a href="<?php echo URL_BASE . "compromisso/edit/" . $compromisso->id_compromisso ?>" ><img style="width: 25px; height: 25px" src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a>
                                <a href="javascript:;" onclick="excluirCom(this)" data-entidade="compromisso" data-id="<?php echo $compromisso->id_compromisso ?>" ><img style="width: 25px; height: 25px" src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a>
                            </td>
                            <td hidden align="center"><?php echo dataEn($compromisso->data_comp) ?></td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>
        </div>
        <a href="<?php echo URL_BASE . "painel"?>"><img style="width: 40px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>
</section>