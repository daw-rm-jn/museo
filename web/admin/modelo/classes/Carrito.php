<?php 	
	class Carrito{
		private $idCarrito;
		private $email;
		private $fechaCreacion;
		private $fechaExpir;

		public function Carrito($idCarrito,$email,$fechaCreacion,$fechaExpir){
			$this->idCarrito = $idCarrito;
			$this->email = $email;
			$this->fechaCreacion = $fechaCreacion;
			$this->fechaExpir = $fechaExpir;
		}

		public function getidCarrito()
		{
		    return $this->idCarrito;
		}
		public function setidCarrito($idCarrito)
		{
		    $this->idCarrito = $idCarrito;
		    return $this;
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

		public function getfechaCreacion()
		{
		    return $this->fechaCreacion;
		}
		public function setfechaCreacion($fechaCreacion)
		{
		    $this->fechaCreacion = $fechaCreacion;
		    return $this;
		}
		
		public function getfechaExpir()
		{
		    return $this->fechaExpir;
		}
		public function setfechaExpir($fechaExpir)
		{
		    $this->fechaExpir = $fechaExpir;
		    return $this;
		}		
	}
?>