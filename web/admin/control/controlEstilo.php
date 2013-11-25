<?php 
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlEstilo{
		static function verEstilos(Request $req, Application $app){
			$estilos = Modelo::getEstilos();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$idEstilos = $req->request->get('cb_borrar');
		        	Modelo::borrarEstilos($idEstilos);
					return $app['twig']->render('/estilos/del_estilo.twig', array(
						'msgCabecera' => 'Entrada(s) borrada(s)',
						'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
						'sessionId' => $_SESSION['admin']
				    	)
				    );
		        }
		    }

			return $app ['twig']->render('/estilos/ver_estilos.twig', array(
		    	'form' => $form_borrar->createView(),
				'estilos' => $estilos,
				'msgCabecera' => 'Administración de estilos',
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function verFichaEstilo(Request $req, Application $app, $id){
			$estilo = Modelo::getEstiloPorId($id);
			$form = $app['form.factory']->createBuilder('form')
					->add('idEstilo', 'hidden', array())
			        ->add('nombreEstilo', 'text', array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);
		        $desc = $req->request->get('descEstilo');

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::modificaEstilo($data, $desc)){
						return $app['twig']->render('/estilos/mod_estilo.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada Modificada',
				    		'msgoperacion' => 'Estilo modificado con éxito'
						));
					}else{
						return $app['twig']->render('/estilos/mod_estilo.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el estilo.'
						));
					}
		        }
		    }

		    return $app['twig']->render('/estilos/ficha_estilo.twig', array(
		    	'form' => $form->createView(),
		    	'estilo' => $estilo,
				'msgCabecera' => 'Ficha de estilo',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function addEstilo(Request $req, Application $app){
			$form_add_estilo = $app['form.factory']->createBuilder('form')
			        ->add('nombreEstilo', 'text', array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form_add_estilo->bind($req);
		        $desc = $req->request->get('descEstilo');

		        if ($form_add_estilo->isValid()) {
		        	$data = $form_add_estilo->getData();

					if(Modelo::addEstilo($data, $desc)){
						return $app['twig']->render('/estilos/estilo_added.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada Añadida',
				    		'msgoperacion' => 'Pintor añadida con éxito'
						));
					}else{
						return $app['twig']->render('/estilos/estilo_added.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al añadir el pintor.'
						));
					}
		        }
		    }

		    return $app['twig']->render('/estilos/add_estilo.twig', array(
		    	'form' => $form_add_estilo->createView(),
				'msgCabecera' => 'Añadir estilo',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
	}

?>