<?php 
	require 'ListaClases.php';

	class Modelo{
		static function conectar(){
			$host = 'localhost';
			$usuario = 'root';
			$clave = 'root';

			try {
			    $con = new PDO("mysql:host=$host;dbname=bd_Museo;charset=utf8", $usuario, $clave);
			    return $con;
			}catch(PDOException $e){
			    echo $e->getMessage();
			}
		}

		static function getProductos(){
			$productos = array();
			$con = Modelo::conectar();
			$stmt = $con->prepare("SELECT * FROM Copia_Cuadro ORDER BY fechaAlta ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$producto = new Copia_Cuadro($row['idCopia_Cuadro'],$row['nombreProducto'],$row['autor'],$row['estilo'],$row['orientacion'],$row['anioCuadro'],$row['fechaAlta'],$row['descripcion'],$row['precio'],$row['fotoCuadro']);
				$productos[] = $producto;
		    }
		    return $productos;
			$con = null;
		}
	}
?>