<?php 
	require_once 'Model_Misc.php';
	require_once 'Model_BD.php';

	class Model_Tienda{
		static function getCarritos(){
			$carritos = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Carrito ORDER BY idCarrito ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$carrito = new Carrito($row['idCarrito'],$row['email'],$row['fechaCreacion'],$row['fechaExpir']);
				$carritos[] = $carrito;
		    }
		    return $carritos;
			$con = null;
		}

		static function addCarrito($carrito){
			$con = Model_BD::conectar();
			$insertcarrito = $con->prepare("INSERT INTO Carrito (email,fechaCreacion,fechaExpir) VALUES (:email,NOW(),NOW()+INTERVAL 10 DAY)");

			$insertcarrito->bindParam(':email', $carrito['email']);

			$insertcarrito->execute();
			$affected_rows = $insertcarrito->rowCount();

			if($affected_rows >= 0){
					return true;
			}else{
				return false;
			}
			$con = null;
		}

		static function borrarCarritos($idCarritos){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idCarritos); $i++) { 
				$stmt = $con->prepare("DELETE FROM Carrito WHERE idCarrito = :id");
				$borrarLineas = $con->prepare("DELETE FROM Linea_Carrito WHERE idCarrito = :id");
				
				$borrarLineas->bindParam(':id', $idCarritos[$i]);
				$stmt->bindParam(':id', $idCarritos[$i]);

				$borrarLineas->execute();
				$stmt->execute();

				$affected_rows_borrar = $borrarLineas->rowCount();
				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0 && $affected_rows_borrar > 0){
					return true;
				}else{
					return false;
				}

			}
			$con = null;
		}

		static function getCarritoPorId($idCarrito){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Carrito WHERE idCarrito = :idCarrito");

		    $stmt->bindParam(':idCarrito', $idCarrito);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$carrito = new Carrito($row['idCarrito'],$row['email'],$row['fechaCreacion'],$row['fechaExpir']);
			
		    return $carrito;
			$con = null;
		}

		static function modificaCarrito($carrito){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("UPDATE Carrito SET email = :email WHERE idCarrito = :idCarrito");
						
			$stmt->bindParam(':email', $carrito['email']);
			$stmt->bindParam(':idCarrito', $carrito['idCarrito']);

			$stmt->execute();
			$affected_rows = $stmt->rowCount();

			if($affected_rows >= 0){
				return true;
			}else{
				return false;
			}

			$con = null;
		}

		static function getLineasCarrito(){
			$lineas = array();
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Linea_Carrito ORDER BY idLinea_Carrito ASC");
		    $stmt->execute();
		    $result = $stmt->fetchAll();

		    foreach($result as $row){
				$linea = array(
					'idLinea_Carrito' => $row['idLinea_Carrito'],
					'idCarrito' => $row['idCarrito'],
					'idCopia_Cuadro' => $row['idCopia_Cuadro'],
					'nombreProducto' => $row['nombreProducto'],
					'unidades' => $row['unidades'],
					'precio' => $row['precio'],
					'IVA' => $row['IVA'],
					'totalLinea' => $row['totalLinea']
				);
				$lineas[] = $linea;
		    }
		    return $lineas;
			$con = null;
		}

		static function addLineaCarrito($carrito){
			$con = Model_BD::conectar();
			$insertlinea = $con->prepare("INSERT INTO Linea_Carrito VALUES (:idLinea,:idCarrito,:idCopia_Cuadro,:nombreProducto,:unidades,:precio,:IVA,:totalLinea)");

			$totalLinea =  ($carrito['precio'] + (($carrito['precio'] * $carrito['IVA'])/100)) * $carrito['unidades'];
			$lineasDelCarrito = Modelo::getLineasCarrito($carrito['idCarrito']);
			if(sizeof($lineasDelCarrito) > 0){
				$sigLinea = sizeof($lineasDelCarrito) + 1;
			}else{
				$sigLinea = 1;
			}			

			$insertlinea->bindParam(':idLinea',$sigLinea);
			$insertlinea->bindParam(':idCarrito',$carrito['idCarrito']);
			$insertlinea->bindParam(':idCopia_Cuadro',$carrito['idCopia_Cuadro']);
			$insertlinea->bindParam(':nombreProducto',$carrito['nombreProducto']);
			$insertlinea->bindParam(':unidades',$carrito['unidades']);
			$insertlinea->bindParam(':precio',$carrito['precio']);
			$insertlinea->bindParam(':IVA',$carrito['IVA']);
			$insertlinea->bindParam(':totalLinea',$totalLinea);

			$insertlinea->execute();
			$affected_rows = $insertlinea->rowCount();

			if($affected_rows >= 0){
				return true;
			}else{
				return false;
			}
			$con = null;
		}

		static function borrarLineasCarrito($idLineas, $idCarrito){
			$con = Model_BD::conectar();
			for ($i=0; $i < sizeof($idLineas); $i++) { 
				$stmt = $con->prepare("DELETE FROM Linea_Carrito WHERE idLinea_Carrito = :idLinea AND idCarrito = :idCarrito");

				$stmt->bindParam(':idLinea', $idLineas[$i]);
				$stmt->bindParam(':idCarrito', $idCarrito);
				$stmt->execute();

				$affected_rows = $stmt->rowCount();

				if($affected_rows > 0){
					return true;
				}else{
					return false;
				}

			}
			$con = null;
		}

		static function getLineaCarritoPorId($idCarrito, $idLinea){
			$con = Model_BD::conectar();
			$stmt = $con->prepare("SELECT * FROM Linea_Carrito WHERE idLinea_Carrito = :idLinea AND idCarrito = :idCarrito");

		    $stmt->bindParam(':idLinea', $idLinea);
		    $stmt->bindParam(':idCarrito', $idCarrito);

		    $stmt->execute();
		    $row = $stmt->fetch();

			$linea = array(
					'idLinea_Carrito' => $row['idLinea_Carrito'],
					'idCarrito' => $row['idCarrito'],
					'idCopia_Cuadro' => $row['idCopia_Cuadro'],
					'nombreProducto' => $row['nombreProducto'],
					'unidades' => $row['unidades'],
					'precio' => $row['precio'],
					'IVA' => $row['IVA'],
					'totalLinea' => $row['totalLinea']
				);
		    return $linea;
			$con = null;
		}

		static function modificaLineaCarrito($linea){
			$con = Model_BD::conectar();
			$updatelinea = $con->prepare("UPDATE Linea_Carrito SET idCopia_Cuadro = :idCopia_Cuadro,nombreProducto = :nombreProducto,unidades = :unidades,precio = :precio,IVA = :IVA,totalLinea = :totalLinea WHERE idLinea_Carrito = :idLinea AND idCarrito = :idCarrito");

			$totalLinea =  ($linea['precio'] + (($linea['precio'] * $linea['IVA'])/100)) * $linea['unidades'];		

			$updatelinea->bindParam(':idLinea',$linea['idLinea_Carrito']);
			$updatelinea->bindParam(':idCarrito',$linea['idCarrito']);
			$updatelinea->bindParam(':idCopia_Cuadro',$linea['idCopia_Cuadro']);
			$updatelinea->bindParam(':nombreProducto',$linea['nombreProducto']);
			$updatelinea->bindParam(':unidades',$linea['unidades']);
			$updatelinea->bindParam(':precio',$linea['precio']);
			$updatelinea->bindParam(':IVA',$linea['IVA']);
			$updatelinea->bindParam(':totalLinea',$totalLinea);

			$updatelinea->execute();
			$affected_rows = $updatelinea->rowCount();

			if($affected_rows >= 0){
				return true;
			}else{
				return false;
			}
			$con = null;
		}
	}
?>