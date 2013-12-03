<?php 
	class Sala_Museo{

		private $idSala;
		private $idPlanta;
		private $nombreSala;
		private $descripcionSala;

		public function Sala_Museo($idSala,$idPlanta,$nombreSala,$descripcionSala){
			$this->idSala = $idSala;
			$this->idPlanta = $idPlanta;
			$this->nombreSala = $nombreSala;
			$this->descripcionSala = $descripcionSala;
		}

		public function getidSala()
		{
		    return $this->idSala;
		}
		public function setidSala($idSala)
		{
		    $this->idSala = $idSala;
		    return $this;
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

		public function getnombreSala()
		{
		    return $this->nombreSala;
		}
		public function setnombreSala($nombreSala)
		{
		    $this->nombreSala = $nombreSala;
		    return $this;
		}

		public function getdescripcionSala()
		{
		    return $this->descripcionSala;
		}
		public function setdescripcionSala($descripcionSala)
		{
		    $this->descripcionSala = $descripcionSala;
		    return $this;
		}		
	}
?>