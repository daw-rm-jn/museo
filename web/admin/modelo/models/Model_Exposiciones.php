<?php 
	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';

	class Model_Exposiciones{

		static function getExposiciones(){
			$exposiciones = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Exposicion ORDER BY idExposicion ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$exposicion = new Exposicion($row['idExposicion'],$row['idSala'],$row['nombreExposicion'],$row['fechaInicio'],$row['fechaFIn'],$row['descripcionExpo']);
				$exposiciones[] = $exposicion;
		    }
		    return $exposiciones;
			$con = null;
		}

		static function getIdExposicion($nombre){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT idExposicion FROM Exposicion WHERE nombreExposicion = :nombreExposicion");

		    $stmt->bindParam(':nombreExposicion', $nombre);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$id = $row['idExposicion'];
			
		    return $id;
			$con = null;
		}

		static function borrarExposiciones($idExposiciones){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idExposiciones); $i++) { 
				$stmt = $con->prepare("DELETE FROM Exposicion WHERE idExposicion = :id");
				$stmt->bindParam(':id', $idExposiciones[$i]);
				$stmt->execute();

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$descriptor = array(
						'op' => 'BAJA [EXPOSICION]',
						'sec' => 'Exposicion',
						'id' => $idExposiciones[$i],
						'estado' => 'eliminado'
					);
					Model_Misc::insertUpdate($descriptor);
					return true;
				}else{
					return false;
				}

			}
			$con = null;
		}

		static function getExposicionPorId($idExposicion){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Exposicion WHERE idExposicion = :idExposicion");

		    $stmt->bindParam(':idExposicion', $idExposicion);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$pintor = new Exposicion($row['idExposicion'],$row['idSala'],$row['nombreExposicion'],$row['fechaInicio'],$row['fechaFIn'],$row['descripcionExpo']);
			
		    return $pintor;
			$con = null;
		}

		static function addExposicion($exposicion, $descriptor){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("INSERT INTO Exposicion (idSala,nombreExposicion,fechaInicio,fechaFin,descripcionExpo) VALUES (:salaex,:nomex,:fechinex,:fechfinex,:descex)");

			$stmt->bindParam(':nomex', $exposicion['nombreExposicion']);
			$stmt->bindParam(':descex', $descriptor['descripcion']);
			$stmt->bindParam(':fechinex', $exposicion['fechaInicio']);
			$stmt->bindParam(':fechfinex', $exposicion['fechaFin']);
			$stmt->bindParam(':salaex', $descriptor['sala']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'ALTA [EXPOSICION]',
					'sec' => 'Exposicion',
					'id' => $con->lastInsertId(),
					'estado' => 'insertado'
				);
				Model_Misc::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function modificaExpo($expo, $descriptor){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Exposicion SET idSala = :salaex, nombreExposicion = :nomex, fechaInicio = :fechinex, fechaFIn = :fechfinex, descripcionExpo = :descex WHERE idExposicion = :idex");
			
			$stmt->bindParam(':nomex', $expo['nombreExposicion']);
			$stmt->bindParam(':descex', $descriptor['descripcion']);
			$stmt->bindParam(':salaex', $descriptor['sala']);
			$stmt->bindParam(':idex', $descriptor['id']);
			$stmt->bindParam(':fechinex', $expo['fechaInicio']);
			$stmt->bindParam(':fechfinex', $expo['fechaFin']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'MODIFICACIÓN [EXPOSICION]',
					'sec' => 'Exposicion',
					'id' => $descriptor['id'],
					'estado' => 'actualizado'
				);
				Model_Misc::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

			$con = null;

		}
	}

?>