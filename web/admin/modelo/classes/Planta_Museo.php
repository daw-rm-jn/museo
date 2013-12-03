<?php 
	class Planta_museo{

		private $idPlanta;
		private $numeroPlanta;
		private $capacidad;

		public function Planta_Museo($idPlanta,$numeroPlanta,$capacidad){
			$this->idPlanta = $idPlanta;
			$this->numeroPlanta = $numeroPlanta;
			$this->capacidad = $capacidad;
		}

		public function getidPlanta()
		{
		    return $this->idPlanta;
		}
		public function setidPlanta($idPlanta)
		{
		    $this->idPlanta = $idPlanta;
		    return $this;
		}

		public function getnumeroPlanta()
		{
		    return $this->numeroPlanta;
		}
		public function setnumeroPlanta($numeroPlanta)
		{
		    $this->numeroPlanta = $numeroPlanta;
		    return $this;
		}

		public function getCapacidad()
		{
		    return $this->capacidad;
		}
		public function setCapacidad($capacidad)
		{
		    $this->capacidad = $capacidad;
		    return $this;
		}		
	}
?>