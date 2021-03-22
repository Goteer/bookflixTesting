

<style>

input[type=text], select {

  width: 100%;
	max-width:800px;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=email], select {

  width: 100%;
	max-width:800px;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=password], select {

  width: 100%;
  max-width:800px;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit], button {
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

input[type=submit]:hover {
  background-color: #444444;
}

input, select, textarea{
    color: #000000;
}

</style>


<br>
<div align="center" style:"width:100%">
  <div id="content-box" style="width:90vw; max-width:1000px; border-radius: 5px; padding-left:1vw" align="left">
    <br>
    <h2>Ingresa tus datos y preparate para un nuevo mundo de lectura!</h2><br>
    <br>
    <form method="post" action="../navigation/nav.php">



      <label>Direcci&oacute;n de correo electronico:</label><br>
      <input type="email" name="email" placeholder="Direccion de correo electr&oacute;nico..." required maxlength="128" value="<?= (isset($_SESSION['email'])?$_SESSION['email']:'') ?>"/><br>

      <label>Nombre de usuario:</label><br>
      <input type="text" name="usernameReg" placeholder="Nombre de usuario..." required maxlength="16" value="<?= (isset($_SESSION['usernameReg'])?$_SESSION['usernameReg']:'') ?>"/><br>

      <label>DNI:</label><br>
      <input id="dniTitular" name="dniTitular" type="text" placeholder="Dni del titular..." required pattern="[0-9]{8}" maxlength="8" value="<?= (isset($_SESSION['dniTitular'])?$_SESSION['dniTitular']:'') ?>" title="Ingrese un documento numerico de 8 digitos"><br>

      <fieldset>

        <input type="password" placeholder="Contrase&ntilde;a" id="password_fake" pattern="^\S{6,}$" name="password_fake" required><br>
        <input type="password" placeholder="Confirmar contrase&ntilde;a" id="password_two" pattern="^\S{6,}$" name="passwordReg" required><br>

      </fieldset><br>

      <input type="hidden" name="target_page" value="/pages/registro/ingresarDatosTarjeta.php"/>
      <a onclick="this.parentNode.submit();"><button class="pure-button pure-button-primary">Enviar datos</button></a>
      <br>
    </form>
  </div>
</div>

<script>
var password = document.getElementById("password_fake")
  , confirm_password = document.getElementById("password_two");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Las contraseñas no coinciden.");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
