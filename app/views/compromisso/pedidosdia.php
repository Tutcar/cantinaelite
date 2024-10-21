<script>
    var coluOr = 1;
</script>
<style>
    .modalverPedido {
        display: none;
        /* Certifique-se de que o modal começa oculto */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        /* Fundo semitransparente */
    }

    .modalverPedido>div {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }
</style>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script src="<?php echo URL_BASE ?>assets/js/componentes/js_data_table2.js"></script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Pedidos Site</div>
    <div class="base-lista">
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "compromisso/filtro"; ?>" method="post">
                <div class="rows">
                    <div class="col-4">
                        <select onchange="mudarType(this.value)" name="campo">
                            <option value="descricao">Descrição</option>
                            <option value="data_comp">Data Compromisso</option>
                            <option value="data_compM">Compromisso a realizar</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input id="confData" type="text" required="required" name="valorfiltro" placeholder="Valor da pesquisar...">
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
                        <th align="left">Data Pedido.</th>
                        <th align="center">Descrição</th>
                        <th hidden align="center">id_compromisso</th>
                        <th hidden align="center">nr_pedido</th>
                        <th align="center">Ação</th>
                        <th hidden align="left">Data Compromisso.</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lista as $compromisso) { ?>
                        <tr>
                            <td align="center"><?php echo dateTime($compromisso->data_cad) ?></td>
                            <td align="center"><?php echo substr($compromisso->descricao, 0, 60) ?></td>
                            <td hidden><?php echo $compromisso->id_compromisso ?></td>
                            <?php preg_match('/nr:(\d+)/', $compromisso->descricao, $matches); ?>
                            <td hidden><?php echo $nr_pedido = $matches[1] ?></td>
                            <td align="center">
                                <a title="Confirmar entrega" href="javascript:;" onclick="pedidoEntregue(this)" data-entidade="compromisso" data-id="<?php echo $compromisso->id_compromisso ?>"><img style="width: 25px; height: 25px" src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a>
                                <a title="Ver pedido" href="javascript:;" onclick="pedidoVer(this)" data-entidade="Pedidos" data-nr_pedido="<?php echo $nr_pedido ?>"><img style="width: 25px; height: 25px" src="<?php echo URL_IMAGEM . 'lupa.png'; ?>"></a>
                            </td>
                            <td hidden align="center"><?php echo dataEn($compromisso->data_comp) ?></td>
                        </tr>
                    <?php } ?>

                </tbody>



            </table>
        </div>
        <a href="<?php echo URL_BASE . "painel" ?>"><img style="width: 40px; height: 30px"
                src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    </div>

</section>
<div id="pedidoModal" class="modalverPedido" style="display:none;">
    <div>

    </div>
</div>