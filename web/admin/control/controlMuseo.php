<?php 

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlMuseo{
		static function verExposiciones(Request $req, Application $app){
			$exposiciones = Modelo::getExposiciones();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$idExposiciones = $req->request->get('cb_borrar');
		        	if(Modelo::borrarExposiciones($idExposiciones)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
							'titulo' => 'Entrada(s) eliminada(s)',
							'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
							'seccion' => 'museo/exposiciones_museo',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
							'titulo' => 'Error en la operacion',
							'msgoperacion' => 'Hubo un error al eliminar las entradas del registro',
							'seccion' => 'museo/exposiciones_museo',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}
		        }
		    }

			return $app ['twig']->render('/museo/ver_exposiciones.twig', array(
		    	'form' => $form_borrar->createView(),
				'exposiciones' => $exposiciones,
				'msgCabecera' => 'Administración de exposiciones',
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function addExposicion(Request $req, Application $app){
			$salas = Modelo::getSalas();
			$form = $app['form.factory']->createBuilder('form')
			        ->add('nombreExposicion', 'text', array())
			        ->add('fechaInicio','text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('fechaFin', 'text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {

		        	$data = $form->getData();

		        	$descriptorAddExpo = array(
		        		'sala' => $req->request->get('selsalas'),
		        		'descripcion' => $req->request->get('descExpo')
		        	);

					if(Modelo::addExposicion($data, $descriptorAddExpo)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Exposicion añadido con éxito',
				    		'seccion' => 'museo/exposiciones_museo'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Exposicion',
				    		'seccion' => 'museo/exposiciones_museo'
						));
					}
		        }
		    }

		    return $app['twig']->render('/museo/add_expo.twig', array(
		    	'form' => $form->createView(),
		    	'salas'=> $salas,
				'msgCabecera' => 'Añadir exposicion',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verFichaExposicion(Request $req, Application $app, $id){
			$exposicion = Modelo::getExposicionPorId($id);
			$salas = Modelo::getSalas();
			$form = $app['form.factory']->createBuilder('form')
					->add('idExposicion', 'hidden', array())
			        ->add('nombreExposicion', 'text', array())
			        ->add('fechaInicio','text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('fechaFin', 'text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

					$descriptorMod = array(
						'id' => $data['idExposicion'],
		        		'sala' => $req->request->get('selsalas'),
		        		'descripcion' => $req->request->get('descExpo'),
		        	);
					if(Modelo::modificaExpo($data, $descriptorMod)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Exposicion modificado con éxito',
				    		'seccion' => 'museo/exposiciones_museo'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Exposicion',
				    		'seccion' => 'museo/exposiciones_museo'
						));
					}
		        }
		    }

		    return $app['twig']->render('/museo/ficha_expo.twig', array(
		    	'form' => $form->createView(),
		    	'exposicion' => $exposicion,
		    	'salas' => $salas,
				'msgCabecera' => 'Ficha de exposicion',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verPlantas(Request $req, Application $app){
			$plantas = Modelo::getPlantas();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$idPlantas = $req->request->get('cb_borrar');
		        	if(Modelo::borrarPlantas($idPlantas)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
							'titulo' => 'Entrada(s) eliminada(s)',
							'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
							'seccion' => 'museo/plantas_museo',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
							'titulo' => 'Error en la operacion',
							'msgoperacion' => 'Hubo un error al eliminar las entradas del registro',
							'seccion' => 'museo/plantas_museo',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}
					
		        }
		    }

			return $app ['twig']->render('/museo/ver_plantas.twig', array(
		    	'form' => $form_borrar->createView(),
				'plantas' => $plantas,
				'msgCabecera' => 'Administración de plantas',
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function addPlanta(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
					->add('numeroPlanta','text',array())
					->add('capacidad','text',array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {

		        	$data = $form->getData();

					if(Modelo::addPlanta($data)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Planta añadida con éxito',
				    		'seccion' => 'museo/plantas_museo'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Planta',
				    		'seccion' => 'museo/plantas_museo'
						));
					}
		        }
		    }

		    return $app['twig']->render('/museo/add_planta.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Añadir planta',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verFichaPlanta(Request $req, Application $app, $id){
			$planta = Modelo::getPlantaPorId($id);
			$form = $app['form.factory']->createBuilder('form')
					->add('idPlanta', 'hidden', array())
					->add('numeroPlanta','text',array())
					->add('capacidad','text',array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::modificaPlanta($data)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Planta modificado con éxito',
				    		'seccion' => 'museo/plantas_museo'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Planta',
				    		'seccion' => 'museo/plantas_museo'
						));
					}
		        }
		    }

		    return $app['twig']->render('/museo/ficha_planta.twig', array(
		    	'form' => $form->createView(),
		    	'planta' => $planta,
				'msgCabecera' => 'Ficha de planta',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verSalas(Request $req, Application $app){
			$salas = Modelo::getSalas();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$idSalas = $req->request->get('cb_borrar');
		        	if(Modelo::borrarSalas($idSalas)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
							'titulo' => 'Entrada(s) eliminada(s)',
							'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
							'seccion' => 'museo/salas_museo',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
							'titulo' => 'Error en la operacion',
							'msgoperacion' => 'Hubo un error al eliminar las entradas del registro',
							'seccion' => 'museo/salas_museo',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}
					
		        }
		    }

			return $app ['twig']->render('/museo/ver_salas.twig', array(
		    	'form' => $form_borrar->createView(),
				'salas' => $salas,
				'msgCabecera' => 'Administración de salas',
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function addSala(Request $req, Application $app){
			$plantas = Modelo::getPlantas();
			$form = $app['form.factory']->createBuilder('form')
					->add('nombreSala','text',array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {

		        	$data = $form->getData();

		        	$descriptorAddSala = array(
		        		'planta' => $req->request->get('selplantas'),
		        		'descripcion' => $req->request->get('descSala')
		        	);

					if(Modelo::addSala($data, $descriptorAddSala)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Sala añadido con éxito',
				    		'seccion' => 'museo/salas_museo'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Sala',
				    		'seccion' => 'museo/salas_museo'
						));
					}
		        }
		    }

		    return $app['twig']->render('/museo/add_sala.twig', array(
		    	'form' => $form->createView(),
		    	'plantas' => $plantas,
				'msgCabecera' => 'Añadir planta',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verFichaSala(Request $req, Application $app, $id){
			$plantas = Modelo::getPlantas();
			$sala = Modelo::getSalaPorId($id);
			$form = $app['form.factory']->createBuilder('form')
					->add('idSala', 'hidden', array())
					->add('nombreSala','text',array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	$descriptorModSala = array(
		        		'planta' => $req->request->get('selplantas'),
		        		'descripcion' => $req->request->get('descSala')
		        	);
					if(Modelo::modificaSala($data, $descriptorModSala)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Sala modificado con éxito',
				    		'seccion' => 'museo/salas_museo'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Sala',
				    		'seccion' => 'museo/salas_museo'
						));
					}
		        }
		    }

		    return $app['twig']->render('/museo/ficha_sala.twig', array(
		    	'form' => $form->createView(),
		    	'sala' => $sala,
		    	'plantas' => $plantas,
				'msgCabecera' => 'Ficha de sala',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}


	}
?>