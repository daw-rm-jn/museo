<?php 
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;
	use Pagerfanta\Pagerfanta;
	use Pagerfanta\Adapter\ArrayAdapter;
	use Pagerfanta\View\DefaultView;

	class controlEstilo{
		static function verEstilos(Request $req, Application $app){
			$estilos = Modelo::getEstilos();

			$adapter = new ArrayAdapter($estilos);
		    $pagerfanta = new Pagerfanta($adapter);
		    $pagerfanta->setMaxPerPage(25);
		    $page = $req->query->get('page', 1);
		    $pagerfanta->setCurrentPage($page);
		 
		    $routeGenerator = function($page) use ($app) {
		        return $app['url_generator']->generate('ver_estilos', array("page" => $page));
		    };
		 
		    $view = new DefaultView();
		    $htmlPagination = $view->render($pagerfanta, $routeGenerator, array(
		        'proximity' => 3,
		    ));

			$form = $app['form.factory']->createBuilder('form')
					->add('addRegistro', 'submit', array())
					->add('borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form->bind($req);
		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	if($form->get("borrar")->isClicked()){
						$idEstilos = $req->request->get('cb_borrar');
			        	Modelo::borrarEstilos($idEstilos);
						return $app->redirect($app['url_generator']->generate('ver_estilos'));
		        	}else if($form->get("addRegistro")->isClicked()){
			        	return $app->redirect($app['url_generator']->generate('add_estilo'));
		        	}	
		        }
		    }

			return $app ['twig']->render('/estilos/ver_estilos.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Administración de estilos',
				'pager' => $pagerfanta,
				'htmlPagination' => $htmlPagination,
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
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Estilo modificado con éxito',
				    		'seccion' => 'estilos'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Estilo',
				    		'seccion' => 'estilo'
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
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Estilo añadido con éxito',
				    		'seccion' => 'estilos'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Estilo',
				    		'seccion' => 'estilos'
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