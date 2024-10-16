<section class="caixa">
    <div class="rows">
        <div class="col-3 position-relative"></div>
        <div class="col-6 position-relative">
            <div class="UploadProgress simples">
                <form id="uploadForm" action="<?php echo URL_BASE . "Comp/salvar" ?>" method="post" enctype="multipart/form-data">
                    <div class="rows">


                        <div class="col-9 ">
                            <label for="arquivo">.</label>
                            <label class="btn width-100">
                                <input id="arquivo" type="file" name="arquivo">
                                <input type="submit" name="submit" value="   Enviar" class="btn" />
                            </label>

                        </div>
                        <div class="col-3 mt-4">
                            <input hidden type="text" value="<?php echo $compr->id_corretora  ?>" name="id_corretora">
                            <input hidden type="text" value="<?php echo $compr->id_corrente  ?>" name="id_corrente">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="base-lista">
        <?php $this->verMsg() ?>
        <?php $this->verErro(); ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">

                <thead>
                    <tr>
                        <th align="center">Comprovante de Pagamento</th>
                        <th hidden align="center">Id</th>
                        <th align="center">Ação</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comp as $corrente) { ?>
                        <tr>
                            <td align="left"><?php echo $corrente->nome_arq ?></td>
                            <td hidden align="right"><?php echo $corrente->id_comp ?></td>
                            <td align="center">
                                <a href="<?php echo URL_BASE . "comp/lerArq/" . $corrente->id_comp  ?>"><img
                                    style="width: 20px; height: 20px" src="<?php echo URL_IMAGEM . "lupa.png"; ?>">&nbsp;&nbsp;</a>
                                <a href="javascript:;" onclick="excluir(this)" data-entidade="comp" data-id="<?php echo $corrente->id_comp ?>"><img style="width: 20px; height: 20px"
                                    src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-3">

           <a href="<?php echo URL_BASE . "corrente/index/?id_corretora=". $corrente->id_corretora?>" ><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>

        </div>
    </div>
</section>