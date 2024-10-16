<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>LOGIN</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo URL_IMAGEM_vaf ?>PHOTO-2024-08-20-10-35-08.jpg" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/css/auxiliar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/css/grade.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/css/m-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!--font icones-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>

<body class="base-login">
    <div class="rows mx-0">
        <div class="col-4 m-auto">
            <div class="caixa p-4 pb-4 position-relative">
                <img src="<?php echo URL_BASE ?>images/PHOTO-2024-08-20-10-35-08.jpg" width="340px" class="m-auto d-block">
                <form action="<?php echo URL_BASE . 'login/enviar_senha'; ?>" method="POST">
                    <h1 class="text-center mt-2">Recuperar senha</h1>
                    <?php $this->verMsg() ?>
                    <?php $this->verErro(); ?>
                    <label class="mb-2 d-block">
                        <span class="d-block text-label">Informe email cadastrado</span>
                        <input id="email" type="email" name="email" placeholder="Email de recuperação de senha." class="form-campo" required>
                    </label>
                    <input type="submit" value="Recuperar" class="btn btn-tutaLogin d-table m-auto width-100 h5">
                    <br /><br />
                </form>
                <div>
                    <a style="color: white;" href="<?php echo URL_BASE . 'login'; ?>">
                        <i class="fas fa-sign-in-alt"></i> Página de login
                    </a>
                </div>
            </div>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="<?php echo URL_BASE ?>assets/js/js.js"></script>
</body>

</html>