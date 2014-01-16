<?php 
	class Admin{
		private $email;
		private $clave;
		private $fechaAlta;

		public function Admin($email,$clave,$fechaAlta){
			$this->email = $email;
			$this->clave = $clave;
			$this->fechaAlta = $fechaAlta;
		}

		public function getemail()
		{
		    return $this->email;
		}
		public function setemail($email)
		{
		    $this->email = $email;
		    return $this;
		}

		public function getclave()
		{
		    return $this->clave;
		}
		public function setclave($clave)
		{
		    $this->clave = $clave;
		    return $this;
		}
		

		public function getfechaAlta()
		{
		    return $this->fechaAlta;
		}
		public function setfechaAlta($fechaAlta)
		{
		    $this->fechaAlta = $fechaAlta;
		    return $this;
		}
		
		
		
	}
?>