<script>
    var coluOr = 2;
</script>

<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Marmitex: pequeno <?php echo ($marmitexsContar["total_pequeno"] > 0) ? $marmitexsContar["total_pequeno"] : 0; ?> grande <?php echo ($marmitexsContar["total_grande"] > 0) ? $marmitexsContar["total_grande"] : 0; ?> Valor: <?php echo ($marmitexsContar["soma_total"] > 0) ? moedaBr($marmitexsContar["soma_total"]) : moedaBr(0); ?><?php echo " - " . databr(hoje()); ?></div>
    <div class="base-lista">
        <div class="rows">
            <div class="text-end d-flex col-12">
                <a title="Voltar" href="<?php echo URL_BASE . "painel" ?>"><img style="width: 30px; height: 30px"
                        src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>&nbsp;
                <?php if ($marmitexsContar["total_registros"] > 0) : ?>
                    <a title="Imprimir relatorio" href="<?php echo URL_BASE . "Pedidos/marmitexImp" ?>" class="d-inline-block mb-2"><img style="width: 30px; height: 30px" src="<?php echo URL_IMAGEM . 'imprimirped.png'; ?>"></a>
                <?php endif; ?>
            </div>

        </div>
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th align="left">Pedido</th>
                        <th align="center">Prato</th>
                        <th align="center">Cliente</th>
                        <th align="center">Observação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($marmitexs as $marmitex) { ?>
                        <tr>
                            <?php
                            $nomeCompleto = $marmitex->cli_p;
                            $partesNome = explode(' ', $nomeCompleto);
                            $primeiroNome = $partesNome[0];
                            $ultimoNome = $partesNome[count($partesNome) - 1];
                            $cli_p = $primeiroNome . " " . $ultimoNome;

                            $tamanho = $marmitex->nome;
                            $tamanho1 = explode(' ', $tamanho);
                            $tamanhoM = $tamanho1[count($tamanho1) - 1];
                            ?>
                            <td align="left"><?php echo $marmitex->id_pedidos ?></td>
                            <td align="left"><?php echo $tamanhoM ?></td>
                            <td align="left"><?php echo $cli_p ?></td>
                            <td align="left"><?php echo $marmitex->obs_cardapio ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</section>
<script>
    $(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'none';
        var table = $('#dataTable').DataTable({
            order: [
                [2, 'asc']
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            }
        });

        // Exemplo de atualização dinâmica
        function atualizarDados(novosDados) {
            table.clear(); // Limpa os dados existentes
            table.rows.add(novosDados); // Adiciona os novos dados
            table.draw(); // Atualiza a tabela
        }
    });
</script>