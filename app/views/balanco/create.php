<section class="caixa">
    <div class="thead"><i class="ico cad"></i>Formulario de cadastro</div>
    <div class="base-form">
        <div class="caixa-form">
            <div class="thead">Inserir novo cadastro</div>
            <form action="<?php echo URL_BASE . "agenda/salvar" ?>" method="POST">
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
                                <label>Fone</label>
                                <input name="fone" value="<?php echo isset($agenda->fone) ? $agenda->fone : null ?>"
                                    type="text" placeholder="Insira um telefone" class="form-campo">
                            </div>
                            <div class="col-8">
                                <label>Nome</label>
                                <input name="nome" value="<?php echo isset($agenda->nome) ? $agenda->nome : null ?>"
                                    type="text" placeholder="Insira o nome" class="form-campo">
                            </div>
                            <div class="col-4">
                                <label>Dados</label>
                                <input name="dados" value="<?php echo isset($agenda->dados) ? $agenda->dados : null ?>"
                                    type="text" placeholder="Insira os dados" class="form-campo">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_agenda"
                        value="<?php echo isset($agenda->id_agenda) ? $agenda->id_agenda : null ?>" />
                    <input type="submit" value="<?php echo isset($agenda->id_agenda) ? "Alterar" : "Cadastrar" ?>"
                        class="btn">
            </form>
        </div>
    </div>
    <script src="<?php echo URL_BASE ?>assets/js/mascara.js"></script>
</section>