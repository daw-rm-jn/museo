<?php 
	class Pintor{
		private $idPintor;
		private $nombrePintor;
		private $bioPintor;
		private $fechaNacimiento;
		private $fechaMuerte;
		private $fotoPintor;

		public function Pintor($idPintor,$nombrePintor,$bioPintor,$fechaNacimiento,$fechaMuerte,$fotoPintor){
			$this->idPintor = $idPintor;
			$this->nombrePintor = $nombrePintor;
			$this->bioPintor = $bioPintor;
			$this->fechaNacimiento = $fechaNacimiento;
			$this->fechaMuerte = $fechaMuerte;
			$this->fotoPintor = $fotoPintor;
		}

		public function getidPintor()
		{
		    return $this->idPintor;
		}
		public function setidPintor($idPintor)
		{
		    $this->idPintor = $idPintor;
		    return $this;
		}

		public function getnombrePintor()
		{
		    return $this->nombrePintor;
		}
		public function setnombrePintor($nombrePintor)
		{
		    $this->nombrePintor = $nombrePintor;
		    return $this;
		}

		public function getbioPintor()
		{
		    return $this->bioPintor;
		}
		public function setbioPintor($bioPintor)
		{
		    $this->bioPintor = $bioPintor;
		    return $this;
		}
		
		public function getfechaNacimiento()
		{
		    return $this->fechaNacimiento;
		}
		public function setfechaNacimiento($fechaNacimiento)
		{
		    $this->fechaNacimiento = $fechaNacimiento;
		    return $this;
		}
		
		public function getfechaMuerte()
		{
		    return $this->fechaMuerte;
		}
		public function setfechaMuerte($fechaMuerte)
		{
		    $this->fechaMuerte = $fechaMuerte;
		    return $this;
		}
		
		public function getfotoPintor()
		{
		    return $this->fotoPintor;
		}
		public function setfotoPintor($fotoPintor)
		{
		    $this->fotoPintor = $fotoPintor;
		    return $this;
		}
		
		
	}
?>