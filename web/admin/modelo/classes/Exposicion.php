<?php 
	class Exposicion{
		private $idExposicion;
		private $idSala;
		private $nombreExposicion;
		private $fechaInicio;
		private $fechaFin;
		private $descripcionExpo;
		private $cartel;

		public function Exposicion($idExposicion,$idSala,$nombreExposicion,$fechaInicio,$fechaFin,$descripcionExpo,$cartel){
			$this->idExposicion = $idExposicion;
			$this->idSala = $idSala;
			$this->nombreExposicion = $nombreExposicion;
			$this->fechaInicio = $fechaInicio;
			$this->fechaFin = $fechaFin;
			$this->descripcionExpo = $descripcionExpo;
			$this->cartel = $cartel;
		}

		public function getidExposicion()
		{
		    return $this->idExposicion;
		}
		public function setidExposicion($idExposicion)
		{
		    $this->idExposicion = $idExposicion;
		    return $this;
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

		public function getnombreExposicion()
		{
		    return $this->nombreExposicion;
		}
		public function setnombreExposicion($nombreExposicion)
		{
		    $this->nombreExposicion = $nombreExposicion;
		    return $this;
		}

		public function getfechaInicio()
		{
		    return $this->fechaInicio;
		}
		public function setfechaInicio($fechaInicio)
		{
		    $this->fechaInicio = $fechaInicio;
		    return $this;
		}

		public function getfechaFin()
		{
		    return $this->fechaFin;
		}
		public function setfechaFin($fechaFin)
		{
		    $this->fechaFin = $fechaFin;
		    return $this;
		}

		public function getdescripcionExpo()
		{
		    return $this->descripcionExpo;
		}
		public function setdescripcionExpo($descripcionExpo)
		{
		    $this->descripcionExpo = $descripcionExpo;
		    return $this;
		}

		public function getcartel()
		{
		    return $this->cartel;
		}
		
		public function setcartel($cartel)
		{
		    $this->cartel = $cartel;
		    return $this;
		}		
	}
?>