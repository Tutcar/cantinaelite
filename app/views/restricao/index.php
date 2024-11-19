<form action="<?php echo URL_BASE . "Restricao/salvar" ?>" method="POST">
    <label for="id_aluno">Aluno:</label>
    <select name="id_cliente" id="id_cliente" required>
        <?php foreach ($clientes as $aluno): ?>
            <option value="<?= $aluno->id_cliente; ?>"><?= $aluno->nm_nome; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="id_produto">Produto:</label>
    <select name="id_produtos" id="id_produtos" required>
        <?php foreach ($produtos as $produto): ?>
            <option value="<?= $produto->id_produtos; ?>"><?= $produto->nome; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" name="id_restricoes" value="" />

    <button type="submit">Adicionar Restrição</button>
</form>