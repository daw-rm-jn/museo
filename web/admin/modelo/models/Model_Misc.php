<?php 
	require_once 'Model_BD.php';

	class Model_Misc{

		static function isAdmin($datos){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Administrador WHERE email = :usuario AND clave = :clave");

		    $stmt->bindParam(':usuario', $datos['usuario']);
		    $stmt->bindParam(':clave', $datos['clavecifrada']);

		    $stmt->execute();
		    $result = $stmt->fetch();
			$affected_rows = $stmt->rowCount();
		    
	        if($affected_rows > 0){
	        	return true;
	        }else{
	        	return false;
	        }
		    $con = null;
		}

		static function getUpdates(){
			$updates  = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Actualizacion ORDER BY idActualizacion DESC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$update = new Actualizacion($row['idActualizacion'],$row['tituloActualizacion'],$row['fechaActualizacion'],$row['descActualizacion'],$row['Usuario_email']);
				$updates[] = $update;
		    }
		    return $updates;
			$con = null;
		}

		static function insertUpdate($actualizacion){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("INSERT INTO Actualizacion (tituloActualizacion,fechaActualizacion,descActualizacion,Usuario_email) VALUES (:tit,NOW(),:desca,:user)");

			$stmt->bindParam(':tit',$actualizacion['titulo']);
			$stmt->bindParam(':desca',$actualizacion['descripcion']);
			$stmt->bindParam(':user',$actualizacion['user']);

		    $stmt->execute();

		    $con = null;
		}
	}
?>