<?php 
	class Model_BD{
		static function conectar(){
			$host = 'localhost';
			$usuario = 'root';
			$clave = 'root';

			try {
			    $con = new PDO("mysql:host=$host;dbname=bd_Museo;charset=utf8", $usuario, $clave);
			    return $con;
			}
			catch(PDOException $e){
			    echo $e->getMessage();
			}
		}
	}
?>