<?php




	class ConsultasResena{
		public function cargarResena($contenido, $idLibro, $puntaje, $spoiler, $idPerfil){
			//include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			$tabla = "resenas";
			$sql = "INSERT INTO $tabla (contenido,idLibro,puntaje,spoiler, idPerfil) values(:contenido, :idLibro, :puntaje, :spoiler, :idPerfil)";
			$statement = $conn->prepare($sql);
			$statement->bindParam(':contenido',$contenido);
			$statement->bindParam(':idLibro',$idLibro);
			$statement->bindParam(':puntaje',$puntaje);
			$statement->bindParam(':spoiler',$spoiler);
			$statement->bindParam(':idPerfil',$idPerfil);
			if(!$statement){
				return "Error al cargar la rese&ntilde;a";
			}
			else {
				$statement->execute();
				return "Se cargo la rese&ntilde;a con exito";
			}


		}

		public function eliminarResena($id){
			include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			//include	 "C:/wamp64/www/bookflix/resources/framework/DBconfig.php";
			$tabla = "resenas";
			$sql = "DELETE FROM $tabla where idResena = $id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(':idResena',$id);
			if (!$statement){
				return "Error al borrar la rese&ntilde;a con id: $id";
			}
			else{
				$statement->execute();
				return "Rese&ntilde;a con id $id eliminada satisfactoriamente";
			}


		}

		public function modificarResena($campo, $valor, $id){
			include "../../resources/framework/DBconfig.php";
			include_once "../../resources/framework/class/class.novedad.php";
			//include	 "C:/wamp64/www/bookflix/resources/framework/DBconfig.php";
			//include_once "C:/wamp64/www/bookflix/resources/framework/class/class.novedad.php";

			$tabla = "resenas";
			$sql = "UPDATE $tabla set $campo = :valor where idResena = :id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(":valor",$valor);
			$statement->bindParam(":id",$id);
			if(!$statement){
				return "Error al modificar la rese&ntilde;a";
			}
			else {
				$statement->execute();
				return "Rese&ntilde;a modificada correctamente";
			}
		}


	}

?>
