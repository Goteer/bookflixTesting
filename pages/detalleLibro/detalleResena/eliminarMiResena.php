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

</style>

<form method="post" name="volverForm" action="../navigation/nav.php">
  <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
  <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/listarResena.php"/>
</form>
<br>
<div align="center">
<h2>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/pages/detalleLibro/detalleResena/class.consultasResena.php';
$consulta = new ConsultasResena();
echo $consulta->eliminarResena($_POST['idResena']);
echo "</h2>
    <script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>";
    die();

?>


