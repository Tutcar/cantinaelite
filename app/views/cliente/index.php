<script>
    var coluOr = 1;
</script>

<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Lista de Cliente</div>
    <div class="base-lista">
        <div>
            <div class="text-end d-flex">
                <a title="Voltar" href="<?php echo URL_BASE . "Painel" ?>"><img style="width: 30px; height: 30px"
                        src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>&nbsp;
                <a title="Atualizar" href="<?php echo URL_BASE . "cliente/index" ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "atualizar.png"; ?>"></a>
                <a title="Cadastrar" href="<?php echo URL_BASE . "cliente/create" ?>" class="d-inline-block mb-2"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                <a title="Pesquisar" data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i aria-hidden="true"></i> <img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
            </div>
        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "cliente/filtro"; ?>" method="post">
                <div class="rows">
                    <div class="col-4">
                        <!-- Elemento select -->
                        <select name="campo" id="campoSelect" onchange="atualizarInput()">
                            <option value="nm_nome" selected>Nome</option>
                            <option value="nr_cpf_cnpj">Cpf/Cnpj</option>
                            <option value="limites">Limites</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <!-- Campo de entrada -->
                        <input type="text" value="" required="required" name="pesqFiltrar" id="pesqFiltrar" placeholder="Valor da pesquisa...">
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn-roxo" value="Pesquisar">
                    </div>
                </div>
            </form>
        </div>

        <!-- Script para atualizar o campo de entrada -->
        <script>
            function atualizarInput() {
                const selectElement = document.getElementById('campoSelect');
                const inputElement = document.getElementById('pesqFiltrar');

                // Verifica se a opção "Limites" está selecionada
                if (selectElement.value === 'limites') {
                    inputElement.value = 'limite';
                } else {
                    inputElement.value = ''; // Limpa o input para outras opções
                }
            }
        </script>


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
                                <a title="Editar" href="<?php echo URL_BASE . "cliente/edit/" . $cliente->id_cliente ?>"><img
                                        style="width: 25px; height: 25px"
                                        src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a></a>
                                <!-- <a href="javascript:;" onclick="excluir(this)" data-entidade="cliente" data-id="<?php echo $cliente->id_cliente ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a></a> -->
                            </td>
                            <td hidden align="right"><?php echo $cliente->id_cliente ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</section>