<form method="post" name="volverForm" action="../navigation/nav.php">
  <input type="hidden" name="bookID" value="<?=$_POST['bookID']?>"/>
  <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleLibro.php"/>
</form>
<br>
<div align="center">
<h2>
<?php
$porCapitulos = (isset($_POST['porCapitulos'])?$_POST['porCapitulos']:0); //Valor por defecto por las dudas

$yaMarcadoQuery = $conn->query("SELECT * FROM librosterminados WHERE idLibro = ".$_POST['bookID']." AND idUsuario = ".$_SESSION['id']." AND idPerfil = ".$_SESSION['profileId']);

if ($yaMarcadoQuery->fetch()){

  echo "<p>El libro ya esta marcado como leido.</p>
  <br><p>Volviendo al libro...</p>
  </h2>
  <script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>";
  die();
}

if ($porCapitulos){
  $sinTerminar = $conn->query("SELECT MAX(esCapituloFinal) FROM capitulos WHERE idLibro = ".$_POST['bookID']);

  if ($sinTerminar->fetchColumn() == 0){

    echo "<p>El libro todavia no est&aacute; finalizado. No pod&eacute;s marcar como leido un libro que no termin&oacute;.</p>
    <br><p>Volviendo al libro...</p>
    </h2>
    <script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>";
    die();
  }
}


$conn->query("DROP TEMPORARY TABLE IF EXISTS results;
CREATE TEMPORARY TABLE results AS ( SELECT
historial.idLectura,
historial.idLibro,
historial.idUsuario,
historial.idPerfil,
libros.nombre,
libros.descripcion,
MAX(historial.fechaAct) AS fechaAct,
COUNT(DISTINCT historial.idLibro, historial.capitulo) AS capitulosLeidos,
IF(COUNT(DISTINCT capitulos.idLibro, capitulos.nroCapitulo)  >= 1, COUNT(DISTINCT capitulos.idLibro, capitulos.nroCapitulo), 1 ) AS cantCapitulosLibro,
(IF((COUNT(DISTINCT historial.idLibro, historial.capitulo)) < (IF(COUNT(DISTINCT capitulos.idLibro, capitulos.nroCapitulo)  >= 1, COUNT(DISTINCT capitulos.idLibro, capitulos.nroCapitulo), 1 )), 0, 1)) AS libroFinalizado

FROM historial
LEFT JOIN capitulos ON historial.idLibro = capitulos.idLibro
LEFT JOIN libros ON historial.idLibro = libros.idLibro

WHERE historial.idPerfil = ".$_SESSION['profileId']." AND historial.idUsuario = ".$_SESSION['id']." AND historial.idLibro = ".$_POST['bookID']."
GROUP BY historial.idLibro, CASE WHEN historial.capitulo > 0 THEN 1 ELSE 0 END
ORDER BY MAX(historial.fechaAct) DESC );");

$queryLibroTerminado = $conn->query("SELECT MAX(results.libroFinalizado) FROM results;"); //Es un max porque a veces hace varios grupos para el mismo libro
$libroTerminado = $queryLibroTerminado->fetchColumn();
//----------------------------------------------------------------------------------------------------------------------------


if ($libroTerminado == 1){

    if ($conn->query('INSERT INTO
            librosterminados (
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
        echo "El libro ha sido marcado como leido. Esperamos que lo haya disfrutado.";
      }else{
        echo "Error al marcar el libro como terminado. Intente nuevamente.";
      }

}else{
  echo ($porCapitulos)?'Hay capitulos de este libro sin leer.':'Hay contenido de este libro sin leer.';
}

?>
<br>
<p>Volviendo al libro...</p>
</h2>
<script>setTimeout(function(){document.forms['volverForm'].submit()},3000);</script>

</div>



<?php  //---------------------------------------------------------------------------------------------------------------------
$conn->query("DROP TEMPORARY TABLE results;");
?>
