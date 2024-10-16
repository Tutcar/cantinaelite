<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="fermentacao natural, padaria, paes, focaccia, italiano, cappuccino, cafe, bolo, bolos" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="images/PHOTO-2024-08-20-10-35-08.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URL_BASE ?>/style/style.css">
    <link rel="stylesheet" href="<?php echo URL_BASE ?>/style/stylecar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<script>
    var base_url = "<?php echo URL_BASE ?>";
    var base_url2 = "<?php echo URL_BASE ?>";
    const carrinhoSessao = <?php echo json_encode($carrinho); ?>;
</script>
<div class="div-msg">
    <?php $this->verMsg() ?>
</div>
<title>Cantina Elite</title>
</head>

<body id="home">
    <!-- cabecalho -->
    <?php include_once 'cabecalhocarda.php'; ?>
    <!-- conteudo -->
    <div class="conteudo">

        <?php $this->load($view, $viewData) ?>
    </div>
    <!-- Rodapé -->
    <?php include_once 'rodapecarda.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo URL_BASE ?>/assets/js/js/cart.js"></script>
    <script src="<?php echo URL_BASE ?>/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script src="<?php echo URL_BASE ?>assets/js/js.js"></script>
</body>

</html>