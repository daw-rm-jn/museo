<?php 
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlCuadros{
		public function verCuadros(Application $app){
			$cuadros = Modelo::getCuadros();
			return $app ['twig']->render('/cuadros/ver_cuadros.twig', array(
				'cuadros' => $cuadros,
				'msgCabecera' => 'Administración de cuadros',
				'sessionId' => $_SESSION['admin']
				)
			);
		}
	}
?>