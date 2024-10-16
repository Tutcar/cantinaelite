<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Título da página</title>
    <meta charset="utf-8">
</head>

<body>
    <section class="caixa">
        <div>
            <div class="text-end d-flex">
                <a href="<?php echo URL_BASE . "Comp/index/" . $comp->id_corrente ?>" class="btn"><i aria-hidden="true"></i> Voltar</a>
            </div>
        </div>
        <div class="col-12 ">
            <br />
        </div>
        <div class="col-12 ">
            <div style="height: 150px;">
                <?php $imagem = ($comp->foto <> "") ? $comp->foto : "img-usuario.png"; ?>
                <embed src="<?php echo URL_IMAGEM . $imagem ?>" type="application/pdf" width="100%" height="500%">
            </div>
        </div>
    </section>

</body>

</html>