<section class="caixa">

    <div class="thead"><i class="ico cad"></i>Movimento</div>

    <div class="base-form">
        <div class="caixa-form">

            <div class="thead">Fechar Caixa do Dia - <?php echo dataBr($dataCx->data_ab_caixa); ?></div>

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
                                            value="<?php echo isset($dataCx->entrada) ? moedaBr($dataCx->entrada) : moedaBr(0) ?>"
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
                                        <label>Outros</label>
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
                                    <div class="col-4">
                                        <label>Saldo Caixa</label>
                                        <input readonly id="saldo_cx" name="saldo_cx"
                                            value="<?php echo isset($idAbreValor) ? moedaBr($idAbreValor + $dinheiro) : moedaBr(0) ?>"
                                            type="text" class="form-campo">
                                    </div>
                                    <div class="col-4">
                                        <label>Valor conferência</label>
                                        <input id="conferencia" name="conferencia"
                                            value="<?php echo moedaBr($idAbreValor + $dinheiro) ?>" type="text"
                                            onblur="calcDif()" placeholder="Insira diferenca de caixa caso tenha."
                                            class="form-campo">
                                    </div>
                                    <div class="col-4">
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
                        <input type="submit" value="<?php echo isset($caixafecha->nome) ? "Alterar" : "Fechar Caixa" ?>"
                            class="btn">
                    </div>
                </div>
            </form>

        </div>
    </div>
    <a href="<?php echo URL_BASE . "Caixafecha/index"?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
</section>