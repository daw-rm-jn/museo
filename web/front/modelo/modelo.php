<?php 

	require 'ListaModelos.php';

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;

	class Modelo{

		public static function abrirConexion(){
			$mysql_server = "localhost";
			$mysql_user = "root";
			$mysql_password = "";
			$mysql_db = "bd_Museo";
			$mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_db);
			if ($mysqli->connect_errno) {
				echo "Connection failed: \n" . $mysqli->connect_error;
				exit();
			}
			$mysqli->set_charset("utf8");
			return $mysqli;
		}
                public function existeUser($user){
                    $con = Modelo::abrirConexion();
			$rol;
			$query = "SELECT * FROM Usuario WHERE email = '$user'";
			$res = $con->query($query);
			if($res->num_rows>0){
                            return true;
                        }else{
                            return false;
                        }
			mysql_close($con);
                }
                public function passCorrecta($user, $pass){
                    $con = Modelo::abrirConexion();
			$rol;
			$query = "SELECT * FROM Usuario WHERE email = '$user' and clave='$pass";
			$res = $con->query($query);
			if($res->num_rows>0){
                            return true;
                        }else{
                            return false;
                        }
			mysql_close($con);
                }
                public static function getPintores(){
			$pintores = array();
			$con = Modelo::abrirConexion();
			$query = "SELECT * FROM Pintor ORDER BY nombrePintor ASC";
			$res = $con->query($query);

		    foreach($res as $row){
				$pintor = new Pintor($row['idPintor'],$row['nombrePintor'],$row['bioPintor'],$row['fechaNacimiento'],$row['fechaMuerte'],$row['fotoPintor']);
				$pintores[] = $pintor;
		    }
		    return $pintores;
			$con = null;
		}
                 public static function getCuadros(){
			$cuadros = array();
			$con = Modelo::abrirConexion();
			$query = "SELECT * FROM Cuadro ORDER BY nombreCuadro ASC";
			$res = $con->query($query);

		    foreach($res as $row){
				$cuadro = new Cuadro($row['idCuadro'],$row['idPintor'],$row['idExposicion'],$row['idEstilo'],$row['nombreCuadro'],$row['descripcionCuadro'],$row['fotoCuadro']);
				$cuadros[] = $cuadro;
		    }
		    return $cuadros;
			$con = null;
		}


		public function cerrarSesion(){
			session_destroy();
		}
	}
?>