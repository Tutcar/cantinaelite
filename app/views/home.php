<section class="caixa">
	<div class="thead"><i class="ico home"></i> Caixa do Dia : <?php echo date('d/m/Y'); ?></div>
	<div class="base-home">
		<div class="grade">
			<div class="rows">


				<div class="col-6">
					<article class="cx-home">
						<div class="thead">Cardápio</div>
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
													<td id="idVenda" align="right"><?php echo moedaBR($produtos->venda) ?></td>
													<?php if ($produtos->foto || "") : ?>
														<?php $imagem = $produtos->foto ?>
													<?php else : ?>
														<?php $imagem = 'camera.png' ?>
													<?php endif; ?>
													<td><a href="javascript:;" onclick="cadPedido(<?php echo $produtos->id_produtos ?>)"><img style="width: 50px; height: 50px" src="<?php echo URL_IMAGEM . $imagem ?>"></a></td>
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

								<label class="btn" href="javascript:;" id="nomePedidos" onclick="abrirModal('#janela1')">Novo Pedidos</label>
								<select onchange="mostraAlerta(this.value)" id="novoPed" name="nr_pedidos" class="form-campo">
									<option value="novo"></option>
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

								<div class="col-12">
									<button class="btn novo" ref="javascript:;" id="fechaPedidos" onclick="abrirModal('#janela2')">Fechar Pedido:<?php echo isset($somaPedido) ? "   -   R$ " . moedaBr($somaPedido) : null; ?></button>
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
													<td><?php echo $item->quant ?></td>
													<td align="right"><?php echo moedaBR($item->valor * $item->quant) ?></td>
													<td align="center">
														<a href="javascript:;"
															onclick="abrirModalQuant2('#quantAlterar2', this)"
															data-valorPd="<?php echo $item->valor ?>"
															data-quantPd="<?php echo $item->quant ?>"
															data-idPd="<?php echo $item->id_pedidos ?>"
															data-nm_nomePd="<?php echo $item->nome ?>"><img
																style="width: 15px; height: 15px"
																src="<?php echo URL_IMAGEM . "checar.png"; ?>"></a>
														<a href="javascript:;" onclick="excluir3(this)" data-entidade="pedidos" data-id="<?php echo $item->id_pedidos ?>"><img style="width: 20px; height: 20px" src="<?php echo URL_IMAGEM . "del.png"; ?>"></a>
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
<div class="window formulario" id="janela1">
	<div class="p-4 width-100 d-inline-block">
		<form method="POST" id="nomePedido">
			<div class="rows">
				<div class="col-12">
					<span class="label text-label">Nome Cliente</span>

					<select id="nomeCliente" name="cliente" class="form-campo">
						<option value=""></option>
						<?php
						foreach ($clientes as $cliente) :
						?>
							<option value="<?php echo $cliente->nm_nome; ?>"><?php echo $cliente->nm_nome; ?></option>
						<?php
						endforeach;
						?>
					</select>

					<!-- <input id="nomeCliente" name="cliente" type="text" class="form-campo campo-form"> -->
				</div>
				<div class="col-12 mt-3">
					<input id="nomePedido" type="submit" class="btn">
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
					<input id="valor" name="valor" type="text" value="<?php echo isset($somaPedido) ? moedaBr($somaPedido) : null; ?>" readonly class="form-campo campo-form">
				</div>
				<div class="col-12">
					<span class="label text-label">Tipo Pagamento</span>
					<select onchange="mostraCampos(this.value)" id="tipo_pg" name="tipo_pg" class="form-campo">
						<option value="Dinheiro">Opção de Pagamento</option>
						<option value="Dinheiro">Dinheiro</option>
						<option value="Cartao">Cartão</option>
						<option value="Pix">Pix</option>
						<option value="Outros">Outros</option>
					</select>
				</div>
				<div id="mostra" class="col-12">
					<span class="label text-label">Desconto</span>
					<input id="desconto" name="desconto" type="text" value="<?php echo 0; ?>" onblur="darDesc()" placeholder="Desconto..." class="form-campo campo-form">
				</div>
				<div id="mostra5" class="col-12">
					<span class="label text-label">Taxa de Entrega</span>
					<input id="aumento" name="aumento" type="text" value="<?php echo 0; ?>" onblur="darAumento()" placeholder="Aumento..." class="form-campo campo-form">
				</div>
				<div id="mostra2" class="col-12">
					<span class="label text-label">Valor Liquido</span>
					<input id="vLiquido" name="vLiquido" type="text" value="0" readonly class="form-campo campo-form">
				</div>
				<div id="mostra3" class="col-12">
					<span class="label text-label">Dinheiro</span>
					<input id="dinheiro" name="dinheiro" type="text" value="" onblur="darTroco()" placeholder="Dinheiro" class="form-campo campo-form">
				</div>

				<div id="mostra4" class="col-12">
					<span class="label text-label">Troco</span>
					<input id="troco" name="troco" type="text" value="0" readonly placeholder="Troco" class="form-campo campo-form">
				</div>

				<div class="col-12 mt-3">
					<input id="fecharPedido" type="submit" class="btn">
				</div>
			</div>
		</form>
		<a href="#" class="fechar">x</a>
	</div>

</div>
<div class="window formulario" id="quantAlterar2">
	<div class="p-4 width-100 d-inline-block">
		<form method="POST" id="alteraPedido2">
			<div class="rows">
				<div class="ocDiv"> <!--class="ocDiv"-->
					<span class="label text-label">Id</span>
					<input id="id_pedidosPd" name="id_pedidos" type="text" value="">
				</div>

				<div class="col-12 ocDiv">
					<span class="label text-label">Produto</span>
					<input class="form-campo" id="nomePd" name="nome" type="text" value="">
				</div>
				<div class="col-12">
					<span class="label text-label">Quantidade</span>
					<input class="form-campo" id="quantPd" name="quant" type="number" value="">
				</div>
				<div class="col-12 ocDiv">
					<span class="label text-label">Valor Unitario</span>
					<input class="form-campo" id="valorPd" name="valor2" type="text" value="">
				</div>
				<div class="col-12 mt-3">
					<input id="alteraPedido2" type="submit" class="btn">
				</div>
			</div>
		</form>
		<a href="#" class="fechar">x</a>
	</div>
</div>
<div id="mascara"></div>