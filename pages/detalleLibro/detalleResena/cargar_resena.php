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

$libroMarcadoPorCapitulos = $conn->query("SELECT porCapitulos from libros WHERE idLibro = ".$_POST['bookId']);
$libroMarcadoPorCapitulos = $libroMarcadoPorCapitulos->fetchColumn();



$libroTienePdf = $conn->query("SELECT * FROM libros WHERE idLibro = ".$_POST['bookId']." AND pathFile IS NOT NULL AND pathFile != '' AND pathfile != '/'");

$sinTerminar = $conn->query("SELECT COUNT(*) FROM librosterminados WHERE idLibro = '".$_POST['bookId']."' AND idUsuario = '".$_SESSION['id']."'");

$conReseña = $conn->query("SELECT COUNT(*) FROM resenas WHERE idLibro = '".$_POST['bookId']."' AND idPerfil = '".$_SESSION['profileId']."'");

$libroFinalizado = $conn->query("SELECT * FROM resenas WHERE idLibro = '".$_POST['bookId']."' AND idPerfil = '".$_SESSION['profileId']."'");

/*
if (!$libroMarcadoPorCapitulos && !$libroTienePdf->fetch()){
  echo '<h1>Error, este libro no esta finalizado</h1><br>
  <form method="post">
    <input type="hidden" name="target_page" value="/pages/admin/listarLibros/listarLibros.php"/>
    <a onclick="this.parentNode.submit();"><button>Volver a Libros</button></a>
  </form>
  ';
  die();
}

if ($sinTerminar->fetchColumn() == 0){

    echo "<p>Hay contenido de este libro sin leer o no esta marcado como leido. No pod&eacute;s rese&ntilde;ar un libro que no se haya marcado como leido.</p>
    <br><p>Volviendo al libro...</p>
    </h2>
    <script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>";
    die();
}*/

if ($conReseña->fetchColumn() != 0){

    echo "<p>Ya hay una rese&ntilde;a de este libro con este perfil. No pod&eacute;s rese&ntilde;ar un libro que ya hayas rese&ntilde;ado.</p>
    <br><p>Volviendo al libro...</p>
    </h2>
    <script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>";
    die();
  }

/*if ($libroFinalizado->fetchColumn() != null){

    echo "<p>Ya hay una rese&ntilde;a de este libro con este perfil. No pod&eacute;s rese&ntilde;ar un libro que ya hayas rese&ntilde;ado.</p>
    <br><p>Volviendo al libro...</p>
    </h2>
    <script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>";
    die();
    }
}
*/
//----------------------------------------------------------------------
  if (isset($_POST['spoiler'])) {
    $spoiler=1;
  } else{
    $spoiler=0;
  }



  if(true){
    $consultas = new ConsultasResena();
    $mensaje = $consultas->cargarResena($_POST['contenido'], $_POST['bookId'], $_POST['puntaje'], $spoiler, $_SESSION['profileId']);
    ?>
      <!DOCTYPE html>
        <html>
        <head>
          <title></title>
        </head>
        <body>
          <h1>Reseña creada satisfactoriamente. Redireccionando al listado de rese&ntilde;as...</h1>
          <form name="redirect" method="post" action="../navigation/nav.php">
            <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
            <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/listarResena.php"/>
          </form>



          <script type="text/javascript">
            setTimeout(function(){document.forms["redirect"].submit()},4000);
          </script>
        </body>
        </html>
<?php
  }
  else{
    echo "Falta completar campos obligatorios.";
  }
?>

    <h2><?= $mensaje ?></h2><br>
    <form method="post">
      <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/listarResena.php"/>
      <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
      <a onclick="this.parentNode.submit();"><button>Volver a rese&ntilde;as</button></a>
    </form>

  </div>
</div>
