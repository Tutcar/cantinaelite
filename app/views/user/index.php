<script>
	var coluOr = 2;
</script>
<section class="caixa">
	<div class="thead"><i class="ico lista"></i> Lista Usuários</div>
	<div class="base-lista">

		<div>
			<div class="text-end d-flex">
				<a href="<?php echo URL_BASE . "user/create" ?>" class="btn btn-roxo d-inline-block mb-2 mx-1"><i class="fas fa fa-plus-circle" aria-hidden="true"></i> Cadastrar user</a>
				<a href="" class="btn btn-roxo d-inline-block mb-2 filtro"><i class="fas fa fa-filter" aria-hidden="true"></i> Filtrar</a>
			</div>
		</div>
		<div class="lst mostraFiltro">
			<form action="<?php echo URL_BASE . "user/filtro"; ?>" method="post">
				<div class="rows">
					<div class="col-4">
						<select name="campo">
							<option selected>nome</option>
						</select>
					</div>
					<div class="col-6">
						<input type="text" name="valor" placeholder="Valor da pesquisar...">
					</div>
					<div class="col-2">
						<input type="submit" class="btn-roxo" value="Pesquisar">
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
							<td><?php echo $user->login ?></td>
							<td hidden><?php echo $user->id_user ?></td>

							<td align="center">
								<a href="<?php echo URL_BASE . "user/edit/" . $user->id_user ?>" class="btn btn-verde">Editar</a>
								<a href="javascript:;" onclick="excluir(this)" data-entidade="user" data-id="<?php echo $user->id_user ?>" class="btn btn-vermelho">Excluir</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>

			</table>
		</div>
	</div>
</section>