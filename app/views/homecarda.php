<!-- O Modal -->

<div id="myModalcarda" class="modalcarda">
    <!-- Conteúdo do Modal -->
    <div class="modalcarda-content">
        <div id="links-fixos" class="hidden-md-down">
            <span title="Fechar" class="closecarda">&times;</span>
        </div>
        <h2 class="h2carda">Cardápio da Semana</h2>
        <section class="cardapio" id="cardapio">
            <form>
                <?php foreach ($pratoss as $prato) { ?>
                    <div class="itens-cardapio">

                        <div class="card">
                            <div class="h2span">
                                <h2><span><?php echo $prato->diaPorExtenso; ?></span></h2>
                            </div>
                            <img src="<?php echo URL_IMAGEM . $prato->foto ?>" alt="">
                            <div class="info">
                                <h2 hidden><?php echo $prato->id_produtos; ?></h2>
                                <h2 class="prato"><?php echo $prato->nome; ?></h2>
                                <p><?php echo $prato->descricao ?></p>

                            </div>
                        </div>

                    </div>
                <?php } ?>
                <div class="divt">.</div>
            </form>
        </section>
    </div>
</div>
<!-- Fim do Modal -->
<!--Modal pi -->
<?php
$qrcodeUrl = isset($_SESSION['qrcode_url']) ? $_SESSION['qrcode_url'] : '';
$mostrarModal = !empty($qrcodeUrl); // Verifica se há um valor para mostrar o modal
; ?>
<script>
    window.onload = function() {
        var mostrarModal = <?php echo json_encode($mostrarModal); ?>;

        if (mostrarModal) {
            var modal = document.getElementById('qrcodeModal');
            var closeBtn = document.getElementsByClassName("close")[0];

            // Exibe o modal automaticamente
            if (modal) {
                modal.style.display = 'block';
            }

            // Fechar o modal ao clicar no botão de fechar
            closeBtn.onclick = function() {
                modal.style.display = 'none';
            }

            // Fechar o modal ao clicar fora da área do conteúdo
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        }
    };

    // Função para copiar o valor do input para a área de transferência
    function copyToClipboard() {
        var copyText = document.getElementById("qrcodeLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // Para dispositivos móveis

        // Copia o texto para a área de transferência
        document.execCommand("copy");

        // Alerta visual de cópia bem-sucedida (opcional)
        alert("Link copiado: " + copyText.value);
    }
</script>
<!-- Modal -->
<div id="qrcodeModal" class="modalpix">
    <div class="modalpix-content">
        <span class="close">&times;</span>
        <h2>QR Code</h2>
        <p>Digitalize o código QR abaixo ou copie o link:</p>
        < /br>
            <img src="<?php echo htmlspecialchars($qrcodeUrl, ENT_QUOTES, 'UTF-8'); ?>" alt="QR Code">

            <!-- Seção de copiar o texto -->
            <div class="copy-container">
                <input type="text" id="qrcodeLink" class="copy-input" value="<?php echo htmlspecialchars($qrcodeUrl, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                <button class="copy-btn" onclick="copyToClipboard()">Copiar Link</button>
            </div>
    </div>
</div>
<!-- fim modal pix -->
<!-- Cardápio -->
<div id="links-fixos" class="hidden-md-down">
    <button id="openModal" class="botao-personalizado">
        <i class="fa fa-shopping-cart"></i>
        <span id="cart-count" class="cart-count">0</span>
    </button>
</div>
<div id="myModal" class="modalcar">
    <div class="modalcar-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Carrinho de Compras</h2>
        <?php if ($_SESSION[SESSION_LOGIN]->tipo === "cliente") : ?>
            <input type="hidden" name="saldoal" value="<?php echo moedaBR($saldoAluno) ?>">
            <label class="form-label">
                <p <?php echo ($saldoAluno == 0) ? "hidden" : "" ?>> Saldo: R$&nbsp;
                    <?php echo moedaBR($saldoAluno) ?></p>
            </label>
        <?php endif; ?>
        <ul id="cart"></ul>
        <p><span id="totalcart">0</span></p>
        <button <?php echo $_SESSION[SESSION_LOGIN]->tipo <> "cliente" ? 'disabled' : ''; ?> id="botaoPagamento" class="botao-pagamento">Finalizar Compra</button>
    </div>
</div>

<!-- Modal -->
<div id="changePasswordModal" class="modalus">
    <div class="modalus-content">
        <span class="closeus">&times;</span>
        <h2>Alterar Senha</h2>
        <?php if ($_SESSION[SESSION_LOGIN]->tipo === "cliente") : ?>
            <h3><?php echo $_SESSION[SESSION_LOGIN]->login ?></h3>
            <form action="<?php echo URL_BASE . "User/salvarUser" ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="senha" class="form-label">Nova Senha</label>
                    <input maxlength="20" minlength="6" type="password" name="senha" id="senha" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirme a Nova Senha</label>
                    <input maxlength="20" minlength="6" type="password" name="confirmPassword" id="confirmPassword" required>
                </div>
                <input type="hidden" name="id_user" value="<?php echo $_SESSION[SESSION_LOGIN]->id_user ?>" />
                <button type="submit">Salvar Alterações</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<!-- Modal -->
<div id="creditos" class="modalcr">
    <div class="modalcr-content">
        <span class="closecr">&times;</span>
        <h2>Cadastro de Créditos</h2><br />
        <?php if ($_SESSION[SESSION_LOGIN]->tipo === "cliente") : ?>
            <form id="formulario" action="<?php echo URL_BASE . "Aluno/salvarAl" ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="senha" class="form-label"><span><?php echo $_SESSION[SESSION_LOGIN]->login ?></span></label>
                    <label class="form-label">
                        <p> Saldo: R$&nbsp;
                            <?php echo moedaBR($saldoAluno) ?></p>
                    </label>
                </div>
                <div class="mb-3">
                    <label for="valor_credito" class="form-label">Informe o valor para créditar:</label>
                    <input type="text" name="valor_credito" id="currency" required>
                    <input type="hidden" name="valor_debito" value="">
                </div>
                <input type="hidden" name="id_user" value="<?php echo $_SESSION[SESSION_LOGIN]->id_user ?>" />
                <button type="submit">Créditar</button>
                <!-- INICIO DO BOTAO PAGBANK --><a href="https://pag.ae/7-XFzKMM4/button" target="_blank" title="Pagar com PagBank"><img src="//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar.gif" alt="Pague com PagBank - é rápido, grátis e seguro!" /></a><!-- FIM DO BOTAO PAGBANK -->
            </form>
        <?php endif; ?>
    </div>
</div>
<section class="cardapio" id="cardapio">
    <div class="cardapioh2">
        <h2>Cardápio <span><?php echo $dia; ?></span></h2>
    </div>
    <form>
        <?php foreach ($pratos as $prato) { ?>
            <div class="itens-cardapio">
                <div class="card">
                    <img src="<?php echo URL_IMAGEM . $prato->foto ?>" alt="">
                    <div class="info">
                        <h2 hidden><?php echo $prato->id_produtos; ?></h2>
                        <h2 class="prato"><?php echo $prato->nome; ?></h2>
                        <p><?php echo $prato->descricao ?></p>
                        <!-- Exibição das duas opções de preço -->
                        <div class="rows">
                            <div class="col-3">
                                <label>
                                    <input type="radio" name="preco_<?php echo $prato->id_produtos; ?>" value="<?php echo $prato->venda_g; ?>" checked>
                                    <span class="ptrg">Prato grande: &nbsp;&nbsp;&nbsp;<span class="ptrg2">R$ <?php echo moedaBr($prato->venda_g); ?></span></span>
                                </label>
                            </div>
                            <div class="col-3">
                                <label>
                                    <input type="radio" name="preco_<?php echo $prato->id_produtos; ?>" value="<?php echo $prato->venda; ?>">
                                    <span class="ptpq">Prato pequeno: <span class="ptpq2">R$ <?php echo moedaBr($prato->venda); ?></span></span>
                                </label>
                            </div>
                            <div class="col-3 div-sp">
                                <button id="marmitex" onclick="adicionarAoCarrinho(<?php echo $prato->id_produtos; ?>, 'cardapio', 'Prato -&nbsp;<?php echo $prato->descricao ?>', getSelectedPrice(<?php echo $prato->id_produtos; ?>), event); return false;" class="botao-personalizado">Pedir Marmitex</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </form>
</section>
<section class="cardapio" id="cardapio">
    <div class="cardapioh2">
        <h2>Cardápio <span>Bebidas</span></h2>
    </div>
    <div class="table-containerb">
        <table class="tabela">
            <thead>
                <tr>
                    <th hidden>id</th>
                    <th>Img</th>
                    <th>Bebida</th>
                    <th>Valor</th>
                    <th>Pedir</th>
                </tr>
            </thead>
            <?php foreach ($bebidas as $bebida) { ?>
                <tbody>
                    <tr>
                        <td hidden><?php echo $bebida->id_produtos ?></td>
                        <td><img style="width: 40px; height: 40px" src="<?php echo URL_IMAGEM . $bebida->foto ?>"></td>
                        <td><?php echo $bebida->descricao ?></td>
                        <td><?php echo moedaBR($bebida->venda) ?></td>
                        <td><button onclick="adicionarAoCarrinho(<?php echo $bebida->id_produtos ?>,'produtos','<?php echo $bebida->descricao ?>', <?php echo $bebida->venda; ?>, event); return false;" class="botao-personalizado2">Pedir</button></td>
                    </tr>
                </tbody>
            <?php } ?>
    </div>
    </table>
</section>
<section class="cardapio" id="cardapio">
    <div class="cardapioh2">
        <h2>Cardápio <span>Salgados</span></h2>
    </div>
    <div class="table-containerb">
        <table class="tabela">
            <thead>
                <tr>
                    <th hidden>id</th>
                    <th>Img</th>
                    <th>Salgado</th>
                    <th>Valor</th>
                    <th>Pedir</th>
                </tr>
            </thead>
            <?php foreach ($salgados as $salgado) { ?>
                <tbody>
                    <tr>
                        <td hidden><?php echo $salgado->id_produtos ?></td>
                        <td><img style="width: 40px; height: 40px" src="<?php echo URL_IMAGEM . $salgado->foto ?>"></td>
                        <td><?php echo $salgado->descricao ?></td>
                        <td><?php echo moedaBR($salgado->venda) ?></td>
                        <td><button onclick="adicionarAoCarrinho(<?php echo $salgado->id_produtos ?>,'produtos','<?php echo $salgado->descricao ?>', <?php echo $salgado->venda; ?>, event); return false;" class="botao-personalizado2">Pedir</button></td>
                    </tr>
                </tbody>
            <?php } ?>
    </div>
    </table>
</section>
<section class="cardapio" id="cardapio">
    <div class="cardapioh2">
        <h2>Cardápio <span>Outros</span></h2>
    </div>
    <div class="table-containerb">
        <table class="tabela">
            <thead>
                <tr>
                    <th hidden>id</th>
                    <th>Img</th>
                    <th>Outros</th>
                    <th>Valor</th>
                    <th>Pedir</th>
                </tr>
            </thead>
            <?php foreach ($outros as $outro) { ?>
                <tbody>
                    <tr>
                        <td hidden><?php echo $outro->id_produtos ?></td>
                        <td><img style="width: 40px; height: 40px" src="<?php echo URL_IMAGEM . $outro->foto ?>"></td>
                        <td><?php echo $outro->descricao ?></td>
                        <td><?php echo moedaBR($outro->venda) ?></td>
                        <td><button onclick="adicionarAoCarrinho(<?php echo $outro->id_produtos ?>,'produtos','<?php echo $outro->descricao ?>', <?php echo $outro->venda; ?>, event); return false;" class="botao-personalizado2">Pedir</button></td>
                    </tr>
                </tbody>
            <?php } ?>
    </div>
    </table>
</section>

<!-- Contato -->
<section class="contato" id="contatos">
    <h1>Contatos</h1>
    <div class="contatos-secao">
        <div>
            <i class="bi bi-telephone"></i>
            <span>(67) 9 6128-5454</span>
        </div>
        <div>
            <a target="_blank" rel="noopener noreferrer" href="https://api.whatsapp.com/send/?phone=5567991285454&text&type=phone_number&app_absent=0"><i class="bi bi-whatsapp"></i>Whatsapp</a>
        </div>
    </div>
</section>