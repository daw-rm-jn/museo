<?php
	namespace controlador;

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;

	class controladorPrincipal{

		public function main(Application $app){
			return $app['twig']->render('inicio.twig', array());
		}

	}
?>
