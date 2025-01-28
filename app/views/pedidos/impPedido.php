<script>
    var coluOr = 1;
</script>

<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Pedidos Caixa</div>
    <div class="base-lista">
        <div>
            <div class="text-end d-flex">
                &nbsp;&nbsp;&nbsp;<a data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i aria-hidden="true"></i> <img style="width: 35px; height: 35px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
                &nbsp;&nbsp;&nbsp;
                <a href="<?php echo URL_BASE . "Compromisso/pedidosDia" ?>"><img style="width: 30px; height: 30px"
                        src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
            </div>
        </div>
        <div id="minhaDiv" class="lst">
            <form action="<?php echo URL_BASE . "Pedidos/filtro"; ?>" method="post">
                <div class="rows">
                    <div class="col-4">
                        <select onchange="mudarType(this.value)" name="campo">
                            <option value="nr_pedido">Nr. Pedido</option>
                            <option value="data_cad">Data Pedido</option>
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
                        <th align="left">Aluno</th>
                        <th align="center">Nr.Pedido</th>
                        <th align="center">Ação</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($pedidosImp as $pedidos) { ?>
                        <tr>
                            <td align="center"><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $pedidos->data_cad)->format('d/m/Y H:i:s'); ?></td>
                            <td align="left"><?php echo substr($pedidos->cliente, 0, 60) ?></td>
                            <td align="center"><?php echo $pedidos->nr_pedido ?></td>
                            <td align="center">
                                <a title="Imprimir pedido" href="<?php echo URL_BASE . "Pedidos/impPedidoVia2/" . $pedidos->nr_pedido ?>"><img style="width: 25px; height: 25px" src="<?php echo URL_IMAGEM . 'imprimirped.png'; ?>"></a>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>



            </table>
        </div>

    </div>

</section>