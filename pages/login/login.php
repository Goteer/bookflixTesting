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

input[type=submit] {
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

div {
  border-radius: 5px;
  padding: 20px;
}

label {
	font-size:14px;
	font-weight: bold;
}
</style>

<div align="center">
<h1>Ingresar al sitio</h1>
<div>
<form>
  <label>Usuario:</label><br><input type="text" required placeholder="nombre de usuario..."></input><br>
  <label>Contrase&ntilde;a:</label><br><input type="text" disabled placeholder="contrase&ntilde;a inhabilitada WIP"></input><br>
  <input type="submit" formmethod="post" formaction="pages/navigation/nav.php" value="Ingresar"></button>
</form>
</div>
