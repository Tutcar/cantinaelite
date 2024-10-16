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

    <!--font icones-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>

<body class="base-login">
    <div class="rows mx-0">
        <div class="col-4 m-auto">
            <div class="caixa p-4 pb-4 position-relative">
                <img src="<?php echo URL_BASE ?>images/PHOTO-2024-08-20-10-35-08.jpg" width="340px" class="m-auto d-block">
                <?php $this->verMsg() ?>
                <?php $this->verErro(); ?>

                <form action="<?php echo URL_BASE . 'login/resetar_senha'; ?>" method="POST">
                    <h1 class="text-center mt-2">Resetar senha</h1>
                    <input type="hidden" name="token" value="">

                    <label class="mb-2 d-block">
                        <span class="d-block text-label">Nova senha.</span>
                        <input maxlength="20" minlength="6" id="senha" type="password" name="senha" placeholder="Informe a nova senha" class="form-campo" required>
                    </label>
                    <input type="submit" value="Redefinir Senha" class="btn btn-tutaLogin d-table m-auto width-100 h5">
                    <br /><br />
                    <br /><br /><br /><br />
                </form>
                <div>
                    <a style="color: white;" href="<?php echo URL_BASE . 'login'; ?>">
                        <i class="fas fa-sign-in-alt"></i> Página de login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Pegando o token da URL usando a barra como separador
        const path = window.location.pathname;
        const pathParts = path.split('/');
    
        // Procurando o token na URL
        const tokenIndex = pathParts.indexOf('token');
        const token = tokenIndex !== -1 ? pathParts[tokenIndex + 1] : null;
        
        // Atribuindo o valor do token ao campo hidden do formulário
        if (token) {
            document.querySelector('input[name="token"]').value = token;
        }
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="<?php echo URL_BASE ?>assets/js/js.js"></script>
</body>

</html>
