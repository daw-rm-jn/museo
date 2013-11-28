<?php 
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlPintor{
		static function verPintores(Request $req, Application $app){
			$pintores = Modelo::getPintores();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$idPintores = $req->request->get('cb_borrar');
		        	Modelo::borrarPintores($idPintores);
					return $app['twig']->render('mod.twig', array(
						'msgCabecera' => 'Operación correcta',
						'titulo' => 'Entrada(s) eliminada(s)',
						'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
						'seccion' => 'pintores',
						'sessionId' => $_SESSION['admin']
				    	)
				    );
		        }
		    }

			return $app ['twig']->render('/pintores/ver_pintores.twig', array(
		    	'form' => $form_borrar->createView(),
				'pintores' => $pintores,
				'msgCabecera' => 'Administración de pintores',
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function verFichaPintor(Request $req, Application $app, $id){
			$pintor = Modelo::getPintorPorId($id);
			$form = $app['form.factory']->createBuilder('form')
					->add('idPintor', 'hidden', array())
			        ->add('nombrePintor', "text", array())
			        ->add('fechaNacimiento', "text",  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('fechaMuerte', "text",  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('fotoPintor', "file", array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);		       

		        if ($form->isValid()) {
		        	$data = $form->getData();
		        	$files = $req->files->get($form->getName());
		            $path = __DIR__.'/../../img/pintores/'.$data['nombrePintor'];

		            $extension = $files['fotoPintor']->guessExtension();
					if (!$extension) {
					    $extension = 'bin';
					}

					$filename = $data['nombrePintor'].'.'.$extension;
					$files['fotoPintor']->move($path, $filename);

					$descriptor = array(
						'bio' => $req->request->get('bioPintor'),
						'foto' => $filename
					);
					if(Modelo::modificaPintor($data, $descriptor)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Pintor modificado con éxito',
				    		'seccion' => 'pintores'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Pintor',
				    		'seccion' => 'pintores'
						));
					}
		        }
		    }

		    return $app['twig']->render('/pintores/ficha_pintor.twig', array(
		    	'form' => $form->createView(),
		    	'pintor' => $pintor,
				'msgCabecera' => 'Ficha de pintor',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function addPintor(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
			        ->add('nombrePintor', "text", array())
			        ->add('fechaNacimiento', "text",  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('fechaMuerte', "text",  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('fotoPintor', "file", array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	$files = $req->files->get($form->getName());
		            $path = __DIR__.'/../../img/pintores/'.$data['nombrePintor'];

		            $extension = $files['fotoPintor']->guessExtension();
					if (!$extension) {
					    $extension = 'bin';
					}

					$filename = $data['nombrePintor'].'.'.$extension;
					$files['fotoPintor']->move($path, $filename);

					$descriptor = array(
						'bio' => $req->request->get('bioPintor'),
						'foto' => $filename
					);

					if(Modelo::addPintor($data, $descriptor)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Pintor añadido con éxito',
				    		'seccion' => 'pintores'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Pintor',
				    		'seccion' => 'pintores'
						));
					}
		        }
		    }

		    return $app['twig']->render('/pintores/add_pintor.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Añadir pintor',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
	}
?>