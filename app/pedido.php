<article class="cx-home">
    <div class="thead">
        <div class="col-12">

            <label href="javascript:;" id="nomePedidos" onclick="abrirModal('#janela1')">Novo Pedido</label>
            <select onchange="mostraAlerta(this.value)" id="novoPed" name="nr_pedidos" class="form-campo">
                <option value="novo">Novo Cliente</option>
                <?php
                foreach ($pedidos as $pedido) :
                ?>

                    <option value="<?php echo $pedido->nr_pedido; ?>" <?php echo ($pedido->nr_pedido == $_SESSION["nr_ped"]) ? 'selected="selected"' : ''; ?>><?php echo $pedido->cliente; ?></option>


                <?php
                endforeach;
                ?>
            </select>
        </div>
    </div>
    <script>
        var coluOr = 1;
    </script>
    <section class="caixa">

        <div class="base-lista">
            <?php $this->verMsg() ?>
            <div class="tabela-responsiva">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                    <thead>
                        <tr>
                            <th hidden align="center">Id</th>
                            <th align="left">Nome</th>
                            <th align="left">Quant</th>
                            <th align="center">Venda</th>
                            <th align="center">Ação</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itens as $item) { ?>
                            <tr>
                                <td hidden align="right"><?php echo $item->id_pedidos ?></td>
                                <td><?php echo substr($item->nome, 0, 20) ?></td>
                                <td><?php echo $item->quant ?></td>
                                <td align="right"><?php echo moedaBR($item->valor) ?></td>
                                <td align="center">
                                    <a href="javascript:;" onclick="excluir(this)" data-entidade="pedidos" data-id="<?php echo $item->id_pedidos ?>"><img style="width: 15px; height: 15px" src="<?php echo URL_IMAGEM . "del.png"; ?>"></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>
</article>