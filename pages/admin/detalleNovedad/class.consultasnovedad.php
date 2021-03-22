<?php




	class ConsultasNovedad{
		public function cargarNovedad($contenido, $foto, $video, $descripcion, $titulo){
			include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			$tabla = "novedades";
			$sql = "INSERT INTO $tabla (contenido,foto,video,descripcion,titulo) values(:contenido, :foto, :video, :descripcion, :titulo)";
			$statement = $conn->prepare($sql);
			$statement->bindParam(':contenido',$contenido);
			$statement->bindParam(':foto',$foto);
			$statement->bindParam(':video',$video);
			$statement->bindParam(':descripcion',$descripcion);
			$statement->bindParam(':titulo',$titulo);
			if(!$statement){
				return "Error al cargar la novedad";
			}
			else {
				$statement->execute();
				return "Se cargo la novedad con exito";
			}


		}

		public function eliminarNovedad($id){
			include	 $_SERVER['DOCUMENT_ROOT']."/resources/framework/DBconfig.php";
			$tabla = "novedades";
			$sql = "DELETE FROM $tabla where idNovedad = $id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(':idNovedad',$id);
			if (!$statement){
				return "Erro al borrar el elemento con id: $id";
			}
			else{
				$statement->execute();
				return "Elemento con id $id eliminado satisfactoriamente";
			}


		}

		public function verNovedad($id){
			include "../../resources/framework/DBconfig.php";
			include_once "../../resources/framework/class/class.novedad.php";

			$filas = null;
			$tabla = "novedades";
			$sql = "SELECT * from $tabla where idNovedad = $id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(":idNovedad", $id);
			$statement->execute();
			while ($result = $statement->fetch()){
				$filas[] = $result;
			}
			return $filas;

		}

		public function modificarNovedad($campo, $valor, $id){
			include "../../resources/framework/DBconfig.php";
			include_once "../../resources/framework/class/class.novedad.php";

			$tabla = "novedades";
			$sql = "UPDATE $tabla set $campo = :valor where idNovedad = :id";
			$statement = $conn->prepare($sql);
			$statement->bindParam(":valor",$valor);
			$statement->bindParam(":id",$id);
			if(!$statement){
				return "Error al modificar el producto";
			}
			else {
				$statement->execute();
				return "Producto modificado correctamente";
			}
		}


	}

?>
