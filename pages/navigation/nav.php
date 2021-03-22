<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Hub libros prueba</title>
	<link rel="stylesheet" href="../../resources/framework/mainStyle.css">
	<meta charset="UTF-8" />
</head>


<body>

<?php
include_once "../../resources/framework/DBconfig.php";
include_once "../../resources/framework/common/topbar.php";

if (isset($_POST['target_page'])) {
    include $_POST['target_page'];
}else{
    include "../home/home.php"; //Si no encuentro a que pagina queria ir, voy al home
}
 ?>





 <?php
$conn = null;
 ?>
</body>
