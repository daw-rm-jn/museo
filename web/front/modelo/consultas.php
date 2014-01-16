<?php 

	namespace consultas;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;

	class Consultas{

		
                public function getPintores(){
                    $con = Modelo::abrirConexion();
			$rol;
			$query = "SELECT * FROM pintores";
			$res = $con->query($query);
			
			mysql_close($con);
                }
                public function getPintorNombre($nombre){
                    $con = Modelo::abrirConexion();
			$rol;
			$query = "SELECT * FROM pintores where nombrePintor='$nombre'";
			$res = $con->query($query);
			
			mysql_close($con);
                }
                 public function getCuadros(){
                    $con = Modelo::abrirConexion();
			$rol;
			$query = "SELECT * FROM cuadros";
			$res = $con->query($query);
			
			mysql_close($con);
                }
                public function getCuadrosNombre($nombre){
                    $con = Modelo::abrirConexion();
			$rol;
			$query = "SELECT * FROM cuadros where nombreCuadro='$nombre'";
			$res = $con->query($query);
			
			mysql_close($con);
                }


		
	}
?>

