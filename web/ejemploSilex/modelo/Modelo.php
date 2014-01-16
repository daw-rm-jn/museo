<?php 
	require 'ListaModelos.php';

	class Modelo{

		static function abrirConexion(){
			$mysql_server = "localhost";
			$mysql_user = "root";
			$mysql_password = "root";
			$mysql_db = "ejSilex";
			$mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_db);
			if ($mysqli->connect_errno) {
				echo "Connection failed: \n" . $mysqli->connect_error;
				exit();
			}
			$mysqli->set_charset("utf8");
			return $mysqli;
		}

		static function getListaPosts(){
			$listaPosts = array();
			$con = Modelo::abrirConexion();
			$query = "SELECT * FROM Post";
			$result = $con->query($query) or die($con->error.__LINE__);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$unPost = new Post($row['idPost'], $row['titulo'], $row['autor'], $row['cuerpo'], $row['fecha']);
					$listaPosts[] = $unPost;	
				}
			}else {
				return false;	
			}
			return $listaPosts;
			mysqli_close($con);
		}

		static function verPost($idPost){
			$post = null;
			$con = Modelo::abrirConexion();
			$query = "SELECT * FROM Post WHERE idPost = $idPost";
			$result = $con->query($query) or die($con->error.__LINE__);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$post = new Post($row['idPost'], $row['titulo'], $row['autor'], $row['cuerpo'], $row['fecha']);
				}
			}else {
				return false;	
			}
			return $post;
			mysql_close($con);
		}

		static function getUltimaId(){
			$uID = 0;
			$con = Modelo::abrirConexion();
			$query = "SELECT MAX(idPost) as id FROM Post";
			$result = $con->query($query) or die($con->error.__LINE__);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$uID = $row['id'];
				}
			}else {
				echo 'NO RESULTS';	
			}
			return $uID;
			mysql_close($con);
		}

		static function addPost($titulo, $autor, $cuerpo, $fecha){
			$ultimaId = Modelo::getUltimaId();
			$ultimaId = $ultimaId + 1;
			$con = Modelo::abrirConexion();
			$con->autocommit(FALSE);
			$stmt = $con->prepare("INSERT INTO Post (idPost, titulo, autor, cuerpo, fecha) VALUES ($ultimaId, '$titulo', '$autor', '$cuerpo', '$fecha')");
			if(!$stmt->execute()){
				$con->rollback();
				return false;
			}else{
				$con->commit();
				return true;
			}
			mysql_close($con);
		}
	}
 ?>