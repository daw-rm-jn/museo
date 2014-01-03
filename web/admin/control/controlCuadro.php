<?php 
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Validator\Constraints as Assert;
	use Pagerfanta\Pagerfanta;
	use Pagerfanta\Adapter\ArrayAdapter;
	use Pagerfanta\View\DefaultView;

	class controlCuadro{
		static function verCuadros(Request $req, Application $app){
			$cuadros = Modelo::getCuadros();

			$adapter = new ArrayAdapter($cuadros);
		    $pagerfanta = new Pagerfanta($adapter);
		    $pagerfanta->setMaxPerPage(25);
		    $page = $req->query->get('page', 1);
		    $pagerfanta->setCurrentPage($page);
		 
		    $routeGenerator = function($page) use ($app) {
		        return $app['url_generator']->generate('ver_cuadros', array("page" => $page));
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
						$idCuadros = $req->request->get('cb_borrar');
			        	Modelo::borrarCuadros($idCuadros);
						return $app->redirect($app['url_generator']->generate('ver_cuadros'));
		        	}else if($form->get("addRegistro")->isClicked()){
			        	return $app->redirect($app['url_generator']->generate('add_cuadro'));
		        	}	
		        }
		    }

			return $app ['twig']->render('/cuadros/ver_cuadros.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Administración de cuadros',
				'pager' => $pagerfanta,
				'htmlPagination' => $htmlPagination,
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function addCuadro(Request $req, Application $app){
			$pintores = Modelo::getPintores();
			$estilos = Modelo::getEstilos();
			$expos = Modelo::getExposiciones();
			$form = $app['form.factory']->createBuilder('form')
					->add('nombreCuadro', 'text', array())
					->add('orientacion', 'choice', array(
					    'choices'   => array(
					        ''   => '',
					        'horizontal'   => 'horizontal',
					        'vertical' => 'vertical',
					    ),
					))
					->add('anioCuadro', 'text', array())
					->add('fotoCuadro', 'file', array())
					->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {

		        	$data = $form->getData();

		        	$files = $req->files->get($form->getName());
		            $path = __DIR__.'/../../img/cuadros/'.$data['nombreCuadro'];

		            $extension = $files['fotoCuadro']->guessExtension();
					if (!$extension) {
					    $extension = 'bin';
					}

					$filename = $data['nombreCuadro'].'.'.$extension;
					$files['fotoCuadro']->move($path, $filename);

		        	$descriptorAddCuadro = array(
		        		'pintor' => $req->request->get('selpintores'),
		        		'estilo' => $req->request->get('selestilos'),
		        		'expo' => $req->request->get('selexpos'),
		        		'descripcion' => $req->request->get('descCuadro'),
		        		'foto' => $filename
		        	);

					if(Modelo::addCuadro($data, $descriptorAddCuadro)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Cuadro añadido con éxito',
				    		'seccion' => 'cuadros'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Cuadro',
				    		'seccion' => 'cuadros'
						));
					}
		        }
		    }

		    return $app['twig']->render('/cuadros/add_cuadro.twig', array(
		    	'form' => $form->createView(),
		    	'pintores' => $pintores,
		    	'estilos'=> $estilos,
		    	'exposiciones' => $expos,
				'msgCabecera' => 'Añadir cuadro',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
		static function verFichaCuadro(Request $req, Application $app, $id){
			$cuadro = Modelo::getDatosCuadro($id);
			$pintores = Modelo::getPintores();
			$estilos = Modelo::getEstilos();
			$expos = Modelo::getExposiciones();
			$form = $app['form.factory']->createBuilder('form')
					->add('idCuadro', 'hidden', array())
					->add('nombreCuadro', 'text', array())
					->add('orientacion', 'choice', array(
					    'choices'   => array(
					        ''   => '',
					        'horizontal'   => 'horizontal',
					        'vertical' => 'vertical',
					    ),
					))
					->add('anioCuadro', 'text', array())
					->add('fotoCuadro', 'file', array())
					->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
		        	$files = $req->files->get($form->getName());
		            $path = __DIR__.'/../../img/cuadros/'.$data['nombreCuadro'];

		            $extension = $files['fotoCuadro']->guessExtension();
					if (!$extension) {
					    $extension = 'bin';
					}

					$filename = $data['nombreCuadro'].'.'.$extension;
					$files['fotoCuadro']->move($path, $filename);

					$descriptorModCuadro = array(
						'id' => $data['idCuadro'],
		        		'pintor' => $req->request->get('selpintores'),
		        		'estilo' => $req->request->get('selestilos'),
		        		'expo' => $req->request->get('selexpos'),
		        		'descripcion' => $req->request->get('descCuadro'),
		        		'foto' => $filename
		        	);
					if(Modelo::modificaCuadro($data, $descriptorModCuadro)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Cuadro modificado con éxito',
				    		'seccion' => 'cuadros'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Cuadro',
				    		'seccion' => 'cuadros'
						));
					}
		        }
		    }

		    return $app['twig']->render('/cuadros/ficha_cuadro.twig', array(
		    	'form' => $form->createView(),
		    	'cuadro' => $cuadro,
		    	'pintores' => $pintores,
		    	'estilos'=> $estilos,
		    	'exposiciones' => $expos,
				'msgCabecera' => 'Ficha de cuadro',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
	}
?>