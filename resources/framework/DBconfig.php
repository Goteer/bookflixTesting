<?php
$servername = "www.db4free.net";
$username = "joaquinchurria";
$password = "Jdownloader10";
$dbName = "bookflixtesting";
try {
   $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
   // set the PDO error mode to exception
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   //echo "<h1>Connected successfully</h1>";
   }
catch(PDOException $e)
   {
   die("<h1>Ha fallado la conexion al servidor: " . $e->getMessage().'</h1>');
   }
?>
