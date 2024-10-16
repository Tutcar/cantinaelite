<section class="caixa">
    <div class="thead"><i class="ico cad"></i>Compromissos</div>
    <div class="base-form">
        <div class="caixa-form">
            <div class="thead">Inserir novo cadastro</div>
            <form action="<?php echo URL_BASE . "compromisso/salvar" ?>" method="POST">
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
                                <label>Data compromisso</label>
                                <input name="data_comp"
                                    value="<?php echo isset($compromisso->data_comp) ? $compromisso->data_comp : null ?>"
                                    type="date" class="form-campo">
                            </div>
                            <div class="col-12">
                                <label>Descrição</label>
                                <textarea rows="10" name="descricao"
                                    class="form-campo"><?php echo isset($compromisso->descricao) ? $compromisso->descricao : null ?></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_compromisso"
                        value="<?php echo isset($compromisso->id_compromisso) ? $compromisso->id_compromisso : null ?>" />
                    <input type="submit" value="Cadastrar" class="btn">
            </form>
        </div>
        <a href="<?php echo URL_BASE . "compromisso/index"?>"><img style="width: 40px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>
    <script src="<?php echo URL_BASE ?>assets/js/mascara.js"></script>
</section>