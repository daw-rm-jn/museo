<?php 
	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';

	class Model_Museo{
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

		static function borrarExposiciones($idExposiciones){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idExposiciones); $i++) { 
				$stmt = $con->prepare("DELETE FROM Exposicion WHERE idExposicion = :id");
				$stmt->bindParam(':id', $idExposiciones[$i]);
				$stmt->execute();

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$act = array(
						'titulo' => 'BAJA [EXPOSICION]',
						'descripcion' => 'Se ha borrado el registro Exposicion con id '. $idExposiciones[$i] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
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
				$lastId = $con->lastInsertId();
					$act = array(
						'titulo' => 'ALTA [EXPOSICION]',
						'descripcion' => 'Se ha insertado el registro Exposicion con id ' . $lastId . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
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
				$act = array(
						'titulo' => 'MODIFICACION [EXPOSICION]',
						'descripcion' => 'Se ha modificado el registro Exposicion con id ' . $descriptor['id'] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
				return true;
			}else{
				return false;
			}

			$con = null;

		}

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
					$act = array(
						'titulo' => 'BAJA [PLANTA_MUSEO]',
						'descripcion' => 'Se ha borrado el registro Planta_Museo con id '. $idPlantas[$i] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
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
				$lastId = $con->lastInsertId();
					$act = array(
						'titulo' => 'ALTA [PLANTA_MUSEO]',
						'descripcion' => 'Se ha insertado el registro Planta_Museo con id ' . $lastId . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
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
				$act = array(
						'titulo' => 'MODIFICACION [PLANTA_MUSEO]',
						'descripcion' => 'Se ha modificado el registro Planta_Museo con id ' . $planta['idPlanta'] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
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

		static function getSalas(){
			$salas = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Sala_Museo ORDER BY idSala ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$sala = new Sala_Museo($row['idSala'],$row['idPlanta'],$row['nombreSala'],$row['descripcionSala']);
				$salas[] = $sala;
		    }
		    return $salas;
			$con = null;
		}

		static function borrarSalas($idSalas){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idSalas); $i++) { 
				$stmt = $con->prepare("DELETE FROM Sala_Museo WHERE idSala = :id");
				$stmt->bindParam(':id', $idSalas[$i]);
				$stmt->execute();
				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$act = array(
						'titulo' => 'BAJA [SALA_MUSEO]',
						'descripcion' => 'Se ha borrado el registro Sala_Museo con id '. $idSalas[$i] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
					return true;
				}else{
					return false;
				}

			}
			$con = null;
		}

		static function addSala($sala, $descriptor){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("INSERT INTO Sala_Museo (idPlanta,nombreSala,descripcionSala) VALUES (:idp,:nomsala,:descs)");

			$stmt->bindParam(':nomsala', $sala['nombreSala']);
			$stmt->bindParam(':idp', $descriptor['planta']);
			$stmt->bindParam(':descs', $descriptor['descripcion']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$lastId = $con->lastInsertId();
					$act = array(
						'titulo' => 'ALTA [SALA_MUSEO]',
						'descripcion' => 'Se ha insertado el registro Sala_Museo con id ' . $lastId . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function getSalaPorId($idSala){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Sala_Museo WHERE idSala = :idSala");

		    $stmt->bindParam(':idSala', $idSala);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$sala = new Sala_Museo($row['idSala'],$row['idPlanta'],$row['nombreSala'],$row['descripcionSala']);
			
		    return $sala;
			$con = null;
		}

		static function modificaSala($sala, $descriptor){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Sala_Museo SET idPlanta = :idp, nombreSala = :nomsala, descripcionSala = :descs WHERE idSala = :idSala");
			
			$stmt->bindParam(':nomsala', $sala['nombreSala']);
			$stmt->bindParam(':idSala', $sala['idSala']);
			$stmt->bindParam(':idp', $descriptor['planta']);
			$stmt->bindParam(':descs', $descriptor['descripcion']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$act = array(
						'titulo' => 'MODIFICACION [SALA_MUSEO]',
						'descripcion' => 'Se ha modificado el registro Sala_Museo con id ' . $sala['idSala'] . '.',
						'user' => $_SESSION['admin']
					);
					Modelo::insertUpdate($act);
				return true;
			}else{
				return false;
			}

			$con = null;
		}
	}
 ?>