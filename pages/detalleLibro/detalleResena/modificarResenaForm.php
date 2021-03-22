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


<?php
  $id = $_POST['bookId'];
  $libSql = "SELECT porCapitulos from libros where idLibro = $id";
  $statement = $conn->prepare($libSql);
  $statement->bindParam(':idLibro',$id);
  $statement->execute();
  $auxL = $statement->fetch();

  $perfil = $_SESSION['profileId'];
  $terSql = "SELECT idLibro from librosterminados where idLibro = $id and idPerfil = $perfil";
  $statement = $conn->prepare($terSql);
  $statement->bindParam(':idLibro',$id);
  $statement->bindParam(':idPerfil',$perfil);
  $statement->execute();
  $auxT = $statement->fetch();


  $auxSql = "SELECT esCapituloFinal from capitulos where idLibro = $id and esCapituloFinal = 1";
  $statement = $conn->prepare($auxSql);
  $statement->bindParam(':idLibro',$id);
  $statement->execute();
  $aux = $statement->fetch();


  


  if ($aux == null && $auxL["porCapitulos"] == 1){
    ?>
    <h2>No puedes modificar una reseña de un libro incompleto.</h2>
          <form method="post" name="volverForm" action="../navigation/nav.php">
            <input type="hidden" name="bookId" value="<?=$_POST["bookId"]?>"/>
            <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/listarResena.php"/>
          </form>
          <script>setTimeout(function(){document.forms["volverForm"].submit()},3000);</script>
    <?php
    
  }
  else if ($auxT == null){
    ?>
    <h2>No puedes modificar una reseña de un libro que no has terminado.</h2>
          <form method="post" name="volverForm" action="../navigation/nav.php">
            <input type="hidden" name="bookId" value="<?=$_POST["bookId"]?>"/>
            <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/listarResena.php"/>
          </form>
          <script>setTimeout(function(){document.forms["volverForm"].submit()},3000);</script>
    <?php   
  }
  else {

?>


<script type="text/javascript">

  function funcion(){
    document.getElementById('check').disabled=true;
  }

  function checkear(){
    if (document.getElementById('check').value == "yes"){
      document.getElementById('check').disabled=true;
    }
  }
  function desCheckear(){
    if (document.getElementById('check').value == "yes"){
      document.getElementById('check').disabled=false;
    }
  }

  window.onload=checkear;

</script>
<br>
<form style="margin-left:10px;" method="post" name="volverForm" action="../navigation/nav.php">
  <input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/>
  <input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/listarResena.php"/>
  <button>Volver al listado</button>
</form>
<br>
<div align="center">
  <div id="content-box" style="width:40vw">
<?php

    include "../../resources/framework/DBconfig.php";
    if (isset($_POST['idResena'])){
      $tabla = "resenas";
      $sql = "SELECT * from $tabla where idResena = :idResena";
      $statement = $conn->prepare($sql);
      $statement->bindParam(":idResena", $_POST['idResena']);
      $statement->execute();
      $next = $statement->fetch();
      //echo $next[3];
      //echo $next[5];


 ?>

          <form name="formulario" action="../navigation/nav.php" method = "post" onsubmit="return validateForm()">
            <table>
              <tr>
                <td>Contenido</td>
                <td><textarea style="color: #000000" rows="10" cols="30" name="contenido" required><?php
                    echo $next['contenido'];
                   ?></textarea></td>
              </tr>
              <tr>
              <td>Puntaje</td>
          <td><select id="puntaje" name="puntaje" required>

              <option selected value="<?=$next['puntaje']?>"> <?php echo $next['puntaje'] ?> </option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>              

              </select></td>
        </tr>
        <tr>
          <label>

          <input <?php if ($next['spoiler'] > 0){ echo "checked"; } ?> type="checkbox" id="check" value=<?php if ($next['spoiler'] == 2){ echo "'yes'";} else {echo "'asd'";}?> name="spoiler" >
          Spoiler <?php if ($next['spoiler'] == 2){ echo '| Marcada as&iacute; por un administrador. Si cre&eacute;s que esto es un error, informe con un adminstrador.'; } ?>

          </label>
        </tr>
        <tr>

        <td>&nbsp;</td>
        <td><input type="hidden" name="idResena" value="<?=$_POST['idResena']?>"/></td>
        <td><input type="hidden" name="bookId" value="<?=$_POST['bookId']?>"/></td>
        <td><input type="hidden" name="target_page" value="/pages/detalleLibro/detalleResena/modificarResena.php"/></td>
        <td><input type="hidden" name="nombrePerfil" value=""/> <!--Aca quiero poner el nombre de perfil, pero no estoy seguro como se hace -->
        <a onclick="desCheckear();this.parentNode.submit();"><button>Modificar rese&ntilde;a</button></a></td>
        </tr>
    </table>
  </form>


<?php

      }}

?>
</div>
</div>
