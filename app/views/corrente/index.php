<script>
    var coluOr = 3;
    var coluSoma = 6;
    var coluSomaC = 7;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Conta corrente
        <?php echo isset($corretoras->nome) ? substr($corretoras->nome, 0, 20) : null ?> - Saldo:
        <?php echo isset($saldo) ? moedaBr($saldo) : null ?> - Compensar:
        <?php echo isset($compensar) ? moedaBr($compensar) : null ?> - Saldo Lq.:
        <?php echo isset($saldoLq) ? moedaBr($saldoLq) : null ?></div>
    <div class="base-lista">
        <div>
            <div class="text-end d-flex">
                <a href="<?php echo URL_BASE . "corrente/index/?id_corretora=" . $_GET['id_corretora']  ?>"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "atualizar.png"; ?>">&nbsp;&nbsp;</a>
                <a href="<?php echo URL_BASE . "corrente/create/?id_corretora=" . $_GET['id_corretora']  ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                <a data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i aria-hidden="true"></i> <img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
            </div>
        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "corrente/filtro/?id_corretora=" . $_GET['id_corretora']  ?>" method="post">
                <div class="rows">
                    <div class="col-4">
                        <select onchange="mudarType(this.value)" name="campo">
                            <option selected>Selecione o valor...</option>
                            <option value="confirmaU">Lançamentos do dia</option>
                            <option value="nr_doc_banco">Nr.Doc. Banco</option>
                            <option value="confirmaN">A Compensado</option>
                            <option value="confirma">Compensado</option>
                            <option value="data_confirma">Data Compensação</option>
                            <option value="data_cad">Data Cadastro</option>
                            <option value="descricao">Desccrição</option>
                            <option value="valor_credito">Valor Credito</option>
                            <option value="valor_debito">Valor Debito</option>
                            <option value="cod_despesa">Codigo Despesa</option>
                            <option value="obs">Observações</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input hidden id="confCompensado" type="text"
                            value="<?php echo isset($compensado->max) ? $compensado->max : null ?>" name="valor3">
                        <input hidden id="confValor" type="text" name="valor2">
                        <input id="confData" type="text" required="required" value="" name="valorfiltro"
                            placeholder="Valor da pesquisar...">
                    </div>
                    <div class="col-2">
                        <input id="btnConf" type="submit" class="btn" value="pesquisar">
                    </div>
                </div>
                <input type="hidden" name="id_corretora" value="<?php echo $corretoras->id_corretora; ?>" />
            </form>
        </div>
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <div class="rows">
                <div hidden id="vlc" class="col-2">
                    <label>&nbsp;&nbsp;&nbsp;&nbsp; Credito</label>
                    <input id="valorCred" value="" class="form-campo">
                </div>
                <div hidden id="vld" class="col-2">
                    <label>&nbsp;&nbsp;&nbsp;&nbsp; Debito</label>
                    <input id="valorDbi" value="" class="form-campo">
                </div><br />
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">

                <thead>
                    <tr>
                        <th align="left">Doc Ban.</th>
                        <th hidden align="left">Cadastro.</th>
                        <th align="left">Desp.</th>
                        <th align="left">Cadastro.</th>
                        <th align="left">Descrição</th>
                        <th align="left">Doc Pg</th>
                        <th align="left">Debito</th>
                        <th align="left">Credito</th>
                        <th align="left">Comp.</th>
                        <th align="center">Ação</th>
                        <th hidden align="center">id_corrente</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista as $corrente) { ?>
                        <tr>
                            <td align="center"><?php echo substr($corrente->nr_doc_banco, 0, 8) ?></td>
                            <td hidden align="center"><?php echo moedaEN($corrente->data_cad) ?></td>
                            <td align="center"><?php echo substr($corrente->cod_despesa, 0, 8) ?></td>
                            <td align="center"><?php echo dataBr($corrente->data_cad) ?></td>
                            <td align="center"><?php echo substr($corrente->descricao, 0, 18) ?></td>
                            <td align="center"><?php echo substr($corrente->nr_doc_pg, 0, 10) ?></td>
                            <td align="center"><?php echo $corrente->valor_debito ?></td>
                            <td align="center"><?php echo $corrente->valor_credito ?></td>
                            <td align="center"><?php echo $corrente->confirma ?></td>
                            <td align="center">
                                <a href="<?php echo URL_BASE . "corrente/edit/" . $corrente->id_corrente . "/" . $corretoras->id_corretora ?>"><img style="width: 25px; height: 25px" src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a>
                                <a href="javascript:;" onclick="excluir(this)" data-entidade="corrente" data-id="<?php echo $corrente->id_corrente . "/" . $corretoras->id_corretora ?>"><img style="width: 25px; height: 25px"
                                        src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a>

                            </td>
                            <td hidden><?php echo $corrente->id_corrente ?></td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>

        </div>
        <a href="<?php echo URL_BASE . "corretora/index" ?>"><img style="width: 40px; height: 40px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>

</section>