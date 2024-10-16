<section class="caixa">

    <div class="thead"><i class="ico cad"></i>Formulario de cadastro</div>

    <div class="base-form">
        <div class="caixa-form">

            <div class="thead">Inserir novo cadastro</div>

            <form action="<?php echo URL_BASE . "cardapio/salvar" ?>" method="POST" enctype="multipart/form-data">

                <?php
                $this->verMsg();
                $this->verErro();
                ?>

                <div class="rows">

                    <div class="col-3 position-relative">
                        <?php if (@$cardapio->foto || "") : ?>
                            <?php $imagem = $cardapio->foto ?>
                        <?php else : ?>
                            <?php $imagem = 'camera.png' ?>
                        <?php endif; ?>
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
                                    <div class="col-12">
                                        <label>Nome</label>
                                        <input name="nome"
                                            value="<?php echo isset($cardapio->nome) ? $cardapio->nome : null ?>"
                                            type="text" placeholder="Insira um nome" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Dia</label>
                                        <select name="dia" class="form-campo">
                                            <option value=""></option>
                                            <?php
                                            foreach ($dias as $chave => $dia) :
                                            ?>
                                                <?php if (is_object($cardapio)) : ?>
                                                    <option value="<?php echo $chave; ?>"
                                                        <?php echo ($cardapio->dia == $chave) ? 'selected="selected"' : ''; ?>>
                                                        <?php echo $dia; ?></option>
                                                <?php endif; ?>
                                                <?php if ((!$cardapio)) : ?>
                                                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                                                <?php endif; ?>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Descrição</label>
                                        <input name="descricao"
                                            value="<?php echo isset($cardapio->descricao) ? $cardapio->descricao : null ?>"
                                            type="text" placeholder="Insira a descrção" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Prato Pequeno</label>
                                        <input id="venda" name="venda"
                                            value="<?php echo isset($cardapio->venda) ? moedaBr($cardapio->venda) : moedaBr(0) ?>"
                                            type="text" placeholder="Valor prato pequeno" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Prato Grande</label>
                                        <input id="venda_g" name="venda_g"
                                            value="<?php echo isset($cardapio->venda_g) ? moedaBr($cardapio->venda_g) : moedaBr(0) ?>"
                                            type="text" placeholder="Valor prato grande" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Custo</label>
                                        <input id="custo" name="custo"
                                            value="<?php echo isset($cardapio->custo) ? moedaBr($cardapio->custo) : moedaBr(0) ?>"
                                            type="text" placeholder="Valor custo" class="form-campo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="categorias"
                    value="prato" />
                <input type="hidden" name="id_produtos"
                    value="<?php echo isset($cardapio->id_produtos) ? $cardapio->id_produtos : null ?>" />
                <input type="submit" value="<?php echo isset($cardapio->nome) ? "Alterar" : "Cadastrar" ?>" class="btn">
            </form>
        </div>
        <a href="<?php echo URL_BASE . "Cardapio/index" ?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>

    </div>
</section>