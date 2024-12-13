<script>
    var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Produtos vendido <?php echo $vDia; ?></div>
    <div class="base-lista">
        <div>
            <div class="text-end d-flex">
                <a href="<?php echo URL_BASE . "Painel" ?>"><img style="width: 30px; height: 30px"
                        src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>&nbsp;
                <a data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i aria-hidden="true"></i> <img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
            </div>
        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "balanco/filtroProd"; ?>" method="POST">
                <div class="rows">
                    <div class="col-4">
                        <select name="campo">
                            <option value="diavenda" selected>Dia</option>
                            <option value="mesvenda">Mês</option>
                            <option value="anovenda">Ano</option>
                        </select>

                    </div>
                    <div class="col-6">
                        <input type="date" required="required" name="valorCampo" placeholder="Valor da pesquisar...">
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn-azul" value="Pesquisar">
                    </div>
                </div>
            </form>
        </div>


        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>

                        <th align="center">Data</th>
                        <th align="center">Produto</th>
                        <th align="center">Quantidade</th>
                        <th align="center">Unitário</th>
                        <th align="center">Total</th>
                        <th hidden align="center">Id</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($vendasDia as $venda) { ?>
                        <tr>

                            <td align="left"><?php echo databr($venda->data_ab_pedido) ?></td>
                            <td align="left"><?php echo $venda->nome ?></td>
                            <td align="center"><?php echo $venda->total_quantidade ?></td>
                            <td align="right"><?php echo moedaBr($venda->valor) ?></td>
                            <td align="right"><?php echo moedaBr($venda->valor_total) ?></td>
                            <td hidden align="right"><?php echo $venda->id_produto ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>