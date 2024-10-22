<script>
    var coluOr = 1;
</script>

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
                            <td align="center"><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $compromisso->data_cad)->format('d/m/Y H:i:s'); ?></td>
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
<style>
    /*MOdal ver pedido*/
    .modalverPedido {
        display: none;
        position: absolute;
        z-index: 1;
        left: 50%;
        /* Centraliza horizontalmente */
        top: 50%;
        /* Centraliza verticalmente */
        width: 61%;
        height: 61%;
        overflow: auto;
        background-color: white;
        /* Fundo sólido, sem transparência */
        transform: translate(-50%, -50%);
        /* Ajusta a posição para o centro exato */
    }

    /* Conteúdo do modal */
    .modalverPedido-content {
        background-color: darkslategray;
        padding: 10px;
        border: 1px solid #888;
        width: 100%;
        max-width: 500rem;
        border-radius: 8px;
    }

    .itens-moralcada {
        width: 90%;
        margin-top: 2rem;
        margin-bottom: 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 300px));
        justify-content: center;
        align-items: center;
        gap: 30px;
    }

    .modalverPedido-content h2 {
        text-align: center;
    }

    .h2carda {
        color: #ddd;
        font-size: 2.5rem;
        text-align: center;
        font-weight: bold;
    }

    .h2span {
        margin-top: -8rem;
    }

    .divt {
        height: 3rem;
    }

    /* Botão de fechar */
    .closecarda {
        color: #aaa;
        float: right;
        font-size: 4rem;
        font-weight: bold;
    }

    .closecarda:hover,
    .closecarda:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Estilo da lista dentro do modal */
    .modalverPedido-list {
        list-style-type: none;
        padding: 0;
    }

    .modalverPedido-list li {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .modalverPedido-list img {
        width: 50px;
        height: 50px;
        margin-right: 15px;
        border-radius: 4px;
    }

    .modalverPedido-list p {
        margin: 0;
    }

    .even-row {
        background-color: #ffffff;

        /* Cor para as linhas pares */
    }

    .odd-row {
        background-color: #f2f2f2;
        /* Cor para as linhas ímpares */
    }
</style>
<div id="pedidoModal" class="modalverPedido" style="display:none;">
    <div>

    </div>
</div>