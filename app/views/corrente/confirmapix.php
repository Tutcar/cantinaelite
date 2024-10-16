<?php
// Verifica se a URL do QR Code está definida
if (isset($_SESSION['qrcode_url'])) {
    $qrcode_url = $_SESSION['qrcode_url'];
} else {
    echo "Erro: QR Code não disponível.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento PIX</title>
</head>

<body>
    <h1>Pague seu pedido via PIX</h1>
    <p>Escaneie o QR Code abaixo para realizar o pagamento:</p>
    <img src="<?php echo $qrcode_url; ?>" alt="QR Code para pagamento via PIX">
    <p>Após realizar o pagamento, sua compra será confirmada automaticamente.</p>
</body>

</html>