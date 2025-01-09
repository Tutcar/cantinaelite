<script>
    var coluOr = 0;
</script>
<section class="caixa">
    <div class="thead"><i class="ico lista"></i> Lista de Caixas Não Conferidos</div>
    <div class="base-lista">
        <?php $this->verMsg() ?>
        <div class="tabela-responsiva">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="dataTable">
                <thead>
                    <tr>
                        <th hidden align="center">Id</th>
                        <th align="center">Caixa</th>
                        <th align="center">Ação</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($caixasNaoConferidos as $caixas) { ?>
                        <td hidden align="right"><?php echo $caixas->id_caixaabre ?></td>
                        <tr>
                            <td align="left">
                                <?php
                                // Verifica se a data está definida
                                if (!empty($caixas->data_ab_caixa)) {
                                    // Cria um objeto DateTime com o valor da data
                                    $data = new DateTime($caixas->data_ab_caixa);

                                    // Formata a data no formato desejado
                                    echo $data->format('d-m-Y H:i:s');
                                } else {
                                    // Caso não tenha valor, exibe um texto padrão ou vazio
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                            <td align="center">
                                <a title="Conferir" href="<?php echo URL_BASE . "Caixafecha/indexnaoconferido/" . $caixas->id_caixaabre ?>"><img
                                        style="width: 30px; height: 30px"
                                        src="<?php echo URL_IMAGEM . "editar.jpeg"; ?>"></a>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
        <div class="text-end d-flex">
            <a title="Voltar" href="<?php echo URL_BASE . "Painel" ?>"><img style="width: 30px; height: 30px"
                    src="<?php echo URL_IMAGEM . "voltar.png"; ?>"></a>&nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
        </div>
    </div>
</section>