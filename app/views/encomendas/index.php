<section class="caixa">
    <div class="thead"><i class="ico home"></i> Encomendas do Dia : <?php echo date('d/m/Y'); ?></div>
    <div class="base-home">
        <div class="grade">
            <div class="rows">


                <div class="col-6">
                    <article class="cx-home">
                        <div class="thead">Tabela Venda </div>
                        <script>
                        var coluOr = 1;
                        </script>
                        <section class="caixa">

                            <div class="base-lista">

                                <div class="tabela-responsiva">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th align="left">Nome</th>
                                                <th align="center">Venda</th>
                                                <th align="left">Foto</th>
                                                <th hidden align="left">ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($lista as $produtos) { ?>

                                            <tr>
                                                <td id="idNome"><?php echo substr($produtos->nome, 0, 20) ?></td>
                                                <td id="idVenda" align="right"><?php echo moedaBR($produtos->venda) ?>
                                                </td>
                                                <td><a href="javascript:;"
                                                        onclick="cadPedido2(<?php echo $produtos->id_produtos ?>)"><img
                                                            style="width: 50px; height: 50px"
                                                            src="<?php echo URL_IMAGEM . $produtos->foto ?>"></a></td>
                                                <td id="idId" hidden><?php echo $produtos->id_produtos ?></td>
                                            </tr>

                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </section>

                    </article>
                </div>
                <div class="col-6">
                    <article class="cx-home">
                        <div class="thead">
                            <div class="col-12">

                                <label class="btn" href="javascript:;" id="nomePedidos"
                                    onclick="abrirModal('#janela3')">Nova Encomenda</label>
                                <select onchange="mostraAlerta2(this.value)" id="novoPed" name="nr_pedidos"
                                    class="form-campo">
                                    <option value="novo"></option>
                                    <?php
                                    foreach ($pedidos as $pedido) :
                                    ?>
                                    <option value="<?php echo $pedido->nr_pedido; ?>"
                                        <?php echo $_SESSION["data_encomendas"] = $pedido->data_encomendas; ?>
                                        <?php echo ($pedido->nr_pedido == $_SESSION["nr_ped"]) ? 'selected="selected"' : ''; ?>>
                                        <?php echo $pedido->id_pedidos; ?>-<?php echo $pedido->cliente; ?></option>
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
                                <div class="col-12">
                                    <button class="btn novo" ref="javascript:;" id="fechaPedidos"
                                        onclick="abrirModal('#janela2')">Fechar
                                        Encomenda:<?php echo isset($somaPedido) ? "   -   R$ " . moedaBr($somaPedido) : null; ?></button>
                                </div>
                                <div class="tabela-responsiva">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th align="left">Nome</th>
                                                <th align="left">Quant</th>
                                                <th align="center">Venda</th>
                                                <th align="center">Ação</th>
                                                <th hidden align="center">Id</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($itens as $item) { ?>
                                            <tr>
                                                <td><?php echo substr($item->nome, 0, 20) ?></td>
                                                <td align="center"><?php echo $item->quant ?></td>
                                                <td align="right"><?php echo moedaBR($item->valor * $item->quant) ?></td>
                                                <td align="center">
                                                    <a href="javascript:;"
                                                        onclick="abrirModalQuant('#quantAlterar', this)"
                                                        data-valor="<?php echo $item->valor ?>"
                                                        data-quant="<?php echo $item->quant ?>"
                                                        data-id="<?php echo $item->id_pedidos ?>"
                                                        data-nm_nome="<?php echo $item->nome ?>"><img
                                                            style="width: 20px; height: 20px"
                                                            src="<?php echo URL_IMAGEM . "checar.png"; ?>"></a>
                                                    <a href="javascript:;" onclick="excluir3(this)"
                                                        data-entidade="Encomendas"
                                                        data-id="<?php echo $item->id_pedidos ?>"><img
                                                            style="width: 20px; height: 20px"
                                                            src="<?php echo URL_IMAGEM . "del.png"; ?>"></a>
                                                </td>
                                                <td hidden align="right"><?php echo $item->id_pedidos ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                        </section>
                    </article>


                </div>

            </div>

        </div>
    </div>

    </div>

</section>
<script>
var novoPedido = "<?php echo $nr_pedido + 1; ?>";
</script>
<div class="window formulario" id="janela3">
    <div class="p-4 width-100 d-inline-block">
        <form method="POST" id="nomePedido2">
            <div class="rows">
                <select id="nm_cliente" name="nm_cliente" class="form-campo">

                    <?php
                    foreach ($clientes as $cliente) :
                    ?>
                    <option value="<?php echo $cliente->nm_nome; ?>"><?php echo $cliente->nm_nome; ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
                <div class="col-12">
                    <span class="label text-label">Data da Entrega</span>
                    <input id="data_encomendas" name="data_encomendas" type="date" value="" required="required"
                        class="form-campo campo-form">
                </div>
                <input type="hidden" id="encomendas" value="S">
                <div class="col-12 mt-3">
                    <input id="nomePedido2" type="submit" class="btn">
                </div>
            </div>
        </form>
        <a href="#" class="fechar">x</a>
    </div>
</div>

<div class="window formulario" id="quantAlterar">
    <div class="p-4 width-100 d-inline-block">
        <form method="POST" id="alteraPedido">
            <div class="rows">
                <div class="ocDiv">
                    <input id="id_pedidos" name="id_pedidos" type="text" value="">
                </div>

                <div class="col-12">
                    <span class="label text-label">Produto</span>
                    <input class="form-campo" id="nome" name="nome" type="text" value="">
                </div>
                <div class="col-12">
                    <span class="label text-label">Quantidade</span>
                    <input class="form-campo" id="quant" name="quant" type="number" value="">
                </div>
                <div class="col-12">
                    <span class="label text-label">Valor Unitario</span>
                    <input class="form-campo" id="valorEnc" name="valor2" type="text" value="">
                </div>
                <div class="col-12 mt-3">
                    <input id="alteraPedido" type="submit" class="btn">
                </div>
            </div>
        </form>
        <a href="#" class="fechar">x</a>
    </div>
</div>

<div class="window formulario " id="janela2">
    <div class="p-4 width-100 d-inline-block">
        <form method="POST" id="fecharPedido">
            <div class="rows">
                <div class="col-12 ocDiv">
                    <input id="id_pedidos" name="id_pedidos" type="text" value="<?php echo $_SESSION["nr_ped"]; ?>">
                </div>
                <div class="col-12">
                    <span class="label text-label">Valor Do Pedido</span>
                    <input id="valor" name="valor" type="text"
                        value="<?php echo isset($somaPedido) ? moedaBr($somaPedido) : null; ?>" readonly
                        class="form-campo campo-form">
                </div>
                <div class="col-12">
                    <span class="label text-label">Tipo Pagamento</span>
                    <select onchange="mostraCampos(this.value)" id="tipo_pg" name="tipo_pg" class="form-campo">
                        <option value=""></option>
                        <option value="Dinheiro">Dinheiro</option>
                        <option value="Cartao">Cartão</option>
                        <option value="Pix">Pix</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>
                <div id="mostra" class="col-12">
                    <span class="label text-label">Desconto</span>
                    <input id="desconto" name="desconto" type="text" value="<?php echo moedaBr(0);?>" onblur="darDesc()"
                        placeholder="Desconto..." class="form-campo campo-form">
                </div>
                <div id="mostra5" class="col-12">
					<span class="label text-label">Aumento</span>
					<input id="aumento" name="aumento" type="text" value="<?php echo moedaBr(0);?>" onblur="darAumento()"  placeholder="Aumento..." class="form-campo campo-form">
				</div>
                <div id="mostra2" class="col-12">
                    <span class="label text-label">Valor Liquido</span>
                    <input id="vLiquido" name="vLiquido" type="text" value="0" readonly class="form-campo campo-form">
                </div>
                <div id="mostra3" class="col-12">
                    <span class="label text-label">Dinheiro</span>
                    <input id="dinheiro" name="dinheiro" type="text" value="" onblur="darTroco()" placeholder="Dinheiro"
                        class="form-campo campo-form">
                </div>

                <div id="mostra4" class="col-12">
                    <span class="label text-label">Troco</span>
                    <input id="troco" name="troco" type="text" value="0" readonly placeholder="Troco"
                        class="form-campo campo-form">
                </div>

                <div class="col-12 mt-3">
                    <input id="fecharPedido" type="submit" class="btn">
                </div>
            </div>
        </form>
        <a href="#" class="fechar">x</a>
    </div>

</div>
<div id="mascara"></div>