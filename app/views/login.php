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
	<?php $this->verErro(); ?>
	<div class="rows mx-0">

		<div class="col-4 m-auto">
			<div class="caixa p-4 pb-4 position-relative">
				<img src="<?php echo URL_BASE ?>images/PHOTO-2024-08-20-10-35-08.jpg" width="340px" class="m-auto d-block">



				<form action="<?php echo URL_BASE . 'login/logar'; ?>" method="POST">
					<h1 class="text-center mt-2">Login</h1>
					<?php $this->verMsg() ?>
					<label class="mb-2 d-block">
						<span class="d-block text-label">Email</span>
						<input id="e_mail" type="email" name="e_mail" placeholder="Email" class="form-campo" required>
					</label>

					<label class="mb-2 d-block">
						<span class="d-block text-label">Senha</span>
						<input type="password" name="senha" placeholder="Senha" class="form-campo" required minlength="6">
					</label>

					<input type="submit" value="Entrar" class="btn btn-tutaLogin d-table m-auto width-100 h5">
					<br /><br />

					<!-- Link para recuperação de senha -->
					<div class="text-center mt-2">
						<a style="color: wheat;" href="<?php echo URL_BASE . 'login/recuperar_senha'; ?>" class="text-secondary">Esqueceu sua senha?</a>
					</div>
					<br /><br /><br /><br />
				</form>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/js.js"></script>
</body>

</html>