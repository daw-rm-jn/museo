<?php 

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlExposicion{
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
							'seccion' => 'plantas_museo',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
							'titulo' => 'Error en la operacion',
							'msgoperacion' => 'Hubo un error al eliminar las entradas del registro',
							'seccion' => 'plantas_museo',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}
		        }
		    }

			return $app ['twig']->render('/exposiciones/ver_exposiciones.twig', array(
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

		        	$descriptorAdd = array(
		        		'sala' => $req->request->get('selsalas'),
		        		'descripcion' => $req->request->get('descExpo')
		        	);

					if(Modelo::addExposicion($data, $descriptorAdd)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Exposicion añadido con éxito',
				    		'seccion' => 'exposiciones_museo'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Exposicion',
				    		'seccion' => 'exposiciones_museo'
						));
					}
		        }
		    }

		    return $app['twig']->render('/exposiciones/add_expo.twig', array(
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
				    		'seccion' => 'exposiciones_museo'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Exposicion',
				    		'seccion' => 'exposiciones_museo'
						));
					}
		        }
		    }

		    return $app['twig']->render('/exposiciones/ficha_expo.twig', array(
		    	'form' => $form->createView(),
		    	'exposicion' => $exposicion,
		    	'salas' => $salas,
				'msgCabecera' => 'Ficha de exposicion',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
	}
?>