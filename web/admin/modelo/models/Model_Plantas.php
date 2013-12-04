<?php 
	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';

	class Model_Plantas{
		static function getPlantas(){
			$plantas = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Planta_Museo ORDER BY idPlanta ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$planta = new Planta_Museo($row['idPlanta'],$row['numeroPlanta'],$row['capacidad']);
				$plantas[] = $planta;
		    }
		    return $plantas;
			$con = null;
		}

		static function borrarPlantas($idPlantas){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idPlantas); $i++) { 
				$stmt = $con->prepare("DELETE FROM Planta_Museo WHERE idPlanta = :id");
				$stmt->bindParam(':id', $idPlantas[$i]);
				$stmt->execute();
				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$descriptor = array(
						'op' => 'BAJA [PLANTA]',
						'sec' => 'Planta',
						'id' => $idPlantas[$i],
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

		static function addPlanta($planta){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("INSERT INTO Planta_Museo (numeroPlanta,capacidad) VALUES (:nump,:capp)");

			$stmt->bindParam(':nump', $planta['numeroPlanta']);
			$stmt->bindParam(':capp', $planta['capacidad']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'ALTA [PLANTA]',
					'sec' => 'Planta',
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

		static function modificaPlanta($planta){

			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Planta_Museo SET numeroPlanta = :nump, capacidad = :capp WHERE idPlanta = :idep");
			
			$stmt->bindParam(':nump', $planta['numeroPlanta']);
			$stmt->bindParam(':capp', $planta['capacidad']);
			$stmt->bindParam(':idep', $planta['idPlanta']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'MODIFICACIÓN [PLANTA]',
					'sec' => 'Planta',
					'id' => $planta['idPlanta'],
					'estado' => 'actualizado'
				);
				Model_Misc::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

			$con = null;

		}

		static function getPlantaPorId($idPlanta){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Planta_Museo WHERE idPlanta = :idPlanta");

		    $stmt->bindParam(':idPlanta', $idPlanta);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$planta = new Planta_Museo($row['idPlanta'],$row['numeroPlanta'],$row['capacidad']);
			
		    return $planta;
			$con = null;
		}
	}
?>