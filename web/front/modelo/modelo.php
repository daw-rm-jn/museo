<?php 

	namespace modelo;
	//require 'ListaModelos.php';

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;

	class Modelo{

		public function abrirConexion(){
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
                public function getPintores(){
                    $con = Modelo::abrirConexion();
			$rol;
			$query = "SELECT * FROM pintores";
			$res = $con->query($query);
			
			mysql_close($con);
                }


		public function cerrarSesion(){
			session_destroy();
		}
	}
?>