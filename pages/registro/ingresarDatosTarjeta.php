
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

input[type=submit] ,button {
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
<input type="hidden" name="retorno" value="/pages/registro/crearSuscripcion.php"/>
</form>







<br>


<div align="center" style:"width:100%">
  <div id="content-box" style="width:90vw; max-width:1000px; border-radius: 5px; padding-left:1vw" align="left">

    <?php
    require_once($_SERVER['DOCUMENT_ROOT']."/resources/framework/class/class.user.php");

    if (isset($_POST['usernameReg'])){
      $_SESSION['usernameReg'] = $_POST['usernameReg'];
    }
    if (isset($_POST['passwordReg'])){
      $_SESSION['passwordReg'] = $_POST['passwordReg'];
    }
    if (isset($_POST['email'])){
      $_SESSION['email'] = $_POST['email'];
    }
    if (isset($_POST['dniTitular'])){
      $_SESSION['dniTitular'] = $_POST['dniTitular'];
    }

    $user = new UserDB();

    $user->setFiltro("uLogin = ".$conn->quote($_SESSION['usernameReg'])." OR email = ".$conn->quote($_SESSION['email'])." OR dniTitular = ".$_SESSION['dniTitular']);
    $user->fetchRecordSet($conn);

    if ($next = $user->getNextRecord()) { //Si se encontro el usuario en la base de datos
      //Informar al usuario que el nombre no esta disponible.
      echo "<h2>";
      if ($next->uLogin == $_POST['usernameReg']){
        echo 'El usuario que ingreso ya esta en uso. Por favor intente con uno nuevo.<br>';
      }
      if ($next->email == $_POST['email']){
        echo 'El email que ingreso ya esta en uso. Por favor intente con uno nuevo.<br>';
      }
      if ($next->dniTitular == $_POST['dniTitular']){
        echo 'El DNI que ingreso ya esta en uso. Por favor intente con uno nuevo.<br>';
      }
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
    <h2>Ingresa tus datos y preparate para un nuevo mundo de lectura!</h2><br>
    <br>
    <form method="POST" action="../navigation/nav.php">

      <label>Direcci&oacute;n de correo electronico:</label><br>
      <?= $_SESSION['email']?><br>
      <input type="hidden" name="email" value="<?= $_SESSION['email']?>"/>
      <label>Nombre de usuario:</label><br>
      <?= $_SESSION['usernameReg']?><br>
      <label>DNI de usuario:</label><br>
      <?= $_SESSION['dniTitular']?><br>
      <input type="hidden" name="usernameReg" value="<?= $_SESSION['usernameReg']?>"/>
      <input type="hidden" name="passwordReg" value="<?= $_SESSION['passwordReg']?>"/>
      <input id="number" name="dniTitular" type="hidden" value="<?= $_SESSION['dniTitular'] ?>" /><br>
      <br>
      <label>Nombre:</label><br>
      <input type="text" name="nombre" placeholder="Nombre..." required maxlength="24" value="<?= (isset($_SESSION['nombre'])?$_SESSION['nombre']:'') ?>"/><br>
      <label>Apellido:</label><br>
      <input type="text" name="apellido" placeholder="Apellido..." required maxlength="24" value="<?= (isset($_SESSION['apellido'])?$_SESSION['apellido']:'') ?>"/><br>
      <br>

      <label>Nro tarjeta credito:</label><br>
      <input type="text" name="nroTarjeta" placeholder="Nro de tarjeta..." pattern="[0-9]{16}" required minlength="16" maxlength="16" value="<?= (isset($_SESSION['nroTarjeta'])?$_SESSION['nroTarjeta']:'') ?>" title="El numero de tarjeta deben ser 16 digitos."/><br>

      <label>Fecha vencimiento:</label><br>
      <input type="text" name="vencimiento" placeholder="mm/aa" pattern="[0-9]{2}[/,-]{1}[0-9]{2}" minlength="5" required value="<?= (isset($_SESSION['vencimiento'])?$_SESSION['vencimiento']:'') ?>" title="Ingrese un vencimiento del formato mm/aa, EJ: 03/20"/><br>

      <label>Nombre del Titular de la tarjeta (Como figura en la tarjeta) :</label><br>
      <input type="text" name="nombreTitular" placeholder="Nombre del titular..." required maxlength="16" value="<?= (isset($_SESSION['nombreTitular'])?$_SESSION['nombreTitular']:'') ?>"/><br>



      <label>Cod Seguridad (Ultimos 3 digitos del reverso de la tarjeta):</label><br>
      <input id="number" name="codSeg" type="text" placeholder="Cod Seguridad..." pattern="[0-9]{3}"required maxlength="3" minlength="3" title="El codigo deben ser 3 digitos"><br>

      <label>Tipo suscripcion:</label><br>
      <select id="tipoSuscripcion" name="tipoSuscripcion">
          <option <?= ((isset($_SESSION['tipoSuscripcion']) and $_SESSION['tipoSuscripcion'] == 'suscriptor')?'selected ':'') ?> value="suscriptor">Sucripcion Comun (2 Perfiles)</option>
          <option <?= ((isset($_SESSION['tipoSuscripcion']) and $_SESSION['tipoSuscripcion'] == 'premium')?'selected ':'') ?>value="premium">Suscripcion Premium (4 Perfiles)</option>
      </select>
      <br>


      <button type="button" onclick="document.getElementById('volverForm').submit();">Volver atras</button></p>
      <input type="hidden" name="target_page" value="/pages/registro/registroCompleto.php"/>
      <a onclick="this.parentNode.submit();"><button>Continuar</button></a>
      <br>
    </form>
  </div>
</div>
