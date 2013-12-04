<?php 
	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';

	class Model_Salas{
		static function getSalas(){
			$salas = array();
			$con = Modelo_BD::conectar();
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
	}
?>