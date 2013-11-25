<?php

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\Validator\Constraints as Assert;

	class controladorPrincipal{

		public static function main(Application $app){
			return $app['twig']->render('index.twig', array());
		}
                
                public static function cuadros(Application $app){
			return $app['twig']->render('cuadros.twig', array());
		}
                
                 public static function pintores(Application $app){
                     $pintores = Modelo::getPintores();
			return $app['twig']->render('pintores.twig', array(
                            'pintores' => $pintores));
		}


	}
?>
