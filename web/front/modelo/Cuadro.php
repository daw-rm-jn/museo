<?php 

	class Cuadro{
		private $idCuadro;
		private $idPintor;
		private $idExposicion;
		private $idEstilo;
		private $nombreCuadro;
		private $descripcionCuadro;
		private $fotoCuadro;
                private $foto;

		public function Cuadro($idCuadro,$idPintor,$idExposicion,$idEstilo,$nombreCuadro,$descripcionCuadro,$fotoCuadro, $foto){
			$this->idCuadro = $idCuadro;
			$this->idPintor = $idPintor;
			$this->idExposicion = $idExposicion;
			$this->idEstilo = $idEstilo;
			$this->nombreCuadro = $nombreCuadro;
			$this->descripcionCuadro = $descripcionCuadro;
			$this->fotoCuadro = $fotoCuadro;
                        $this->foto = $foto;
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

		public function getfotoCuadro(){
			return $this->idCuadro;
		}

		public function setfotoCuadro($foto){
			$this->foto = $foto;
			return $this;
		}
                public function getfoto(){
			return $this->foto;
		}

		public function setfoto($foto){
			$this->foto = $foto;
			return $this;
		}
	}

?>