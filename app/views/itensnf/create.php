<section class="caixa">
    <div class="thead"><i class="ico cad"></i>Cadastro Itens NF</div>
    <div class="base-form">
        <div class="caixa-form">
            <div class="thead">Inserir novo item</div>
            <form action="<?php echo URL_BASE . "Itensnf/salvar" ?>" method="POST" enctype="multipart/form-data">
                <?php
                $this->verMsg();
                $this->verErro();
                ?>
                <div class="rows">

                    <div class="col-9">
                        <div class="rows">

                            <div class="col-12">
                                <label>Nome</label>
                                <input name="nf_nome"
                                    value="<?php echo isset($itensnf->nf_nome) ? $itensnf->nf_nome : null ?>"
                                    type="text" placeholder="Nome item Nf" class="form-campo">
                            </div>
                            <div class="col-12">
                                <label>Tipo Despesa</label>
                                <?php

                                if ($tipos) :
                                ?>
                                <select class="form-campo" name="nf_tipo">
                                    <!--query que vem do edit-->
                                    <option value="<?php echo isset($itensnf->nf_tipo) ? $itensnf->nf_tipo : null; ?>">
                                        <?php echo isset($itensnf->nf_tipo) ? $itensnf->nf_tipo : null; ?></option>
                                    <?php
                                        foreach ($tipos as $tipo) :
                                        ?>
                                    <!--query que vem para o select-->
                                    <option value="<?php echo $tipo; ?>"><?php echo $tipo; ?></option>
                                    <?php
                                        endforeach;
                                    else :
                                        ?>
                                    <select class="form-campo" name="nf_tipo">
                                        <!--query que vem do edit-->
                                        <option value="<?php echo $itensnf->nf_nome; ?>">
                                            <?php echo $itensnf->nf_nome; ?></option>
                                        <!--query que vem para o select comparar-->
                                        <option value="<?php echo $tipo; ?>"
                                            <?php echo ($tipo == $itensnf->nf_tipo) ? 'selected="selected"' : ''; ?>>
                                            <?php echo $tipo; ?></option>
                                        <?php
                                    endif;
                                        ?>
                                    </select>
                            </div>
                            <div class="col-3">
                                <label>Quant. NF</label>
                                <input id="quantidadeItem" onblur="valTotal()" id="nf_quant" name="nf_quant"
                                    value="<?php echo isset($itensnf->nf_quant) ? $itensnf->nf_quant : null ?>"
                                    type="number" placeholder="Quantidade item" class="form-campo">
                            </div>
                            <div class="col-3">
                                <label>Valor</label>
                                <input onblur="valTotal()" id="valorLiquido" id="nf_preco" name="nf_preco"
                                    value="<?php echo isset($itensnf->nf_preco) ? moedaBr($itensnf->nf_preco) : moedaBr(0) ?>"
                                    type="text" placeholder="Valor unitario item" class="form-campo">
                            </div>
                            <div class="col-3 ocDiv">
                                <label>Desconto</label>
                                <input id="nf_desc" name="nf_desc"
                                    value="<?php echo isset($itensnf->nf_desc) ? moedaBr($itensnf->nf_desc) : moedaBr(0) ?>"
                                    type="text" placeholder="Valor desconto item" class="form-campo">
                            </div>
                            <div class="col-3">
                                <label>Total</label>
                                <input id="totalItem" readonly
                                    value="<?php echo isset($itensnf->nf_preco) ? moedaBr($itensnf->nf_preco - $itensnf->nf_desc * $itensnf->nf_quant) : moedaBr(0) ?>"
                                    type="text" placeholder="Valor total item" class="form-campo">
                            </div>
                            <input type="hidden" name="data_nf"
                                value="<?php echo isset($itensnf->data_nf) ? $itensnf->data_nf : null ?>" />
                            <input type="hidden" name="id_fornecedor"
                                value="<?php echo isset($id_fornecedor) ? $id_fornecedor : null ?>" />
                            <input type="hidden" name="id_compras"
                                value="<?php echo isset($id_compras) ? $id_compras : null ?>" />
                            <input type="hidden" name="id_itensnf"
                                value="<?php echo isset($itensnf->id_itensnf) ? $itensnf->id_itensnf : null ?>" />
                            <input type="submit"
                                value="<?php echo isset($itensnf->id_itensnf) ? "Alterar" : "Cadastrar" ?>" class="btn">
                            <?php
                            if (isset($itensnf->id_itensnf)) :
                            ?>
                            <input type="hidden" name="id_fornecedor"
                                value="<?php echo isset($itensnf->id_fornecedor) ? $itensnf->id_fornecedor : null ?>" />
                            <input type="hidden" name="id_compras"
                                value="<?php echo isset($itensnf->id_compras) ? $itensnf->id_compras : null ?>" />
                            <!--<a href="<?php echo URL_BASE . "itensnf/index/" . $itensnf->id_itensnf ?>" class="btn btn-verde">Itens NF</a>-->
                            <?php
                            endif;

                            ?>

                        </div>
                    </div>
                </div>
        </div>

        </form>
    </div>
    <a href="<?php echo URL_BASE . "Faturas/apagar" ?>"><img style="width: 30px; height: 30px"
            src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>
    <script src="<?php echo URL_BASE ?>assets/js/mascara.js"></script>
</section>