<?php 
	class Usuario{
		private $email;
		private $clave;
		private $nombre;
		private $nif;
		private $dir;
		private $pais;
		private $provincia;
		private $poblacion;
		private $cp;
		private $telf;
		private $fechaAlta;

		public function Usuario($email,$clave,$nombre,$nif,$dir,$pais,$provincia,$poblacion,$cp,$telf,$fechaAlta){
			$this->email = $email;
			$this->clave = $clave;
			$this->nombre = $nombre;
			$this->nif = $nif;
			$this->dir = $dir;
			$this->pais = $pais;
			$this->provincia = $provincia;
			$this->poblacion = $poblacion;
			$this->cp = $cp;
			$this->telf = $telf;
			$this->fechaAlta = $fechaAlta;
		}

		public function getEmail()
		{
		    return $this->email;
		}
		public function setEmail($email)
		{
		    $this->email = $email;
		    return $this;
		}

		public function getClave()
		{
		    return $this->clave;
		}
		public function setClave($clave)
		{
		    $this->clave = $clave;
		    return $this;
		}

		public function getNombre()
		{
		    return $this->nombre;
		}
		public function setNombre($nombre)
		{
		    $this->nombre = $nombre;
		    return $this;
		}

		public function getNif()
		{
		    return $this->nif;
		}
		public function setNif($nif)
		{
		    $this->nif = $nif;
		    return $this;
		}

		public function getDir()
		{
		    return $this->dir;
		}
		public function setDir($dir)
		{
		    $this->dir = $dir;
		    return $this;
		}

		public function getPais()
		{
		    return $this->pais;
		}
		
		public function setPais($pais)
		{
		    $this->pais = $pais;
		    return $this;
		}

		public function getProvincia()
		{
		    return $this->provincia;
		}
		
		public function setProvincia($provincia)
		{
		    $this->provincia = $provincia;
		    return $this;
		}

		public function getPoblacion()
		{
		    return $this->poblacion;
		}
		
		public function setPoblacion($poblacion)
		{
		    $this->poblacion = $poblacion;
		    return $this;
		}

		public function getCp()
		{
		    return $this->cp;
		}
		public function setCp($cp)
		{
		    $this->cp = $cp;
		    return $this;
		}
		
		public function getTelf()
		{
		    return $this->telf;
		}
		public function setTelf($telf)
		{
		    $this->telf = $telf;
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