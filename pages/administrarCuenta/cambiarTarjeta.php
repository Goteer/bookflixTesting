
<style>

input, select {

  width: 80%;
  max-width:800px;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

#content-box input[type=submit] ,#content-box button {
	width: 100%;
	max-width:500px;
  background-color: #555555;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover , button:hover {
  background-color: #444444;
}

input, select, textarea{
    color: #000000;
}

label {
  font-size: 20px;
}
</style>
<form method="POST" id="volverForm" action="../navigation/nav.php">
<input type="hidden" name="target_page" value="/pages/administrarCuenta/editarCuenta.php"/>
</form>







<br>


<div align="center" style="width:100%">
  <div id="content-box" style="width:80vw; border-radius: 5px; padding-left:1vw" align="left">

    <?php
    require_once($_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.tarjeta.php");


    $tarjeta = new TarjetaDB();

    $tarjeta->setFiltro("idUsuario = ".$conn->quote($_SESSION['id']));
    $tarjeta->fetchRecordSet($conn);

    if (!($next = $tarjeta->getNextRecord())) {
      echo "<h2>";
      echo "Error en la base de datos al buscar la tarjeta actual. Contacte con un administrador si este error persiste.";
      echo "</h2>";
      echo '<script type="text/javascript">
    		setTimeout(function(){document.forms["volverForm"].submit()},3000);
    	</script>';
      echo '  </div>
      </div>';
      die();

    }else{
      //Usuario esta disponible, continuar.

    }

    ?>

    <br>
    <h2>Cambiar tarjeta a facturar...</h2><br>
    <br>
    <form method="POST" action="../navigation/nav.php">

      <label>Direcci&oacute;n de correo electronico:</label><br>
      <br>
      <label>Nro tarjeta credito:</label><br>
      <input type="text" name="nroTarjeta" placeholder="Nro de tarjeta..." pattern="[0-9]{16}" required minlength="16" maxlength="16" value="<?= (isset($_SESSION['nroTarjeta'])?$_SESSION['nroTarjeta']:$next->nroTarjeta) ?>" title="El numero de tarjeta deben ser 16 digitos."/><br>

      <label>Fecha vencimiento:</label><br>
      <input type="text" name="vencimiento" placeholder="mm/aa" pattern="[0-9]{2}[/,-]{1}[0-9]{2}" required value="<?= (isset($_SESSION['vencimiento'])?$_SESSION['vencimiento']:substr($next->vencimiento,5,2).'/'.substr($next->vencimiento,2,2)) ?>" title="Ingrese un vencimiento del formato mm/aa, EJ: 03/20"/><br>

      <label>Nombre del Titular de la tarjeta (Como figura en la tarjeta) :</label><br>
      <input type="text" name="nombreTitular" placeholder="Nombre del titular..." pattern="[a-zA-Z.\x20]+" required maxlength="16" value="<?= (isset($_SESSION['nombreTitular'])?$_SESSION['nombreTitular']:$next->titular) ?>"/><br>


      <label>Cod Seguridad (Ultimos 3 digitos del reverso de la tarjeta):</label><br>
      <input id="number" name="codSeg" type="text" placeholder="Cod Seguridad..." pattern="[0-9]{3}"required maxlength="3" minlength="3" title="El codigo deben ser 3 digitos"><br>


      <a onclick="document.getElementById('volverForm').submit();"><button>Volver atras</button></a></p>
      <input type="hidden" name="target_page" value="/pages/administrarCuenta/class/tarjetaEditada.php"/>
      <input type="submit" value="Continuar">
      <br>
    </form>
  </div>
</div>
