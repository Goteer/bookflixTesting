<?php

/*
Ejemplo de uso:

<table>
	<tr> <th>Id:</th> <th>uLogin:</th> <th>uPassword:</th> <th>uRole:</th> </tr>
<?php
	$userRecord->fetchRecordSet();
	while ($next = $userRecord->getNextRecord()){
		echo "<tr> <td>{$next->id}</td> <td>{$next->uLogin}</td> <td>{$next->uPassword}</td> <td>{$next->uRole}</td> </tr>";
	}
?>
</table>

*/

class LibroInstance { //Clase "instancia" que contiene todas las propiedades de una fila de la tabla de mysql
  public $nombre;
  public $descripcion;
  public $idAutor;
  public $idGenero;
  public $idEditorial;
  public $foto;
  public $isbn;
  public $idLibro;
  public $pathFile;
  public function __construct() {
    $nombre = '';
    $descripcion = '';
    $idAutor = 0;
    $idGenero = 0;
    $idEditorial = 0;
    $foto = '';
    $isbn = '';
    $idLibro = 0;
    $pathFile = '';
    }

}

class LibroDB{ //Clase que conecta a mysql para obtener una lista de registros con el query adecuado
  private $result;
  private $current;
  private $filtro;
  private $campos;
  private $otros;


  public function __construct() {
    $this->result = null;
    $this->filtro = '';
    $this->campos = '*';
    $this->otros = '';
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
      $this->result = $conn->query("SELECT {$this->campos} FROM libros ". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new LibroInstance();
      $current->nombre = $row['nombre'];
      $current->descripcion = $row['descripcion'];
      $current->idAutor = $row['idAutor'];
      $current->idGenero = $row['idGenero'];
      $current->idEditorial = $row['idEditorial'];
      $current->foto = $row['foto'];
      $current->isbn = $row['isbn'];
      $current->idLibro = $row['idLibro'];
      $current->pathFile = $row['pathFile'];
      return $current;
    }else{
      return null;
    }
  }




  }

?>
