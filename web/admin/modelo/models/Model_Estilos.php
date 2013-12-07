<?php 

	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';

	class Model_Estilos{

		static function getEstilos(){
			$estilos = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Estilo ORDER BY idEstilo ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$estilo = new Estilo($row['idEstilo'],$row['nombreEstilo'],$row['descripcionEstilo']);
				$estilos[] = $estilo;
		    }
		    return $estilos;
			$con = null;
		}

		static function getEstiloPorId($idEstilo){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Estilo WHERE idEstilo = :idEstilo");

		    $stmt->bindParam(':idEstilo', $idEstilo);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$estilo = new Estilo($row['idEstilo'],$row['nombreEstilo'],$row['descripcionEstilo']);
			
		    return $estilo;
			$con = null;
		}

		static function modificaEstilo($estilo, $desc){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Estilo SET nombreEstilo = :nomestilo,  descripcionEstilo = :descestilo WHERE idEstilo = :ide");
			
			$stmt->bindParam(':ide', $estilo['idEstilo']);
			$stmt->bindParam(':nomestilo', $estilo['nombreEstilo']);
			$stmt->bindParam(':descestilo', $desc);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'MODIFICACIÓN [ESTILO]',
					'sec' => 'Estilo',
					'id' => $estilo['idEstilo'],
					'estado' => 'actualizado'
				);
				Model_Misc::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

			$con = null;

		}

		static function borrarEstilos($idEstilos){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idEstilos); $i++) { 
				$stmt = $con->prepare("DELETE FROM Estilo WHERE idEstilo = :id");
				$stmt->bindParam(':id', $idEstilos[$i]);
				$stmt->execute();

				$estiloABorrar = Modelo::getEstiloPorId($idEstilos[$i]);
				$nombreEstilo = $estiloABorrar->getnombreEstilo();

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$descriptor = array(
						'op' => 'BAJA [ESTIL]',
						'sec' => 'Estilo',
						'id' => $idEstilos[$i],
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

		static function addEstilo($estilo, $desc){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("INSERT INTO Estilo (nombreEstilo,descripcionEstilo) VALUES (:nomestilo,:descestilo)");

			$stmt->bindParam(':nomestilo', $estilo['nombreEstilo']);
			$stmt->bindParam(':descestilo', $desc);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'ALTA [ESTILO]',
					'sec' => 'Estilo',
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
	}
?>