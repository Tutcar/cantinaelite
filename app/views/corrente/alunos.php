<script>
    var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead">Saldo : <?php echo (isset($credito)) ? moedaBr($credito) : moedaBr(0); ?> Limite: <?php echo (isset($limite)) ? moedaBr($limite) : moedaBr(0); ?> Total: <?php echo moedaBr($credito + $limite); ?></div>
    <?php $this->verMsg() ?>
    <div class="base-lista">
        <div class="text-end d-flex">
            <a href="<?php echo URL_BASE . "/painel" ?>"><img style="width: 30px; height: 30px"
                    src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
        </div>
        <div class="tabela-responsiva">
            <div class="col-12">
                <div class="rows">
                    <div class="col-6">
                        <label for="id_cliente">Aluno: <?php echo (isset($clienteAl)) ? $clienteAl : ""; ?></label>

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
                <button id="openMdCreditos" class="btn mt-3">Crédito ou Débito</button>
                <!-- <button id="openMdCreditos" class="btn mt-3" style="display: none;">Creditar</button> -->
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
                                <?php if ($corrente->valor_credito == 0 && explode(' ', $corrente->obs)[0] != "Débito") : ?>
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
        // Atualiza o nome do aluno no label
        const labelAluno = document.querySelector('label[for="id_cliente"]');
        if (labelAluno) {
            labelAluno.innerHTML = `Aluno: ${clienteNome || ""}`;
        }

        if (clienteNome) {
            fetch(`<?php echo URL_BASE; ?>Corrente/obterCorrentes/${clienteNome}`)
                .then(response => response.json()) // Processa como JSON
                .then(data => {
                    const tbody = document.querySelector("#dataTable tbody");
                    const saldoDisplay = document.querySelector(".thead");

                    // Limpa a tabela antes de processar novos dados
                    saldoDisplay.innerHTML = "";
                    saldoDisplay.innerHTML = `
                    Saldo: ${moedaBr(data?.credito || 0)} 
                    Limite: ${moedaBr(data?.limite || 0)} 
                    Total: ${moedaBr((data?.credito || 0) + (data?.limite || 0))}
                `;
                    tbody.innerHTML = "";

                    if (data.error) {
                        console.warn(`Erro do servidor: ${data.error}`);
                        // Exibe mensagem de erro na tabela
                        tbody.insertAdjacentHTML("beforeend", `
                        <tr>
                            <td colspan="6" align="center">${data.error}</td>
                        </tr>
                    `);
                    } else {
                        // Atualiza a tabela com os dados recebidos
                        atualizarTabela(data.correntes);

                        // Atualiza o saldo, limite e total na interface
                        saldoDisplay.innerHTML = `
                        Saldo: ${moedaBr(data.credito)} 
                        Limite: ${moedaBr(data.limite)} 
                        Total: ${moedaBr(data.credito + data.limite)}
                    `;
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
            // Verifica se a primeira palavra de `corrente.obs` é "Débito"
            const isDebito = (corrente.obs || "").trim().startsWith("Débito");

            tbody.insertAdjacentHTML("beforeend", `
            <tr>
                <td align="left">${corrente.data_cad ? formatarDataBr(corrente.data_cad) : ""}</td>
                <td align="right">${corrente.valor_credito ? moedaBr(corrente.valor_credito) : ""}</td>
                <td align="right">${corrente.valor_debito ? moedaBr(corrente.valor_debito) : ""}</td>
                <td align="left">${corrente.obs || ""}</td>
                <td hidden>${corrente.nr_doc_pg || ""}</td>
                <td align="center">
                    ${(corrente.valor_credito == 0 && !isDebito) 
                        ? `<a href="<?php echo URL_BASE; ?>Relatorios/itensPedido/${corrente.nr_doc_pg}/${corrente.descricao}/${corrente.data_cad}/ext">
                               <img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM; ?>lupa.png">
                           </a>` 
                        : ""}
                </td>
            </tr>
        `);
        });
    }


    const moedaBr = valor => {
        if (valor === null || valor === undefined || isNaN(valor)) {
            return ""; // Retorna vazio para valores inválidos
        }
        return new Intl.NumberFormat('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(valor);
    };

    // Atualiza o saldo, limite e total na interface
    saldoDisplay.innerHTML = ""; // Garante que o campo será limpo antes de atualizar
    saldoDisplay.innerHTML = `
    Saldo: ${moedaBr(data?.credito || 0)} 
    Limite: ${moedaBr(data?.limite || 0)} 
    Total: ${moedaBr((data?.credito || 0) + (data?.limite || 0))}
`;

    function formatarDataBr(data) {
        const date = new Date(data);
        return date.toLocaleDateString('pt-BR');
    }
</script>
<!-- Modal -->
<section class="caixa">
    <div class="base-form">
        <div class="caixa-form">
            <div id="modalCrdAl" class="modalCrdAl" style="display: none;">
                <div class="modal-content">
                    <span id="closeModalCrdAl" class="close">&times;</span>
                    <div class="thead">Cadastro de Crédito/Débito</div>
                    <form id="formCreditos" method="POST" action="<?php echo URL_BASE . "Corrente/salvarCrd" ?>">
                        <div class="col-12">
                            <div class="rows">
                                <div class="col-12">
                                    <label for="nome">Nome:</label>
                                    <input class="form-campo" type="text" id="nome" name="nome" readonly required><br><br>

                                    <label for="tipoOperacao">Tipo de Operação:</label>
                                    <select class="form-campo" id="tipoOperacao" name="tipoOperacao" required>
                                        <option value="credito" selected>Crédito</option>
                                        <option value="debito">Débito</option>
                                    </select>
                                    <br><br>

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
    const selectCliente = document.getElementById('id_cliente');
    const inputNome = document.getElementById('nome');
    const inputValorCredito = document.getElementById('valorCredito');

    // Função para formatar como moeda
    function formatarMoeda(valor) {
        const numeroLimpo = valor.replace(/\D/g, ''); // Remove caracteres não numéricos
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

    // Função para limpar campos do modal
    function limparCamposModal() {
        console.log("Limpando campos do modal...");
        inputNome.value = ''; // Limpa o nome
        inputValorCredito.value = ''; // Limpa o valor do crédito
    }

    // Abrir o modal com validação
    openModalCreditos.onclick = function() {
        // Verificar se um cliente foi selecionado
        if (!selectCliente.value) {

            return; // Interrompe a execução se nenhum cliente estiver selecionado
        }

        console.log("Abrindo modal...");
        limparCamposModal(); // Limpa os campos antes de abrir
        inputNome.value = selectCliente.options[selectCliente.selectedIndex].text; // Preenche o nome no modal
        modalCrdAl.style.display = 'block';
        setTimeout(() => {
            inputValorCredito.focus(); // Foca no campo de valor
        }, 100); // Garante o foco após exibir o modal
    };


    // Fechar o modal
    closeModalCrdAl.onclick = function() {
        console.log("Fechando modal...");
        modalCrdAl.style.display = 'none'; // Esconde o modal
        limparCamposModal(); // Garante a limpeza ao fechar
    };

    // Fechar o modal clicando fora do conteúdo
    window.onclick = function(event) {
        if (event.target === modalCrdAl) {
            console.log("Fechando modal ao clicar fora...");
            modalCrdAl.style.display = 'none';
            limparCamposModal(); // Garante a limpeza ao clicar fora
        }
    };

    // Mostrar botão ao selecionar cliente
    selectCliente.addEventListener('change', function() {
        const btnCreditar = document.getElementById('openMdCreditos');
        if (this.value) {
            btnCreditar.style.display = 'block';
        } else {
            btnCreditar.style.display = 'none';
        }
    });
</script>
<script>
    // Capturar o botão e o select
    document.getElementById('openMdCreditos').addEventListener('click', function() {
        // Obtém o valor selecionado no select
        const alunoSelecionado = document.getElementById('id_cliente').value;

        // Verifica se um valor foi selecionado
        if (!alunoSelecionado) {
            alert("Por favor, selecione um aluno!");
            return;
        }

        // Define o valor no campo do modal
        document.getElementById('nome').value = alunoSelecionado;

        // Exibe o modal
        document.getElementById('modalCrdAl').style.display = 'block';
    });

    // Fechar o modal
    document.getElementById('closeModalCrdAl').addEventListener('click', function() {
        document.getElementById('modalCrdAl').style.display = 'none';
    });
</script>