<?php

/*
Ejemplo de uso:

<?php
include_once "../../resources/framework/class/class.autor.php";
$autores = new AutorDB();
?>
<table>
	<tr> <th>nombre:</th> <th>apellido:</th><th>idAutor:</th> </tr>
<?php
	$autores->fetchRecordSet($conn);
	while ($next = $autores->getNextRecord()){
		echo "<tr> <td>{$next->nombre}</td> <td>{$next->apellido}</td> <td>{$next->idAutor}</td> </tr>";
	}
?>
</table>

*/

class AutorInstance { //Clase "instancia" que contiene todas las propiedades de una fila de la tabla de mysql
  public $nombre;
  public $apellido;
  public $bio;
  public $idAutor;

  public function __construct() {
    $this->nombre = '';
    $this->apellido = '';
    $this->bio = '';
    $this->idAutor = 0;
    }

    public function setValues($nombre,$apellido,$bio) {
      $this->nombre = $nombre;
      $this->apellido = $apellido;
      $this->bio = $bio;
      $this->idAutor = 0;
      }

      public function getValues() {
        return array(
          'idAutor'=>$this->idAutor,
          'bio'=>$this->bio,
          'nombre'=>$this->nombre,
          'apellido'=>$this->apellido
        );
        }


}

class AutorDB{ //Clase que conecta a mysql para obtener una lista de registros con el query adecuado
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
    $this->current = new autorInstance();
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
      $this->result = $conn->query("SELECT {$this->campos} FROM autores ". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new AutorInstance();
      $current->nombre = $row['nombre'];
      $current->apellido = $row['apellido'];
      $current->bio = $row['bio'];
      $current->idAutor = $row['idAutor'];

      return $current;
    }else{
      return null;
    }
  }


  public function insert($conn = null) { //Insertar el objeto en la base de datos
    try {
      $this->result = $conn->query('
      INSERT INTO
          autores (
            nombre,
            apellido,
            bio )
          VALUES (
            '.$conn->quote($this->current->nombre).',
            '.$conn->quote($this->current->apellido).',
            '.$conn->quote($this->current->bio).'
          );' );
    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
      return false;
    }
    return true;
  }



  }

?>
