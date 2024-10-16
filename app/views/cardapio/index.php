<script>
    var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Lista dos cardapio</div>
    <div class="base-lista">
        <div>
            <div class="rows">
                <div class="text-end d-flex col-12">
                    <a href="<?php echo URL_BASE . "cardapio/index" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "atualizar.png"; ?>"></a>
                    <a href="<?php echo URL_BASE . "cardapio/create" ?>" class="d-inline-block mb-2"><img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "cadastro.jpeg"; ?>"></a>
                    <a data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i aria-hidden="true"></i> <img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
                </div>

            </div>

        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "cardapio/filtro"; ?>" method="post">
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
                        <th align="center">Nome</th>
                        <th align="center">Dia Semana</th>
                        <th align="center">Descrição</th>
                        <th hidden align="left">ID</th>
                        <th align="right">Venda</th>
                        <th align="center">Ação</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $cardapio) { ?>

                        <tr>
                            <?php foreach ($dias as $chave => $dia): ?>
                                <?php ($cardapio->dia == $chave) ? $diasemana = $dia : ''; ?>
                            <?php endforeach; ?>
                            <?php if ($cardapio->foto || "") : ?>
                                <?php $imagem = $cardapio->foto ?>
                            <?php else : ?>
                                <?php $imagem = 'camera.png' ?>
                            <?php endif; ?>
                            <td><img style="width: 50px; height: 50px" src="<?php echo URL_IMAGEM . $imagem ?>"></td>
                            <td><?php echo substr($cardapio->nome, 0, 20) ?></td>
                            <td><?php echo substr($diasemana, 0, 20) ?></td>
                            <td><?php echo substr($cardapio->descricao, 0, 20) ?></td>
                            <td hidden><?php echo $cardapio->id_cardapio ?></td>
                            <td align="right"><?php echo moedaBR($cardapio->venda) ?></td>
                            <td align="center">
                                <a href="<?php echo URL_BASE . "cardapio/edit/" . $cardapio->id_produtos ?>"><img
                                        style="width: 30px; height: 30px"
                                        src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a>
                                <a href="javascript:;" onclick="excluir(this)" data-entidade="cardapio" data-id="<?php echo $cardapio->id_produtos ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
        <a href="<?php echo URL_BASE . "Painel" ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>

</section>