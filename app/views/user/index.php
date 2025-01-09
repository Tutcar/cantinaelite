<script>
	var coluOr = 2;
</script>
<section class="caixa">
	<div class="thead"><i class="ico lista"></i> Lista Usuários</div>
	<div class="base-lista">
		<div>
			<div class="rows">
				<div class="text-end d-flex col-12">
					<a title="Voltar" href="<?php echo URL_BASE . "painel" ?>"><img style="width: 30px; height: 30px"
							src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>&nbsp;
					<a title="Pesquisar" data-element="#minhaDiv" href="" class="d-inline-block mb-2 btn-toggle"><i aria-hidden="true"></i> <img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . "filtrar.jpeg"; ?>"></a>
				</div>

			</div>

		</div>
		<div id="minhaDiv" class="lst">
			<form action="<?php echo URL_BASE . "User/filtro"; ?>" method="post">
				<div class="rows">
					<div class="col-4">
						<select name="campo">
							<option value="login_cli" selected>nome</option>
						</select>
					</div>
					<div class="col-6">
						<input type="text" required="required" name="nome" placeholder="Valor da pesquisar...">
					</div>
					<div class="col-2">
						<input type="submit" class="btn" value="Pesquisar">
					</div>
				</div>
			</form>
		</div>
		<?php $this->verMsg() ?>
		<div class="tabela-responsiva">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
				<thead>
					<tr>
						<th align="left">Usuário</th>
						<th hidden align="left">ID</th>
						<th align="center">Ação</th>
					</tr>
				</thead>
				<tbody>


					<?php foreach ($lista as $user) { ?>
						<tr>
							<td><?php echo $user->login_cli ?></td>
							<td hidden><?php echo $user->id_user ?></td>

							<td align="center">
								<a title="Editar" href="<?php echo URL_BASE . "user/edit/" . $user->id_user ?>"><img
										style="width: 25px; height: 25px"
										src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a>
								<a title="Excluir" href="javascript:;" onclick="excluir(this)" data-entidade="user" data-id="<?php echo $user->id_user ?>"><img style="width: 25px; height: 25px" src="<?php echo URL_IMAGEM . "excluir.png"; ?>"></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>

			</table>
		</div>
	</div>
</section>