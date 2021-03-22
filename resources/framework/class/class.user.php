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

class UserInstance {
  public $id;
  public $uLogin;
  public $uPassword;
  public $uRole;

  public function __construct() {
    $id = 0;
    $uLogin = '';
    $uPassword = '';
    $uRole = '';
    }

}

class UserDB{
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

    public function getFiltro(){
      return $this->filtro;
    }
    public function getCampos(){
      return $this->campos;
    }

    public function setOtros($newOtros){
      $this->otros = $newOtros;
    }
    public function getOtros(){
      return $this->otros;
    }

  public function fetchRecordSet($conn) {
    try {
      $this->result = $conn->query("SELECT {$this->campos} FROM users". $this->filtro . " " . $this->otros);

    }
    catch(PDOException $e) {
      echo "<h1>Error:</h1> " . $e->getMessage();
    }
    $conn = null;
  }


  public function getNextRecord() {
    if ($row = $this->result->fetch()) {
      $current = new UserInstance();
      $current->id = $row['id'];
      $current->uLogin = $row['uLogin'];
      $current->uPassword = $row['uPassword'];
      $current->uRole = $row['uRole'];
      return $current;
    }else{
      return null;
    }
  }




  }

?>
