<?php 
	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';

	class Model_Pintores{

		static function getPintores(){
			$pintores = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Pintor ORDER BY idPintor ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$pintor = new Pintor($row['idPintor'],$row['nombrePintor'],$row['bioPintor'],$row['fechaNacimiento'],$row['fechaMuerte'],$row['fotoPintor']);
				$pintores[] = $pintor;
		    }
		    return $pintores;
			$con = null;
		}

		static function getPintorPorId($idPintor){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Pintor WHERE idPintor = :idPintor");

		    $stmt->bindParam(':idPintor', $idPintor);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$pintor = new Pintor($row['idPintor'],$row['nombrePintor'],$row['bioPintor'],$row['fechaNacimiento'],$row['fechaMuerte'],$row['fotoPintor']);
			
		    return $pintor;
			$con = null;
		}

		static function modificaPintor($pintor, $descriptor){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Pintor SET nombrePintor = :nombrep,  bioPintor = :biop, fechaNacimiento = :fechan, fechaMuerte = :fecham, fotoPintor = :fotop WHERE idPintor = :idp");
			
			$stmt->bindParam(':idp', $pintor['idPintor']);
			$stmt->bindParam(':nombrep', $pintor['nombrePintor']);
			$stmt->bindParam(':biop', $descriptor['bio']);
			$stmt->bindParam(':fechan', $pintor['fechaNacimiento']);
			$stmt->bindParam(':fecham', $pintor['fechaMuerte']);
			$stmt->bindParam(':fotop', $descriptor['foto']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'MODIFICACIÓN [PINTOR]',
					'sec' => 'Pintor',
					'id' => $pintor['idPintor'],
					'estado' => 'actualizado'
				);
				Model_Misc::insertUpdate($descriptor);
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function borrarPintores($idPintores){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idPintores); $i++) { 
				$stmt = $con->prepare("DELETE FROM Pintor WHERE idPintor = :id");
				$stmt->bindParam(':id', $idPintores[$i]);
				$stmt->execute();

				$pintorABorrar = Modelo::getPintorPorId($idPintores[$i]);
				$nombrePintor = $pintorABorrar->getnombrePintor();

				//Modelo::borraDirectorio(__DIR__.'/../../img/pintores/'. $nombrePintor);

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					$descriptor = array(
						'op' => 'BAJA [PINTOR]',
						'sec' => 'Pintor',
						'id' => $idPintores[$i],
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

		static function addPintor($pintor, $descriptor){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("INSERT INTO Pintor (nombrePintor,bioPintor,fechaNacimiento,fechaMuerte,fotoPintor) VALUES (:nomp,:biop,:fechn,:fechm,:fotop)");

			$stmt->bindParam(':nomp', $pintor['nombrePintor']);
			$stmt->bindParam(':biop', $descriptor['bio']);
			$stmt->bindParam(':fechn', $pintor['fechaNacimiento']);
			$stmt->bindParam(':fechm', $pintor['fechaMuerte']);
			$stmt->bindParam(':fotop', $descriptor['foto']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				$descriptor = array(
					'op' => 'ALTA [PINTOR]',
					'sec' => 'Pintor',
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

		static function getIdPintor($nombre){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT idPintor FROM Pintor WHERE nombrePintor = :nombrePintor");

		    $stmt->bindParam(':nombrePintor', $nombre);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$id = $row['idPintor'];
			
		    return $id;
			$con = null;
		}

	}
?>