<?php 
    class Post{

        private $idPost;
    	private $titulo;
    	private $autor;
    	private $cuerpo;
    	private $fecha;

    	function Post($idPost, $titulo, $autor, $cuerpo, $fecha){
            $this->idPost = $idPost;
    		$this->titulo = $titulo;
			$this->autor = $autor;
			$this->cuerpo = $cuerpo;
			$this->fecha = $fecha;
    	}

        public function getidPost()
        {
            return $this->idPost;
        }
        
        public function setidPost($idPost)
        {
            $this->idPost = $idPost;
            return $this;
        }
        


    	public function getTitulo()
    	{
    	    return $this->titulo;
    	}
    	
    	public function setTitulo($titulo)
    	{
    	    $this->titulo = $titulo;
    	    return $this;
    	}


    	public function getAutor()
    	{
    	    return $this->autor;
    	}
    	
    	public function setAutor($autor)
    	{
    	    $this->autor = $autor;
    	    return $this;
    	}


    	public function getCuerpo()
    	{
    	    return $this->cuerpo;
    	}
    	
    	public function setCuerpo($cuerpo)
    	{
    	    $this->cuerpo = $cuerpo;
    	    return $this;
    	}
    	
    	        
    	public function getFecha()
    	{
    	    return $this->fecha;
    	}
    	
    	public function setFecha($fecha)
    	{
    	    $this->fecha = $fecha;
    	    return $this;
    	}
    }
 ?>