<section class="caixa">

    <div class="thead"><i class="ico cad"></i>Formulario de cadastro</div>

    <div class="base-form">
        <div class="caixa-form">

            <div class="thead">Iniciar Caixa</div>

            <form action="<?php echo URL_BASE . "caixaabre/salvar" ?>" method="POST" enctype="multipart/form-data">



                <div class="rows">
                    <div class="ocDiv">
                        <?php $imagem = isset($caixafecha->foto) ? $caixafecha->foto : "img-semproduto.png"; ?>
                        <img src="<?php echo URL_IMAGEM . $imagem ?>" class="img-fluido foto" id="imgUp">
                        <div class="foto-file">
                            <input type="file" name="arquivo" id="arquivo" onchange="pegaArquivo(this.files)"><label for="arquivo"><span>Editar foto</span></label>
                        </div>
                    </div>

                    <div class="col-9">

                        <div class="rows">

                            <div class="col-9">
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Data</label>
                                        <input name="data_ab_caixa" type="date" value="<?php echo isset($caixaabre->data_ab_caixa) ? $caixaabre->data_ab_caixa : hoje() ?>" type="text" placeholder="Insira a data" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Entrada</label>
                                        <input id="entrada" name="entrada" value="<?php echo isset($caixaabre->entrada) ? moedaBr($caixaabre->entrada) : moedaBr($idAbreValor) ?>" type="text" placeholder="Insira o valor do caixa inicial" class="form-campo">
                                    </div>
                                </div>
                                <div class="rows">
                                    <div class="col-12">
                                        <label>Retirada</label>
                                        <input id="retirada" name="retirada" value="<?php echo isset($caixaabre->retirada) ? moedaBr($caixaabre->retirada) : moedaBr(0) ?>" type="text" placeholder="Insira o valor da retirada" class="form-campo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_caixaabre" value="<?php echo isset($caixaabre->id_caixaabre) ? $caixaabre->id_caixaabre : null ?>" />
                <input type="submit" value="<?php echo isset($caixaabre->data_ab_caixa) ? "Alterar" : "Cadastrar" ?>" class="btn">
            </form>
        </div>
        <a href="<?php echo URL_BASE . "Caixaabre/index"?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>

    </div>
</section>