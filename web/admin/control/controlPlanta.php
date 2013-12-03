<?php 
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlPlanta{
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

			return $app ['twig']->render('/plantas/ver_plantas.twig', array(
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
				    		'msgoperacion' => 'Exposicion añadido con éxito',
				    		'seccion' => 'plantas_museo'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Planta',
				    		'seccion' => 'plantas_museo'
						));
					}
		        }
		    }

		    return $app['twig']->render('/plantas/add_planta.twig', array(
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
				    		'seccion' => 'plantas_museo'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Planta',
				    		'seccion' => 'plantas_museo'
						));
					}
		        }
		    }

		    return $app['twig']->render('/plantas/ficha_planta.twig', array(
		    	'form' => $form->createView(),
		    	'planta' => $planta,
				'msgCabecera' => 'Ficha de planta',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
	}
?>