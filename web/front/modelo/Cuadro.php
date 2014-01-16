<?php 

	class Cuadro{
		private $idCuadro;
		private $idPintor;
		private $idExposicion;
		private $idEstilo;
		private $nombreCuadro;
		private $descripcionCuadro;
		private $orientacion;
		private $anioCuadro;
		private $fotoCuadro;

		public function Cuadro($idCuadro,$idPintor,$idExposicion,$idEstilo,$nombreCuadro,$descripcionCuadro,$orientacion,$anioCuadro,$fotoCuadro){
			$this->idCuadro = $idCuadro;
			$this->idPintor = $idPintor;
			$this->idExposicion = $idExposicion;
			$this->idEstilo = $idEstilo;
			$this->nombreCuadro = $nombreCuadro;
			$this->descripcionCuadro = $descripcionCuadro;
			$this->orientacion = $orientacion;
			$this->anioCuadro = $anioCuadro;
			$this->fotoCuadro = $fotoCuadro;
		}

		public function getidCuadro(){
			return $this->idCuadro;
		}

		public function setidCuadro($idCuadro){
			$this->idCuadro = $idCuadro;
			return $this;
		}

		public function getidPintor(){
			return $this->idPintor;
		}

		public function setidPintor($idPintor){
			$this->idPintor = $idPintor;
			return $this;
		}

		public function getidExposicion(){
			return $this->idCuadro;
		}

		public function setidExposicion($idExposicion){
			$this->idExposicion = $idExposicion;
			return $this;
		}

		public function getidEstilo(){
			return $this->idCuadro;
		}

		public function setidEstilo($idEstilo){
			$this->idEstilo = $idEstilo;
			return $this;
		}

		public function getnombreCuadro(){
			return $this->nombreCuadro;
		}

		public function setnombreCuadro($nombreCuadro){
			$this->nombreCuadro = $nombreCuadro;
			return $this;
		}

		public function getdescripcionCuadro(){
			return $this->descripcionCuadro;
		}

		public function setdescripcionCuadro($descripcionCuadro){
			$this->descripcionCuadro = $descripcionCuadro;
			return $this;
		}
		public function getorientacion()
		{
		    return $this->orientacion;
		}
		
		public function setorientacion($orientacion)
		{
		    $this->orientacion = $orientacion;
		    return $this;
		}

		public function getanioCuadro()
		{
		    return $this->anioCuadro;
		}
		
		public function setanioCuadro($anioCuadro)
		{
		    $this->anioCuadro = $anioCuadro;
		    return $this;
		}

		public function getfotoCuadro()
		{
		    return $this->fotoCuadro;
		}
		
		public function setfotoCuadro($fotoCuadro)
		{
		    $this->fotoCuadro = $fotoCuadro;
		    return $this;
		}
	}

?>