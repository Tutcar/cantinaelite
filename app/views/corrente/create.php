<section class="caixa">

    <div class="thead"><i class="ico cad"></i>Conta corrente
        <?php echo isset($corretoras->nome) ? substr($corretoras->nome, 0, 20)  : null ?></div>
    <div class="base-form">
        <div class="caixa-form">
            <div class="thead">Inserir novo cadastro</div>
            <form action="<?php echo URL_BASE . "corrente/salvar/?id_corretora=" . $corretoras->id_corretora ?>"
                method="POST">
                <?php
                $this->verMsg();
                $this->verErro();
                ?>
                <div class="rows">
                    <div class="col-3 position-relative">
                        <?php $imagem = ($_SESSION[SESSION_LOGIN]->foto <> '') ? $_SESSION[SESSION_LOGIN]->foto : "img-usuario.png"; ?>
                        <img src="<?php echo URL_IMAGEM . $imagem ?>" class="img-fluido foto" id="imgUp">
                    </div>

                    <div class="col-9">
                        <div class="rows">
                            <div class="col-4">
                                <label style="height: 23px;">Nr. Doc. Banco</label>
                                <input name="nr_doc_banco"
                                    value="<?php echo isset($corrente->nr_doc_banco) ? $corrente->nr_doc_banco : null ?>"
                                    type="text" placeholder="Insira número doc banco" class="form-campo">
                            </div>


                            <div class="col-4">
                                <div class="col-12">
                                    <label href="javascript:;" id="cadDesp" onclick="abrirModalDesp('#janela3')">Despesa</label>

                                    <?php
                                    if (is_array($despesas)) :
                                    ?>
                                        <select class="form-campo" name="cod_despesa">
                                            <!--query que vem do edit-->
                                            <option
                                                value="<?php echo isset($corrente->cod_despesa) ? $corrente->cod_despesa : null; ?>">
                                                <?php echo isset($corrente->cod_despesa) ? $corrente->cod_despesa : null; ?>
                                            </option>
                                            <?php
                                            foreach ($despesas as $desp) :
                                            ?>
                                                <!--query que vem para o select-->
                                                <option value="<?php echo $desp->nome_desp; ?>"><?php echo $desp->nome_desp; ?>
                                                </option>
                                            <?php
                                            endforeach;
                                        else :
                                            ?>
                                            <select name="id_corretora">
                                                <!--query que vem do edit-->
                                                <option value="<?php echo $corrente->cod_despesa; ?>">
                                                    <?php echo $corrente->cod_despesa; ?></option>
                                                <!--query que vem para o select comparar-->
                                                <option value="<?php echo $desp->nome_desp; ?>"
                                                    <?php echo ($desp->nome_desp == $corrente->cod_despesa) ? 'selected="selected"' : ''; ?>>
                                                    <?php echo $desp->nome_desp; ?></option>
                                            <?php
                                        endif;
                                            ?>
                                            </select>
                                </div>
                            </div>

                            <div class="col-4">
                                <label style="height: 23px;">Data</label>
                                <input name="data_cad"
                                    value="<?php echo isset($corrente->data_cad) ? $corrente->data_cad : "S" ?>"
                                    type="date" placeholder="Insira data de cadastro" class="form-campo">
                            </div>
                            <div class="col-8">
                                <label>Descriminação</label>
                                <input name="descricao"
                                    value="<?php echo isset($corrente->descricao) ? $corrente->descricao : null ?>"
                                    type="text" placeholder="Insira descriminação" class="form-campo">
                            </div>

                            <div class="col-4">
                                <label>Nr. Doc. Pg</label>
                                <input name="nr_doc_pg"
                                    value="<?php echo isset($corrente->nr_doc_pg) ? $corrente->nr_doc_pg : null ?>"
                                    type="text" placeholder="Insira nr doc de pagamento" class="form-campo">
                            </div>
                            <div class="col-3">
                                <label>Debito</label>
                                <input onblur="validaCampoDebito()" name="valor_debito" id="valor_debito"
                                    value="<?php echo isset($corrente->valor_debito) ? moedaBr($corrente->valor_debito) : null ?>"
                                    type="text" class="form-campo">
                            </div>

                            <div class="col-3">
                                <label>Credito</label>
                                <input onblur="validaCampoCredito()" name="valor_credito" id="valor_credito"
                                    value="<?php echo isset($corrente->valor_credito) ? moedaBr($corrente->valor_credito) : null ?>"
                                    type="text" class="form-campo">
                            </div>
                            <div class="col-3">
                                <label>Não compensado</label>
                                <input type="radio" name="confirma" value="N"
                                    <?php echo (isset($corrente->confirma) and $corrente->confirma === "N") ? "checked" : "checked" ?>>
                            </div>
                            <div class="col-3">
                                <label>Compensado</label>
                                <input type="radio" name="confirma" value="S"
                                    <?php echo (isset($corrente->confirma) and $corrente->confirma === "S") ? "checked" : null ?>>
                            </div>

                            <div class="col-12">
                                <label>Observação</label>
                                <textarea rows="10" name="obs"
                                    class="form-campo"><?php echo isset($corrente->obs) ? $corrente->obs : null ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rows">
                            <div class="col-3 position-relative">
                            </div>
                            <div class="col-2">
                                <input type="hidden" name="tipo" value="1" />
                                <input type="hidden" name="id_corretora"
                                    value="<?php echo isset($corretoras->id_corretora) ? $corretoras->id_corretora : null ?>" />
                                <input type="hidden" name="id_corrente"
                                    value="<?php echo isset($corrente->id_corrente) ? $corrente->id_corrente : null ?>" />
                                <input type="submit"
                                    value="<?php echo isset($corrente->id_corrente) ? "Salvar" : "Cadastrar" ?>"
                                    class="btn">
                            </div>
                            <?php if (isset($corrente->id_corrente)) : ?>
                                <div class="col-3">
                                    <?php $_SESSION["id_cor"] = $corrente->id_corrente; ?>
                                    <a href="<?php echo URL_BASE . "comp/index/$corrente->id_corrente" ?>" class="btn"><i
                                            class="fas fa fa-plus-circle" aria-hidden="true"></i> Comprovante</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

            </form>
        </div>
        <a href="<?php echo URL_BASE . "corrente/index/?id_corretora=" . $corretoras->id_corretora ?>"><img style="width: 40px; height: 40px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>

    <div class="window formulario" id="janela3">
        <div class="p-4 width-100 d-inline-block">
            <form method="POST" id="nomeDesp">
                <div class="rows">
                    <div class="col-12">
                        <span class="label text-label">Despesa</span>
                        <input type="hidden" name="id_despesas" value="" />
                        <input id="nomeDespesas" name="nome_desp" type="text" placeholder="Nome dadespesa..."
                            class="form-campo campo-form">
                    </div>


                    <div class="col-12 mt-3">
                        <input id="nomeDesp" type="submit" class="btn">
                    </div>
                </div>
            </form>
            <a href="#" class="fechar">x</a>
        </div>

    </div>
    <div id="mascara"></div>
    <script src="<?php echo URL_BASE ?>assets/js/mascara.js"></script>
    <script src="<?php echo URL_BASE ?>assets/js/componentes/js_modal.js"></script>
    <script src="<?php echo URL_BASE ?>assets/js/jquery-3.6.1.min.js"></script>
    <script src="<?php echo URL_BASE ?>assets/js/script.js"></script>

</section>