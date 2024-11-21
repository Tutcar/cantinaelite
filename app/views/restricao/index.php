<section class="caixa">
    <div class="thead">Cadastro de Restrições</div>
    <?php $this->verMsg() ?>
    <div class="base-lista">
        <div class="tabela-responsiva">
            <form action="<?php echo URL_BASE . "Restricao/salvar" ?>" method="POST">
                <div class="col-12">
                    <div class="rows">
                        <div class="col-6">
                            <label for="id_aluno">Aluno:</label>
                            <select class="form-campo mt-3" name="id_cliente" id="id_cliente" required>
                                <option value="">Selecione um aluno</option>
                                <?php foreach ($clientes as $aluno): ?>
                                    <option value="<?= $aluno->id_cliente; ?>"
                                        <?= isset($selectedCliente) && $selectedCliente == $aluno->id_cliente ? 'selected' : ''; ?>>
                                        <?= $aluno->nm_nome; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="id_produto">Produto:</label>
                            <select class="form-campo mt-3" name="id_produtos" id="id_produtos" required>
                                <?php foreach ($produtos as $produto): ?>
                                    <option value="<?= $produto->id_produtos; ?>"><?= $produto->nome; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="id_restricoes" value="" />
                    <button type="submit" class="btn mt-3">Adicionar Restrição</button>
                </div>
            </form>
        </div>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>

                        <th align="center">ID</th>
                        <th align="center">Nome</th>
                        <th align="center">Ação</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($restricoes as $restricao) { ?>
                        <tr>

                            <td align="left"><?php echo $restricao->id_produtos ?></td>
                            <td align="left"><?php echo $restricao->nome ?></td>
                            <td align="center">
                                <a href="javascript:;" onclick="excluir(this)" data-entidade="restricoes" data-id="<?php echo $restricao->id_produtos ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a></a>
                            </td>
                            <!-- <td hidden align="right"><?php echo $cliente->id_cliente ?></td> -->
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</section>