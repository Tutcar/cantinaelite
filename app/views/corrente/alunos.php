<script>
    var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead">Extrato Alunos</div>
    <?php $this->verMsg() ?>
    <div class="base-lista">
        <div class="tabela-responsiva">
            <div class="col-12">
                <div class="rows">
                    <div class="col-6">
                        <label for="id_cliente">Aluno:</label>
                        <select class="form-campo mt-3" name="id_cliente" id="id_cliente" required>
                            <option value="">Selecione um aluno</option>
                            <?php foreach ($clientes as $aluno): ?>
                                <option value="<?= $aluno->nm_nome; ?>"
                                    <?= isset($selectedCliente) && $selectedCliente == $aluno->id_cliente ? 'selected' : ''; ?>>
                                    <?= $aluno->nm_nome; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="id_restricoes" value="" />
                <button id="openMdCreditos" class="btn mt-3" style="display: none;">Creditar</button>

            </div>

        </div>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="center">Data</th>
                        <th align="center">Crédito</th>
                        <th align="center">Débito</th>
                        <th align="center">Descrição</th>
                        <th hidden align="center">Pedido</th>
                        <th align="center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($correntes as $corrente) { ?>
                        <tr>
                            <td align="left"><?php echo ($corrente->data_cad) ? formatarDataBr($corrente->data_cad) : ""  ?></td>
                            <td align="right"><?php echo ($corrente->valor_credito) ? moedaBr($corrente->valor_credito) : "" ?></td>
                            <td align="right"><?php echo ($corrente->valor_debito) ? moedaBr($corrente->valor_debito) : "" ?></td>
                            <td align="left"><?php echo ($corrente->obs) ? $corrente->obs : "" ?></td>
                            <td hidden><?php echo ($corrente->nr_doc_pg) ? $corrente->nr_doc_pg : "" ?></td>
                            <td align="center">
                                <?php if ($corrente->valor_credito == 0) : ?>
                                    <a href="<?php echo URL_BASE . "Relatorios/itensPedido/" . $corrente->nr_doc_pg . "/" . $corrente->descricao . "/" . date('Y-m-d', strtotime($corrente->data_cad)) . "/" . "ext" ?>"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "lupa.png"; ?>"></a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>
    document.getElementById("id_cliente").addEventListener("change", function() {
        const clienteNome = this.value;

        if (clienteNome) {
            fetch(`<?php echo URL_BASE; ?>Corrente/obterCorrentes/${clienteNome}`)
                .then(response => response.json()) // Processa como JSON
                .then(data => {
                    const tbody = document.querySelector("#dataTable tbody");

                    // Limpa a tabela antes de processar novos dados
                    tbody.innerHTML = "";

                    if (data.error) {
                        console.warn(`Erro do servidor: ${data.error}`);
                        // Opcional: Exibe uma mensagem na tabela ou em outro local
                        tbody.insertAdjacentHTML("beforeend", `
                        <tr>
                            <td colspan="5" align="center">Nenhum registro encontrado para este cliente.</td>
                        </tr>
                    `);
                    } else {
                        atualizarTabela(data);
                    }
                })
                .catch(error => {
                    console.error("Erro ao buscar correntes:", error);
                    alert("Erro ao buscar correntes. Verifique o console para mais detalhes.");
                });
        }
    });

    function atualizarTabela(correntes) {
        const tbody = document.querySelector("#dataTable tbody");

        correntes.forEach(corrente => {
            const row = `
            <tr>
                <td align="left">${corrente.data_cad}</td>
                <td align="right">${corrente.valor_credito}</td>
                <td align="right">${corrente.valor_debito}</td>
                <td align="left">${corrente.obs}</td>
                <td hidden>${corrente.nr_doc_pg}</td>
                <td align="center">
                    ${corrente.valor_credito == 0 ? `<a href="<?php echo URL_BASE; ?>Relatorios/itensPedido/${corrente.nr_doc_pg}/${corrente.descricao}/${corrente.data_cad}/ext"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM; ?>lupa.png"></a>` : ""}
                </td>
            </tr>
        `;
            tbody.insertAdjacentHTML("beforeend", row);
        });
    }
</script>
<!-- Modal -->
<section class="caixa">
    <div class="base-form">
        <div class="caixa-form">
            <div id="modalCrdAl" class="modalCrdAl" style="display: none;">
                <div class="modal-content">
                    <span id="closeModalCrdAl" class="close">&times;</span>
                    <div class="thead">Cadastro de Crédito</div>
                    <form id="formCreditos" method="POST" action="<?php echo URL_BASE . "Corrente/salvarCrd" ?>">
                        <div class="col-12">
                            <div class="rows">
                                <div class="col-12">
                                    <label for="nome">Nome:</label>
                                    <input class="form-campo" type="text" id="nome" name="nome" readonly required><br><br>
                                    <label for="valorCredito">Valor de Crédito:</label>
                                    <input
                                        class="form-campo"
                                        type="text"
                                        id="valorCredito"
                                        name="valorCredito"
                                        required
                                        placeholder="0,00" />
                                    <br><br>
                                </div>
                                <button type="submit" class="btn mt-3">Adicionar Crédito</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    /* Estilos do Modal */
    .modalCrdAl {
        display: none;
        /* Escondido por padrão */
        position: fixed;
        /* Fixo na tela */
        z-index: 1;
        /* Colocado acima de outros elementos */
        left: 0;
        top: 0;
        width: 100%;
        /* Largura total */
        height: 100%;
        /* Altura total */
        overflow: auto;
        /* Permite rolar se necessário */
        background-color: rgba(0, 0, 0, 0.4);
        /* Cor de fundo semitransparente */
    }

    /* Conteúdo do modal */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 400px;
    }

    /* Estilo do botão de fechar */
    .close {
        margin-top: 10px;
        margin-right: 10px;
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
<script>
    // Obtendo elementos
    const modalCrdAl = document.getElementById('modalCrdAl');
    const openModalCreditos = document.getElementById('openMdCreditos');
    const closeModalCrdAl = document.getElementById('closeModalCrdAl');

    // Abrir o modal
    openModalCreditos.onclick = function() {
        modalCrdAl.style.display = 'block';
    }

    // Fechar o modal
    closeModalCrdAl.onclick = function() {
        modalCrdAl.style.display = 'none';
    }

    // Fechar o modal clicando fora do conteúdo
    window.onclick = function(event) {
        if (event.target === modalCrdAl) {
            modalCrdAl.style.display = 'none';
        }
    }

    // Exemplo de manipulação do envio do formulário
    document.getElementById('valorCredito').addEventListener('input', function(event) {
        let value = event.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        value = (value / 100).toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
        event.target.value = value;
    });

    // Elementos HTML
    const selectCliente = document.getElementById('id_cliente');
    const btnCreditar = document.getElementById('openMdCreditos');
    const modal = document.getElementById('modalCrdAl');
    const closeModal = document.getElementById('closeModalCrdAl');
    const inputNome = document.getElementById('nome');

    // Mostrar botão ao selecionar cliente
    selectCliente.addEventListener('change', function() {
        if (this.value) {
            btnCreditar.style.display = 'block';
        } else {
            btnCreditar.style.display = 'none';
        }
    });

    // Abrir modal e passar valor do select
    btnCreditar.addEventListener('click', function() {
        const nomeSelecionado = selectCliente.value;
        if (nomeSelecionado) {
            inputNome.value = nomeSelecionado; // Passa o nome selecionado para o campo do modal
            modal.style.display = 'block'; // Exibe o modal
        }
    });

    // Fechar modal
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none'; // Esconde o modal
    });

    // Fechar modal ao clicar fora dele
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    const inputValorCredito = document.getElementById('valorCredito');

    // Função para formatar como moeda
    function formatarMoeda(valor) {
        const numeroLimpo = valor.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        const numeroFormatado = (numeroLimpo / 100).toLocaleString('pt-BR', {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
        return numeroFormatado;
    }

    // Adiciona evento ao campo para formatar durante a digitação
    inputValorCredito.addEventListener('input', function(event) {
        this.value = formatarMoeda(this.value);
    });

    // Foca automaticamente no campo ao abrir o modal
    btnCreditar.addEventListener('click', function() {
        modal.style.display = 'block'; // Abre o modal
        inputNome.value = selectCliente.value; // Passa o nome selecionado
        setTimeout(() => {
            inputValorCredito.focus(); // Foca no campo de valor
        }, 100); // Adiciona pequeno atraso para garantir que o modal foi exibido
    });
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none'; // Esconde o modal
        inputValorCredito.value = ''; // Limpa o campo de valor
    });
</script>