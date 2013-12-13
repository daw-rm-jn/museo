<?php 
	class Copia_Cuadro{
		private $idCopia_Cuadro;
		private $nombreProducto;
		private $autor;
		private $estilo;
		private $fechaAlta;
		private $descripcion;
		private $precio;
		private $fotoCuadro;

		public function Copia_Cuadro($idCopia_Cuadro,$nombreProducto,$autor,$estilo,$fechaAlta,$descripcion,$precio,$fotoCuadro){
			$this->idCopia_Cuadro = $idCopia_Cuadro;
			$this->nombreProducto = $nombreProducto;
			$this->autor = $autor;
			$this->estilo = $estilo;
			$this->fechaAlta = $fechaAlta;
			$this->descripcion = $descripcion;
			$this->precio = $precio;
			$this->fotoCuadro = $fotoCuadro;
		}

		public function getidCopia_Cuadro()
		{
		    return $this->idCopia_Cuadro;
		}
		
		public function setidCopia_Cuadro($idCopia_Cuadro)
		{
		    $this->idCopia_Cuadro = $idCopia_Cuadro;
		    return $this;
		}

		public function getnombreProducto()
		{
		    return $this->nombreProducto;
		}
		
		public function setnombreProducto($nombreProducto)
		{
		    $this->nombreProducto = $nombreProducto;
		    return $this;
		}

		public function getautor()
		{
		    return $this->autor;
		}
		
		public function setautor($autor)
		{
		    $this->autor = $autor;
		    return $this;
		}

		public function getestilo()
		{
		    return $this->estilo;
		}
		
		public function setestilo($estilo)
		{
		    $this->estilo = $estilo;
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

		public function getdescripcion()
		{
		    return $this->descripcion;
		}
		
		public function setdescripcion($descripcion)
		{
		    $this->descripcion = $descripcion;
		    return $this;
		}

		public function getprecio()
		{
		    return $this->precio;
		}
		
		public function setprecio($precio)
		{
		    $this->precio = $precio;
		    return $this;
		}

		public function getfotoCuadro()
		{
		    return $this->fotoCuadro;
		}
		
		public function setfotoCuadro($fotoCuadro)
		{
		    $this->fotoCuadro = $fotoCuadro;
		    return $this;
		}
	}
?>