
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<style>
	button {
	  background-color: #555555;
	  color: white;
	  padding: 14px 20px;
	  margin: 8px 0;
	  border: none;
	  border-radius: 4px;
	  cursor: pointer;
	}

	.cuadro-listado {
	  margin: 15px 0;
	  background-image: linear-gradient(to bottom,#444, #222);
	  padding-top:10px;
	  padding-bottom:10px;
	  width:80%;
	}

	input, select, textarea{
	    color: #000000;
	}

	.row {
	  margin: 15px 0;
	  border:1px;
	  border-style: solid;
	  border-color: white;
	  background-color: rgba(0, 0, 0, 0.35);
	}
	.no-margin
	{
	  margin: 0px !important;
	}

	</style>

	<h1>Modificar Novedad</h1>

	<?php
		require_once('class.consultasnovedad.php');
		require_once('../../resources/framework/DBconfig.php');
		require_once('seleccionar.php');
		$id = $_POST['idNovedad'];
		seleccionar($id);
	?>

</body>
</html>