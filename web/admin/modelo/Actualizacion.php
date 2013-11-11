<?php 

	class Actualizacion{
		private $idActualizacion;
		private $tituloActualizacion;
		private $fechaActualizacion;
		private $descActualizacion;
		private $Usuario_email;

		function Actualizacion($idActualizacion,$tituloActualizacion,$fechaActualizacion,$descActualizacion,$Usuario_email){
			$this->idActualizacion = $idActualizacion;
			$this->tituloActualizacion = $tituloActualizacion;
			$this->fechaActualizacion = $fechaActualizacion;
			$this->descActualizacion = $descActualizacion;
			$this->Usuario_email = $Usuario_email;
		}

		public function getidActualizacion(){
			return $this->idActualizacion;
		}
		public function setidActualizacion($idActualizacion){
			$this->idActualizacion = $idActualizacion;
			return $this;
		}

		public function gettituloActualizacion(){
			return $this->tituloActualizacion;
		}
		public function settituloActualizacion($tituloActualizacion){
			$this->tituloActualizacion = $tituloActualizacion;
			return $this;
		}

		public function getfechaActualizacion(){
			return $this->fechaActualizacion;
		}
		public function setfechaActualizacion($fechaActualizacion){
			$this->fechaActualizacion = $fechaActualizacion;
			return $this;
		}

		public function getdescActualizacion(){
			return $this->descActualizacion;
		}
		public function setdescActualizacion($descActualizacion){
			$this->descActualizacion = $descActualizacion;
			return $this;
		}

		public function getUsuario_email(){
			return $this->Usuario_email;
		}
		public function setUsuario_email($Usuario_email){
			$this->Usuario_email = $Usuario_email;
			return $this;
		}
	}
?>