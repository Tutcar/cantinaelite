<?php print_r($corrente->foto); ?>
<section class="caixa">
	<div class="thead"><i class="ico cad"></i>Conta corrente <?php echo isset($corretoras->nome) ? substr($corretoras->nome, 0, 20)  : null ?></div>
	<div class="base-form">
		<div class="caixa-form">
			<div class="thead">Inserir novo cadastro</div>
			<form action="<?php echo URL_BASE . "corrente/salvar/?id_corretora=" . $corretoras->id_corretora ?>" method="POST">
				<?php
				$this->verMsg();
				$this->verErro();
				?>
				<div class="rows">
					<div class="col-3 position-relative">
						<?php $imagem = ($_SESSION[SESSION_LOGIN]->foto <> '') ? $_SESSION[SESSION_LOGIN]->foto : "img-usuario.png"; ?>
						<img src="<?php echo URL_IMAGEM . $imagem ?>" class="img-fluido foto" id="imgUp">
					</div>

					<div class="col-9">
						<div class="rows">
							<div class="col-4">
								<label>Nr. Doc. Banco</label>
								<input name="nr_doc_banco" value="<?php echo isset($corrente->nr_doc_banco) ? $corrente->nr_doc_banco : null ?>" type="text" placeholder="Insira número doc banco" class="form-campo">
							</div>
							<div class="col-4">
								<label>Despesas/Credito</label>
								<input name="cod_despesa" value="<?php echo isset($corrente->cod_despesa) ? $corrente->cod_despesa : null ?>" type="text" placeholder="Descreva despesa/credito" class="form-campo">
							</div>

							<div class="col-4">
								<label>Data</label>
								<input name="data_cad" value="<?php echo isset($corrente->data_cad) ? $corrente->data_cad : "S" ?>" type="date" placeholder="Insira data de cadastro" class="form-campo">
							</div>
							<div class="col-8">
								<label>Descriminação</label>
								<input name="descricao" value="<?php echo isset($corrente->descricao) ? $corrente->descricao : null ?>" type="text" placeholder="Insira descriminação" class="form-campo">
							</div>

							<div class="col-4">
								<label>Nr. Doc. Pg</label>
								<input name="nr_doc_pg" value="<?php echo isset($corrente->nr_doc_pg) ? $corrente->nr_doc_pg : null ?>" type="text" placeholder="Insira nr doc de pagamento" class="form-campo">
							</div>
							<div class="col-3">
								<label>Debito</label>
								<input onblur="validaCampoDebito()" name="valor_debito" id="valor_debito" value="<?php echo isset($corrente->valor_debito) ? $corrente->valor_debito : null ?>" type="text" class="form-campo">
							</div>

							<div class="col-3">
								<label>Credito</label>
								<input onblur="validaCampoCredito()" name="valor_credito" id="valor_credito" value="<?php echo isset($corrente->valor_credito) ? $corrente->valor_credito : null ?>" type="text" class="form-campo">
							</div>
							<div class="col-3">
								<label>Não compensado</label>
								<input type="radio" name="confirma" value="N" <?php echo (isset($corrente->confirma) and $corrente->confirma === "N") ? "checked" : "checked" ?>>
							</div>
							<div class="col-3">
								<label>Compensado</label>
								<input type="radio" name="confirma" value="S" <?php echo (isset($corrente->confirma) and $corrente->confirma === "S") ? "checked" : null ?>>
							</div>

							<div class="col-12">
								<label>Observação</label>
								<textarea rows="10" name="obs" class="form-campo"><?php echo isset($corrente->obs) ? $corrente->obs : null ?></textarea>
							</div>
						</div>

					</div>
					<div class="col-12">
						<div class="rows">

							<div class="col-3 position-relative">
								<?php $imagem = ($corrente->foto <> "") ? $corrente->foto : "arquivo.jpg"; ?>
								<img src="<?php echo URL_IMAGEM . $imagem ?>" class="img-fluido foto" id="imgUp">
								<div class="foto-file">
									<input type="file" id="arquivo" name="arquivo" onchange="pegaArquivo(this.files)"><label for="arquivo"><span>Editar arquivo</span></label>
								</div>
							</div>

							<div class="col-3">
								<input type="submit" value="Arquivo" class="btn">
							</div>
							<div class="col-3">
								<input type="hidden" name="tipo" value="1" />
								<input type="hidden" name="id_corretora" value="<?php echo isset($corretoras->id_corretora) ? $corretoras->id_corretora : null ?>" />
								<input type="hidden" name="id_corrente" value="<?php echo isset($corrente->id_corrente) ? $corrente->id_corrente : null ?>" />
								<input type="submit" value="Cadastrar" class="btn">

							</div>
						</div>
					</div>

			</form>
		</div>
	</div>
	<script src="<?php echo URL_BASE ?>assets/js/mascara.js"></script>
</section>