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
</style>

<br>
<div align="center">
<div style="background-image:linear-gradient(to bottom,#444, #222);"
<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.editorial.php');

  $editorial = new EditorialDB();
	$editorial->setFiltro("nombre = ".$conn->quote(strtolower($_POST['nombre'])));
  $editorial->fetchRecordSet($conn);

  if (!$editorial->getNextRecord()) {

    $editorial->current->setValues(strtolower($_POST['nombre']));
  	$values = $editorial->current->getValues();
  	if(
      ($values['nombre'] !== null) and (strtolower($_POST['nombre']) !== '')
    ){
  		if ($editorial->insert($conn)){
        $mensaje = "Editorial insertada con exito.";
      }else{
        $mensaje = "No se pudo insertar la editorial.";
      }
  	}
  	else{
  		$mensaje = "Complete todos los campos";
  	};

  }else{

    $mensaje = "La editorial ingresada ya existe. Ingrese una editorial nueva por favor.";
  }



	echo "<h2>".$mensaje."</h2><br>"; ?>
  <form method="post" action="../../pages/navigation/nav.php">
    <input type="hidden" name="target_page" value="/pages/admin/cargarDatos/cargar_editorial.php"/>
    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
  </form>

</div>
</div>
