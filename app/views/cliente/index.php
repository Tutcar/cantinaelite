<script>
    var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Lista de Cliente</div>
    <div class="base-lista">
        <div>
            <div class="text-end d-flex">
                <a href="<?php echo URL_BASE . "cliente/index" ?>"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "atualizar.png"; ?>"></a>
                <a href="<?php echo URL_BASE . "cliente/create" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                <a data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i aria-hidden="true"></i> <img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
            </div>
        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "cliente/filtro"; ?>" method="post">
                <div class="rows">
                    <div class="col-4">
                        <select name="campo">
                            <option value="nm_nome" selected>nome</option>
                            <option value="nr_cpf_cnpj" selected>Cpf/Cnpj</option>
                        </select>

                    </div>
                    <div class="col-6">
                        <input type="text" required="required" name="pesqFiltrar" placeholder="Valor da pesquisar...">
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn-roxo" value="Pesquisar">
                    </div>
                </div>
            </form>
        </div>


        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>

                        <th align="center">Aluno</th>
                        <th align="center">Telefone</th>
                        <th align="center">CPF/CNPJ</th>
                        <th align="center">Cidade</th>
                        <th align="center">Ação</th>
                        <th hidden align="center">Id</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $cliente) { ?>
                        <tr>

                            <td align="left"><?php echo $cliente->nm_nome ?></td>
                            <td align="right"><?php echo $cliente->nr_fone ?></td>
                            <td align="right"><?php echo $cliente->nr_cpf_cnpj ?></td>
                            <td align="right"><?php echo $cliente->nm_cidade ?></td>
                            <td align="center">
                                <a href="<?php echo URL_BASE . "cliente/edit/" . $cliente->id_cliente ?>"><img
                                        style="width: 30px; height: 30px"
                                        src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a></a>
                                <a href="javascript:;" onclick="excluir(this)" data-entidade="cliente" data-id="<?php echo $cliente->id_cliente ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a></a>
                            </td>
                            <td hidden align="right"><?php echo $cliente->id_cliente ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
        <a href="<?php echo URL_BASE . "Painel" ?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>
</section>