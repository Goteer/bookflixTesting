<?php

/*
Ejemplo de uso:

<?php
include_once "../../resources/framework/class/class.editorial.php";
$novedades = new EditorialDB();
?>
<table>
	<tr> <th>nombre:</th> <th>idEditorial:</th></tr>
<?php
	$novedades->fetchRecordSet($conn);
	while ($next = $novedades->getNextRecord()){
		echo "<tr> <td>{$next->nombre}</td> <td>{$next->idEditorial}</td></tr>";
	}
?>
</table>

*/

class EditorialInstance { //Clase "instancia" que contiene todas las propiedades de una fila de la tabla de mysql
  public $nombre;
  public $idEditorial;

  public function __construct() {
    $this->nombre = '';
    $this->idEditorial = 0;
    }

    public function setValues($nombre) {
      $this->nombre = $nombre;
      $this->idEditorial = 0;
      }

      public function getValues() {
        return array(
          'nombre'=>$this->nombre,
          'idEditorial'=>$this->idEditorial
        );
        }


}

class EditorialDB{ //Clase que conecta a mysql para obtener una lista de registros con el query adecuado
  private $result;
  public $current;
  private $filtro;
  private $campos;
  private $otros;


  public function __construct() {
    $this->result = null;
    $this->filtro = '';
    $this->campos = '*';
    $this->otros = '';
    $this->current = new EditorialInstance();
    }


  public function setFiltro($newFiltro){
    $this->filtro = "WHERE $newFiltro";
  }

  public function resetFiltro(){
    $this->filtro = "";
  }

  public function setCampos($newCampos){
    $this->campos = $newCampos;
  }
  public function getCampos(){
    return $this->campos;
  }
  public function getFiltro(){
    return $this->filtro;
  }

  public function setOtros($newOtros){
    $this->otros = $newOtros;
  }
  public function getOtros(){
    return $this->otros;
  }

  public function fetchRecordSet($conn = null) {
    try {
      $this->result = $conn->query("SELECT {$this->campos} FROM editoriales ". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new EditorialInstance();
      $current->nombre = $row['nombre'];
      $current->idEditorial = $row['idEditorial'];

      return $current;
    }else{
      return null;
    }
  }


  public function insert($conn = null) { //Insertar el objeto en la base de datos
    try {
      $this->result = $conn->query('
      INSERT INTO
          editoriales (
            nombre
          )
          VALUES (
            '.$conn->quote($this->current->nombre).'
          )' );
    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
      return false;
    }
    $conn = null;
    return true;
  }



  }

?>
