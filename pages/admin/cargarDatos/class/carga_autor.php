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

	require_once($_SERVER['DOCUMENT_ROOT'].'/resources/framework/class/class.autor.php');

  $autor = new autorDB();
	$autor->current;
  $autor->current->setValues($_POST['nombre'],$_POST['apellido'],$_POST['bio']);
	$values = $autor->current->getValues();
	if(
    ($values['nombre'] !== null) and ($values['nombre'] !== '') and
    ($values['apellido'] !== null) and ($values['apellido'] !== '')
  ){
    $autor->resetFiltro();
    $autor->setFiltro('nombre = "'.$_POST['nombre'].'"');
    $autor->fetchRecordSet($conn);
    while ($record = $autor->getNextRecord()) {
      if (($record->nombre == $_POST['nombre']) && ($record->apellido == $_POST['apellido'])){
        echo '<h2>El nombre del autor "'.$_POST['nombre'].' '.$_POST['apellido']. '" ya existe. Elija otro por favor.</h2><br>';
        echo '<form method="post" action="../../pages/navigation/nav.php">
          <input type="hidden" name="target_page" value="/pages/admin/cargarDatos/cargar_autor.php"/>
          <a onclick="this.parentNode.submit();"><button>Volver</button></a>
          </form>';
          die();
        }

    }
		if ($autor->insert($conn)){
      $mensaje = "Autor insertado con exito.";
    }else{
      $mensaje = "No se pudo insertar el autor.";
    }
	}
	else{
		$mensaje = "Complete todos los campos";
	};

	echo "<h2>".$mensaje."</h2><br>"; ?>
  <form method="post" action="../../pages/navigation/nav.php">
    <input type="hidden" name="bookID" value="<?=$next->idLibro?>"/>
    <input type="hidden" name="target_page" value="/pages/admin/cargarDatos/cargar_autor.php"/>
    <a onclick="this.parentNode.submit();"><button>Volver</button></a>
  </form>

</div>
</div>
