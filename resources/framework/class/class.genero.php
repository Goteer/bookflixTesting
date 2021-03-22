<?php

/*
Ejemplo de uso:

<?php
include_once "../../resources/framework/class/class.genero.php";
$novedades = new GeneroDB();
?>
<table>
	<tr> <th>Id:</th> <th>genero:</th>  </tr>
<?php
	$novedades->fetchRecordSet($conn);
	while ($next = $novedades->getNextRecord()){
		echo "<tr> <td>{$next->idGenero}</td> <td>{$next->genero}</td> </tr>";
	}
?>
</table>

*/

class GeneroInstance { //Clase "instancia" que contiene todas las propiedades de una fila de la tabla de mysql
  public $idGenero;
  public $genero;
  public $descripcion;

  public function __construct() {
    $this->idGenero = 0;
    $this->genero = '';
    $this->descripcion = '';
    }

    public function setValues($genero,$descripcion) {
      $this->idGenero = 0;
      $this->genero = $genero;
      $this->descripcion = $descripcion;
      }

      public function getValues() {
        return array(
          'descripcion'=>$this->descripcion,
          'idGenero'=>$this->idGenero,
          'genero'=>$this->genero,
        );
        }


}

class GeneroDB{ //Clase que conecta a mysql para obtener una lista de registros con el query adecuado
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
    $this->current = new GeneroInstance();
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
      $this->result = $conn->query("SELECT {$this->campos} FROM generos ". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new GeneroInstance();
      $current->idGenero = $row['idGenero'];
      $current->genero = $row['genero'];
      $current->descripcion = $row['descripcion'];

      return $current;
    }else{
      return null;
    }
  }


  public function insert($conn = null) { //Insertar el objeto en la base de datos
    try {
      $this->result = $conn->query('
      INSERT INTO
          generos (
            genero,
            descripcion )
          VALUES (
            '.$conn->quote($this->current->genero).',
            '.$conn->quote($this->current->descripcion).'
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
