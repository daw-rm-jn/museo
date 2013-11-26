<?php 
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
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
					return $app['twig']->render('/pintores/del_pintor.twig', array(
						'msgCabecera' => 'Entrada(s) borrada(s)',
						'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
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
		        $bio = $req->request->get('bioPintor');

		        $files = $req->files->get($form->getName());
		            $path = __DIR__.'/../img/Pintores/'.$data['nombrePintor'];

		            $extension = $files['fotoPintor']->guessExtension();
					if (!$extension) {
					    $extension = 'bin';
					}

					$filename = $data['nombrePintor'].'.'.$extension;
					$files['fotoPintor']->move($path, $filename);

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::modificaPintor($data, $bio, $filename)){
						return $app['twig']->render('/pintores/mod_pintor.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada Modificada',
				    		'msgoperacion' => 'Pintor modificado con éxito'
						));
					}else{
						return $app['twig']->render('/pintores/mod_pintor.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada Modificada',
				    		'msgoperacion' => 'Error al modificar el pintor.'
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
		        $bio = $req->request->get('bioPintor');

		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	$files = $req->files->get($form->getName());
		            $path = __DIR__.'/../img/Pintores/'.$data['nombrePintor'];

		            $extension = $files['fotoPintor']->guessExtension();
					if (!$extension) {
					    $extension = 'bin';
					}

					$filename = $data['nombrePintor'].'.'.$extension;
					$files['fotoPintor']->move($path, $filename);

					if(Modelo::addPintor($data, $bio, $filename)){
						return $app['twig']->render('/pintores/pintor_added.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada Añadida',
				    		'msgoperacion' => 'Pintor añadida con éxito'
						));
					}else{
						return $app['twig']->render('/pintores/pintor_added.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al añadir el pintor.'
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