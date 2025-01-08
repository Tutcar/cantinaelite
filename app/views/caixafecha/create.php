<section class="caixa">

    <div class="thead"><i class="ico cad"></i>Movimento <?php echo (isset($funcionario)) ?  $funcionario : ""; ?></div>

    <div class="base-form">
        <div class="caixa-form">

            <div class="thead">Fechar Caixa do Dia - <?php echo DateTime::createFromFormat('Y-m-d H:i:s', $dataCx->data_ab_caixa)->format('d/m/Y H:i:s'); ?></div>
            <div class="text-end d-flex">
                <a href="<?php echo URL_BASE . "Caixafecha/index" ?>"><img style="width: 30px; height: 30px"
                        src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
            </div>
            <form action="<?php echo URL_BASE . "caixafecha/salvar" ?>" method="POST" enctype="multipart/form-data">

                <div class="rows">
                    <div class="ocDiv">
                        <?php $imagem = isset($caixafecha->foto) ? $caixafecha->foto : "img-semproduto.png"; ?>
                        <img src="<?php echo URL_IMAGEM . $imagem ?>" class="img-fluido foto" id="imgUp">
                        <div class="foto-file">
                            <input type="file" name="arquivo" id="arquivo" onchange="pegaArquivo(this.files)"><label
                                for="arquivo"><span>Editar foto</span></label>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="rows">
                            <div class="col-9">
                                <div class="rows">
                                    <div class="col-6">
                                        <label>Entrada</label>
                                        <input readonly name="entrada"
                                            value="<?php echo isset($cxInicial) ? moedaBr($cxInicial) : moedaBr(30) ?>"
                                            type="text" class="form-campo">
                                    </div>
                                    <div class="col-6">
                                        <label>Total Venda</label>
                                        <input readonly name="total_dia"
                                            value="<?php echo isset($saldo) ? moedaBr($saldo) : moedaBr(0) ?>"
                                            type="text" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-6">
                                        <label>Vendas Dinheiro</label>
                                        <input readonly name="dinheiro"
                                            value="<?php echo isset($dinheiro) ? moedaBr($dinheiro) : moedaBr(0) ?>"
                                            type="text" class="form-campo">
                                    </div>
                                    <div class="col-6">
                                        <label>Vendas Cartao</label>
                                        <input readonly name="cartao"
                                            value="<?php echo isset($cartao) ? moedaBr($cartao) : moedaBr(0) ?>"
                                            type="text" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-6">
                                        <label>Pix</label>
                                        <input readonly name="pix"
                                            value="<?php echo isset($pix) ? moedaBr($pix) : moedaBr(0) ?>" type="text"
                                            class="form-campo">
                                    </div>
                                    <div class="col-6">
                                        <label>Alunos</label>
                                        <input readonly name="outros"
                                            value="<?php echo isset($outros) ? moedaBr($outros) : moedaBr(0) ?>"
                                            type="text" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-6">
                                        <label>Pedidos Pendentes</label>
                                        <input readonly id="pedidos_ab" name="pedidos_ab"
                                            value="<?php echo isset($pedidos_ab) ? moedaBr($pedidos_ab) : moedaBr(0) ?>"
                                            type="text" class="form-campo">
                                    </div>
                                    <div class="col-6">
                                        <label>Retitada</label>
                                        <input readonly id="retirada" name="retirada"
                                            value="<?php echo isset($dataCx->retirada) ? moedaBr($dataCx->retirada) : moedaBr(0) ?>"
                                            type="text" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-3">
                                        <label <?php echo (isset($creditos) && !empty($creditos)) ? 'style="color: blue;"' : ''; ?>>Créditos</label> <input readonly name="credito"
                                            value="<?php echo isset($creditos) ? moedaBr($creditos) : moedaBr(0) ?>"
                                            type="text" class="form-campo">
                                    </div>
                                    <div class="col-3">
                                        <label>Saldo Caixa</label>
                                        <input readonly id="saldo_cx" name="saldo_cx"
                                            value="<?php echo (isset($funcionario)) ? moedaBr($idAbreValor + $dinheiro) : moedaBr($cxInicial + $dinheiro) ?>"
                                            type="text" class="form-campo">
                                    </div>
                                    <div class="col-3">
                                        <label>Conferência</label>
                                        <input id="conferencia" name="conferencia"
                                            value="<?php echo (isset($funcionario)) ? moedaBr($idAbreValor + $dinheiro) : moedaBr($cxInicial + $dinheiro) ?>" type="text"
                                            onblur="calcDif()" placeholder="Insira diferenca de caixa caso tenha."
                                            class="form-campo">
                                    </div>
                                    <div class="col-3">
                                        <label>Diferença</label>
                                        <input readonly id="diferenca" name="diferenca"
                                            value="<?php echo moedaBr(0); ?>" type="text" class="form-campo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rows">
                    <div class="col-12">
                        <input type="hidden" name="id_caixaabre"
                            value="<?php echo isset($dataCx->id_caixaabre) ? $dataCx->id_caixaabre : null ?>" />
                        <input type="hidden" name="data_fch_caixa"
                            value="<?php echo isset($dataCx->data_ab_caixa) ? $dataCx->data_ab_caixa : null ?>" />
                        <div style="display: flex; gap: 10px;">
                            <input type="<?php echo (isset($funcionario)) ? "hidden" : "submit"; ?>"
                                name="acao"
                                value="Fechar Caixa"
                                class="btn"
                                <?php echo isset($caixafecha->nome) ? 'value="Alterar"' : 'value="Fechar Caixa"'; ?>>
                            <input type="<?php echo (isset($funcionario)) ? "hidden" : "submit"; ?>"
                                name="acao"
                                value="Fechar Caixa a conferir"
                                class="btn"
                                <?php echo isset($caixafecha->nome) ? 'value="Alterar"' : 'value="Fechar Caixa a conferir"'; ?>>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>