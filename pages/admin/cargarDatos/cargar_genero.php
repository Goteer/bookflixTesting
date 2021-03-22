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

<body>

  <!-- $autor->setValues($_POST['nombre'],$_POST['apellido'],$_POST['foto'],$_POST['bio'],) -->

<div align="center" width="100%">
<div class="cuadro-listado">
	<form method="post" action="../../pages/navigation/nav.php">
		<table>
			<tr>
				<td>Genero</td>
			<td><input type="text" name="genero" pattern="[a-zA-Z\x20]+" maxlength="32" required title="Solo letras y espacios"></td>
			</tr>
			<tr>
				<td>Descripci&oacute;n (Opcional)</td>
				<td><textarea rows="10" cols="30" name="descripcion"></textarea></td>
			</tr>
      <tr>
				<td>&nbsp;</td>
				<td><input type="hidden" name="target_page" value="/pages/admin/cargarDatos/class/carga_genero.php"/>
        <a onclick="this.parentNode.submit();"><button>Ingresar genero</button></a></td>
			</tr>
		</table>
	</form>
</div>
</div>


</body>
</html>