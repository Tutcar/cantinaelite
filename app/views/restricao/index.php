<script>
    var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead">Cadastro de Restrições</div>&nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    <div class="text-end d-flex">
        <a href="<?php echo URL_BASE . "Painel" ?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>&nbsp;
        &nbsp;
        &nbsp;
        &nbsp;
    </div>
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
                                <a href="javascript:;" onclick="excluir(this)" data-entidade="Restricao" data-id="<?php echo $restricao->id_restricoes ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.getElementById('id_cliente').addEventListener('change', function() {
            const idCliente = this.value;

            if (idCliente) {
                // Enviar requisição AJAX para buscar as restrições
                fetch(`<?php echo URL_BASE; ?>Restricao/listar/${idCliente}`)
                    .then(response => response.json())
                    .then(data => {
                        const tabelaBody = document.querySelector('#dataTable tbody');
                        tabelaBody.innerHTML = ''; // Limpar tabela

                        if (data.length > 0) {
                            data.forEach(restricao => {
                                const row = `
                            <tr>
                                <td align="left">${restricao.id_produtos}</td>
                                <td align="left">${restricao.nome}</td>
                                <td align="center">
                                    <a href="javascript:;" onclick="excluir(this)" data-entidade="Restricao" data-id="${restricao.id_restricoes}">
                                        <img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM; ?>excluir.png">
                                    </a>
                                </td>
                            </tr>
                        `;
                                tabelaBody.insertAdjacentHTML('beforeend', row);
                            });
                        } else {
                            tabelaBody.innerHTML = '<tr><td colspan="3" align="center">Nenhuma restrição encontrada.</td></tr>';
                        }
                    })
                    .catch(error => console.error('Erro ao buscar restrições:', error));
            }
        });
    </script>
</section>