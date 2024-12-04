<script>
    var coluOr = 1;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Caixas Fechados -
        Vendas:<?php echo isset($vendaTotal) ? moedaBR($vendaTotal) : null; ?> -
        Custo:<?php echo isset($custoTotal) ? moedaBR($custoTotal) : null; ?> -
        Margem:<?php echo ($vendaTotal > 0 && $custoTotal > 0) ? number_format(($vendaTotal / $custoTotal), 2, '.', ',') * 100 . "%" : ""; ?>
    </div>
    <div class="base-lista">

        <div>
            <div class="text-end d-flex">
                <a data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i aria-hidden="true"></i> <img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>" title="Filtrar Por Data"></a>
            </div>
        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "relatorios/filtro"; ?>" method="post">
                <div class="rows">
                    <div class="col-4">
                        <select onchange="mudarType(this.value)" name="campo">
                            <option value="data_comp">Datas Caixa</option>
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
                        <th align="left">Data</th>
                        <th align="left">Entrada</th>
                        <th align="left">Retirada</th>
                        <th align="left">Fechado</th>
                        <th align="left">Venda</th>
                        <th align="left">Custo</th>
                        <th align="left">Margem</th>
                        <th hidden align="left">ID</th>
                        <th align="center">Ação</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($lista as $relatorios) { ?>
                        <tr>
                            <td><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $relatorios->data_ab_caixa)->format('d/m/Y H:i:s'); ?></td>
                            <td align="right"><?php echo moedaBr($relatorios->entrada) ?></td>
                            <td align="right"><?php echo moedaBr($relatorios->retirada) ?></td>
                            <td align="right"><?php echo $relatorios->fechado ?></td>
                            <td align="right"><?php echo ($relatorios->valor) ? moedaBr($relatorios->valor) : moedaBr(0) ?></td>
                            <td align="right"><?php echo ($relatorios->custo) ? moedaBr($relatorios->custo) : moedaBr(0) ?></td>
                            <td align="right">
                                <?php echo ($relatorios->valor && $relatorios->custo) ? number_format(($relatorios->valor / $relatorios->custo) * 100) .  "%" : '0%'  ?></td>
                            <td hidden><?php echo $relatorios->id_relatorios ?></td>
                            <td align="center">
                                <a href="<?php echo URL_BASE . "Relatorios/relatDia/" . $relatorios->id_caixaabre ?>">&nbsp;&nbsp;<img
                                        style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "lupa.png"; ?>" title="Vendas Diárias"></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
        <a href="<?php echo URL_BASE . "painel" ?>"><img style="width: 30px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>" title="Retornar Painel"></a>

    </div>
</section>