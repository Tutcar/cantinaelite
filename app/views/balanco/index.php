<script>
var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Lista de Balanco</div>
    <div class="base-lista">
        <div>
            <div class="text-end d-flex">
                <a href="<?php echo URL_BASE . "Balanco/index" ?>"><img style="width: 40px; height: 40px"
                        src="<?php echo URL_IMAGEM . "atualizar.png"; ?>"></a>
                <a> &nbsp;&nbsp; </a>
                <a data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i  aria-hidden="true"></i> <img style="width: 40px; height: 40px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
            </div>
        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "Balanco/filtro"; ?>" method="post">
                <div class="rows">
                    <div class="col-4">
                        <select onchange="mudarType(this.value)" name="campo">
                            <option value="balanco">Datas Caixa</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <input id="dataIn" type="date" required="required" name="dataIn"
                            placeholder="Valor da pesquisar...">
                    </div>
                    <div class="col-3">
                        <input id="dataFim" type="date" required="required" name="dataFim"
                            placeholder="Valor da pesquisar...">
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn" value="pesquisar">
                    </div>
                </div>
            </form>
        </div>
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="center">Mês</th>
                        <th align="center">Vendas</th>
                        <th align="center">Compras</th>
                        <th align="center">Despesas</th>
                        <th align="center">Terceiros</th>
                        <th align="center">Produção</th>
                        <th align="center">Salários</th>
                        <th align="center">Lucro</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach ($balaMes as $balanco) { ?>
                    <tr>
                        <td align="left"><?php echo $balanco->mes . "/" . $balanco->ano  ?></td>
                        <td align="right"><?php echo ($balanco->vendaTotal     > 0)     ? moedaBr($balanco->vendaTotal) : moedaBr(0) ?></td>
                        <td align="right"><?php echo ($balanco->comprasTotal   > 0)     ? moedaBr($balanco->comprasTotal) : moedaBr(0) ?></td>
                        <td align="right"><?php echo ($balanco->despesasTotal  > 0)     ? moedaBr($balanco->despesasTotal) : moedaBr(0) ?></td>
                        <td align="right"><?php echo ($balanco->terceirosTotal > 0)     ? moedaBr($balanco->terceirosTotal) : moedaBr(0) ?></td>
                        <td align="right"><?php echo ($balanco->producaoTotal  > 0)     ? moedaBr($balanco->producaoTotal) : moedaBr(0) ?></td>
                        <td align="right"><?php echo ($balanco->salarioTotal   > 0)     ? moedaBr($balanco->salarioTotal) : moedaBr(0); ?></td>
                        <td align="right"><?php echo moedaBr($balanco->vendaTotal - $balanco->comprasTotal - $balanco->salarioTotal) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <a href="<?php echo URL_BASE . "Painel" ?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>
</section>