<section class="caixa">
    <div class="thead"><i class="ico cad"></i>Formulario de cadastro Aluno</div>
    <div class="base-form">
        <div class="caixa-form">
            <div class="thead">Cadastro do aluno</div>
            <form action="<?php echo URL_BASE . "cliente/salvar" ?>" method="POST" enctype="multipart/form-data">
                <?php
                $this->verMsg();
                $this->verErro();
                ?>
                <div class="rows">
                    <div class="col-3 position-relative">
                        <?php if (@$cliente->foto || "") : ?>
                            <?php $imagem = $cliente->foto ?>
                        <?php else : ?>
                            <?php $imagem = 'img-usuario.png' ?>
                        <?php endif; ?>
                        <img src="<?php echo URL_IMAGEM . $imagem ?>" class="img-fluido foto" id="imgUp">
                        <div class="foto-file">
                            <input type="file" name="arquivo" id="arquivo" onchange="pegaArquivo(this.files)"><label for="arquivo"><span>Editar foto</span></label>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="rows">
                            <div class="col-6">
                                <label>Aluno</label>
                                <?php
                                // Exemplo de variável que contém o nome do cliente
                                $nomeExistente = isset($cliente->nm_nome) ? $cliente->nm_nome : "";

                                // Verifica se o nome já existe
                                $readonly = !empty($nomeExistente) ? 'readonly' : '';
                                ?>
                                <input name="nm_nome" required="required" value="<?php echo $nomeExistente ?>" type="text" placeholder="Nome aluno" class="form-campo" <?php echo $readonly; ?>>
                            </div>
                            <div class="col-6">
                                <label>Respponsável</label>
                                <input name="nm_short" required="required" value="<?php echo isset($cliente->nm_short) ? $cliente->nm_short : null ?>" type="text" placeholder="Responsável pelo aluno" class="form-campo">
                            </div>
                            <div class="col-4">
                                <label>CPF/CNPJ</label>
                                <input name="nr_cpf_cnpj" required="required" value="<?php echo isset($cliente->nr_cpf_cnpj) ? $cliente->nr_cpf_cnpj : null ?>" type="number" placeholder="CPF/CNPJ responável" class="form-campo">
                            </div>
                            <div class="col-3">
                                <label>Aniversário</label>
                                <input name="dat_niver" value="<?php echo isset($cliente->dat_niver) ? $cliente->dat_niver : null ?>" type="date" placeholder="Aniverário aluno" class="form-campo">
                            </div>
                            <div class="col-2">
                                <label>Serie</label>
                                <input name="serie" value="<?php echo isset($cliente->serie) ? $cliente->serie : null ?>" type="text" placeholder="Serie aluno" class="form-campo">
                            </div>
                            <div class="col-3">
                                <label>Fone</label>
                                <input name="nr_fone" value="<?php echo isset($cliente->nr_fone) ? $cliente->nr_fone : null ?>" type="text" placeholder="Fone aluno" class="form-campo">
                            </div>
                            <div class="col-3">
                                <label>CEP</label>
                                <input href="javascript:;" id="nr_cep" name="nr_cep" value="<?php echo isset($cliente->nr_cep) ? $cliente->nr_cep : null ?>" type="text" onchange="pesquisacep()" placeholder="Cep aluno" class="form-campo">
                            </div>
                            <div class="col-6">
                                <label>Rua</label>
                                <input id="nm_rua" name="nm_rua" value="<?php echo isset($cliente->nm_rua) ? $cliente->nm_rua : null ?>" type="text" placeholder="Rua aluno" class="form-campo">
                            </div>
                            <div class="col-3">
                                <label>Número</label>
                                <input id="nr_numero" name="nr_numero" value="<?php echo isset($cliente->nr_numero) ? $cliente->nr_numero : null ?>" type="text" placeholder="Numero aluno" class="form-campo">
                            </div>
                            <div class="col-6">
                                <label>Bairro</label>
                                <input id="nm_bairro" name="nm_bairro" value="<?php echo isset($cliente->nm_bairro) ? $cliente->nm_bairro : null ?>" type="text" placeholder="Bairro aluno" class="form-campo">
                            </div>
                            <div class="col-4">
                                <label>Cidade</label>
                                <input id="nm_cidade" name="nm_cidade" value="<?php echo isset($cliente->nm_cidade) ? $cliente->nm_cidade : null ?>" type="text" placeholder="Cidade aluno" class="form-campo">
                            </div>
                            <div class="col-2">
                                <label>UF</label>
                                <input id="sg_estado" name="sg_estado" value="<?php echo isset($cliente->sg_estado) ? $cliente->sg_estado : null ?>" type="text" placeholder="UF" class="form-campo">
                            </div> 
                            <div class="col-4">
                                <label>Limite</label>
                                <input id="limite" name="limite"
                                    value="<?php echo isset($cliente->limite) ? moedaBr($cliente->limite) : moedaBr(0) ?>"
                                    type="text" placeholder="Valor limite" class="form-campo">
                            </div>
                            <div class="col-8">
                                <label>Email</label>
                                <?php
                                // Exemplo de variável que contém o nome do cliente
                                $e_mailExistente = isset($cliente->e_mail) ? $cliente->e_mail : "";

                                // Verifica se o nome já existe
                                $readonly = !empty($e_mailExistente) ? 'readonly' : '';
                                ?>
                                <input name="e_mail" required="required" value="<?php echo $e_mailExistente ?>" type="text" placeholder="Email aluno" class="form-campo" <?php echo $readonly; ?>>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_cliente" value="<?php echo isset($cliente->id_cliente) ? $cliente->id_cliente : null ?>" />
                    <input type="submit" value="<?php echo isset($cliente->id_cliente) ? "Alterar" : "Cadastrar" ?>" class="btn">
            </form>
        </div>

    </div>
    <a href="<?php echo URL_BASE . "Cliente/index" ?>"><img style="width: 30px; height: 30px"
            src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>
    <script src="<?php echo URL_BASE ?>assets/js/mascara.js"></script>
</section>