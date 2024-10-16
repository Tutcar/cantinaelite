<script>
var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i>nf:<?php echo $compras->nr_nf; ?> -
        Fornecedor:<?php echo substr($compras->fornecedor, 0, 30); ?> - Date:<?php echo dataBr($compras->data_nf) ?> -
        Valor: <?php echo moedaBr($compras->valor_nf); ?></div>
    <div class="base-lista">
        <div>
            <div class="text-end d-flex">
                <a href="<?php echo URL_BASE . "itensnf/create/$compras->id_compras/$compras->id_fornecedor" ?>"
                    class="btn btn-roxo d-inline-block mb-2 mx-1"><i class="fas fa fa-plus-circle"
                        aria-hidden="true"></i> Cadastrar itens nf</a>
            </div>
        </div>
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="center">Nome</th>
                        <th align="center">Tipo</th>
                        <th align="center">Quant</th>
                        <th align="center">Unit..</th>
                        <th align="center">Total.</th>
                        <th align="center">Ação</th>
                        <th hidden align="center">Id</th>
                        <th hidden align="center">Id</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $itensnf) { ?>
                    <tr>

                        <td align="left"><?php echo substr($itensnf->nf_nome, 0, 30) ?></td>
                        <td align="right"><?php echo $itensnf->nf_tipo ?></td>
                        <td align="right"><?php echo $itensnf->nf_quant ?></td>
                        <td align="right"><?php echo moedaBr($itensnf->nf_preco) ?></td>
                        <td align="right"><?php echo moedaBr($itensnf->nf_quant * $itensnf->nf_preco) ?></td>
                        <td align="center">
                            <a href="<?php echo URL_BASE . "compras/index"?>"><img style="width: 15px; height: 15px"
                                    src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
                            <a href="<?php echo URL_BASE . "itensnf/edit/" . $itensnf->id_itensnf ?>"><img
                                    style="width: 20px; height: 20px"
                                    src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a>
                            <a href="javascript:;" onclick="excluiritem(this)" data-entidade="itensnf"
                                data-id="<?php echo $itensnf->id_itensnf ?>"
                                data-idc="<?php echo $itensnf->id_compras ?>"
                                data-idf="<?php echo $itensnf->id_fornecedor ?>"><img style="width: 20px; height: 20px"
                                    src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a>
                        </td>
                        <td hidden align="right"><?php echo $itensnf->id_itensnf ?></td>
                        <td hidden align="right"><?php echo $itensnf->id_fornecedor ?></td>
                    </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</section>