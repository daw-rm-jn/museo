<?php 

	class Estilo{
		private $idEstilo;
		private $nombreEstilo;
		private $descripcionEstilo;

		public function Estilo($idEstilo,$nombreEstilo,$descripcionEstilo){
			$this->idEstilo = $idEstilo;
			$this->nombreEstilo = $nombreEstilo;
			$this->descripcionEstilo = $descripcionEstilo;
		}

		public function getidEstilo()
		{
		    return $this->idEstilo;
		}
		public function setidEstilo($idEstilo)
		{
		    $this->idEstilo = $idEstilo;
		    return $this;
		}

		public function getnombreEstilo()
		{
		    return $this->nombreEstilo;
		}
		public function setnombreEstilo($nombreEstilo)
		{
		    $this->nombreEstilo = $nombreEstilo;
		    return $this;
		}
		
		public function getdescripcionEstilo()
		{
		    return $this->descripcionEstilo;
		}
		public function setdescripcionEstilo($descripcionEstilo)
		{
		    $this->descripcionEstilo = $descripcionEstilo;
		    return $this;
		}
		
		
	}
?>