<section class="caixa">
    <div class="thead"><i class="ico cad"></i>Formulario de cadastro</div>
    <div class="base-form">
        <div class="caixa-form">
            <div class="thead">Inserir novo cadastro</div>
            <form action="<?php echo URL_BASE . "user/salvar" ?>" method="POST" enctype="multipart/form-data">
                <?php
                $this->verMsg();
                $this->verErro();
                ?>
                <div class="rows">
                    <?php $null = ""; ?>
                    <div class="col-3 position-relative">
                        <?php $imagem = 'img-usuario.png' ?>
                        <img src="<?php echo URL_IMAGEM . $imagem ?>" class="img-fluido foto" id="imgUp">
                        <div class="foto-file">
                            <input type="file" name="arquivo" id="arquivo" onchange="pegaArquivo(this.files)"><label for="arquivo"><span>Editar foto</span></label>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="rows">
                            <div class="col-12">
                                <label>Usuário</label>
                                <input required="required" name="login" value="" type="text" placeholder="Insira um usuário" class="form-campo">
                            </div>
                        </div>
                        <div class="rows">
                            <div class="col-4">
                                <label>Senha ver&nbsp;&nbsp;<input type="checkbox" onclick="showOlh()"></label>
                                <input maxlength="20" minlength="6" required="required" id="senha" name="senha" value="" type="text" placeholder="Insira uma senha" class="form-campo">
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Cadastrar" class="btn">
                </div>
            </form>
        </div>
    </div>
</section>
<script src="<?php echo URL_BASE ?>assets/js/mascara.js"></script>