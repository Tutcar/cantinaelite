<section class="caixa">
    <div class="thead"><i class="ico cad"></i>Formulario de cadastro</div>
    <div class="base-form">
        <div class="caixa-form">
            <div class="thead">Inserir novo cadastro</div>
            <form action="<?php echo URL_BASE . "corretora/salvar" ?>" method="POST">
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
                            <div class="col-12">
                                <label>Banco</label>
                                <input name="nome"
                                    value="<?php echo isset($corretora->nome) ? $corretora->nome : null ?>" type="text"
                                    placeholder="Nome corretora" class="form-campo">
                            </div>


                            <div class="col-6">
                                <label>Nr. Banco</label>
                                <input name="nr_banco"
                                    value="<?php echo isset($corretora->nr_banco) ? $corretora->nr_banco : null ?>"
                                    type="text" placeholder="Nr. banco" class="form-campo">
                            </div>
                            <div class="col-3">
                                <label>Nr. Agencia</label>
                                <input name="nr_agencia"
                                    value="<?php echo isset($corretora->nr_agencia) ? $corretora->nr_agencia : null ?>"
                                    type="text" placeholder="Nr. agencia" class="form-campo">
                            </div>
                            <div class="col-3">
                                <label>Nr. Conta</label>
                                <input name="nr_conta" id="valor_compra"
                                    value="<?php echo isset($corretora->nr_conta) ? $corretora->nr_conta : null ?>"
                                    type="text" placeholder="Nr. conta" class="form-campo">
                            </div>
                        </div>
                    </div>



                    <input type="hidden" name="id_corretora"
                        value="<?php echo isset($corretora->id_corretora) ? $corretora->id_corretora : null ?>" />
                    <input type="submit" value="<?php echo isset($corretora->id_corretora) ? "Alterar" : "Cadastrar" ?>"
                        class="btn">
            </form>
        </div>
         <a href="<?php echo URL_BASE . "corretora/index"?>"><img style="width: 40px; height: 40px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>
    <script src="<?php echo URL_BASE ?>assets/js/mascara.js"></script>
</section>