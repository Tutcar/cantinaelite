<!doctype html>
<html language="pt-br">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">

<head>
	<title>CantinaElite</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo URL_IMAGEM_vaf ?>PHOTO-2024-08-20-10-35-08.jpg" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/js/datatables/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/js/jquery.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/js/datatables/css/responsive.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/js/datatables/css/style_dataTable.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/css/auxiliar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/css/tuta.css">
	<link rel="stylesheet" href="<?php echo URL_BASE ?>assets/css/grade.css">
	<link rel="stylesheet" href="<?php echo URL_BASE ?>assets/css/estilo-modal.css">
	<link rel="stylesheet" href="<?php echo URL_BASE ?>assets/css/stylee.css">
	<link rel="stylesheet" href="<?php echo URL_BASE ?>assets/css/tuta.css">
	<link rel="stylesheet" href="<?php echo URL_BASE ?>assets/css/carrocel.css">
	<link rel="stylesheet" href="<?php echo URL_BASE ?>/assets/css/menu.css">
	<script>
		var base_url2 = "<?php echo URL_BASE ?>"
		var nrpedido = <?php echo isset($_SESSION["nr_ped"]) ? $_SESSION["nr_ped"] : '0'; ?>
	</script>
	<!--font icones-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<script src="<?php echo URL_BASE ?>assets/js/jquery.min.js"></script>
	<script>
		var base_url = "<?php echo URL_BASE ?>";
		var base_url2 = "<?php echo URL_BASE ?>";
	</script>
</head>

<body>
	<?php include_once 'cabecalho.php'; ?>
	<div class="conteudo">
		<?php $this->load($view, $viewData) ?>
	</div>

	<?php include_once 'rodape.php'; ?>
	<!-- Acordeon-->
	<script src="assets/admin/js/jquery-ui.js"></script>
	<!-- Graficos -->
	<script src="assets/admin/js/chart.js/Chart.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://kit.fontawesome.com/9480317a2f.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/jquery.mask.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/datatables/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/datatables/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/componentes/js_data_table.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/componentes/jsmascaras.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/mascara.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/js.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/buscacep.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/buscacepj.js"></script>
	<script src="<?php echo URL_BASE ?>assets/js/jsp.js"></script>
</body>

</html>