<form method="post" name="volverForm" action="../navigation/nav.php">
  <input type="hidden" name="bookID" value="<?=$_POST['bookID']?>"/>
  <input type="hidden" name="target_page" value="<?=(isset($_POST['retorno']) && $_POST['retorno'] != '')?$_POST['retorno']:'/pages/detalleLibro/detalleLibro.php'?>"/>
</form>
<br>
<div align="center">
<h2>
<?php
$porCapitulos = (isset($_POST['porCapitulos'])?$_POST['porCapitulos']:0); //Valor por defecto por las dudas

$yaMarcadoQuery = $conn->query("SELECT * FROM favoritos WHERE idLibro = ".$_POST['bookID']." AND idUsuario = ".$_SESSION['id']." AND idPerfil = ".$_SESSION['profileId']);

if ($yaMarcadoQuery->fetch()){

  echo "<p>El libro ya esta marcado como favorito.</p>
  <br><p>Volviendo al libro...</p>
  </h2>
  <script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>";
  die();
}


$sinTerminar = $conn->query("SELECT COUNT(*) FROM librosterminados WHERE idLibro = '".$_POST['bookID']."' AND idUsuario = '".$_SESSION['id']."'");
if ($sinTerminar->fetchColumn() == 0){

    echo "<p>Hay contenido de este libro sin leer o no esta marcado como leido. No pod&eacute;s marcar como favorito un libro que no haya marcado como leido.</p>
    <br><p>Volviendo al libro...</p>
    </h2>
    <script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>";
    die();
}

//----------------------------------------------------------------------------------------------------------------------------


    if ($conn->query('INSERT INTO
            favoritos (
            idLibro,
            idUsuario,
            idPerfil )
            VALUES (
              '.$conn->quote($_POST['bookID']).',
              '.$conn->quote($_SESSION['id']).',
              '.$conn->quote($_SESSION['profileId']).'
            );' )
            )
      {

        echo "El libro ha sido marcado como favorito. Nos alegra que lo haya disfrutado.";
      }else{
        echo "Error al marcar el libro como favorito. Intente nuevamente.";
      }


?>
<br>

<p>Volviendo...</p>
</h2>

<script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>

</div>
