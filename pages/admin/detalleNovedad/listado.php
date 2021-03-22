<!DOCTYPE html>
<html>
<head>
  <title>Listado de novedades</title>
  <link rel="stylesheet" type="text/css" href="../../../resources/libs/jquery.dataTables.min.css">
  <script src= "../../../resources/libs/jquery-1.7.1.min.js" ></script>
  <script src= "../../../resources/libs/jquery.dataTables.min.js" ></script>

  <script>
    $(document).ready( function () {
        $('#novedades').DataTable();
    } );

  </script>

</head>
<body>
  <table id="novedades" class="display">
    <thead>
      <tr> 
        <th>Id:</th>
        <th>titulo:</th>
        <th>descripcion:</th>
        <th>foto:</th>
        <th>video:</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php
        require_once "listar_novedad.php";
      ?>

    </tbody>
  </table>



<div id="mostrar_mensaje"></div>


<script>
	function eliminar()
    { 
      var parametros = 
      {
        "id": document.activeElement.value
      };

      $.ajax({
        data: parametros,
        url: 'prueba.php',
        type: 'POST',
        
        beforesend: function()
        {
          $('#mostrar_mensaje').html("Mensaje antes de Enviar");
        },

        success: function(mensaje)
        {
          $('#mostrar_mensaje').html(mensaje);
        }
      });
    }


</script>
</body>
</html>