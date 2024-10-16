<section class="caixa">

    <div class="thead"><i class="ico cad"></i>Formulario de cadastro</div>

    <div class="base-form">
        <div class="caixa-form">

            <div class="thead">Inserir novo cadastro</div>

            <form action="<?php echo URL_BASE . "produtos/salvar" ?>" method="POST" enctype="multipart/form-data">

                <?php
                $this->verMsg();
                $this->verErro();
                ?>

                <div class="rows">

                    <div class="col-3 position-relative">
                        <?php if (@$produtos->foto || "") : ?>
                            <?php $imagem = $produtos->foto ?>
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
                                        <label>Quantidade</label>
                                        <input name="quant"
                                            value="<?php echo isset($produtos->quant) ? $produtos->quant : null ?>"
                                            type="text" placeholder="Insira a quantidade" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Nome</label>
                                        <input name="nome"
                                            value="<?php echo isset($produtos->nome) ? $produtos->nome : null ?>"
                                            type="text" placeholder="Insira um nome" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Descrição</label>
                                        <input name="descricao"
                                            value="<?php echo isset($produtos->descricao) ? $produtos->descricao : null ?>"
                                            type="text" placeholder="Insira a descrção" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Categoria</label>
                                        <select name="categorias" class="form-campo">
                                            <option value=""></option>
                                            <option value="bebidas" <?php echo (isset($produtos) && isset($produtos->categorias) && $produtos->categorias === "bebidas") ? 'selected="selected"' : ''; ?>>
                                                Bebidas
                                            </option>
                                            <option value="salgados" <?php echo (isset($produtos) && isset($produtos->categorias) && $produtos->categorias === "salgados") ? 'selected="selected"' : ''; ?>>
                                                Salgados
                                            </option>
                                            <option value="outros" <?php echo (isset($produtos) && isset($produtos->categorias) && $produtos->categorias === "outros") ? 'selected="selected"' : ''; ?>>
                                                Outros
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Tipo</label>
                                        <select name="tipo" class="form-campo">
                                            <option value=""></option>
                                            <?php
                                            foreach ($tipo as $tip) :
                                            ?>
                                                <?php if (is_object($produtos)) : ?>
                                                    <option value="<?php echo $tip->tipo; ?>"
                                                        <?php echo ($produtos->tipo == $tip->tipo) ? 'selected="selected"' : ''; ?>>
                                                        <?php echo $tip->tipo; ?></option>
                                                <?php endif; ?>
                                                <?php if ((!$produtos)) : ?>
                                                    <option value="<?php echo $tip->tipo; ?>"><?php echo $tip->tipo; ?></option>
                                                <?php endif; ?>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>



                                <div class="rows">
                                    <div class="col-12">
                                        <label>Custo</label>
                                        <input id="custo" name="custo"
                                            value="<?php echo isset($produtos->custo) ? moedaBr($produtos->custo) : moedaBr(0) ?>"
                                            type="text" placeholder="Insira um custo" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Venda</label>
                                        <input id="venda" name="venda"
                                            value="<?php echo isset($produtos->venda) ? moedaBr($produtos->venda) : moedaBr(0) ?>"
                                            type="text" placeholder="Insira venda" class="form-campo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_produtos"
                    value="<?php echo isset($produtos->id_produtos) ? $produtos->id_produtos : null ?>" />
                <input type="submit" value="<?php echo isset($produtos->nome) ? "Alterar" : "Cadastrar" ?>" class="btn">
            </form>
        </div>
        <a href="<?php echo URL_BASE . "Produtos/index" ?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>

    </div>
</section>