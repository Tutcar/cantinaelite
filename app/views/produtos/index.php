<script>
    var coluOr = 2;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Lista dos Produtos</div>
    <div class="base-lista">
        <div>
            <div class="rows">
                <div class="text-end d-flex col-12">
                    <a title="Voltar" href="<?php echo URL_BASE . "painel" ?>"><img style="width: 30px; height: 30px"
                            src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>&nbsp;

                    <a title="Atualizar" href="<?php echo URL_BASE . "Produtos/index" ?>" class="d-inline-block mb-2"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "atualizar.png"; ?>"></a>
                    <a title="Cadastra" href="<?php echo URL_BASE . "Produtos/create" ?>" class="d-inline-block mb-2"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                    <a title="Pesquisar" data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i aria-hidden="true"></i> <img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
                </div>

            </div>

        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "Produtos/filtro"; ?>" method="post">
                <div class="rows">
                    <div class="col-4">
                        <select name="campo">
                            <option selected>nome</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="text" required="required" name="nome" placeholder="Valor da pesquisar...">
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn" value="Pesquisar">
                    </div>
                </div>
            </form>
        </div>
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="left">Foto</th>
                        <th align="left">Qte</th>
                        <th align="left">Nome</th>
                        <th align="left">Descrição</th>
                        <th align="left">Categoria</th>
                        <th align="left">Tipo</th>
                        <th hidden align="left">ID</th>
                        <th align="center">Custo</th>
                        <th align="center">Venda</th>
                        <th align="center">Ação</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $produtos) { ?>
                        <tr>
                            <?php if ($produtos->foto || "") : ?>
                                <?php $imagem = $produtos->foto ?>
                            <?php else : ?>
                                <?php $imagem = 'camera.png' ?>
                            <?php endif; ?>
                            <td><img style="width: 50px; height: 50px" src="<?php echo URL_IMAGEM . $imagem ?>">
                            </td>
                            <td><?php echo $produtos->quant ?></td>
                            <td><?php echo substr($produtos->nome, 0, 20) ?></td>
                            <td><?php echo substr($produtos->descricao, 0, 20) ?></td>
                            <td><?php echo substr($produtos->categorias, 0, 20) ?></td>
                            <td><?php echo $produtos->tipo ?></td>
                            <td hidden><?php echo $produtos->id_produtos ?></td>
                            <td><?php echo moedaBR($produtos->custo) ?></td>
                            <td><?php echo moedaBR($produtos->venda) ?></td>
                            <td align="center">
                                <a title="Editar" href="<?php echo URL_BASE . "produtos/edit/" . $produtos->id_produtos ?>"><img
                                        style="width: 25px; height: 25px"
                                        src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a>
                                <a title="Excluir" href="javascript:;" onclick="excluir(this)" data-entidade="produtos" data-id="<?php echo $produtos->id_produtos ?>"><img style="width: 25px; height: 25px" src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>

</section>