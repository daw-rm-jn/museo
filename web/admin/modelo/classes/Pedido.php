<?php 
	class Pedido{
		private $email;
		private $idPedido;
		private $fecha;
		private $precioTotal;
		private $estado;

		public function Pedido($email,$idPedido,$fecha,$precioTotal,$estado){
			$this->email = $email;
			$this->idPedido = $idPedido;
			$this->fecha = $fecha;
			$this->precioTotal = $precioTotal;
			$this->estado = $estado;
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

		public function getidPedido()
		{
		    return $this->idPedido;
		}
		public function setidPedido($idPedido)
		{
		    $this->idPedido = $idPedido;
		    return $this;
		}

		public function getfecha()
		{
		    return $this->fecha;
		}
		public function setfecha($fecha)
		{
		    $this->fecha = $fecha;
		    return $this;
		}

		public function getprecioTotal()
		{
		    return $this->precioTotal;
		}
		public function setprecioTotal($precioTotal)
		{
		    $this->precioTotal = $precioTotal;
		    return $this;
		}
		
		public function getestado()
		{
		    return $this->estado;
		}
		public function setestado($estado)
		{
		    $this->estado = $estado;
		    return $this;
		}
	}
?>